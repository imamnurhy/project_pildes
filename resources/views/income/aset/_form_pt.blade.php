<div id="input_form_pt" style="display: none">
    <div class="form-row form-inline">
        <div class="col-md-6">
            <div class="form-group mb-1">
                <label for="no_index" class="col-form-label s-12 col-md-4">No Index</label>
                <input type="text" name="no_index[]" id="no_index" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="jenis_doc" class="col-form-label s-12 col-md-4">
                    Rincian Asset</label>
                <select name="jenis_doc[]" id="jenis_doc" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" required>
                    <option value="">Pilih</option>
                    <option value="Copy kontrak">Copy kontrak</option>
                    <option value="Copy SPPD">Copy SPPD</option>
                </select>
            </div>

            <div class="form-group mb-1">
                <label for="nm_pekerjaan" class="col-form-label s-12 col-md-4">Nm Pekerjaan</label>
                <input type="text" name="nm_pekerjaan[]" id="nm_pekerjaan" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="klasifikasi" class="col-form-label s-12 col-md-4">Klasifikasi</label>
                <input type="text" name="klasifikasi[]" id="klasifikasi" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="dinas" class="col-form-label s-12 col-md-4">Dinas</label>
                <input type="text" name="dinas[]" id="dinas" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nilai_kontrak" class="col-form-label s-12 col-md-4">Nilai kontrak</label>
                <input type="text" name="nilai_kontrak[]" id="nilai_kontrak" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-1">
                <label for="ppn" class="col-form-label s-12 col-md-4">PPN</label>
                <input type="text" name="ppn[]" id="ppn" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nilai_kontrak_exc_ppn" class="col-form-label s-12 col-md-4">Nilai Kontrak Exc Ppn</label>
                <input type="text" name="nilai_kontrak_exc_ppn[]" id="nilai_kontrak_exc_ppn" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="pph" class="col-form-label s-12 col-md-4">PPH</label>
                <input type="text" name="pph[]" id="pph" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nilai_kontrak_bersih" class="col-form-label s-12 col-md-4">Nilai Kontrak bersih</label>
                <input type="text" name="nilai_kontrak_bersih[]" id="nilai_kontrak_bersih" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nm_perusahaan" class="col-form-label s-12 col-md-4">Perusahaan</label>
                <input type="text" name="nm_perusahaan[]" id="nm_perusahaan" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="jml_pendapatan" class="col-form-label s-12 col-md-4">Pendapatan</label>
                <input type="text" name="jml_pendapatan[]" id="jml_pendapatan" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>
        </div>
        <div class="form-group mb-1">
            <label for=""></label>
            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrmPt" id="addBtnPt" onclick="addFormPt();">
                <i class="icon-plus"></i>
            </a>
        </div>
    </div>
</div>

<div id="edit_form_pt" style="display: none">
    <div class="form-row form-inline">
        <div class="col-md-6">
            <div class="form-group mb-1">
                <label for="no_index_e" class="col-form-label s-12 col-md-4">No Index</label>
                <input type="text" name="no_index_e" id="no_index_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="jenis_doc_e" class="col-form-label s-12 col-md-4">
                    Rincian Asset</label>
                <select name="jenis_doc_e" id="jenis_doc_e" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" required>
                    <option value="">Pilih</option>
                    <option value="Copy kontrak">Copy kontrak</option>
                    <option value="Copy SPPD">Copy SPPD</option>
                </select>
            </div>

            <div class="form-group mb-1">
                <label for="nm_pekerjaan_e" class="col-form-label s-12 col-md-4">Nm Pekerjaan</label>
                <input type="text" name="nm_pekerjaan_e" id="nm_pekerjaan_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="klasifikasi_e" class="col-form-label s-12 col-md-4">Klasifikasi</label>
                <input type="text" name="klasifikasi_e" id="klasifikasi_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="dinas_e" class="col-form-label s-12 col-md-4">Dinas</label>
                <input type="text" name="dinas_e" id="dinas_e" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nilai_kontrak_e" class="col-form-label s-12 col-md-4">Nilai kontrak</label>
                <input type="text" name="nilai_kontrak_e" id="nilai_kontrak_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-1">
                <label for="ppn_e" class="col-form-label s-12 col-md-4">PPN</label>
                <input type="text" name="ppn_e" id="ppn_e" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nilai_kontrak_exc_ppn_e" class="col-form-label s-12 col-md-4">Nilai Kontrak Exc Ppn</label>
                <input type="text" name="nilai_kontrak_exc_ppn_e" id="nilai_kontrak_exc_ppn_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="pph_e" class="col-form-label s-12 col-md-4">PPH</label>
                <input type="text" name="pph_e" id="pph_e" placeholder="" class="form-control  r-0 s-12 col-md-6"
                    autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nilai_kontrak_bersih_e" class="col-form-label s-12 col-md-4">Nilai Kontrak bersih</label>
                <input type="text" name="nilai_kontrak_bersih_e" id="nilai_kontrak_bersih_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="nm_perusahaan_e" class="col-form-label s-12 col-md-4">Perusahaan</label>
                <input type="text" name="nm_perusahaan_e" id="nm_perusahaan_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>

            <div class="form-group mb-1">
                <label for="jml_pendapatan_e" class="col-form-label s-12 col-md-4">Pendapatan</label>
                <input type="text" name="jml_pendapatan_e" id="jml_pendapatan_e" placeholder=""
                    class="form-control  r-0 s-12 col-md-6" autocomplete="off" />
            </div>
        </div>
    </div>
</div>
