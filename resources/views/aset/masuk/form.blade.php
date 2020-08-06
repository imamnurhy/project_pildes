@extends('layouts.app')

@section('title', 'Tambah Aset Masuk')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4 id="header">
                        <i class="icon icon-notebook-list"></i> Tambah Aset Masuk
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.masuk.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua Data
                        </a>
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

                        <div class="col-md-6">

                            <div class="form-group mb-1 ">
                                <label for="date" class="col-form-label s-12 col-md-4">Tanggal Entry</label>
                                <input type="date" name="date" id="date"
                                    class="form-control light r-0 s-12 col-md-6 ml-3" autocomplete="off" required />
                            </div>

                            <div class="form-group mb-1">
                                <label for="id_jenis_asset" class="col-form-label s-12 col-md-4">Jenis</label>
                                <select name="id_jenis_asset" id="id_jenis_asset"
                                    class="form-control light  r-0 s-12 col-md-6 ml-3" autocomplete="off" required
                                    onchange="getMerk()">
                                    <option value="">Pilih</option>
                                    @foreach($tmjenis_asets as $tmjenis_aset)
                                    <option value="{{ $tmjenis_aset->id }}">{{ $tmjenis_aset->n_jenis_aset }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label for="id_rincian_jenis_asset" class="col-form-label s-12 col-md-4">Rincian
                                    Jenis</label>
                                <select name="id_rincian_jenis_asset" id="id_rincian_jenis_asset"
                                    class="form-control light  r-0 s-12 col-md-6 ml-3" autocomplete="off" required>
                                    <option value="">Pilih</option>
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label for="id_tmperolehan" class="col-form-label s-12 col-md-4">Pembelian</label>
                                <select name="id_tmperolehan" id="id_tmperolehan"
                                    class="form-control light  r-0 s-12 col-md-6 ml-3" autocomplete="off" required>
                                    <option value="">Pilih</option>
                                    @foreach($tmperolehans as $tmperolehan)
                                    <option value="{{ $tmperolehan->id }}">{{ $tmperolehan->nm_pembelian }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label for="pemilik_sebelumnya" class="col-form-label s-12 col-md-4">Pemilik
                                    Sebelumnya</label>
                                <input type="text" name="pemilik_sebelumnya" id="pemilik_sebelumnya" placeholder=""
                                    class="form-control light r-0 s-12 col-md-6 ml-3" autocomplete="off" required />
                            </div>

                            <div class="form-group mb-1">
                                <label for="harga_beli" class="col-form-label s-12 col-md-4">Harga Beli</label>
                                <input type="text" name="harga_beli" id="harga_beli" placeholder=""
                                    class="form-control light r-0 s-12 col-md-6 ml-3" autocomplete="off" required
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            </div>

                            <div class="form-group mb-1">
                                <label for="tahun" class="col-form-label s-12 col-md-4">Tahun</label>
                                <input maxlength="4" type="text" name="tahun" id="tahun" placeholder=""
                                    class="form-control light r-0 s-12 col-md-6 ml-3" autocomplete="off" required
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            </div>

                            <div class="form-group mb-1">
                                <label for="status" class="col-form-label s-12 col-md-4">Status</label>
                                <select name="status" id="status" class="form-control light  r-0 s-12 col-md-6 ml-3"
                                    autocomplete="off" required>
                                    <option value="">Pilih</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Tidak Ada</option>
                                </select>
                            </div>

                            <div class="form-group mb-1">
                                <label for="kondisi" class="col-form-label s-12 col-md-4">Kondisi</label>
                                <input type="text" name="kondisi" id="kondisi" placeholder=""
                                    class="form-control light r-0 s-12 col-md-6 ml-3" autocomplete="off" required />
                            </div>

                            <div class="form-group mb-1">
                                <label for="id_dokumen" class="col-form-label s-12 col-md-4">Doc Kelengkapan</label>
                                <div class="col-md-6">
                                    <select name="id_dokumen[]" id="id_dokumen"
                                        class="form-control select2 light  r-0 s-12  ml-3" autocomplete="off" required
                                        multiple="multiple">
                                        <option value="">Pilih</option>
                                        @foreach($tmdokumens as $tmdokumen)
                                        <option value="{{ $tmdokumen->id }}">{{ $tmdokumen->nama_dokumen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-row form-inline" style="align-items: baseline">
                        <div class="col-md-12">
                            <div class="card-body offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data">
                                    <i class="icon-save mr-2"></i>
                                    Simpan
                                    <span id="txtAction"></span>
                                </button>
                                <a class="btn btn-sm" onclick="add()" id="reset" title="Reset inputan">Reset</a>
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
    {{ $id == 0 ? 'add()' : 'edit('.$id.')'}}

    function add() {
        save_method = 'add';
        $('#form').trigger('reset');
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            if (save_method == 'add'){
                url = "{{ route('aset.masuk.store') }}";
            }else{
                url = "{{ route('aset.masuk.update', ':id') }}".replace(':id', $('#id').val());
            }

            console.log(save_method);

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
                            document.location.href = "{{ route('aset.masuk.index') }}";
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
        var id = id;
        $('#alert').html('');
        $('#header').html('Edit Data Aset Masuk');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form input[name=_method]').val('PATCH');
        $('#span').removeAttr('hidden');
        $.ajax({
            url: "{{ route('aset.masuk.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#formTitle').html("Edit Data");
                $('#form').show();
                $('#id').val(data.id);
                $('#date').val(data.date);

                $('#id_jenis_asset').val(data.id_jenis_asset);
                //-- Get and select merk
                getMerk(data.id_rincian_jenis_asset);

                $('#id_tmperolehan').val(data.id_tmperolehan);
                $('#pemilik_sebelumnya').val(data.pemilik_sebelumnya);
                $('#harga_beli').val(data.harga_beli);
                $('#tahun').val(data.tahun);
                $('#status').val(data.status);
                $('#kondisi').val(data.kondisi);
                $('#id_dokumen').val(data.id_dokumen).trigger('change');

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
                                document.location.href = "{{ route('aset.masuk.index') }}";
                            }
                        }
                    }
                });
            }
        })
    }

    function getMerk(id) {
        $('#id_rincian_jenis_asset').html("<option value=''>Loading...</option>");
        url = "{{ route('aset.masuk.getMerk', ':id') }}".replace(':id', $('#id_jenis_asset').val());

        // Disable button action when prosess getMerek
        $('#action').attr('disabled', true);
        $.get(url, function (data) {
            option = "<option value=''>Pilih</option>";
            $.each(data, function (index, value) {
                option += "<option value='" + value.id + "'>" + value.n_merk + "</li>";
            });
            $('#id_rincian_jenis_asset').html(option);
        }, 'JSON').done(function () {
            $('#id_rincian_jenis_asset').val(id).trigger('change');

            // Enable button action when success getMerek
            $('#action').removeAttr('disabled', true);
        });
    }


    function generateNoAset(){
        url = "{{ route('aset.masuk.generateNoAset') }}";
        $.get(url, {
            jenis_aset_id: $('#jenis_aset_id').val(),
            merk_id: $('#merk_id').val(),
        }, function(data) {
            $('#no_aset').val(data);
            $('#no_aset2').val(data);
        }, 'JSON').done(function() {
            console.log('done');
        })
    }

</script>
@endsection
