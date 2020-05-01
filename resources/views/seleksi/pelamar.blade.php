<div class="row">
    <div class="col-md-6">
        <div class="card no-b no-r">
            <div class="card-body">
                <strong class="card-title blue-text"><i class="icon-user"></i> Data Pengaju</strong>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong class="s-12">Nama</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nama_pj }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">NIK</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nik_pj }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Jenis Kelamin</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->jk_pj }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Alamat</strong>
                        <span class="s-12 float-right">{!! $tmpelamar->tmregistrasi->alamat_pj !!}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">TTL</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->t_lahir_pj.', '.Carbon\Carbon::parse($tmpelamar->tmregistrasi->d_lahir_pj)->format('d F Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Pekerjaan</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->pekerjaan_pj }}</span>
                    </li>
                </ul>
            </div><hr class="m-0">

             <div class="card-body">
                <strong class="card-title light-green-text"><i class="icon-wpforms"></i> Data Pemilik Perusahaan</strong>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong class="s-12">Nama Direktur</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nama_pl }}</span>
                    </li>
                     <li class="list-group-item">
                        <strong class="s-12">NIk</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nik_pl }}</span>
                    </li>
                     <li class="list-group-item">
                        <strong class="s-12">KK</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->kk_pl }}</span>
                    </li>
                      <li class="list-group-item">
                        <strong class="s-12">TTL</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->t_lahir_pl.', '.Carbon\Carbon::parse($tmpelamar->tmregistrasi->d_lahir_pl)->format('d F Y') }}</span>
                    </li>

                     <li class="list-group-item">
                        <strong class="s-12">Jenis Kelamin</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->jk_pl }}</span>
                    </li>

                     <li class="list-group-item">
                        <strong class="s-12">Pekerjaan</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->pekerjaan_pl }}</span>
                    </li>

                     <li class="list-group-item">
                        <strong class="s-12">Alamat</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->alamat_pl }}</span>
                    </li>

                    <li class="list-group-item">
                        <strong class="s-12">No Telp</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->no_tlp_pl }}</span>
                    </li>

                </ul>
            </div>

            <hr class="m-0">
            <div class="card-body">
                <strong class="card-title"><i class="icon-plus"></i> Data Perusahaan</strong>
                <ul class="list-group list-group-flush">
                     <li class="list-group-item">
                        <strong class="s-12">Nama Direktur</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nama_pl }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Perusahaan</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->n_pr }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">No SIUP</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->siup_pr }}</span>
                    </li>
                     <li class="list-group-item">
                        <strong class="s-12">No NIB</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nib_pr }}</span>
                    </li>
                     <li class="list-group-item">
                        <strong class="s-12">No NPWP</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->npwp_pr }}</span>
                    </li>
                    <li class="list-group-item">
                            <strong class="s-12">No Telp</strong>
                            <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->tlp_pr }}</span>
                    </li>
                    <li class="list-group-item">
                            <strong class="s-12">No Fax</strong>
                            <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->fax_pr }}</span>
                    </li>
                    <li class="list-group-item">
                            <strong class="s-12">Email</strong>
                            <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->email_pr }}</span>
                    </li>
                    <li class="list-group-item">
                            <strong class="s-12">Nilai Sewa Dasar</strong>
                            <span class="s-12 float-right">{{ number_format($tmpelamar->penawaran) }}</span>
                    </li>
                    <li class="list-group-item">
                            <strong class="s-12">Alamat</strong>
                            <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->alamat_pr }}</span>
                     </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 pl-0">
        <div class="card no-b no-r mb-3">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-success">
                        <strong>Nomor Registrasi</strong>
                        <strong class="float-right">{{ $tmpelamar->no_pendaftaran }}</strong>
                    </li>
                </ul>
                <strong class="card-title purple-text"><i class="icon-person_pin"></i> Lahan Yang Dilamar</strong>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>{{ $tmpelamar->tmlelang->n_lelang }}</strong>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card no-b no-r" style="min-height:465px">
            <div class="card-body">
                <strong class="card-title orange-text"><i class="icon-attach_file"></i> Kelengkapan Berkas</strong>
                <table class="table ml-3">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama Syarat</th>
                            <th width="50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $a = 1 @endphp
                        @foreach($trpelamar_syarats as $key=>$trpelamar_syarat)
                        <tr>
                            <td>{{ $a++ }}</td>
                            <td>{{ $trpelamar_syarat->tmsyarat->n_syarat }}</td>
                            <td align="center"><a href="{{ env('SFTP_SRC').'syarat/'.$trpelamar_syarat->file }}" target="_blank"><i class="icon-download"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
