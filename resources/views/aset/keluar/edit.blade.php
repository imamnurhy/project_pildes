@extends('layouts.app')

@section('title', 'Edit Asset keluar')

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
                        <i class="icon icon-clipboard-list"></i> Edit Asset Keluar
                    </h3>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.keluar.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="row container-fluid my-3 m-0">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-detail-aset-keluar" class="table table-striped no-b" style="width:100%">
                            <thead>
                                <th width="30">No</th>
                                <th>Jenis</th>
                                <th width="100px">Rincian Jenis</th>
                                <th>Ket</th>
                                <th>Tanggal</th>
                                <th width="40"></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="column col-md-4">
            <div id="alert"></div>

            {{-- <div class="card mb-3">
                <div class="card-header">
                    <h4>Edit Foto</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation" id="form2" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PATCH')
                        <input type="hidden" id="id_foto" name="id_foto" value="{{ $tmopd_id }}" />
            <div class="form-row form-inline" style="align-items: baseline">
                <div class="col-md-12">
                    <div class="form-group m-1">
                        @if ($tmopd->image_network != '')
                        <img src="{{ config('app.SFTP_SRC') . 'aset/opd/' . $tmopd->image_network}}" width="150px"
                            height="150px" id="priview_image" style="border-radius: 5%" class="center">
                        @else
                        <img src="https://via.placeholder.com/150" id="priview_image" style="border-radius: 5%"
                            class="center" width="150px" height="150px" />
                        @endif
                    </div>
                    <div class="form-group m-0">
                        <label for="foto" class="col-form-label s-12 col-md-2">Foto</label>
                        <input type="file" name="foto" id="foto" placeholder=""
                            class="form-control r-0 light s-12 col-md-10" autocomplete="off"
                            value="Pemerintah Kota Tangerang Selatan" required />
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm" id="action2" disabled style="float: right">
                <i class="icon-save mr-2"></i>
                Simpan perubahan
            </button>
        </div>
    </div> --}}

    <div class="card">
        <div class="card-header">
            <h4 id="formTitle">Edit Data</h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" id="form" method="POST" novalidate>
                @csrf
                {{ method_field('POST') }}
                <input type="hidden" id="id" name="id" />
                <input type="hidden" name="opd_id" value="{{ $tmopd_id }}" />
                <div class="form-row form-inline">
                    <div class="col-md-12">
                        <div class="form-group mb-1">
                            <label for="aset_id" class="col-form-label s-12 col-md-2">Jenis</label>
                            <div class="col-md-10">
                                <select name="aset_id" id="aset_id" disabled class="form-control select2 r-0 light s-12"
                                    autocomplete="off" required>
                                    <option value="">Pilih</option>
                                    @foreach($tmmaster_assets as $tmmaster_asset)
                                    <option value="{{ $tmmaster_asset->id }}">
                                        {{ $tmmaster_asset->n_jenis_aset . '-' . $tmmaster_asset->n_rincian . '-' . $tmmaster_asset->tahun  }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-1">
                            <label for="ket" class="col-form-label s-12 col-md-2">Keterangan</label>
                            <div class="col-md-10">
                                <textarea name="ket" id="ket" class="form-control light r-0 s-12" autocomplete="off"
                                    required rows="4" style="min-width: 100%" disabled>
                                </textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm" id="action" disabled style="float: right">
                <i class="icon-save mr-2"></i>
                Simpan perubahan
                <span id="txtAction"></span>
            </button>
        </div>
    </div>

</div>
</div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    var table = $('#table-detail-aset-keluar').dataTable({
        processing: true,
        serverSide: true,
        order: [1, 'desc'],
        ajax: "{{ route('aset.keluar.apiDetailAsetKeluar', ':id')}}".replace(':id', {{ $tmopd_id }}),
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data:'n_jenis_aset',
                name:'n_jenis_aset'
            },
            {
                data:'n_rincian',
                name:'n_rincian'
            },
            {
                data:'ket',
                name:'ket'
            },
            {
                data:'created_at',
                name:'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#table-detail-aset-keluar').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });


    function reset(){
        $('#form').trigger('reset');
        $('#formTitle').html('Edit Data');
        $('#txtAction').html('');
        $('#aset_id').val("").trigger('change');
        $('#aset_id').attr('disabled', 'disabled');
        $('#action').attr('disabled', 'disabled');
        $('#ket').attr('disabled', 'disabled');
    }

    function edit(id){
        $('#alert').html('');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#reset').hide();
        $('#form input[name=_method]').val('PATCH');
        $('#span').removeAttr('hidden');
        $('#action').attr('disabled', true);


        $.ajax({
            url: "{{ route('aset.keluar.edit', ':id') }}".replace(':id',  id ),
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#formTitle').html("Edit Data <a href='#' onclick='reset()' class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
                $('#aset_id').removeAttr('disabled');
                $('#action').removeAttr('disabled');
                $('#ket').removeAttr('disabled');

                $('#form').show();
                $('#id').val(data.id);
                $('#aset_id').val(data.aset_id).trigger('change');
                $('#ket').html(data.ket);
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
                                document.location.href = "{{ route('aset.keluar.index') }}";
                            }
                        }
                    }
                });
            }
        });
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            $.ajax({
                    url: "{{ route('aset.keluar.update', ':id') }}".replace(':id', $('#id').val()),
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#action').removeAttr('disabled');
                        $('#form').trigger('reset');
                        if (data.success == 1) {
                            $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label = 'Close' > <span aria-hidden='true'>×</span></button> <strong> Success! </strong> " + data.message + "</div>");
                            table.api().ajax.reload();
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
                            url: "{{ route('aset.keluar.destroyOpdAset', ':id') }}".replace(':id', id),
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
            $('#alert').html('');
            // $('#action2').attr('disabled', true);
            console.log('jalan');
            url = "{{ route('aset.keluar.updateFoto', ':id') }}".replace(':id', $('#id_foto').val());
            $.ajax({
                url : url,
                type : 'PATCH',
                data: new FormData($(this)[0]),
                dataType:'JSON',
                contentType: false,
                processData: false,
                success : function(data) {
                    // $('#action2').removeAttr('disabled', true);
                    if(data.success == 1){
                        $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                        table.api().ajax.reload();
                        if(save_method == 'add'){
                            add();
                        }
                    }
                },
                error : function(data){
                    // $('#action2').removeAttr('disabled', true);
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

    function editFoto(id) {
        $('#id_foto').val(id);
    }

         function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#priview_image').attr('src', e.target.result);
                $('#priview_image_text').remove();
                $('#action2').removeAttr('disabled', true);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#foto").change(function(){
        readURL(this);
    });

</script>
@endsection
