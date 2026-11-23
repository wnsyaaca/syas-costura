@extends('layouts.costura')

@section('title', 'Checkout - Sya\'s Costura')

@section('content')
@php
    $formatRupiah = fn ($amount) => 'Rp ' . number_format((float) $amount, 0, ',', '.');
    $dpAmount = $total * 0.5;
@endphp

<style>
    .checkout-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 48px 22px 80px;
        color: #342b25;
    }
    .checkout-heading {
        margin-bottom: 34px;
    }
    .checkout-heading small {
        color: #9a806b;
        letter-spacing: 3px;
        font-size: 11px;
        text-transform: uppercase;
    }
    .checkout-heading h1 {
        font-family: Georgia, serif;
        font-size: clamp(30px, 5vw, 42px);
        font-weight: 400;
        margin: 10px 0;
    }
    .checkout-heading p {
        color: #81766e;
        margin: 0;
        font-size: 14px;
    }
    .checkout-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(280px, .85fr);
        gap: 28px;
        align-items: start;
    }
    .checkout-panel {
        background: #fff;
        border: 1px solid #eee7df;
        border-radius: 12px;
        padding: 26px;
        margin-bottom: 22px;
    }
    .checkout-panel h2 {
        font-family: Georgia, serif;
        font-size: 23px;
        font-weight: 400;
        margin: 0 0 22px;
    }
    .checkout-field {
        margin-bottom: 18px;
    }
    .checkout-field label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .checkout-field input,
    .checkout-field textarea {
        width: 100%;
        border: 1px solid #ded5cc;
        border-radius: 7px;
        padding: 12px 13px;
        font: inherit;
        font-size: 14px;
        color: #342b25;
        background: #fff;
        outline: none;
    }
    .checkout-field input:focus,
    .checkout-field textarea:focus {
        border-color: #98775d;
        box-shadow: 0 0 0 2px rgba(152,119,93,.10);
    }
    .checkout-field textarea {
        min-height: 105px;
        resize: vertical;
    }
    .checkout-field small {
        display: block;
        margin-top: 6px;
        color: #8b8179;
        font-size: 12px;
    }
    .checkout-product {
        display: flex;
        gap: 15px;
        padding: 16px 0;
        border-bottom: 1px solid #eee8e2;
    }
    .checkout-product:first-of-type {
        padding-top: 0;
    }
    .checkout-product:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }
    .checkout-product img {
        width: 82px;
        height: 105px;
        object-fit: cover;
        border-radius: 7px;
        background: #f4f0eb;
        flex-shrink: 0;
    }
    .checkout-product-info {
        flex: 1;
        min-width: 0;
    }
    .checkout-product-info h3 {
        font-size: 15px;
        font-weight: 600;
        margin: 2px 0 7px;
    }
    .checkout-product-info p {
        color: #81766e;
        font-size: 12px;
        margin: 4px 0;
    }
    .checkout-product-price {
        font-size: 13px;
        font-weight: 600;
        margin-top: 9px;
    }
    .payment-option {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 15px;
        border: 1px solid #e5ddd5;
        border-radius: 8px;
        margin-bottom: 12px;
        cursor: pointer;
    }
    .payment-option:has(input:checked) {
        border-color: #98775d;
        background: #faf7f3;
    }
    .payment-option input {
        margin-top: 4px;
        accent-color: #76583f;
    }
    .payment-option strong {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .payment-option span {
        color: #81766e;
        font-size: 12px;
    }
    .checkout-summary {
        position: sticky;
        top: 24px;
    }
    .summary-line {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin: 15px 0;
        font-size: 14px;
        color: #756a61;
    }
    .summary-total {
        border-top: 1px solid #e9e1d9;
        padding-top: 18px;
        margin-top: 18px;
        color: #342b25;
        font-size: 17px;
        font-weight: 700;
    }
    .checkout-note {
        background: #f8f5f1;
        border-radius: 8px;
        padding: 13px;
        color: #76695e;
        font-size: 12px;
        line-height: 1.7;
        margin: 18px 0;
    }
    .checkout-submit {
        width: 100%;
        border: 0;
        border-radius: 7px;
        background: #594536;
        color: white;
        padding: 15px 18px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
    }
    .checkout-submit:hover {
        background: #403126;
    }
    .checkout-back {
        display: block;
        text-align: center;
        color: #806b58;
        text-decoration: none;
        font-size: 13px;
        margin-top: 16px;
    }
    .checkout-error {
        color: #a33b32;
        font-size: 12px;
        margin-top: 6px;
    }
    @media(max-width: 760px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
        .checkout-summary {
            position: static;
        }
        .checkout-panel {
            padding: 20px;
        }
    }
</style>

<div class="checkout-page">
    <div class="checkout-heading">
        <small>Sya's Costura</small>
        <h1>Checkout</h1>
        <p>Lengkapi informasi penerima untuk menyelesaikan pesanan online kamu.</p>
    </div>

    @if(session('error'))
        <div class="checkout-panel" style="color:#a33b32; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="checkout-panel" style="border-color:#e6c4bf; color:#a33b32;">
            <strong>Periksa kembali data berikut:</strong>
            <ul style="margin:10px 0 0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cart.checkout.store') }}" method="POST">
        @csrf

        <div class="checkout-layout">
            <div>
                <section class="checkout-panel">
                    <h2>Informasi Penerima</h2>

                    <div class="checkout-field">
                        <label for="recipient_name">Nama Penerima</label>
                        <input
                            type="text"
                            id="recipient_name"
                            name="recipient_name"
                            value="{{ old('recipient_name', $user->name ?? '') }}"
                            placeholder="Nama lengkap penerima"
                            required
                            maxlength="255"
                        >
                        @error('recipient_name')
                            <div class="checkout-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="checkout-field">
                        <label for="phone">Nomor WhatsApp / HP</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 08xxxxxxxxxx"
                            required
                            maxlength="20"
                        >
                        @error('phone')
                            <div class="checkout-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="checkout-field">
                        <label for="full_address">Alamat Lengkap</label>
                        <textarea
                            id="full_address"
                            name="full_address"
                            placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan patokan alamat"
                            required
                        >{{ old('full_address') }}</textarea>
                        @error('full_address')
                            <div class="checkout-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="checkout-field">
                        <label for="city">Kota / Kabupaten</label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city') }}"
                            placeholder="Kota atau kabupaten"
                            required
                            maxlength="255"
                        >
                        @error('city')
                            <div class="checkout-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="checkout-field" style="margin-bottom:0;">
                        <label for="postal_code">Kode Pos</label>
                        <input
                            type="text"
                            id="postal_code"
                            name="postal_code"
                            value="{{ old('postal_code') }}"
                            placeholder="Contoh: 28282"
                            required
                            maxlength="10"
                        >
                        @error('postal_code')
                            <div class="checkout-error">{{ $message }}</div>
                        @enderror
                    </div>
                </section>

                <section class="checkout-panel">
                    <h2>Metode Pembayaran</h2>

                    <label class="payment-option">
                        <input
                            type="radio"
                            name="payment_type"
                            value="dp"
                            {{ old('payment_type', 'dp') === 'dp' ? 'checked' : '' }}
                            required
                        >
                        <span>
                            <strong>DP 50%</strong>
                            Bayar uang muka {{ $formatRupiah($dpAmount) }} terlebih dahulu.
                        </span>
                    </label>

                    <label class="payment-option">
                        <input
                            type="radio"
                            name="payment_type"
                            value="full"
                            {{ old('payment_type') === 'full' ? 'checked' : '' }}
                            required
                        >
                        <span>
                            <strong>Bayar Lunas</strong>
                            Bayar seluruh total pesanan {{ $formatRupiah($total) }}.
                        </span>
                    </label>

                    @error('payment_type')
                        <div class="checkout-error">{{ $message }}</div>
                    @enderror

                    <div class="checkout-note">
                        Informasi rekening atau metode pembayaran akan dikonfirmasi oleh admin Sya's Costura setelah pesanan dibuat. Biaya pengiriman juga akan diinformasikan secara terpisah.
                    </div>
                </section>
            </div>

            <aside class="checkout-summary">
                <section class="checkout-panel">
                    <h2>Ringkasan Pesanan</h2>

                    @foreach($cartItems as $item)
                        @php
                            $image = $item['image'] ?? null;
                            $imageUrl = $image
                                ? (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')
                                    ? $image
                                    : asset('storage/' . ltrim($image, '/')))
                                : null;
                        @endphp

                        <div class="checkout-product">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $item['service']->name }}">
                            @else
                                <div style="width:82px;height:105px;border-radius:7px;background:#f4f0eb;display:flex;align-items:center;justify-content:center;color:#9b8b7d;font-size:11px;text-align:center;flex-shrink:0;">
                                    Sya's Costura
                                </div>
                            @endif

                            <div class="checkout-product-info">
                                <h3>{{ $item['service']->name }}</h3>

                                @if(!empty($item['color']))
                                    <p>Warna: {{ $item['color'] }}</p>
                                @endif

                                @if(!empty($item['size_label']))
                                    <p>Ukuran: {{ $item['size_label'] }}</p>
                                @endif

                                <p>Jumlah: {{ $item['quantity'] }}</p>

                                @if(!empty($item['custom_measurements']))
                                    <p>Ukuran custom telah diisi</p>
                                @endif

                                <div class="checkout-product-price">
                                    {{ $formatRupiah($item['line_total']) }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="summary-line">
                        <span>Jumlah produk</span>
                        <strong>{{ $totalItems }} item</strong>
                    </div>

                    <div class="summary-line">
                        <span>Subtotal</span>
                        <strong>{{ $formatRupiah($total) }}</strong>
                    </div>

                    <div class="summary-line summary-total">
                        <span>Total Pesanan</span>
                        <strong>{{ $formatRupiah($total) }}</strong>
                    </div>

                    <button type="submit" class="checkout-submit">
                        Buat Pesanan
                    </button>

                    <a href="{{ route('cart.index') }}" class="checkout-back">
                        ← Kembali ke Keranjang
                    </a>
                </section>
            </aside>
        </div>
    </form>
</div>
@endsection
