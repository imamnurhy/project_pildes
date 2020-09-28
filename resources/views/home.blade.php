@extends('layouts.app')

@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box">
                        </i>
                        Dashboard
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <!--Today Tab Start-->
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
                {{-- Card --}}
                <div class="row my-3">
                    {{-- Jumlah  Merk --}}
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-notebook-list s-48">
                                    </span>
                                </div>
                                <div class="counter-title">
                                    Merk
                                </div>
                                <h5 class="sc-counter mt-3">
                                    {{ $tmmerk }}
                                </h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div aria-valuemin="0" aria-valuenow="25" class="progress-bar" role="progressbar"
                                    style="width:{{ $tmmerk }}%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Jumlah Aset--}}
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-notebook-list s-48">
                                    </span>
                                </div>
                                <div class="counter-title ">
                                    Aset
                                </div>
                                <h5 class="sc-counter mt-3">
                                    {{ $tmjenis_aset }}
                                </h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div aria-valuemin="0" aria-valuenow="25" class="progress-bar" role="progressbar"
                                    style="width: {{ $tmjenis_aset }}%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Jumlah Aset Masuk --}}
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-input s-48">
                                    </span>
                                </div>
                                <div class="counter-title">
                                    Aset Masuk
                                </div>
                                <h5 class="sc-counter mt-3">
                                    {{ $tmaset }}
                                </h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div aria-valuemin="0" aria-valuenow="25" class="progress-bar" role="progressbar"
                                    style="width:{{ $tmaset }}%;">
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Jumlah Aset Keluar --}}
                    <div class="col-md-3">
                        <div class="counter-box white r-5 p-3">
                            <div class="p-4">
                                <div class="float-right">
                                    <span class="icon icon-arrow_back s-48">
                                    </span>
                                </div>
                                <div class="counter-title">
                                    Aset Keluar
                                </div>
                                <h5 class="sc-counter mt-3">
                                    {{ $tmopd_aset }}
                                </h5>
                            </div>
                            <div class="progress progress-xs r-0">
                                <div aria-valuemin="0" aria-valuenow="25" class="progress-bar" role="progressbar"
                                    style="width:{{ $tmopd_aset }}%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Image --}}
                <div class="ro">


                    <div class="col-md-12">
                        <div class="white p-5 r-5">
                            <div class="card-title">
                                <h5>
                                    --
                                </h5>
                            </div>
                            <div align="center">
                                <img height="280" src="{{ asset('assets/img/icon/icon-plane.png')}}" width="300">
                                </img>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Today Tab End-->
        </div>
    </div>
</div>
@endsection
