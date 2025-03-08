@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Riwayat Peminjaman</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Riwayat Peminjaman</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body p-4">
              <div class="table-responsive">
                <table id="datatable" class="table table-striped table-md">
                  <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                      </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script>
    $(function () {

      /*------------------------------------------ Render DataTable --------------------------------------------*/ 
      let table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        autoWidth: false,
        ajax: "{{ route('riwayat-peminjaman.datatable') }}",
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'kode_barang', name: 'kode_barang'},
          {data: 'nama_barang', name: 'nama_barang'},
          {data: 'mulai', name: 'mulai'},
          {data: 'selesai', name: 'selesai'},
          {data: 'deskripsi', name: 'deskripsi'},
          {data: 'status', name: 'status'},

          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
          { className: "dt-center", targets: [ 0, 1, 2, 3, 4, 5, 6 ] }
        ]
      });

    });
  </script>
@endpush