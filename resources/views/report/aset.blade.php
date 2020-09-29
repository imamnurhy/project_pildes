@extends('layouts.app')

@section('title', 'Report')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-notebook-list"></i> Report Pendapatan Aset
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="row">

            <div class="col-md-12">
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
                                        <select name="tmjenis_aset_id" id="tmjenis_aset_id" placeholder="Semua"
                                            class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                            autocomplete="off">
                                            <option value="99">Jenis Aset : Semua</option>
                                            @foreach ($tmJenisAsets as $item)
                                            <option value="{{ $item->id }}">{{ $item->n_jenis_aset }}</option>
                                            @endforeach
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
                        <div class="table-responsive">
                            <table id="report-table" class="table table-striped no-b" style="width:100%">
                                <thead>
                                    <th width="10">No</th>
                                    <th>Jenis Aset</th>
                                    <th>Jumlah Aset</th>
                                    <th>Total Pendapatan</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
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
    var table = $('#report-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('report.aset.api')}}",
            method: 'GET',
            data: function (data) {
                data.tmjenis_aset_id = $('#tmjenis_aset_id').val();
            },
        },
        dom: 'Bfrtip',
        buttons: ['excelHtml5' , 'pdfHtml5'],
        columns: [
            {
            data: 'id',
            name: 'id',
            orderable: false,
            searchable: false,
            className: 'text-center',
            },
            {
                data: 'tm_jenis_aset.n_jenis_aset',
                name: 'tm_jenis_aset.n_jenis_aset',
                width: '50%'
            },
            {
                data: 'jml_aset',
                name: 'jml_aset',
                width: '25%'
            },
            {
                data: 'ttl_pendapatan',
                name: 'ttl_pendapatan',
                width: '25%'
            }
         ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#report-table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    $('#tmjenis_aset_id').change(function(){
        if ($(this).val() == '99') {
            $('.formFilter').removeClass('active');
            $('#btnFilter').hide();
        } else {
            $('.formFilter').addClass('active');
            $('#btnFilter').show();
        }
        table.api().draw();
    });

    function filterReset() {
        $('#tmjenis_aset_id').val('99').change();
        table.api().draw();
    }

    function getAsetRincian(id) {
        option = "<option value='99'>Rincian Aset : semua</li>";
        $('#tmjenis_aset_rincian_id').html("<option value=''>Loading...</option>");
        url = "{{ route('report.getAsetRincian', ':id') }}".replace(':id', $('#tmjenis_aset_id').val());
        $.get(url, function (data) {
            $.each(data, function (index, value) {
                option += "<option value='" + value.id + "'>" + value.n_rincian + "</li>";
            });
            $('#tmjenis_aset_rincian_id').html(option);
        }, 'JSON').done(function(){
            $('#tmjenis_aset_rincian_id').val(id);
        });
    }

</script>
@endsection
