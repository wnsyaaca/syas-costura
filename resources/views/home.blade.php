@extends('layouts.costura')

@section('title', "Home - Sya's Costura")

@section('content')

@php
    $slides = [
        [
            'image' => 'https://images.pexels.com/photos/9853292/pexels-photo-9853292.jpeg?auto=compress&cs=tinysrgb&w=2200',
            'eyebrow' => "Sya's Costura Atelier",
            'title' => 'Elegance in Every Stitch',
            'description' => 'Temukan keindahan busana yang dirancang dengan detail, ketelitian, dan sentuhan personal.'
        ],
        [
            'image' => 'https://images.pexels.com/photos/9850078/pexels-photo-9850078.jpeg?auto=compress&cs=tinysrgb&w=2200',
            'eyebrow' => 'Made with Love',
            'title' => 'Crafted Just for You',
            'description' => 'Setiap jahitan memiliki cerita. Wujudkan busana impian bersama Sya’s Costura.'
        ],
        [
            'image' => 'https://images.pexels.com/photos/15791201/pexels-photo-15791201.jpeg?auto=compress&cs=tinysrgb&w=2200',
            'eyebrow' => 'Timeless Beauty',
            'title' => 'Your Style, Your Story',
            'description' => 'Rasakan pengalaman busana eksklusif yang mencerminkan karakter dan kepribadianmu.'
        ],
    ];
@endphp

