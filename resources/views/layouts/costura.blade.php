<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Sya's Costura")</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brand: #b83a5e;
            --color-brand-dark: #2a1a1f;
            --color-blush: #fbf1ee;
            --font-sans: 'DM Sans', sans-serif;
            --font-serif: 'Fraunces', serif;
        }
    </style>
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="bg-blush text-brand-dark font-sans">

    <header class="bg-blush/90 backdrop-blur sticky top-0 z-40 border-b border-rose-100">
        <nav class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="font-serif text-xl font-bold text-brand">Sya's Costura</a>

            <div class="hidden md:flex items-center gap-1 text-sm">
                @php
                    $menu = [
                        ['Beranda', '/'],
                        ['Katalog', '/katalog'],
                        ['Booking', '/booking'],
                        ['Checkout', '/checkout/create'],
                        ['Tracking', '/tracking'],
                    ];
                @endphp
                @foreach ($menu as [$label, $url])
                    @php
                        $active = $url === '/' ? request()->is('/') : request()->is(trim($url, '/') . '*');
                    @endphp
                    <a href="{{ $url }}"
                       class="px-3 py-1.5 rounded-full {{ $active ? 'bg-rose-200 text-brand' : 'hover:bg-rose-100' }}">
                        {{ $label }}
                    </a>
                @endforeach
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="/admin" class="px-3 py-1.5 rounded-full hover:bg-rose-100">Admin</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-2 text-sm">
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="bg-brand-dark text-white px-4 py-1.5 rounded-full">
                            {{ auth()->user()->name }} ▾
                        </button>
                        <div x-show="open" @click.outside="open = false" x-cloak
                             class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow border border-rose-100 p-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-rose-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1.5 rounded-full border border-brand-dark">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-1.5 rounded-full bg-brand-dark text-white">Daftar</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 min-h-[70vh]">
        @if (session('success'))
            <div class="mb-4 rounded-xl bg-green-100 text-green-800 px-4 py-2">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-red-100 text-red-800 px-4 py-2">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-rose-100 py-6 text-center text-sm text-stone-500">
        Sya's Costura · Digital Atelier &amp; Fashion Custom Studio · Pekanbaru
    </footer>

    <x-whatsapp-popup />
</body>
</html>
