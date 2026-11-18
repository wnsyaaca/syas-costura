@extends('layouts.costura')

@section('title', 'Pesanan Berhasil - Sya\'s Costura')

@section('content')

<div class="min-h-[75vh] flex items-center justify-center px-4 py-16">

    <div class="max-w-2xl w-full bg-white border border-[#E6DED2] rounded-3xl shadow-sm p-8 md:p-12 text-center">

        {{-- ICON BERHASIL --}}
        <div class="w-20 h-20 rounded-full bg-[#F7F4EE] flex items-center justify-center mx-auto mb-6">
            <span class="text-4xl text-[#806B57]">✓</span>
        </div>

        {{-- JUDUL --}}
        <p class="text-sm tracking-[0.2em] uppercase text-[#A1876C]">
            Sya's Costura
        </p>

        <h1 class="font-serif text-3xl md:text-4xl text-[#292522] mt-3">
            Pesanan Berhasil!
        </h1>

        <p class="text-stone-500 mt-4 leading-relaxed">
            Terima kasih telah mempercayakan kebutuhan busana kamu kepada Sya's Costura.
            Pesanan kamu berhasil dicatat.
        </p>

        {{-- KODE PESANAN --}}
        <div class="bg-[#F7F4EE] rounded-2xl p-5 mt-8">

            <p class="text-xs uppercase tracking-wider text-stone-500">
                Kode Pesanan
            </p>

            <p class="text-xl font-semibold tracking-wider text-[#665246] mt-2">
                {{ $order->code }}
            </p>

            <p class="text-xs text-stone-500 mt-2">
                Simpan kode ini untuk memudahkan pengecekan pesanan.
            </p>

        </div>

        {{-- RINGKASAN --}}
        <div class="text-left border border-[#E6DED2] rounded-2xl p-5 mt-6 space-y-4">

            <h2 class="font-serif text-lg text-[#292522]">
                Ringkasan Pesanan
            </h2>

            <div class="flex justify-between gap-4 text-sm">
                <span class="text-stone-500">Status</span>
                <span class="font-medium text-[#806B57]">
                    {{ $order->status }}
                </span>
            </div>

            <div class="flex justify-between gap-4 text-sm">
                <span class="text-stone-500">Total Harga</span>
                <span class="font-medium">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex justify-between gap-4 text-sm">
                <span class="text-stone-500">Metode Pembayaran</span>
                <span class="font-medium">
                    {{ strtoupper($order->payment_type) }}
                </span>
            </div>

            <div class="border-t border-[#E6DED2] pt-4 flex justify-between gap-4">
                <span class="text-sm font-medium text-[#665246]">
                    Jumlah Pembayaran
                </span>

                <span class="font-semibold text-[#806B57]">
                    Rp {{ number_format($order->dp_amount, 0, ',', '.') }}
                </span>
            </div>

        </div>

        {{-- TOMBOL --}}
        <div class="mt-8 space-y-3">

            <a href="{{ route('checkout.show', $order->code) }}"
               class="block w-full py-3.5 rounded-xl bg-[#665246] text-white font-medium hover:bg-[#4E3D33] transition">
                Lihat Checkout Pesanan
            </a>

            <a href="{{ route('tracking.show', $order->code) }}"
               class="block w-full py-3.5 rounded-xl border border-[#E6DED2] text-[#665246] font-medium hover:bg-[#F7F4EE] transition">
                Tracking Pesanan
            </a>

            <a href="{{ route('katalog') }}"
               class="block text-sm text-stone-500 hover:text-[#665246] transition pt-2">
                Kembali ke Katalog
            </a>

        </div>

    </div>

</div>

@endsection
