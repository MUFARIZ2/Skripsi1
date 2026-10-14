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
</head>
<body class="bg-bg text-ink font-sans antialiased">

    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- KIRI: brand & identitas --}}
        <div class="hidden lg:flex relative flex-col justify-between bg-bg p-12 overflow-hidden border-r border-gray-100">
            {{-- <svg class="absolute -right-8 -bottom-10 w-64 h-64 xl:w-72 xl:h-72 opacity-[0.07] -rotate-3" viewBox="0 0 240 240" aria-hidden="true">
                <defs>
                    <path id="sealAdmin" d="M 120,120 m -94,0 a 94,94 0 1,1 188,0 a 94,94 0 1,1 -188,0" />
                </defs>
                <circle cx="120" cy="120" r="110" fill="none" stroke="#075E4D" stroke-width="2"/>
                <circle cx="120" cy="120" r="94" fill="none" stroke="#075E4D" stroke-width="1.5"/>
                <text font-family="Poppins, sans-serif" font-size="12" font-weight="600" letter-spacing="3" fill="#075E4D">
                    <textPath href="#sealAdmin" startOffset="1%">OLIVE VERIFY ✦ PANEL ADMIN ✦</textPath>
                </text>
                <g transform="translate(120,120)">
                    <rect x="-27" y="-27" width="54" height="54" fill="none" stroke="#075E4D" stroke-width="7"/>
                    <rect x="-11" y="-11" width="22" height="22" fill="#075E4D"/>
                </g>
            </svg> --}}

            <a href="{{ route('home') }}" class="flex items-center gap-2.5 relative z-10">
                <span class="w-12 h-12 rounded-full overflow-hidden shrink-0 border border-primary/10 bg-white">
                    <img src="{{ asset('logo_teh_olive.png') }}" alt="Olive Verify" class="w-full h-full object-cover">
                </span>
                <span class="font-display font-semibold text-primary text-lg">Olive Verify</span>
            </a>

            <div class="relative z-10 max-w-sm">
                <h2 class="font-display font-semibold text-ink text-3xl leading-snug mb-4">Kelola produk &amp; verifikasi keaslian minuman tradisional</h2>
                <p class="text-subtext text-sm leading-relaxed">Pastikan setiap produk yang Anda kelola tercatat, terenkripsi, dan dapat diverifikasi konsumen secara langsung.</p>
            </div>

            <p class="relative z-10 text-subtext/70 text-xs">&copy; {{ date('Y') }} Olive Verify</p>
        </div>

        {{-- KANAN: form --}}
        <div class="flex items-center justify-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-sm">
                <div class="lg:hidden flex items-center gap-2.5 mb-8">
                    <span class="w-10 h-10 rounded-full overflow-hidden shrink-0 border border-primary/10 bg-white">
                        <img src="{{ asset('logo_teh_olive.png') }}" alt="Olive Verify" class="w-full h-full object-cover">
                    </span>
                    <span class="font-display font-semibold text-ink text-base">Olive Verify</span>
                </div>

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>