<style>
    :root {
        --costura-brown: #80664f;
        --costura-dark: #44372d;
        --costura-beige: #eee5da;
        --costura-cream: #faf8f4;
    }

    .costura-home {
        color: var(--costura-dark);
        width: 100%;
        min-width: 0;
        overflow-x: clip;
    }

    .costura-section {
        padding: 75px 24px;
    }

    .costura-eyebrow {
        color: var(--costura-brown);
        text-transform: uppercase;
        letter-spacing: .28em;
        font-size: 11px;
        font-weight: 600;
    }

    .costura-heading {
        font-family: Georgia, serif;
        color: var(--costura-dark);
        font-size: clamp(30px, 4vw, 45px);
        line-height: 1.2;
    }

    /* HERO SLIDESHOW */
    .hero-wrapper {
        padding: 22px 24px 0;
    }

    .hero-slider {
        position: relative;
        height: min(650px, 75vh);
        min-height: 470px;
        overflow: hidden;
        border-radius: 34px;
        isolation: isolate;
        background: #b9a58f;
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        visibility: hidden;
        transition: opacity .9s ease, visibility .9s ease;
    }

    .hero-slide.active {
        opacity: 1;
        visibility: visible;
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        border-radius: inherit;
        transform: scale(1.02);
        transition: transform 6s ease;
    }

    .hero-slide.active img {
        transform: scale(1.08);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(
            90deg,
            rgba(34, 27, 22, .68) 0%,
            rgba(34, 27, 22, .35) 48%,
            rgba(34, 27, 22, .08) 100%
        );
    }

    .hero-content {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 9%;
        transform: translateY(-50%);
        max-width: 590px;
        color: white;
        padding: 20px;
    }

    .hero-content .eyebrow {
        color: #ead9c5;
        font-size: 11px;
        letter-spacing: .35em;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    .hero-content h1 {
        font-family: Georgia, serif;
        font-size: clamp(42px, 6vw, 76px);
        line-height: 1.08;
        font-weight: 400;
        margin-bottom: 22px;
    }

    .hero-content p {
        color: rgba(255,255,255,.88);
        font-size: 15px;
        line-height: 1.9;
        max-width: 450px;
        margin-bottom: 30px;
    }

    .hero-button {
        display: inline-block;
        background: #f5eee5;
        color: #4b3c30;
        padding: 15px 30px;
        border-radius: 999px;
        font-size: 11px;
        letter-spacing: .15em;
        text-transform: uppercase;
        font-weight: 600;
        transition: .3s ease;
    }

    .hero-button:hover {
        background: white;
        transform: translateY(-3px);
    }

    .hero-arrow {
        position: absolute;
        z-index: 5;
        top: 50%;
        transform: translateY(-50%);
        width: 43px;
        height: 43px;
        border: 1px solid rgba(255,255,255,.65);
        border-radius: 50%;
        color: white;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(8px);
        cursor: pointer;
        font-size: 22px;
        transition: .3s;
    }

    .hero-arrow:hover {
        background: white;
        color: var(--costura-dark);
    }

    .hero-prev { left: 22px; }
    .hero-next { right: 22px; }

    .hero-dots {
        position: absolute;
        z-index: 5;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 9px;
    }

    .hero-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: 0;
        background: rgba(255,255,255,.55);
        cursor: pointer;
        transition: .3s;
    }

    .hero-dot.active {
        width: 25px;
        border-radius: 20px;
        background: white;
    }

    /* INTRO */
    .intro-section {
        text-align: center;
        max-width: 850px;
        margin: auto;
        padding: 85px 24px 65px;
    }

    .intro-section h2 {
        font-family: Georgia, serif;
        font-size: clamp(30px, 4vw, 43px);
        font-weight: 400;
        line-height: 1.3;
        margin: 18px 0;
    }

    .intro-section p {
        color: #81766b;
        font-size: 14px;
        line-height: 2;
    }

    /* HOW TO ORDER */
    .how-section {
        background: var(--costura-cream);
    }

    .how-card {
        height: 100%;
        padding: 32px 25px;
        border: 1px solid #e9dfd3;
        border-radius: 24px;
        background: white;
        transition: .3s ease;
    }

    .how-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(80, 60, 40, .08);
    }

    .how-number {
        font-family: Georgia, serif;
        font-size: 35px;
        color: #b39b82;
        margin-bottom: 18px;
    }

    .how-card h3 {
        font-family: Georgia, serif;
        font-size: 21px;
        margin-bottom: 12px;
    }

    .how-card p {
        font-size: 13px;
        line-height: 1.8;
        color: #81766b;
    }

    /* HOW TO ORDER - ACTION BUTTONS */
    .how-card .costura-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;

        padding: 13px 24px;
        border-radius: 999px;

        background: #80664f;
        color: #fffaf4;

        font-size: 11px;
        font-weight: 600;
        letter-spacing: .10em;
        text-transform: uppercase;
        text-decoration: none;

        cursor: pointer;
        transition: all .3s ease;
        box-shadow: 0 5px 14px rgba(80, 60, 40, .12);
    }

    .how-card .costura-button:hover {
        background: #594635;
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 9px 20px rgba(80, 60, 40, .20);
    }

    .how-card .costura-button span {
        font-size: 17px;
        transition: transform .3s ease;
    }

    .how-card .costura-button:hover span {
        transform: translateX(4px);
    }

    .how-card .costura-button:focus-visible {
        outline: 3px solid #b99a79;
        outline-offset: 4px;
    }

    /* HOME CATALOG */
    .home-catalog-section {
        padding-top: 85px;
        padding-bottom: 85px;
        scroll-margin-top: 100px;
    }

    .home-catalog-heading {
        margin-bottom: 36px;
        gap: 18px;
    }

    .home-catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        align-items: stretch;
        justify-items: stretch;
        gap: 24px;
        width: 100%;
    }

    .home-catalog-grid > .home-catalog-item {
        width: 100%;
        min-width: 0;
        height: 100%;
    }

    /* ABOUT */
    .about-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 32px;
        display: block;
    }

    .about-copy {
        font-size: 14px;
        line-height: 2;
        color: #81766b;
    }

    /* TESTIMONIALS */
    .testimonial-card {
        height: 100%;
        padding: 32px;
        border-radius: 25px;
        border: 1px solid #e9dfd3;
        background: #fff;
    }

    .testimonial-stars {
        color: #ad8c60;
        letter-spacing: 4px;
        margin-bottom: 18px;
    }

    .testimonial-card p {
        color: #766b61;
        font-size: 14px;
        line-height: 1.9;
        font-style: italic;
    }

    .testimonial-card h4 {
        font-family: Georgia, serif;
        margin-top: 20px;
        font-size: 18px;
    }

    /* CLOSING CTA */
    .closing-section {
        position: relative;
        isolation: isolate;
        overflow: hidden;

        margin: 20px 24px 75px;
        padding: 75px 25px;
        text-align: center;

        background: #d9bfa3;
        border-radius: 34px;
    }

    .closing-section::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;

        background:
            linear-gradient(
                135deg,
                rgba(218, 185, 150, .66) 0%,
                rgba(235, 207, 174, .69) 50%,
                rgba(199, 161, 125, .73) 100%
            ),
            url('https://images.pexels.com/photos/7147649/pexels-photo-7147649.jpeg?auto=compress&cs=tinysrgb&w=2000')
            center center / cover no-repeat;

        filter: saturate(1.16) sepia(.10);
        transform: scale(1.01);
    }

    .closing-section .costura-eyebrow {
        position: relative;
        color: #705039;
    }

    .closing-section h2 {
        position: relative;
        font-family: Georgia, serif;
        color: #443125;
        font-size: clamp(30px, 4vw, 45px);
        line-height: 1.25;
        margin: 15px auto;
        max-width: 650px;
    }

    .closing-section p {
        position: relative;
        color: #654d3b;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .closing-section .costura-button {
        position: relative;
        display: inline-block;
        background: #75543b;
        color: #fffaf4;
        padding: 14px 28px;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: 11px;
        font-weight: 600;
        transition: .3s;
    }

    .closing-section .costura-button:hover {
        background: #59402f;
        color: white;
        transform: translateY(-3px);
    }

    /* TABLET */
    @media (max-width: 1023px) {
        .home-catalog-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .hero-wrapper {
            padding: 12px 12px 0;
        }

        .hero-slider {
            min-height: 530px;
            height: 70vh;
            border-radius: 24px;
        }

        .hero-content {
            left: 5%;
            right: 5%;
            padding: 10px;
        }

        .hero-content h1 {
            font-size: 43px;
        }

        .hero-content p {
            font-size: 13px;
        }

        .hero-prev { left: 12px; }
        .hero-next { right: 12px; }

        .costura-section {
            padding: 65px 18px;
        }

        .home-catalog-section {
            padding-top: 70px;
            padding-bottom: 70px;
        }

        .home-catalog-heading {
            margin-bottom: 28px;
        }

        .about-image {
            height: 360px;
            border-radius: 25px;
        }

        .closing-section {
            margin: 10px 12px 45px;
            border-radius: 25px;
        }
    }

    @media (max-width: 560px) {
        .home-catalog-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 22px;
        }
    }
