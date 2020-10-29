@extends('layouts.app')

@section('title', 'Master Pemilih')

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
                    <h4>
                        <i class="icon icon-users"></i> Data Pemilih
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="tab-content my-3">
            <div class="row">

                <!-- Tabel -->
                <div class="col-md-8">
                    <div class="card no-b">
                        <div class="card-body">
                            <a href="{{ route('pemilih.cetakUndangan')}}" target="_blank"
                                class="button btn btn-primary btn-xs">
                                <i class="icon-file-pdf/"></i>
                                Cetak undangan
                            </a>
                        </div>
                    </div>
                    <div class="card no-b">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pemilih-table" class="table table-striped" style="width:100%">
                                    <thead>
                                        <th width="30">No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Np Telp</th>
                                        <th>RT/RW</th>
                                        <th width="40"></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="col-md-4">
                    <div class="card no-b">
                        <div class="card-body">
                            <div id="alert"></div>
                            <form class="needs-validation" id="form" method="POST" novalidate>
                                @csrf
                                {{ method_field('POST') }}
                                <input type="hidden" id="id" name="id" />
                                <h4 id="formTitle">Tambah Data</h4>
                                <hr>
                                <div class="form-row form-inline">
                                    <div class="col-md-12">

                                        <div class="form-group m-0">
                                            <label for="nik" class="col-form-label s-12 col-md-4">NIK</label>
                                            <input type="text" name="nik" id="nik" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="n_pemilih" class="col-form-label s-12 col-md-4">Nama</label>
                                            <input type="text" name="n_pemilih" id="n_pemilih" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="t_lahir" class="col-form-label s-12 col-md-4">Tempat L</label>
                                            <input type="text" name="t_lahir" id="t_lahir" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="d_lahir" class="col-form-label s-12 col-md-4">Tanggal L</label>
                                            <input type="text" name="d_lahir" id="d_lahir" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="jk" class="col-form-label s-12 col-md-4">Gender</label>
                                            <select name="jk" id="jk" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off"
                                                required>
                                                <option value="">Pilih</option>
                                                <option value="Laki-Laki">Laki-Laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="telp" class="col-form-label s-12 col-md-4">Telp</label>
                                            <input type="text" name="telp" id="telp" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="alamat" class="col-form-label s-12 col-md-4">Alamat</label>
                                            <textarea name="alamat" id="alamat" placeholder=""
                                                class="form-control r-0 light s-12 col-md-8" required></textarea>
                                        </div>

                                        <div class="card-body offset-md-3">
                                            <button type="submit" class="btn btn-primary btn-sm" id="action"
                                                title="Simpan data">
                                                <i class="icon-save mr-2"></i>
                                                Simpan
                                                <span id="txtAction"></span>
                                            </button>
                                            <a class="btn btn-sm" onclick="add()" id="reset" title="Reset inputan">
                                                Reset
                                            </a>
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
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    $('#d_lahir').datetimepicker({
        format: 'Y-m-d',
        timepicker: false
    });

    var table = $('#pemilih-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pemilih.api') }}",
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'nik',
                mame: 'nik'
            },
            {
                data: 'n_pemilih',
                name: 'n_pemilih'
            },
            {
                data: 'telp',
                name: 'telp'
            },
            {
                data: 'rt_rw',
                name: 'rt_rw'
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
        var PageInfo = $('#pemilih-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function add(){
        save_method = "add";
        $('#form').trigger('reset');
        $('#formTitle').html("Tambah Data");
        $('#form input[name=_method]').val('POST');
        $('#txtAction').html('');
        $('#reset').show();
        $('#nik').focus();
    }

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data <a href='#' onclick='add()'class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#getNik').hide();
        $('#form input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ route('pemilih.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#nik').val(data.nik);
                $('#n_pemilih').val(data.n_pemilih);
                $('#t_lahir').val(data.t_lahir);
                $('#d_lahir').val(data.d_lahir);
                $('#jk').val(data.jk);
                $('#telp').val(data.telp);
                $('#alamat').val(data.alamat);
            },
            error : function() {
                reload();
            }
        })
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
                                url : "{{ route('pemilih.destroy', ':id') }}".replace(':id', id),
                                type : "POST",
                                data : {'_method' : 'DELETE', '_token' : csrf_token},
                                success : function(data) {
                                    table.api().ajax.reload();
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
            $('#action').attr('disabled', true);
            if (save_method == 'add'){
                url = "{{ route('pemilih.store') }}";
            }else{
                url = "{{ route('pemilih.update', ':id') }}".replace(':id', $('#id').val());
            }
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action').removeAttr('disabled');
                    table.api().ajax.reload();
                    if(save_method == 'add'){
                        add();
                    }
                     $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
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
