<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Fabric;
use App\Models\Order;
use App\Models\Service;
use App\Models\Size;
use App\Models\StoreBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(Service $service)
    {
        $service->load('category');

        $fabrics = Fabric::orderBy('name')->get();

        return view('booking.create', compact('service', 'fabrics'));
    }

    public function store(Request $request, Service $service)
    {
        $isPickup = $request->input('fulfillment_type') === 'pickup';

        $rules = [
            'phone' => ['required', 'string', 'max:20'],

            'size_name' => ['required', 'string', 'max:100'],
            'dimensions_label' => ['required', 'string'],

            'fabric_id' => ['nullable', 'exists:fabrics,id'],

            'fulfillment_type' => [
                'required',
                Rule::in(['pickup', 'delivery']),
            ],

            'payment_type' => [
                'required',
                Rule::in(['dp', 'full']),
            ],

            'recipient_name' => [
                'required_if:fulfillment_type,delivery',
                'nullable',
                'string',
                'max:255',
            ],

            'full_address' => [
                'required_if:fulfillment_type,delivery',
                'nullable',
                'string',
            ],

            'city' => [
                'required_if:fulfillment_type,delivery',
                'nullable',
                'string',
                'max:255',
            ],

            'postal_code' => [
                'required_if:fulfillment_type,delivery',
                'nullable',
                'string',
                'max:10',
            ],
        ];

        // Jadwal hanya diperlukan untuk janji pengambilan di toko.
        if ($isPickup) {
            $rules['booking_date'] = [
                'required',
                'date',
                'after_or_equal:today',
            ];

            $rules['time_slot'] = [
                'required',
                'string',
                Rule::unique('store_bookings', 'time_slot')
                    ->where(fn ($query) =>
                        $query->where('booking_date', $request->booking_date)
                    ),
            ];
        } else {
            $rules['booking_date'] = ['nullable'];
            $rules['time_slot'] = ['nullable'];
        }

        $validator = Validator::make($request->all(), $rules, [
            'booking_date.required' => 'Tanggal pengambilan wajib dipilih.',
            'booking_date.after_or_equal' => 'Tanggal pengambilan tidak boleh sebelum hari ini.',
            'time_slot.required' => 'Jam pengambilan wajib dipilih.',
            'time_slot.unique' => 'Jadwal tersebut sudah dipesan. Silakan pilih jam lain.',
            'recipient_name.required_if' => 'Nama penerima wajib diisi.',
            'full_address.required_if' => 'Alamat lengkap wajib diisi.',
            'city.required_if' => 'Kota wajib diisi.',
            'postal_code.required_if' => 'Kode pos wajib diisi.',
        ]);

        $validated = $validator->validate();

        $order = DB::transaction(function () use (
            $request,
            $service,
            $validated,
            $isPickup
        ) {
            // DATA PELANGGAN
            $customer = Customer::firstOrNew([
                'user_id' => $request->user()->id,
            ]);

            $customer->phone = $validated['phone'];
            $customer->save();

            // DATA UKURAN
            $size = Size::create([
                'customer_id' => $customer->id,
                'size_name' => $validated['size_name'],
                'dimensions_label' => $validated['dimensions_label'],
                'measurement_unit' => 'cm',
            ]);

            // PILIHAN KAIN
            $fabric = !empty($validated['fabric_id'])
                ? Fabric::findOrFail($validated['fabric_id'])
                : null;

            // PERHITUNGAN HARGA
            $totalPrice = (float) $service->price;

            if ($fabric) {
                $totalPrice +=
                    (float) $fabric->price_per_meter *
                    (float) $service->fabric_need_meter;
            }

            // PERHITUNGAN PEMBAYARAN
            if ($validated['payment_type'] === 'dp') {
                $dpAmount = $totalPrice * 0.5;
                $remainingAmount = $totalPrice - $dpAmount;
            } else {
                $dpAmount = $totalPrice;
                $remainingAmount = 0;
            }

            // SIMPAN PESANAN
            $order = Order::create([
                'code' => 'SC-' . strtoupper(Str::random(10)),
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'size_id' => $size->id,
                'fabric_id' => $fabric?->id,
                'total_price' => $totalPrice,
                'payment_type' => $validated['payment_type'],
                'dp_amount' => $dpAmount,
                'remaining_amount' => $remainingAmount,
                'payment_status' => 'unpaid',
                'fulfillment_type' => $validated['fulfillment_type'],
                'status' => 'Pending',
            ]);

            // JANJI PENGAMBILAN DI TOKO
            // Delivery tidak membuat booking atau jadwal fitting.
            if ($isPickup) {
                StoreBooking::create([
                    'order_id' => $order->id,
                    'customer_id' => $customer->id,
                    'booking_date' => $validated['booking_date'],
                    'time_slot' => $validated['time_slot'],
                    'booking_type' => 'pickup_appointment',
                    'status' => 'pending',
                ]);
            }

            // ALAMAT PENGIRIMAN
            if ($validated['fulfillment_type'] === 'delivery') {
                DB::table('shipping_addresses')->insert([
                    'order_id' => $order->id,
                    'recipient_name' => $validated['recipient_name'],
                    'full_address' => $validated['full_address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $order;
        });

        return redirect()->route('checkout.show', $order->code)
            ->with('success', 'Pesanan berhasil dibuat. Silakan periksa detail checkout.');
    }
}
