@extends('layouts.app')

@section('content')
<div class="page has-sidebar-left">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4 class="my-2">
                        <i class="icon icon-sailing-boat-water"></i> Dashboard
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="blue accent-3 pl-3 pr-3 pb-3">
        <div id="myfirstchart" style="height: 365px;"></div>
    </div>

    <div class="container-fluid animatedParent animateOnce no-p">
        <div class="animated fadeInUpShort">
            <div class="card no-b shadow">
                <div class="card-body p-0">
                    <div class="lightSlider" data-item="4" data-item-md="2" data-item-sm="1" data-pause="7000" data-pager="false" data-auto="true">
                     <!-- data-item="6" data-item-xl="4" data-item-md="2" data-item-sm="1" data-pause="7000" data-pager="false" data-auto="true" data-loop="true"> -->
                        <div class="p-5 light clone">
                            <h5 class="font-weight-normal s-14">Lowongan Jabatan</h5>
                            <span class="s-48 font-weight-lighter" id="lowonganTotal">...</span>
                            <div><small>Sedang berlangsung</small></div>
                        </div>

                        <div class="p-5 lighten-3">
                            <h5 class="font-weight-normal s-14">Pelamar</h5>
                            <span class="s-48 font-weight-lighter text-primary" id="pelamarTotal">...</span>
                            <div><small>Berkas pelamar</small></div>
                        </div>

                        <div class="p-5 indigo lighten-2 text-white">
                            <h5 class="font-weight-normal s-14">Dalam Proses</h5>
                            <span class="s-48 font-weight-lighter text-primary" id="prosesTotal">...</span>
                            <div><small>Berkas dalam proses</small></div>
                        </div>

                        <div class="p-5 text-danger">
                            <h5 class="font-weight-normal s-14">Ditolak</h5>
                            <span class="s-48 font-weight-lighter" id="tolakTotal">...</span>
                            <div><small>Dinyatakan tidak lolos</small></div>
                        </div>

                        <div class="p-5 light-green-text">
                            <h5 class="font-weight-normal s-14">Lulus</h5>
                            <span class="s-48 font-weight-lighter" id="lulusTotal">...</span>
                            <div><small>Dinyatakan lolos</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
$.get

$.get("{!! route('home.grafikLelang') !!}", function(data){
    grafikLelang(data.grafik);
    $('#lowonganTotal').html(data.lowonganTotal);
    $('#pelamarTotal').html(data.pelamarTotal);
    $('#prosesTotal').html(data.prosesTotal);
    $('#tolakTotal').html(data.tolakTotal);
    $('#lulusTotal').html(data.lulusTotal);

}, 'JSON');

function grafikLelang(grafikLelangData)
{
    new Morris.Bar({
        element: 'myfirstchart',
        gridLineColor: '#5796ff',
        gridTextColor: '#a2c5ff',
        pointFillColors: '#000',
        data: grafikLelangData,
        xkey: 'y',
        ykeys: ['a', 'b', 'c', 'd'],
        labels: ['Pelamar', 'Dalam Proses', 'Ditolak', 'Lulus'],
        barColors: ['#95bcfc', '#0b62a4', '#c66767', '#70c667'],
        hideHover: 'auto'
    });
}
</script>
@endsection
