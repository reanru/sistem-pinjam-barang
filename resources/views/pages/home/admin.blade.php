<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <strong>Dashboard</strong>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-list"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Barang</h4>
                </div>
                <div class="card-body">
                    {{ $countBarang ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Pengguna</h4>
                </div>
                <div class="card-body">
                    {{ $countUser ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-history"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Barang Sementara Dipinjam</h4>
                </div>
                <div class="card-body">
                    {{ $countRiwayatPeminjamanBarangSementara ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-history"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Barang Selesai Dipinjam</h4>
                </div>
                <div class="card-body">
                    {{ $countRiwayatPeminjamanBarangSelesai ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-history"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Peminjaman Dibatalkan</h4>
                </div>
                <div class="card-body">
                    {{ $countRiwayatPeminjamanBarangDibatalkan ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>