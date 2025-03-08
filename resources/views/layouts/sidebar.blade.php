<aside>
    <div class="sidebar-brand">
        <a href="index.html">Sistem Pinjam Barang</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">SPB</a>
    </div>
    <ul class="sidebar-menu">
        <li class="{{ request()->segment(1) == '' ? 'active' : '' }}"><a class="nav-link" href="{{ route('home') }}"><i class="fas fa-th-large"></i> <span>Dashboard</span></a></li>
        @if(Auth::user()->role == 'admin')

            <li class="{{ request()->segment(1) == 'pengguna' ? 'active' : '' }}"><a class="nav-link" href="{{ route('pengguna.index') }}"><i class="fas fa-square"></i> <span>Pengguna</span></a></li>
            <li class="{{ request()->segment(1) == 'barang' ? 'active' : '' }}"><a class="nav-link" href="{{ route('barang.index') }}"><i class="fas fa-square"></i> <span>Barang</span></a></li>

        @endif

        @if(Auth::user()->role == 'pengguna')

            <li class="{{ request()->segment(1) == 'daftar-barang' ? 'active' : '' }}"><a class="nav-link" href="{{ route('daftar-barang.index') }}"><i class="fas fa-square"></i> <span>Daftar Barang</span></a></li>
            <li class="{{ request()->segment(1) == 'riwayat-peminjaman' ? 'active' : '' }}"><a class="nav-link" href="{{ route('riwayat-peminjaman.index') }}"><i class="fas fa-square"></i> <span>Riwayat Peminjaman</span></a></li>

        @endif

        <li class="{{ request()->segment(1) == 'pengaturan' ? 'active' : '' }}"><a class="nav-link" href="{{ route('pengaturan.index') }}"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
    </ul> 
</aside>