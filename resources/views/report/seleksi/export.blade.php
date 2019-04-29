<style>
.badge-primary {
    color: #fff;
    background-color: #03a9f4;
}
.text-danger {
    color: #ed5564!important;
}
.text-success {
    color: #7dc855!important;
}
</style>
<table border="1">
          <thead>
                    <tr>
                              <td></td>
                              <td colspan="23">Lampiran Berita Acara</td>
                    </tr>
                    <tr>
                              <td></td>
                              <td colspan="23">Nomor  : 829/&nbsp; &nbsp;  &nbsp; &nbsp; -BA.SekrPANSELJPT/{{ Carbon\Carbon::parse($d_dari)->format('Y') }}</td>
                    </tr>
                    <tr>
                              <td colspan="24">&nbsp;</td>
                    </tr>
                    <tr>
                              <td></td>
                              <td colspan="23">REKAPITULASI PENDAFTARAN SELEKSI JPT PRATAMA ESELON II.b PEMERINTAH KOTA TANGERANG SELATAN</td>
                    </tr>
                    <tr>
                              <td></td>
                              <td colspan="23">PER TANGGAL {{ Carbon\Carbon::parse($d_dari)->format('d F Y').' s.d. '.Carbon\Carbon::parse($d_sampai)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                              <td colspan="24">&nbsp;</td>
                    </tr>
                    <tr>
                              <td></td>
                              <td colspan="23">Jumlah Lamaran : {{ $tmpelamars->count() }}</td>
                    </tr>
                    <tr>
                              <td></td>
                              <td colspan="23">Dicetak Pada Tanggal : {{ Carbon\Carbon::parse(date('Y-m-d H:i:s'))->format('d F Y H:i:s') }}</td>
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
                              <th>Jabatan Yang Dilamar</th>
                              <th>Status</th>
                              <th>Tgl Melamar</th>
                    </tr>
          </thead>
          <tbody>
                    @php $i = 1 @endphp
                    @foreach($tmpelamars as $key=>$tmpelamar)
                    <tr>
                              <td>{{ $i++ }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->nip }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->n_pegawai }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->email }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->telp }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->alamat }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->n_unitkerja }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->n_opd }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->nik }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->t_lahir.', '.$tmpelamar->tmregistrasi->d_lahir }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->jk }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->pekerjaan }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->golongan->n_golongan }}</td>
                              <td>{{ Carbon\Carbon::parse($tmpelamar->tmregistrasi->tmt_golongan)->format('d F Y') }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->eselon->n_eselon }}</td>
                              <td>{{ Carbon\Carbon::parse($tmpelamar->tmregistrasi->tmt_eselon)->format('d F Y') }} </td>
                              <td>{{ $tmpelamar->tmregistrasi->jabatan }}</td>
                              <td>{{ $tmpelamar->tmregistrasi->instansi }}</td>
                              <td>
                                        @if($tmpelamar->tmregistrasi->foto != '')
                                                  <img src="{{ env('SFTP_SRC').'syarat/'.$tmpelamar->tmregistrasi->foto }}" alt="foto" width="120px"/>
                                        @endif
                              </td>
                              <td>{{ $tmpelamar->tmregistrasi->c_tangsel == 1 ? 'Ya' : 'Tidak' }}</td>
                              <td>{{ Carbon\Carbon::parse($tmpelamar->tmregistrasi->created_at)->format('d F Y H:i:s') }}</td>
                              <td>{{ $tmpelamar->tmlelang->n_lelang }}</td>
                              <td>
                                        @php
                                        $txtStatus = '';
                                        if($tmpelamar->n_panselnas == ''){
                                                  $txtStatus .= "<br/> Belum diseleksi. ";
                                        }else{
                                                  if($tmpelamar->c_tolak == 0){
                                                            $txtStatus .= "<br/><strong class='text-success'> Di Setujui </strong>";
                                                  }else{
                                                            $txtStatus .= "<br/><strong class='text-danger'> Di Tolak </strong>";
                                                  }
                                                  $txtStatus .= "<br/> Oleh : ".$tmpelamar->n_panselnas;
                                        }
                                        @endphp
                                        <span class="badge badge-primary r-5">{{ $tmpelamar->tmpelamar_status->n_status }}</span><small>{!! $txtStatus !!}</small>
                              </td>
                              <td>{{ Carbon\Carbon::parse($tmpelamar->created_at)->format('d F Y H:i:s') }}</td>
                    </tr>
                    @endforeach
          </tbody>
</table>
@php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_lamaran.xls");
@endphp