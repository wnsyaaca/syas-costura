<div class="bg-white rounded-2xl p-3 border border-rose-100">
    <div class="h-32 rounded-xl bg-gradient-to-br from-rose-100 to-rose-300"></div>
    <p class="mt-3 font-serif font-bold">{{ $service->name }}</p>
    <p class="text-xs text-stone-500">Mulai Rp {{ number_format($service->price, 0, ',', '.') }}</p>
    <a href="/katalog/{{ $service->id }}" class="mt-3 inline-block border border-brand text-brand text-sm px-4 py-1 rounded-full">Pesan</a>
</div>