</style>

<div class="costura-home">

    {{-- HERO SLIDESHOW --}}
    <section class="hero-wrapper">
        <div class="hero-slider" id="costuraHero">

            @foreach($slides as $index => $slide)
                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ $slide['image'] }}"
                         alt="Sya's Costura fashion collection"
                         fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}">

                    <div class="hero-overlay"></div>

                    <div class="hero-content">
                        <div class="eyebrow">{{ $slide['eyebrow'] }}</div>
                        <h1>{{ $slide['title'] }}</h1>
                        <p>{{ $slide['description'] }}</p>

                        <a href="{{ route('katalog') }}" class="hero-button">
                            Explore Collection
                        </a>
                    </div>
                </div>
            @endforeach

            <button type="button" class="hero-arrow hero-prev" aria-label="Previous slide">
                &#8249;
            </button>

            <button type="button" class="hero-arrow hero-next" aria-label="Next slide">
                &#8250;
            </button>

            <div class="hero-dots">
                @foreach($slides as $index => $slide)
                    <button type="button"
                            class="hero-dot {{ $index === 0 ? 'active' : '' }}"
                            aria-label="Go to slide {{ $index + 1 }}">
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- INTRODUCTION --}}
    <section class="intro-section">
        <span class="costura-eyebrow">Welcome to Sya's Costura</span>

        <h2>Where Every Stitch Tells a Story</h2>

        <p>
            Sya's Costura hadir untuk membantu setiap perempuan menemukan
            keindahan dalam busana yang dibuat dengan penuh ketelitian.
            Dari pemilihan bahan hingga detail jahitan, setiap proses
            dirancang untuk menghadirkan karya yang istimewa.
        </p>
    </section>

    {{-- HOW TO ORDER --}}
    <section class="costura-section how-section">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-12">
                <span class="costura-eyebrow">Our Process</span>
                <h2 class="costura-heading mt-3">How To Order</h2>
                <p class="text-sm text-stone-500 mt-3">
                    Dua cara mudah untuk mendapatkan busana impianmu.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- CARD 01 --}}
                <div class="how-card">
                    <div class="how-number">01</div>

                    <h3>Fitting Appointment</h3>

                    <p>
                        Datang langsung ke atelier kami untuk konsultasi,
                        pengukuran badan, dan menentukan desain busana
                        yang sesuai dengan keinginanmu.
                    </p>

                    <a href="{{ route('booking.index') }}"
                       class="costura-button mt-5">
                        Book Appointment
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                {{-- CARD 02 --}}
                <div class="how-card">
                    <div class="how-number">02</div>

                    <h3>Order Online</h3>

                    <p>
                        Tidak bisa datang ke atelier? Kamu tetap bisa
                        memesan dari mana saja dengan mengisi detail
                        pesanan dan ukuran secara online.
                    </p>

                    <a href="{{ route('katalog') }}"
                       class="costura-button mt-5">
                        Shop Online
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- CATALOG --}}
    <section class="costura-section home-catalog-section">
        <div class="max-w-6xl mx-auto">

            <div class="home-catalog-heading flex flex-col md:flex-row md:items-end md:justify-between">

                <div>
                    <span class="costura-eyebrow">Our Collection</span>
                    <h2 class="costura-heading mt-3">Discover Our Catalog</h2>
                    <p class="text-sm text-stone-500 mt-3">
                        Temukan layanan jahit yang sesuai dengan gayamu.
                    </p>
                </div>

                <a href="{{ route('katalog') }}"
                   class="text-sm font-semibold text-[#80664f] hover:underline">
                    View All Collection →
                </a>
            </div>

            @if(isset($services) && $services->count())
                <div class="home-catalog-grid">
                    @foreach($services as $service)
                        <div class="home-catalog-item">
                            @include('catalog._card', ['service' => $service])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-[#faf8f4] rounded-3xl">
                    <p class="text-stone-500">
                        Koleksi kami sedang dipersiapkan.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- ABOUT US --}}
    <section class="costura-section bg-[#faf8f4]">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div>
                <img
                    src="https://images.pexels.com/photos/7147963/pexels-photo-7147963.jpeg?auto=compress&cs=tinysrgb&w=1400"
                    alt="Craftsmanship at Sya's Costura"
                    class="about-image"
                    loading="lazy">
            </div>

            <div>
                <span class="costura-eyebrow">Our Story</span>

                <h2 class="costura-heading mt-4 mb-6">
                    About Sya's Costura
                </h2>

                <p class="about-copy mb-5">
                    Sya's Costura merupakan atelier yang mengutamakan
                    kualitas, kenyamanan, dan keindahan dalam setiap
                    busana yang diciptakan.
                </p>

                <p class="about-copy mb-7">
                    Kami percaya bahwa setiap orang memiliki cerita
                    dan karakter tersendiri. Karena itu, setiap karya
                    dibuat dengan perhatian pada detail agar terasa
                    lebih personal dan istimewa.
                </p>

                <a href="{{ route('katalog') }}" class="costura-button">
                    Discover More
                </a>
            </div>

        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="costura-section">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-12">
                <span class="costura-eyebrow">Kind Words</span>
                <h2 class="costura-heading mt-3">Testimonials</h2>
                <p class="text-sm text-stone-500 mt-3">
                    Cerita dan pengalaman pelanggan Sya's Costura.
                </p>
            </div>

            @if(isset($testimonials) && $testimonials->count())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($testimonials as $t)
                        <div class="testimonial-card">
                            <div class="testimonial-stars">★★★★★</div>

                            <p>
                                “{{ $t->message }}”
                            </p>

                            <h4>
                                {{ $t->customer->user->name ?? 'Customer Sya’s Costura' }}
                            </h4>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-[#faf8f4] rounded-3xl">
                    <p class="text-stone-500 text-sm">
                        Testimonials pelanggan akan ditampilkan di sini.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- CLOSING CTA --}}
    <section class="closing-section">
        <span class="costura-eyebrow">Your Dream Outfit Awaits</span>

        <h2>Let's Create Something Beautiful Together</h2>

        <p>
            Mulai perjalananmu untuk memiliki busana yang dibuat
            khusus sesuai keinginan dan gayamu.
        </p>

        <a href="{{ route('katalog') }}" class="costura-button">
            Start Your Order
        </a>
    </section>

