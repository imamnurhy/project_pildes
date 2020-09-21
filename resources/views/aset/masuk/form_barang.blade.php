<div class="card">
    <div class="card-header white">
        <i class="icon-clipboard-edit blue-text"></i>
        <strong id="formTitle"> Tambah Detail Barang </strong>
    </div>
    <div class="card-body no-b">
        <form class="needs-validation" id="form_barang" method="POST">
            <div class="card-body">
                @csrf
                {{ method_field('POST') }}
                <input type="hidden" name="id_master_aset" value="{{ $tmmaster_asset->tmmaster_asset_id }}" />
                <input type="hidden" name="form_edit" id="form_edit" value="{{ $formEdit }}" />
                <input type="hidden" name="id" id="id">

                <div class="form-inline row">
                    <div class="form-group m-0 col-md-12">
                        <label for="nomor" class="col-form-label s-12 col-md-4">Nomor</label>
                        <input type="text" name="nomor" id="nomor" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="merk" class="col-form-label s-12 col-md-4">Merk</label>
                        <input type="text" name="merk" id="merk" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="jenis" class="col-form-label s-12 col-md-4">Jenis</label>
                        <input type="text" name="jenis" id="jenis" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="tahun_pembuatan" class="col-form-label s-12 col-md-4">Tahun</label>
                        <input type="text" name="tahun_pembuatan" id="tahun_pembuatan"
                            class="form-control light r-0 s-12 col-md-6" autocomplete="off" required maxlength="4"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                    </div>
                    <div class="form-group m-0 col-md-12">
                        <label for="no_rangka" class="col-form-label s-12 col-md-4">No Rangka</label>
                        <input type="text" name="no_rangka" id="no_rangka" class="form-control light r-0 s-12 col-md-6"
                            autocomplete="off" required
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                    </div>

                    <div class="form-group m-0 col-md-12">
                        <label for="no_mesin" class="col-form-label s-12 col-md-4">No Mesin</label>
                        <input type="text" name="no_mesin" id="no_mesin" class="form-control light r-0 s-12 col-md-6"
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
        <table class="table table-bordered" id="barang-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nomor</th>
                    <th>Merek</th>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Nomor rangka</th>
                    <th>Nomor mesin</th>

                    <th class="text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>
                @foreach ($tmaset_barangs as $key => $tmaset_barang)
                <tr>
                    <td class="text-center">{{ ++$key }}</td>
                    <td>{{ $tmaset_barang->nomor }}</td>
                    <td>{{ $tmaset_barang->merk }}</td>
                    <td>{{ $tmaset_barang->jenis }}</td>
                    <td>{{ $tmaset_barang->tahun_pembuatan }}</td>
                    <td>{{ $tmaset_barang->no_rangka }}</td>
                    <td>{{ $tmaset_barang->no_mesin }}</td>


                    <td class="text-center">
                        <a href="#" onclick="editBarang({{ $tmaset_barang->id }})" title="Edit barang"><i
                                class="icon-pencil mr-1"></i></a>
                        <a href="#" onclick="removeBarang({{ $tmaset_barang->id }})" class="text-danger"
                            title="Hapus barang">
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
    var table = $('#barang-table').dataTable({})
    save_method = 'add';

     $('#form_barang').on('submit', function (e) {
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

    function editBarang(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#header').html('Edit Data Aset Masuk');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form_barang input[name=_method]').val('PATCH');
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
                $('#nomor').val(data.nomor);
                $('#merk').val(data.merk);
                $('#jenis').val(data.jenis);
                $('#tahun_pembuatan').val(data.tahun_pembuatan);
                $('#no_rangka').val(data.no_rangka);
                $('#no_mesin').val(data.no_mesin);
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

function removeBarang(id) {
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
                            '_token': csrf_token,
                            'form_edit': $('#form_edit').val()
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
