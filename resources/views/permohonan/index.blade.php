@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
@endsection

@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        Permohonan
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
                                    <span class="icon icon-notebook-list s-48"></span>
                                </div>
                                <div class="counter-title">Permohonan</div>
                                <h5 class="sc-counter mt-3">{{ $totalPermohonan }}</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width:{{ $totalPermohonan }}%;"
                                    aria-valuenow="{{ $totalPermohonan }}" aria-valuemin="{{ $totalPermohonan }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-notebook-list s-48"></span>
                                </div>
                                <div class="counter-title ">Proses Verifikasi</div>
                                <h5 class="sc-counter mt-3">{{ $verifikasiProsess }}</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width:{{ $verifikasiProsess }}%;"
                                    aria-valuenow="{{ $verifikasiProsess }}" aria-valuemin="{{ $verifikasiProsess }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-clipboard-checked s-48"></span>
                                </div>
                                <div class="counter-title">Di strujui</div>
                                <h5 class="sc-counter mt-3">{{ $verifikasiSuccess }}</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width:{{ $verifikasiSuccess }}%;"
                                    aria-valuenow="{{ $verifikasiSuccess }}" aria-valuemin="{{ $verifikasiSuccess }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-document-error s-48"></span>
                                </div>
                                <div class="counter-title">Di Tolak</div>
                                <h5 class="sc-counter mt-3">{{ $verifikasiGagal }}</h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div class="progress-bar" role="progressbar" style="width:{{ $verifikasiGagal }}%;"
                                    aria-valuenow="{{ $verifikasiGagal }}" aria-valuemin="{{ $verifikasiGagal }}"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="white p-5 r-5">
                            <div class="table-responsive">
                                <table id="permohonan-table" class="table table-striped no-b" style="width:100%">
                                    <thead>
                                        <th width="30">No</th>
                                        <th>OPD</th>
                                        <th>Jenis permohonan</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                        <th width="40"></th>
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

    <div id="priview_permohonan_detail" class="modal fade">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush no-b">
                            <li class="list-group-item">
                                <strong class="s-12">OPD</strong>
                                <span class="s-12 float-right" id="d_opd"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Kepala Dinas</strong>
                                <span class="s-12 float-right" id="d_kadis"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">No Hp </strong>
                                <span class="s-12 float-right" id="d_no_hp_kadis"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jenis Permohonan</strong>
                                <span class="s-12 float-right" id="d_jenis_permohonan"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Kebutuhan Bandwith</strong>
                                <span class="s-12 float-right" id="d_kebutuhan_bandwith"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jumlah Perangkat</strong>
                                <span class="s-12 float-right" id="d_jumlah_perangkat"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Jaringan Listrik</strong>
                                <span class="s-12 float-right" id="d_jaringan_listrik"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="s-12">Ketersediaan internet</strong>
                                <span class="s-12 float-right" id="d_jaringan_internet"></span>
                            </li>
                        </ul>
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
    var table = $('#permohonan-table').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('permohonan.api')}}",
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'tmopd.n_lokasi',
                name: 'tmopd.n_lokasi'
            },
            {
                data: 'jenis_permohonan',
                name: 'jenis_permohonan'
            },
            {
                data: 'status',
                name: 'status'
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
        var PageInfo = $('#permohonan-table').DataTable().page.info();
        table.api().column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });


    function showPermohonanDetail(id){
        $('#btn_detail_'+id).removeAttr('href', true);
        $.ajax({
            url: "{{ route('permohonan.detail', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function (data) {
                console.log(data);
                $('#priview_permohonan_detail').modal('show');
                $('#d_opd').html(data.tmopd.n_lokasi);
                $('#d_kadis').html(data.n_kadis);
                $('#d_no_hp_kadis').html(data.no_hp_kadis);

                if(data.jenis_permohonan == 1){
                $('#d_jenis_permohonan').html('Pengajuan pemasangan internet');
                } else if(data.jenis_permohonan == 2){
                $('#d_jenis_permohonan').html('Penambahan pemasangan internet');
                }

                $('#d_kebutuhan_bandwith').html(data.bandwith);
                $('#d_jumlah_perangkat').html(data.jumlah_perangkat);
                $('#d_jaringan_listrik').html(data.ketersediaan_listrik);
                $('#d_jaringan_internet').html(data.ketersediaan_internet);

                $('#btn_detail_'+id).attr('href', '#');

            },
            error: function (data) {

            }
        });

    }

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
                            url: "{{ route('permohonan.destroy', ':id') }}".replace(':id', id),
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


</script>
@endsection
