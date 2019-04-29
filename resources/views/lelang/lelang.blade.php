@extends('layouts.app')

@section('title', 'Master Lelang')

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
                        <i class="icon icon-event_seat"></i> Data Lelang
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card no-b">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="lelang-table" class="table table-striped" style="width:100%">
                        <thead>
                            <th width="30">No</th>
                            <th>Nama</th>
                            <th width="100px">Dari Tgl</th>
                            <th width="100px">Sampai Tgl</th>
                            <th width="80">Status</th>
                            <th width="80px">Syarat</th>
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

<script type="text/javascript">
    $('#menuLelang').addClass('active');
    var table = $('#lelang-table').dataTable({
        processing: true,
        serverSide: true,
        order: [ 2, 'asc' ],
        ajax: "{{ route('api.lelang') }}",
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, className: 'text-center'},
            {data: 'n_lelang', name: 'n_lelang'},
            {data: 'd_dari', name: 'd_dari', className: 'text-center'},
            {data: 'd_sampai', name: 'd_sampai', className: 'text-center'},
            {data: 'c_status', name: 'c_status', className: 'text-center'},
            {data: 'syarats', name: 'syarats', orderable: false, searchable: false, className: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#lelang-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        } );
    });

    function remove(id){
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
                    action: function(){
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url : "{{ route('lelang.destroy', ':id') }}".replace(':id', id),
                            type : "POST",
                            data : {'_method' : 'DELETE', '_token' : csrf_token},
                            success : function(data) {
                                table.api().ajax.reload();
                                $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                            },
                            error : function () {
                                console.log('Opssss...');
                                reload();
                            }
                        });
                    }
                },
                cancel: function(){
                    console.log('the user clicked cancel');
                }
            }
        });
    }
</script>
@endsection
