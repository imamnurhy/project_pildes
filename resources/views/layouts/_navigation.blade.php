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

    @can('master-wilayah')
    <li>
        <a href="{{ route('provinsi.index') }}">
            <i class="icon icon-map brown-text"></i> <span>Wilayah</span>
        </a>
    </li>
    @endcan

    <li class="treeview" id="menuConfigInstansi">
        <a href="{{ route('pegawai.index') }}">
            <i class="icon icon-settings2 s-18"></i> <span>Configurasi Instansi</span> <i
                class="icon icon-angle-left s-18 pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('rumpun.index') }}">
                    <i class="icon icon-account_balance"></i> <span>Rumpun</span>
                </a>
            </li>
            <li>
                <a href="{{ route('opd.index') }}">
                    <i class="icon icon-building-o"></i> <span>OPD</span>
                </a>
            </li>
            <li>
                <a href="{{ route('unitkerja.index') }}">
                    <i class="icon icon-sitemap"></i> <span>Unit Kerja</span>
                </a>
            </li>
            <li>
                <a href="{{ route('golongan.index') }}">
                    <i class="icon icon-chess"></i> <span>Golongan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('eselon.index') }}">
                    <i class="icon icon-surround_sound"></i> <span>Eselon</span>
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
            <i class="icon icon-input blue-text s-18"></i> <span>Masuk</span>
        </a>
    </li>
    <li>
        <a href="{{ route('aset.keluar.index')}}">
            <i class="icon icon-arrow_back red-text s-18"></i> <span>Keluar</span>
        </a>
    </li>
    @endcan
</ul>
