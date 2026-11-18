@extends('layouts.costura')

@section('title', 'Checkout - Sya\'s Costura')

@section('content')
@php
    $booking = $order->bookings->first();
    $shipping = $order->shippingAddress;
@endphp

<div class="max-w-5xl mx-auto px-4 py-12">

    {{-- HEADER --}}
    <div class="mb-8">
        <p class="text-sm tracking-[0.2em] uppercase text-[#A1876C]">
            Sya's Costura
        </p>

        <h1 class="font-serif text-3xl md:text-4xl text-[#292522] mt-2">
            Checkout Pesanan
        </h1>

        <p class="text-stone-500 mt-2">
            Periksa kembali detail pesanan sebelum melanjutkan.
        </p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- DETAIL PESANAN --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white border border-[#E6DED2] rounded-2xl p-6">
                <h2 class="font-serif text-xl text-[#292522] mb-5">
                    Detail Pesanan
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Kode Pesanan</span>
                        <span class="font-semibold text-[#665246]">
                            {{ $order->code }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Layanan</span>
                        <span class="font-medium text-right">
                            {{ $order->service->name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Jenis Kain</span>
                        <span class="font-medium text-right">
                            {{ $order->fabric->name ?? 'Tidak memilih kain' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Ukuran</span>
                        <span class="font-medium text-right">
                            {{ $order->size->size_name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Tanggal Booking</span>
                        <span class="font-medium text-right">
                            {{ $booking?->booking_date
                                ? \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y')
                                : '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Jam Booking</span>
                        <span class="font-medium text-right">
                            {{ $booking?->time_slot ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Jenis Booking</span>
                        <span class="font-medium text-right">
                            {{ $booking
                                ? ($booking->booking_type === 'fitting'
                                    ? 'Fitting'
                                    : 'Janji Pengambilan')
                                : '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-stone-500">Pengiriman</span>
                        <span class="font-medium text-right">
                            {{ $order->fulfillment_type
                                ? ucfirst($order->fulfillment_type)
                                : '-' }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- ALAMAT PENGIRIMAN --}}
            @if($order->fulfillment_type === 'delivery' && $shipping)
                <div class="bg-white border border-[#E6DED2] rounded-2xl p-6">

                    <h2 class="font-serif text-xl text-[#292522] mb-4">
                        Alamat Pengiriman
                    </h2>

                    <p class="font-semibold">
                        {{ $shipping->recipient_name }}
                    </p>

                    <p class="text-sm text-stone-600 mt-2">
                        {{ $shipping->full_address }}
                    </p>

                    <p class="text-sm text-stone-600">
                        {{ $shipping->city }} - {{ $shipping->postal_code }}
                    </p>

                </div>
            @endif

            {{-- STATUS PESANAN --}}
            <div class="bg-[#F7F4EE] border border-[#E6DED2] rounded-2xl p-6">

                <h2 class="font-serif text-xl text-[#292522] mb-3">
                    Status Pesanan
                </h2>

                <span class="inline-block px-4 py-2 rounded-full bg-white text-[#806B57] text-sm font-medium">
                    {{ $order->status ?? 'Belum tersedia' }}
                </span>

                <p class="text-sm text-stone-500 mt-3">
                    Status pembayaran:
                    <strong>
                        {{ $order->payment_status
                            ? ucfirst(str_replace('_', ' ', $order->payment_status))
                            : 'Belum tersedia' }}
                    </strong>
                </p>

            </div>

        </div>

        {{-- RINGKASAN PEMBAYARAN --}}
        <div>
            <div class="bg-white border border-[#E6DED2] rounded-2xl p-6 sticky top-6">

                <h2 class="font-serif text-xl text-[#292522] mb-5">
                    Ringkasan Pembayaran
                </h2>

                <div class="space-y-4 text-sm">

                    <div class="flex justify-between gap-3">
                        <span class="text-stone-500">Total Harga</span>
                        <span class="font-medium">
                            Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-stone-500">Metode Pembayaran</span>
                        <span class="font-medium">
                            {{ $order->payment_type
                                ? strtoupper($order->payment_type)
                                : '-' }}
                        </span>
                    </div>

                    <div class="border-t border-[#E6DED2] pt-4">
                        <div class="flex justify-between gap-3">
                            <span class="text-stone-600 font-medium">
                                Jumlah yang harus dibayar
                            </span>

                            <span class="font-semibold text-[#806B57]">
                                Rp {{ number_format($order->dp_amount ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-stone-500">Sisa Pembayaran</span>
                        <span class="font-medium">
                            Rp {{ number_format($order->remaining_amount ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                {{-- INFORMASI --}}
                <div class="mt-6 p-4 bg-[#F7F4EE] rounded-xl">
                    <p class="text-xs text-stone-500">
                        Informasi
                    </p>

                    <p class="text-sm text-[#665246] mt-1">
                        Pesanan kamu sudah tercatat. Silakan hubungi admin untuk informasi pembayaran lebih lanjut.
                    </p>
                </div>

                {{-- TOMBOL --}}
                <a href="{{ route('tracking.show', $order->code) }}"
                   class="block text-center w-full mt-6 py-3 rounded-xl bg-[#665246] text-white hover:bg-[#4E3D33] transition">
                    Lihat Tracking Pesanan
                </a>

                <a href="{{ route('katalog') }}"
                   class="block text-center w-full mt-3 py-3 rounded-xl border border-[#E6DED2] text-[#665246] hover:bg-[#F7F4EE] transition">
                    Kembali ke Katalog
                </a>

            </div>
        </div>

    </div>
</div>
@endsection
