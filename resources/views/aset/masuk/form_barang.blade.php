<form class="needs-validation" id="form" method="POST">
    <div class="card-body">
        <strong class="card-title">Edit Detail Barang</strong>
        @csrf
        <input type="hidden" name="id_master_aset" value="{{ $tmmaster_asset->tmmaster_asset_id }}" />
        <input type="hidden" name="form_edit" value="{{ $formEdit }}" />

        <div class="form-inline row">
            <div class="form-group m-0 col-md-12">
                <label for="nomor" class="col-form-label s-12 col-md-4">Nomor</label>
                <input type="text" name="nomor" id="nomor" class="form-control light r-0 s-12 col-md-6"
                    autocomplete="off" value="{{ $data ? $data->nomor : '' }}" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="merk" class="col-form-label s-12 col-md-4">Merk</label>
                <input type="text" name="merk" id="merk" value="{{ $data ? $data->merk : '' }}" class="form-control light r-0 s-12 col-md-6" autocomplete="off"
                    required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="jenis" class="col-form-label s-12 col-md-4">Jenis</label>
                <input type="text" name="jenis" id="jenis" value="{{ $data ? $data->jenis : '' }}"  class="form-control light r-0 s-12 col-md-6"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="tahun_pembuatan" class="col-form-label s-12 col-md-4">Tahun</label>
                <input type="text" name="tahun_pembuatan" id="tahun_pembuatan"
                    class="form-control light r-0 s-12 col-md-6" value="{{ $data ? $data->tahun_pembuatan : '' }}"  autocomplete="off" required maxlength="4"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>
            <div class="form-group m-0 col-md-12">
                <label for="no_rangka" class="col-form-label s-12 col-md-4">No Rangka</label>
                <input type="text" name="no_rangka" id="no_rangka" value="{{ $data ? $data->no_rangka : '' }}" class="form-control light r-0 s-12 col-md-6"
                    autocomplete="off" required
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="no_mesin" class="col-form-label s-12 col-md-4">No Mesin</label>
                <input type="text" name="no_mesin" id="no_mesin" value="{{ $data ? $data->no_mesin : '' }}"  class="form-control light r-0 s-12 col-md-6"
                    autocomplete="off" required
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>


            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-sm float-right" id="action" title="Simpan data"><i
                        class="icon-save mr-2"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>
