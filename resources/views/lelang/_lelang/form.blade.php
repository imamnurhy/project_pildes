@extends('layouts.app')

@section('title', 'Tambah Data')

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
                        <i class="icon icon-event_seat"></i> Tambah Data Lahan
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('lelang.index') }}"><i class="icon icon-arrow_back"></i>Semua
                            Data Lahan</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        <form class="needs-validation" id="form" method="POST" novalidate enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" id="id" name="id" />

            <div class="card no-b  no-r">
                <div class="card-body">
                    <h5 class="card-title" id="formTitle">Tambah Data</h5>
                    <div class="form-row form-inline" style="align-items: baseline">
                        <div class="col-md-12">

                            {{-- Form Input OPD --}}
                            {{-- <div class="form-group mb-1">
                                    <div class="col-md-2">
                                        <label for="opd_id" class="col-form-label s-12">OPD</label>
                                    </div>
                                    <div class="col-md-8 no-p">
                                        <select name="opd_id" id="opd_id" placeholder="" class="form-control r-0 light s-12 select2" required>
                                            <option value="">Pilih</option>
                                            @foreach($opds as $key=>$opd)
                                            <option value="{{ $opd->id }}">{{ $opd->n_opd }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div class="form-group m-0">
                        <label for="n_lelang" class="col-form-label s-12 col-md-2">Nama</label>
                        <input type="text" name="n_lelang" id="n_lelang" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="d_dari" class="col-form-label s-12 col-md-2">Periode</label>
                        <input type="text" name="d_dari" id="d_dari" placeholder=""
                            class="form-control r-0 light s-12 col-md-2" autocomplete="off" required />

                        <label for="d_sampai" class="col-form-label s-12 col-md-1">s/d</label>
                        <input type="text" name="d_sampai" id="d_sampai" placeholder=""
                            class="form-control r-0 light s-12 col-md-2" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="nilai_sewa" class="col-form-label s-12 col-md-2">Nilai Sewa</label>
                        <input type="text" name="nilai_sewa" id="nilai_sewa" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="jumlah_mobil" class="col-form-label s-12 col-md-2">Jumlah SRP</label>
                        <input type="number" name="jumlah_mobil" id="jumlah_mobil" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="jumlah_motor" class="col-form-label s-12 col-md-2">Jumlah Motor</label>
                        <input type="number" name="jumlah_motor" id="jumlah_motor" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="luas_lahan" class="col-form-label s-12 col-md-2">luas Lahan</label>
                        <input type="text" name="luas_lahan" id="luas_lahan" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="alamat" class="col-form-label s-12 col-md-2">Alamat</label>
                        <input type="text" name="alamat" id="alamat" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label for="foto" class="col-form-label s-12 col-md-2">Foto</label>
                        <input type="file" name="foto" id="fileUpload" placeholder=""
                            class="form-control light r-0 s-12 col-md-8" autocomplete="off" required />
                    </div>
                    <div class="form-group m-0">
                        <label class="col-form-label s-12 col-md-2"></label>
                        <div class="r-0 s-12 col-md-8"> <span hidden id="span" style="color:#00f60f; font-size:12px">
                                <li id="li"></li>
                            </span> </div>
                    </div>
                    <div class="form-group m-0">
                        <label for="foto" class="col-form-label s-12 col-md-2"></label>
                        <div id="image-holder" class="r-0 s-12 col-md-8"> </div>
                    </div>
                    <br>
                    <div class="form-group m-0">
                        <label for="d_pengumuman_dari" class="col-form-label s-12 col-md-2">Pengumuman</label>
                        <input type="text" name="d_pengumuman_dari" id="d_pengumuman_dari" placeholder=""
                            class="form-control r-0 light s-12 col-md-2" autocomplete="off" required />

                        <label for="d_pengumuman_sampai" class="col-form-label s-12 col-md-1">s/d</label>
                        <input type="text" name="d_pengumuman_sampai" id="d_pengumuman_sampai" placeholder=""
                            class="form-control r-0 light s-12 col-md-2" autocomplete="off" required />
                    </div>

                    <div class="form-group m-0 mb-1">
                        <label for="ket" class="col-form-label s-12 col-md-2">Keterangan</label>
                    </div>
                    <div class="form-group m-2" style="align-items:flex-start">
                        <div class="col-md-12 card-body border no-p">
                            <textarea name="ket" id="ket" placeholder="" class="form-control r-0 s-12 editor"
                                style="width:100%" required></textarea>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label for="c_status" class="col-form-label s-12 col-md-2">Status</label>
                        <select name="c_status" id="c_status" placeholder=""
                            class="form-control r-0 light s-12 col-md-2" required>
                            <option value="">Pilih</option>
                            <option value="1">Tampil</option>
                            <option value="0">Tidak Tampil</option>
                        </select>
                    </div>
                    <div class="card-body offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i
                                class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                        <a class="btn btn-sm" onclick="add()" id="reset" title="Reset inputan">Reset</a>
                    </div>
                </div>
            </div>
    </div>
</div>
</form>
</div>
</div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    $('#menuLelang').addClass('active');
    $('.select2').addClass('light');

    $('#d_dari').datetimepicker({
        format:'Y-m-d H:i',
        onShow:function( ct ){
        this.setOptions({
            maxDate:$('#d_sampai').val()?$('#d_sampai').val():false
        })
        },
        timepicker:true
    });

    $('#d_sampai').datetimepicker({
        format:'Y-m-d H:i',
        onShow:function( ct ){
        this.setOptions({
            minDate:$('#d_dari').val()?$('#d_dari').val():false
        })
        },
        timepicker:true
    });

    $('#d_pengumuman_dari').datetimepicker({
        format:'Y-m-d H:i',
        onShow:function( ct ){
        this.setOptions({
            maxDate:$('#d_pengumuman_sampai').val()?$('#d_pengumuman_sampai').val():false
        })
        },
        timepicker:false
    });

    $('#d_pengumuman_sampai').datetimepicker({
        format:'Y-m-d H:i',
        onShow:function( ct ){
        this.setOptions({
            minDate:$('#d_pengumuman_dari').val()?$('#d_pengumuman_dari').val():false
        })
        },
        timepicker:false
    });

    var rupiah = document.getElementById('nilai_sewa');
		rupiah.addEventListener('keyup', function(e){
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah.value = formatRupiah(this.value);
		});

    var rupiah2 = document.getElementById('luas_lahan');
		rupiah2.addEventListener('keyup', function(e){
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah2.value = formatRupiah(this.value);
		});

		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
            }


			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

    {{ $id == 0 ? 'add()' : 'edit('.$id.')' }}
    function add(){
        save_method = 'add';
        $('#form').trigger('reset');
        $('#opd_id').focus();
    }

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#formTitle').html("Mohon tunggu beberapa saat...");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('#form input[name=_method]').val('PATCH');
        $('#fileUpload').removeAttr('required', true);
        $('#span').removeAttr('hidden');
        $('#li').html('Abaikan Bila Tidak Ingin Mengganti.')
        $.ajax({
            url: "{{ route('lelang.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#formTitle').html("Edit Data");
                $('#form').show();
                $('#id').val(data.id);
                $('#opd_id').val(data.opd_id).trigger('change');
                $('#n_lelang').val(data.n_lelang).focus();
                $('#d_dari').val(data.d_dari);
                $('#d_sampai').val(data.d_sampai);
                $('#nilai_sewa').val(data.nilai_sewa);
                $('#jumlah_mobil').val(data.jumlah_mobil);
                $('#jumlah_motor').val(data.jumlah_motor);
                $('#luas_lahan').val(data.luas_lahan);
                $('#alamat').val(data.alamat);
                $('#c_status').val(data.c_status);
                // $('#fileUpload').val(data.foto);
                $('#ket').trumbowyg('html', data.ket);
                $('#d_pengumuman_dari').val(data.d_pengumuman_dari);
                $('#d_pengumuman_sampai').val(data.d_pengumuman_sampai);
            },
            error : function() {
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
                            action: function(){
                                document.location.href = "{{ route('lelang.index') }}";
                            }
                        }
                    }
                });
            }
        })
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);;
            if (save_method == 'add'){
                url = "{{ route('lelang.store') }}";
            }else{
                url = "{{ route('lelang.update', ':id') }}".replace(':id', $('#id').val());
            }
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action').removeAttr('disabled');
                    if(data.success == 1){
                        $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                        document.location.href = "{{ route('lelang.index') }}"
                    }
                },
                error : function(data){
                    $('#action').removeAttr('disabled');
                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function( index, value ) {
                        err = err + "<li>" + value +"</li>";
                    });

                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            });
            return false;
        }
        $(this).addClass('was-validated');
    });


    $("#fileUpload").on('change', function () {

        if (typeof (FileReader) != "undefined") {

            var image_holder = $("#image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                }).appendTo(image_holder);

            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
        });
</script>
@endsection
