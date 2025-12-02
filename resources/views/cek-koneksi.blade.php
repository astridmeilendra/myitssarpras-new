<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Daftar Peminjaman Ruangan</h1>
    <table>
        <thead> 
            <tr>
                <th>ID</th>
                <th>Nama Pemohon</th>
                <th>Keterangan</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $item)
            <tr>
                <td>{{ $item->peminjamanid }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->dokumen }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
