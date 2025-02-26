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

        @endif

    </ul> 
</aside>