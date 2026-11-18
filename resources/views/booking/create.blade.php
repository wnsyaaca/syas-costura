@extends('layouts.costura')

@section('title', 'Pemesanan Online - Sya\'s Costura')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-12">

    {{-- HEADER --}}
    <div class="text-center mb-10">
        <p class="uppercase tracking-[0.3em] text-sm text-[#A1876C]">
            Sya's Costura Atelier
        </p>

        <h1 class="font-serif text-4xl text-[#292522] mt-3">
            Form Pemesanan Online
        </h1>

        <p class="text-stone-500 mt-3">
            Lengkapi detail pesanan jahit sesuai kebutuhanmu.
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-[#E6DED2] p-6 md:p-10">

        {{-- LAYANAN --}}
        <div class="bg-[#F7F4EE] rounded-2xl p-5 mb-8">
            <p class="text-sm text-[#A1876C] uppercase tracking-widest">
                Layanan yang dipilih
            </p>

            <h2 class="font-serif text-2xl text-[#292522] mt-2">
                {{ $service->name }}
            </h2>

            <p class="text-[#806B57] font-semibold mt-2">
                Rp {{ number_format($service->price, 0, ',', '.') }}
            </p>
        </div>

        {{-- VALIDATION ERROR --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
                <p class="font-semibold mb-2">
                    Periksa kembali data berikut:
                </p>

                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('checkout.store', $service->id) }}"
              class="space-y-8">

            @csrf

            {{-- 01 INFORMASI PELANGGAN --}}
            <section>
                <h3 class="font-serif text-xl text-[#292522] mb-5">
                    01. Informasi Pelanggan
                </h3>

                <label class="block text-sm font-medium mb-2">
                    Nomor WhatsApp
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', auth()->user()->customer->phone ?? '') }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                    required
                >
            </section>

            {{-- 02 METODE PENERIMAAN --}}
            <section>
                <h3 class="font-serif text-xl text-[#292522] mb-5">
                    02. Metode Penerimaan
                </h3>

                <select
                    name="fulfillment_type"
                    id="fulfillment_type"
                    class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                    required
                >
                    <option value="pickup"
                        @selected(old('fulfillment_type', 'pickup') == 'pickup')>
                        Pickup / Ambil di toko
                    </option>

                    <option value="delivery"
                        @selected(old('fulfillment_type') == 'delivery')>
                        Delivery / Dikirim ke alamat
                    </option>
                </select>

                <p class="text-xs text-stone-500 mt-2">
                    Pilih apakah pesanan akan diambil langsung di toko atau dikirim ke alamatmu.
                </p>

                {{-- JADWAL PICKUP --}}
                <div
                    id="pickup_fields"
                    class="mt-6 bg-[#F7F4EE] rounded-2xl p-5 space-y-4"
                >
                    <div>
                        <h4 class="font-semibold text-[#292522]">
                            Jadwal Pengambilan
                        </h4>

                        <p class="text-sm text-stone-500 mt-1">
                            Pilih jadwal untuk mengambil pesanan yang sudah selesai di toko.
                            Jadwal ini bukan jadwal fitting.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tanggal Pengambilan
                            </label>

                            <input
                                type="date"
                                name="booking_date"
                                id="booking_date"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('booking_date') }}"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Jam Pengambilan
                            </label>

                            <select
                                name="time_slot"
                                id="time_slot"
                                class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                                required
                            >
                                <option value="">Pilih jam</option>

                                @foreach (['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] as $time)
                                    <option value="{{ $time }}"
                                        @selected(old('time_slot') == $time)>
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- ALAMAT DELIVERY --}}
                <div
                    id="delivery_fields"
                    class="mt-6 space-y-4"
                    style="{{ old('fulfillment_type') == 'delivery' ? '' : 'display:none' }}"
                >
                    <div class="bg-[#F7F4EE] rounded-2xl p-5">
                        <h4 class="font-semibold text-[#292522] mb-1">
                            Alamat Pengiriman
                        </h4>

                        <p class="text-sm text-stone-500">
                            Isi alamat lengkap agar pesanan dapat dikirim dengan benar.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Nama Penerima
                        </label>

                        <input
                            type="text"
                            name="recipient_name"
                            id="recipient_name"
                            value="{{ old('recipient_name') }}"
                            placeholder="Nama penerima"
                            class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Alamat Lengkap
                        </label>

                        <textarea
                            name="full_address"
                            id="full_address"
                            rows="3"
                            placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, dan detail alamat lainnya"
                            class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                        >{{ old('full_address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Kota
                        </label>

                        <input
                            type="text"
                            name="city"
                            id="city"
                            value="{{ old('city') }}"
                            placeholder="Kota atau kabupaten"
                            class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Kode Pos
                        </label>

                        <input
                            type="text"
                            name="postal_code"
                            id="postal_code"
                            value="{{ old('postal_code') }}"
                            placeholder="Kode pos"
                            class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                        >
                    </div>
                </div>
            </section>

            {{-- 03 DETAIL UKURAN --}}
            <section>
                <h3 class="font-serif text-xl text-[#292522] mb-5">
                    03. Detail Ukuran
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Nama Ukuran
                        </label>

                        <input
                            type="text"
                            name="size_name"
                            value="{{ old('size_name', 'Ukuran Pribadi') }}"
                            placeholder="Contoh: Ukuran Pribadi"
                            class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Detail Ukuran (cm)
                        </label>

                        <textarea
                            name="dimensions_label"
                            rows="5"
                            placeholder="Contoh:&#10;Lingkar dada: 90 cm&#10;Lingkar pinggang: 75 cm&#10;Lingkar pinggul: 95 cm&#10;Panjang baju: 60 cm"
                            class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                            required
                        >{{ old('dimensions_label') }}</textarea>

                        <p class="text-xs text-stone-500 mt-2">
                            Tuliskan ukuran tubuh yang diperlukan untuk layanan pilihanmu.
                        </p>
                    </div>

                </div>
            </section>

            {{-- 04 PILIHAN KAIN --}}
            <section>
                <h3 class="font-serif text-xl text-[#292522] mb-5">
                    04. Pilihan Kain
                </h3>

                <label class="block text-sm font-medium mb-2">
                    Pilih Kain (Opsional)
                </label>

                <select
                    name="fabric_id"
                    class="w-full rounded-xl border-stone-300 focus:border-[#806B57] focus:ring-[#806B57]"
                >
                    <option value="">Belum memilih kain</option>

                    @foreach ($fabrics as $fabric)
                        <option value="{{ $fabric->id }}"
                            @selected(old('fabric_id') == $fabric->id)>
                            {{ $fabric->name }} -
                            Rp {{ number_format($fabric->price_per_meter, 0, ',', '.') }}/meter
                        </option>
                    @endforeach
                </select>
            </section>

            {{-- 05 PEMBAYARAN --}}
            <section>
                <h3 class="font-serif text-xl text-[#292522] mb-5">
                    05. Pembayaran
                </h3>

                <div class="grid md:grid-cols-2 gap-4">

                    <label class="border border-[#E6DED2] rounded-2xl p-5 cursor-pointer hover:bg-[#F7F4EE] transition">
                        <input
                            type="radio"
                            name="payment_type"
                            value="dp"
                            @checked(old('payment_type', 'dp') == 'dp')
                            required
                        >

                        <span class="font-semibold ml-2">
                            DP 50%
                        </span>

                        <p class="text-sm text-stone-500 mt-2">
                            Bayar setengah di awal, sisanya kemudian.
                        </p>
                    </label>

                    <label class="border border-[#E6DED2] rounded-2xl p-5 cursor-pointer hover:bg-[#F7F4EE] transition">
                        <input
                            type="radio"
                            name="payment_type"
                            value="full"
                            @checked(old('payment_type') == 'full')
                            required
                        >

                        <span class="font-semibold ml-2">
                            Lunas 100%
                        </span>

                        <p class="text-sm text-stone-500 mt-2">
                            Bayar seluruh biaya pesanan.
                        </p>
                    </label>

                </div>
            </section>

            {{-- TOMBOL --}}
            <div class="border-t border-[#E6DED2] pt-6">

                <p class="text-sm text-stone-500 mb-4">
                    Periksa kembali data pesanan sebelum melanjutkan.
                </p>

                <button
                    type="submit"
                    class="w-full bg-[#665246] hover:bg-[#292522] text-white py-4 rounded-full font-semibold transition"
                >
                    Lanjutkan Pemesanan
                </button>

                <a
                    href="{{ route('katalog.show', $service->id) }}"
                    class="block text-center text-sm text-stone-500 mt-4"
                >
                    Kembali ke detail layanan
                </a>

            </div>

        </form>
    </div>
</div>

{{-- JAVASCRIPT METODE PENERIMAAN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fulfillment = document.getElementById('fulfillment_type');

    const pickupFields = document.getElementById('pickup_fields');
    const deliveryFields = document.getElementById('delivery_fields');

    const bookingDate = document.getElementById('booking_date');
    const timeSlot = document.getElementById('time_slot');

    const deliveryInputs = [
        document.getElementById('recipient_name'),
        document.getElementById('full_address'),
        document.getElementById('city'),
        document.getElementById('postal_code')
    ];

    function toggleFulfillment() {
        const isPickup = fulfillment.value === 'pickup';
        const isDelivery = fulfillment.value === 'delivery';

        pickupFields.style.display = isPickup ? 'block' : 'none';
        deliveryFields.style.display = isDelivery ? 'block' : 'none';

        // Jadwal hanya wajib untuk Pickup
        bookingDate.required = isPickup;
        timeSlot.required = isPickup;

        // Alamat hanya wajib untuk Delivery
        deliveryInputs.forEach(function (input) {
            input.required = isDelivery;
        });
    }

    fulfillment.addEventListener('change', toggleFulfillment);

    toggleFulfillment();
});
</script>

@endsection
