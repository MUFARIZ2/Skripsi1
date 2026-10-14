<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Batch Produksi - Teh Olive</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #f3f4f6;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .toolbar {
            max-width: 800px;
            margin: 16px auto 0;
            padding: 0 16px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #1a1a1a;
            cursor: pointer;
        }
        .btn-primary { background: #075E4D; border-color: #075E4D; color: #fff; }

        .paper {
            max-width: 800px;
            margin: 16px auto;
            background: #fff;
            padding: 32px;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }

        .kop { display: flex; align-items: center; gap: 16px; padding-bottom: 12px; border-bottom: 3px double #1a1a1a; }
        .kop img { width: 72px; height: 72px; object-fit: contain; }
        .kop h2 { margin: 0; font-size: 20px; letter-spacing: 1px; }
        .kop p { margin: 2px 0 0; font-size: 12px; color: #444; }

        h1 { font-size: 16px; text-align: center; margin: 22px 0 2px; }
        .periode { text-align: center; color: #555; margin: 0 0 18px; }

        .tabel-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; }
        th { background: #f2f2f2; }
        tfoot td { font-weight: bold; background: #f9f9f9; }

        .ttd-wrap { margin-top: 28px; display: flex; justify-content: flex-end; }
        .ttd { width: 240px; text-align: center; }
        .ttd .area { position: relative; height: 110px; }
        .ttd .area img {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 105px;
            height: 105px;
            transform: translate(-50%, -50%) rotate(-8deg);
            opacity: .9;
        }
        .ttd .nama { font-weight: bold; border-top: 1px solid #1a1a1a; padding-top: 4px; }

        @media print {
            @page { size: A4 portrait; margin: 1.5cm; }
            body { background: #fff; }
            .toolbar { display: none !important; }
            .paper { max-width: none; margin: 0; padding: 0; box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <a href="{{ route('admin.laporan.index', ['mulai' => $mulai, 'akhir' => $akhir, 'produk' => $produkId]) }}" class="btn">Kembali</a>
        <button type="button" class="btn btn-primary" onclick="window.print()">Cetak</button>
    </div>

    <div class="paper">

        <div class="kop">
            <img src="{{ asset('logo_teh_olive.png') }}" alt="Logo Teh Olive">
            <div>
                <h2>TEH OLIVE</h2>
                <p>Minuman Serbuk Tradisional</p>
                <p>Winduhaji, Kuningan, Jawa Barat &middot; NIB 1705220025607</p>
            </div>
        </div>

        <h1>Laporan Batch Produksi</h1>
        <p class="periode">
            Periode: {{ \Carbon\Carbon::parse($mulai)->translatedFormat('d F Y') }}
            s/d {{ \Carbon\Carbon::parse($akhir)->translatedFormat('d F Y') }}
        </p>

        <div class="tabel-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Batch</th>
                        <th>Produk</th>
                        <th>Jumlah QR</th>
                        <th>Tgl Produksi</th>
                        <th>Tgl Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($batches as $i => $batch)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $batch->batch_code }}</td>
                            <td>{{ $batch->product->name }}</td>
                            <td>{{ $batch->qr_count }}</td>
                            <td>{{ $batch->production_date->translatedFormat('d M Y') }}</td>
                            <td>{{ $batch->expiry_date->translatedFormat('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak ada batch pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total Batch: {{ $totalBatch }}</td>
                        <td colspan="3">Total QR: {{ number_format($totalQr, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="ttd-wrap">
            <div class="ttd">
                <div>Kuningan, {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
                <div class="area">
                    <img src="{{ asset('cap_teh_olive.png') }}" alt="Cap Teh Olive">
                </div>
                <div class="nama">Admin</div>
            </div>
        </div>

    </div>

</body>
</html>