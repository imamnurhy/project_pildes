<div class="row">
    <div class="col-md-4">
        <div class="card no-b no-r">
            <div class="card-body">
                <strong class="card-title blue-text"><i class="icon-user"></i> Data Pribadi</strong>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong class="s-12">NIK</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nik_pl }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Jenis Kelamin</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->jk_pl }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Alamat</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->alamat_pl }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">TTL</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->t_lahir_pl.', '.Carbon\Carbon::parse($tmpelamar->tmregistrasi->d_lahir_pl)->format('d F Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Pekerjaan</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->pekerjaan_pl }}</span>
                    </li>
                </ul>
            </div><hr class="m-0">
            {{-- <div class="card-body">
                <strong class="card-title light-green-text"><i class="icon-wpforms"></i> Data Jabatan</strong>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong class="s-12">NIP</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->nip }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Golongan</strong>
                        <span class="s-12 float-right">{{ $n_golongan }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">TMT Golongan</strong>
                        <span class="s-12 float-right">{{ Carbon\Carbon::parse($tmpelamar->tmregistrasi->tmt_golongan)->format('d F Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Eselon</strong>
                        <span class="s-12 float-right">{{ $n_eselon }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">TMT Eselon</strong>
                        <span class="s-12 float-right">{{ Carbon\Carbon::parse($tmpelamar->tmregistrasi->tmt_eselon)->format('d F Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Jabatan</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->jabatan }}</span>
                    </li>
                </ul>
            </div> --}}
            <hr class="m-0">
            <div class="card-body">
                <strong class="card-title"><i class="icon-plus"></i> Data Tambahan</strong>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong class="s-12">Email</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->email_pr }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong class="s-12">Telp</strong>
                        <span class="s-12 float-right">{{ $tmpelamar->tmregistrasi->no_tlp_pl }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8 pl-0">
        <div class="card no-b no-r mb-3">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-success">
                        <strong>Nomor Registrasi</strong>
                        <strong class="float-right">{{ $tmpelamar->no_pendaftaran }}</strong>
                    </li>
                </ul>
                <strong class="card-title purple-text"><i class="icon-person_pin"></i> Jabatan Yang Dilamar</strong>
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
