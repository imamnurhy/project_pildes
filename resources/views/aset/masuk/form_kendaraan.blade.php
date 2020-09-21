<div class="card">
    <div class="card-header white">
        <i class="icon-clipboard-edit blue-text"></i>
        <strong id="formTitle"> Tambah Detail Kendaraan </strong>
    </div>
    <div class="card-body no-b">
        <form class="needs-validation" id="form_kendaraan" method="POST">
            <div class="card-body">
                @csrf
                {{ method_field('POST') }}
                <input type="hidden" name="id_master_aset" value="{{ $tmmaster_asset->tmmaster_asset_id }}" />
                <input type="hidden" name="form_edit" id="form_edit" value="{{ $formEdit }}" />
                <input type="hidden" name="id" id="id">

                <div class="form-inline row">

                    <div class="form-group m-0 col-md-12">
                        <label for="no_polisi" class="col-form-label s-12 col-md-4">Nomor polisi</label>
                        <input type="text" name="no_polisi" id="no_polisi" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="merek" class="col-form-label s-12 col-md-4">Merk</label>
                        <input type="text" name="merek" id="merek" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="no_stnk" class="col-form-label s-12 col-md-4">No STNK</label>
                        <input type="text" name="no_stnk" id="no_stnk" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="nm_pemilik" class="col-form-label s-12 col-md-4">Pemilik</label>
                        <input type="text" name="nm_pemilik" id="nm_pemilik"
                            class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="sumber_barang" class="col-form-label s-12 col-md-4">Sumber barang</label>
                        <select name="sumber_barang" id="sumber_barang" class="form-control light  r-0 s-12 col-md-6"
                            autocomplete="off" required>
                            <option value="">Pilih</option>
                            <option value="Leasing">Leasing</option>
                        </select>
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="nilai" class="col-form-label s-12 col-md-4">Nilai</label>
                        <input type="text" name="nilai" id="nilai" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                    </div>

                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-sm float-right" id="action"
                            title="Simpan data"><i class="icon-save mr-2"></i>
                            Simpan
                            <span id="txtAction"></span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-2">
    <div class="card-header white">
        <i class="icon-clipboard-edit blue-text"></i>
        <strong> Tabel </strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="kendaraan-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>No polisi</th>
                    <th>No STNK</th>
                    <th>Pemilik</th>
                    <th>Merek</th>
                    <th>Sumber barang</th>
                    <th>Nilai</th>
                    <th class="text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>
                @foreach ($tmAssetKendaraans as $key => $tmAssetKendaraan)
                <tr>
                    <td class="text-center">{{ ++$key }}</td>
                    <td>{{ $tmAssetKendaraan->no_polisi }}</td>
                    <td>{{ $tmAssetKendaraan->no_stnk }}</td>
                    <td>{{ $tmAssetKendaraan->nm_pemilik }}</td>
                    <td>{{ $tmAssetKendaraan->merek }}</td>
                    <td>{{ $tmAssetKendaraan->sumber_barang }}</td>
                    <td>{{ $tmAssetKendaraan->nilai }}</td>
                    <td class="text-center">
                        <a href="#" onclick="editKendaraan({{ $tmAssetKendaraan->id }})" title="Edit Merek"><i
                                class="icon-pencil mr-1"></i></a>
                        <a href="#" onclick="removeKendaraan({{ $tmAssetKendaraan->id }})" class="text-danger"
                            title="Hapus Berkas">
                            <i class="icon-remove"></i>
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@section('script_incl')
<script>
    var table = $('#kendaraan-table').dataTable({})
    save_method = 'add';

     $('#form_kendaraan').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);

            if(save_method == 'add'){
                url = "{{ route('aset.masuk.detail.store') }}";
            } else {
                url = "{{ route('aset.masuk.detail.update', ':id') }}".replace(':id', $('#id').val());
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

    function editKendaraan(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#header').html('Edit Data Aset Masuk');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form_kendaraan input[name=_method]').val('PATCH');
        $('#span').removeAttr('hidden');
        $.ajax({
            url: "{{ route('aset.masuk.detail.edit', ':id') }}".replace(':id', id),
            type: "GET",
            data: {
                form_edit : $('#form_edit').val(),
            },
            dataType: "JSON",
            success: function (data) {
                $('#formTitle').html("Edit Data");
                $('#form').show();
                $('#id').val(data.id);
                $('#no_polisi').val(data.no_polisi);
                $('#merek').val(data.merek);
                $('#no_stnk').val(data.no_stnk);
                $('#nm_pemilik').val(data.nm_pemilik);
                $('#sumber_barang').val(data.sumber_barang);
                $('#nilai').val(data.nilai);
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

    function removeKendaraan(id) {
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
                        url: "{{ route('aset.masuk.detail.destroy', ':id') }}".replace(':id', id),
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        success: function (data) {
                          $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success! </strong>" + data.message + "</div>");
                            location.reload();
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
