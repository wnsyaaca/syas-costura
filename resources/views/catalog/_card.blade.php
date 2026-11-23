@php
    $serviceImage = $service->image_path;

    if (empty($serviceImage) && !empty($service->gallery_images)) {
        $serviceImage = $service->gallery_images[0] ?? null;
    }

    $imageAlt = 'Foto ' . $service->name . " - Sya's Costura";
@endphp

<div class="group flex h-full min-w-0 flex-col overflow-hidden rounded-2xl border border-[#E6DED2] bg-white shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">

    {{-- FOTO PRODUK --}}
    <div class="relative h-64 w-full shrink-0 overflow-hidden bg-[#F1ECE3]">

        @if ($serviceImage)
            <img
                src="{{ $serviceImage }}"
                alt="{{ $imageAlt }}"
                class="block h-full w-full object-cover object-center transition duration-700 group-hover:scale-105"
                loading="lazy"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >

            <div
                class="absolute inset-0 hidden items-center justify-center bg-[#F1ECE3]"
            >
                <span class="text-sm text-[#81766B]">
                    Foto belum tersedia
                </span>
            </div>
        @else
            <div class="flex h-full w-full items-center justify-center">
                <span class="text-sm text-[#81766B]">
                    Foto belum tersedia
                </span>
            </div>
        @endif

        {{-- BADGE --}}
        <div class="absolute left-3 top-3 z-10">
            <span class="rounded-full border border-white/70 bg-white/90 px-3 py-1.5 text-[9px] font-semibold uppercase tracking-[0.2em] text-[#665246] shadow-sm backdrop-blur-sm">
                Sya's Costura
            </span>
        </div>

    </div>

    {{-- INFORMASI PRODUK --}}
    <div class="flex flex-1 flex-col px-4 pb-4 pt-4">

        <div>
            <p class="font-serif text-lg font-bold leading-snug text-[#292522] transition group-hover:text-[#806B57]">
                {{ $service->name }}
            </p>

            <p class="mt-2 text-xs text-[#81766B]">
                Mulai dari
            </p>

            <p class="mt-1 text-base font-bold text-[#665246]">
                Rp {{ number_format($service->price, 0, ',', '.') }}
            </p>
        </div>

        {{-- TOMBOL DETAIL --}}
        <a
            href="{{ route('katalog.show', $service->id) }}"
            class="mt-auto flex w-full items-center justify-center gap-2 rounded-xl bg-[#665246] px-4 py-3 text-xs font-semibold uppercase tracking-[0.15em] text-white transition hover:bg-[#49392F]"
        >
            Lihat Detail
            <span aria-hidden="true">→</span>
        </a>

    </div>

</div>
