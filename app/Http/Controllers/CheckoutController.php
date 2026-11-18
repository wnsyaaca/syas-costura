<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Halaman utama checkout.
     */
    public function index(Request $request)
    {
        $orders = Order::with([
            'customer',
            'service',
            'fabric',
            'size',
            'bookings',
            'shippingAddress',
        ])
        ->whereHas('customer', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->latest()
        ->get();

        return view('checkout.index', compact('orders'));
    }

    /**
     * Detail checkout berdasarkan kode pesanan.
     */
    public function show(Request $request, string $code)
    {
        $order = Order::with([
            'customer',
            'service',
            'fabric',
            'size',
            'bookings',
            'shippingAddress',
        ])
        ->where('code', $code)
        ->whereHas('customer', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->firstOrFail();

        return view('checkout.show', compact('order'));
    }
}
