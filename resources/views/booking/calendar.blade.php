@extends('layouts.costura')

@section('title', 'Booking Fitting - Sya\'s Costura')

@section('content')
@php
    $monthStart = $currentMonth->copy()->startOfMonth();
    $calendarStart = $monthStart->copy()->startOfWeek(Carbon\Carbon::MONDAY);
    $calendarEnd = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon\Carbon::SUNDAY);

    $days = [];
    $date = $calendarStart->copy();

    while ($date <= $calendarEnd) {
        $days[] = $date->copy();
        $date->addDay();
    }

    $previousMonth = $currentMonth->copy()->subMonth()->format('Y-m');
    $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

    $selectedTime = request('time');

    $validSelectedTime = $selectedTime
        && in_array($selectedTime, $timeSlots)
        && !$selectedSlots->contains($selectedTime);

    // Menentukan bulan yang sedang aktif berdasarkan bulan sekarang.
    $today = now()->startOfDay();
    $activeMonth = now()->format('Y-m');

    $isViewingActiveMonth = $currentMonth->format('Y-m') === $activeMonth;
    $isViewingPastMonth = $currentMonth->format('Y-m') < $activeMonth;
@endphp

<div class="max-w-7xl mx-auto px-4 py-12">

    {{-- HEADER --}}
    <div class="text-center mb-10">
        <p class="text-sm tracking-[0.3em] uppercase text-[#9A8068] mb-3">
            Sya's Costura
        </p>

        <h1 class="text-3xl md:text-4xl font-serif text-[#49392D]">
            Booking Fitting
        </h1>

        <p class="text-[#817366] mt-3">
            Pilih tanggal dan waktu untuk kunjungan fitting di toko kami.
        </p>
    </div>

    {{-- NOTIFIKASI BERHASIL --}}
    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800">
            <div class="font-semibold">Booking berhasil dikirim!</div>
            <p class="text-sm mt-1">{{ session('success') }}</p>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
            <p class="font-semibold mb-2">Booking belum berhasil.</p>

            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- KALENDER DAN PILIHAN JAM --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        {{-- KOLOM KIRI: KALENDER --}}
        <div class="min-w-0 bg-white border border-[#E8DED2] rounded-3xl shadow-sm p-5 md:p-6">

            {{-- NAVIGASI BULAN --}}
            <div class="flex items-center justify-between mb-8">

                <a href="{{ route('booking.index', ['month' => $previousMonth]) }}"
                   class="w-10 h-10 flex items-center justify-center rounded-full border border-[#E8DED2] text-[#725C49] hover:bg-[#F5F0E9]">
                    &larr;
                </a>

                <div class="text-center">
                    <h2 class="font-serif text-xl md:text-2xl text-[#49392D]">
                        {{ $currentMonth->translatedFormat('F Y') }}
                    </h2>

                    <p class="text-xs text-[#9A8068] mt-1">
                        PILIH TANGGAL BOOKING
                    </p>
                </div>

                <a href="{{ route('booking.index', ['month' => $nextMonth]) }}"
                   class="w-10 h-10 flex items-center justify-center rounded-full border border-[#E8DED2] text-[#725C49] hover:bg-[#F5F0E9]">
                    &rarr;
                </a>

            </div>

            {{-- NAMA HARI --}}
            <div class="grid grid-cols-7 gap-1 md:gap-2 text-center mb-3">
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $dayName)
                    <div class="text-xs font-semibold text-[#806B57] py-2">
                        {{ $dayName }}
                    </div>
                @endforeach
            </div>

            {{-- TANGGAL --}}
            <div class="grid grid-cols-7 gap-1 md:gap-2">

                @foreach ($days as $day)

                    @php
                        $dateKey = $day->toDateString();

                        // Apakah tanggal termasuk bulan yang sedang ditampilkan?
                        $isCurrentMonth = $day->format('Y-m') === $currentMonth->format('Y-m');

                        $isPast = $day->lt($today);
                        $isWeekend = $day->isWeekend();

                        $count = (int) ($bookingCounts[$dateKey] ?? 0);
                        $remainingSlots = max(0, 3 - $count);

                        $isSelected = $selectedDate === $dateKey;

                        // Full Booking hanya jika:
                        // 1. Sedang melihat bulan aktif.
                        // 2. Tanggal sudah lewat.
                        // 3. Bukan hari Sabtu/Minggu.
                        $isPastFullBooking = $isViewingActiveMonth
                            && $isPast
                            && !$isWeekend;

                        // Jika kuota benar-benar habis.
                        $isCapacityFull = $remainingSlots === 0;

                        if ($remainingSlots === 3) {
                            $availabilityClass = 'bg-[#F0F6ED] border-[#D8E7D0] text-[#54734B]';
                            $availabilityLabel = 'Tersedia';
                        } elseif ($remainingSlots === 2) {
                            $availabilityClass = 'bg-[#FFF6E3] border-[#F0DDAF] text-[#98742E]';
                            $availabilityLabel = 'Tersedia';
                        } elseif ($remainingSlots === 1) {
                            $availabilityClass = 'bg-[#FCEEE7] border-[#EBCDBB] text-[#A45F3E]';
                            $availabilityLabel = 'Hampir penuh';
                        } else {
                            $availabilityClass = 'bg-[#F5F2EE] border-[#E8DED2] text-[#A99B8E]';
                            $availabilityLabel = 'Penuh';
                        }
                    @endphp

                    {{-- 1. TANGGAL DI LUAR BULAN YANG DITAMPILKAN --}}
                    @if (!$isCurrentMonth)

                        <div
                            title="Tanggal di luar bulan ini."
                            class="min-h-16 md:min-h-20 rounded-xl border border-[#F0EBE5] bg-[#F8F6F2] opacity-30 flex flex-col items-center justify-center">

                            <span class="text-sm text-[#A99B8E]">
                                {{ $day->day }}
                            </span>

                        </div>

                    {{-- 2. SABTU DAN MINGGU --}}
                    @elseif ($isWeekend)

                        <div
                            title="Toko tutup pada hari Sabtu dan Minggu."
                            aria-disabled="true"
                            class="min-h-16 md:min-h-20 rounded-xl border border-[#E8DED2] bg-[#F5F2EE] flex flex-col items-center justify-center cursor-not-allowed select-none">

                            <span class="text-sm font-semibold text-[#A99B8E]">
                                {{ $day->day }}
                            </span>

                        </div>

                    {{-- 3. SEMUA WEEKDAY DI BULAN MASA LALU --}}
                    @elseif ($isViewingPastMonth)

                        <div
                            title="Bulan sudah berlalu."
                            aria-disabled="true"
                            class="min-h-16 md:min-h-20 rounded-xl border border-[#E8DED2] bg-[#F5F2EE] flex flex-col items-center justify-center cursor-not-allowed select-none">

                            <span class="text-sm font-semibold text-[#A99B8E]">
                                {{ $day->day }}
                            </span>

                        </div>

                    {{-- 4. WEEKDAY YANG SUDAH LEWAT PADA BULAN AKTIF --}}
                    @elseif ($isPastFullBooking)

                        <div
                            title="Full Booking - Tanggal tidak tersedia untuk fitting."
                            aria-disabled="true"
                            class="min-h-16 md:min-h-20 rounded-xl border-2 border-[#D9B9A5] bg-[#FCEEE7] flex flex-col items-center justify-center cursor-not-allowed select-none">

                            <span class="text-sm font-semibold text-[#A45F3E]">
                                {{ $day->day }}
                            </span>

                            <span class="text-[9px] md:text-[10px] font-bold mt-1 text-[#A45F3E]">
                                Full Booking
                            </span>

                        </div>

                    {{-- 5. SLOT BENAR-BENAR HABIS --}}
                    @elseif ($isCapacityFull)

                        <div
                            title="Full Booking - Semua slot sudah terisi."
                            aria-disabled="true"
                            class="min-h-16 md:min-h-20 rounded-xl border-2 border-[#D9B9A5] bg-[#FCEEE7] flex flex-col items-center justify-center cursor-not-allowed select-none">

                            <span class="text-sm font-semibold text-[#A45F3E]">
                                {{ $day->day }}
                            </span>

                            <span class="text-[9px] md:text-[10px] font-bold mt-1 text-[#A45F3E]">
                                Full Booking
                            </span>

                        </div>

                    {{-- 6. TANGGAL YANG MASIH TERSEDIA --}}
                    @else

                        <a href="{{ route('booking.index', [
                            'month' => $currentMonth->format('Y-m'),
                            'date' => $dateKey
                        ]) }}"
                           class="min-h-16 md:min-h-20 rounded-xl border flex flex-col items-center justify-center transition {{ $availabilityClass }} {{ $isSelected ? 'ring-2 ring-[#806B57] ring-offset-2 shadow-md' : 'hover:shadow-sm' }}">

                            <span class="text-sm font-semibold">
                                {{ $day->day }}
                            </span>

                            <span class="text-[10px] md:text-xs font-bold mt-1">
                                {{ $remainingSlots }} slot
                            </span>

                            <span class="text-[8px] md:text-[9px] mt-0.5">
                                {{ $isSelected ? 'Dipilih' : $availabilityLabel }}
                            </span>

                        </a>

                    @endif

                @endforeach

            </div>

            {{-- KETERANGAN WARNA --}}
            <div class="mt-6 pt-5 border-t border-[#EEE7DF]">

                <p class="text-xs font-semibold text-[#49392D] mb-3">
                    Keterangan ketersediaan slot
                </p>

                <div class="grid grid-cols-2 gap-3 text-xs text-[#817366]">

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 shrink-0 rounded bg-[#F0F6ED] border border-[#D8E7D0]"></span>
                        3 slot tersisa
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 shrink-0 rounded bg-[#FFF6E3] border border-[#F0DDAF]"></span>
                        2 slot tersisa
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 shrink-0 rounded bg-[#FCEEE7] border border-[#EBCDBB]"></span>
                        1 slot tersisa
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 shrink-0 rounded bg-[#F5F2EE] border border-[#E8DED2]"></span>
                        Penuh / tutup
                    </div>

                </div>

            </div>

            {{-- INFORMASI BOOKING --}}
            <div class="mt-5 pt-5 border-t border-[#EEE7DF] text-xs text-[#817366]">
                <p>Senin - Jumat: tersedia untuk fitting.</p>
                <p class="mt-1">Sabtu dan Minggu: toko tutup.</p>
                <p class="mt-1">Maksimal 3 pelanggan setiap hari.</p>
            </div>

        </div>

        {{-- KOLOM KANAN: PILIHAN JAM --}}
        <div class="min-w-0 bg-white border border-[#E8DED2] rounded-3xl shadow-sm p-5 md:p-6">

            <h3 class="font-serif text-xl md:text-2xl text-[#49392D]">
                Pilih Jam Fitting
            </h3>

            @if ($selectedDate)

                <p class="text-sm text-[#817366] mt-2 mb-6">
                    {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">

                    @foreach ($timeSlots as $slot)

                        @php
                            $isBooked = $selectedSlots->contains($slot);
                        @endphp

                        @if ($isBooked)

                            <button type="button" disabled
                                title="Jam ini sudah dibooking."
                                class="rounded-xl border border-[#E8DED2] bg-[#F5F2EE] text-[#B7AAA0] py-3 text-sm cursor-not-allowed">
                                {{ $slot }} · Penuh
                            </button>

                        @else

                            <a href="{{ route('booking.index', [
                                'month' => $currentMonth->format('Y-m'),
                                'date' => $selectedDate,
                                'time' => $slot
                            ]) }}"
                               class="rounded-xl border py-3 text-sm text-center transition {{ $selectedTime === $slot ? 'bg-[#806B57] text-white border-[#806B57]' : 'border-[#E8DED2] text-[#49392D] hover:bg-[#F5F0E9]' }}">

                                {{ $slot }}

                            </a>

                        @endif

                    @endforeach

                </div>

                {{-- FORM BOOKING --}}
                @if ($validSelectedTime)

                    <div class="mt-7 border-t border-[#EEE7DF] pt-6">

                        <div class="rounded-xl bg-[#F5F0E9] p-4 mb-6 text-sm text-[#49392D]">

                            <p class="font-semibold mb-2">
                                Ringkasan Jadwal
                            </p>

                            <p>
                                Tanggal:
                                {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}
                            </p>

                            <p>
                                Jam:
                                <strong>{{ $selectedTime }}</strong>
                            </p>

                        </div>

                        <form method="POST"
                              action="{{ route('booking.calendar.store', [
                                  'date' => $selectedDate,
                                  'time' => $selectedTime
                              ]) }}">

                            @csrf

                            <input type="hidden"
                                   name="booking_date"
                                   value="{{ $selectedDate }}">

                            <input type="hidden"
                                   name="time_slot"
                                   value="{{ $selectedTime }}">

                            <div class="mb-5">

                                <label for="phone"
                                       class="block text-sm font-semibold text-[#49392D] mb-2">
                                    Nomor WhatsApp
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Contoh: 081234567890"
                                    required
                                    maxlength="20"
                                    class="w-full rounded-xl border border-[#E8DED2] px-4 py-3 text-sm text-[#49392D] focus:outline-none focus:ring-2 focus:ring-[#B9A28B]">

                                <p class="text-xs text-[#9A8068] mt-2">
                                    Nomor ini digunakan admin untuk menghubungi kamu.
                                </p>

                            </div>

                            <button type="submit"
                                class="w-full rounded-xl bg-[#806B57] hover:bg-[#685441] text-white font-semibold py-4 transition shadow-sm">
                                Booking Sekarang
                            </button>

                            <p class="text-xs text-center text-[#9A8068] mt-4">
                                Booking akan berstatus menunggu konfirmasi admin.
                            </p>

                        </form>

                    </div>

                @else

                    <div class="mt-7 rounded-xl bg-[#F5F0E9] p-5 text-center">
                        <p class="text-sm text-[#817366]">
                            Silakan pilih salah satu jam yang tersedia untuk melanjutkan booking.
                        </p>
                    </div>

                @endif

            @else

                <div class="min-h-64 flex flex-col items-center justify-center text-center">

                    <div class="w-16 h-16 rounded-full bg-[#F5F0E9] flex items-center justify-center mb-5">
                        <span class="text-3xl text-[#806B57]">▦</span>
                    </div>

                    <h4 class="font-serif text-lg text-[#49392D]">
                        Belum Ada Tanggal Dipilih
                    </h4>

                    <p class="text-sm text-[#817366] mt-2 max-w-xs">
                        Silakan pilih tanggal pada kalender di sebelah kiri untuk melihat jam fitting yang tersedia.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>
@endsection
