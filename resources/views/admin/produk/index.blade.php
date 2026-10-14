@extends('layouts.admin')

@section('title', 'Kelola Produk - Olive Verify')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display font-semibold text-2xl text-ink">Kelola Produk</h1>
            <p class="text-sm text-subtext mt-1">Kelola seluruh produk minuman tradisional yang tersedia.</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

        @if (session('success'))
        <div id="alert-success" class="flex items-center gap-3 px-5 py-4 mb-6 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-medium transition-opacity duration-500">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>

            @if (session('error'))
        <div id="alert-error" class="flex items-center gap-3 px-5 py-4 mb-6 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium transition-opacity duration-500">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>

        <script>
            setTimeout(function () {
                const alertEl = document.getElementById('alert-error');
                if (alertEl) {
                    alertEl.style.opacity = '0';
                    setTimeout(() => alertEl.remove(), 500);
                }
            }, 5000);
        </script>
    @endif


        <script>
            setTimeout(function () {
                const alertEl = document.getElementById('alert-success');
                if (alertEl) {
                    alertEl.style.opacity = '0';
                    setTimeout(() => alertEl.remove(), 500);
                }
            }, 3000);
        </script>
    @endif
    

    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft overflow-hidden">

            <form method="GET" action="{{ route('admin.produk.index') }}" class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-gray-100">
    <div class="relative flex-1">
        <svg class="w-4 h-4 text-subtext absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="input-cari" name="cari" value="{{ request('cari') }}" placeholder="Cari produk..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
    </div>
    <select name="varian" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-primary/30">
        <option value="semua" {{ request('varian', 'semua') == 'semua' ? 'selected' : '' }}>Semua Varian</option>
        @foreach ($varianList as $varian)
            <option value="{{ $varian }}" {{ request('varian') == $varian ? 'selected' : '' }}>{{ $varian }}</option>
        @endforeach
    </select>
    <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Cari
    </button>
</form>

            <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-subtext border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Foto</th>
                        <th class="px-6 py-3 font-medium">Nama Produk</th>
                        <th class="px-6 py-3 font-medium">Varian</th>
                        <th class="px-6 py-3 font-medium">Ukuran</th>
                        <th class="px-6 py-3 font-medium">Harga</th>
                        <th class="px-6 py-3 font-medium">Tanggal Dibuat</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse ($products as $i => $product)
                    <tr class="border-b border-gray-50 last:border-0">
                    <td class="px-6 py-3.5 text-subtext">{{ $products->firstItem() + $i }}</td>
                    <td class="px-6 py-3.5">
                    <div class="w-10 h-10 rounded-lg bg-bg border border-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
                        @endif
                    </div>
                    </td>
                        <td class="px-6 py-3.5 font-medium text-ink">{{ $product->name }}</td>
                        <td class="px-6 py-3.5 text-ink">{{ $product->category }}</td>
                        <td class="px-6 py-3.5 text-ink">{{ $product->ukuran ?? '-' }}</td>
                        <td class="px-6 py-3.5 text-ink">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-3.5 text-subtext">{{ $product->created_at->translatedFormat('d M Y') }}</td>
                                                <td class="px-6 py-3.5 text-right space-x-3 whitespace-nowrap">
                            <a href="{{ route('admin.produk.show', $product->id) }}" class="text-primary font-medium hover:underline">Detail</a>
                            <a href="{{ route('admin.produk.edit', $product->id) }}" class="text-subtext font-medium hover:underline">Edit</a>
                            @if ($product->batches_count === 0)
                                <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk &quot;{{ $product->name }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-medium hover:underline">Hapus</button>
                                </form>
                            @else
                                <span class="text-gray-300 cursor-not-allowed" title="Tidak bisa dihapus, produk sudah memiliki batch produksi">Hapus</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-subtext">Belum ada produk. Klik "Tambah Produk" untuk mulai.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
                <div class="md:hidden divide-y divide-gray-50">
            @forelse ($products as $product)
                <div class="p-4">
                    <div class="flex gap-3">
                        <div class="w-12 h-12 shrink-0 rounded-lg bg-bg border border-gray-100 flex items-center justify-center overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-ink text-sm truncate">{{ $product->name }}</p>
                            <p class="text-xs text-subtext mt-0.5">{{ $product->category }} &middot; {{ $product->ukuran ?? '-' }}</p>
                        </div>
                        <p class="font-medium text-ink text-sm whitespace-nowrap">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                        <span class="text-xs text-subtext">{{ $product->created_at->translatedFormat('d M Y') }}</span>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.produk.show', $product->id) }}" class="text-primary text-sm font-medium hover:underline">Detail</a>
                            <a href="{{ route('admin.produk.edit', $product->id) }}" class="text-subtext text-sm font-medium hover:underline">Edit</a>
                            @if ($product->batches_count === 0)
                                <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk &quot;{{ $product->name }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm font-medium hover:underline">Hapus</button>
                                </form>
                            @else
                                <span class="text-gray-300 text-sm cursor-not-allowed" title="Tidak bisa dihapus, produk sudah memiliki batch produksi">Hapus</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-subtext text-sm">Belum ada produk. Klik "Tambah Produk" untuk mulai.</div>
            @endforelse
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 text-sm text-subtext">
    <span>
        @if ($products->total() > 0)
            Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari {{ $products->total() }} produk
        @else
            Tidak ada produk
        @endif
        </span>
        <div>
            {{ $products->links() }}
        </div>
        </div>
    </div>

            {{-- <script>
        let timer;
        document.getElementById('input-cari').addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                this.form.submit();
            }, 1500);
        });
    </script> --}}
@endsection
