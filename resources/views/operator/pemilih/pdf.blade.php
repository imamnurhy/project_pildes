<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    @yield('style')

    <title>{{ config('app.name', 'Laravel') }} | SURAT UNDAGAN PILKADES</title>

</head>

<body>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 11px;
            margin: 0.7cm 1.5cm 0.7cm 0.8cm;
            padding: 0px
        }

        @page {
            size: letter potrait;
            margin: 0cm;
            padding: 0cm;
            size: 21.0cm 29.7cm,
        }

        p {
            margin: 0px;
            padding: 0px
        }

        hr {
            margin: 1px;
        }

        .page-break {
            page-break-after: always;
        }

        .heading {
            font-size: 13px
        }

        .heading15 {
            font-size: 15px
        }
    </style>

    <div style="height: 7cm">
        @foreach ($pemilihs as $pemilih)
        <table width="100%">
            <tbody>
                <tr>
                    {{-- Fungsi jika logo tidak muncul saat di export ke pdf --}}
                    <?php
                                                $path = public_path('/logo_1.png');
                                                $type = pathinfo($path, PATHINFO_EXTENSION);
                                                $data = file_get_contents($path);
                                                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                            ?>
                    <td width="150px" align="center"><img width="50%" src="{{ $base64 }}" alt="Logos" /></td>
                    <td align="center">
                        <strong class="heading">
                            PANITIA PEMILIHAN KEPALA DESA<br>
                            DESA PADURENAN <br>
                            KECAMATAN GUNUNGSINDUR KABUPATEN BOGOR <br>
                            Sekretariat : Jl. Padurenan V RT.03/03 Ds. Padurenan Kec. Gunungsindur Kab. Bogor
                            HP.
                            085716138570
                        </strong>
                    </td>
                    <?php
                                                $path2 = public_path('/logo_2.png');
                                                $type2 = pathinfo($path2, PATHINFO_EXTENSION);
                                                $data2 = file_get_contents($path2);
                                                $base642 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
                                            ?>
                    <td width="150px"><img width="50%" src="{{ $base642 }}" alt="Logos" /></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr style="border:1px #000 solid" />
                    </td>
                </tr>

                <tr>
                    <td colspan="3" align="right">
                        <span>No Pemilih : {{ $pemilih->id }}</span>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" align="center">
                        <strong class="heading">
                            SURAT UNDANGAN<br>
                            Untuk Memberikan Suara Pada Pemilihan Kepala Desa Padurenan
                        </strong>
                    </td>
                </tr>

            </tbody>
        </table>

        <br>

        <table width="50%" cellspacing="2px">
            <tbody>
                <tr>
                    <td width="10%"></td>
                    <td width="50%">Nama pemilih</td>
                    <td> : </td>
                    <td>{{ $pemilih->n_pemilih }}</td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td>Jenis Kelamin</td>
                    <td> : </td>
                    <td>{{ $pemilih->jk }}</td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td>NIK</td>
                    <td> : </td>
                    <td>{{ $pemilih->nik }}</td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td>Alamat</td>
                    <td> : </td>
                    <td>{{ $pemilih->alamat }}</td>
                </tr>

                <tr>
                    <td width="10%"></td>
                    <td>Waktu pemungutan suara</td>
                    <td> : </td>
                    <td>Minggu , 09 Maret 2014</td>
                </tr>

                <tr>
                    <td width="10%"></td>
                    <td>Tempat pemungutan suara</td>
                    <td> : </td>
                    <td>KP. PADURENAN RT.04 / RW.02 DESA PADURENAN</td>
                </tr>

            </tbody>
        </table>

        <table width="100%">
            <tbody>
                <tr>
                    <td width="5%"></td>
                    <td width="50%"></td>
                    <td width="50%">
                        <div style="text-align: center">
                            {{ 'Padurenan' . date('d M Y') }} <br>
                            ketua Panitia <br>
                            Pemilihan Kepala Desa Padurenan <br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="5%"></td>
                    <td width="50%">
                        <span>
                            KETERANGAN : <br>
                            1.Pemilih tidak boleh mewakilkan dalam memberikan suara <br>
                            2.Agar membawa undangan yang sudah diberikan <br>
                        </span>
                    </td>
                    <td width="50%"> </td>
                </tr>
                <tr>
                    <td width="5%"></td>
                    <td width="50%">
                        <span>PANITIA</span>
                    </td>
                    <td width="50%">
                        <div style="text-align: center">
                            ( MUKRON RAISAZ, S.Pd )
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" height="3%">
                        <hr style="border-top: 2px dashed #000;">
                    </td>
                </tr>
            </tbody>
        </table>
        @endforeach
    </div>






</body>

</html>
