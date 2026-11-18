<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with([
            'service',
            'bookings',
        ])
        ->whereHas('customer', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->latest()
        ->get();

        return view('tracking.index', compact('orders'));
    }

    public function show(Request $request, string $code)
    {
        $order = Order::with([
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

        return view('tracking.show', compact('order'));
    }
}