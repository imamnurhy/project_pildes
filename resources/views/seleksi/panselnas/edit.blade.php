@extends('layouts.app')

@section('title', 'Data Seluruh Pelamar Lahan Parkir')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
					<div class="pb-3">
						<div class="image mr-3  float-left">
							@if($tmpelamar->tmregistrasi->foto_pl != '')
								<img class="user_avatar no-b no-p" src="{{ env('SFTP_SRC').'register/'.$tmpelamar->tmregistrasi->foto_pl }}" alt="User Image">
							@endif
						</div>
						<div>
							<h5>{{ $tmpelamar->tmregistrasi->nama_pl }} @if($tmpelamar->tmregistrasi->c_tangsel == 1)<i class="icon-check_circle"></i>@endif</h5>
							{{ $tmpelamar->tmregistrasi->nik_pl.' - '.$tmpelamar->tmregistrasi->kk_pl }}
						</div>
					</div>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('panselnas') }}"><i class="icon icon-arrow_back"></i>Semua Pelamar Lahan</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        <form class="needs-validation" id="form" method="POST" novalidate="">
            {{-- onsubmit="confirm_form()" --}}

            @include('seleksi.pelamar')

            <div class="card no-b no-r mt-3">
                <div class="card-body">
                <strong class="card-title">Kesimpulan</strong>
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" value="{!! $tmpelamar->id !!}" id="id"/>
                    <div class="form-inline">
                        <div class="form-group m-0 col-md-12">
                            <label for="n_panselnas" class="col-form-label s-12 col-md-2">Nama Pansel</label>
			@php $n_pegawai = (Auth::user()->pegawai ? Auth::user()->pegawai->n_pegawai : '') @endphp
                            <input type="text" name="n_panselnas" id="n_panselnas" placeholder="" class="form-control r-0 light s-12 col-md-10" autocomplete="off" value="{{ $tmpelamar->n_panselnas == '' ? $n_pegawai : $tmpelamar->n_panselnas }}" disabled="disabled">
                        </div>
                        <div class="form-group m-0 col-md-12">
                            <label for="c_tolak" class="col-form-label s-12 col-md-2">Keputusan</label>
                            <br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="c_tolak0" name="c_tolak" value="0" class="custom-control-input"{{ $tmpelamar->c_tolak === 0 ? 'checked="checked"' : '' }} required>
                                <label class="custom-control-label m-0 text-success" for="c_tolak0"><strong>Disetujui</strong></label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="c_tolak1" name="c_tolak" value="1" class="custom-control-input"{{ $tmpelamar->c_tolak === 1 ? 'checked="checked"' : '' }} required>
                                <label class="custom-control-label m-0 text-danger" for="c_tolak1"><strong>Ditolak</strong></label>
                            </div>
                        </div>
                        <div class="form-group m-0 col-md-12" id="v_alasan_tolak" {{ $tmpelamar->c_tolak === 1 ? '' : "style=display:none" }}>
                            <label for="alasan_tolak" class="col-form-label s-12 col-md-2">Alasan</label>
                            <textarea type="text" name="alasan_tolak" id="alasan_tolak" placeholder="" class="form-control r-0 light s-12 col-md-10" autocomplete="off">{{ $tmpelamar->alasan_tolak }}</textarea>
                        </div>
                        <div class="card-body offset-md-2">
                            <button type="button" onclick="confirm_form();" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i class="icon-save mr-2"></i>Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
$('#c_tolak0').click(function(){
    $('#v_alasan_tolak').hide();
});
$('#c_tolak1').click(function(){
    $('#v_alasan_tolak').show();
    $('#alasan_tolak').focus();
});



$('#form').on('submit', function (e) {

    if ($(this)[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
    }
    else{
        $('#alert').html('');
        $('#action').attr('disabled', true);
        url = "{{ route('panselnas.update', ':id') }}".replace(':id', $('#id').val());
        $.ajax({
            url : url,
            type : 'POST',
            data: new FormData($(this)[0]),
            contentType: false,
            processData: false,
            success : function(data) {
                $('#action').removeAttr('disabled');
                $.confirm({
                    title: 'Berhasil',
                    content: 'Data berhasil tersimpan.',
                    icon: 'icon-check',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'green',
                    autoClose: 'cancelAction|5000',
                        escapeKey: 'cancelAction',
                        buttons: {
                            cancelAction: {
                                text: 'Ke Halaman Tabel Panselnas',
                                action: function () {
                                    document.location.href = "{{ route('panselnas') }}";
                                }
                            }
                        }
                });
            },
            error : function(data){
                $('#action').removeAttr('disabled');
                err = '';
                respon = data.responseJSON;
                $.each(respon.errors, function( index, value ) {
                    err = err + "<li>" + value +"</li>";
                });
                $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                $('html, body').animate({ scrollTop: $('#alert').offset().top - 50 }, 500);
            }
        });
        return false;
    }
    $(this).addClass('was-validated');
});

function alerts(){
    $.alert({
            title: 'Error',
            content: 'Form Inputan Tidak Boleh Kosong Silahkan Pilih Minimal Satu Keputusan',
            icon: 'icon-error',
            type: 'red',
            theme: 'material',
            typeAnimated: true,
            animation: 'top',
            buttons: {
                close: function () {
                }
            }
        });
}

function confirm_form(){
    var n = $('#alasan_tolak').val();
    if(form.c_tolak0.checked != true && form.c_tolak1.checked != true ){
       alerts();
    } else {

        if(form.c_tolak1.checked != false){
            if(n == ''){
                $('#alasan_tolak').focus();
                alerts();
                return false;
            }
        }

        $.confirm({
                title: '',
                content: 'Apakah Anda yakin akan Menyimpan data ini?',
                icon: 'icon-save',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'green',
                    buttons: {
                        'confirm': {
                            text: 'Ya',
                            btnClass: 'btn-blue',
                            action: function () {
                                  $('#form').submit();
                            }
                        },
                        cancel: function () {
                            //
                        }
                    }
                });
    }
}

</script>
@endsection
