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

<div class="row">
    <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <section class="section">
                            <div class="section-body" style="width: 100%; height: 100%; max-width: 600px; max-height: 600px;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>

        // console.log('check, ', @json($stokBarang));
        let stokBarang = @json($stokBarang)

        // const colors = ['#F0F8FF','#FAEBD7','#00FFFF','#7FFFD4','#DEB887','#5F9EA0','#A9A9A9','#BDB76B','#8FBC8F','#DCDCDC','#DAA520','#ADFF2F','#F0E68C',
        //     '#ADD8E6','#FAFAD2','#D3D3D3','#90EE90','#FFB6C1','#FFA07A','#87CEFA','#FAF0E6','#66CDAA','#FFE4B5','#EEE8AA','#98FB98','#AFEEEE','#FFDAB9',
        //     '#FFC0CB','#B0E0E6','#F5F5F5'];

        const dataPie = {
            labels: stokBarang?.map(data=>{return data.nama}),
            datasets: [{
                label: 'Stok',
                // backgroundColor: colors,
                // borderColor: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
                data: stokBarang?.map(data=>{return data.stok}),
            }]
        };

        const configPie = {
            type: 'pie',
            data: dataPie,
            options: {
                plugins: {
                    legend: {
                        position: 'bottom', // Mengubah posisi legenda ke kanan
                        labels: {
                            boxWidth: 15, // Ukuran kotak warna pada legend
                            maxHeight: 200, // Maksimum tinggi legend
                        }
                    },
                    title: {
                        display: true, // Menampilkan judul
                        text: 'Stok Barang', // Teks judul
                        align: 'start',
                        font: {
                            size: 15 // Ukuran font judul
                        },
                        color: 'gray', // Warna teks
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            }
        };
        
        const myChart = new Chart(
            document.getElementById('myChart'),
            configPie
        );
    </script>
@endpush