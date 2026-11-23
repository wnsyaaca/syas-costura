@extends('layouts.costura')

@section('title', 'Keranjang Belanja - Sya\'s Costura')

@section('content')

<div class="mx-auto max-w-5xl">

    <div class="mb-8">
        <a href="{{ route('katalog') }}" class="text-sm text-[#806B57] hover:underline">
            ← Kembali ke katalog
        </a>

        <p class="mt-5 text-xs uppercase tracking-[0.3em] text-[#A1876C]">
            Your Shopping Bag
        </p>

        <h1 class="mt-2 font-serif text-4xl text-[#292522]">
            Keranjang Belanja
        </h1>

        <p class="mt-2 text-sm text-[#81766B]">
            Periksa kembali pilihan busana sebelum melanjutkan pemesanan.
        </p>
    </div>

    @if (empty($cart))

        <div class="rounded-2xl border border-[#E6DED2] bg-white px-6 py-16 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#F1ECE3] text-2xl text-[#806B57]">
                ♡
            </div>

            <h2 class="mt-5 font-serif text-2xl text-[#292522]">
                Keranjangmu masih kosong
            </h2>

            <p class="mt-2 text-sm text-[#81766B]">
                Yuk, temukan busana yang sesuai dengan gayamu.
            </p>

            <a href="{{ route('katalog') }}"
               class="mt-7 inline-flex rounded-xl bg-[#665246] px-7 py-3 text-xs font-semibold uppercase tracking-[0.15em] text-white transition hover:bg-[#49392F]">
                Jelajahi Katalog
            </a>
        </div>

    @else

        <div class="grid gap-7 lg:grid-cols-[1fr_320px]">

            <div class="space-y-4">

                @foreach ($cart as $key => $item)

                    <div class="rounded-2xl border border-[#E6DED2] bg-white p-4 sm:p-5">

                        <div class="flex flex-col gap-5 sm:flex-row">

                            <div class="h-36 w-full shrink-0 overflow-hidden rounded-xl bg-[#F1ECE3] sm:w-32">
                                @if (!empty($item['image']))
                                    <img
                                        src="{{ $item['image'] }}"
                                        alt="{{ $item['name'] }}"
                                        class="h-full w-full object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="hidden h-full w-full items-center justify-center text-xs text-[#81766B]">
                                        Foto belum tersedia
                                    </div>
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xs text-[#81766B]">
                                        Foto belum tersedia
                                    </div>
                                @endif
                            </div>

                            <div class="flex min-w-0 flex-1 flex-col">

                                <div class="flex flex-wrap items-start justify-between gap-3">

                                    <div>
                                        <h2 class="font-serif text-xl font-semibold text-[#292522]">
                                            {{ $item['name'] }}
                                        </h2>

                                        <p class="mt-1 text-sm font-semibold text-[#806B57]">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <p class="text-sm font-semibold text-[#292522]">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </p>

                                </div>

                                <div class="mt-3 space-y-1 text-xs text-[#81766B]">

                                    <p>
                                        Warna:
                                        {{ $item['color'] ?: 'Belum dipilih' }}
                                    </p>

                                    <p>
                                        Ukuran:
                                        {{ $item['size_label'] ?? '-' }}
                                    </p>

                                    @if (($item['size_type'] ?? '') === 'custom' && !empty($item['custom_measurements']))
                                        <p class="pt-1 font-semibold text-[#806B57]">
                                            Ukuran custom
                                        </p>

                                        @foreach ($item['custom_measurements'] as $field => $value)
                                            <span class="mr-2">
                                                {{ ucfirst($field) }}: {{ $value }} cm
                                            </span>
                                        @endforeach
                                    @endif

                                </div>

                                <div class="mt-auto flex flex-wrap items-end justify-between gap-4 pt-5">

                                    <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-end gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <div>
                                            <label class="mb-1 block text-[10px] uppercase tracking-wider text-[#81766B]">
                                                Jumlah
                                            </label>

                                            <input
                                                type="number"
                                                name="quantity"
                                                min="1"
                                                max="20"
                                                value="{{ $item['quantity'] }}"
                                                class="w-20 rounded-lg border border-[#D9CFC2] px-3 py-2 text-sm outline-none focus:border-[#806B57]"
                                                required
                                            >
                                        </div>

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-[#806B57] px-3 py-2 text-xs font-semibold text-[#665246] transition hover:bg-[#F1ECE3]">
                                            Perbarui
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.destroy', $key) }}" method="POST"
                                          onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-xs font-semibold text-[#A15D50] hover:underline">
                                            Hapus produk
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>

            <aside class="h-fit rounded-2xl border border-[#E6DED2] bg-white p-6">

                <h2 class="font-serif text-2xl text-[#292522]">
                    Ringkasan Belanja
                </h2>

                <div class="my-5 border-t border-[#E6DED2]"></div>

                <div class="flex justify-between text-sm text-[#81766B]">
                    <span>Total item</span>
                    <span>{{ $totalItems }} produk</span>
                </div>

                <div class="mt-4 flex justify-between gap-3 text-sm">
                    <span class="text-[#81766B]">Subtotal</span>
                    <span class="font-semibold text-[#292522]">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>

                <div class="my-5 border-t border-[#E6DED2]"></div>

                <div class="flex justify-between gap-3">
                    <span class="font-semibold text-[#292522]">Total</span>
                    <span class="font-bold text-[#665246]">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>

                <p class="mt-5 rounded-xl bg-[#F7F4EE] p-3 text-xs leading-relaxed text-[#81766B]">
                    Biaya pengiriman dan detail pembayaran akan dikonfirmasi pada tahap pemesanan.
                </p>

                {{-- TOMBOL CHECKOUT --}}
                <a href="{{ route('cart.checkout') }}"
                   class="mt-5 flex w-full justify-center rounded-xl bg-[#80664f] px-5 py-3 text-xs font-semibold uppercase tracking-[0.12em] text-white transition hover:bg-[#66503d]">
                    Lanjut ke Checkout
                </a>

                {{-- TOMBOL LANJUT BELANJA --}}
                <a href="{{ route('katalog') }}"
                   class="mt-3 flex w-full justify-center rounded-xl border border-[#665246] px-5 py-3 text-xs font-semibold uppercase tracking-[0.12em] text-[#665246] transition hover:bg-[#F7F4EE]">
                    Lanjut Belanja
                </a>

            </aside>

        </div>

    @endif

</div>

@endsection
