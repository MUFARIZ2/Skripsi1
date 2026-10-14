<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Olive Verify - Verifikasi Keaslian Produk')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" integrity="sha384-Bk5cbLkZQ5raZ0+H2/+VbfYx3WpvxvQK4zqXZr7sYODuaX7bKXoSOnipQxkaS8sv" crossorigin="anonymous">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#075E4D', dark: '#06483B' },
                        mint: '#72C7B8',
                        bg: '#F7F9F8',
                                                paper: '#F7F9F8',
                        ink: '#1F2937',
                        subtext: '#6B7280',
                        success: '#16A34A',
                        warning: '#F59E0B',
                        danger: '#DC2626',
                        turmeric: '#C08A17',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    borderRadius: { xl: '0.875rem', '2xl': '1.25rem' },
                    boxShadow: {
                        soft: '0 1px 2px rgba(6, 72, 59, 0.04), 0 4px 12px rgba(6, 72, 59, 0.06)',
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-bg text-ink font-sans antialiased">

    {{-- ============ NAVBAR PUBLIK ============ --}}
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <span class="w-14 h-14 rounded-full overflow-hidden shrink-0 border border-primary/10 bg-white">
                    <img src="{{ asset('logo_teh_olive.png') }}" alt="Olive Verify" class="w-full h-full object-cover">
                </span>
                <span class="font-display font-semibold text-lg text-ink leading-none">Olive Verify</span>
            </a>

            <button id="navToggle" class="md:hidden p-2 text-ink" aria-label="Buka menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-ink hover:text-primary transition">Beranda</a>
                <a href="{{ route('home') }}#cara-verifikasi" class="text-sm font-medium text-subtext hover:text-primary transition">Cara Verifikasi</a>
                <a href="{{ route('home') }}#tentang-produk" class="text-sm font-medium text-subtext hover:text-primary transition">Tentang Produk</a>
                <a href="{{ route('home') }}#bantuan" class="text-sm font-medium text-subtext hover:text-primary transition">Bantuan</a>
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-subtext hover:text-primary transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg>
            Admin
        </a>
            </div>

        </nav>

        {{-- <div id="navMobile" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ink hover:bg-bg">Beranda</a>
            <a href="{{ route('home') }}#cara-verifikasi" class="block px-3 py-2 rounded-lg text-sm font-medium text-subtext hover:bg-bg">Cara Verifikasi</a>
            <a href="{{ route('home') }}#tentang-produk" class="block px-3 py-2 rounded-lg text-sm font-medium text-subtext hover:bg-bg">Tentang Produk</a>
            <a href="{{ route('home') }}#bantuan" class="block px-3 py-2 rounded-lg text-sm font-medium text-subtext hover:bg-bg">Bantuan</a>
            <a href="{{ route('verifikasi') }}" class="block text-center mt-2 px-3 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold">Verifikasi Produk</a>
            <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-subtext hover:text-primary transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>Admin</a>
        </div> --}}
<div id="navMobile" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
    <a href="{{ route('home') }}"
       class="block px-3 py-2 rounded-lg text-sm font-medium text-ink hover:bg-bg">
        Beranda
    </a>

    <a href="{{ route('home') }}#cara-verifikasi"
       class="block px-3 py-2 rounded-lg text-sm font-medium text-subtext hover:bg-bg">
        Cara Verifikasi
    </a>

    <a href="{{ route('home') }}#tentang-produk"
       class="block px-3 py-2 rounded-lg text-sm font-medium text-subtext hover:bg-bg">
        Tentang Produk
    </a>

    <a href="{{ route('home') }}#bantuan"
       class="block px-3 py-2 rounded-lg text-sm font-medium text-subtext hover:bg-bg">
        Bantuan
    </a>
    <a href="{{ route('admin.login') }}"
       class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-subtext hover:bg-bg hover:text-primary transition">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg>
        Admin
    </a>
</div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="border-t border-gray-100 bg-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                {{-- <span class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center text-white font-display font-bold text-xs">TV</span> --}}
                                <span class="w-8 h-8 rounded-full overflow-hidden shrink-0 border border-primary/10 bg-white">
                    <img src="{{ asset('logo_teh_olive.png') }}" alt="Olive Verify" class="w-full h-full object-cover">
                </span>
                <span class="font-display font-semibold text-sm text-ink">Olive Verify</span>
            </div>
            <p class="text-sm text-subtext text-center">Sistem verifikasi keaslian produk minuman tradisional berbasis QR Code.</p>
            <p class="text-xs text-subtext">&copy; {{ date('Y') }} Olive Verify</p>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle')?.addEventListener('click', () => {
            document.getElementById('navMobile').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
