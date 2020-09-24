@extends('layouts.app')

@section('title', 'Report')

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
                                        <select name="pegawai_id" id="pegawai_id" placeholder="Semua"
                                            class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                            autocomplete="off">
                                            <option value="99">Aset : Semua</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <a class="btn btn-sm" id="btnFilter" title="Reset Filter"
                                        style="display:none">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped no-b" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
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

<script type="text/javascript">
    var table = $('#table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('report.aset.api')}}",
        columns: [{
            data: 'id',
            name: 'id',
            orderable: false,
            searchable: false,
            className: 'text-center'
        }, ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

</script>
@endsection
