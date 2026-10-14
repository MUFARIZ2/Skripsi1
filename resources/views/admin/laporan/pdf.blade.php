<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Batch Produksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1a1a1a; }
        h1 { font-size: 16px; text-align: center; margin-bottom: 2px; }
        p.periode { text-align: center; color: #555; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tfoot td { font-weight: bold; background-color: #f9f9f9; }
                table.kop { width: 100%; border-collapse: collapse; }
        table.kop td { border: none; padding: 0; vertical-align: middle; }
        .kop-nama { font-size: 20px; font-weight: bold; letter-spacing: 1px; }
        .kop-sub { font-size: 12px; color: #444; }
        .kop-alamat { font-size: 10px; color: #444; }
        .garis { border-top: 3px double #333; margin: 6px 0 16px 0; }
        table.ttd { width: 100%; border-collapse: collapse; margin-top: 30px; }
        table.ttd td { border: none; padding: 0; text-align: center; vertical-align: top; }
        .ttd-garis { border-top: 1px solid #333; width: 100%; margin: 0 auto 4px auto; }</style>
</head>
<body>

        <table class="kop">
        <tr>
            <td style="width: 70px;">
                <img src="{{ public_path('logo_teh_olive.png') }}" width="60" height="60">
            </td>
            <td>
                <div class="kop-nama">TEH OLIVE</div>
                <div class="kop-sub">Minuman Serbuk Tradisional</div>
                <div class="kop-alamat">Winduhaji, Kuningan, Jawa Barat · NIB 1705220025607</div>
            </td>
        </tr>
    </table>
    <div class="garis"></div>
    <h1>Laporan Batch Produksi</h1>
    <p class="periode">
        Periode: {{ \Carbon\Carbon::parse($mulai)->translatedFormat('d F Y') }}
        s/d {{ \Carbon\Carbon::parse($akhir)->translatedFormat('d F Y') }}
    </p>

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
                <td colspan="2">Total Batch: {{ $totalBatch }}</td>
                <td colspan="4">Total QR: {{ number_format($totalQr, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

        <table class="ttd">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">
                Kuningan, {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                <div style="height: 110px;">
                    <img src="{{ public_path('cap_teh_olive.png') }}" width="95" style="margin-top: 5px;">
                </div>
                <div class="ttd-garis"></div>
                <strong>Admin</strong>
            </td>
        </tr>
    </table>
</body>
</html>