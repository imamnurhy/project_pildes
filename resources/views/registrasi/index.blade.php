@extends('layouts.app')

@section('title', 'Waiting list')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-fancybox.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-payment"></i> Waiting List
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">

            <div class="col-md-8">
                <div class="card no-b">
                    <div class="card-body">
                        <form id="form_filter">
                            <div class="row col-md-12">

                                <div class="col-md-2 pr-0">
                                    <div class="mt-1">
                                        <strong><i class="icon-filter"></i>FILTER</strong>
                                    </div>
                                </div>

                                <div class="col-md-4 pr-0">
                                    <div class="bg-light" width="100%">
                                        <input type="text" id="tgl_daftar_filter"
                                            class="form-control r-0 light s-12 col-md-12" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="col-md-4 pr-0">
                                    <div class="bg-light" width="100%">
                                        <select id="status_filter" placeholder="Semua"
                                            class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                            autocomplete="off">
                                            <option value="99">Status : Semua</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-1">
                                    <a class="btn btn-sm" id="btnFilter" title="Reset Filter" style="display:none"
                                        onclick="reset()">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="registrasi-table" class="table table-striped" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th>Pelanggan</th>
                                    <th>No hp</th>
                                    <th>Tgl daftar</th>
                                    <th>Tgl pemasangan</th>
                                    <th>Alamat</th>
                                    <th>Status pemasangan</th>
                                    <th width="60"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 my-1">
                <div class="card">
                    <div class="card-body">
                        <div id="alert"></div>
                        <form class="needs-validation" id="form" method="POST" novalidate>
                            @csrf
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id" />
                            <h4 id="formTitle">Edit Data</h4>
                            <hr>
                            <div class="form-row form-inline">
                                <div class="col-md-12">

                                    <div class="form-group m-0">
                                        <label for="tgl_pemasangan" class="col-form-label s-12 col-md-4">Tgl
                                            Pemasangan</label>
                                        <input type="text" name="tgl_pemasangan" id="tgl_pemasangan" autocomplete="off"
                                            class="date-time-picker form-control  s-12 col-md-6 " required />
                                    </div>

                                    <div class="form-group m-0">
                                        <label for="status" class="col-form-label s-12 col-md-4">Status</label>
                                        <select name="status" id="status"
                                            class="form-control r-0 light s-12 col-md-6 custom-select select " required>
                                            <option value="">Plih</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>

                                    </div>


                                    <div class="card-body offset-md-3">
                                        <button type="submit" class="btn btn-primary btn-sm" id="action"><i
                                                class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>

<script type="text/javascript">
    $('#tgl_pemasangan, #tgl_daftar_filter').datetimepicker({
        format: 'Y-m-d',
        timepicker: false
    });
    var table = $('#registrasi-table').dataTable({
        processing: true,
        serverSide: true,
        order: [ 1, 'asc' ],
        ajax: {
            url: "{{ route('registrasi.api') }}",
            method: 'GET',
            data: function(data){
                data.tgl_daftar_filter = $('#tgl_daftar_filter').val();
                data.status_filter = $('#status_filter').val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                align: 'center',
                className: 'text-center'
            },
            {
                data: 'n_pelanggan',
                name: 'n_pelanggan'
            },
            {
                data: 'no_hp',
                name: 'no_hp'
            },
            {
                data: 'tgl_daftar',
                name: 'tgl_daftar'
            },
            {
                data: 'tgl_pemasangan',
                name: 'tgl_pemasangan'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'status',
                name: 'status',
                render: function(data){
                    if(data == 0){
                        return 'Tidak';
                    } else {
                        return 'Ya';
                    }
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#registrasi-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function reset(){
        $('#form').trigger('reset');
        $('#formTitle').html('Edit Data');
        $('#txtAction').html('');
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);;
            $.ajax({
                url : "{{ route('registrasi.update', ':id') }}".replace(':id', $('#id').val()),
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action').removeAttr('disabled');
                    $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    table.api().ajax.reload();
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

    function edit(id) {
        $('#alert').html('');
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data <a href='#' onclick='reset()' class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ route('registrasi.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#tgl_pemasangan').val(data.tgl_pemasangan);
                $('#status').val(data.status);
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
                            url : "{{ route('registrasi.destroy', ':id') }}".replace(':id', id),
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

    $('#tgl_daftar_filter, #status_filter').on('change', function () {
        if ($(this).val() == '99') {
            $('.formFilter').removeClass('active');
            $('#btnFilter').hide();
        } else {
            $('.formFilter').addClass('active');
            $('#btnFilter').show();
        }
        table.api().draw();
    });

    function reset() {
        $('#form_filter').trigger('reset');
        table.api().draw();
    }
</script>
@endsection
