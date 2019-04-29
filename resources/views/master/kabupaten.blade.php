@extends('layouts.app')

@section('title', 'Data Kabupaten')

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
                        <i class="icon icon-account_balance"></i> Data Kabupaten <strong>'Provinsi {{ $provinsi->n_provinsi.' '.$provinsi->kode }}'</strong>
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab">
                    <li>
                        <a class="nav-link" href="{{ route('provinsi.index') }}"><i class="icon icon-arrow_back"></i>Kembali Ke Provinsi</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card no-b">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="kabupaten-table" class="table table-striped" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th width="80">Kode</th>
                                    <th>Nama Kabupaten</th>
                                    <th width="120">Kecamatan</th>
                                    <th width="40"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-1">
                <div id="alert"></div>
                <form class="needs-validation" id="form" method="POST" novalidate>
                    @csrf
                    {{ method_field('POST') }}
                    <input type="hidden" id="id" name="id"/>
                    <input type="hidden" name="provinsi_id" value="{{ $provinsi_id }}"/>
                    <h4 id="formTitle">Tambah Data</h4><hr>
                    <div class="form-row form-inline">
                        <div class="col-md-12">
                            <div class="form-group m-0">
                                <label for="kode" class="col-form-label s-12 col-md-4">Kode</label>
                                <input type="text" name="kode" id="kode" placeholder="" class="form-control r-0 light s-12 col-md-8" autocomplete="off" required/>
                            </div>
                            <div class="form-group m-0">
                                <label for="n_kabupaten" class="col-form-label s-12 col-md-4">Nama</label>
                                <input type="text" name="n_kabupaten" id="n_kabupaten" placeholder="" class="form-control r-0 light s-12 col-md-8" autocomplete="off" required/>
                            </div>
                            <div class="card-body offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="action"><i class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                <a class="btn btn-sm" onclick="add()" id="reset">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    var table = $('#kabupaten-table').dataTable({
        processing: true,
        serverSide: true,
        order: [ 1, 'asc' ],
        ajax: "{{ route('api.kabupaten', $provinsi_id) }}",
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'kode', name: 'kode'},
            {data: 'n_kabupaten', name: 'n_kabupaten'},
            {data: 'kecamatan', name: 'kecamatan', className: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#kabupaten-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function add(){
        save_method = "add";
        $('#form').trigger('reset');
        $('#kode').val('{{ $provinsi->kode }}.');
        $('#formTitle').html('Tambah Data');
        $('input[name=_method]').val('POST');
        $('#txtAction').html('');
        $('#reset').show();
        $('#kode').focus();
    }

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data <a href='#' onclick='add()' class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ route('kabupaten.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#n_kabupaten').val(data.n_kabupaten).focus();
                $('#kode').val(data.kode);
            },
            error : function() {
                console.log("Nothing Data");
                reload();
            }
        });
    }

    function remove(id){
        $.confirm({
            title: '',
            content: 'Apakah Anda yakin akan menghapus data ini?',
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
                            url : "{{ route('kabupaten.destroy', ':id') }}".replace(':id', id),
                            type : "POST",
                            data : {'_method' : 'DELETE', '_token' : csrf_token},
                            success : function(data) {
                                table.api().ajax.reload();
                                if(id == $('#id').val()){
                                    add();
                                }
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

    add();
    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);;
            if (save_method == 'add'){
                url = "{{ route('kabupaten.store') }}";
            }else{
                url = "{{ route('kabupaten.update', ':id') }}".replace(':id', $('#id').val());
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
                        table.api().ajax.reload();
                        if(save_method == 'add'){
                            add();
                        }
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