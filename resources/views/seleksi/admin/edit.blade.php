@extends('layouts.app')

@section('title', 'Data Seluruh Pelamar Jabatan')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
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
                        <a class="nav-link" href="{{ route('admin.panselnas') }}"><i class="icon icon-arrow_back"></i>Semua Pelamar Jabatan</a>
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
                <strong class="card-title">Kesimpulan Tim Panselnas</strong><br><br>
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
              {{-- <strong class="card-title">Keputusan</strong>
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
                </div> --}}

                <form class="needs-validation" id="form" method="POST" novalidate="">
                    @csrf
                    @method('PATCH')
                    {{-- <div class="form-inline">
                        @if($tmpelamar->c_tolak == 0)
                        <strong class="card-title">Set Jadwal Pengumuman</strong>
                        <div class="form-group m-0 col-md-12">
                            <label for="c_tolak" class="col-form-label s-12 col-md-2">Pengumuman</label>
                            <input type="text" name="d_pengumuman_dari" id="d_pengumuman_dari" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_pengumuman_dari, 0, -3) !!}" required>
                            <label class="col-md-1"> s.d. </label>
                            <input type="text" name="d_pengumuman_sampai" id="d_pengumuman_sampai" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{!! substr($tmpelamar->d_pengumuman_sampai, 0, -3) !!}" required>
                        </div>
                        <div class="card-body offset-md-2">
                            <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i class="icon-save mr-2"></i>Simpan Keputusan</button>
                        </div>
                        @else
                        <div class="card-body offset-md-2">
                            <button type="submit" class="btn btn-danger btn-sm" id="action" title="Simpan data"><i class="icon-save mr-2"></i>Simpan Keputusan Ditolak</button>
                        </div>
                        @endif

                        <a class="btn btn-warning btn-sm" title="Kembalikan berkas" onclick="mutasiForward()"><i class="icon-mail-forward mr-2"></i>Kembalikan Berkas Ke Pansel</a>
                    </div> --}}
                    <div class="card no-b no-r mt-3">
                            <div class="card-body">
                            <strong class="card-title">Kesimpulan Admin Panselnas</strong><br><br>
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{!! $tmpelamar->id !!}" id="id"/>
                                <div class="form-inline">
                                    <div class="form-group m-0 col-md-12">
                                        <label for="n_panselnas" class="col-form-label s-12 col-md-2">Nama Pansel</label>
                        @php $n_pegawai = (Auth::user()->pegawai ? Auth::user()->pegawai->n_pegawai : '') @endphp
                                        {{-- {{ dd($n_pegawai)}} --}}
                                        <input type="text" name="n_panselnas" id="n_panselnas" placeholder="" class="form-control r-0 light s-12 col-md-10" autocomplete="off" value="{{ $n_pegawai }}" disabled="disabled">
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
                                    <div class="form-group m-0 col-md-12" id="v_alasan_tolak2" {{ $tmpelamar->c_tolak === 1 ? '' : "style=display:none" }}>
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
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
$('#c_tolak0').click(function(){
    $('#v_alasan_tolak2').hide();
});
$('#c_tolak1').click(function(){
    $('#v_alasan_tolak2').show();
    $('#alasan_tolak').focus();
});

$('#d_pengumuman_dari').datetimepicker({
    format:'Y-m-d H:i',
    onShow:function( ct ){
    this.setOptions({
        maxDate:$('#d_pengumuman_dari').val()?$('#d_pengumuman_dari').val():false
    })},
    timepicker:true
});
$('#d_pengumuman_sampai').datetimepicker({
    format:'Y-m-d H:i',
    onShow:function( ct ){
    this.setOptions({
        minDate:$('#d_pengumuman_sampai').val()?$('#d_pengumuman_sampai').val():false
    })},
    timepicker:true
});

$('#form').on('submit', function (e) {
    if ($(this)[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
    }
    else{
        $('#alert').html('');
        $('#action').attr('disabled', true);
        $.ajax({
            url : "{!! route('admin.panselnas.update', $tmpelamar->id) !!}",
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
                                text: 'Ke Halaman Tabel Admin Pansel',
                                action: function () {
                                    document.location.href = "{!! route('admin.panselnas') !!}";
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

function mutasiForward(){
    $.confirm({
        title: '',
        content: 'Apakah Anda yakin akan mengembalikan berkas ini?',
        icon: 'icon-mail-forward',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: 'orange',
        buttons: {
            ok: {
                text: "Ya",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function(){
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url : "{!! route('admin.panselnas.updateMutasi', $tmpelamar->id) !!}",
                        type : "POST",
                        data : {'_method' : 'PATCH', '_token' : csrf_token, 'forward' : 1},
                        success : function(data) {
                            document.location.href = "{!! route('admin.panselnas') !!}";
                        },
                        error : function () {
                            console.log('Opssss...');
                            reload();
                        }
                    });
                }
            },
            cancel: function(){
                console.log('the user clicked cancel');
            }
        }
    });
}
</script>
@endsection
