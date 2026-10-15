@extends('layouts.app')

@section('title', 'Verifikasi Produk - Olive Verify')

@section('content')
<section class="bg-paper">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">

        <div class="text-center mb-10">
            <h1 class="font-display font-semibold text-2xl lg:text-3xl text-ink mb-2">Verifikasi Keaslian Produk</h1>
            <p class="text-ink/70">Scan QR Code pada kemasan untuk memverifikasi produk Anda.</p>
            </div>

        {{-- tab switch --}}
        {{-- <div class="flex justify-center mb-8">
            <div class="inline-flex bg-white rounded-xl p-1 border border-primary/10 shadow-soft">
                <button id="tabScan" onclick="switchTab('scan')" class="px-5 py-2 rounded-lg text-sm font-semibold bg-primary text-white transition">Scan QR Code</button>
                <button id="tabManual" onclick="switchTab('manual')" class="px-5 py-2 rounded-lg text-sm font-semibold text-subtext transition">Input Manual</button>
            </div>
        </div> --}}

        {{-- ============ PANEL SCAN ============ --}}
        <div id="panelScan" class="bg-white rounded-2xl shadow-soft border border-primary/10 p-8 text-center">

            {{-- viewfinder: sudut siku echo motif finder-pattern QR dari hero --}}
            <div class="relative mx-auto w-full max-w-xs aspect-square rounded-2xl overflow-hidden bg-paper">
                <div id="qr-reader" class="w-full h-full"></div>

                <div class="pointer-events-none absolute inset-5">
                    <span class="absolute top-0 left-0 w-7 h-7 border-t-2 border-l-2 border-primary rounded-tl-md"></span>
                    <span class="absolute top-0 right-0 w-7 h-7 border-t-2 border-r-2 border-primary rounded-tr-md"></span>
                    <span class="absolute bottom-0 left-0 w-7 h-7 border-b-2 border-l-2 border-primary rounded-bl-md"></span>
                    <span class="absolute bottom-0 right-0 w-7 h-7 border-b-2 border-r-2 border-primary rounded-br-md"></span>
                </div>
            </div>

            <button id="btnStartScan" onclick="startScan(); document.getElementById('btnStopScan').classList.remove('hidden');"
            class="mt-5 px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
            Mulai Scan
            </button>

            <button id="btnStopScan" onclick="stopScan()"
            class="hidden mt-5 px-6 py-3 rounded-xl bg-danger text-white text-sm font-semibold hover:bg-red-700 transition shadow-soft">
            Berhenti Scan
            </button>

            <p id="scanStatus" class="text-sm text-subtext mt-3">Klik tombol di atas untuk mengaktifkan kamera.</p>

            {{-- form tersembunyi, di-submit otomatis lewat JS begitu QR berhasil dibaca --}}
            <form id="formScanResult" action="{{ route('verifikasi.cek') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="kode" id="scanKodeInput">
            </form>
        </div>

        {{-- ============ PANEL MANUAL ============ --}}
        {{-- <div id="panelManual" class="hidden bg-white rounded-2xl shadow-soft border border-primary/10 p-8">
            <form action="{{ route('verifikasi.cek') }}" method="POST">
                @csrf
                <label for="kode" class="block text-sm font-medium text-ink mb-2">Masukkan kode verifikasi</label>
                <div class="relative mb-5">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg viewBox="0 0 24 24" class="w-4 h-4 text-primary/50" fill="none">
                            <rect x="3" y="3" width="10" height="10" rx="1.5" stroke="currentColor" stroke-width="1.6"/>
                            <rect x="6.5" y="6.5" width="3" height="3" fill="currentColor"/>
                        </svg>
                    </span>
                    <input type="text" id="kode" name="kode" placeholder="Contoh: QR0001"
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
                    Verifikasi
                </button>
            </form>
        </div> --}}

        <p class="text-center text-xs text-subtext mt-6">Kode verifikasi hanya berlaku untuk satu produk fisik dan bersifat unik.</p>
    </div>
</section>

{{-- library pembaca QR lewat kamera browser --}}
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>

    // function switchTab(tab) {
    //     const isScan = tab === 'scan';
    //     document.getElementById('panelScan').classList.toggle('hidden', !isScan);
    //     document.getElementById('panelManual').classList.toggle('hidden', isScan);
    //     document.getElementById('tabScan').className = 'px-5 py-2 rounded-lg text-sm font-semibold transition ' + (isScan ? 'bg-primary text-white' : 'text-subtext');
    //     document.getElementById('tabManual').className = 'px-5 py-2 rounded-lg text-sm font-semibold transition ' + (!isScan ? 'bg-primary text-white' : 'text-subtext');
    // }

    let html5QrCode;

    function extractKode(text) {
        try {
            const u = new URL(text);
            return u.searchParams.get('kode') ?? text;
        } catch (e) {
            return text;
        }
    }

    (function () {
        const params = new URLSearchParams(window.location.search);
        const kode = params.get('kode');
        if (!kode) return;
        window.history.replaceState({}, document.title, window.location.pathname);
        document.getElementById('scanKodeInput').value = kode;
        document.getElementById('formScanResult').submit();
    })();

    function startScan() {
        document.getElementById('btnStartScan').classList.add('hidden');
        document.getElementById('scanStatus').textContent = 'Mengaktifkan kamera...';

        html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 220, aspectRatio: 1.0 }, // dipaksa 1:1 biar tidak overflow
            (decodedText) => {
                html5QrCode.stop().then(() => {
                    // document.getElementById('scanKodeInput').value = decodedText; // old
                    document.getElementById('scanKodeInput').value = extractKode(decodedText);
                    document.getElementById('formScanResult').submit();
                });
            },
            (errorMessage) => {}
        ).then(() => {
            // ditambahkan: update status setelah kamera berhasil nyala
            document.getElementById('scanStatus').textContent = 'Arahkan kamera ke QR Code.';
        }).catch((err) => {
            document.getElementById('scanStatus').textContent = 'Gagal mengakses kamera. Pastikan izin kamera diizinkan.';
            document.getElementById('btnStartScan').classList.remove('hidden');
        });
    }

        function stopScan() {
        const resetTampilan = () => {
            document.getElementById('btnStopScan').classList.add('hidden');
            document.getElementById('btnStartScan').classList.remove('hidden');
            document.getElementById('scanStatus').textContent = 'Kamera dihentikan. Klik Mulai Scan untuk memulai lagi.';
        };

        if (!html5QrCode) {
            resetTampilan();
            return;
        }

        html5QrCode.stop()
            .then(() => html5QrCode.clear())
            .catch(() => {})
            .finally(resetTampilan);
    }
</script>
@endsection