@extends('layouts.costura')

@section('title', $service->name . " - Sya's Costura")

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | GALERI FOTO PRODUK
    |--------------------------------------------------------------------------
    | Foto utama dan tambahan dibaca dari database produk.
    | Tidak ada foto acak berdasarkan nama produk.
    */

    $galleryImages = [];
    $imageAlt = $service->name . " - Sya's Costura";

    $formatImageUrl = function ($image) {
        if (empty($image)) {
            return null;
        }

        $image = trim($image);

        if (preg_match('/^https?:\/\//i', $image)) {
            return $image;
        }

        if (str_starts_with($image, 'storage/')) {
            return asset($image);
        }

        return asset('storage/' . ltrim($image, '/'));
    };

    // Foto utama.
    if (!empty($service->image_path)) {
        $mainImage = $formatImageUrl($service->image_path);

        if ($mainImage) {
            $galleryImages[] = $mainImage;
        }
    }

    // Foto tambahan produk yang sama.
    foreach (($service->gallery_images ?? []) as $image) {
        $formattedImage = $formatImageUrl($image);

        if ($formattedImage) {
            $galleryImages[] = $formattedImage;
        }
    }

    // Hilangkan duplikasi foto.
    $galleryImages = array_values(array_unique($galleryImages));

    $colors = $service->available_colors ?? [];

    $sizes = $service->standard_sizes ?: [
        'S', 'M', 'L', 'XL', 'XXL'
    ];

    $measurementFields = [
        'chest' => 'Lingkar Dada',
        'waist' => 'Lingkar Pinggang',
        'hip' => 'Lingkar Pinggul',
        'shoulder' => 'Lebar Bahu',
        'length' => 'Panjang Baju',
        'sleeve' => 'Panjang Lengan',
    ];
@endphp

