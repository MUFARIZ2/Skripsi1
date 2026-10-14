@extends('layouts.admin')

@section('title', 'Tambah Produk - Olive Verify')

@section('content')

    <div class="flex items-center gap-2 text-sm text-subtext mb-6">
        <a href="{{ route('admin.produk.index') }}" class="hover:text-primary">Kelola Produk</a>
        <span>/</span>
        <span class="text-ink font-medium">Tambah Produk</span>
    </div>

    <div class="max-w-2xl bg-white rounded-2xl border border-gray-50 shadow-soft p-8">
        <h1 class="font-display font-semibold text-xl text-ink mb-6">Tambah Produk Baru</h1>

        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-ink mb-2">Foto Produk</label>
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="w-20 h-20 rounded-xl bg-bg border border-dashed border-gray-300 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-subtext" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16v16H4V4z"/></svg>
                    </div>
                    <input type="file" name="foto" accept="image/*" class="min-w-0 max-w-full text-sm text-subtext file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/10 file:text-primary file:text-sm file:font-medium">
                    </div>
                @error('foto')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                
                <div>
                    <label for="nama" class="block text-sm font-medium text-ink mb-2">Nama Produk</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Jamu Kunyit Asam" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    @error('nama')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="varian" class="block text-sm font-medium text-ink mb-2">Varian</label>
                    <input type="text" id="varian" name="varian" placeholder="Contoh: Original" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="ukuran" class="block text-sm font-medium text-ink mb-2">Ukuran</label>
                    <input type="text" id="ukuran" name="ukuran" placeholder="Contoh: 250 ml" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>
                                <div>
                    <label for="harga" class="block text-sm font-medium text-ink mb-2">Harga</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-subtext">Rp</span>
                        <input type="number" id="harga" name="harga" value="{{ old('harga') }}" placeholder="20000" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    </div>
                    @error('harga')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

                        <div>
                <label for="komposisi" class="block text-sm font-medium text-ink mb-2">Komposisi</label>
                <textarea id="komposisi" name="komposisi" rows="3" placeholder="Contoh: Kunyit, asam jawa, gula aren, air"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">{{ old('komposisi') }}</textarea>
                @error('komposisi')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-ink mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsikan produk secara singkat..."
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"></textarea>
            </div>

                        <div class="pt-2 border-t border-gray-100">
                <h2 class="text-sm font-semibold text-ink mt-5 mb-1">Template Label Kemasan</h2>
                <p class="text-xs text-subtext mb-4">Opsional. Unggah desain label, kotak hijau otomatis muncul di kotak putih. Geser kalau perlu, tarik pojok kanan bawah untuk mengubah ukuran.</p>

                <div class="mb-4">
                    <label for="label_image" class="block text-sm font-medium text-ink mb-2">Gambar Desain Label (PNG/JPG)</label>
                    <input type="file" id="label_image" name="label_image" accept="image/png,image/jpeg" class="text-sm text-subtext file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/10 file:text-primary file:text-sm file:font-medium">
                    @error('label_image')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" id="label_width_cm" name="label_width_cm" value="{{ old('label_width_cm', 12) }}">

                <div id="labelEditor" class="hidden mb-4">
                    <p class="text-sm font-medium text-ink mb-2">Posisi QR</p>
                    <div id="labelStage" class="relative inline-block max-w-full border border-gray-200 rounded-lg overflow-hidden select-none touch-none">
                        <img id="labelPreview" src="" alt="Template label" class="block max-w-full h-auto" style="max-height: 480px;" draggable="false">
                        <div id="qrBox" class="absolute border-2 border-primary bg-primary/20 cursor-move" style="display:none;">
                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-semibold text-primary pointer-events-none">QR</span>
                            <div id="qrHandle" class="absolute -right-1.5 -bottom-1.5 w-4 h-4 bg-primary rounded-sm cursor-nwse-resize"></div>
                        </div>
                    </div>
                    <p id="qrReadout" class="text-xs text-subtext mt-2"></p>
                </div>

                <input type="hidden" id="label_qr_x" name="label_qr_x" value="{{ old('label_qr_x') }}">
                <input type="hidden" id="label_qr_y" name="label_qr_y" value="{{ old('label_qr_y') }}">
                <input type="hidden" id="label_qr_size" name="label_qr_size" value="{{ old('label_qr_size') }}">
                @error('label_qr_x')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.produk.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-ink hover:bg-bg transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Simpan Produk</button>
            </div>
        </form>
    </div>

    @push('scripts')
