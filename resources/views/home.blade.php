@extends('layouts.costura')

@section('content')

{{-- HERO SECTION --}}
<section class="overflow-hidden rounded-3xl bg-[#F5F1EA]">
    <div class="grid items-center gap-10 px-6 py-12 md:grid-cols-2 md:px-12 md:py-16">

        <div>
            <span class="inline-block rounded-full border border-[#C9B99F] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#665246]">
                Welcome to Sya's Costura
            </span>

            <h1 class="mt-7 font-serif text-4xl font-bold leading-tight text-[#292522] md:text-6xl">
                Jahit custom,
                <span class="text-[#A1876C]">sesuai gayamu.</span>
            </h1>

            <p class="mt-5 max-w-lg text-base leading-relaxed text-[#746B62] md:text-lg">
                Wujudkan pakaian impianmu bersama Sya's Costura.
                Pilih model, kain, dan ukuran sesuai keinginanmu.
                Setiap jahitan dibuat dengan perhatian pada detail dan kenyamanan.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/katalog"
                   class="rounded-full bg-[#292522] px-7 py-3 font-semibold text-white shadow-md transition duration-300 hover:-translate-y-1 hover:bg-[#665246]">
                    Lihat Katalog →
                </a>

                <a href="/booking"
                   class="rounded-full border border-[#A1876C] bg-white px-7 py-3 font-semibold text-[#665246] transition duration-300 hover:bg-[#EAE2D6]">
                    Booking Fitting
                </a>
            </div>

            <div class="mt-9 flex flex-wrap gap-x-6 gap-y-3 text-sm text-[#746B62]">
                <span>✦ Custom Design</span>
                <span>✦ Perfect Fit</span>
                <span>✦ Quality Stitch</span>
            </div>
        </div>

        {{-- HERO VISUAL --}}
        <div class="relative">
            <div class="relative flex min-h-[340px] items-center justify-center overflow-hidden rounded-3xl bg-gradient-to-br from-[#DED1BF] via-[#BBA58B] to-[#806B57] p-8 md:min-h-[430px]">

                <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full border border-white/30"></div>
                <div class="absolute -bottom-20 -left-16 h-64 w-64 rounded-full border border-white/30"></div>

                <div class="relative z-10 w-full max-w-sm rounded-2xl border border-white/60 bg-[#F7F4EE]/95 p-8 text-center shadow-2xl backdrop-blur-sm">

                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#806B57]">
                        The Art of Tailoring
                    </p>

                    <div class="my-6 flex items-center justify-center gap-3">
                        <div class="h-px w-10 bg-[#A1876C]"></div>
                        <span class="text-4xl text-[#806B57]">✂</span>
                        <div class="h-px w-10 bg-[#A1876C]"></div>
                    </div>

                    <h2 class="font-serif text-3xl font-bold text-[#292522]">
                        Made with Care
                    </h2>

                    <p class="mt-3 text-sm leading-relaxed text-[#746B62]">
                        Every Stitch Tells a Story
                    </p>

                    <div class="mx-auto mt-6 h-1 w-14 rounded-full bg-[#A1876C]"></div>

                    <p class="mt-5 text-xs font-semibold tracking-[0.25em] text-[#665246]">
                        SYA'S COSTURA
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- SERVICES SECTION --}}
<section class="mt-16">

    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#A1876C]">
                Our Collection
            </p>

            <h2 class="mt-2 font-serif text-3xl font-bold text-[#292522]">
                Layanan Pilihan
            </h2>

            <p class="mt-2 text-sm text-[#746B62]">
                Temukan pakaian yang sesuai dengan gaya dan kebutuhanmu.
            </p>
        </div>

        <a href="/katalog"
           class="rounded-full border border-[#C9B99F] px-5 py-2 text-sm font-semibold text-[#665246] transition hover:bg-[#F5F1EA]">
            Lihat Semua →
        </a>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($services as $service)
            @include('catalog._card', ['service' => $service])
        @endforeach
    </div>

</section>


{{-- TESTIMONIAL SECTION --}}
<section class="mt-20 rounded-3xl bg-[#F5F1EA] px-6 py-12 md:px-10">

    <div class="mx-auto mb-10 max-w-xl text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#A1876C]">
            Customer Stories
        </p>

        <h2 class="mt-3 font-serif text-3xl font-bold text-[#292522]">
            Kata Pelanggan
        </h2>

        <p class="mt-3 text-sm leading-relaxed text-[#746B62]">
            Cerita dan pengalaman pelanggan menjadi inspirasi
            kami untuk terus memberikan hasil jahitan terbaik.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

        @forelse ($testimonials as $t)

            <div class="rounded-2xl border border-[#E6DED2] bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                <div class="text-lg tracking-widest text-[#A1876C]">
                    {{ str_repeat('★', $t->rating) }}
                </div>

                <p class="mt-4 text-sm leading-relaxed text-[#746B62]">
                    "{{ $t->review }}"
                </p>

                <div class="mt-6 border-t border-[#EAE2D6] pt-4">
                    <p class="font-semibold text-[#292522]">
                        {{ $t->customer->user->name }}
                    </p>

                    <p class="mt-1 text-xs text-[#A1876C]">
                        Customer Sya's Costura
                    </p>
                </div>

            </div>

        @empty

            <div class="col-span-full rounded-2xl border border-[#E6DED2] bg-white p-8 text-center">
                <p class="text-sm text-[#746B62]">
                    Belum ada ulasan pelanggan.
                </p>
            </div>

        @endforelse

    </div>
</section>


{{-- CLOSING SECTION --}}
<section class="my-16 overflow-hidden rounded-3xl bg-[#292522] px-6 py-14 text-center text-white md:px-12">

    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C9B99F]">
        Your Style, Your Story
    </p>

    <h2 class="mt-4 font-serif text-3xl font-bold md:text-4xl">
        Let's Create Your Dream Outfit
    </h2>

    <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-white/75">
        Pakaian yang sempurna dimulai dari desain yang sesuai dengan dirimu.
        Percayakan kebutuhan jahitmu kepada Sya's Costura.
    </p>

    <a href="/katalog"
       class="mt-8 inline-block rounded-full bg-[#F5F1EA] px-8 py-3 font-semibold text-[#292522] transition hover:bg-[#DED1BF]">
        Mulai Pesananmu →
    </a>

</section>

@endsection
