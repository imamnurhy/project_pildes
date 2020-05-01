<table border="1">
          <thead>
                    <tr>
                              <th></th>
                              <th colspan="20">REKAPITULASI REGISTRASI PEMILIHAN CALON MITRA SEWA DINAS PERHUNGAN KOTA TANGERANG SELATAN</th>
                    </tr>
                    <tr>
                              <th></th>
                              <th colspan="20">TANGGAL {{ Carbon\Carbon::parse($d_dari)->format('d F Y').' s.d. '.Carbon\Carbon::parse($d_sampai)->format('d F Y') }}</th>
                    </tr>
          </thead>
          <tbody>
                    <tr>
                              <td></td>
                              <td colspan="20">Jumlah Registrasi : {{ $tmregistrasis->count() }}</td>
                    </tr>
                    <tr>
                              <td></td>
                              <td colspan="20">Dicetak Pada Tanggal : {{ Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('d F Y H:i:s') }}</td>
                    </tr>
          </tbody>
          <thead>
                    <tr>
                              <th>NO</th>
                              <th>NIK</th>
                              <th>Nama</th>
                              <th>Tempat Lahir</th>
                              <th>Tanggal Lahir</th>
                              <th>Pekerjaan</th>
                              <th>Alamat</th>
                              <th>No Telp</th>
                              {{-- <th>Foto</th> --}}
                              <th><em>Verified</em></th>
                              <th>Tgl Registrasi</th>
                    </tr>
          </thead>
          <tbody>
                    @php $i = 1 @endphp
                    @foreach($tmregistrasis as $key=>$tmregistrasi)
                    <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ $tmregistrasi->nik_pl }}</td>
                              <td>{{ $tmregistrasi->nama_pl }}</td>
                              <td>{{ $tmregistrasi->t_lahir_pl }}</td>
                              <td>{{ Carbon\Carbon::parse($tmregistrasi->d_lahir_pl)->format('d F Y') }}</td>
                              <td>{{ $tmregistrasi->pekerjaan_pl }}</td>
                              <td>{{ $tmregistrasi->alamat_pl }}</td>
                              <td>{{ $tmregistrasi->no_tlp_pl }}</td>
                              {{-- <td>
                                        @if($tmregistrasi->foto_pl != '')
                                                  <img src="{{ env('SFTP_SRC').'register/'.$tmregistrasi->foto_pl }}" alt="foto" width='60'  height='60'/>
                                        @endif
                              </td> --}}
                              <td>{{ $tmregistrasi->c_tangsel == 1 ? 'Ya' : 'Tidak' }}</td>
                              <td>{{ $tmregistrasi->created_at }}</td>
                    </tr>
                    @endforeach
          </tbody>
</table>
@php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_registrasi.xls");
@endphp
