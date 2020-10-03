@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-fancybox.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        Dashboard
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">

                <div class="row my-3">

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-note-list text-light-blue s-48"></span>
                                </div>
                                <div class="counter-title">Total Layanan</div>
                                <h5 class="sc-counter mt-3">{{ $ttl_layanan }}</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="{{ $ttl_layanan }}"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-user-o s-48"></span>
                                </div>
                                <div class="counter-title ">Jumlan Pelanggan</div>
                                <h5 class="sc-counter mt-3">{{ $ttl_pelanggan }}</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="{{ $ttl_pelanggan }}"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-stop-watch3 s-48"></span>
                                </div>
                                <div class="counter-title">Support Requests</div>
                                <h5 class="sc-counter mt-3">1228</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="128"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-inbox-document-text s-48"></span>
                                </div>
                                <div class="counter-title">Support Requests</div>
                                <h5 class="sc-counter mt-3">550</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="128"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="white p-2 r-5">
                            <div class="formFilter">
                                <div class="card-body">
                                    <form id="form">
                                        <div class="row col-md-12">

                                            <div class="col-md-1 pr-0">
                                                <div class="mt-1">
                                                    <strong><i class="icon-filter"></i>FILTER</strong>
                                                </div>
                                            </div>

                                            <div class="col-md-2 pr-0">
                                                <div class="bg-light" width="100%">
                                                    <input type="date" name="tgl_pembayaran" id="tgl_pembayaran"
                                                        class="form-control r-0 light s-12 col-md-12" autocomplete="off"
                                                        required value="{{ date('Y-m-d') }}" />
                                                </div>
                                            </div>

                                            <div class="col-md-2 pr-0">
                                                <div class="bg-light" width="100%">
                                                    <select name="layanan_id" id="layanan_id" placeholder="Semua"
                                                        class="form-control r-0 light s-12 col-md-12 custom-select select2"
                                                        autocomplete="off">
                                                        <option value="99">Layanan : Semua</option>
                                                        @foreach ($layanan as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->n_layanan . ' ' . $item->bandwidth . ' Mbps' }}
                                                        </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-1">
                                                <a class="btn btn-sm" id="btnFilter" title="Reset Filter"
                                                    style="display:none" onclick="reset()">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="white p-2 r-2">
                            <div class="card-body no-b">
                                <div class="table-responsive">
                                    <table id="home-table" class="table table-striped" style="width:100%">
                                        <thead>
                                            <th width="30">No</th>
                                            <th>Pelanggan</th>
                                            <th>Paket layanan</th>
                                            <th>Tgl pemasangan</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>jumlah bayar</th>
                                            <th>Tagihan</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <th></th>
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

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="white p-5 r-5">
                            <div class="card-title">
                                <h5> Sales Overview</h5>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-3">
                                    <div class="my-3 mt-4">
                                        <h5>Sales <span class="red-text">+203.48</span></h5>
                                        <span class="s-24">$2652.07</span>
                                        <p>A short summary of sales report if you want to add here. This could
                                            be useful
                                            for quick view.</p>
                                    </div>
                                    <div class="row no-gutters bg-light r-3 p-2 mt-5">
                                        <div class="col-md-6 b-r p-3">
                                            <h5>Net Sales</h5>
                                            <span>$2351.08 </span>
                                        </div>
                                        <div class="col-md-6 p-3">
                                            <div class="">
                                                <h5>Costs <span class="amber-text">+87.4</span></h5>
                                                <span>$900.09</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9" style="height: 350px">
                                    <canvas data-chart="line" data-dataset="[
                                                                [0, 15, 4, 30, 8, 5, 18, 40],
                                                                ]"
                                        data-labels="['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']" data-dataset-options="[
                                                                {   label:'HTML',
                                                                    fill: true,
                                                                    backgroundColor: 'rgba(50,141,255,.2)',
                                                                    borderColor: '#328dff',
                                                                    pointBorderColor: '#328dff',
                                                                    pointBackgroundColor: '#fff',
                                                                    pointBorderWidth: 2,
                                                                    borderWidth: 1,
                                                                    borderJoinStyle: 'miter',
                                                                    pointHoverBackgroundColor: '#328dff',
                                                                    pointHoverBorderColor: '#328dff',
                                                                    pointHoverBorderWidth: 1,
                                                                    pointRadius: 3,

                                                                },
                                                                ]" data-options="{
                                                                        maintainAspectRatio: false,
                                                                        legend: {
                                                                            display: true
                                                                        },

                                                                        scales: {
                                                                            xAxes: [{
                                                                                display: true,
                                                                                gridLines: {
                                                                                    zeroLineColor: '#eee',
                                                                                    color: '#eee',
                                                                                    borderDash: [5, 5],
                                                                                }
                                                                            }],
                                                                            yAxes: [{
                                                                                display: true,
                                                                                gridLines: {
                                                                                    zeroLineColor: '#eee',
                                                                                    color: '#eee',
                                                                                    borderDash: [5, 5],
                                                                                },
                                                                                ticks: {
                                                                                    beginAtZero: !0,
                                                                                    max: 40,
                                                                                    stepSize: 10,
                                                                                    fontSize: '11',
                                                                                    fontColor: '#969da5'
                                                                                }
                                                                            }]

                                                                        },
                                                                        elements: {
                                                                            line: {

                                                                                tension: 0.4,
                                                                                borderWidth: 1
                                                                            },
                                                                            point: {
                                                                                radius: 2,
                                                                                hitRadius: 10,
                                                                                hoverRadius: 6,
                                                                                borderWidth: 4
                                                                            }
                                                                        }
                                                                    }">
                                    </canvas>
                                </div>
                            </div>
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
<script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>

