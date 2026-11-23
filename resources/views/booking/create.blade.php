@extends('layouts.costura')

@section('title', 'Pemesanan Online - Sya\'s Costura')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | GALERI FOTO PRODUK
    |--------------------------------------------------------------------------
    */

    $productImages = [];

    if (!empty($service->image_path)) {
        $productImages[] = str_starts_with($service->image_path, 'http')
            ? $service->image_path
            : asset('storage/' . $service->image_path);
    }

    foreach (($service->gallery_images ?? []) as $image) {
        if (!empty($image)) {
            $productImages[] = str_starts_with($image, 'http')
                ? $image
                : asset('storage/' . $image);
        }
    }

    $productImages = array_values(array_unique($productImages));
@endphp

<div class="min-h-screen bg-[#FAF8F4] py-10">

    <div class="max-w-5xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="text-center mb-10">
            <p class="uppercase tracking-[0.3em] text-sm text-[#A1876C]">
                Sya's Costura Atelier
            </p>

            <h1 class="font-serif text-4xl text-[#292522] mt-3">
                Form Pemesanan Online
            </h1>

            <p class="text-stone-500 mt-3">
                Lengkapi detail pesanan jahit sesuai kebutuhanmu.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-[#E6DED2] p-6 md:p-10">

            {{-- PRODUK DAN GALERI FOTO --}}
            <section class="mb-10">

                <p class="text-sm text-[#A1876C] uppercase tracking-widest mb-4">
                    Produk yang dipilih
                </p>

                @if(count($productImages) > 0)

                    <div class="grid md:grid-cols-2 gap-6 items-start">

                        {{-- FOTO UTAMA --}}
                        <div class="relative overflow-hidden rounded-2xl bg-[#F7F4EE]">

                            <img
                                id="bookingMainImage"
                                src="{{ $productImages[0] }}"
                                alt="{{ $service->name }}"
                                class="w-full aspect-[4/5] object-cover"
                                onerror="this.style.display='none'; document.getElementById('bookingImageFallback').style.display='flex';"
                            >

                            <div
                                id="bookingImageFallback"
                                class="hidden aspect-[4/5] items-center justify-center text-stone-400"
                            >
                                Foto produk tidak tersedia
                            </div>

                            @if(count($productImages) > 1)
                                <button
                                    type="button"
                                    onclick="bookingChangeSlide(-1)"
                                    aria-label="Foto sebelumnya"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 text-[#665246] shadow flex items-center justify-center hover:bg-white"
                                >
                                    &#10094;
                                </button>

                                <button
                                    type="button"
                                    onclick="bookingChangeSlide(1)"
                                    aria-label="Foto berikutnya"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 text-[#665246] shadow flex items-center justify-center hover:bg-white"
                                >
                                    &#10095;
                                </button>

                                <div class="absolute bottom-3 right-3 bg-black/55 text-white text-xs px-3 py-1.5 rounded-full">
                                    <span id="bookingSlideNumber">1</span>
                                    / {{ count($productImages) }}
                                </div>
                            @endif

                        </div>

                        {{-- INFORMASI PRODUK --}}
                        <div class="flex flex-col justify-center py-2">

                            <p class="text-xs uppercase tracking-[0.2em] text-[#A1876C]">
                                Sya's Costura Collection
                            </p>

                            <h2 class="font-serif text-3xl text-[#292522] mt-3">
                                {{ $service->name }}
                            </h2>

                            @if($service->category)
                                <p class="text-sm text-stone-500 mt-2">
                                    {{ $service->category->name }}
                                </p>
                            @endif

                            <p class="text-2xl text-[#806B57] font-semibold mt-5">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </p>

                            @if($service->description)
                                <p class="text-sm text-stone-600 leading-7 mt-5">
                                    {{ $service->description }}
                                </p>
                            @endif

                            <div class="border-t border-[#E6DED2] mt-6 pt-5">

                                <p class="text-sm font-medium text-[#665246]">
                                    Detail koleksi
                                </p>

                                <p class="text-sm text-stone-500 mt-2">
                                    Produk yang ditampilkan adalah produk yang sedang kamu pesan.
                                    Silakan periksa foto sebelum melanjutkan.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- THUMBNAIL --}}
                    @if(count($productImages) > 1)
                        <div class="flex gap-3 overflow-x-auto mt-4 pb-2">

                            @foreach($productImages as $index => $image)
                                <button
                                    type="button"
                                    data-booking-thumbnail="{{ $index }}"
                                    onclick="bookingGoToSlide({{ $index }})"
                                    class="booking-thumbnail flex-shrink-0 w-20 h-24 overflow-hidden rounded-xl border-2 {{ $index === 0 ? 'border-[#806B57]' : 'border-transparent' }}"
                                    aria-label="Lihat foto {{ $index + 1 }}"
                                >
                                    <img
                                        src="{{ $image }}"
                                        alt="Foto {{ $index + 1 }} {{ $service->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </button>
                            @endforeach

                        </div>
                    @endif

                @else

                    <div class="bg-[#F7F4EE] rounded-2xl p-8 text-center">
                        <p class="text-stone-500">
                            Foto untuk produk ini belum tersedia.
                        </p>
                    </div>

                @endif

            </section>

            {{-- VALIDATION ERROR --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
                    <p class="font-semibold mb-2">
                        Periksa kembali data berikut:
                    </p>

                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('checkout.store', $service->id) }}"
                  class="space-y-8">

                @csrf

                {{-- 01 INFORMASI PELANGGAN --}}
                <section>
                    <h3 class="font-serif text-xl text-[#292522] mb-5">
                        01. Informasi Pelanggan
                    </h3>

                    <label class="block text-sm font-medium mb-2">
                        Nomor WhatsApp
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', auth()->user()->customer->phone ?? '') }}"
                        placeholder="Contoh: 081234567890"
                        class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                        required
                    >
                </section>

                {{-- 02 METODE PENERIMAAN --}}
                <section>
                    <h3 class="font-serif text-xl text-[#292522] mb-5">
                        02. Metode Penerimaan
                    </h3>

                    <select
                        name="fulfillment_type"
                        id="fulfillment_type"
                        class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                        required
                    >
                        <option value="pickup"
                            @selected(old('fulfillment_type', 'pickup') == 'pickup')>
                            Pickup / Ambil di toko
                        </option>

                        <option value="delivery"
                            @selected(old('fulfillment_type') == 'delivery')>
                            Delivery / Dikirim ke alamat
                        </option>
                    </select>

                    <p class="text-xs text-stone-500 mt-2">
                        Pilih apakah pesanan akan diambil langsung di toko atau dikirim ke alamatmu.
                    </p>

                    {{-- JADWAL PICKUP --}}
                    <div
                        id="pickup_fields"
                        class="mt-6 bg-[#F7F4EE] rounded-2xl p-5 space-y-4"
                    >
                        <div>
                            <h4 class="font-semibold text-[#292522]">
                                Jadwal Pengambilan
                            </h4>

                            <p class="text-sm text-stone-500 mt-1">
                                Pilih jadwal untuk mengambil pesanan yang sudah selesai di toko.
                                Jadwal ini bukan jadwal fitting.
                            </p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Tanggal Pengambilan
                                </label>

                                <input
                                    type="date"
                                    name="booking_date"
                                    id="booking_date"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('booking_date') }}"
                                    class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Jam Pengambilan
                                </label>

                                <select
                                    name="time_slot"
                                    id="time_slot"
                                    class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                                    required
                                >
                                    <option value="">Pilih jam</option>

                                    @foreach (['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] as $time)
                                        <option value="{{ $time }}"
                                            @selected(old('time_slot') == $time)>
                                            {{ $time }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    {{-- ALAMAT DELIVERY --}}
                    <div
                        id="delivery_fields"
                        class="mt-6 space-y-4"
                        style="{{ old('fulfillment_type') == 'delivery' ? '' : 'display:none' }}"
                    >
                        <div class="bg-[#F7F4EE] rounded-2xl p-5">
                            <h4 class="font-semibold text-[#292522] mb-1">
                                Alamat Pengiriman
                            </h4>

                            <p class="text-sm text-stone-500">
                                Isi alamat lengkap agar pesanan dapat dikirim dengan benar.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nama Penerima
                            </label>

                            <input
                                type="text"
                                name="recipient_name"
                                id="recipient_name"
                                value="{{ old('recipient_name') }}"
                                placeholder="Nama penerima"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Alamat Lengkap
                            </label>

                            <textarea
                                name="full_address"
                                id="full_address"
                                rows="3"
                                placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, dan detail alamat lainnya"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                            >{{ old('full_address') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Kota
                            </label>

                            <input
                                type="text"
                                name="city"
                                id="city"
                                value="{{ old('city') }}"
                                placeholder="Kota atau kabupaten"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Kode Pos
                            </label>

                            <input
                                type="text"
                                name="postal_code"
                                id="postal_code"
                                value="{{ old('postal_code') }}"
                                placeholder="Kode pos"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                            >
                        </div>
                    </div>
                </section>

                {{-- 03 DETAIL UKURAN --}}
                <section>
                    <h3 class="font-serif text-xl text-[#292522] mb-5">
                        03. Detail Ukuran
                    </h3>

                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nama Ukuran
                            </label>

                            <input
                                type="text"
                                name="size_name"
                                value="{{ old('size_name', 'Ukuran Pribadi') }}"
                                placeholder="Contoh: Ukuran Pribadi"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Detail Ukuran (cm)
                            </label>

                            <textarea
                                name="dimensions_label"
                                rows="5"
                                placeholder="Contoh:&#10;Lingkar dada: 90 cm&#10;Lingkar pinggang: 75 cm&#10;Lingkar pinggul: 95 cm&#10;Panjang baju: 60 cm"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                                required
                            >{{ old('dimensions_label') }}</textarea>

                            <p class="text-xs text-stone-500 mt-2">
                                Tuliskan ukuran tubuh yang diperlukan untuk layanan pilihanmu.
                            </p>
                        </div>

                    </div>
                </section>

                {{-- 04 PILIHAN KAIN --}}
                <section>
                    <h3 class="font-serif text-xl text-[#292522] mb-5">
                        04. Pilihan Kain
                    </h3>

                    <label class="block text-sm font-medium mb-2">
                        Pilih Kain (Opsional)
                    </label>

                    <select
                        name="fabric_id"
                        class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                    >
                        <option value="">Belum memilih kain</option>

                        @foreach ($fabrics as $fabric)
                            <option value="{{ $fabric->id }}"
                                @selected(old('fabric_id') == $fabric->id)>
                                {{ $fabric->name }} -
                                Rp {{ number_format($fabric->price_per_meter, 0, ',', '.') }}/meter
                            </option>
                        @endforeach
                    </select>
                </section>

                {{-- 05 PEMBAYARAN --}}
                <section>
                    <h3 class="font-serif text-xl text-[#292522] mb-5">
                        05. Pembayaran
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">

                        <label class="border border-[#E6DED2] rounded-2xl p-5 cursor-pointer hover:bg-[#F7F4EE] transition">
                            <input
                                type="radio"
                                name="payment_type"
                                value="dp"
                                @checked(old('payment_type', 'dp') == 'dp')
                                required
                            >

                            <span class="font-semibold ml-2">
                                DP 50%
                            </span>

                            <p class="text-sm text-stone-500 mt-2">
                                Bayar setengah di awal, sisanya kemudian.
                            </p>
                        </label>

                        <label class="border border-[#E6DED2] rounded-2xl p-5 cursor-pointer hover:bg-[#F7F4EE] transition">
                            <input
                                type="radio"
                                name="payment_type"
                                value="full"
                                @checked(old('payment_type') == 'full')
                                required
                            >

                            <span class="font-semibold ml-2">
                                Lunas 100%
                            </span>

                            <p class="text-sm text-stone-500 mt-2">
                                Bayar seluruh biaya pesanan.
                            </p>
                        </label>

                    </div>
                </section>

                {{-- TOMBOL --}}
                <div class="border-t border-[#E6DED2] pt-6">

                    <p class="text-sm text-stone-500 mb-4">
                        Periksa kembali data pesanan sebelum melanjutkan.
                    </p>

                    <button
                        type="submit"
                        class="w-full bg-[#665246] hover:bg-[#292522] text-white py-4 rounded-full font-semibold transition"
                    >
                        Lanjutkan Pemesanan
                    </button>

                    <a
                        href="{{ route('katalog.show', $service->id) }}"
                        class="block text-center text-sm text-stone-500 mt-4"
                    >
                        Kembali ke detail layanan
                    </a>

                </div>

            </form>
        </div>
    </div>
</div>

{{-- JAVASCRIPT GALERI FOTO --}}
<script>
const bookingProductImages = @json($productImages);
let bookingCurrentSlide = 0;

function bookingUpdateSlide() {
    const mainImage = document.getElementById('bookingMainImage');
    const slideNumber = document.getElementById('bookingSlideNumber');

    if (!mainImage || bookingProductImages.length === 0) return;

    mainImage.src = bookingProductImages[bookingCurrentSlide];
    mainImage.style.display = 'block';

    const fallback = document.getElementById('bookingImageFallback');
    if (fallback) fallback.style.display = 'none';

    if (slideNumber) {
        slideNumber.textContent = bookingCurrentSlide + 1;
    }

    document.querySelectorAll('.booking-thumbnail').forEach((thumbnail, index) => {
        thumbnail.classList.toggle(
            'border-[#806B57]',
            index === bookingCurrentSlide
        );

        thumbnail.classList.toggle(
            'border-transparent',
            index !== bookingCurrentSlide
        );
    });
}

function bookingChangeSlide(direction) {
    if (bookingProductImages.length <= 1) return;

    bookingCurrentSlide =
        (bookingCurrentSlide + direction + bookingProductImages.length)
        % bookingProductImages.length;

    bookingUpdateSlide();
}

function bookingGoToSlide(index) {
    if (index < 0 || index >= bookingProductImages.length) return;

    bookingCurrentSlide = index;
    bookingUpdateSlide();
}

// Dukungan swipe pada layar HP
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('bookingMainImage');

    if (!mainImage) return;

    let touchStartX = 0;

    mainImage.addEventListener('touchstart', function (event) {
        touchStartX = event.changedTouches[0].screenX;
    }, { passive: true });

    mainImage.addEventListener('touchend', function (event) {
        const touchEndX = event.changedTouches[0].screenX;
        const distance = touchEndX - touchStartX;

        if (Math.abs(distance) > 50) {
            bookingChangeSlide(distance < 0 ? 1 : -1);
        }
    }, { passive: true });
});
</script>

{{-- JAVASCRIPT METODE PENERIMAAN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fulfillment = document.getElementById('fulfillment_type');

    const pickupFields = document.getElementById('pickup_fields');
    const deliveryFields = document.getElementById('delivery_fields');

    const bookingDate = document.getElementById('booking_date');
    const timeSlot = document.getElementById('time_slot');

    const deliveryInputs = [
        document.getElementById('recipient_name'),
        document.getElementById('full_address'),
        document.getElementById('city'),
        document.getElementById('postal_code')
    ];

    function toggleFulfillment() {
        const isPickup = fulfillment.value === 'pickup';
        const isDelivery = fulfillment.value === 'delivery';

        pickupFields.style.display = isPickup ? 'block' : 'none';
        deliveryFields.style.display = isDelivery ? 'block' : 'none';

        bookingDate.required = isPickup;
        timeSlot.required = isPickup;

        deliveryInputs.forEach(function (input) {
            input.required = isDelivery;
        });
    }

    fulfillment.addEventListener('change', toggleFulfillment);

    toggleFulfillment();
});
</script>

@endsection
