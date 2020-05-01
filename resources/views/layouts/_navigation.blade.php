<ul class="sidebar-menu">
    <li class="header"><strong>MAIN NAVIGATION</strong></li>
    <li>
        <a href="{{ route('home') }}">
            <i class="icon icon-sailing-boat-water purple-text s-18"></i> <span>Dashboard</span>
        </a>
    </li>

    @can('petugas-panselnas')
    <li>
        <a href="{{ route('panselnas') }}">
            <i class="icon icon-package blue-text s-18"></i> <span>Pansel</span>
        </a>
    </li>
    @endcan

    @can('petugas-panselnas-admin')
    <li>
        <a href="{{ route('admin.panselnas') }}">
            <i class="icon icon-goals-1 blue-text s-18"></i> <span>Admin Pansel</span>
        </a>
    </li>

    <li class="header light"><strong>Arsip</strong></li>
    <li>
        <a href="{{ route('arsipSetuju') }}">
            <i class="icon icon-check green-text s-18"></i> <span>Disetujui</span>
        </a>
    </li>
    <li>
        <a href="{{ route('arsipTolak') }}">
            <i class="icon icon-ban red-text s-18"></i> <span>Ditolak</span>
        </a>
    </li>
    @endcan

    @can('report-lelang')
    <li class="header light"><strong>Laporan</strong></li>
    <li>
        <a href="{{ route('registrasi.report') }}">
            <i class="icon icon-id-badge text-lime s-18"></i> <span>Registrasi</span>
        </a>
    </li>
    <li>
        <a href="{{ route('seleksi.report') }}">
            <i class="icon icon-list3 amber-text s-18"></i> <span>Lamaran</span>
        </a>
    </li>
    @endcan

    @can('config-lelang_jabatan')
    <li class="header light"><strong>SETUP SELEKSI LAHAN PARKIR</strong></li>
        <li class="treeview" id="menuLelang">
            <a href="#">
                <i class="icon icon-event_seat light-green-text s-18"></i> <span>Lahan Parkir</span> <i class="icon icon-angle-left s-18 pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('lelang.create') }}">
                        <i class="icon icon-add"></i> <span>Tambah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('lelang.index') }}">
                        <i class="icon icon-circle-o"></i> <span>Semua</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="treeview" id="menuPengumuman">
            <a href="#">
                <i class="icon icon-bullhorn orange-text s-18"></i> <span>Pengumuman</span> <i class="icon icon-angle-left s-18 pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('pengumuman.create') }}">
                        <i class="icon icon-add"></i> <span>Tambah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengumuman.index') }}">
                        <i class="icon icon-circle-o"></i> <span>Semua</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview" id="menuContent">
            <a href="#">
            <i class="icon icon-aspect_ratio pink-text s-18"></i> <span>Konten</span> <i class="icon icon-angle-left s-18 pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('content.create') }}">
                        <i class="icon icon-add"></i> <span>Tambah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('content.index') }}">
                        <i class="icon icon-circle-o"></i> <span>Semua</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('agenda.index') }}">
                <i class="icon icon-calendar-o lime-text s-18"></i> <span>Agenda</span>
            </a>
        </li>
        <li>
            <a href="{{ route('album.index') }}">
                <i class="icon icon-album light-green-text s-18"></i> <span>Album</span>
            </a>
        </li>
        <li>
            <a href="{{ route('filedownload.index') }}">
                <i class="icon icon-document-download2 teal-text s-18"></i> <span>File Download</span>
            </a>
        </li>
        <li>
            <a href="{{ route('syarat.index') }}">
                <i class="icon icon-notebook-list2 cyan-text s-18"></i> <span>Persyaratan</span>
            </a>
        </li>
    @endcan

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
                <i class="icon icon-settings2 s-18"></i> <span>Configurasi Instansi</span> <i class="icon icon-angle-left s-18 pull-right"></i>
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
</ul>
