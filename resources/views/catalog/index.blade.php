@extends('layouts.costura')

@section('title', "Katalog - Sya's Costura")

@section('content')

@php
    $collectionNames = [
        'woman' => 'Woman',
        'men' => 'Men',
        'kids' => 'Kids',
        'family' => 'Family',
    ];
@endphp

<div class="w-full min-w-0 px-4 py-8 sm:px-6 lg:px-8">

    {{-- HEADER KATALOG --}}
    <section class="relative isolate w-full overflow-hidden rounded-[30px] bg-[#F1ECE3] px-6 py-12 md:px-12 md:py-16">

        <img
            src="https://images.pexels.com/photos/7147600/pexels-photo-7147600.jpeg?auto=compress&dpr=1&h=750&w=1260"
            alt="Fashion atelier"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-center"
        >

        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#F2DCC3]/95 via-[#EBD0AF]/85 to-[#C99D70]/65"></div>

        <div class="relative z-10 mx-auto max-w-2xl text-center">

            <p class="text-[11px] font-semibold uppercase tracking-[0.35em] text-[#604633]">
                Discover Our Collection
            </p>

            <h1 class="mt-5 font-serif text-3xl font-bold text-[#292522] md:text-5xl">
                Katalog Koleksi
            </h1>

            <p class="mt-5 text-sm leading-8 text-[#514033] md:text-base">
                Temukan koleksi busana pilihan Sya's Costura.
                Pilih model, warna, dan ukuran favoritmu untuk
                melengkapi penampilan dengan sentuhan elegan.
            </p>

            <div class="mx-auto mt-7 h-px w-16 bg-[#806044]"></div>

        </div>
    </section>


    {{-- PILIHAN KOLEKSI UTAMA --}}
    <section class="mt-12">

        <div class="text-center">
            <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#A1876C]">
                Explore Our Collections
            </p>

            <h2 class="mt-2 font-serif text-2xl font-bold text-[#292522] md:text-3xl">
                Find Your Collection
            </h2>

            <p class="mt-3 text-sm text-[#81766B]">
                Pilih koleksi sesuai gaya dan kebutuhanmu.
            </p>
        </div>

        <div class="mt-7 grid grid-cols-2 gap-3 md:grid-cols-4">

            @foreach($collections as $key => $name)

                <a
                    href="{{ route('katalog', array_merge(request()->except('category', 'page'), ['collection' => $key])) }}"
                    class="group rounded-2xl border px-4 py-5 text-center transition duration-300 hover:-translate-y-1 hover:shadow-md
                    {{ $collection === $key
                        ? 'border-[#292522] bg-[#292522] text-white shadow-md'
                        : 'border-[#E3D9CC] bg-[#FAF8F4] text-[#514033] hover:border-[#A1876C] hover:bg-[#F1ECE3]' }}"
                >

                    <span class="block font-serif text-lg font-bold tracking-wide md:text-xl">
                        {{ strtoupper($name) }}
                    </span>

                    <span class="mt-2 block text-[10px] uppercase tracking-[0.2em]
                        {{ $collection === $key ? 'text-[#D8BD9C]' : 'text-[#A1876C]' }}">
                        {{ $collection === $key ? 'Selected Collection' : 'Explore Collection' }}
                    </span>

                </a>

            @endforeach

        </div>

    </section>


    {{-- SEARCH DAN FILTER KATEGORI --}}
    <section class="mt-14 w-full min-w-0">

        <div class="flex min-w-0 flex-col gap-5 md:flex-row md:items-end md:justify-between">

            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-[#A1876C]">
                    {{ $collectionNames[$collection] ?? 'Woman' }} Collection
                </p>

                <h2 class="mt-2 font-serif text-2xl font-bold text-[#292522] md:text-3xl">
                    Pilihan {{ $collectionNames[$collection] ?? 'Woman' }}
                </h2>
            </div>

            {{-- SEARCH --}}
            <form
                method="GET"
                action="{{ route('katalog') }}"
                class="flex w-full min-w-0 gap-2 md:max-w-md"
            >

                <input
                    type="hidden"
                    name="collection"
                    value="{{ $collection }}"
                >

                @if(request('category'))
                    <input
                        type="hidden"
                        name="category"
                        value="{{ request('category') }}"
                    >
                @endif

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari produk..."
                    class="min-w-0 flex-1 rounded-full border border-[#D8CCBC] bg-white px-5 py-3.5 text-sm text-[#292522] outline-none transition placeholder:text-[#A49A8E] focus:border-[#806B57] focus:ring-2 focus:ring-[#806B57]/10"
                >

                <button
                    type="submit"
                    class="shrink-0 rounded-full bg-[#292522] px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-[#665246]"
                >
                    Cari
                </button>

            </form>

        </div>


        {{-- FILTER KATEGORI --}}
        <div class="mt-7 flex flex-wrap gap-3">

            <a
                href="{{ route('katalog', request()->except('category', 'page')) }}"
                class="rounded-full px-6 py-2.5 text-xs font-semibold transition
                {{ !request('category')
                    ? 'bg-[#292522] text-white shadow-sm'
                    : 'border border-[#D8CCBC] bg-white text-[#665246] hover:bg-[#F1ECE3]' }}"
            >
                Semua
            </a>

            @foreach($categories as $c)

                <a
                    href="{{ route('katalog', array_merge(request()->except('page'), ['category' => $c->slug])) }}"
                    class="rounded-full px-6 py-2.5 text-xs font-semibold transition
                    {{ request('category') === $c->slug
                        ? 'bg-[#292522] text-white shadow-sm'
                        : 'border border-[#D8CCBC] bg-white text-[#665246] hover:bg-[#F1ECE3]' }}"
                >
                    {{ $c->name }}
                </a>

            @endforeach

        </div>

    </section>


    {{-- PRODUCT GRID --}}
    <section class="mt-10 w-full min-w-0">

        <div class="mb-6 flex items-center justify-between">
            <p class="text-xs text-[#81766B]">
                Menampilkan {{ $services->total() }} produk
            </p>
        </div>

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
                        @if(request('q'))
                            Produk Tidak Ditemukan
                        @else
                            Koleksi {{ $collectionNames[$collection] ?? 'Woman' }} Segera Hadir
                        @endif
                    </h3>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-[#81766B]">
                        @if(request('q'))
                            Coba gunakan kata kunci pencarian yang berbeda.
                        @else
                            Kami sedang menyiapkan pilihan busana terbaik
                            untuk koleksi ini. Nantikan koleksi terbaru Sya's Costura.
                        @endif
                    </p>

                    <a
                        href="{{ route('katalog', ['collection' => $collection]) }}"
                        class="mt-7 inline-block rounded-full bg-[#292522] px-7 py-3 text-sm font-semibold text-white transition hover:bg-[#665246]"
                    >
                        Lihat Koleksi
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


    {{-- CLOSING BANNER --}}
    <section class="relative isolate my-20 w-full overflow-hidden rounded-[30px] px-6 py-14 text-center text-white md:px-12 md:py-16">

        <img
            src="https://images.pexels.com/photos/7147646/pexels-photo-7147646.jpeg?auto=compress&cs=tinysrgb&w=1600"
            alt="Penjahit sedang menjahit kain di atelier"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-center"
            loading="lazy"
        >

        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#241710]/90 via-[#39251A]/85 to-[#241710]/90"></div>

        <div class="relative z-10">

            <p class="text-[11px] font-semibold uppercase tracking-[0.35em] text-[#D8BD9C]">
                Made Especially for You
            </p>

            <h2 class="mt-5 font-serif text-2xl font-bold text-white md:text-4xl">
                Your Perfect Outfit Starts Here
            </h2>

            <p class="mx-auto mt-4 max-w-xl text-sm leading-8 text-white/85">
                Temukan busana yang mencerminkan gaya dan kepribadianmu.
                Pilih koleksi favorit dan lengkapi pesananmu melalui
                sistem belanja Sya's Costura.
            </p>

            <a
                href="{{ route('katalog', ['collection' => $collection]) }}"
                class="mt-8 inline-block rounded-full bg-[#F1ECE3] px-8 py-3.5 text-sm font-semibold text-[#292522] transition hover:-translate-y-1 hover:bg-[#DED1BF]"
            >
                Jelajahi Koleksi
            </a>

        </div>

    </section>

</div>

@endsection
