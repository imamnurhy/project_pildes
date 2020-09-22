<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pendapatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan pendapatan</h4>
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Aset</th>
                <th>Jenis Aset</th>
                <th>Nilai</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tmasets as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
                <td>{{ $item->n_jenis_aset }}</td>
                <td>{{ $item->n_rincian }}</td>
                <td>{{ $item->nilai }}</td>
                <td>{{ $item->tahun }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
