@extends('layouts.costura')

@section('title', "Katalog - Sya's Costura")

@section('content')

<div class="w-full min-w-0 px-4 py-8 sm:px-6 lg:px-8">

    {{-- HEADER KATALOG DENGAN FOTO ASLI --}}
    <section class="relative isolate w-full overflow-hidden rounded-[30px] bg-[#F1ECE3] px-6 py-12 md:px-12 md:py-16">

        {{-- FOTO ASLI DARI PEXELS --}}
        <img
            src="https://images.pexels.com/photos/7147600/pexels-photo-7147600.jpeg?auto=compress&dpr=1&h=750&w=1260"
            alt="Fashion designer sedang mengukur kain pada mannequin"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-center"
        >

        {{-- WARM BEIGE OVERLAY --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#F2DCC3]/95 via-[#EBD0AF]/85 to-[#C99D70]/65"></div>

        {{-- TEKS HEADER --}}
        <div class="relative z-10 mx-auto max-w-2xl text-center">

            <p class="text-[11px] font-semibold uppercase tracking-[0.35em] text-[#604633]">
                Discover Our Collection
            </p>

            <h1 class="mt-5 font-serif text-3xl font-bold text-[#292522] md:text-5xl">
                Katalog Layanan
            </h1>

            <p class="mt-5 text-sm leading-8 text-[#514033] md:text-base">
                Temukan layanan jahit pilihan untuk menciptakan pakaian
                yang sesuai dengan gaya, kebutuhan, dan kepribadianmu.
            </p>

            <div class="mx-auto mt-7 h-px w-16 bg-[#806044]"></div>

        </div>

    </section>


    {{-- SEARCH DAN FILTER --}}
    <section class="mt-12 w-full min-w-0">

        <div class="flex min-w-0 flex-col gap-5 md:flex-row md:items-end md:justify-between">

            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#A1876C]">
                    Find Your Style
                </p>

                <h2 class="mt-2 font-serif text-2xl font-bold text-[#292522] md:text-3xl">
                    Pilihan Layanan
                </h2>
            </div>

            {{-- SEARCH --}}
            <form method="GET"
                  action="{{ route('katalog') }}"
                  class="flex w-full min-w-0 gap-2 md:max-w-md">

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari layanan jahit..."
                    class="min-w-0 flex-1 rounded-full border border-[#D8CCBC] bg-white px-5 py-3.5 text-sm text-[#292522] outline-none transition placeholder:text-[#A49A8E] focus:border-[#806B57] focus:ring-2 focus:ring-[#806B57]/10">

                @if(request('category'))
                    <input type="hidden"
                           name="category"
                           value="{{ request('category') }}">
                @endif

                <button type="submit"
                        class="shrink-0 rounded-full bg-[#292522] px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-[#665246]">
                    Cari
                </button>

            </form>

        </div>


        {{-- CATEGORY FILTER --}}
        <div class="mt-7 flex flex-wrap gap-3">

            <a href="{{ route('katalog', request()->except('category', 'page')) }}"
               class="rounded-full px-6 py-2.5 text-xs font-semibold transition
               {{ !request('category')
                    ? 'bg-[#292522] text-white shadow-sm'
                    : 'border border-[#D8CCBC] bg-white text-[#665246] hover:bg-[#F1ECE3]' }}">
                Semua
            </a>

            @foreach($categories as $c)

                <a href="{{ route('katalog', array_merge(request()->except('page'), ['category' => $c->slug])) }}"
                   class="rounded-full px-6 py-2.5 text-xs font-semibold transition
                   {{ request('category') === $c->slug
                        ? 'bg-[#292522] text-white shadow-sm'
                        : 'border border-[#D8CCBC] bg-white text-[#665246] hover:bg-[#F1ECE3]' }}">
                    {{ $c->name }}
                </a>

            @endforeach

        </div>

    </section>


    {{-- PRODUCT GRID --}}
    <section class="mt-10 w-full min-w-0">

        <div class="grid w-full min-w-0 grid-cols-1 items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @forelse($services as $service)

                <div class="h-full min-w-0">
                    @include('catalog._card', ['service' => $service])
                </div>

            @empty

                <div class="col-span-full rounded-[28px] border border-[#E6DED2] bg-[#FAF8F4] px-6 py-16 text-center">

                    <div class="text-5xl text-[#A1876C]">
                        ✂
                    </div>

                    <h3 class="mt-5 font-serif text-2xl font-bold text-[#292522]">
                        Layanan Tidak Ditemukan
                    </h3>

                    <p class="mt-3 text-sm text-[#81766B]">
                        Coba gunakan kata kunci pencarian yang berbeda.
                    </p>

                    <a href="{{ route('katalog') }}"
                       class="mt-7 inline-block rounded-full bg-[#292522] px-7 py-3 text-sm font-semibold text-white transition hover:bg-[#665246]">
                        Lihat Semua Layanan
                    </a>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($services->hasPages())
            <div class="mt-12">
                {{ $services->links() }}
            </div>
        @endif

    </section>


    {{-- CLOSING BANNER DENGAN FOTO ASLI --}}
    <section class="relative isolate my-20 w-full overflow-hidden rounded-[30px] px-6 py-14 text-center text-white md:px-12 md:py-16">

        {{-- FOTO ASLI DARI PEXELS --}}
        <img
            src="https://images.pexels.com/photos/7147646/pexels-photo-7147646.jpeg?auto=compress&cs=tinysrgb&w=1600"
            alt="Penjahit sedang menjahit kain di atelier"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-center"
            loading="lazy"
        >

        {{-- OVERLAY ESPRESSO HANGAT --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#241710]/90 via-[#39251A]/85 to-[#241710]/90"></div>

        {{-- TEKS CTA --}}
        <div class="relative z-10">

            <p class="text-[11px] font-semibold uppercase tracking-[0.35em] text-[#D8BD9C]">
                Made Especially for You
            </p>

            <h2 class="mt-5 font-serif text-2xl font-bold text-white md:text-4xl">
                Your Perfect Outfit Starts Here
            </h2>

            <p class="mx-auto mt-4 max-w-xl text-sm leading-8 text-white/85">
                Punya desain pakaian impian? Konsultasikan kebutuhan jahitmu
                bersama Sya's Costura.
            </p>

            <a href="{{ route('booking.index') }}"
               class="mt-8 inline-block rounded-full bg-[#F1ECE3] px-8 py-3.5 text-sm font-semibold text-[#292522] transition hover:-translate-y-1 hover:bg-[#DED1BF]">
                Konsultasi Sekarang →
            </a>

        </div>

    </section>

</div>

@endsection
