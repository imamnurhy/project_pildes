@extends('layouts.app')

@section('title', 'Master Pendapatan')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon-notebook-list"></i> Pendapatan
                    </h3>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.masuk.create')}}"><i class="icon icon-plus">
                            </i>Tambah Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card">
            <div class="formFilter">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1 pr-0">
                            <div class="mt-1">
                                <strong><i class="icon-filter"></i> FILTER</strong>
                            </div>
                        </div>
                        <div class="col-md-2 pr-0">
                            <div class="bg-light" width="100%">
                                <select name="id_jenis_aset" id="id_jenis_aset" placeholder="Semua"
                                    class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                    autocomplete="off" onchange="getRincian()">
                                    <option value="99">Aset : Semua</option>
                                    @foreach ($tmjenis_asets as $tmjenis_aset)
                                    <option value="{{ $tmjenis_aset->id }}">{{ $tmjenis_aset->n_jenis_aset }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 pr-0">
                            <div class="bg-light p-0" width="100%">
                                <select name="id_rincian_jenis_asset" id="id_rincian_jenis_asset" placeholder=""
                                    class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                    autocomplete="off">
                                    <option value="">Jenis Aset</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <a class="btn btn-sm" id="btnFilter" title="Reset Filter" style="display:none"
                                onclick="filterReset()">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a id="laporan" class="btn btn-primary" target="_blank">Laporan</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="asetmasuk-table" class="table table-striped no-b" style="width:100%">
                        <thead>
                            <th width="30">No</th>
                            <th>Tanggal</th>
                            <th>Aset</th>
                            <th>Jenis Aset</th>
                            <th>Nilai</th>
                            <th>Tahun</th>
                            <th width="40">Detail</th>
                            <th width="40"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script src="{{ asset('assets/js/_datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/_datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/_datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/_datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/_datatables/buttons.html5.min.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

var table = $('#asetmasuk-table').dataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [1, 'desc'],
    ajax: {
        url: "{{ route('aset.masuk.api')}}",
        method: 'POST',
        data: function(data){
            data.id_jenis_aset = $('#id_jenis_aset').val();
            data.id_rincian_jenis_aset = $('#id_rincian_jenis_asset').val();
            data.status = $('#status').val();
            data.id_dokumen = $('#id_dokumen').val();
        }
    },
    columns: [
        {
            data: 'id',
            name: 'id',
            orderable: false,
            searchable: false,
            className: 'text-center'
        },
        {
            data: 'date',
            name: 'date',
        },
        {
            data: 'n_jenis_aset',
            name: 'n_jenis_aset',
            searchable: false,
        },
        {
            data: 'n_rincian',
            name: 'n_rincian',
            searchable: false,
        },
        {
            data: 'nilai',
            name: 'nilai',
        },
        {
            data: 'tahun',
            name: 'tahun',
        },
        {
            data: 'detail',
            name: 'detail',
            orderable: false,
            searchable: false,
            className: 'text-center'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'text-center'
        }
    ]
});

table.on('draw.dt', function () {
    var PageInfo = $('#asetmasuk-table').DataTable().page.info();
    table.api().column(0, {
        page: 'current'
    }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });
});

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
                        url: "{{ route('aset.masuk.destroy', ':id') }}".replace(':id', id),
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        success: function (data) {
                        table.api().ajax.reload();
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

$('#id_jenis_aset, #id_rincian_jenis_asset').on("select2:select", function(){ filter(); });

   function filter(){
        if($('#id_jenis_aset').val() == '99'){
            $('.formFilter').removeClass('active');
            $('#btnFilter').hide();
        }else{
            $('.formFilter').addClass('active');
            $('#btnFilter').show();
        }
        table.api().draw();
    }

    function filterReset(){
        $('#id_jenis_aset').val('99');
        $('#id_jenis_aset').trigger('change.select2');
        filter();
        }

    function getRincian(id) {
        $('#id_rincian_jenis_asset').html("<option value=''>Loading...</option>");
        url = "{{ route('aset.masuk.getRincian', ':id') }}".replace(':id', $('#id_jenis_aset').val());

        // Disable button action when prosess getMerek
        $('#action').attr('disabled', true);
        $.get(url, function (data) {
            option = "<option value=''>Pilih</option>";
            $.each(data, function (index, value) {
                option += "<option value='" + value.id + "'>" + value.n_rincian + "</li>";
            });
            $('#id_rincian_jenis_asset').html(option);
        }, 'JSON').done(function () {
            $('#id_rincian_jenis_asset').val(id).trigger('change');

            // Enable button action when success getMerek
            $('#action').removeAttr('disabled', true);
        });
    }



    $(document).ready(function () {
    $('#laporan').on('click', function (e) {
        var $this = $(this);
        $.ajax({
            url: "{{ route('aset.masuk.laporan') }}",
            async: false,
            success: function (url) {
                $this.attr("href", url);
                $this.attr("target", "_blank");
            },
            error: function () {
                e.preventDefault();
            }
        });
    })

})


</script>
@endsection
