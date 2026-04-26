<!DOCTYPE html>
<html>

<head>
    <title>Laporan Arus Lalu Lintas Parkir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        p {
            text-align: center;
            margin-top: 5px;
            color: #555;
        }
    </style>
</head>

<body>

    <h2>Laporan Arus Lalu Lintas Kendaraan</h2>
    <p>Sistem SmartParking & Traffic Flow - Politeknik Negeri Padang</p>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>Lokasi Area</th>
                <th>Kamera CCTV</th>
                <th class="text-center">K. Masuk</th>
                <th class="text-center">K. Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($traffics as $index => $t)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $t->tanggal }}</td>
                    <td>{{ $t->kamera->area->nama_area ?? '-' }}</td>
                    <td>{{ $t->kamera->nama_kamera ?? '-' }}</td>
                    <td class="text-center">{{ $t->kendaraan_masuk }}</td>
                    <td class="text-center">{{ $t->kendaraan_keluar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
