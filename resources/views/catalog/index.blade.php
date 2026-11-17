@extends('layouts.costura')

@section('title', "Katalog - Sya's Costura")

@section('content')

{{-- HEADER KATALOG --}}
<section class="rounded-3xl bg-[#F1ECE3] px-6 py-10 md:px-10 md:py-14">

    <div class="mx-auto max-w-2xl text-center">

        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#A1876C]">
            Discover Our Collection
        </p>

        <h1 class="mt-4 font-serif text-3xl font-bold text-[#292522] md:text-5xl">
            Katalog Layanan
        </h1>

        <p class="mt-4 text-sm leading-relaxed text-[#746B62] md:text-base">
            Temukan layanan jahit pilihan untuk menciptakan pakaian
            yang sesuai dengan gaya, kebutuhan, dan kepribadianmu.
        </p>

        <div class="mx-auto mt-6 h-px w-16 bg-[#A1876C]"></div>

    </div>

</section>


{{-- SEARCH SECTION --}}
<section class="mt-10">

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#A1876C]">
                Find Your Style
            </p>

            <h2 class="mt-1 font-serif text-2xl font-bold text-[#292522]">
                Pilihan Layanan
            </h2>
        </div>

        <form method="GET" action="/katalog"
              class="flex w-full gap-2 md:max-w-md">

            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari layanan jahit..."
                class="min-w-0 flex-1 rounded-full border border-[#D8CCBC] bg-white px-5 py-3 text-sm text-[#292522] outline-none transition placeholder:text-[#A49A8E] focus:border-[#806B57] focus:ring-2 focus:ring-[#806B57]/10">

            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <button type="submit"
                    class="rounded-full bg-[#292522] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#665246]">
                Cari
            </button>

        </form>

    </div>


    {{-- CATEGORY FILTER --}}
    <div class="mt-6 flex flex-wrap gap-2">

        <a href="/katalog"
           class="rounded-full px-5 py-2 text-sm font-semibold transition
           {{ !request('category')
                ? 'bg-[#292522] text-white'
                : 'border border-[#D8CCBC] bg-white text-[#665246] hover:bg-[#F1ECE3]' }}">
            Semua
        </a>

        @foreach ($categories as $c)

            <a href="/katalog?category={{ $c->slug }}"
               class="rounded-full px-5 py-2 text-sm font-semibold transition
               {{ request('category') === $c->slug
                    ? 'bg-[#292522] text-white'
                    : 'border border-[#D8CCBC] bg-white text-[#665246] hover:bg-[#F1ECE3]' }}">
                {{ $c->name }}
            </a>

        @endforeach

    </div>

</section>


{{-- PRODUCT GRID --}}
<section class="mt-8">

    <div class="mb-5 flex items-center justify-between">

        <p class="text-sm text-[#81766B]">
            Berikut layanan yang tersedia di Sya's Costura.
        </p>

    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        @forelse ($services as $service)

            @include('catalog._card', ['service' => $service])

        @empty

            <div class="col-span-full rounded-2xl border border-[#E6DED2] bg-white px-6 py-14 text-center">

                <div class="text-4xl text-[#A1876C]">✂</div>

                <h3 class="mt-4 font-serif text-xl font-bold text-[#292522]">
                    Layanan Tidak Ditemukan
                </h3>

                <p class="mt-2 text-sm text-[#81766B]">
                    Coba gunakan kata kunci pencarian yang berbeda.
                </p>

                <a href="/katalog"
                   class="mt-5 inline-block rounded-full bg-[#292522] px-6 py-2 text-sm font-semibold text-white transition hover:bg-[#665246]">
                    Lihat Semua Layanan
                </a>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    <div class="mt-10">
        {{ $services->links() }}
    </div>

</section>


{{-- CLOSING BANNER --}}
<section class="my-16 rounded-3xl bg-[#292522] px-6 py-10 text-center text-white md:px-12">

    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C9B99F]">
        Made Especially for You
    </p>

    <h2 class="mt-4 font-serif text-2xl font-bold md:text-3xl">
        Your Perfect Outfit Starts Here
    </h2>

    <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-white/70">
        Punya desain pakaian impian? Konsultasikan kebutuhan jahitmu
        bersama Sya's Costura.
    </p>

    <a href="/booking"
       class="mt-6 inline-block rounded-full bg-[#F1ECE3] px-7 py-3 text-sm font-semibold text-[#292522] transition hover:bg-[#DED1BF]">
        Konsultasi Sekarang →
    </a>

</section>

@endsection
