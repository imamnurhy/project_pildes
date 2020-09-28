@extends('layouts.app')

@section('title', 'Rincian aset')

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
                        <i class="icon icon-notebook-list"></i> Rincian Aset
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped no-b" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th>Aset</th>
                                    <th>No index</th>
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
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" id="form" method="POST" novalidate>
                            @csrf
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id" />
                            <h4 id="formTitle">Tambah Data</h4>
                            <hr>
                            <div class="form-row form-inline">
                                <div class="col-md-12">

                                    <div class="form-group mb-1">
                                        <label for="tm_penghasilan_aset_id" class="col-form-label s-12 col-md-4">Jenis
                                            aset</label>
                                        <select name="tm_penghasilan_aset_id" id="tm_penghasilan_aset_id" placeholder=""
                                            class="form-control  r-0 s-12 col-md-8" autocomplete="off" required>
                                            <option value="">Pilih</option>
                                            @foreach ($tm_penghasilan_asets as $item)
                                            <option value="{{ $item->id }}">{{ $item->n_aset }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label for="no_index" class="col-form-label s-12 col-md-4">No Index</label>
                                        <input type="text" name="no_index" id="no_index" placeholder=""
                                            class="form-control  r-0 s-12 col-md-8" autocomplete="off" required />
                                    </div>

                                    <div class="card-body offset-md-3">
                                        <button type="submit" class="btn btn-primary btn-sm" id="action"><i
                                                class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                        <a class="btn btn-sm" onclick="add()" id="reset">Reset</a>
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

<script type="text/javascript">
    {{ isset($id) ? 'add()' : 'edit('.$id.')'}}

var table = $('#table').dataTable({
    processing: true,
    serverSide: true,
    order: [1, 'desc'],
    ajax: "{{ route('pendapatan.rincianAset.api')}}",
    columns: [{
            data: 'id',
            name: 'id',
            orderable: false,
            searchable: false,
            className: 'text-center'
        },
        {
            data: 'tm_penghasilan_aset.n_aset',
            name: 'tm_penghasilan_aset.n_aset'
        },
        {
            data:'no_index',
            name:'no_index'
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
}

$('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            if (save_method == 'add'){
                url = "{{ route('pendapatan.rincianAset.store') }}";
            }else{
                url = "{{ route('pendapatan.rincianAset.update', ':id') }}".replace(':id', $('#id').val());
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
                            table.api().ajax.reload();
                            $('#form').trigger('reset');
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
        $.ajax({
            url: "{{ route('pendapatan.rincianAset.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#formTitle').html("Edit Data  <a href='#' onclick='add()' class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
                $('#form').show();
                $('#id').val(data.id);
                $('#tm_penghasilan_aset_id').val(data.tm_penghasilan_aset_id);
                $('#no_index').val(data.no_index);
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
                                document.location.href = "{{ route('pendapatan.rincianAset.index') }}";
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
                        url: "{{ route('pendapatan.rincianAset.destroy', ':id') }}".replace(':id', id),
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
