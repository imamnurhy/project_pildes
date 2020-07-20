@extends('layouts.app')

@section('title', 'Master Asset Keluar')

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
                        <i class="icon icon-clipboard-list"></i> Data Aset Keluar
                    </h3>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.keluar.create')}}"><i class="icon icon-plus"></i>Tambah
                            Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="aset-keluar-table" class="table table-striped no-b" style="width:100%">
                        <thead>
                            <th width="30">No</th>
                            <th>OPD</th>
                            <th>Kategori</th>
                            <th width="450">Alamat</th>
                            <th width=130px>foto</th>
                            <th>Detail</th>
                            <th width="40"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="formUpload" style="display:none">
    <div id="alert2"></div>
    <form class="needs-validation" id="form2" method="POST" enctype="multipart/form-data" novalidate>
        <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg
                xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
        @csrf
        @method('PATCH')
        <input type="hidden" id="id_foto" name="id_foto" />
        <h4>Unggah Foto</h4>
        <hr>
        <div class="form-row form-inline" style="align-items: baseline">
            <div class="col-md-12">
                <div class="form-group m-0">
                    <label for="foto" class="col-form-label s-12 col-md-4">Foto</label>
                    <input type="file" name="foto" id="foto" placeholder="" class="form-control r-0 light s-12 col-md-8"
                        autocomplete="off" value="Pemerintah Kota Tangerang Selatan" required />
                </div>
                <div class="card-body offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm" id="action2" title="Simpan data"><i
                            class="icon-save mr-2"></i>Unggah<span id="txtAction"></span></button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>

<script type="text/javascript">
    var table = $('#aset-keluar-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('aset.keluar.api')}}",
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'n_lokasi',
                name: 'n_lokasi'
            },
            {
                data: 'n_kategori',
                name: 'n_kategori'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data:'foto',
                name:'foto',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'detail',
                name: 'detail'
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
        var PageInfo = $('#aset-keluar-table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function remove(id) {
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
                    action: function () {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: "{{ route('aset.keluar.destroy', ':id') }}".replace(':id', id),
                            type: "POST",
                            data: {
                                '_method': 'DELETE',
                                '_token': csrf_token
                            },
                            success: function (data) {
                            table.api().ajax.reload();
                            $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success! </strong>" + data.message + "</div>");
                            },
                            error: function () {
                                console.log('Opssss...');
                                reload();
                            }
                        });
                    }
                },
                cancel: function () {
                    console.log('the user clicked cancel');
                }
            }
        });
    }

    //--- Edit Foto
    $('#form2').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert2').html('');
            $('#action2').attr('disabled', true);
            url = "{{ route('aset.keluar.updateFoto', ':id') }}".replace(':id', $('#id_foto').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                dataType:'JSON',
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action2').removeAttr('disabled');
                    if(data.success == 1){
                        $('#alert2').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
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

                    $('#alert2').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            });
            return false;
        }
        $(this).addClass('was-validated');
    });

    function editFoto(id) {
        $('#id_foto').val(id);
    }

</script>
@endsection
