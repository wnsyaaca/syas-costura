
@extends('layouts.costura')

@section('title', 'Tracking Pesanan - Sya\'s Costura')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-12">

    {{-- HEADER --}}
    <div class="mb-10">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#A1876C]">
            Sya's Costura
        </p>

        <h1 class="mt-3 font-serif text-3xl md:text-4xl font-bold text-[#292522]">
            Tracking Pesanan
        </h1>

        <p class="mt-3 text-sm text-[#746B62]">
            Pantau perkembangan pesanan jahitanmu dengan mudah.
        </p>
    </div>

    {{-- DAFTAR PESANAN --}}
    @forelse ($orders as $order)

        <div class="mb-5 rounded-2xl border border-[#E6DED2] bg-white p-6 shadow-sm">

            <div class="flex flex-wrap items-start justify-between gap-4">

                <div>
                    <p class="text-xs uppercase tracking-wider text-[#A1876C]">
                        Kode Pesanan
                    </p>

                    <h2 class="mt-1 text-lg font-bold text-[#292522]">
                        {{ $order->code }}
                    </h2>
                </div>

                <span class="rounded-full bg-[#F5F1EA] px-4 py-2 text-sm font-medium text-[#806B57]">
                    {{ $order->status }}
                </span>

            </div>

            <div class="my-5 border-t border-[#E6DED2]"></div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div>
                    <p class="text-sm text-stone-500">
                        Layanan
                    </p>

                    <p class="mt-1 font-semibold text-[#292522]">
                        {{ $order->service->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-stone-500">
                        Total Harga
                    </p>

                    <p class="mt-1 font-semibold text-[#665246]">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-stone-500">
                        Tanggal Booking
                    </p>

                    <p class="mt-1 font-medium text-[#292522]">
                        @if($order->bookings->isNotEmpty())
                            {{ \Carbon\Carbon::parse($order->bookings->first()->booking_date)->format('d F Y') }}
                        @else
                            Belum tersedia
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-stone-500">
                        Status Pembayaran
                    </p>

                    <p class="mt-1 font-medium text-[#292522]">
                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                    </p>
                </div>

            </div>

            <div class="mt-6 flex flex-wrap gap-3">

                <a href="{{ route('tracking.show', $order->code) }}"
                   class="rounded-full bg-[#665246] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#4E3D33]">
                    Detail Tracking →
                </a>

                <a href="{{ route('checkout.show', $order->code) }}"
                   class="rounded-full border border-[#C9B99F] px-6 py-3 text-sm font-semibold text-[#665246] transition hover:bg-[#F5F1EA]">
                    Lihat Checkout
                </a>

            </div>

        </div>

    @empty

        <div class="rounded-2xl border border-[#E6DED2] bg-[#F7F4EE] px-6 py-16 text-center">

            <div class="mb-4 text-5xl">✂</div>

            <h2 class="font-serif text-2xl font-bold text-[#292522]">
                Belum Ada Pesanan
            </h2>

            <p class="mt-3 text-sm text-[#746B62]">
                Kamu belum memiliki pesanan. Yuk, temukan layanan jahit favoritmu!
            </p>

            <a href="{{ route('katalog') }}"
               class="mt-7 inline-block rounded-full bg-[#665246] px-7 py-3 text-sm font-semibold text-white transition hover:bg-[#4E3D33]">
                Lihat Katalog
            </a>

        </div>

    @endforelse

</div>

@endsection
