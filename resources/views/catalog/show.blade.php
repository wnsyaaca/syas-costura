@extends('layouts.costura')

@section('title', $service->name . " - Sya's Costura")

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">

    <a href="{{ route('katalog') }}"
       class="text-sm text-stone-500 hover:text-stone-800">
        ← Kembali ke Katalog
    </a>

    <div class="grid md:grid-cols-2 gap-10 mt-8 items-start">

        {{-- GAMBAR LAYANAN --}}
        <div class="rounded-3xl overflow-hidden bg-[#E6DED2] min-h-[350px] flex items-center justify-center">
            @if ($service->image_path)
                <img
                    src="{{ asset('storage/' . $service->image_path) }}"
                    alt="{{ $service->name }}"
                    class="w-full h-full object-cover"
                >
            @else
                <div class="text-center p-10">
                    <div class="text-6xl mb-4">✂</div>
                    <p class="font-serif text-2xl text-[#665246]">
                        Sya's Costura
                    </p>
                    <p class="text-sm text-[#806B57] mt-2">
                        Made with care, made for you
                    </p>
                </div>
            @endif
        </div>

        {{-- INFORMASI LAYANAN --}}
        <div>
            <p class="text-sm uppercase tracking-[0.25em] text-[#A1876C]">
                {{ $service->category->name ?? 'Our Collection' }}
            </p>

            <h1 class="font-serif text-4xl font-bold text-[#292522] mt-3">
                {{ $service->name }}
            </h1>

            <p class="text-2xl font-semibold text-[#806B57] mt-5">
                Mulai Rp {{ number_format($service->price, 0, ',', '.') }}
            </p>

            <div class="border-t border-[#E6DED2] my-6"></div>

            <h2 class="font-semibold text-[#292522]">
                Deskripsi Layanan
            </h2>

            <p class="text-stone-600 leading-7 mt-3">
                {{ $service->description ?: 'Layanan jahit custom dari Sya\'s Costura.' }}
            </p>

            {{-- KEBUTUHAN BAHAN --}}
            <div class="mt-6 rounded-2xl bg-[#F7F4EE] p-5">
                <p class="text-sm text-stone-600">
                    Estimasi kebutuhan bahan
                </p>

                <p class="font-semibold text-[#665246] mt-1">
                    {{ $service->fabric_need_meter ?? 0 }} meter
                </p>
            </div>

            {{-- PILIHAN PEMESANAN --}}
            <div class="mt-8">
                <p class="text-sm text-stone-500">
                    Tertarik dengan layanan ini?
                </p>

                <p class="font-medium text-[#292522] mt-1">
                    Pilih cara pemesanan yang kamu inginkan.
                </p>

                <div class="mt-5 space-y-3">

                    {{-- PESAN ONLINE / CHECKOUT --}}
                    <a href="{{ route('checkout.create', $service->id) }}"
                       class="block text-center bg-[#665246] hover:bg-[#292522] text-white px-8 py-3 rounded-full transition">
                        Pesan Sekarang
                    </a>

                    {{-- KONSULTASI WHATSAPP --}}
                    <a href="https://wa.me/6281266649126"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block text-center border border-[#806B57] text-[#665246] hover:bg-[#F7F4EE] px-8 py-3 rounded-full transition">
                        Konsultasi via WhatsApp
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
