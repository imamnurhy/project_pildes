@extends('layouts.app')

@section('title', 'Pendapatan')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-notebook-list"></i> Pendapatan Aset
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="column">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped no-b" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th>jenis Aset</th>
                                    <th>Aset</th>
                                    <th>Pendapatan</th>
                                    <th>Tahun</th>
                                    <th>Nilai</th>
                                    <th width="40"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div id="alert"></div>
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" id="form" method="POST" novalidate>
                            @csrf
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id" />
                            <input type="hidden" name="form_type" id="form_type" value="1">
                            <h4 id="formTitle">Tambah Data</h4>
                            <hr>

                            <div class="form-row form-inline">
                                <div class="col-md-6">

                                    <div class="form-group mb-1">
                                        <label for="tmjenis_aset_id" class="col-form-label s-12 col-md-4">Jenis
                                            Aset</label>
                                        <select name="tmjenis_aset_id" id="tmjenis_aset_id" placeholder=""
                                            class="form-control  r-0 s-12 col-md-6" autocomplete="off" required
                                            onchange="getRincianAset()">
                                            <option value="">Pilih</option>
                                            @foreach ($tmJenisAsets as $item)
                                            <option value="{{ $item->id }}">{{ $item->n_jenis_aset }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label for="tmjenis_aset_rincian_id" class="col-form-label s-12 col-md-4">
                                            Rincian Asset</label>
                                        <select name="tmjenis_aset_rincian_id" id="tmjenis_aset_rincian_id"
                                            placeholder="" class="form-control  r-0 s-12 col-md-6" autocomplete="off"
                                            required>
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>

                                    <div id="input_form" style="display: block">
                                        <div class="form-group mb-1">
                                            <label for="tahun" class="col-form-label s-12 col-md-4">Tahun</label>
                                            <input type="text" name="tahun[]" id="tahun" placeholder=""
                                                class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="tgl_pendapatan" class="col-form-label s-12 col-md-4">
                                                Tgl Pendapatan
                                            </label>
                                            <input type="date" name="tgl_pendapatan[]" id="tgl_pendapatan"
                                                placeholder="" class="form-control  r-0 s-12 col-md-6"
                                                autocomplete="off" />
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="nilai" class="col-form-label s-12 col-md-4"> Nilai </label>
                                            <input type="text" name="nilai[]" id="nilai" placeholder=""
                                                class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for=""></label>
                                            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrm" id="addBtn1"
                                                onclick="addForm();">
                                                <i class="icon-plus"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div id="input_form_edit" style="display: none">
                                        <div class="form-group mb-1">
                                            <label for="tahun_e" class="col-form-label s-12 col-md-4">Tahun</label>
                                            <input type="text" name="tahun_e" id="tahun_e" placeholder=""
                                                class="form-control  r-0 s-12 col-md-8" autocomplete="off" />
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="tgl_pendapatan_e" class="col-form-label s-12 col-md-4">
                                                Tgl Pendapatan
                                            </label>
                                            <input type="date" name="tgl_pendapatan_e" id="tgl_pendapatan_e"
                                                placeholder="" class="form-control  r-0 s-12 col-md-8"
                                                autocomplete="off" />
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="nilai_e" class="col-form-label s-12 col-md-4"> Nilai </label>
                                            <input type="text" name="nilai_e" id="nilai_e" placeholder=""
                                                class="form-control  r-0 s-12 col-md-8" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div id="input_form_pt" style="display: none">
                                        @include('income.aset._form_pt')
                                    </div>
                                </div>


                                <div class="card-body offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action"><i
                                            class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                    <a class="btn btn-sm" onclick="add()" id="reset">Reset</a>
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

<script type="text/javascript">
    {{ isset($id) ? 'add()' : 'edit('.$id.')'}}

    var table = $('#table').dataTable({
        processing: true,
        serverSide: true,
        order: [1, 'desc'],
        ajax: "{{ route('pendapatan.aset.api')}}",
        columns: [{
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'tm_jenis_aset.n_jenis_aset',
                name: 'tm_jenis_aset.n_jenis_aset'
            },
            {
                data: 'tm_jenis_aset_rincian.n_rincian',
                name: 'tm_jenis_aset_rincian.n_rincian'
            },
            {
                data: 'tgl_pendapatan',
                name: 'tgl_pendapatan'
            },
            {
                data: 'tahun',
                name: 'tahun'
            },
            {
                data: 'nilai',
                name: 'nilai'
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
        var PageInfo = $('#table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function add() {
        $('#form').trigger('reset');
        save_method = 'add';
        $('#input_form').show();
        $('#input_form_edit').hide();
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            if (save_method == 'add'){
                url = "{{ route('pendapatan.aset.store') }}";
            }else{
                url = "{{ route('pendapatan.aset.update', ':id') }}".replace(':id', $('#id').val());
            }
            $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#action').removeAttr('disabled');
                        if (data.success == 1) {
                            $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label = 'Close' > <span aria-hidden='true'>×</span></button> <strong> Success! </strong> " + data.message + "</div>");
                            $('#form').trigger('reset');
                            location.reload();
                        }
                    },
                    error: function (data) {
                        $('#action').removeAttr('disabled');
                        err = '';
                        respon = data.responseJSON;
                        $.each(respon.errors, function (index, value) {
                            err = err + "<li>" + value + "</li>";
                        });

                        $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                        }
                    });
                return false;
            }
            $(this).addClass('was-validated');
    });

    function edit(id) {
        save_method = 'edit';
        $('#alert').html('');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form input[name=_method]').val('PATCH');
        $('#span').removeAttr('hidden');
        $('#input_form').hide();
        $('#input_form_edit').show();
        $.ajax({
            url: "{{ route('pendapatan.aset.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data.n_aset);
                $('#formTitle').html("Edit Data  <a href='#' onclick='add()' class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
                $('#form').show();
                $('#id').val(data.id);
                $('#tmmaster_aset_id').val(data.tmmaster_aset_id).trigger('change');
                getJenisAset(data.n_aset);
                $('#tahun_e').val(data.tahun);
                $('#tgl_pendapatan_e').val(data.tgl_pendapatan);
                $('#nilai_e').val(data.nilai);
            },
            error: function () {
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
                            action: function () {
                                document.location.href = "{{ route('pendapatan.aset.index') }}";
                            }
                        }
                    }
                });
            }
        })
    }

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
                            url: "{{ route('pendapatan.aset.destroy', ':id') }}".replace(':id', id),
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

    var input_form = 1;
    function addForm(){
        $('.addBtnFrm').hide();
        input_form++;

        htmlAdd = `
        <div id="input_form`+input_form+`">
        <hr>
        <div class="form-group mb-1">
            <label for="tahun" class="col-form-label s-12 col-md-4">Tahun</label>
            <input type="text" name="tahun[]" id="tahun" placeholder="" class="form-control  r-0 s-12 col-md-6"
                autocomplete="off" />
        </div>

        <div class="form-group mb-1">
            <label for="tgl_pendapatan" class="col-form-label s-12 col-md-4">
                Tgl Pendapatan
            </label>
            <input type="date" name="tgl_pendapatan[]" id="tgl_pendapatan" placeholder=""
                class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
        </div>

        <div class="form-group mb-1">
            <label for="nilai" class="col-form-label s-12 col-md-4"> Nilai </label>
            <input type="text" name="nilai[]" id="nilai" placeholder="" class="form-control  r-0 s-12 col-md-6"
                autocomplete="off" />
        </div>
        <div class="form-group">
            <label for=""></label>
            <a class="btn-fab btn-fab-sm shadow btn-danger" style="" onclick="deleteForm(`+input_form+`);">
            <i class="icon-minus"></i>
            </a>
            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrm" id="addBtn`+input_form+`" onclick="addForm();">
            <i class="icon-plus"></i>
            </a>
        </div>
        </div>
        `;
        $('#input_form').append(htmlAdd);

        $('.addBtnFrm').last().show();
    }

    function deleteForm(id){
        $('.addBtnFrm').hide();
        $('#input_form'+id).remove();
        $('.addBtnFrm').last().show();
    }

    function getRincianAset(id) {
        option = " <option value=''> Pilih </option>";
        $('#tmjenis_aset_rincian_id').html("<option value=''>Loading...</option>");
        url = "{{ route('pendapatan.aset.getRincianAset', ':id') }}".replace(':id', $('#tmjenis_aset_id').val());
        $.get(url, function (data) {
            console.log(data);
            $.each(data, function (index, value) {
                option += "<option value='" + value.id + "'>" + value.n_rincian + "</li>";
            });
            $('#tmjenis_aset_rincian_id').html(option);
        }, 'JSON').done(function (){
            $('#tmjenis_aset_rincian_id').val(id);
        });

        if($('#tmjenis_aset_id').val() ==  29){
            $('#input_form').hide();
            $('#input_form_pt').show();
            $('#form_type').val(2);
        } else {
            $('#input_form').show();
            $('#input_form_pt').hide();
            $('#form_type').val(1);
        }
    }

    function getJenisAset(n_aset) {
        option = " <option value=''> Pilih </option>";
        $('#n_aset').html("<option value=''>Loading...</option>");
        url = "{{ route('pendapatan.aset.getJenisAset', ':id') }}".replace(':id', $('#tmmaster_aset_id').val());
        $.get(url, function (data) {
            console.log(data);
            $.each(data, function (index, value) {
                option += "<option value='" + value.n_aset + "'>" + value.n_aset + "</li>";
            });
            $('#n_aset').html(option);
        }, 'JSON').done(function (){
            $('#n_aset').val(n_aset);
        });
    }

     var input_form_pt = 1;
    function addFormPt(){
        $('.addBtnFrmPt').hide();
        input_form_pt++;

        htmlAddPt = `
        <div id="input_form_pt`+input_form_pt+`">
        <hr>
        <div class="form-row form-inline">
            <div class="col-md-6">
                <div class="form-group mb-1">
                    <label for="no_index" class="col-form-label s-12 col-md-4">No Index</label>
                    <input type="text" name="no_index[]" id="no_index" placeholder="" class="form-control  r-0 s-12 col-md-6"
                        autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="jenis_doc" class="col-form-label s-12 col-md-4">
                        Rincian Asset</label>
                    <select name="jenis_doc[]" id="jenis_doc" placeholder="" class="form-control  r-0 s-12 col-md-6"
                        autocomplete="off" required>
                        <option value="">Pilih</option>
                        <option value="Copy kontrak">Copy kontrak</option>
                        <option value="Copy SPPD">Copy SPPD</option>
                    </select>
                </div>

                <div class="form-group mb-1">
                    <label for="nm_pekerjaan" class="col-form-label s-12 col-md-4">Nm Pekerjaan</label>
                    <input type="text" name="nm_pekerjaan[]" id="nm_pekerjaan" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="klasifikasi" class="col-form-label s-12 col-md-4">Klasifikasi</label>
                    <input type="text" name="klasifikasi[]" id="klasifikasi" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="dinas" class="col-form-label s-12 col-md-4">Dinas</label>
                    <input type="text" name="dinas[]" id="dinas" placeholder="" class="form-control  r-0 s-12 col-md-6"
                        autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="nilai_kontrak" class="col-form-label s-12 col-md-4">Nilai kontrak</label>
                    <input type="text" name="nilai_kontrak[]" id="nilai_kontrak" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-1">
                    <label for="ppn" class="col-form-label s-12 col-md-4">PPN</label>
                    <input type="text" name="ppn[]" id="ppn" placeholder="" class="form-control  r-0 s-12 col-md-6"
                        autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="nilai_kontrak_exc_ppn" class="col-form-label s-12 col-md-4">nilai Kontrak Exc Ppn</label>
                    <input type="text" name="nilai_kontrak_exc_ppn[]" id="nilai_kontrak_exc_ppn" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="pph" class="col-form-label s-12 col-md-4">PPH</label>
                    <input type="text" name="pph[]" id="pph" placeholder="" class="form-control  r-0 s-12 col-md-6"
                        autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="nilai_kontrak_bersih" class="col-form-label s-12 col-md-4">Nilai Kontrak bersih</label>
                    <input type="text" name="nilai_kontrak_bersih[]" id="nilai_kontrak_bersih" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="nm_perusahaan" class="col-form-label s-12 col-md-4">Perusahaan</label>
                    <input type="text" name="nm_perusahaan[]" id="nm_perusahaan" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>

                <div class="form-group mb-1">
                    <label for="jml_pendapatan" class="col-form-label s-12 col-md-4">Pendapatan</label>
                    <input type="text" name="jml_pendapatan[]" id="jml_pendapatan" placeholder=""
                        class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for=""></label>
            <a class="btn-fab btn-fab-sm shadow btn-danger" style="" onclick="deleteFormPt(`+input_form_pt+`);">
                <i class="icon-minus"></i>
            </a>
            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrmPt" id="addBtnPt`+input_form_pt+`" onclick="addFormPt();">
                <i class="icon-plus"></i>
            </a>
        </div>
        </div>
        `;
        $('#input_form_pt').append(htmlAddPt);

        $('.addBtnFrmPt').last().show();
    }

    function deleteFormPt(id){
        $('.addBtnFrmPt').hide();
        $('#input_form_pt'+id).remove();
        $('.addBtnFrmPt').last().show();
    }
</script>
@endsection
