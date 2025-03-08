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
                <i class="fas fa-history"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Riwayat Peminjaman</h4>
                </div>
                <div class="card-body">
                    {{ $countRiwayatPeminjamanBarang ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>