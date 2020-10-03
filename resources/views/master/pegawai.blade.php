@extends('layouts.app')

@section('title', 'Master Pegawai')

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
                        <i class="icon icon-users"></i> Data Pegawai
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link active" id="v-pegawai-all-tab" data-toggle="pill" href="#v-pegawai-all"
                            role="tab" aria-controls="v-pegawai-all"><i class="icon icon-home2"></i>Semua Pegawai</a>
                    </li>
                    <li>
                        <a class="nav-link" onclick="add()" data-fancybox data-src="#formAdd" data-modal="true"
                            href="javascript:;"><i class="icon icon-plus"></i>Tambah Pegawai</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="tab-content my-3" id="v-pegawai-tabContent">
            <div class="tab-pane show active go" id="v-pegawai-all" role="tabpanel" aria-labelledby="v-pegawai-all-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card no-b">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="pegawai-table" class="table table-striped" style="width:100%">
                                        <thead>
                                            <th width="30">No</th>
                                            <th>Nama</th>
                                            <th width="130px">Foto</th>
                                            <th width="120">Pengguna APP</th>
                                            <th width="40"></th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="formAdd" style="width:690px;display:none">
    <div id="alert"></div>
    <form class="needs-validation" id="form" method="POST" novalidate>
        <button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg
                xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
        @csrf
        {{ method_field('POST') }}
        <input type="hidden" id="id" name="id" />
        <h4 id="formTitle">Tambah Data</h4>
        <hr>
        <div class="form-row form-inline" style="align-items: baseline">
            <div class="col-md-6">
                <div class="form-group m-0">
                    <label for="n_pegawai" class="col-form-label s-12 col-md-4">Nama</label>
                    <input type="text" name="n_pegawai" id="n_pegawai" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                </div>
                <div class="form-group m-0">
                    <label for="t_lahir" class="col-form-label s-12 col-md-4">Tempat L</label>
                    <input type="text" name="t_lahir" id="t_lahir" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                </div>
                <div class="form-group m-0">
                    <label for="d_lahir" class="col-form-label s-12 col-md-4">Tanggal L</label>
                    <input type="text" name="d_lahir" id="d_lahir" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                </div>
                <div class="form-group m-0">
                    <label for="jk" class="col-form-label s-12 col-md-4">Gender</label>
                    <select name="jk" id="jk" placeholder="" class="form-control r-0 light s-12 col-md-8"
                        autocomplete="off" required>
                        <option value="">Pilih</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group m-0">
                    <label for="pekerjaan" class="col-form-label s-12 col-md-4">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                </div>
                <div class="form-group m-0">
                    <label for="telp" class="col-form-label s-12 col-md-4">Telp</label>
                    <input type="text" name="telp" id="telp" placeholder="" class="form-control r-0 light s-12 col-md-8"
                        autocomplete="off" required />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group m-0">
                    <label for="provinsi_id" class="col-form-label s-12 col-md-4">Provinsi</label>
                    <select name="provinsi_id" id="provinsi_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" onchange="getKabupaten()" required>
                        <option value="">Pilih</option>
                        @foreach($provinsis as $key=>$provinsi)
                        <option value="{{ $provinsi->id }}">{{ $provinsi->n_provinsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group m-0">
                    <label for="kelurahan_id" class="col-form-label s-12 col-md-4">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" required>
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="form-group m-0">
                    <label for="kabupaten_id" class="col-form-label s-12 col-md-4">Kabupaten</label>
                    <select name="kabupaten_id" id="kabupaten_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" onchange="getKecamatan()" required>
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="form-group m-0">
                    <label for="kecamatan_id" class="col-form-label s-12 col-md-4">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-8" onchange="getKelurahan()" required>
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="form-group m-0">
                    <label for="alamat" class="col-form-label s-12 col-md-4">Alamat</label>
                    <textarea name="alamat" id="alamat" placeholder="" class="form-control r-0 light s-12 col-md-8"
                        required></textarea>
                </div>
                <div class="card-body offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i
                            class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                    <a class="btn btn-sm" onclick="add()" id="reset" title="Reset inputan">Reset</a>
                </div>
            </div>
        </div>
    </form>
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
<script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    var table = $('#pegawai-table').dataTable({
        processing: true,
        serverSide: true,
        order: [ 2, 'asc' ],
        ajax: "{{ route('api.pegawai') }}",
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, className: 'text-center'},
            {data: 'n_pegawai', name: 'n_pegawai'},
            {data: 'foto', name: 'foto', orderable: false, searchable: false, className: 'text-center'},
            {data: 'user_id', name: 'user_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#pegawai-table').DataTable().page.info();
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
        $('#getNik').show();
        $('#nik').focus();
    }

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#getNik').hide();
        $('#form input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ route('pegawai.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                getWilayah(data);
                data = data.pegawai;
                $('#id').val(data.id);

                $('#n_pegawai').val(data.n_pegawai);
                $('#telp').val(data.telp);
                $('#alamat').val(data.alamat);
                $('#nik').val(data.nik);
                $('#t_lahir').val(data.t_lahir);
                $('#d_lahir').val(data.d_lahir);
                $('#jk').val(data.jk);
                $('#pekerjaan').val(data.pekerjaan);
                $('#tmopd_id').val(data.tmopd_id);
            },
            error : function() {
                console.log("Nothing Data");
                reload();
            }
        })
    }

    function remove(id){
        if(id != {{ $auth_pegawai_id }}){
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
                                url : "{{ route('pegawai.destroy', ':id') }}".replace(':id', id),
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
        }else{
            $.alert({
                title: '',
                content: 'Anda tidak diperkenankan menghapus data Anda sendiri.',
                icon: 'icon icon-remove text-danger',
                theme: 'modern',
                animation: 'scale',
                closeAnimation: 'scale',
                buttons: {
                    okay: {
                        text: 'Okay',
                        btnClass: 'btn-blue'
                    }
                }
            });
        }
    }

    $("input#nik, input#nip").on({
        keydown: function(e) {
            if (e.which === 32)
            return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });

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
                url = "{{ route('pegawai.store') }}";
            }else{
                url = "{{ route('pegawai.update', ':id') }}".replace(':id', $('#id').val());
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

    $('#v-pegawai-add-tab').click(function(){
        $.confrim({
            title: 'Asynchronous content',
            content: $('#addForm'),
            animation: 'scale',
            columnClass: 'medium',
            closeAnimation: 'scale',
            backgroundDismiss: true,
        });
    });

    function getKabupaten(id){
        val = $('#provinsi_id').val();
        option = "<option value=''>Pilih</option>";
        if(val == ""){
            $('#kabupaten_id').html(option);
        }else{
            $('#kabupaten_id').html("<option value=''>Loading...</option>");
            url = "{{ route('pegawai.getKabupaten', ':id') }}".replace(':id', val);
            $.get(url, function(data){
                $.each(data, function( index, value ) {
                    option += "<option value='" + value.id + "'>" + value.n_kabupaten +"</li>";
                });
                $('#kabupaten_id').html(option);
            }, 'JSON');
        }
    }

    function getKecamatan(id){
        val = $('#kabupaten_id').val();
        option = "<option value=''>Pilih</option>";
        if(val == ""){
            $('#kecamatan_id').html(option);
        }else{
            $('#kecamatan_id').html("<option value=''>Loading...</option>");
            url = "{{ route('pegawai.getKecamatan', ':id') }}".replace(':id', val);
            $.get(url, function(data){
                $.each(data, function( index, value ) {
                    option += "<option value='" + value.id + "'>" + value.n_kecamatan +"</li>";
                });
                $('#kecamatan_id').html(option);
            }, 'JSON');
        }
    }

    function getKelurahan(){
        val = $('#kecamatan_id').val();
        option = "<option value=''>Pilih</option>";
        if(val == ""){
            $('#kelurahan_id').html(option);
        }else{
            $('#kelurahan_id').html("<option value=''>Loading...</option>");
            url = "{{ route('pegawai.getKelurahan', ':id') }}".replace(':id', val);
            $.get(url, function(data){
                $.each(data, function( index, value ) {
                    option += "<option value='" + value.id + "'>" + value.n_kelurahan +"</li>";
                });
                $('#kelurahan_id').html(option);
            }, 'JSON');
        }
    }

    function getWilayah(data){
        $('#provinsi_id').val(data.provinsi_id);

        option = "<option value=''>Pilih</option>";
        $.each(data.kabupatens, function( index, value ) {
            option += "<option value='" + value.id + "'>" + value.n_kabupaten +"</li>";
        });
        $('#kabupaten_id').html(option);
        $('#kabupaten_id').val(data.kabupaten_id);

        option = "<option value=''>Pilih</option>";
        $.each(data.kecamatans, function( index, value ) {
            option += "<option value='" + value.id + "'>" + value.n_kecamatan +"</li>";
        });
        $('#kecamatan_id').html(option);
        $('#kecamatan_id').val(data.kecamatan_id);

        option = "<option value=''>Pilih</option>";
        $.each(data.kelurahans, function( index, value ) {
            option += "<option value='" + value.id + "'>" + value.n_kelurahan +"</li>";
        });
        $('#kelurahan_id').html(option);
        $('#kelurahan_id').val(data.kelurahan_id);
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
            url = "{{ route('pegawai.updateFoto', ':id') }}".replace(':id', $('#id_foto').val());
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
