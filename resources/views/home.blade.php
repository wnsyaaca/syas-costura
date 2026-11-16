@extends('layouts.costura')

@section('content')
<section class="grid md:grid-cols-2 gap-8 items-center py-6">
    <div>
        <h1 class="font-serif text-5xl font-bold leading-tight">Jahit custom,<br>pas di badan.</h1>
        <p class="mt-4 text-stone-600">Pilih model dan kain, ukur di studio atau pakai panduan ukuran, lalu pantau foto pengerjaan bajumu dari awal sampai selesai.</p>
        <div class="mt-6 flex gap-3">
            <a href="/katalog" class="bg-brand text-white px-5 py-2 rounded-full">Lihat katalog</a>
            <a href="/booking" class="border border-brand text-brand px-5 py-2 rounded-full">Booking fitting</a>
        </div>
    </div>
    <div class="h-64 rounded-2xl bg-gradient-to-br from-rose-200 via-brand to-brand-dark"></div>
</section>

<section class="mt-10">
    <h2 class="font-serif text-2xl font-bold mb-4">Layanan pilihan</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($services as $service)
            @include('catalog._card', ['service' => $service])
        @endforeach
    </div>
</section>

<section class="mt-12">
    <h2 class="font-serif text-2xl font-bold mb-4">Kata pelanggan</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @forelse ($testimonials as $t)
            <div class="bg-white rounded-2xl p-4 border border-rose-100">
                <div class="text-amber-500">{{ str_repeat('★', $t->rating) }}</div>
                <p class="mt-2 text-sm">{{ $t->review }}</p>
                <p class="mt-3 text-sm font-bold">{{ $t->customer->user->name }}</p>
            </div>
        @empty
            <p class="text-stone-500 text-sm">Belum ada ulasan.</p>
        @endforelse
    </div>
</section>
@endsection
