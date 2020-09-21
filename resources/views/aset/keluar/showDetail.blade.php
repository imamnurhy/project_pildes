@extends('layouts.app')

@section('title', 'Detail Asset keluar')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-clipboard-list"></i> Detail Asset Keluar -
                        {{ $tmopd->n_lokasi .' - '. $tmopd->tmkategoris->n_kategori }}
                    </h3>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.keluar.index') }}">
                            <i class="icon icon-arrow_back"></i>Semua data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="row container-fluid my-3 m-0">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-detail-aset-keluar" class="table table-striped no-b" style="width:100%">
                            <thead>
                                <th width="30">No</th>
                                <th>Barang</th>
                                <th>No Aset</th>
                                <th>Serial</th>
                                <th>Merek</th>
                                <th>Ket</th>
                                <th>Tanggal</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="column col-md-3">
            <div id="alert"></div>
            <div class="card mb-1">
                <div class="card-body text-center">
                    <div class="image m-3">
                        @if ($tmopd->image_network != '')
                        <a href="#modal_priview_image" rel="modal:open">
                            <img class="no-b no-p r-10"
                                src="{{ config('app.SFTP_SRC') . 'aset/opd/'. $tmopd->image_network }}"
                                alt="Foto design jaringan" id="image_network" width="100%">
                        </a>
                        @else
                        <img class="user_avatar no-b no-p r-10" src="{{ asset('assets/img/dummy/u1.png')}}"
                            alt="User Image">
                        @endif
                    </div>
                    <div>
                        <h6 class="p-t-10">{{ $tmopd->n_lokasi }}</h6>
                        {{ $tmopd->tmkategoris->n_kategori }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal HTML embedded directly into document -->
    <div id="modal_priview_image" class="modal" style="overflow: initial">
        <img src="{{ config('app.SFTP_SRC') . 'aset/opd/'. $tmopd->image_network }}" width="100%"
            style="border-radius: 5%" />
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

<script type="text/javascript">
    var table = $('#table-detail-aset-keluar').dataTable({
        processing: true,
        serverSide: true,
        order: [1, 'desc'],
        ajax: "{{ route('aset.keluar.apiDetailAsetKeluar', ':id')}}".replace(':id', {{ $tmopd_id }}),
        columns: [
            {
                data:'id',
                name:'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data:'n_jenis_aset',
                name:'n_jenis_aset'
            },
            {
                data:'no_aset',
                name:'no_aset'
            },
            {
                data:'serial',
                name:'serial'
            },
            {
                data:'n_rincian',
                name:'n_rincian'
            },
            {
                data:'ket',
                name:'ket'
            },
            {
                data:'created_at',
                name:'created_at'
            },
        ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#table-detail-aset-keluar').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

</script>
@endsection
