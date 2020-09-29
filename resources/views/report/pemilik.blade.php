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
                                        <select name="pegawai_id" id="pegawai_id" placeholder="Semua"
                                            class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                            autocomplete="off">
                                            <option value="99">Pemilik : Semua</option>
                                            @foreach ($pegawai as $item)
                                            <option value="{{ $item->id }}">{{ $item->n_pegawai }}</option>
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
                        <a id="btn_report" class="btn btn-primary">
                            <span id="btn_report_text">Laporan</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="report-table" class="table table-striped no-b" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th width="150">Pemilik</th>
                                    <th>Jumlah Aset</th>
                                    <th>Total Pendapatan</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                </tfoot>
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
            url: "{{ route('report.pemilik.api')}}",
            method: 'GET',
            data: function (data) {
                data.pegawai_id = $('#pegawai_id').val();
            },
        },
        columns: [
            {
            data: 'id',
            name: 'id',
            orderable: false,
            searchable: false,
            className: 'text-center',
            },
            {
                data: 'n_pegawai',
                name: 'n_pegawai'
            },
            {
                data: 'jml_aset',
                name: 'jml_aset'
            },
            {
                data: 'ttl_pendapatan',
                name: 'ttl_pendapatan'
            }
         ],
        drawCallback: function () {
                var api = this.api(),
                    data;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                // Total over all pages
                total = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var number_string = total.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                // Update footer
                $(api.column(3).footer()).html(rupiah);
        }
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#report-table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    $('#pegawai_id').change(function(){
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
        $('#pegawai_id').val('99').change();
        table.api().draw();
    }

    $('#btn_report').on('click', function (e) {
        $('#btn_report_text').html('Tunggu sebentar ...');
        $.ajax({
            url: "{{ route('report.pemilik.exportPdf') }}",
            method: 'GET',
            data: {
                pegawai_id: $('#pegawai_id').val(),
            },
            success: function (data) {
                $('#btn_report_text').html('Laporan');
                window.open(data,'_blank');
            },
            error: function () {
                console.log('error');
            }
        }).done(function(){
            console.log('done');
        });
    })

</script>
@endsection
