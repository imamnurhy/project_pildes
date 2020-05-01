@extends('layouts.app')

@section('title', 'Edit Pelamar')

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
							@if($registrasi->foto_pl != '')
								<img class="user_avatar no-b no-p" src="{{ env('SFTP_SRC').'register/'.$registrasi->foto_pl }}" alt="User Image">
							@endif
						</div>
						<div>
							<h5>{{ $registrasi->nama_pl }}</h5>
							{{ $registrasi->nik_pl.' - '.$registrasi->kk_pl }}
						</div>
					</div>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('pelamar') }}"><i class="icon icon-arrow_back"></i>Semua Pelamar </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>

        <div class="row">
            <div class="col-md-8">
                <div class="card no-b no-r">

                     <div class="card-body">
                        <strong class="card-title light-green-text"><i class="icon-wpforms"></i> Pelamar</strong>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong class="s-12">Nama </strong>
                                <span class="s-12 float-right">{{ $registrasi->nama_pl }}</span>
                            </li>
                             <li class="list-group-item">
                                <strong class="s-12">NIk</strong>
                                <span class="s-12 float-right">{{ $registrasi->nik_pl }}</span>
                            </li>
                             <li class="list-group-item">
                                <strong class="s-12">KK</strong>
                                <span class="s-12 float-right">{{ $registrasi->kk_pl }}</span>
                            </li>
                              <li class="list-group-item">
                                <strong class="s-12">TTL</strong>
                                <span class="s-12 float-right">{{ $registrasi->t_lahir_pl.', '.Carbon\Carbon::parse($registrasi->d_lahir_pl)->format('d F Y') }}</span>
                            </li>

                             <li class="list-group-item">
                                <strong class="s-12">Jenis Kelamin</strong>
                                <span class="s-12 float-right">{{ $registrasi->jk_pl }}</span>
                            </li>

                             <li class="list-group-item">
                                <strong class="s-12">Pekerjaan</strong>
                                <span class="s-12 float-right">{{ $registrasi->pekerjaan_pl }}</span>
                            </li>

                             <li class="list-group-item">
                                <strong class="s-12">Alamat</strong>
                                <span class="s-12 float-right">{{ $registrasi->alamat_pl }}</span>
                            </li>

                            <li class="list-group-item">
                                <strong class="s-12">No Telp</strong>
                                <span class="s-12 float-right">{{ $registrasi->no_tlp_pl }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pl-0">
                <div class="card no-b no-r mb-3">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <strong> Reset Password</strong>
                            <br>
                            <li class="list-group-item text-success">
                                <form class="needs-validation" id="form1" method="POST" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="type" value="1"/>
                                    <input type="hidden" id="id" name="id" value="{{ $registrasi->id }}"/>
                                    <div class="form-row form-inline">
                                        <div class="col-md-12">
                                            <div class="form-group m-0">
                                                <label for="password" class="col-form-label s-12 col-md-3">Password</label>
                                                <input type="password" name="password" id="password" placeholder="" class="form-control r-0 light s-12 col-md-8" required/>
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="password_confirmation" class="col-form-label s-12 col-md-3">Ulangi Password</label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="" class="form-control r-0 light s-12 col-md-8" required data-match="#password"/>
                                            </div>
                                            <div class="card-body offset-md-7">
                                                <a href="#" class="btn btn-primary btn-sm" id="action1" onclick="send_data(1)"><i class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card no-b no-r" style="min-height:465px">
                    <div class="card-body">
                        <strong class="card-title orange-text"><i class="icon-attach_file"></i> Reset Pelamar</strong>
                        <table class="table ml-3">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Registrasi</th>
                                    <th>Lahan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $a = 1 @endphp
                                @foreach($pelamars as $key=>$pelamar)
                                <tr>
                                    <td>{{ $a++ }}</td>
                                   <td>{{ $pelamar->tmregistrasi->nama_pl}}</td>
                                   <td>{{ $pelamar->tmlelang->n_lelang }}</td>
                                   <td> <a class='text-danger' style="cursor: pointer;" onclick="removePelamar({{ $pelamar->id }})" title='Hapus Pelamar'><i class='icon-remove'></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">

function send_data(no){
        if ($('#form' + no)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action' + no).addClass('disabled');

            url = "{{ route('pelamar.update', ':id') }}".replace(':id', $('#id').val());
            data = new FormData($('#form' + no)[0]);
            $.ajax({
                url : url,
                type : 'POST',
                data: data,
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action' + no).removeClass('disabled');
                    $('#form' + no).trigger('reset');
                    if(data.success == 1){
                        $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    }
                },
                error : function(data){
                    $('#action' + no).removeClass('disabled');
                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function( index, value ) {
                        err = err + "<li>" + value +"</li>";
                    });

                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            });
            return false;
        }
        $('#form' + no).addClass('was-validated');
    }

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

function removePelamar(id){
        $.confirm({
            title: '',
            content: 'Apakah Anda yakin akan menghapus Lamaran ini?',
            icon: 'icon icon-question amber-text',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                ok: {
                    text: "ok!",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url : "{{ route('pelamar.destroy', ':id') }}".replace(':id', id),
                            type : "POST",
                            data : {'_method' : 'DELETE', '_token' : csrf_token},
                            success : function(data) {
                                location.reload();
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
