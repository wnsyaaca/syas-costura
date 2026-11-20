<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Sya's Costura")</title>

    {{-- FONT MONTSERRAT UNTUK BODY UMUM --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- TAILWIND --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- GLOBAL THEME --}}
    <style type="text/tailwindcss">
        @theme {
            --color-brand: #806B57;
            --color-brand-dark: #292522;
            --color-blush: #F7F4EE;
            --font-sans: 'Montserrat', sans-serif;
            --font-serif: 'Playfair Display', serif;
        }
    </style>

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #F7F4EE;
            font-family: 'Montserrat', sans-serif;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT NAVBAR - TETAP DIPERTAHANKAN
        |--------------------------------------------------------------------------
        */

        .costura-navbar,
        .costura-navbar a,
        .costura-navbar button {
            font-family: 'Cormorant Garamond', Georgia, serif !important;
        }

        .costura-logo {
            font-family: 'Cormorant Garamond', Georgia, serif !important;
            font-size: 1.9rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            line-height: 1;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | NAVBAR SPACING
        |--------------------------------------------------------------------------
        */

        .costura-nav {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
            align-items: center;
            column-gap: 1.25rem;
            min-height: 42px;
        }

        .costura-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.2rem;
            white-space: nowrap;
        }

        .costura-menu a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 0.35rem 0.7rem;
            border-radius: 9999px;
            font-size: 1.12rem;
            font-weight: 500;
            letter-spacing: 0.015em;
            line-height: 1;
            white-space: nowrap;
        }

        .costura-account {
            justify-self: end;
            font-size: 1.05rem;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (min-width: 768px) and (max-width: 1023px) {
            .costura-nav {
                column-gap: 0.5rem;
            }

            .costura-logo {
                font-size: 1.65rem;
            }

            .costura-menu {
                gap: 0.05rem;
            }

            .costura-menu a {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                font-size: 1rem;
            }

            .costura-account button {
                padding-left: 0.85rem;
                padding-right: 0.85rem;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 767px) {
            .costura-nav {
                grid-template-columns: minmax(0, 1fr) auto;
                column-gap: 0.75rem;
                min-height: 38px;
            }

            .costura-logo {
                font-size: 1.65rem;
            }

            .costura-account {
                justify-self: end;
            }

            .costura-account button {
                padding: 0.5rem 0.85rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body class="bg-[#F7F4EE] text-[#292522] font-sans">

    {{-- NAVBAR --}}
    <header class="costura-navbar sticky top-0 z-40 border-b border-[#E6DED2] bg-[#F7F4EE]/95 backdrop-blur-md">

        <nav class="costura-nav mx-auto max-w-6xl px-4 py-3 md:py-3.5">

            {{-- LOGO --}}
            <a href="{{ route('home') }}"
               class="costura-logo text-[#665246] transition hover:text-[#A1876C]">
                Sya's <span class="text-[#A1876C]">Costura.</span>
            </a>

            {{-- MENU NAVIGASI --}}
            <div class="costura-menu hidden text-[#665246] md:flex">

                @php
                    $menu = [
                        ['Beranda', route('home')],
                        ['Katalog', route('katalog')],
                        ['Booking', route('booking.index')],
                        ['Checkout', route('checkout.index')],
                        ['Tracking', route('tracking.index')],
                    ];
                @endphp

                @foreach ($menu as [$label, $url])
                    @php
                        $active = $label === 'Beranda'
                            ? request()->routeIs('home')
                            : request()->is(trim(parse_url($url, PHP_URL_PATH), '/') . '*');
                    @endphp

                    <a href="{{ $url }}"
                       class="transition duration-300
                       {{ $active
                            ? 'bg-[#E6DED2] text-[#292522] font-semibold'
                            : 'text-[#665246] hover:bg-[#EDE7DE] hover:text-[#292522]' }}">
                        {{ $label }}
                    </a>
                @endforeach

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="/admin"
                           class="text-[#665246] transition hover:bg-[#EDE7DE]">
                            Admin
                        </a>
                    @endif
                @endauth

            </div>

            {{-- TOMBOL AKUN --}}
            <div class="costura-account flex items-center gap-2">

                @auth
                    <div x-data="{ open: false }" class="relative">

                        <button
                            @click="open = !open"
                            class="rounded-full bg-[#292522] px-5 py-2 font-semibold text-white shadow-sm transition hover:bg-[#665246]">
                            {{ auth()->user()->name }} ▾
                        </button>

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-cloak
                            x-transition
                            class="absolute right-0 mt-3 w-44 rounded-xl border border-[#E6DED2] bg-white p-2 shadow-xl">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button class="w-full rounded-lg px-3 py-2 text-left text-[#665246] transition hover:bg-[#F5F1EA]">
                                    Keluar
                                </button>
                            </form>

                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-full border border-[#A1876C] px-5 py-2 font-semibold text-[#665246] transition hover:bg-[#EDE7DE]">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-full bg-[#292522] px-5 py-2 font-semibold text-white transition hover:bg-[#665246]">
                        Daftar
                    </a>
                @endauth

            </div>

        </nav>
    </header>

    {{-- KONTEN HALAMAN --}}
    <main class="mx-auto min-h-[70vh] max-w-6xl px-4 py-8">

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-[#C5D8C0] bg-[#EDF4EA] px-5 py-3 text-sm font-medium text-[#42613D]">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-[#E5C6BE] bg-[#F8ECE8] px-5 py-3 text-sm text-[#914C40]">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')

    </main>

    {{-- FOOTER --}}
    <footer class="mt-12 border-t border-[#E6DED2] bg-[#F1ECE3]">

        <div class="mx-auto max-w-6xl px-4 py-10">

            <div class="text-center">

                <h2 class="font-serif text-2xl font-bold tracking-wide text-[#665246]">
                    Sya's Costura.
                </h2>

                <p class="mt-3 text-sm text-[#746B62]">
                    The Art of Tailoring, Made Just for You.
                </p>

                <div class="mx-auto my-5 h-px w-16 bg-[#A1876C]"></div>

                <p class="text-xs tracking-wide text-[#81766B]">
                    Digital Atelier &amp; Fashion Custom Studio
                </p>

                <p class="mt-2 text-xs text-[#81766B]">
                    Pekanbaru · Indonesia
                </p>

                <p class="mt-6 text-xs text-[#9A8D80]">
                    © {{ date('Y') }} Sya's Costura. All Rights Reserved.
                </p>

            </div>

        </div>
    </footer>

    <x-whatsapp-popup />

</body>
</html>
