@extends('layouts.costura')

@section('title', "Katalog - Sya's Costura")

@section('content')
<h1 class="font-serif text-3xl font-bold">Katalog layanan</h1>

<form method="GET" class="mt-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari layanan..."
           class="w-full md:w-96 rounded-xl border border-brand px-4 py-2 bg-white">
    @if (request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
    @endif
</form>

<div class="mt-3 flex gap-2 text-sm">
    <a href="/katalog" class="px-4 py-1 rounded-full {{ !request('category') ? 'bg-brand-dark text-white' : 'bg-white border' }}">Semua</a>
    @foreach ($categories as $c)
        <a href="/katalog?category={{ $c->slug }}"
           class="px-4 py-1 rounded-full {{ request('category') === $c->slug ? 'bg-brand-dark text-white' : 'bg-white border' }}">
            {{ $c->name }}
        </a>
    @endforeach
</div>

<div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse ($services as $service)
        @include('catalog._card', ['service' => $service])
    @empty
        <p class="text-stone-500">Layanan tidak ditemukan.</p>
    @endforelse
</div>

<div class="mt-6">{{ $services->links() }}</div>
@endsection
