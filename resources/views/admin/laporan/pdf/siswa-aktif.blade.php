<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Siswa Paling Aktif</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #9333ea; color: white; }
        tr:nth-child(even) { background-color: #faf5ff; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
        .text-center { text-align: center; }
        .rank { display: inline-block; width: 24px; height: 24px; border-radius: 50%; text-align: center; line-height: 24px; font-weight: bold; color: white; }
        .rank-1 { background: #fbbf24; }
        .rank-2 { background: #9ca3af; }
        .rank-3 { background: #f97316; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SISWA PALING AKTIF</h1>
        <p>Perpustakaan {{ $setting->get('nama_sekolah', 'SD N 3 Prabumulih') }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">Peringkat</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th class="text-center">Jumlah Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $index => $siswa)
                <tr>
                    <td class="text-center">
                        @if($index < 3)
                            <span class="rank rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </td>
                    <td>{{ $siswa->name }}</td>
                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="text-center"><strong>{{ $siswa->peminjamans_count }}</strong> buku</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data siswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Top 20 siswa dengan peminjaman terbanyak</p>
    </div>
</body>
</html>
