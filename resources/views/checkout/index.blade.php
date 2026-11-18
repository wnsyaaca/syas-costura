@extends('layouts.costura')

@section('title', 'Checkout - Sya\'s Costura')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-12">

    {{-- HEADER --}}
    <div class="mb-10">
        <p class="text-sm tracking-[0.2em] uppercase text-[#A1876C]">
            Sya's Costura
        </p>

        <h1 class="font-serif text-3xl md:text-4xl text-[#292522] mt-2">
            Checkout
        </h1>

        <p class="text-stone-500 mt-2">
            Lihat dan periksa pesanan online kamu.
        </p>
    </div>

    {{-- JIKA BELUM ADA PESANAN --}}
    @if($orders->isEmpty())

        <div class="bg-white border border-[#E6DED2] rounded-3xl p-10 md:p-16 text-center">

            <div class="text-5xl text-[#A1876C] mb-5">
                ♡
            </div>

            <h2 class="font-serif text-2xl text-[#292522] mb-3">
                Belum Ada Pesanan
            </h2>

            <p class="text-stone-500 max-w-md mx-auto mb-7">
                Kamu belum memiliki pesanan online.
                Yuk, pilih layanan yang kamu inginkan dari katalog Sya's Costura.
            </p>

            <a href="{{ route('katalog') }}"
               class="inline-block px-8 py-3 rounded-xl bg-[#665246] text-white hover:bg-[#4E3D33] transition">
                Lihat Katalog
            </a>

        </div>

    @else

        <div class="grid lg:grid-cols-3 gap-7">

            {{-- DAFTAR PESANAN --}}
            <div class="lg:col-span-2 space-y-5">

                @foreach($orders as $order)

                    <div class="bg-white border border-[#E6DED2] rounded-2xl p-6">

                        <div class="flex flex-wrap justify-between items-center gap-3 mb-5">

                            <div>
                                <p class="text-xs text-stone-500">
                                    Kode Pesanan
                                </p>

                                <p class="font-semibold text-[#665246] mt-1">
                                    {{ $order->code }}
                                </p>
                            </div>

                            <span class="px-4 py-2 rounded-full bg-[#F7F4EE] text-[#806B57] text-xs font-medium">
                                {{ ucfirst($order->status ?? 'Pending') }}
                            </span>

                        </div>

                        <div class="border-t border-[#E6DED2] pt-5 space-y-3 text-sm">

                            <div class="flex justify-between gap-4">
                                <span class="text-stone-500">
                                    Layanan
                                </span>

                                <span class="font-medium text-right">
                                    {{ $order->service->name ?? '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-stone-500">
                                    Jenis Kain
                                </span>

                                <span class="font-medium text-right">
                                    {{ $order->fabric->name ?? 'Tidak memilih kain' }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-stone-500">
                                    Pengiriman
                                </span>

                                <span class="font-medium text-right">
                                    {{ $order->fulfillment_type
                                        ? ucfirst($order->fulfillment_type)
                                        : '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-stone-500">
                                    Total Harga
                                </span>

                                <span class="font-semibold text-[#665246]">
                                    Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                        </div>

                        <div class="border-t border-[#E6DED2] mt-5 pt-5 flex flex-wrap justify-between items-center gap-4">

                            <div>
                                <p class="text-xs text-stone-500">
                                    Pembayaran
                                </p>

                                <p class="font-semibold text-[#806B57] mt-1">
                                    Rp {{ number_format($order->dp_amount ?? 0, 0, ',', '.') }}
                                </p>
                            </div>

                            <a href="{{ route('checkout.show', $order->code) }}"
                               class="px-6 py-3 rounded-xl bg-[#665246] text-white text-sm hover:bg-[#4E3D33] transition">
                                Lihat Detail
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

            {{-- RINGKASAN --}}
            <div>
                <div class="bg-white border border-[#E6DED2] rounded-2xl p-6 sticky top-6">

                    <h2 class="font-serif text-xl text-[#292522] mb-5">
                        Ringkasan Checkout
                    </h2>

                    <div class="space-y-4 text-sm">

                        <div class="flex justify-between gap-3">
                            <span class="text-stone-500">
                                Jumlah Pesanan
                            </span>

                            <span class="font-medium">
                                {{ $orders->count() }} pesanan
                            </span>
                        </div>

                        <div class="border-t border-[#E6DED2] pt-4">

                            <p class="text-stone-500 mb-2">
                                Total Seluruh Pesanan
                            </p>

                            <p class="text-2xl font-semibold text-[#806B57]">
                                Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}
                            </p>

                        </div>

                    </div>

                    <div class="mt-6 p-4 bg-[#F7F4EE] rounded-xl">

                        <p class="text-xs text-stone-500">
                            Informasi
                        </p>

                        <p class="text-sm text-[#665246] mt-1">
                            Pilih tombol Lihat Detail pada pesanan untuk memeriksa rincian dan informasi pembayarannya.
                        </p>

                    </div>

                    <a href="{{ route('katalog') }}"
                       class="block text-center w-full mt-6 py-3 rounded-xl border border-[#E6DED2] text-[#665246] hover:bg-[#F7F4EE] transition">
                        Tambah Pesanan
                    </a>

                </div>
            </div>

        </div>

    @endif

</div>

@endsection
