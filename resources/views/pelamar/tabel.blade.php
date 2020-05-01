@extends('layouts.app')

@section('title', 'Pelamar')

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
                        <i class="icon icon-id-badge "></i>Data Semua Pelamar
                    </h3>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card no-b no-r mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dt-buttons mr-3">
                        <button class="dt-button buttons-excel buttons-html5 btn btn-default btn-xs" tabindex="0" aria-controls="panselnas-table" type="button" onclick="exportToExcel()"><span>Excel</span></button>
                    </div>
                    <table id="report-table" class="table table-striped" style="width:100%">
                        <thead>
                            <th width="10">No</th>
                            <th width="30">Nik</th>
                            <th width="50">Nama</th>
                            <th width="40">TTL</th>
                            <th width="30">Jenis Kelamin</th>
                            <th width="30">Perusahaan</th>
                            <th width="15"></th>
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
    $('#d_dari').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
            maxDate:$('#d_sampai').val()?$('#d_sampai').val():false
        })},
        timepicker:false
    });
    $('#d_sampai').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){
        this.setOptions({
            minDate:$('#d_dari').val()?$('#d_dari').val():false
        })},
        timepicker:false
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#report-table').dataTable({
        processing: true,
        serverSide: true,
        order: [ 1, 'asc' ],
        ajax: {
            url: "{{ route('api.pelamar') }}",
            method: 'POST',
            data: function (d) {
                d.d_dari = $('#d_dari').val();
                d.d_sampai = $('#d_sampai').val();
            }
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'nik_pl', name: 'nik_pl'},
            {data: 'nama_pl', name: 'nama_pl'},
            {data: 't_lahir_pl', name: 't_lahir_pl'},
            {data: 'jk_pl', name: 'jk_pl'},
            {data: 'n_pr', name: 'n_pr'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    $('.dt-button').addClass('btn btn-default btn-xs');

    table.on('draw.dt', function (){
        var PageInfo = $('#report-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function filter(){
        if($('#d_dari').val() == '' || $('#d_sampai').val() == ''){
            alert('Silahkan pilih rentan tanggal');
            return false;
        }
        table.api().draw();
    }

    function exportToExcel(){
        if($('#d_dari').val() == '' && $('#d_sampai').val() == ''){
            alert('Silahkan pilih rentan tanggal');
            return false;
        }else{
            document.location.href = "{{ route('registrasi.report.exportToExcel', [':d_dari', ':d_sampai']) }}".replace(':d_dari', $('#d_dari').val()).replace(':d_sampai', $('#d_sampai').val());
        }
    }

    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);
            $.ajax({
                url : "{{ route('registrasi.report') }}",
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action').removeAttr('disabled');
                },
                error : function(data){
                    $('#action').removeAttr('disabled');
                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function( index, value ) {
                        err = err + "<li>" + value +"</li>";
                    });
                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    $('html, body').animate({ scrollTop: $('#alert').offset().top - 50 }, 500);
                }
            });
            return false;
        }
        $(this).addClass('was-validated');
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
                            url : "{{ route('pelamar.delete', ':id') }}".replace(':id', id),
                            type : "POST",
                            data : {'_method' : 'DELETE', '_token' : csrf_token},
                            success : function(data) {
                                $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                                table.api().ajax.reload();
                                if(id == $('#id').val()){
                                    add();
                                }
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
