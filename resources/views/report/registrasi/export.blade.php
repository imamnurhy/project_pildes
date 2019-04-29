<table border="1">
          <thead>
                    <tr>
                              <th></th>
                              <th colspan="20">REKAPITULASI REGISTRASI SELEKSI JPT PRATAMA ESELON II.b PEMERINTAH KOTA TANGERANG SELATAN</th>
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
                              <th>NIP</th>
                              <th>Nama</th>
                              <th>Email</th>
                              <th>Telp</th>
                              <th>Alamat</th>
                              <th>Unit Kerja</th>
                              <th>OPD</th>
                              <th>NIK</th>
                              <th>TTL</th>
                              <th>Jenis Kelamin</th>
                              <th>Pekerjaan</th>
                              <th>Golongan</th>
                              <th>TMT Golongan</th>
                              <th>Eselon</th>
                              <th>TMT Eselon</th>
                              <th>Jabatan</th>
                              <th>Instansi</th>
                              <th>Foto</th>
                              <th><em>Verified</em></th>
                              <th>Tgl Registrasi</th>
                    </tr>
          </thead>
          <tbody>
                    @php $i = 1 @endphp
                    @foreach($tmregistrasis as $key=>$tmregistrasi)
                    <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ $tmregistrasi->nip }}</td>
                              <td>{{ $tmregistrasi->n_pegawai }}</td>
                              <td>{{ $tmregistrasi->email }}</td>
                              <td>{{ $tmregistrasi->telp }}</td>
                              <td>{{ $tmregistrasi->alamat }}</td>
                              <td>{{ $tmregistrasi->n_unitkerja }}</td>
                              <td>{{ $tmregistrasi->n_opd }}</td>
                              <td>{{ $tmregistrasi->nik }}</td>
                              <td>{{ $tmregistrasi->t_lahir.', '.$tmregistrasi->d_lahir }}</td>
                              <td>{{ $tmregistrasi->jk }}</td>
                              <td>{{ $tmregistrasi->pekerjaan }}</td>
                              <td>{{ $tmregistrasi->golongan->n_golongan }}</td>
                              <td>{{ Carbon\Carbon::parse($tmregistrasi->tmt_golongan)->format('d F Y') }}</td>
                              <td>{{ $tmregistrasi->eselon->n_eselon }}</td>
                              <td>{{ Carbon\Carbon::parse($tmregistrasi->tmt_eselon)->format('d F Y') }} </td>
                              <td>{{ $tmregistrasi->jabatan }}</td>
                              <td>{{ $tmregistrasi->instansi }}</td>
                              <td>
                                        @if($tmregistrasi->foto != '')
                                                  <img src="{{ env('SFTP_SRC').'syarat/'.$tmregistrasi->foto }}" alt="foto" width="120px"/>
                                        @endif
                              </td>
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