@extends('layouts.app')

@section('title', 'Master Asset Keluar')

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
                        <i class="icon icon-clipboard-list"></i> Data Aset Keluar
                    </h3>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul class="nav nav-material nav-material-white responsive-tab" role="tablist">
                    <li>
                        <a class="nav-link" href="{{ route('aset.keluar.create')}}">
                            <i class="icon icon-plus"></i>
                            Tambah Data
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="aset-keluar-table" class="table table-striped no-b" style="width:100%">
                        <thead>
                            <th width="30">No</th>
                            <th>OPD</th>
                            <th>Kategori</th>
                            <th width="350">Alamat</th>
                            <th width=130px>foto</th>
                            <th>Detail</th>
                            <th width="40"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="priview_aset_detail" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
    </div>

    <div id="priview_image_network" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image priview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img alt="image network" id="image_network">
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    var table = $('#aset-keluar-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('aset.keluar.api')}}",
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'n_lokasi',
                name: 'n_lokasi'
            },
            {
                data: 'n_kategori',
                name: 'n_kategori'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data:'foto',
                name:'foto',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'detail',
                name: 'detail'
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
        var PageInfo = $('#aset-keluar-table').DataTable().page.info();
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
                            url: "{{ route('aset.keluar.destroy', ':id') }}".replace(':id', id),
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

    function showDetailAset(tmopd_id){
        $('#priview_aset_detail').modal('show');

        var table2 = $('#table-detail-aset-keluar').dataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            order: [1, 'desc'],
            ajax: "{{ route('aset.keluar.apiDetailAsetKeluar', ':id')}}".replace(':id', tmopd_id ),
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
                    data:'n_merk',
                    name:'n_merk'
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

        table2.on('draw.dt', function () {
            var PageInfo2 = $('#table-detail-aset-keluar').DataTable().page.info();
            table2.api().column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo2.start;
            });
        });
    }

    function showImageNetwork(image){
        $('#priview_image_network').modal('show');
        $('#image_network').attr('src',image);
    }
</script>
@endsection
