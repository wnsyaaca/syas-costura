<div class="group overflow-hidden rounded-2xl border border-[#E6DED2] bg-white p-3 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">

    {{-- PRODUCT VISUAL --}}
    <div class="relative flex h-40 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-[#F1ECE3] via-[#DED1BF] to-[#BBA58B]">

        <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full border border-white/40"></div>
        <div class="absolute -bottom-10 -left-8 h-32 w-32 rounded-full border border-white/40"></div>

        <div class="relative z-10 text-center">
            <span class="text-4xl text-[#665246]">✂</span>
            <p class="mt-3 text-[10px] font-semibold uppercase tracking-[0.3em] text-[#665246]">
                Made for You
            </p>
        </div>

        <span class="absolute bottom-3 right-3 rounded-full bg-white/80 px-3 py-1 text-[9px] font-semibold uppercase tracking-wider text-[#665246] backdrop-blur-sm">
            Sya's Costura
        </span>

    </div>

    {{-- PRODUCT INFORMATION --}}
    <div class="px-2 pb-2 pt-4">

        <p class="font-serif text-lg font-bold text-[#292522] transition group-hover:text-[#806B57]">
            {{ $service->name }}
        </p>

        <p class="mt-2 text-xs text-[#81766B]">
            Mulai dari
        </p>

        <p class="mt-1 text-base font-bold text-[#665246]">
            Rp {{ number_format($service->price, 0, ',', '.') }}
        </p>

        {{-- BUTTON --}}
        <a href="/katalog/{{ $service->id }}"
           class="mt-4 flex items-center justify-center rounded-full border border-[#806B57] px-4 py-2 text-sm font-semibold text-[#665246] transition duration-300 hover:bg-[#292522] hover:text-white">
            Lihat Detail <span class="ml-2">→</span>
        </a>

    </div>

</div>
