
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Sya's Costura")</title>

    {{-- ELEGANT TYPOGRAPHY --}}
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    {{-- TAILWIND --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- GLOBAL THEME --}}
    <style type="text/tailwindcss">
        @theme {
            --color-brand: #806B57;
            --color-brand-dark: #292522;
            --color-blush: #F7F4EE;
            --font-sans: 'DM Sans', sans-serif;
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
        }
    </style>
</head>

<body class="bg-[#F7F4EE] text-[#292522] font-sans">

    {{-- HEADER & NAVBAR --}}
    <header class="sticky top-0 z-40 border-b border-[#E6DED2] bg-[#F7F4EE]/95 backdrop-blur-md">

        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">

            {{-- LOGO --}}
            <a href="/"
               class="font-serif text-2xl font-bold tracking-wide text-[#665246] transition hover:text-[#A1876C]">
                Sya's <span class="text-[#A1876C]">Costura.</span>
            </a>

            {{-- MENU --}}
            <div class="hidden items-center gap-1 text-sm font-medium text-[#665246] md:flex">

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
                       class="rounded-full px-4 py-2 transition duration-300
                       {{ $active
                            ? 'bg-[#E6DED2] text-[#292522] font-semibold'
                            : 'text-[#665246] hover:bg-[#EDE7DE] hover:text-[#292522]' }}">
                        {{ $label }}
                    </a>

                @endforeach

                {{-- ADMIN MENU --}}
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="/admin"
                           class="rounded-full px-4 py-2 text-[#665246] transition hover:bg-[#EDE7DE]">
                            Admin
                        </a>
                    @endif
                @endauth

            </div>

            {{-- AUTHENTICATION --}}
            <div class="flex items-center gap-2 text-sm">

                @auth

                    <div x-data="{ open: false }" class="relative">

                        <button
                            @click="open = !open"
                            class="rounded-full bg-[#292522] px-5 py-2 font-medium text-white shadow-sm transition hover:bg-[#665246]">
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

                                <button
                                    class="w-full rounded-lg px-3 py-2 text-left text-[#665246] transition hover:bg-[#F5F1EA]">
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

    {{-- MAIN CONTENT --}}
    <main class="mx-auto min-h-[70vh] max-w-6xl px-4 py-8">

        {{-- SUCCESS NOTIFICATION --}}
        @if (session('success'))

            <div class="mb-5 rounded-xl border border-[#C5D8C0] bg-[#EDF4EA] px-5 py-3 text-sm font-medium text-[#42613D]">
                ✓ {{ session('success') }}
            </div>

        @endif

        {{-- ERROR NOTIFICATION --}}
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

    {{-- WHATSAPP POPUP --}}
    <x-whatsapp-popup />

</body>
</html>
