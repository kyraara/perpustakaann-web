<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Buku</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #16a34a; color: white; }
        tr:nth-child(even) { background-color: #f0fdf4; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
        .text-center { text-align: center; }
        .badge-green { background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 8px; }
        .badge-red { background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STOK BUKU</h1>
        <p>Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Dipinjam</th>
                <th class="text-center">Tersedia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $index => $buku)
                @php $tersedia = $buku->stok - $buku->dipinjam; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $buku->kode_buku }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->kategori->nama_kategori }}</td>
                    <td>{{ $buku->rak->nama_rak }}</td>
                    <td class="text-center">{{ $buku->stok }}</td>
                    <td class="text-center">{{ $buku->dipinjam }}</td>
                    <td class="text-center">
                        <span class="{{ $tersedia > 0 ? 'badge-green' : 'badge-red' }}">{{ $tersedia }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total: {{ $bukus->count() }} judul buku | Total Stok: {{ $bukus->sum('stok') }} eksemplar</p>
    </div>
</body>
</html>
