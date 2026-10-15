@extends('layouts.admin')

@section('title', 'Detail Produk - Olive Verify')

@section('content')

    <div class="flex items-center gap-2 text-sm text-subtext mb-6">
        <a href="{{ route('admin.produk.index') }}" class="hover:text-primary">Kelola Produk</a>
        <span>/</span>
        <span class="text-ink font-medium">Detail Produk</span>
    </div>

    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-8 grid md:grid-cols-[220px_1fr] gap-8">

        <div class="w-full aspect-square rounded-xl bg-bg border border-gray-100 flex items-center justify-center overflow-hidden">
            @if ($product->image)
                <img src="{{ asset( $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <svg class="w-16 h-16 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
            @endif
        </div>

        <div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span class="px-2.5 py-1 rounded-full bg-mint/20 text-primary-dark text-xs font-semibold">{{ $product->category }}</span>
                <span class="px-2.5 py-1 rounded-full bg-bg text-subtext text-xs font-semibold">{{ $product->ukuran ?? '-' }}</span>
            </div>
            <h1 class="font-display font-semibold text-2xl text-ink mb-1">{{ $product->name }}</h1>
            <p class="text-xl font-semibold text-primary mb-6">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

            <dl class="grid sm:grid-cols-2 gap-y-4 text-sm mb-6">
                @foreach ([
                    'Nama Produk' => $product->name,
                    'Varian' => $product->category,
                    'Ukuran' => $product->ukuran ?? '-',
                    'Harga' => 'Rp' . number_format($product->price, 0, ',', '.'),
                    'Dibuat Oleh' => 'Admin',
                    'Tanggal Dibuat' => $product->created_at->translatedFormat('d F Y'),
                ] as $label => $value)
                    <div>
                        <dt class="text-subtext mb-0.5">{{ $label }}</dt>
                        <dd class="font-medium text-ink">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>

                        @if (!empty($product->composition))
                <div class="mb-6">
                    <dt class="text-sm text-subtext mb-1">Komposisi</dt>
                    <dd class="text-sm text-ink leading-relaxed">{{ $product->composition }}</dd>
                </div>
            @endif

            <div class="mb-6">
                <dt class="text-sm text-subtext mb-1">Deskripsi</dt>
                <dd class="text-sm text-ink leading-relaxed">
                    {{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}
                </dd>
            </div>
        </div>
    </div>

@endsection