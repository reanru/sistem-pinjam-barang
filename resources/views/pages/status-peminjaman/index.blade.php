@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Status Peminjaman</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Status Peminjaman</a></div>
                <div class="breadcrumb-item">Pengaturan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-8">
                    
                    <div class="card">
                        <div class="card-body p-4">

                            @if(count($daftarPeminjaman) <= 0 )
                                <div class="alert alert-warning alert-has-icon">
                                    <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Informasi</div>
                                        <span>Tidak ada barang yang sementara dipinjam.</span>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-light alert-has-icon">
                                    <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Informasi</div>
                                        <ul style="margin-left: -20px; margin-bottom: 0px">
                                            <li>Saat ini ada barang yang sementara dipinjam.</li>
                                            <li>Anda tidak dapat meminjam barang yang sama.</li>
                                        </ul> 
                                    </div>
                                </div>

                                @if($cekKadaluarsa > 0)
                                    <div class="alert alert-warning alert-has-icon">
                                        <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
                                        <div class="alert-body">
                                            <div class="alert-title">Informasi</div>
                                            <span>Belum bisa melakukan peminjaman karena salah satu barang yg dipinjam telah melewati batas waktu.</span>
                                        </div>
                                    </div>
                                @endif


                                <hr>

                                <h5>Daftar Barang Dipinjam : </h5>

                                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                    @foreach ($daftarPeminjaman as $item)
                                        <li class="media">
                                            <div class="media-body">
                                                @if($item->kadaluarsa)
                                                    <div class="media-right"><h6><span class="badge badge-warning">Kadaluarsa</span></h6></div>
                                                @endif
                                                <div class="media-title mb-1">{{$item?->nama_barang ?? '-'}}</div>
                                                <div class="text-time">Kode Barang : {{$item?->kode_barang ?? '-'}}</div>
                                                <div class="media-description text-muted">{{$item?->deskripsi ?? '-'}}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection