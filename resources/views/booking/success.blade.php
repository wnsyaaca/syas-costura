@extends('layouts.costura')

@section('title', 'Booking Berhasil - Sya\'s Costura')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-20 text-center">

    <div class="bg-white border border-[#E6DED2] rounded-3xl p-8 md:p-12 shadow-sm">

        <div class="text-5xl text-[#806B57] mb-5">✓</div>

        <h1 class="font-serif text-3xl text-[#292522]">
            Booking Berhasil!
        </h1>

        <p class="text-stone-500 mt-3">
            Terima kasih telah memilih Sya's Costura.
            Pesananmu berhasil kami simpan.
        </p>

        <div class="bg-[#F7F4EE] rounded-2xl p-6 mt-8 text-left space-y-3">
            <div>
                <p class="text-sm text-stone-500">Kode Pesanan</p>
                <p class="font-bold text-lg text-[#665246]">
                    {{ $order->code }}
                </p>
            </div>

            <div>
                <p class="text-sm text-stone-500">Total Pesanan</p>
                <p class="font-semibold">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-stone-500">Pembayaran Awal</p>
                <p class="font-semibold">
                    Rp {{ number_format($order->dp_amount, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-stone-500">Sisa Pembayaran</p>
                <p class="font-semibold">
                    Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-stone-500">Status Pembayaran</p>
                <p class="font-semibold">Belum Dibayar</p>
            </div>
        </div>

        <a href="{{ route('katalog') }}"
           class="inline-block mt-8 bg-[#665246] hover:bg-[#292522] text-white px-8 py-3 rounded-full">
            Kembali ke Katalog
        </a>
    </div>
</div>
@endsection
