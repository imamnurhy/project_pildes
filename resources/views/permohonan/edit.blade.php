@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        Permohonan
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('permohonan.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="column container-fluid my-3 m-0">
        <div id="alert"></div>
        <div class="col-md-12 mb-1">
            <div class="card">
                <div class="card-body no-b">
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong class="s-12">OPD</strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->tmopd->n_lokasi }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Kepala Dinas</strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->n_kadis }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">No Hp </strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->no_hp_kadis }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jenis Permohonan</strong>
                                <span class="s-12 float-right">
                                    @if ($tmpermohonan->jenis_permohonan == 1)
                                    Pengajuan pemasangan internet
                                    @else
                                    Penambahan pemasangan internet
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Kebutuhan Bandwith</strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->bandwith }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jumlah Perangkat</strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->jumlah_perangkat }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jaringan Listrik</strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->ketersediaan_listrik }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Ketersediaan Internt</strong>
                                <span class="s-12 float-right">{{ $tmpermohonan->ketersediaan_internet }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body no-b">
                    <form class="needs-validation" id="form" method="POST">
                        <div class="card-body">
                            <strong class="card-title">Kesimpulan</strong>
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{!! $tmpermohonan->id !!}" id="id" />
                            <div class="form-inline">
                                <div class="form-group m-0 col-md-12">
                                    <label for="n_pegawai" class="col-form-label s-12 col-md-2">Nama Pegawai</label>
                                    <span class="s-12 float-right">{{ Auth::user()->pegawai->n_pegawai }}</span>
                                    <input type="hidden" name="n_pegawai"
                                        value="{{ Auth::user()->pegawai->n_pegawai }}">
                                </div>

                                <div class="form-group m-0 col-md-12">
                                    <label class="col-form-label s-12 col-md-2">Keputusan</label>
                                    <br>
                                    <select name="status" id="c_status" class="form-control r-0 light s-12 col-md-4"
                                        required>
                                        <option>Pilih</option>
                                        <option value="1" {{ $tmpermohonan->status == 1 ? 'selected="selected"' : ''}}>
                                            DI setujui</option>
                                        <option value="2" {{ $tmpermohonan->status == 2 ? 'selected="selected"' : ''}}>
                                            DI tolak</option>
                                    </select>
                                </div>

                                <div class="form-group m-0 col-md-12" id="v_alasan_tolak"
                                    {{ $tmpermohonan->status == 2 ? '' : "style=display:none" }}>
                                    <label for=" alasan_tolak" class="col-form-label s-12 col-md-2">Alasan
                                        Tolak</label>
                                    <textarea type="text" name="alasan_tolak" id="alasan_tolak" placeholder=""
                                        class="form-control r-0 light s-12 col-md-4"
                                        autocomplete="off">{{ $tmpermohonan->alasan_tolak }}</textarea>
                                </div>

                                <div class="card-body offset-md-2">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action"
                                        title="Simpan data"><i class="icon-save mr-2"></i>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    $('#c_status').click(function(){
        console.log($(this).val())
        if($(this).val() == 2){
            $('#v_alasan_tolak').show();
        } else {
            $('#v_alasan_tolak').hide();
        }
    });

    $('#form').on('submit', function (e) {

        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);
            url = "{{ route('permohonan.update', ':id') }}".replace(':id', $('#id').val());
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
                                    text: 'Ke Halaman Permohoanan',
                                    action: function () {
                                        document.location.href = "{{ route('permohonan.index') }}";
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


</script>
@endsection
