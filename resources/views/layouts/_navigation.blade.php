<ul class="sidebar-menu">
    <li class="header"><strong>MAIN NAVIGATION</strong></li>
    <li>
        <a href="{{ route('home') }}">
            <i class="icon icon-sailing-boat-water purple-text s-18"></i> <span>Dashboard</span>
        </a>
    </li>

    @can('master-pegawai')
    <li class="header light"><strong>MASTER PEGAWAI</strong></li>
    <li>
        <a href="{{ route('pegawai.index') }}">
            <i class="icon icon-users amber-text s-18"></i> <span>Pegawai</span>
        </a>
    </li>

    <li class="treeview" id="menuConfig">
        <a href="{{ route('pegawai.index') }}">
            <i class="icon icon-settings2 s-18"></i> <span>Configurasi</span> <i
                class="icon icon-angle-left s-18 pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('opd.index') }}">
                    <i class="icon icon-building-o s-8"></i> <span>Pengguna</span>
                </a>
            </li>
        </ul>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('kategori.index') }}">
                    <i class="icon icon-document-list blue-text s-8"></i> <span>Kategori</span>
                </a>
            </li>
        </ul>
    </li>
    @endcan

    @can('master-role')
    <li class="header light"><strong>MASTER ROLE</strong></li>
    <li>
        <a href="{{ route('role.index') }}">
            <i class="icon icon-key4 amber-text s-18"></i> <span>Role</span>
        </a>
    </li>
    <li class="no-b">
        <a href="{{ route('permission.index') }}">
            <i class="icon icon-clipboard-list2 text-success s-18"></i> <span>Permission</span>
        </a>
    </li>
    @endcan

    @can('master-jenisAset')
    <li class="header light"><strong>JENIS ASET</strong></li>
    <li>
        <a href="{{ route('jenisAset.index')}}">
            <i class="icon icon-document-text3 text-success s-18"></i> <span>Jenis</span>
        </a>
    </li>
    <li>
        <a href="{{ route('rincianJenisAset.index')}}">
            <i class="icon icon-branding_watermark amber-text s-18"></i> <span>Rincian Jenis</span>
        </a>
    </li>
    @endcan

    @can('master-aset')
    <li class="header light"><strong>ASSETS</strong></li>
    <li>
        <a href="{{ route('aset.masuk.index')}}">
            <i class="icon icon-input blue-text s-18"></i> <span>Pendataan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('aset.keluar.index')}}">
            <i class="icon icon-arrow_back red-text s-18"></i><span>Pendistribusian</span>
        </a>
    </li>
    @endcan

    @can('master-income')
    <li class="header light"><strong>PENDAPATAN</strong></li>
    <li>
        <a href="{{ route('pendapatanAset.index')}}">
            <i class="icon icon-money-2 blue-text s-18"></i> <span>Aset<span>
        </a>
    </li>
    <li>
        <a href="{{ route('pendapatanNonAset.index') }}">
            <i class="icon icon-money-1 blue-text s-18"></i> <span>Non Aset</span>
        </a>
    </li>

    <li>
        <a href="#">
            <i class="icon icon-money-1 blue-text s-18"></i> <span>Rincian Aset</span>
        </a>
    </li>

    @endcan


</ul>
