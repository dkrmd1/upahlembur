<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Lembur Detail</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        h2 { margin: 0; }
        .subtitle {
            font-size: 13px;
            margin: 5px 0 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        {{-- Tambahkan logo jika perlu --}}
        <img src="{{ public_path('assets/img/jb/bjbsekuritas.png') }}" alt="Logo">
        <h2>LAPORAN LEMBUR DETAIL</h2>
        <p class="subtitle">Bulan {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</p>
        <p class="subtitle">Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Tanggal</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Upah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalJam = 0;
                $totalUpah = 0;
            @endphp

            @forelse ($lemburData as $i => $item)
                @php
                    $tanggal = \Carbon\Carbon::parse($item->tanggal);
                    $hari = $tanggal->translatedFormat('l');
                    $totalJam += $item->jam;
                    $totalUpah += $item->upah;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->karyawan->nama ?? '-' }}</td>
                    <td>{{ $item->karyawan->nip ?? '-' }}</td>
                    <td>{{ $tanggal->format('d-m-Y') }}</td>
                    <td>{{ $hari }}</td>
                    <td>{{ $item->jam }} Jam</td>
                    <td>Rp {{ number_format($item->upah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data lembur.</td>
                </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="5">TOTAL</td>
                <td>{{ $totalJam }} Jam</td>
                <td>Rp {{ number_format($totalUpah, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
