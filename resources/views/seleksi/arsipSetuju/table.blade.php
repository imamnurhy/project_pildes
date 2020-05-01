@extends('layouts.app')

@section('title', 'Data Arsip Disetujui')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<style>
.avatar {
  vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
label{
    font-size:12px;
}
h4{
    font-size:12px;
}


</style>

@endsection

@section('content')
<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h3 class="my-2">
                        <i class="icon icon-check"></i> Data Arsip Disetujui
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
                            <th width="125">Status</th>
                            <th width="70">Aksi</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog" style="height:100px;">
      <div class="modal-content ">
        <div class="modal-header">
            <div class="float-left">
                <img id="foto"  src="" alt="Avatar" class="avatar">
            </div>&nbsp;&nbsp;
            <div>
                <h5 style="font-size:15px" id="nama_pl"></h5>
                <h5 style="font-size:15px" id="no_pendaftaran"></h5>
            </div>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body" >
            <div class="row">
                    <div class="col-md-6">
                        <label>Detail Pemilik</label>
                        <br>
                        <label>Direktur : <h4 id="nama_pl2"></h4></label>
                        <br>
                        <label>Nik : <h4 id="nik_pl"></h4></label>
                        <br>
                        <label>Ttl : <h4 id="ttl_pl"></h4></label>
                        <br>
                        <label>Jk : <h4 id="jk_pl"></h4></label>
                        <br>
                        <label>No Telp : <h4 id="no_tlp_pr"></h4></label>

                    </div>
                    <div class="col-md-6 ml-auto">
                        <label>Detail Perusahaan</label>
                        <br>
                        <label>Perusahaan : <h4 id="n_pr"></h4></label>
                        <br>
                        <label>No Siup : <h4 id="siup_pr"></h4></label>
                        <br>
                        <label>No Npwp : <h4 id="npwp_pr"></h4></label>
                        <br>
                        <label>Alamat : <h4 id="alamat_pr"></h4></label>
                        <br>
                        <label>Email : <h4 id="email_pr"></h4></label>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Lahan Yang Di Lamar</label>
                    <br>
                    <h4 id="n_lelang"></h4>
                    <br>
                    <label> Penawaran </label>
                    <h4 id="penawaran">Rp.</h4>
                    <br>
                    <label>Foto Lahan :</label>
                    <br>
                    <a id="foto2" target="_blank" >Lihat Foto Lahan</a>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="center">Dengan Ini Menyatakan Bahwa Pelamar Ini Menang </h4>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" id="id">
            <button type="button" class="btn btn-primary" onclick="pemenang()">Ya</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
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
        // order: [ 5, 'desc' ],
        ajax: {
            url: "{{ route('api.arsipSetuju') }}",
            method: 'POST',
            data: function (d) {
                d.tmlelang_id = $('#tmlelang_id').val();
            }
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'no_pendaftaran', name: 'no_pendaftaran'},
            {data: 'nama_pl', name: 'nama_pl'},
            {data: 'n_pr', name: 'n_pr'},
            {data: 'n_lelang', name: 'n_lelang'},
            {data: 'penawaran', name: 'penawaran'},
            {data: 'c_pemenang', name: 'c_pemenang', visible: false, searchable: false},
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

    var penawaran = '';
    function cekPemenang(id){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url : "{{ route('arsipSetuju.cekPemenang', ':id') }}".replace(':id', id),
            type : "POST",
            data : {'_method' : 'PATCH', '_token' : csrf_token},
            success : function(data) {
                console.log(data);
                $('#myModal').modal('show');

                $('#foto').attr('src', data.env + data.foto_pl);
                $('#nama_pl').html(data.nama_pl);
                $('#nama_pl2').html(data.nama_pl);
                $('#no_pendaftaran').html(data.no_pendaftaran);
                $('#nik_pl').html(data.nik_pl);
                $('#kk_pl').html(data.kk_pl);
                $('#ttl_pl').html(data.t_lahir_pl + data.d_lahir_pl);
                $('#jk_pl').html(data.jk_pl);
                $('#no_tlp_pr').html(data.no_tlp_pl);


                $('#n_pr').html(data.n_pr);
                $('#siup_pr').html(data.siup_pr);
                $('#npwp_pr').html(data.npwp_pr);
                $('#jw_pr').html(data.jw_pr);
                $('#alamat_pr').html(data.alamat_pr);
                $('#email_pr').html(data.email_pr);

                $('#n_lelang').html(data.n_lelang);
                $('#id').val(data.id);
                $('#foto2').attr("href", data.env2 + data.foto);


                 penawaran = data.penawaran;

                 //--- Harga Penawaran ---//
                    var bilangan = penawaran;

                    var	number_string = bilangan.toString(),
                        sisa 	= number_string.length % 3,
                        rupiah 	= number_string.substr(0, sisa),
                        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                $('#penawaran').html('Rp' + '.' + rupiah);

            },
            error : function () {
                console.log('Opssss...');
                reload();
            }
        });
    }


    function pemenang(id){
        var id = $('#id').val();
        $('#myModal').modal('hide');
        $.confirm({
            title: '',
            content: 'Pemenang Pemilihan Calon Mitra Sewa',
            icon: 'icon-send',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'green',
            buttons: {
                ok: {
                    text: "Pilih",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url : "{{ route('arsipSetuju.pemenang', ':id') }}".replace(':id', id),
                            type : "POST",
                            data : {'_method' : 'PATCH', '_token' : csrf_token, 'tmlelang_id' : 39},
                            success : function(data) {
                                console.log(data);
                                $.confirm({
                                    title: 'Berhasil',
                                    content: data.message,
                                    icon: 'icon-check',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'green',
                                    autoClose: 'cancelAction|5000',
                                        escapeKey: 'cancelAction',
                                        buttons: {
                                            cancelAction: {
                                                text: 'OK',
                                                action: function () {
                                                }
                                            }
                                        }
                                });
                                table.api().ajax.reload();
                            },
                            error : function () {
                                console.log('Opssss...');
                                reload();
                            }
                        });
                    }
                },
                cancel: function(){
                    $('#myModal').modal('show');
                    console.log('the user clicked cancel');
                }
            }
        });
    }

    function cek(){
        $.confirm({
            title: '',
            content: 'Pemenang Terpilih',
            icon: 'icon-check',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'green',
            buttons: {
                ok: {
                    text: "Ok",
                    btnClass: 'btn-primary',
                    keys: ['enter']
                }
            }
        });
    }

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
