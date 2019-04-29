@extends('layouts.app')

@section('title', 'Tambah Pengumuman')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4>
                        <i class="icon icon-bullhorn"></i> Tambah Data Pengumuman
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('pengumuman.index') }}"><i class="icon icon-arrow_back"></i>Semua Pengumuman</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
            <form class="needs-validation" id="form" method="POST" novalidate>
                @csrf
                @method('POST')
                <input type="hidden" id="id" name="id"/>

                <div class="card no-b  no-r">
                    <div class="card-body">
                        <h5 class="card-title" id="formTitle">Tambah Data</h5>
                        <div class="form-row form-inline" style="align-items: baseline">
                            <div class="col-md-12">
                                <div class="form-group m-0">
                                    <label for="n_pengumuman" class="col-form-label s-12 col-md-2">Judul</label>
                                    <input type="text" name="n_pengumuman" id="n_pengumuman" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0">
                                    <label for="tgl" class="col-form-label s-12 col-md-2">Tanggal</label>
                                    <input type="text" name="tgl" id="tgl" placeholder="" class="form-control r-0 light s-12 col-md-2 date-time-picker" data-options='{"format":"Y-m-d", "timepicker":false}' autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="ket" class="col-form-label s-12 col-md-2">Keterangan</label>
                                </div>
                                <div class="form-group m-2" style="align-items:flex-start">
                                    <div class="col-md-12 card-body border no-p">
                                        <textarea name="ket" id="ket" placeholder="" class="form-control r-0 s-12 editor" style="width:100%"" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group m-0">
                                    <label for="c_status" class="col-form-label s-12 col-md-2">Status</label>
                                    <select name="c_status" id="c_status" placeholder="" class="form-control r-0 light s-12 col-md-2" required>
                                        <option value="">Pilih</option>
                                        <option value="1">Tampil</option>
                                        <option value="0">Tidak Tampil</option>
                                    </select>
                                </div>
                                <div class="card-body offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                    <a class="btn btn-sm" onclick="add()" id="reset" title="Reset inputan">Reset</a>
                                </div>
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
    $('#menuPengumuman').addClass('active');
    $('.select2').addClass('light');
    $('#d_dari').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
            maxDate:$('#d_sampai').val()?$('#d_sampai').val():false
        })
        },
        timepicker:false
    });
    
    $('#d_sampai').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
            minDate:$('#d_dari').val()?$('#d_dari').val():false
        })
        },
        timepicker:false
    });

    {{ $id == 0 ? 'add()' : 'edit('.$id.')' }}
    function add(){
        save_method = 'add';
        $('#form').trigger('reset');
        $('#n_pengumuman').focus();
    }

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ route('pengumuman.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#formTitle').html("Edit Data");
                $('#form').show();
                $('#id').val(data.id);
                $('#n_pengumuman').val(data.n_pengumuman).focus();
                $('#tgl').val(data.tgl);
                $('#c_status').val(data.c_status);
                $('#ket').trumbowyg('html', data.ket);
            },
            error : function() {
                console.log("Nothing Data");
                $.confirm({
                    title: '',
                    content: 'Terdapat kesalahan saat mengirim data.',
                    icon: 'icon icon-all_inclusive',
                    theme: 'supervan',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'orange',
                    autoClose: 'ok|10000',
                    escapeKey: 'cancelAction',
                    buttons: {   
                        ok: {
                            text: "ok!",
                            btnClass: 'btn-primary',
                            keys: ['enter'],
                            action: function(){
                                document.location.href = "{{ route('pengumuman.index') }}";
                            }
                        }
                    }
                });
            }
        })
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);;
            if (save_method == 'add'){
                url = "{{ route('pengumuman.store') }}";
            }else{
                url = "{{ route('pengumuman.update', ':id') }}".replace(':id', $('#id').val());
            }
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action').removeAttr('disabled');
                    if(data.success == 1){
                        $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                        document.location.href = "{{ route('pengumuman.index') }}"
                    }
                },
                error : function(data){
                    $('#action').removeAttr('disabled');
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
        $(this).addClass('was-validated');
    });
</script>
@endsection