@extends('layouts.app')

@section('title', 'Tambah Lelang')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.2/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.2/themes/explorer-fa/theme.css" media="all" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/fonts/glyphicons-halflings-regular.eot">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/fonts/glyphicons-halflings-regular.svg">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/fonts/glyphicons-halflings-regular.ttf">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/fonts/glyphicons-halflings-regular.woff">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/fonts/glyphicons-halflings-regular.woff2">

@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4>
                        <i class="icon icon-event_seat"></i> Tambah Data Lelang
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('lelang.index') }}"><i class="icon icon-arrow_back"></i>Semua Lelang</a>
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
                <input type="hidden" id="id" name="id"/>

                <div class="card no-b  no-r">
                    <div class="card-body">
                        <h5 class="card-title" id="formTitle">Tambah Data</h5>
                        <div class="form-row form-inline" style="align-items: baseline">
                            <div class="col-md-12">
                                <div class="form-group m-0">
                                    <label for="n_lelang" class="col-form-label s-12 col-md-2">Nama</label>
                                    <input type="text" name="n_lelang" id="n_lelang" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0">
                                    <label for="d_dari" class="col-form-label s-12 col-md-2">Periode</label>
                                    <input type="text" name="d_dari" id="d_dari" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" required/>

                                    <label for="d_sampai" class="col-form-label s-12 col-md-1">s/d</label>
                                    <input type="text" name="d_sampai" id="d_sampai" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0">
                                        <label for="nilai_sewa" class="col-form-label s-12 col-md-2">Nilai Sewa</label>
                                        <input type="number" name="nilai_sewa" id="nilai_sewa" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                 </div>
                                 <div class="form-group m-0">
                                        <label for="jumlah_mobil" class="col-form-label s-12 col-md-2">Jumlah Mobil</label>
                                        <input type="number" name="jumlah_mobil" id="jumlah_mobil" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0">
                                        <label for="jumlah_motor" class="col-form-label s-12 col-md-2">Jumlah Motor</label>
                                        <input type="number" name="jumlah_motor" id="jumlah_motor" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0">
                                        <label for="luas_lahan" class="col-form-label s-12 col-md-2">luas Lahan</label>
                                        <input type="number" name="luas_lahan" id="luas_lahan" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                </div>
                                <div class="form-group m-0">
                                        <label for="alamat" class="col-form-label s-12 col-md-2">Alamat</label>
                                        <input type="text" name="alamat" id="alamat" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required/>
                                    </div>
                                <div class="form-group m-0">
                                    <label for="foto" class="col-form-label s-12 col-md-2">Foto</label>
                                    <input type="file" name="foto[]" id="file-upload-demo" placeholder="" class="form-control light r-0 s-12 col-md-8" autocomplete="off" required multiple />
                                    {{-- <input id="file-upload-demo" type="file" multiple><br />
                                    <button type="submit" class="btn btn-success">Upload Files</button>
                                    <button type="reset" class="btn btn-warning">Reset</button> --}}
                                </div>

                                <div class="form-group m-0">
                                        <label for="foto" class="col-form-label s-12 col-md-2" ></label>
                                    <div id="image-holder" class="r-0 s-12 col-md-8"> </div>
                                </div>

                                <div class="form-group m-0 mb-1">
                                    <label for="ket" class="col-form-label s-12 col-md-2">Keterangan</label>
                                </div>
                                <div class="form-group m-2" style="align-items:flex-start">
                                    <div class="col-md-12 card-body border no-p">
                                        <textarea name="ket" id="ket" placeholder="" class="form-control r-0 s-12 editor" style="width:100%" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group m-0">
                                    <label for="c_status" class="col-form-label s-12 col-md-2">Status</label>
                                    <select name="c_status" id="c_status" placeholder="" class="form-control r-0 light s-12 col-md-2" required>
                                        <option value="">Pilih</option>
                                        <option value="1">Tampil</option>
                                        <option value="0">Tidak Tampil</option>
                                    </select>
                                </div>
                                <div class="card-body offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data"><i class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.2/js/plugins/sortable.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.2/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.2/themes/explorer/theme.js" type="text/javascript"></script>

<script type="text/javascript">
    $('#menuLelang').addClass('active');
    $('.select2').addClass('light');

        $("#file-upload-demo").fileinput({
            'theme': 'explorer',
            'uploadUrl': '#',
            overwriteInitial: false,
            initialPreviewAsData: true,
        });

            $('.glyphicon-trash').addClass('icon icon-package blue-text s-18');


    $('#d_dari').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
            maxDate:$('#d_sampai').val()?$('#d_sampai').val():false
        })
        },
        timepicker:false
    });

    $('#d_sampai').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
            minDate:$('#d_dari').val()?$('#d_dari').val():false
        })
        },
        timepicker:false
    });

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
        $.ajax({
            url: "{{ route('lelang.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data);
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

                $('#fileFoto').html(data.foto);

                $('#ket').trumbowyg('html', data.ket);
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
