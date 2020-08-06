<form class="needs-validation" id="form" method="POST">
    <div class="card-body">
        <strong class="card-title">Edit Detail Barang</strong>
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" id="id" />
        <div class="form-inline">
            <div class="form-group m-0 col-md-12">
                <label for="n_pegawai" class="col-form-label s-12 col-md-2"></label>
                <span class="s-12 float-right"></span>
                <input type="hidden" name="n_pegawai" value="">
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
