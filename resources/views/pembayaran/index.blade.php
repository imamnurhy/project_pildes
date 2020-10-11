@extends('layouts.app')

@section('title', 'Pembayaran')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-fancybox.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-payment"></i> Data Pembayaran
                    </h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">

            <div class="col-md-8">
                <div class="card no-b">


                    <div class="formFilter">
                        <div class="card-body">
                            <form id="formFilter">
                                <div class="row col-md-12">

                                    <div class="col-md-2 pr-0">
                                        <div class="mt-1">
                                            <strong><i class="icon-filter"></i>FILTER</strong>
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="bg-light" width="100%">
                                            <select name="thn_pembayaran" id="thn_pembayaran" placeholder="Semua"
                                                class="form-control r-0 light s-12 col-md-12 custom-select"
                                                autocomplete="off">
                                                <option value="99">Tahun : Semua</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="bg-light" width="100%">
                                            <select name="bln_pembayaran" id="bln_pembayaran" placeholder="Semua"
                                                class="form-control r-0 light s-12 col-md-12 custom-select select"
                                                autocomplete="off">
                                                <option value="99">Bulan : Semua</option>
                                                @foreach ($months as $key => $month)
                                                <option value="{{ $key }}">{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="bg-light" width="100%">
                                            <select name="status_pembayaran" id="status_pembayaran" placeholder="Semua"
                                                class="form-control r-0 light s-12 col-md-12 custom-select select"
                                                autocomplete="off">
                                                <option value="99">Status : Semua</option>
                                                <option value="1">Lunas</option>
                                                <option value="0">Belum lunas</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-1">
                                        <a class="btn btn-sm" id="btnFilter" title="Reset Filter" style="display:none"
                                            onclick="reset()">Reset</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pembayaran-table" class="table table-striped" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th width="60"></th>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <th colspan="2"></th>
                                    <th>Total</th>
                                    <th></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 my-1">
                <div class="card">
                    <div class="card-body">
                        <div id="alert"></div>
                        <form class="needs-validation" id="form" method="POST" novalidate>
                            @csrf
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id" />
                            <h4 id="formTitle">Tambah Data</h4>
                            <hr>
                            <div class="form-row form-inline">
                                <div class="col-md-12">

                                    <div class="form-group m-1">
                                        <label for="pelanggan_id" class="col-form-label s-12 col-md-4">Pelanggan</label>
                                        <div class="col-md-7">
                                            <select name="pelanggan_id" id="pelanggan_id"
                                                class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                                required>
                                                <option value="">Plih</option>
                                                @foreach ($pelanggan as $item)
                                                <option value="{{ $item->id }}">{{ $item->n_pelanggan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group m-0">
                                        <label for="tgl_bayar" class="col-form-label s-12 col-md-4">Tgl Bayar</label>
                                        <input type="text" name="tgl_bayar" id="tgl_bayar" autocomplete="off"
                                            class="date-time-picker form-control  s-12 col-md-6 ml-3 " required />
                                    </div>

                                    <div class="form-group m-0">
                                        <label for="status" class="col-form-label s-12 col-md-4">Status</label>
                                        <select name="status" id="status"
                                            class="form-control r-0 light s-12 col-md-6 custom-select select ml-3"
                                            required>
                                            <option value="">Plih</option>
                                            <option value="0">Belum lunas</option>
                                            <option value="1">Lunas</option>
                                        </select>

                                    </div>


                                    <div class="card-body offset-md-3">
                                        <button type="submit" class="btn btn-primary btn-sm" id="action"><i
                                                class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                        <a class="btn btn-sm" onclick="add()" id="reset">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>

<script type="text/javascript">
    $('#tgl_bayar').datetimepicker({
        format: 'Y-m-d H:i',
        timepicker: true
    });
    var table = $('#pembayaran-table').dataTable({
        processing: true,
        serverSide: true,
        order: [ 1, 'asc' ],
        ajax: {
            url: "{{ route('pembayaran.api') }}",
            data : function(data){
                data.thn_pembayaran = $('#thn_pembayaran').val();
                data.bln_pembayaran = $('#bln_pembayaran').val();
                data.status_pembayaran = $('#status_pembayaran').val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                align: 'center',
                className: 'text-center'
            },
            {
                data: 'pelanggan.n_pelanggan',
                name: 'pelanggan.n_pelanggan'
            },
            {
                data: 'tgl_bayar',
                name: 'tgl_bayar'
            },
            {
                data: 'jml_bayar',
                name: 'jml_bayar',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(data);
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function(data){
                    if(data == 0){
                        return 'Belum lunas';
                    } else if(data == 1){
                        return 'Lunas';
                    }
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        drawCallback: function (data) {
            var api = this.api();
            total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp ' ).display;
            $(api.column(3).footer()).html(numFormat(total));

        }
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#pembayaran-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    function add(){
        save_method = "add";
        $('#form').trigger('reset');
        $('#formTitle').html('Tambah Data');
        $('input[name=_method]').val('POST');
        $('#txtAction').html('');
    }

    add();
    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            $('#action').attr('disabled', true);;
            if (save_method == 'add'){
                url = "{{ route('pembayaran.store') }}";
            }else{
                url = "{{ route('pembayaran.update', ':id') }}".replace(':id', $('#id').val());
            }
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#action').removeAttr('disabled');
                    $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    table.api().ajax.reload();
                },
                error : function(data){
                    $('#action').removeAttr('disabled');
                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function( index, value ) {
                        err = err + "<li>" + value +"</li>";
                    });

                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            });
            return false;
        }
        $(this).addClass('was-validated');
    });

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data <a href='#' onclick='add()' class='btn btn-outline-primary btn-xs pull-right'>Batal</a>");
        $('#txtAction').html(" Perubahan");
        $('#reset').hide();
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ route('pembayaran.edit', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#pelanggan_id').val(data.pelanggan_id).trigger('change');
                $('#tgl_bayar').val(data.tgl_bayar);
                $('#status').val(data.status);
            },
            error : function() {
                console.log("Nothing Data");
                reload();
            }
        });
    }

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
                            url : "{{ route('pembayaran.destroy', ':id') }}".replace(':id', id),
                            type : "POST",
                            data : {'_method' : 'DELETE', '_token' : csrf_token},
                            success : function(data) {
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

    $('#thn_pembayaran, #bln_pembayaran, #status_pembayaran').on('change', function () {
        if ($(this).val() == '99') {
            $('.formFilter').removeClass('active');
            $('#btnFilter').hide();
        } else {
            $('.formFilter').addClass('active');
            $('#btnFilter').show();
        }
        table.api().draw();
    });

    function reset() {
        $('#formFilter').trigger('reset');
        $('.formFilter').removeClass('active');
        $('#btnFilter').hide();
        table.api().draw();
    }
</script>
@endsection
