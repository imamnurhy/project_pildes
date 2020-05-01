@extends('layouts.app')

@section('title', 'Data Arsip Ditolak')

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
                        <a class="nav-link" href="{{ route('arsipTolak') }}"><i class="icon icon-arrow_back"></i>Semua Arsip Ditolak</a>
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
                <strong class="card-title">Kesimpulan Tim Panselnas</strong>
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
                <strong class="card-title">Kesimpulan Admin Panselnas</strong>
                <div class="form-inline">
                    <div class="form-group m-0 col-md-12">
                        <label for="n_panselnas" class="col-form-label s-12 col-md-2">Nama Pansel</label>
                        <label>{{ $tmpelamar->n_admin_panselnas }}</label>
                    </div>
                    <div class="form-group m-0 col-md-12">
                        <label for="c_tolak" class="col-form-label s-12 col-md-2">Keputusan</label>
                        <label>
                            @if($tmpelamar->c_tolak_admin === 1)
                                <strong class="text-danger">Ditolak</strong>
                            @else
                                <strong class="text-success">Disetujui</strong>
                            @endif
                        </label>
                    </div>
                    <div class="form-group m-0 col-md-12" id="v_alasan_tolak" {{ $tmpelamar->c_tolak_admin === 1 ? '' : "style=display:none" }}>
                        <label for="alasan_tolak" class="col-form-label s-12 col-md-2">Alasan</label>
                        <label>{{ $tmpelamar->alasan_tolak_admin_panselnas }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
