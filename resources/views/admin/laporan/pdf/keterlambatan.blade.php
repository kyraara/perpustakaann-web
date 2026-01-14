<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keterlambatan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #dc2626; color: white; }
        tr:nth-child(even) { background-color: #fff5f5; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
        .badge-red { background: #fee2e2; color: #991b1b; padding: 3px 8px; border-radius: 10px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KETERLAMBATAN</h1>
        <p>Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Keterlambatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $p)
                @php
                    $terlambat = $p->status == 'dipinjam' 
                        ? now()->diffInDays($p->tanggal_kembali, false) * -1
                        : $p->tanggal_dikembalikan->diffInDays($p->tanggal_kembali, false) * -1;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td>{{ $p->tanggal_kembali->format('d M Y') }}</td>
                    <td><span class="badge-red">{{ $terlambat }} hari</span></td>
                    <td>{{ $p->status == 'dipinjam' ? 'Belum Dikembalikan' : 'Sudah Dikembalikan' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data keterlambatan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total: {{ $peminjamans->count() }} peminjaman terlambat</p>
    </div>
</body>
</html>
