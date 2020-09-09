@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        Permohonan
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.masuk.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="column container-fluid my-3 m-0">
        <div id="alert"></div>
        <div class="col-md-12 mb-1">
            <div class="card">
                <div class="card-body no-b">
                    <div class="col-md-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong class="s-12">Aset</strong>
                                <span class="s-12 float-right">{{ $tmmaster_asset->n_jenis_aset }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jenis Aset</strong>
                                <span class="s-12 float-right">{{ $tmmaster_asset->n_merk }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body no-b">

                    @if ($formEdit == 1)
                    @include('aset.masuk.form_tanah')
                    @else
                    @include('aset.masuk.form_barang')
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $('#alert').html('');
            $('#action').attr('disabled', true);
            $.ajax({
                    url: "{{ route('aset.masuk.storeDetailTanah') }}",
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

   
</script>

@yield('script_incl')
@endsection