<div class="min-h-screen bg-[#FAF8F4] py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- KEMBALI --}}
        <a
            href="{{ route('katalog') }}"
            class="inline-flex items-center gap-2 text-sm text-[#8B8178] transition hover:text-[#665246]"
        >
            ← Kembali ke Katalog
        </a>

        <div class="mt-8 grid grid-cols-1 items-start gap-10 lg:grid-cols-2 lg:gap-14">

            {{-- ================================================= --}}
            {{-- GALERI FOTO --}}
            {{-- ================================================= --}}

            <div>

                <div class="relative">

                    <div
                        class="relative overflow-hidden rounded-[28px] bg-[#EAE3D9]"
                        style="aspect-ratio: 4 / 5;"
                    >

                        @if(count($galleryImages) > 0)

                            <img
                                id="mainProductImage"
                                src="{{ $galleryImages[0] }}"
                                alt="{{ $imageAlt }}"
                                class="h-full w-full object-cover transition-opacity duration-300"
                            >

                            @if(count($galleryImages) > 1)

                                <div class="absolute bottom-4 right-4 rounded-full bg-black/55 px-4 py-2 text-xs font-medium text-white backdrop-blur-sm">
                                    <span id="currentImageNumber">1</span>
                                    / {{ count($galleryImages) }}
                                </div>

                                <button
                                    type="button"
                                    onclick="changeSlide(-1)"
                                    aria-label="Foto sebelumnya"
                                    class="absolute left-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-xl text-[#665246] shadow-lg transition hover:bg-white"
                                >
                                    &#10094;
                                </button>

                                <button
                                    type="button"
                                    onclick="changeSlide(1)"
                                    aria-label="Foto berikutnya"
                                    class="absolute right-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-xl text-[#665246] shadow-lg transition hover:bg-white"
                                >
                                    &#10095;
                                </button>

                            @endif

                        @else

                            <div class="flex h-full w-full flex-col items-center justify-center">

                                <span class="text-6xl text-[#A1876C]">✂</span>

                                <p class="mt-4 font-serif text-2xl text-[#665246]">
                                    Sya's Costura
                                </p>

                                <p class="mt-2 text-sm text-[#806B57]">
                                    Foto produk belum tersedia
                                </p>

                            </div>

                        @endif

                    </div>

                    {{-- THUMBNAIL --}}
                    @if(count($galleryImages) > 1)

                        <div
                            id="thumbnailContainer"
                            class="mt-4 flex gap-3 overflow-x-auto pb-3"
                        >

                            @foreach($galleryImages as $index => $image)

                                <button
                                    type="button"
                                    onclick="goToSlide({{ $index }})"
                                    data-thumbnail="{{ $index }}"
                                    class="h-24 w-20 flex-shrink-0 overflow-hidden rounded-xl border-2 transition {{ $index === 0 ? 'border-[#806B57]' : 'border-transparent opacity-70 hover:opacity-100' }}"
                                >

                                    <img
                                        src="{{ $image }}"
                                        alt="Foto {{ $index + 1 }} {{ $service->name }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >

                                </button>

                            @endforeach

                        </div>

                        <p class="mt-2 text-center text-xs text-[#A49A8E]">
                            Geser foto atau pilih gambar kecil untuk melihat koleksi
                        </p>

                    @endif

                </div>

                {{-- INFORMASI ATELIER --}}
                <div class="mt-5 rounded-2xl border border-[#E9E1D7] bg-white p-5">

                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#A1876C]">
                        Sya's Costura Atelier
                    </p>

                    <p class="mt-2 font-serif text-xl text-[#46372D]">
                        Elegance in Every Detail
                    </p>

                    <p class="mt-2 text-sm leading-7 text-[#81766B]">
                        Setiap koleksi dipilih dengan memperhatikan detail,
                        kenyamanan, dan keindahan desain.
                    </p>

                </div>

            </div>

            {{-- ================================================= --}}
            {{-- INFORMASI PRODUK --}}
            {{-- ================================================= --}}

            <div>

                @if(!empty($service->series))
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#A1876C]">
                        {{ $service->series }}
                    </p>
                @endif

                <p class="mt-3 text-xs font-semibold uppercase tracking-[0.3em] text-[#A1876C]">
                    {{ $service->category->name ?? 'Our Collection' }}
                </p>

                <h1 class="mt-4 font-serif text-3xl font-bold leading-tight text-[#292522] md:text-4xl">
                    {{ $service->name }}
                </h1>

                <p class="mt-5 text-2xl font-semibold text-[#806B57]">
                    Rp {{ number_format($service->price, 0, ',', '.') }}
                </p>

                <p class="mt-2 text-xs text-[#A49A8E]">
                    Harga produk
                </p>

                <div class="my-7 border-t border-[#E6DED2]"></div>

                {{-- DESKRIPSI --}}
                <div>

                    <h2 class="font-semibold text-[#292522]">
                        Deskripsi Produk
                    </h2>

                    <p class="mt-3 text-sm leading-8 text-[#81766B]">
                        {{ $service->description ?: "Koleksi pilihan dari Sya's Costura yang dirancang dengan perhatian pada detail dan kenyamanan." }}
                    </p>

                </div>

                {{-- KEBUTUHAN BAHAN --}}
                <div class="mt-6 rounded-2xl bg-[#F1ECE3] p-5">

                    <p class="text-xs uppercase tracking-wider text-[#806B57]">
                        Estimasi kebutuhan bahan
                    </p>

                    <p class="mt-2 font-semibold text-[#665246]">
                        {{ $service->fabric_need_meter ?? 0 }} meter
                    </p>

                </div>

                {{-- ================================================= --}}
                {{-- FORM KERANJANG --}}
                {{-- ================================================= --}}

                <form
                    action="{{ route('cart.store', $service->id) }}"
                    method="POST"
                    class="mt-8"
                >

                    @csrf

                    {{-- PILIH WARNA --}}
                    <div>

                        <label class="block text-sm font-semibold text-[#46372D]">
                            Pilih Warna
                        </label>

                        @if(count($colors) > 0)

                            <select
                                name="color"
                                class="mt-3 w-full rounded-xl border border-[#DED5CA] bg-white px-4 py-3 text-sm text-[#665246] outline-none focus:border-[#806B57]"
                            >

                                <option value="">
                                    Pilih warna
                                </option>

                                @foreach($colors as $color)

                                    <option
                                        value="{{ $color }}"
                                        {{ old('color') == $color ? 'selected' : '' }}
                                    >
                                        {{ $color }}
                                    </option>

                                @endforeach

                            </select>

                        @else

                            <p class="mt-3 text-sm text-[#A49A8E]">
                                Pilihan warna belum ditambahkan untuk produk ini.
                            </p>

                            <input type="hidden" name="color" value="">

                        @endif

                        @error('color')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- PILIH UKURAN --}}
                    <div class="mt-7">

                        <label class="block text-sm font-semibold text-[#46372D]">
                            Pilihan Ukuran
                        </label>

                        <div class="mt-3 grid grid-cols-2 gap-3">

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="size_type"
                                    value="standard"
                                    class="peer sr-only"
                                    {{ old('size_type', 'standard') === 'standard' ? 'checked' : '' }}
                                    onchange="toggleCustomSize()"
                                >

                                <div class="rounded-xl border border-[#DED5CA] bg-white p-4 text-center text-sm text-[#665246] transition peer-checked:border-[#806B57] peer-checked:bg-[#F1ECE3] peer-checked:font-semibold">
                                    Ukuran Standar
                                </div>

                            </label>

                            @if($service->allow_custom_size)

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="size_type"
                                        value="custom"
                                        class="peer sr-only"
                                        {{ old('size_type') === 'custom' ? 'checked' : '' }}
                                        onchange="toggleCustomSize()"
                                    >

                                    <div class="rounded-xl border border-[#DED5CA] bg-white p-4 text-center text-sm text-[#665246] transition peer-checked:border-[#806B57] peer-checked:bg-[#F1ECE3] peer-checked:font-semibold">
                                        Custom Size
                                    </div>

                                </label>

                            @endif

                        </div>

                        {{-- UKURAN STANDAR --}}
                        <div id="standardSizeSection" class="mt-5">

                            <label class="block text-sm text-[#665246]">
                                Pilih ukuran
                            </label>

                            <div class="mt-3 flex flex-wrap gap-3">

                                @foreach($sizes as $size)

                                    <label class="cursor-pointer">

                                        <input
                                            type="radio"
                                            name="size_label"
                                            value="{{ $size }}"
                                            class="peer sr-only"
                                            {{ old('size_label') == $size ? 'checked' : '' }}
                                        >

                                        <div class="flex h-12 min-w-12 items-center justify-center rounded-lg border border-[#DED5CA] bg-white px-4 text-sm text-[#665246] transition peer-checked:border-[#806B57] peer-checked:bg-[#806B57] peer-checked:text-white">
                                            {{ $size }}
                                        </div>

                                    </label>

                                @endforeach

                            </div>

                            @error('size_label')
                                <p class="mt-2 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- UKURAN CUSTOM --}}
                        @if($service->allow_custom_size)

                            <div id="customSizeSection" class="mt-5 hidden">

                                <div class="rounded-2xl border border-[#E5DDD3] bg-white p-5">

                                    <h3 class="font-serif text-xl text-[#46372D]">
                                        Ukuran Badan Custom
                                    </h3>

                                    <p class="mt-2 text-xs leading-6 text-[#A49A8E]">
                                        Masukkan ukuran badan dalam satuan centimeter (cm).
                                    </p>

                                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                                        @foreach($measurementFields as $field => $label)

                                            <div>

                                                <label class="text-xs font-medium text-[#665246]">
                                                    {{ $label }}
                                                </label>

                                                <div class="relative mt-2">

                                                    <input
                                                        type="number"
                                                        step="0.1"
                                                        min="1"
                                                        max="300"
                                                        name="custom_measurements[{{ $field }}]"
                                                        value="{{ old('custom_measurements.' . $field) }}"
                                                        placeholder="Contoh: 90"
                                                        class="w-full rounded-xl border border-[#DED5CA] bg-[#FAF8F4] px-4 py-3 pr-12 text-sm outline-none focus:border-[#806B57]"
                                                    >

                                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-[#A49A8E]">
                                                        cm
                                                    </span>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                    @error('custom_measurements.*')
                                        <p class="mt-3 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        @endif

                        @error('size_type')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- JUMLAH --}}
                    <div class="mt-7">

                        <label
                            for="quantity"
                            class="block text-sm font-semibold text-[#46372D]"
                        >
                            Jumlah Produk
                        </label>

                        <input
                            id="quantity"
                            type="number"
                            name="quantity"
                            min="1"
                            max="20"
                            value="{{ old('quantity', 1) }}"
                            required
                            class="mt-3 w-28 rounded-xl border border-[#DED5CA] bg-white px-4 py-3 text-center text-sm text-[#665246] outline-none focus:border-[#806B57]"
                        >

                        @error('quantity')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- TOMBOL TAMBAH KERANJANG --}}
                    <div class="mt-8 space-y-3">

                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-3 rounded-full bg-[#665246] px-8 py-4 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#292522]"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M6 7h12l1 13H5L6 7Z"/>
                                <path d="M9 9V6a3 3 0 0 1 6 0v3"/>
                            </svg>

                            Tambah ke Keranjang

                        </button>

                        {{-- WHATSAPP --}}
                        <a
                            href="https://wa.me/6281266649126"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="block w-full rounded-full border border-[#806B57] px-8 py-4 text-center text-sm font-semibold text-[#665246] transition hover:bg-[#F1ECE3]"
                        >
                            Konsultasi via WhatsApp
                        </a>

                    </div>

                </form>

                {{-- INFORMASI TAMBAHAN --}}
                <div class="mt-7 border-t border-[#E6DED2] pt-6">

                    <div class="flex items-center gap-3 text-sm text-[#81766B]">
                        <span class="text-[#A1876C]">✦</span>
                        Pilihan ukuran standar dan custom
                    </div>

                    <div class="mt-3 flex items-center gap-3 text-sm text-[#81766B]">
                        <span class="text-[#A1876C]">✦</span>
                        Koleksi pilihan Sya's Costura
                    </div>

                    <div class="mt-3 flex items-center gap-3 text-sm text-[#81766B]">
                        <span class="text-[#A1876C]">✦</span>
                        Detail pesanan dapat diperiksa di keranjang
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ================================================= --}}
{{-- JAVASCRIPT GALERI DAN UKURAN --}}
{{-- ================================================= --}}

