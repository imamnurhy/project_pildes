@extends('layouts.app')

@section('title', 'Laporan Lamaran Jabatan')

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-list3"></i> Laporan Lamaran Jabatan
                    </h3>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid my-3">
        <div id="alert"></div>
        <div class="card no-b no-r mt-3">
            <div class="card-body">
                <strong class="card-title">Filter</strong>
                <div class="form-inline">
                    <div class="form-group m-0 col-md-12">
                        <label for="d_dari" class="col-form-label s-12 col-md-2">Tanggal lamaran</label>
                        <input type="text" name="d_dari" id="d_dari" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{{ date('Y-m-d') }}" required>
                        <label for="d_sampai" class="col-md-1"> s.d. </label>
                        <input type="text" name="d_sampai" id="d_sampai" placeholder="" class="form-control r-0 light s-12 col-md-2" autocomplete="off" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="card-body offset-md-2">
                        <a class="btn btn-primary btn-sm" title="Filter data" onclick="filter()"><i class="icon-filter mr-2"></i>Filter</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card no-b no-r mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dt-buttons mr-3">
                        <button class="dt-button buttons-excel buttons-html5 btn btn-default btn-xs" tabindex="0" onclick="exportToExcel()"><span>Excel</span></button>
                    </div>
                    <table id="report-table" class="table table-striped" style="width:100%">
                        <thead>
                            <th width="30">No</th>
                            <th width="120">No Registrasi</th>
                            <th width="160">Nama</th>
                            <th>Jabatan Yg Dilamar</th>
                            <th width="150">Status</th>
                        </thead>
                        <tbody style="min-height:350px"></tbody>
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
        pageLength: 25,
        processing: true,
        serverSide: true,
        order: [ 1, 'asc' ],
        ajax: {
            url: "{{ route('api.seleksi.report') }}",
            method: 'POST',
            data: function (d) {
                d.d_dari = $('#d_dari').val();
                d.d_sampai = $('#d_sampai').val();
            }
        },
        columns: [
            {data: 'tmregistrasi.id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'no_pendaftaran', name: 'no_pendaftaran'},
            {data: 'tmregistrasi.n_pegawai', name: 'tmregistrasi.n_pegawai'},
            {data: 'tmlelang.n_lelang', name: 'tmlelang.n_lelang'},
            {data: 'tmpelamar_status.n_status', name: 'tmpelamar_status.n_status', className: 'text-center'}
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
            document.location.href = "{{ route('seleksi.report.exportToExcel', [':d_dari', ':d_sampai']) }}".replace(':d_dari', $('#d_dari').val()).replace(':d_sampai', $('#d_sampai').val());
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
            url : "{{ route('seleksi.report') }}",
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
</script>
@endsection