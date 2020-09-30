@extends('layouts.app')

@section('title', 'Detail Perusahaan')

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
                        <i class="icon icon-notebook-list"></i> Detail Perusahaan
                    </h3>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('pendapatan.aset.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua data</a>
                    </li>
                </ul>
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
                                    <th>No Index</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Pekerjaan</th>
                                    <th>Klasifikasi</th>
                                    <th>Dinas</th>
                                    <th>Nilai Kontrak</th>
                                    <th>PPN</th>
                                    <th>Nilai Kontrak Exc PPN</th>
                                    <th>PPH</th>
                                    <th>Nilai Kontrak Bersih</th>
                                    <th>Perusahaan</th>
                                    <th>Jumlah Pendapatan</th>
                                    <th width="40"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-1">
                <div id="alert"></div>
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" id="form" method="POST" novalidate>
                            @csrf
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id" />
                            <h4 id="formTitle">Edit Data</h4>
                            <hr>
                            <div class="form-row form-inline">
                                <div class="col-md-12">
                                    <div class="form-row form-inline">
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label for="no_index" class="col-form-label s-12 col-md-4">No
                                                    Index</label>
                                                <input type="text" name="no_index" id="no_index" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="jenis_doc" class="col-form-label s-12 col-md-4">
                                                    Jenis Dokumen</label>
                                                <select name="jenis_doc" id="jenis_doc" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" required>
                                                    <option value="">Pilih</option>
                                                    <option value="Copy kontrak">Copy kontrak</option>
                                                    <option value="Copy SPPD">Copy SPPD</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="nm_pekerjaan" class="col-form-label s-12 col-md-4">
                                                    Pekerjaan</label>
                                                <input type="text" name="nm_pekerjaan" id="nm_pekerjaan" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="klasifikasi"
                                                    class="col-form-label s-12 col-md-4">Klasifikasi</label>
                                                <input type="text" name="klasifikasi" id="klasifikasi" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="dinas" class="col-form-label s-12 col-md-4">Dinas</label>
                                                <input type="text" name="dinas" id="dinas" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="nilai_kontrak" class="col-form-label s-12 col-md-4">Nilai
                                                    kontrak</label>
                                                <input type="text" name="nilai_kontrak" id="nilai_kontrak"
                                                    placeholder="" class="form-control  r-0 s-12 col-md-6"
                                                    autocomplete="off" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label for="ppn" class="col-form-label s-12 col-md-4">PPN</label>
                                                <input type="text" name="ppn" id="ppn" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="nilai_kontrak_exc_ppn"
                                                    class="col-form-label s-12 col-md-4">Nilai Kontrak Exc Ppn</label>
                                                <input type="text" name="nilai_kontrak_exc_ppn"
                                                    id="nilai_kontrak_exc_ppn" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="pph" class="col-form-label s-12 col-md-4">PPH</label>
                                                <input type="text" name="pph" id="pph" placeholder=""
                                                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="nilai_kontrak_bersih"
                                                    class="col-form-label s-12 col-md-4">Nilai Kontrak bersih</label>
                                                <input type="text" name="nilai_kontrak_bersih" id="nilai_kontrak_bersih"
                                                    placeholder="" class="form-control  r-0 s-12 col-md-6"
                                                    autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="nm_perusahaan"
                                                    class="col-form-label s-12 col-md-4">Perusahaan</label>
                                                <input type="text" name="nm_perusahaan" id="nm_perusahaan"
                                                    placeholder="" class="form-control  r-0 s-12 col-md-6"
                                                    autocomplete="off" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="jml_pendapatan"
                                                    class="col-form-label s-12 col-md-4">Pendapatan</label>
                                                <input type="text" name="jml_pendapatan" id="jml_pendapatan"
                                                    placeholder="" class="form-control  r-0 s-12 col-md-6"
                                                    autocomplete="off" />
                                            </div>
                                        </div>
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
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/currency.js"></script>

<script type="text/javascript">
    var table = $('#table').dataTable({
        processing: true,
        serverSide: true,
        order: [1, 'desc'],
        ajax: "{{ route('pendapatan.aset.apiDetailPt', ':id')}}".replace(':id', {{ $id }}),
        columns: [{
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'no_index',
                name: 'no_index'
            },
            {
                data: 'jenis_doc',
                name: 'jenic_doc',
                visible: false
            },
            {
                data: 'nm_pekerjaan',
                name: 'nm_pekerjaan'
            },
            {
                data: 'klasifikasi',
                name: 'klasifikasi',
                visible: false
            },
            {
                data: 'dinas',
                name: 'dinas'
            },
            {
                data: 'nilai_kontrak',
                name: 'nilai_kontrak',
                render: function (data, type, row, meta) {
                    return meta.settings.fnFormatNumber(row.nilai_kontrak);
                }
            },
            {
                data: 'ppn',
                name: 'ppn',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(row.ppn);
                }
            },
            {
                data: 'nilai_kontrak_exc_ppn',
                name: 'nilai_kontrak_exc_ppn',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(row.nilai_kontrak_exc_ppn);
                }
            },
            {
                data: 'pph',
                name: 'pph',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(row.pph)
                }
            },
            {
                data: 'nilai_kontrak_bersih',
                name: 'nilai_kontrak_bersih',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(row.nilai_kontrak_bersih);
                }
            },
            {
                data: 'nm_perusahaan',
                name: 'nm_perusahaan'
            },
            {
                data: 'jml_pendapatan',
                name: 'jml_pendapatan',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(row.jml_pendapatan);
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
        var PageInfo = $('#table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
    function resetForm() {
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data");
    }

    function edit(id) {
        $('#alert').html('');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form input[name=_method]').val('PATCH');
        $('#span').removeAttr('hidden');
        $.ajax({
            url: "{{ route('pendapatan.aset.editDetailPt', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (data) {
                $('#formTitle').html("Edit Data <a href='#' onclick='resetForm()'class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
                $('#form').show();
                $('#id').val(data.id);
                $('#no_index').val(data.no_index);
                $('#jenis_doc').val(data.jenis_doc);
                $('#nm_pekerjaan').val(data.nm_pekerjaan);
                $('#klasifikasi').val(data.klasifikasi);
                $('#dinas').val(data.dinas);
                $('#nilai_kontrak').val(data.nilai_kontrak);
                $('#ppn').val(data.ppn);
                $('#nilai_kontrak_exc_ppn').val(data.nilai_kontrak_exc_ppn);
                $('#pph').val(data.pph);
                $('#nilai_kontrak_bersih').val(data.nilai_kontrak_bersih);
                $('#nm_perusahaan').val(data.nm_perusahaan);
                $('#jml_pendapatan').val(data.jml_pendapatan);
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

       $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            $.ajax({
                    url: "{{ route('pendapatan.aset.updateDetailPt', ':id') }}".replace(':id', $('#id').val()),
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#action').removeAttr('disabled');

                        table.api().ajax.reload();

                        resetForm();


                        $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label = 'Close' > <span aria-hidden='true'>×</span></button> <strong> Success! </strong> " + data.message + "</div>");
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
</script>
@endsection