</div>

{{-- HERO SLIDESHOW SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const hero = document.getElementById('costuraHero');

    if (!hero) return;

    const slides = hero.querySelectorAll('.hero-slide');
    const dots = hero.querySelectorAll('.hero-dot');
    const prev = hero.querySelector('.hero-prev');
    const next = hero.querySelector('.hero-next');

    let current = 0;
    let interval;

    function showSlide(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');

        current = (index + slides.length) % slides.length;

        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function startAutoSlide() {
        clearInterval(interval);
        interval = setInterval(function () {
            showSlide(current + 1);
        }, 5000);
    }

    prev.addEventListener('click', function () {
        showSlide(current - 1);
        startAutoSlide();
    });

    next.addEventListener('click', function () {
        showSlide(current + 1);
        startAutoSlide();
    });

    dots.forEach(function (dot, index) {
        dot.addEventListener('click', function () {
            showSlide(index);
            startAutoSlide();
        });
    });

    let touchStartX = 0;

    hero.addEventListener('touchstart', function (event) {
        touchStartX = event.changedTouches[0].screenX;
    }, { passive: true });

    hero.addEventListener('touchend', function (event) {
        const touchEndX = event.changedTouches[0].screenX;
        const difference = touchStartX - touchEndX;

        if (Math.abs(difference) > 50) {
            showSlide(current + (difference > 0 ? 1 : -1));
            startAutoSlide();
        }
    }, { passive: true });

    startAutoSlide();
});
</script>

@endsection
