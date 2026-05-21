<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a1a; }
        .header { text-align: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid #6C8B6B; }
        .header h1 { font-size: 20px; font-weight: bold; color: #0F0937; }
        .header p { color: #666; margin-top: 4px; font-size: 11px; }
        .summary { display: flex; gap: 16px; margin-bottom: 20px; }
        .summary-box { flex: 1; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; }
        .summary-box .label { font-size: 10px; color: #666; margin-bottom: 4px; }
        .summary-box .value { font-size: 16px; font-weight: bold; color: #0F0937; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background-color: #F8F5F0; }
        th { padding: 10px 12px; text-align: left; font-size: 11px; color: #444; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
        td { padding: 9px 12px; font-size: 11px; border-bottom: 1px solid #f0f0f0; }
        tr:nth-child(even) td { background-color: #fafafa; }
        .footer { margin-top: 24px; text-align: right; font-size: 10px; color: #999; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Pembayaran Kost</h1>
        <p>
            Periode:
            {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}
        </p>
        <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $pembayaran->count() }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Total Nominal</div>
            <div class="value">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Penghuni</th>
                <th>Kamar</th>
                <th>Periode</th>
                <th>Nominal</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->tagihan->user?->nama }}</td>
                <td>{{ $p->tagihan->kamar?->nomor_kamar }}</td>
                <td>{{ $p->tagihan->tanggal_mulai?->format('d M Y') }} s/d {{ $p->tagihan->tanggal_selesai?->format('d M Y') }}</td>
                <td>Rp {{ number_format($p->nominal_pembayaran, 0, ',', '.') }}</td>
                <td>{{ $p->tanggal_bayar?->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#999; padding: 20px;">
                    Tidak ada data.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan dibuat otomatis oleh sistem.
    </div>

</body>
</html>