<script>
    const productImages = @json($galleryImages);

    let currentSlide = 0;

    function updateSlide() {
        const mainImage = document.getElementById('mainProductImage');
        const currentNumber = document.getElementById('currentImageNumber');

        if (!mainImage || productImages.length === 0) {
            return;
        }

        mainImage.style.opacity = '0.35';

        const nextImage = new Image();

        nextImage.onload = function () {
            mainImage.src = productImages[currentSlide];
            mainImage.style.opacity = '1';
        };

        nextImage.onerror = function () {
            mainImage.style.opacity = '1';
        };

        nextImage.src = productImages[currentSlide];

        if (currentNumber) {
            currentNumber.textContent = currentSlide + 1;
        }

        document.querySelectorAll('[data-thumbnail]').forEach((thumbnail, index) => {
            if (index === currentSlide) {
                thumbnail.classList.add('border-[#806B57]');
                thumbnail.classList.remove('border-transparent', 'opacity-70');
            } else {
                thumbnail.classList.remove('border-[#806B57]');
                thumbnail.classList.add('border-transparent', 'opacity-70');
            }
        });

        const activeThumbnail = document.querySelector(
            `[data-thumbnail="${currentSlide}"]`
        );

        if (activeThumbnail) {
            activeThumbnail.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }

    function changeSlide(direction) {
        if (productImages.length <= 1) return;

        currentSlide += direction;

        if (currentSlide >= productImages.length) {
            currentSlide = 0;
        }

        if (currentSlide < 0) {
            currentSlide = productImages.length - 1;
        }

        updateSlide();
    }

    function goToSlide(index) {
        if (index < 0 || index >= productImages.length) return;

        currentSlide = index;
        updateSlide();
    }

    function toggleCustomSize() {
        const selected = document.querySelector(
            'input[name="size_type"]:checked'
        );

        const standardSection = document.getElementById(
            'standardSizeSection'
        );

        const customSection = document.getElementById(
            'customSizeSection'
        );

        if (!selected) return;

        const isCustom = selected.value === 'custom';

        if (standardSection) {
            standardSection.classList.toggle('hidden', isCustom);

            standardSection.querySelectorAll('input').forEach(input => {
                input.disabled = isCustom;
                input.required = !isCustom;
            });
        }

        if (customSection) {
            customSection.classList.toggle('hidden', !isCustom);

            customSection.querySelectorAll('input').forEach(input => {
                input.disabled = !isCustom;
                input.required = isCustom;
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        const mainImage = document.getElementById('mainProductImage');

        if (mainImage) {
            let startX = 0;

            mainImage.addEventListener('touchstart', function (event) {
                startX = event.changedTouches[0].screenX;
            }, { passive: true });

            mainImage.addEventListener('touchend', function (event) {
                const endX = event.changedTouches[0].screenX;
                const distance = endX - startX;

                if (Math.abs(distance) > 50) {
                    changeSlide(distance < 0 ? 1 : -1);
                }
            }, { passive: true });
        }

        toggleCustomSize();
    });
</script>

@endsection
