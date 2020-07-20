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
                    <i class="icon icon-building-o"></i> <span>OPD</span>
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



    @can('master-brand')
    <li class="header light"><strong>MASTER</strong></li>
    <li>
        <a href="{{ route('brand.index')}}">
            <i class="icon icon-branding_watermark amber-text s-18"></i> <span>Merek</span>
        </a>
    </li>
    <li>
        <a href="{{ route('jenis.index')}}">
            <i class="icon icon-document-text3 text-success s-18"></i> <span>Jenis</span>
        </a>
    </li>
    @endcan

    @can('master-aset')
    <li class="header light"><strong>ASSETS</strong></li>
    <li>
        <a href="{{ route('aset.masuk.index')}}">
            <i class="icon icon-input blue-text s-18"></i> <span>Barang</span>
        </a>
    </li>
    <li>
        <a href="{{ route('aset.keluar.index')}}">
            <i class="icon icon-arrow_back red-text s-18"></i> <span>OPD</span>
        </a>
    </li>
    @endcan

    @can('master-pertanyaan')
    <li class="header light"><strong>MASTER-PERTANYAAN</strong></li>
    <li>
        <a href="{{ route('pertanyaan.index')}}">
            <i class="icon icon-comments-o blue-text s-18"></i> <span>Pertanyaan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('jenis_pertanyaan.index')}}">
            <i class="icon icon-merge_type green-text s-18"></i> <span>Jenis Pertanyaan</span>
        </a>
    </li>
    @endcan

    @can('master-user-pertanyaan')
    <li class="header light"><strong>MASTER-USER-PERTANYAAN</strong></li>
    <li>
        <a href="{{ route('pertanyaanMasuk.index') }}">
            <i class="icon icon-input red-text s-18"></i> <span>Pertanyaan Masuk</span>
        </a>
    </li>
    @endcan
</ul>