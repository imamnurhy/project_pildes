<div class="card">
    <div class="card-header white">
        <i class="icon-clipboard-edit blue-text"></i>
        <strong id="formTitle"> Tambah Detail Tanah </strong>
    </div>
    <div class="card-body no-b">
        <form class="needs-validation" id="form" method="POST">
            <div class="card-body">
                <strong class="card-title">Edit Detail Tanah</strong>
                <hr>
                @csrf
                <input type="hidden" name="id_master_aset" value="{{ $tmmaster_asset->tmmaster_asset_id }}" />
                <input type="hidden" name="id_jenis_tanah" value="{{ $tmmaster_asset->tmjenis_asets_id }}" />
                <input type="hidden" name="nm_pemilik_sebelum" value="{{ $tmmaster_asset->pemilik_sebelumnya }}" />
                <input type="hidden" name="form_edit" value="{{ $formEdit }}" />

                <div class="form-inline row">
                    <div class="col-md-6">
                        <div class="form-group m-0 col-md-12">
                            <label for="nm_lahan" class="col-form-label s-12 col-md-4">Nama Lahan</label>
                            <input type="text" name="nm_lahan" id="nm_lahan"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off"
                                value="{{ $data ? $data->nm_lahan : '' }}" required />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="luas" class="col-form-label s-12 col-md-4">Luas</label>
                            <input type="text" name="luas" id="luas" value="{{ $data ? $data->luas : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="alamat" class="col-form-label s-12 col-md-4">Alamat</label>
                            <input type="text" name="alamat" id="alamat" value="{{ $data ? $data->alamat : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="batas_barat" class="col-form-label s-12 col-md-4">Batas Barat</label>
                            <input type="text" name="batas_barat" id="batas_barat"
                                value="{{ $data ? $data->batas_barat : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="batas_timur" class="col-form-label s-12 col-md-4">Batas Timur</label>
                            <input type="text" name="batas_timur" id="batas_timur"
                                value="{{ $data ? $data->batas_timur : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="batas_selatan" class="col-form-label s-12 col-md-4">Batas Selatan</label>
                            <input type="text" name="batas_selatan" id="batas_selatan"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off"
                                value="{{ $data ? $data->batas_selatan : '' }}" required />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="batas_utara" class="col-form-label s-12 col-md-4">Batas Utara</label>
                            <input type="text" name="batas_utara" id="batas_utara"
                                value="{{ $data ? $data->batas_utara : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="latitude" class="col-form-label s-12 col-md-4">Latitude</label>
                            <input type="text" name="latitude" id="latitude" value="{{ $data ? $data->latitude : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group m-0 col-md-12">
                            <label for="longitude" class="col-form-label s-12 col-md-4">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                value="{{ $data ? $data->longitude : '' }}" class="form-control light r-0 s-12 col-md-6"
                                autocomplete="off" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="provinsi_id" class="col-form-label s-12 col-md-4">Provinsi</label>
                            <select name="provinsi_id" id="provinsi_id" placeholder=""
                                class="form-control r-0 light s-12 col-md-6" onchange="getKabupaten()">
                                <option value="">Pilih</option>
                                @foreach($provinsis as $key=>$provinsi)
                                <option value="{{ $provinsi->id }}">{{ $provinsi->n_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="kabupaten_id" class="col-form-label s-12 col-md-4">Kota</label>
                            <select name="kota_id" id="kabupaten_id" placeholder=""
                                class="form-control r-0 light s-12 col-md-6" onchange="getKecamatan()">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="kecamatan_id" class="col-form-label s-12 col-md-4">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" placeholder=""
                                class="form-control r-0 light s-12 col-md-6" onchange="getKelurahan()">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="kelurahan_id" class="col-form-label s-12 col-md-4">Kelurahan</label>
                            <select name="kelurahan_id" id="kelurahan_id" placeholder=""
                                class="form-control r-0 light s-12 col-md-6">
                                <option value="">Pilih</option>
                            </select>
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="luas_tanah" class="col-form-label s-12 col-md-4">Luah Tanah</label>
                            <input type="text" name="luas_tanah" id="luas_tanah"
                                value="{{ $data ? $data->luas_tanah : '' }}"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" required
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="tanda_bukti" class="col-form-label s-12 col-md-4">Tanda Bukti</label>
                            @if ($data)
                            <input type="hidden" name="tanda_bukti_db" value="{{$data->tanda_bukti}}">
                            <a class="col-md-6" target="_blank"
                                href="{{route('aset.masuk.download_berkas',$data->tanda_bukti) }}">Lihat File</a><br>
                            @endif

                            <input type="file" name="tanda_bukti" id="tanda_bukti"
                                class="form-control light r-0 s-12  col-md-6" autocomplete="off" />

                        </div>

                        <div class="form-group m-0 col-md-12">
                            <label for="file_bukti_beli" class="col-form-label s-12 col-md-4">Bukti Beli</label>
                            @if ($data)
                            <input type="hidden" name="file_bukti_beli_db" value="{{$data->file_bukti_beli}}">
                            <a class="col-md-6" target="_blank" href="{{
                    route('aset.masuk.download_berkas',$data->file_bukti_beli)}}">Lihat File</a><br>
                            @endif
                            <input type="file" name="file_bukti_beli" id="file_bukti_beli"
                                class="form-control light r-0 s-12 col-md-6" autocomplete="off" />
                        </div>
                    </div>



                </div>
            </div>

            <div class="card-body">
                <strong class="card-title">Kelengkapan Berkas</strong>
                <hr>


                <div id="kel_ber">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="tmberkas_id" class="col-form-label s-12 col-md-12 pl-0">Jenis Sertifikat</label>
                            <select name="tmberkas_id[]" id="tmberkas_id_1" placeholder="" onchange="selectBerkasId(1)"
                                class="form-control r-0 light s-12 col-md-12">
                                <option value="">Pilih</option>
                                @foreach($tmberkas as $dtBerkas)
                                <option value="{{ $dtBerkas->id }}">{{ $dtBerkas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="no" class="col-form-label s-12 col-md-12 pl-0">No</label>
                            <input type="text" name="no_sertifikat[]" id="no_sertifikat_1" style="height:38px"
                                class="form-control light r-0 s-12 col-md-12" autocomplete="off" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="no" class="col-form-label s-12 col-md-12 pl-0">Nama Pemegang Hak</label>
                            <input type="text" name="nm_pemegang_hak[]" style="height:38px" id="nm_pemegang_hak_1"
                                class="form-control light r-0 s-12 col-md-12" autocomplete="off" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="no" class="col-form-label s-12 col-md-12 pl-0">Tanggal Berakhir Hak</label>


                            <input type="date" name="tgl_berakhir_hak[]" id="tgl_berakhir_hak_1"
                                class="form-control light r-0 s-12 col-md-12" autocomplete="off" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="no" class="col-form-label s-12 col-md-12 pl-0">NIB</label>
                            <input type="text" name="nib[]" id="nib_1" style="height:38px"
                                class="form-control light r-0 s-12 col-md-12" autocomplete="off" />
                        </div>

                        <div class="form-group m-0 col-md-2">
                            <label for="berkas" class="col-form-label s-12 col-md-12">Berkas</label>
                            <input type="file" name="berkas[]" id="berkas_1"
                                class="form-control light r-0 s-12 col-md-12" autocomplete="off" />
                        </div>

                        <div class="form-group col-md-1">
                            <label for=""></label>
                            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrm" style="" id="addBtn1"
                                onclick="addForm();"><i class="icon-plus"></i></a>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm float-right" id="action"
                            title="Simpan data"><i class="icon-save mr-2"></i>
                            Simpan
                        </button>
                    </div>

                </div>




            </div>



            <div class="card-body">
                <table class="table table-bordered" id="berkas-table">
                    <thead>
                        <tr>
                            <th width="25%">Jenis Sertifikat</th>
                            <th width="10%">No</th>
                            <th width="25%">Nama Pemegang Hak</th>
                            <th width="10%">Tanggal Berakhir Hak</th>
                            <th width="25%">NIB</th>
                            <th width="25%">File</th>
                            <th width="25%"></th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($tbl_berkas as $i)

                        <tr>
                            <td>{{$i->tmberkas->nama}}</td>
                            <td>{{$i->no_sertifikat}}</td>
                            <td>{{$i->nm_pemegang_hak}}</td>
                            <td>{{$i->tgl_berakhir_hak->format('d-m-Y')}}</td>
                            <td>{{$i->nib}}</td>
                            <td><a href="{{ route('aset.masuk.download_berkas',$i->berkas)}}">Download</a></td>
                            <td class="text-center"><a href='#' onclick='remove({{$i->id}})' class='text-danger'
                                    title='Hapus Berkas'><i class='icon-remove'></i></a></td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>


        </form>
    </div>
</div>

@section('script_incl')
<script>
    var table = $('#berkas-table').dataTable({})

   var kel_ber = 1;
    var kota_id,kecamatan_id,kelurahan_id;
    @if($data)

    $('#provinsi_id').val({{$data->provinsi_id}});
    var kota_id = {{$data ? $data->kota_id : ''}};
    var kecamatan_id = {{$data ? $data->kecamatan_id :''}};
    var kelurahan_id = {{$data ? $data->kelurahan_id :''}};


    $('#tanda_bukti').addClass("offset-md-4");
    $('#file_bukti_beli').addClass("offset-md-4");
    $('#tanda_bukti').prop("required",false);
    $('#file_bukti_beli').prop("required",false);
    getKabupaten();



    @endif
     function getKabupaten() {
        val = $('#provinsi_id').val();
        option = " <option value=''> Pilih </option>";
        if (val == "") {
            $('#kabupaten_id').html(option);
        } else {
            $('#kabupaten_id').html("<option value=''>Loading...</option>");
            url = "{{ route('aset.masuk.getKabupaten', ':id') }}".replace(':id', val);
            $.get(url, function (data) {
                $.each(data, function (index, value) {
                    option += "<option value='" + value.id + "'>" + value.n_kabupaten + "</li>";
                });
                $('#kabupaten_id').html(option);

                if(kota_id != '') {
                    $('#kabupaten_id').val(kota_id);
                    getKecamatan()

                }
            }, 'JSON');
        }
    }

    function getKecamatan(id) {
        val = $('#kabupaten_id').val();
        option = " <option value=''> Pilih </option>";
        if (val == "") {
            $('#kecamatan_id').html(option);
        } else {
            $('#kecamatan_id').html("<option value=''>Loading...</option>");
            url = "{{ route('aset.masuk.getKecamatan', ':id') }}".replace(':id', val);
            $.get(url, function (data) {
                $.each(data, function (index, value) {
                    option += "<option value='" + value.id + "'>" + value.n_kecamatan + "</li>";
                });
                $('#kecamatan_id').html(option);
                if(kecamatan_id != '') {
                    $('#kecamatan_id').val(kecamatan_id);
                    getKelurahan()

                }
            }, 'JSON');
        }
    }

    function getKelurahan() {
        val = $('#kecamatan_id').val();
        option = "<option value=''>Pilih </option>";
        if (val == "") {
            $('#kelurahan_id').html(option);
        } else {
            $('#kelurahan_id').html("<option value=''>Loading...</option>");
            url = "{{ route('aset.masuk.getKelurahan', ':id') }}".replace(':id', val);
            $.get(url, function (data) {
                $.each(data, function (index, value) {
                    option += "<option value='" + value.id + "'>" + value.n_kelurahan + "</li>";
                });
                $('#kelurahan_id').html(option);

                if(kelurahan_id != '') {
                    $('#kelurahan_id').val(kelurahan_id);

                }
            }, 'JSON');
        }
    }

    function addForm(){
        $('.addBtnFrm').hide();

        kel_ber++;

        html = `<div class="form-row" id="frm`+kel_ber+`" >

            <div class="form-group col-md-3">
                    <label for="tmberkas_id" class="col-form-label s-12 col-md-12 pl-0">Jenis Sertifikat</label>
                        <select name="tmberkas_id[]" id="tmberkas_id_`+kel_ber+`" placeholder="" onchange="selectBerkasId(`+kel_ber+`)"
                            class="form-control r-0 light s-12 col-md-12">
                            <option value="">Pilih</option>
                            @foreach($tmberkas as $dtBerkas)
                            <option value="{{ $dtBerkas->id }}">{{ $dtBerkas->nama }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group col-md-1">
                    <label for="no" class="col-form-label s-12 col-md-12 pl-0">No</label>
                    <input type="text" name="no_sertifikat[]" id="no_sertifikat_`+kel_ber+`" style="height:38px" class="form-control light r-0 s-12 col-md-12"
                    autocomplete="off"  />
                </div>
                <div class="form-group col-md-2">
                    <label for="no" class="col-form-label s-12 col-md-12 pl-0">Nama Pemegang Hak</label>
                    <input type="text" name="nm_pemegang_hak[]" style="height:38px" id="nm_pemegang_hak_`+kel_ber+`" class="form-control light r-0 s-12 col-md-12"
                    autocomplete="off"  />
                </div>
                <div class="form-group col-md-2">
                    <label for="no" class="col-form-label s-12 col-md-12 pl-0">Tanggal Berakhir Hak</label>
                    <input type="date" name="tgl_berakhir_hak[]" style="height:38px" id="tgl_berakhir_hak_`+kel_ber+`" class="form-control light r-0 s-12 col-md-12"
                    autocomplete="off"  />
                </div>
                <div class="form-group col-md-2">
                    <label for="no" class="col-form-label s-12 col-md-12 pl-0">NIB</label>
                    <input type="text" name="nib[]" id="nib_`+kel_ber+`" style="height:38px" class="form-control light r-0 s-12 col-md-12"
                    autocomplete="off"  />
                </div>

                <div class="form-group m-0 col-md-2">
                    <label for="berkas" class="col-form-label s-12 col-md-12">Berkas</label>
                    <input type="file" name="berkas[]" id="berkas_`+kel_ber+`"
                        class="form-control light r-0 s-12 col-md-12" autocomplete="off"  />
                </div>



                    <div class="form-group col-md-1">
                        <label for=""></label>
                            <a class="btn-fab btn-fab-sm shadow btn-danger" style=""  onclick="deleteForm(`+kel_ber+`);"><i class="icon-minus"></i></a>
                            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrm" style="" id="addBtn`+kel_ber+`" onclick="addForm();"><i class="icon-plus"></i></a>
                    </div>

                </div>`
        $('#kel_ber').append(html);

        $('.addBtnFrm').last().show();


    }


    function deleteForm(id){


   $('.addBtnFrm').hide();

   $('#frm'+id).remove();
   $('.addBtnFrm').last().show();
}

function selectBerkasId(id){
    tmberkas_id = $('#tmberkas_id_'+id).val();
    if(tmberkas_id != ''){
    $('#no_sertifikat_'+id).prop('required',true);
    $('#nm_pemegang_hak_'+id).prop('required',true);
    $('#tgl_berakhir_hak_'+id).prop('required',true);
    $('#nib_'+id).prop('required',true);
    $('#berkas_'+id).prop('required',true);

    }else{
        $('#no_sertifikat_'+id).prop('required',false);
    $('#nm_pemegang_hak_'+id).prop('required',false);
    $('#tgl_berakhir_hak_'+id).prop('required',false);
    $('#nib_'+id).prop('required',false);
    $('#berkas_'+id).prop('required',false);
    }
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
                        url: "{{ route('aset.masuk.hapusBerkas', ':id') }}".replace(':id', id),
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        success: function (data) {
                        location.reload();
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
