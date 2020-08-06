<form class="needs-validation" id="form" method="POST">
    <div class="card-body">
        <strong class="card-title">Edit Detail Tanah</strong>
        @csrf
        @method('PATCH')
        <input type="hidden" name="id_master_aset" value="{{ $tmmaster_asset->tmmaster_asset_id }}" />
        <input type="hidden" name="id_jenis_tanah" value="{{ $tmmaster_asset->tmjenis_asets_id }}" />
        <div class="form-inline">
            <div class="form-group m-0 col-md-12">
                <label for="nm_lahan" class="col-form-label s-12 col-md-2">Nama Lahan</label>
                <input type="text" name="nm_lahan" id="nm_lahan" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="luas" class="col-form-label s-12 col-md-2">Luah</label>
                <input type="text" name="luas" id="luas" class="form-control light r-0 s-12 col-md-4" autocomplete="off"
                    required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="alamat" class="col-form-label s-12 col-md-2">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="batas_barat" class="col-form-label s-12 col-md-2">Batas Barat</label>
                <input type="text" name="batas_barat" id="batas_barat" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="batas_timur" class="col-form-label s-12 col-md-2">Batas Timur</label>
                <input type="text" name="batas_timur" id="batas_timur" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="batas_selatan" class="col-form-label s-12 col-md-2">Batas Selatan</label>
                <input type="text" name="batas_selatan" id="batas_selatan" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="batas_utara" class="col-form-label s-12 col-md-2">Batas Utara</label>
                <input type="text" name="batas_utara" id="batas_utara" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="latitude" class="col-form-label s-12 col-md-2">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="longitude" class="col-form-label s-12 col-md-2">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="provinsi_id" class="col-form-label s-12 col-md-2">Provinsi</label>
                <select name="provinsi_id" id="provinsi_id" placeholder="" class="form-control r-0 light s-12 col-md-4"
                    onchange="getKabupaten()" required>
                    <option value="">Pilih</option>
                    @foreach($provinsis as $key=>$provinsi)
                    <option value="{{ $provinsi->id }}">{{ $provinsi->n_provinsi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="kabupaten_id" class="col-form-label s-12 col-md-2">Kota</label>
                <select name="kota_id" id="kabupaten_id" placeholder="" class="form-control r-0 light s-12 col-md-4"
                    onchange="getKecamatan()" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="kecamatan_id" class="col-form-label s-12 col-md-2">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" placeholder=""
                    class="form-control r-0 light s-12 col-md-4" onchange="getKelurahan()" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="kelurahan_id" class="col-form-label s-12 col-md-2">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" placeholder=""
                    class="form-control r-0 light s-12 col-md-4" required>
                    <option value="">Pilih</option>
                </select>
            </div>

            <div class="form-group m-0 col-md-12">
                <label for="luas_lahan" class="col-form-label s-12 col-md-2">Luah Tanah</label>
                <input type="text" name="luas_lahan" id="luas_lahan" class="form-control light r-0 s-12 col-md-4"
                    autocomplete="off" required
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
            </div>




            <div class="card-body offset-md-2">
                <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i
                        class="icon-save mr-2"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>
