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

    @can('configurasi')
    <li class="header light"><strong>CONFIGURASI</strong></li>
    <li>
        <a href="{{ route('config.layanan.index')}}">
            <i class="icon icon-notebook-list red-text s-18"></i> <span>Layanan</span>
        </a>
    </li>
    @endcan

    @can('pelanggan')
    <li class="header light"><strong>PELANGGAN</strong></li>
    <li>
        <a href="{{ route('pelanggan.index')}}">
            <i class="icon icon-user-o blue-text s-18"></i> <span>Pelanggan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('pembayaran.index')}}">
            <i class="icon  icon-payment red-text s-18"></i> <span>Pembayaran</span>
        </a>
    </li>
    <li>
        <a href="{{ route('registrasi.index')}}">
            <i class="icon  icon-notebook-list red-text s-18"></i> <span>Waiting list</span>
        </a>
    </li>
    @endcan
</ul>
