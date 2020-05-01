@extends('layouts.app')

@section('title', 'Data Arsip Ditolak')

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
                        <i class="icon icon-ban"></i> Data Arsip Ditolak
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card no-b">
        <div class="formFilter">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1 pr-0">
                            <div class="mt-1">
                                <strong><i class="icon-filter"></i> FILTER</strong>
                            </div>
                        </div>
                        <div class="col-md-4 pr-0">
                            <div class="bg-light p-0" width="100%">
                                <select name="tmlelang_id" id="tmlelang_id" placeholder="" class="form-control r-0 light s-12 col-md-12 custom-select select2" autocomplete="off">
                                    <option value="99">Lahan Parkir Yg Dilamar : Semua</option>
                                    @foreach($tmlelangs as $row=>$tmlelang)
                                    <option value="{!! $tmlelang->id !!}">{!! $tmlelang->n_lelang !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <a class="btn btn-sm" id="btnFilter" onclick="filterReset()" title="Reset Filter" style="display:none">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-0">

            <div class="card-body">
                <div class="table-responsive">
                    <table id="panselnas-table" class="table table-striped" style="width:100%">
                        <thead>
                            <th width="30">No</th>
                            <th width="120">No Registrasi</th>
                            <th width="160">Nama</th>
                            <th width="160">Perusahaan</th>
                            <th>Lahan Parkir Yg Dilamar</th>
                            <th width="125">Nilai Usulan Sewa</th>
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

    var table = $('#panselnas-table').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        processing: true,
        serverSide: true,
        order: [ 5, 'DESC' ],
        ajax: {
            url: "{{ route('api.arsipTolak') }}",
            method: 'POST',
            data: function (d) {
                d.tmlelang_id = $('#tmlelang_id').val();
                d.c_tolak = $('#c_tolak').val();
            }
        },
        columns: [
            {data: 'tmregistrasi.id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'no_pendaftaran', name: 'no_pendaftaran'},
            {data: 'tmregistrasi.nama_pl', name: 'tmregistrasi.nama_pl'},
            {data: 'tmregistrasi.n_pr', name: 'tmregistrasi.n_pr'},
            {data: 'tmlelang.n_lelang', name: 'tmlelang.n_lelang'},
            {data: 'penawaran', name: 'penawaran'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    $('.dt-button').addClass('btn btn-default btn-xs');

    table.on('draw.dt', function (){
        var PageInfo = $('#panselnas-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function filter(){
        if($('#tmlelang_id').val() == '99'){
            $('.formFilter').removeClass('active');
            $('#btnFilter').hide();
        }else{
            $('.formFilter').addClass('active');
            $('#btnFilter').show();
        }
        table.api().draw();
    }

    function filterReset(){
        $('#tmlelang_id').val('99');
        $('#tmlelang_id').trigger('change.select2');
        filter();
    }

    $('#tmlelang_id').on("select2:select", function(){ filter(); });
</script>
@endsection
