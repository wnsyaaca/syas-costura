<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CartCheckoutController extends Controller
{
    /**
     * Halaman checkout dari keranjang.
     */
    public function create(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        $serviceIds = collect($cart)
            ->pluck('service_id')
            ->filter()
            ->unique();

        $services = Service::whereIn('id', $serviceIds)
            ->get()
            ->keyBy('id');

        if ($services->count() !== $serviceIds->count()) {
            return redirect()->route('cart.index')
                ->with('error', 'Ada produk yang sudah tidak tersedia. Periksa keranjang kamu.');
        }

        $cartItems = [];
        $total = 0;
        $totalItems = 0;

        foreach ($cart as $key => $item) {
            $service = $services->get($item['service_id']);
            $quantity = (int) $item['quantity'];
            $unitPrice = (float) $service->price;
            $lineTotal = $unitPrice * $quantity;

            $cartItems[] = [
                'key' => $key,
                'service' => $service,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
                'color' => $item['color'] ?? null,
                'size_type' => $item['size_type'] ?? 'standard',
                'size_label' => $item['size_label'] ?? null,
                'custom_measurements' => $item['custom_measurements'] ?? null,
                'image' => $item['image'] ?? $service->image_path,
            ];

            $total += $lineTotal;
            $totalItems += $quantity;
        }

        return view('cart.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'totalItems' => $totalItems,
            'user' => $request->user(),
        ]);
    }

    /**
     * Simpan pesanan dari keranjang.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'full_address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'payment_type' => [
                'required',
                Rule::in(['dp', 'full']),
            ],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        $serviceIds = collect($cart)
            ->pluck('service_id')
            ->filter()
            ->unique();

        $services = Service::whereIn('id', $serviceIds)
            ->get()
            ->keyBy('id');

        if ($services->count() !== $serviceIds->count()) {
            return redirect()->route('cart.index')
                ->with('error', 'Ada produk yang sudah tidak tersedia.');
        }

        foreach ($cart as $item) {
            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1 || $quantity > 20) {
                return redirect()->route('cart.index')
                    ->with('error', 'Jumlah produk dalam keranjang tidak valid.');
            }
        }

        $totalPrice = 0;

        foreach ($cart as $item) {
            $service = $services->get($item['service_id']);
            $totalPrice += (float) $service->price * (int) $item['quantity'];
        }

        if ($totalPrice <= 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Total pesanan tidak valid.');
        }

        $order = DB::transaction(function () use (
            $request,
            $validated,
            $cart,
            $services,
            $totalPrice
        ) {
            // Data pelanggan.
            $customer = Customer::where(
                'user_id',
                $request->user()->id
            )->first();

            if (!$customer) {
                $customer = new Customer();
                $customer->user_id = $request->user()->id;
            }

            $customer->phone = $validated['phone'];
            $customer->address = $validated['full_address'];
            $customer->save();

            // service_id dan size_id wajib di tabel orders.
            // Detail ukuran sebenarnya tetap disimpan per produk.
            $firstService = $services->get(
                $cart[array_key_first($cart)]['service_id']
            );

            $size = new Size();
            $size->customer_id = $customer->id;
            $size->size_name = 'Beragam';
            $size->dimensions_label =
                'Detail ukuran masing-masing produk tersimpan pada item pesanan.';
            $size->measurement_unit = 'cm';
            $size->save();

            // Perhitungan pembayaran.
            $dpAmount = $validated['payment_type'] === 'dp'
                ? $totalPrice * 0.5
                : $totalPrice;

            $remainingAmount = $totalPrice - $dpAmount;

            // Buat pesanan utama.
            $order = Order::create([
                'code' => 'SC-' . strtoupper(Str::random(10)),
                'customer_id' => $customer->id,
                'service_id' => $firstService->id,
                'size_id' => $size->id,
                'fabric_id' => null,
                'total_price' => $totalPrice,
                'payment_type' => $validated['payment_type'],
                'dp_amount' => $dpAmount,
                'remaining_amount' => $remainingAmount,
                'payment_status' => 'unpaid',
                'fulfillment_type' => 'delivery',
                'status' => 'Pending',
            ]);

            // Simpan setiap produk ke order_items.
            foreach ($cart as $item) {
                $service = $services->get($item['service_id']);

                $unitPrice = (float) $service->price;
                $quantity = (int) $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $service->id,
                    'product_name' => $service->name,
                    'product_image' => $item['image']
                        ?? $service->image_path,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'color' => $item['color'] ?? null,
                    'size_type' => $item['size_type'] ?? 'standard',
                    'size_label' => $item['size_label'] ?? null,
                    'custom_measurements' =>
                        $item['custom_measurements'] ?? null,
                    'line_total' => $unitPrice * $quantity,
                ]);
            }

            // Simpan alamat pengiriman.
            DB::table('shipping_addresses')->insert([
                'order_id' => $order->id,
                'recipient_name' => $validated['recipient_name'],
                'full_address' => $validated['full_address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $order;
        });

        // Kosongkan keranjang setelah pesanan berhasil disimpan.
        session()->forget('cart');

        return redirect()
            ->route('checkout.show', $order->code)
            ->with('success', 'Pesanan berhasil dibuat. Silakan periksa detail pesanan.');
    }
}
