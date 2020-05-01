@extends('layouts.app')

@section('title', 'Edit Aset Keluar')

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
                        <i class="icon icon-notebook-list"></i> Edit Aset Keluar
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.keluar.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        <form class="needs-validation" method="POST" id="form" novalidate>
            @csrf
            @method('POST')
            <input type="hidden" id="id" name="id" />

            <div class="card no-b  no-r">
                <div class="card-body">
                    <h5 class="card-title" id="formTitle">Tambah Data</h5>
                    <div class="form-row form-inline">

                        <div class="col-md-8">

                            <div class="form-group mb-1">
                                <label for="opd_id" class="col-form-label s-12 col-md-4">OPD</label>
                                <div class="col-md-8">
                                    <select name="opd_id" id="opd_id" placeholder=""
                                        class="form-control select2 light  r-0 s-12" autocomplete="off" required>
                                        <option value="">Pilih</option>
                                        @foreach($tmopds as $tmopd)
                                        <option value="{{ $tmopd->id }}">{{ $tmopd->lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label for="aset_id" class="col-form-label s-12 col-md-4">Aset</label>
                                <div class="col-md-8">
                                    <select name="aset_id" id="aset_id" placeholder=""
                                        class="form-control select2 r-0 light s-12" autocomplete="off" required>
                                        <option value="">Pilih</option>
                                        @foreach($tmasets as $tmaset)
                                        <option value="{{ $tmaset->id }}">
                                            {{ $tmaset->n_jenis_aset . '-' . $tmaset->n_merk .'-'. $tmaset->serial . '-' . $tmaset->tahun . '-' . $tmaset->jumlah }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label for="ket" class="col-form-label s-12 col-md-4">Keterangan</label>
                                <textarea name="ket" id="ket" class="form-control light r-0 s-12 col-md-6 ml-3"
                                    autocomplete="off" required rows="4" cols="50"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="form-row form-inline" style="align-items: baseline">
                        <div class="col-md-12">
                            <div class="card-body offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i
                                        class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    $('#alert').html('');
    $('#formTitle').html("Mohon tunggu beberapa saat...");
    $('#txtAction').html(" Perubahan");
    $('#reset').hide();
    $('#form input[name=_method]').val('PATCH');
    $('#span').removeAttr('hidden');

    $.ajax({
        url: "{{ route('aset.keluar.edit', ':id') }}".replace(':id', {{ $id }}),
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('#formTitle').html("Edit Data");
            $('#form').show();
            $('#id').val(data.id);
            $('#opd_id').val(data.opd_id).trigger('change');
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
                            document.location.href = "{{ route('aset.keluar.index') }}";
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



</script>
@endsection
