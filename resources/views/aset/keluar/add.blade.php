@extends('layouts.app')

@section('title', 'Tambah Aset Keluar')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4>
                        <i class="icon icon-notebook-list"></i> Tambah Aset Keluar
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" id="v-pegawai-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.keluar.index') }}">
                            <i class="icon icon-arrow_back"></i>SemuaData
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        <form class="needs-validation" method="POST" id="form" novalidate>
            @csrf
            @method('POST')
            <input type="hidden" id="id" name="id" />

            <div class="card no-b  no-r">
                <div class="card-body">
                    <h5 class="card-title" id="formTitle">Tambah Data</h5>
                    <div class="form-row form-inline">

                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label for="opd_id" class="col-form-label s-12 col-md-4">Pengguna</label>
                                <div class="col-md-8">
                                    <select name="opd_id" id="opd_id" class="form-control light select2  r-0 s-12"
                                        autocomplete="off" required>
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach($tmopds as $tmopd)
                                        <option value="{{ $tmopd->id }}">{{ $tmopd->n_lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label for="aset_id" class="col-form-label s-12 col-md-4">Aset</label>
                                <div class="col-md-8">
                                    <select name="aset_id[]" id="aset_id" class="form-control light select2 r-0 s-12"
                                        multiple autocomplete="off" required>
                                        <option value="" disabled>Pilih Asset</option>
                                        @foreach($tmmaster_assets as $tmmaster_asset)
                                        <option value="{{ $tmmaster_asset->id }}">
                                            {{ $tmmaster_asset->n_jenis_aset . '-' . $tmmaster_asset->n_merk . '-' . $tmmaster_asset->tahun  }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group m-0">
                                <label for="foto" class="col-form-label s-12 col-md-4">Foto</label>
                                <div class="col-md-6">
                                    <input type="file" name="foto" id="foto" placeholder=""
                                        class="form-control r-0 light s-12 " autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label for="ket" class="col-form-label s-12 col-md-4">Keterangan</label>
                                <div class="col-md-6">
                                    <textarea name="ket" id="ket" class="form-control light r-0 s-12" autocomplete="off"
                                        required rows="2" cols="38">
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="card" style="width: 50%">
                                <div class="card-header">
                                    Image Priview
                                </div>
                                <div class="card-body text-center">
                                    <div id="priview_image_text" class="card-text">Gambar kamu akan muncul disini</div>
                                    <img id="priview_image" width="50%" style="border-radius: 5%" />

                                </div>
                                <div class="card-footer text-right">
                                    <a href="#modal_priview_image" rel="modal:open">
                                        <button disabled id="button_modal_priview_image" class="btn btn-primary">
                                            Priview
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                    <div class="form-row form-inline" style="align-items: baseline">
                        <div class="col-md-12">
                            <div class="card-body offset-md-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="action" title="Simpan data">
                                    <i class="icon-save mr-2"></i>Simpan<span id="txtAction"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal HTML embedded directly into document -->
    {{-- <div id="modal_priview_image" class="modal" style="overflow: initial">
        <img id="priview_image2" width="100%" style="border-radius: 5%" />
    </div> --}}
</div>


@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

<script type="text/javascript">
    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            $.ajax({
                    url: "{{ route('aset.keluar.store') }}",
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#action').removeAttr('disabled');
                        $('#form').trigger('reset');
                        if (data.success == 1) {
                            $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label = 'Close' > <span aria-hidden='true'>×</span></button> <strong> Success! </strong> " + data.message + "</div>");
                            document.location.href = "{{ route('aset.keluar.index') }}";
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

    //  function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //             $('#priview_image').attr('src', e.target.result);
    //             $('#priview_image2').attr('src', e.target.result);
    //             $('#priview_image_text').remove();
    //             $('#button_modal_priview_image').removeAttr('disabled', true);
    //         }
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }
    // $("#foto").change(function(){
    //     readURL(this);
    // });

</script>
@endsection
