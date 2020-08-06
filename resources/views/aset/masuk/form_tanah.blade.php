<form class="needs-validation" id="form" method="POST">
    <div class="card-body">
        <strong class="card-title">Edit Detail Tanah</strong>
        @csrf
        <input type="hidden" name="id_master_aset" value="{{ $tmmaster_asset->tmmaster_asset_id }}" />
        <input type="hidden" name="id_jenis_tanah" value="{{ $tmmaster_asset->tmjenis_asets_id }}" />
        <input type="hidden" name="nm_pemilik_sebelum" value="{{ $tmmaster_asset->pemilik_sebelumnya }}" />
        <div class="form-inline row">
            <div class="col-md-6">
                <div class="form-group m-0 col-md-12">
                    <label for="nm_lahan" class="col-form-label s-12 col-md-4">Nama Lahan</label>
                    <input type="text" name="nm_lahan" id="nm_lahan" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="luas" class="col-form-label s-12 col-md-4">Luas</label>
                    <input type="text" name="luas" id="luas" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="alamat" class="col-form-label s-12 col-md-4">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="batas_barat" class="col-form-label s-12 col-md-4">Batas Barat</label>
                    <input type="text" name="batas_barat" id="batas_barat" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="batas_timur" class="col-form-label s-12 col-md-4">Batas Timur</label>
                    <input type="text" name="batas_timur" id="batas_timur" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="batas_selatan" class="col-form-label s-12 col-md-4">Batas Selatan</label>
                    <input type="text" name="batas_selatan" id="batas_selatan"
                        class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="batas_utara" class="col-form-label s-12 col-md-4">Batas Utara</label>
                    <input type="text" name="batas_utara" id="batas_utara" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="latitude" class="col-form-label s-12 col-md-4">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group m-0 col-md-12">
                    <label for="longitude" class="col-form-label s-12 col-md-4">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="provinsi_id" class="col-form-label s-12 col-md-4">Provinsi</label>
                    <select name="provinsi_id" id="provinsi_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-6" onchange="getKabupaten()" required>
                        <option value="">Pilih</option>
                        @foreach($provinsis as $key=>$provinsi)
                        <option value="{{ $provinsi->id }}">{{ $provinsi->n_provinsi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="kabupaten_id" class="col-form-label s-12 col-md-4">Kota</label>
                    <select name="kota_id" id="kabupaten_id" placeholder="" class="form-control r-0 light s-12 col-md-6"
                        onchange="getKecamatan()" required>
                        <option value="">Pilih</option>
                    </select>
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="kecamatan_id" class="col-form-label s-12 col-md-4">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-6" onchange="getKelurahan()" required>
                        <option value="">Pilih</option>
                    </select>
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="kelurahan_id" class="col-form-label s-12 col-md-4">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" placeholder=""
                        class="form-control r-0 light s-12 col-md-6" required>
                        <option value="">Pilih</option>
                    </select>
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="luas_tanah" class="col-form-label s-12 col-md-4">Luah Tanah</label>
                    <input type="text" name="luas_tanah" id="luas_tanah" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="tanda_bukti" class="col-form-label s-12 col-md-4">Tanda Bukti</label>
                    <input type="file" name="tanda_bukti" id="tanda_bukti" class="form-control light r-0 s-12 col-md-6"
                        autocomplete="off" required />
                </div>

                <div class="form-group m-0 col-md-12">
                    <label for="file_bukti_beli" class="col-form-label s-12 col-md-4">Bukti Beli</label>
                    <input type="file" name="file_bukti_beli" id="file_bukti_beli"
                        class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                </div>
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