<script type="text/javascript">
    var table = $('#home-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('home.api') }}",
            method: 'GET',
            data: function (data) {
                data.tgl_pembayaran = $('#tgl_pembayaran').val();
                data.layanan_id = $('#layanan_id').val();
            },
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
                data: 'n_pelanggan',
                name: 'n_pelanggan'
            },
            {
                data: 'layanan',
                name: 'layanan',
                render: function(data){
                    return data.n_layanan + ' ' + data.bandwidth + ' Mbps';
                }
            },
            {
                data: 'tgl_daftar',
                name: 'tgl_daftar'
            },
            {
                data: 'layanan.harga',
                name: 'layanan.harga',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(data);
                }
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'jml_bayar',
                name: 'jml_bayar',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(data);
                }
            },
            {
                data: 'tagihan',
                name: 'tagihan',
                render: function(data, type, row, meta){
                    return meta.settings.fnFormatNumber(data);
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
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp ' ).display;
            $(api.column(4).footer()).html(numFormat(total));

        }
    });

    table.on('draw.dt', function () {
        var PageInfo = $('#home-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

   $('#tgl_pembayaran, #layanan_id').on('change', function(){
       if ($(this).val() == '99') {
           $('.formFilter').removeClass('active');
           $('#btnFilter').hide();
       } else {
           $('.formFilter').addClass('active');
           $('#btnFilter').show();
       }
      table.api().draw();
   });

   function reset(){
       $('#form').trigger('reset');
       table.api().draw();
   }

   function paid(pelanggan_id){
    $.confirm({
        title: '',
        content: 'Confirmasi pembayaran',
        icon: 'icon icon-payment blue-text',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: 'blue',
        buttons: {
            ok: {
                text: "ok!",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function () {
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('home.paid') }}",
                        type: "POST",
                        data: {
                            '_method': 'POST',
                            '_token': csrf_token,
                            'pelanggan_id' : pelanggan_id,
                            'tgl_pembayaran': $('#tgl_pembayaran').val(),
                        },
                        success: function (data) {
                            table.api().ajax.reload();
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

</script>
@endsection
