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
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'max:20'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => [
                'required',
                'string',
                Rule::unique('store_bookings', 'time_slot')
                    ->where(fn ($query) =>
                        $query->where('booking_date', $request->booking_date)
                    ),
            ],
            'booking_type' => [
                'required',
                Rule::in(['fitting', 'pickup_appointment']),
            ],
            'size_name' => ['required', 'string', 'max:100'],
            'dimensions_label' => ['required', 'string'],
            'fabric_id' => ['nullable', 'exists:fabrics,id'],
            'fulfillment_type' => [
                'required',
                Rule::in(['pickup', 'delivery']),
            ],
            'recipient_name' => ['required_if:fulfillment_type,delivery', 'nullable', 'string', 'max:255'],
            'full_address' => ['required_if:fulfillment_type,delivery', 'nullable', 'string'],
            'city' => ['required_if:fulfillment_type,delivery', 'nullable', 'string', 'max:255'],
            'postal_code' => ['required_if:fulfillment_type,delivery', 'nullable', 'string', 'max:10'],
            'payment_type' => ['required', Rule::in(['dp', 'full'])],
        ], [
            'time_slot.unique' => 'Jadwal tersebut sudah dipesan. Silakan pilih jam lain.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh sebelum hari ini.',
        ]);

        $validated = $validator->validate();

        $order = DB::transaction(function () use ($request, $service, $validated) {

            $customer = Customer::firstOrNew([
                'user_id' => $request->user()->id,
            ]);

            $customer->phone = $validated['phone'];
            $customer->save();

            $size = Size::create([
                'customer_id' => $customer->id,
                'size_name' => $validated['size_name'],
                'dimensions_label' => $validated['dimensions_label'],
                'measurement_unit' => 'cm',
            ]);

            $fabric = !empty($validated['fabric_id'])
                ? Fabric::findOrFail($validated['fabric_id'])
                : null;

            // Harga jasa + biaya kain jika kain dipilih.
            $totalPrice = (float) $service->price;

            if ($fabric) {
                $totalPrice +=
                    (float) $fabric->price_per_meter *
                    (float) $service->fabric_need_meter;
            }

            // Perhitungan DP 50%.
            if ($validated['payment_type'] === 'dp') {
                $dpAmount = $totalPrice * 0.5;
                $remainingAmount = $totalPrice - $dpAmount;
            } else {
                $dpAmount = $totalPrice;
                $remainingAmount = 0;
            }

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

            StoreBooking::create([
                'order_id' => $order->id,
                'customer_id' => $customer->id,
                'booking_date' => $validated['booking_date'],
                'time_slot' => $validated['time_slot'],
                'booking_type' => $validated['booking_type'],
                'status' => 'pending',
            ]);

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

        return view('booking.success', compact('order'));
    }
}
