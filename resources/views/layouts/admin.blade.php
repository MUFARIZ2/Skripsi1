<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Olive Verify')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#075E4D', dark: '#06483B' },
                        mint: '#72C7B8', bg: '#F7F9F8', ink: '#1F2937',
                        subtext: '#6B7280', success: '#16A34A', warning: '#F59E0B', danger: '#DC2626',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Poppins', 'sans-serif'] },
                    borderRadius: { xl: '0.875rem', '2xl': '1.25rem' },
                    boxShadow: { soft: '0 1px 2px rgba(6,72,59,.04), 0 4px 12px rgba(6,72,59,.06)' }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-bg text-ink font-sans antialiased">

    {{-- ============ NAVBAR ADMIN (HORIZONTAL, STICKY, TANPA SIDEBAR) ============ --}}
    <header class="sticky top-0 z-40 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">

            <div class="flex items-center gap-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 shrink-0">
                    <span class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-display font-bold text-sm">OLV</span>
                    <span class="font-display font-semibold text-ink text-base hidden sm:block">Verify</span>
                </a>

                <nav class="hidden lg:flex items-center gap-1">
                    @php
                        $navItems = [
                            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
                            ['label' => 'Kelola Produk', 'route' => 'admin.produk.index'],
                            ['label' => 'Batch Produksi', 'route' => 'admin.batch.index'],
                            ['label' => 'Laporan', 'route' => 'admin.laporan.index'],
                        ];
                    @endphp
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition
                                  {{ request()->routeIs($item['route'].'*') ? 'bg-primary/10 text-primary' : 'text-subtext hover:text-ink hover:bg-bg' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="flex items-center gap-3">
                {{-- dropdown admin --}}
                <div class="relative">
                    <button id="adminMenuBtn" class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-lg hover:bg-bg transition">
                        <span class="w-8 h-8 rounded-full bg-mint/30 text-primary-dark font-display font-semibold text-xs flex items-center justify-center">
                            {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 1)) }}
                        </span>
                        <span class="hidden sm:block text-sm font-medium text-ink">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <svg class="w-4 h-4 text-subtext" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="adminMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-soft border border-gray-100 py-1.5 z-50">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-danger hover:bg-bg">Logout</button>
                        </form>
                    </div>
                </div>

                <button id="adminNavToggle" class="lg:hidden p-2 text-ink" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- menu mobile --}}
        <div id="adminNavMobile" class="hidden lg:hidden border-t border-gray-100 px-4 py-2 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ink hover:bg-bg">Dashboard</a>
            <a href="{{ route('admin.produk.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ink hover:bg-bg">Kelola Produk</a>
            <a href="{{ route('admin.batch.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ink hover:bg-bg">Batch Produksi</a>
            <a href="{{ route('admin.laporan.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ink hover:bg-bg">Laporan</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script>
        document.getElementById('adminNavToggle')?.addEventListener('click', () => {
            document.getElementById('adminNavMobile').classList.toggle('hidden');
        });
        const menuBtn = document.getElementById('adminMenuBtn');
        const menu = document.getElementById('adminMenu');
        menuBtn?.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('hidden'); });
        document.addEventListener('click', () => menu?.classList.add('hidden'));
    </script>
    @stack('scripts')
</body>
</html>