<script>
(function () {
    const fileInput = document.getElementById('label_image');
    const widthInput = document.getElementById('label_width_cm');
    const editor = document.getElementById('labelEditor');
    const img = document.getElementById('labelPreview');
    const box = document.getElementById('qrBox');
    const handle = document.getElementById('qrHandle');
    const readout = document.getElementById('qrReadout');
    const fx = document.getElementById('label_qr_x');
    const fy = document.getElementById('label_qr_y');
    const fs = document.getElementById('label_qr_size');

    let st = { x: 0.1, y: 0.1, s: 0.2 };

    function labelWidthCm() { return parseFloat(widthInput.value) || 0; }

    function render() {
        const w = img.clientWidth, h = img.clientHeight;
        if (!w || !h) return;
        box.style.display = 'block';
        box.style.left = (st.x * w) + 'px';
        box.style.top = (st.y * h) + 'px';
        box.style.width = (st.s * w) + 'px';
        box.style.height = (st.s * w) + 'px';
        writeFields();
    }

    function writeFields() {
        const cm = labelWidthCm();
        if (!cm || !img.naturalWidth) return;
        const hCm = cm * (img.naturalHeight / img.naturalWidth);
        const x = st.x * cm, y = st.y * hCm, s = st.s * cm;
        fx.value = x.toFixed(2); fy.value = y.toFixed(2); fs.value = s.toFixed(2);
        readout.textContent = 'X ' + x.toFixed(2) + ' cm, Y ' + y.toFixed(2) + ' cm, ukuran ' + s.toFixed(2) + ' cm (label ' + cm + ' x ' + hCm.toFixed(2) + ' cm)';
    }

    function detectWhiteBox() {
        const cw = 600;
        const ch = Math.round(cw * img.naturalHeight / img.naturalWidth);
        const c = document.createElement('canvas');
        c.width = cw; c.height = ch;
        const ctx = c.getContext('2d', { willReadFrequently: true });
        ctx.drawImage(img, 0, 0, cw, ch);
        let data;
        try { data = ctx.getImageData(0, 0, cw, ch).data; } catch (e) { return null; }

        const total = cw * ch;
        const white = new Uint8Array(total);
        for (let i = 0; i < total; i++) {
            if (data[i * 4] > 235 && data[i * 4 + 1] > 235 && data[i * 4 + 2] > 235) white[i] = 1;
        }

        const visited = new Uint8Array(total);
        const stack = new Int32Array(total);
        let best = null;

        for (let start = 0; start < total; start++) {
            if (!white[start] || visited[start]) continue;
            let sp = 0, count = 0;
            let minX = cw, maxX = 0, minY = ch, maxY = 0;
            stack[sp++] = start; visited[start] = 1;
            while (sp > 0) {
                const p = stack[--sp];
                const px = p % cw, py = (p / cw) | 0;
                count++;
                if (px < minX) minX = px; if (px > maxX) maxX = px;
                if (py < minY) minY = py; if (py > maxY) maxY = py;
                if (px > 0 && white[p - 1] && !visited[p - 1]) { visited[p - 1] = 1; stack[sp++] = p - 1; }
                if (px < cw - 1 && white[p + 1] && !visited[p + 1]) { visited[p + 1] = 1; stack[sp++] = p + 1; }
                if (py > 0 && white[p - cw] && !visited[p - cw]) { visited[p - cw] = 1; stack[sp++] = p - cw; }
                if (py < ch - 1 && white[p + cw] && !visited[p + cw]) { visited[p + cw] = 1; stack[sp++] = p + cw; }
            }
            const bw = maxX - minX + 1, bh = maxY - minY + 1;
            const ratio = bw / bh;
            const fill = count / (bw * bh);
            if (bw < cw * 0.04 || bw > cw * 0.6) continue;
            if (ratio < 0.85 || ratio > 1.18) continue;
            if (fill < 0.9) continue;
            if (!best || count > best.count) best = { count, minX, minY, bw };
        }

        if (!best) return null;
        return { x: best.minX / cw, y: best.minY / ch, s: best.bw / cw };
    }

    img.addEventListener('load', function () {
        const found = detectWhiteBox();
        st = found || { x: 0.1, y: 0.1, s: 0.2 };
        render();
    });
    window.addEventListener('resize', render);

    fileInput.addEventListener('change', function () {
        const f = this.files[0];
        if (!f) return;
        fx.value = ''; fy.value = ''; fs.value = '';
        img.src = URL.createObjectURL(f);
        editor.classList.remove('hidden');
    });

    function clamp(v, a, b) { return Math.min(Math.max(v, a), b); }

    let mode = null, startX, startY, startSt;

    function pointerDown(e, m) {
        e.preventDefault(); e.stopPropagation();
        mode = m; startX = e.clientX; startY = e.clientY; startSt = { ...st };
        box.setPointerCapture?.(e.pointerId);
        window.addEventListener('pointermove', pointerMove);
        window.addEventListener('pointerup', pointerUp);
    }

    function pointerMove(e) {
        const w = img.clientWidth, h = img.clientHeight;
        const dx = (e.clientX - startX) / w;
        const dy = (e.clientY - startY) / h;
        if (mode === 'move') {
            const sh = st.s * w / h;
            st.x = clamp(startSt.x + dx, 0, 1 - st.s);
            st.y = clamp(startSt.y + dy, 0, 1 - sh);
        } else if (mode === 'resize') {
            const maxS = Math.min(1 - st.x, (1 - st.y) * h / w);
            st.s = clamp(startSt.s + dx, 0.02, maxS);
        }
        render();
    }

    function pointerUp() {
        mode = null;
        window.removeEventListener('pointermove', pointerMove);
        window.removeEventListener('pointerup', pointerUp);
    }

    box.addEventListener('pointerdown', (e) => pointerDown(e, 'move'));
    handle.addEventListener('pointerdown', (e) => pointerDown(e, 'resize'));
})();
</script>
@endpush

@endsection
