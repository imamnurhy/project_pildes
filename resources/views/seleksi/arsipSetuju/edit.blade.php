@extends('layouts.app')

@section('title', 'Data Arsip Disetujui')

@section('style')
<style>
    .list-group-item{padding:.3rem 1.25rem}
    .custom-control-label::after, .custom-control-label::before{top:0px !important}
</style>
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
					<div class="pb-3">
						<div class="image mr-3  float-left">
							@if($tmpelamar->tmregistrasi->foto != '')
								<img class="user_avatar no-b no-p" src="{{ env('SFTP_SRC').'syarat/'.$tmpelamar->tmregistrasi->foto }}" alt="User Image">
							@endif
						</div>
						<div>
							<h5>{{ $tmpelamar->tmregistrasi->n_pegawai }} @if($tmpelamar->tmregistrasi->c_tangsel == 1)<i class="icon-check_circle"></i>@endif</h5>
							{{ $tmpelamar->tmregistrasi->n_opd.' - '.$tmpelamar->tmregistrasi->instansi }}
						</div>
					</div>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('arsipSetuju') }}"><i class="icon icon-arrow_back"></i>Semua Arsip Disetujui</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        @include('seleksi.pelamar')
        
        <div class="card no-b no-r mt-3">
            <div class="card-body">
                <strong class="card-title">Kesimpulan</strong>
                <div class="form-inline">
                    <div class="form-group m-0 col-md-12">
                        <label for="n_panselnas" class="col-form-label s-12 col-md-2">Nama Pansel</label>
                        <label>{{ $tmpelamar->n_panselnas }}</label>
                    </div>
                    <div class="form-group m-0 col-md-12">
                        <label for="c_tolak" class="col-form-label s-12 col-md-2">Keputusan</label>
                        <label>
                            @if($tmpelamar->c_tolak === 1)
                                <strong class="text-danger">Ditolak</strong>
                            @else
                                <strong class="text-success">Disetujui</strong>
                            @endif
                        </label>
                    </div>
                    <div class="form-group m-0 col-md-12" id="v_alasan_tolak" {{ $tmpelamar->c_tolak === 1 ? '' : "style=display:none" }}>
                        <label for="alasan_tolak" class="col-form-label s-12 col-md-2">Alasan</label>
                        <label>{{ $tmpelamar->alasan_tolak }}</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card no-b no-r mt-3">
            <div class="card-body">
                <strong class="card-title">Keputusan</strong>
                <div class="form-inline">
                    <div class="form-group m-0 col-md-12">
                        <label for="c_tolak" class="col-form-label s-12 col-md-2">Keputusan</label>
                        <label>
                            @if($tmpelamar->c_tolak === 1)
                                <strong class="text-danger">Ditolak</strong>
                            @else
                                <strong class="text-success">Disetujui</strong>
                            @endif
                        </label>
                    </div>
                </div>
                
                <div class="form-inline">
                    @if($tmpelamar->c_tolak == 0)
                    <strong class="card-title">Set Jadwal Seleksi</strong>
                    <div class="form-group m-0 col-md-12">
                        <label for="c_tolak" class="col-form-label s-12 col-md-2">Tes Kesehatan</label>
                        <input type="text" name="d_kesehatan_dari" id="d_kesehatan_dari" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_kesehatan_dari, 0, -3) !!}" required>
                        <label class="col-md-1"> s.d. </label>
                        <input type="text" name="d_kesehatan_sampai" id="d_kesehatan_sampai" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_kesehatan_sampai, 0, -3) !!}" required>
                    </div>
                    <div class="form-group m-0 col-md-12">
                        <label for="c_tolak" class="col-form-label s-12 col-md-2">Tes Assesment</label>
                        <input type="text" name="d_assesment_dari" id="d_assesment_dari" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_assesment_dari, 0, -3) !!}" required>
                        <label class="col-md-1"> s.d. </label>
                        <input type="text" name="d_assesment_sampai" id="d_assesment_sampai" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_assesment_sampai, 0, -3) !!}" required>
                    </div>
                    <div class="form-group m-0 col-md-12">
                        <label for="c_tolak" class="col-form-label s-12 col-md-2">Tes Wawancara</label>
                        <input type="text" name="d_wawancara_dari" id="d_wawancara_dari" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_wawancara_dari, 0, -3) !!}" required>
                        <label class="col-md-1"> s.d. </label>
                        <input type="text" name="d_wawancara_sampai" id="d_wawancara_sampai" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_wawancara_sampai, 0, -3) !!}" required>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection