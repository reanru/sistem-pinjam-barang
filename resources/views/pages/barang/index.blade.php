@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Daftar Barang</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Daftar Barang</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <button id="showAddModalBtn" type="button" class="btn btn-primary">
                Tambah <i class="fas fa-plus-square"></i>
              </button>
            </div>
            <div class="card-body p-4">
              <div class="table-responsive">
                <table id="datatable" class="table table-striped table-md">
                  <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>#</th>
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

  <!-- Modal Add New barang -->
  <div class="modal fade" id="addNewDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="newDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Barang</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" name="kode" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" required="">
            </div>
            <div class="text-right">
              <button type="button" id="closeEditBtn" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" id="confirmEditBtn" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Edit barang -->
  <div class="modal fade" id="editDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="editDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Barang</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editDataId">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" id="kode" name="kode" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" id="nama" name="nama" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Stok</label>
              <input type="number" id="stok" name="stok" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Status</label>
              <select id="status" name="status" class="custom-select" required>
                <option value="">Pilih</option>
                <option value="aktif">Aktif</option>
                <option value="tidak-aktif">Tidak Aktif</option>
              </select>
            </div>
            <div class="text-right">
              <button type="button" id="closeEditBtn" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" id="confirmEditBtn" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

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
        ajax: "{{ route('barang.datatable') }}",
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'kode', name: 'kode'},
          {data: 'nama', name: 'nama'},
          {data: 'stok', name: 'stok'},
          {data: 'status', name: 'status'},

          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
          { className: "dt-center", targets: [ 0, 1, 2, 3, 4, 5 ] }
        ]
      });

      // /*------------------------------------------ Show modal button add new barang --------------------------------------------*/ 
      $('#showAddModalBtn').click(function () {
        $('#addNewDataModal').modal('show');
      });

      // /*------------------------------------------ Create new barang --------------------------------------------*/ 
      $('#newDataForm').submit(function (e) {
        e.preventDefault();
        $('#confirmAddBtn').html('Menyimpan...');
      
        // disable button while editing
        $("#confirmAddBtn").prop("disabled",true); 
        $("#closeAddBtn").prop("disabled",true);

        $.ajax({
          data: $('#newDataForm').serialize(),
          url: "{{ route('barang.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            $('#newDataForm').trigger("reset");
            $('#addNewDataModal').modal('hide');
            table.ajax.reload();
            Swal.fire({
              title: 'Berhasil',
              text: 'Data berhasil disimpan',
              icon: 'success',
              confirmButtonText: 'OK'
            })
          },
          error: function (data) {
            let html = "";
            const { status, message } = data.responseJSON;

            for (const key in message) {
              html += `<p style="">${message[key]}</p>`
            }
            Swal.fire({
              title: 'Terjadi kesalahan',
              html: status === 'validation error' ? html : message,
              icon: status === 'validation error' || status === 'warning' ? 'warning' : 'error',
              confirmButtonText: 'OK'
            })
          },
          complete: function(data) {
            $('#confirmAddBtn').html('Simpan');

            // enable button
            $("#confirmAddBtn").prop("disabled",false); 
            $("#closeAddBtn").prop("disabled",false);
          }
        });
      });

      // /*------------------------------------------ Show modal button edit barang --------------------------------------------*/
      $(document).on('click', '.show-edit-modal', function () {
        $('#editDataModal').modal('show');

        let dataId = $(this).data('id');
        let kode = $(this).data('kode');
        let nama = $(this).data('nama');
        let stok = $(this).data('stok');
        let status = $(this).data('status');

        $('#editDataModal').modal('show');

        $('#editDataId').val(dataId);
        $('#kode').val(kode);
        $('#nama').val(nama);
        $('#stok').val(stok);
        $('#status').val(status);
      });

      // /*------------------------------------------ Edit data barang --------------------------------------------*/ 
      $('#editDataForm').submit(function (e) {
        e.preventDefault();
        $('#confirmEditBtn').html('Menyimpan...');
      
        let dataId = $('#editDataId').val();
        let url = '{{ route('barang.update', ':id') }}'; url = url.replace(':id', dataId);

        // disable button while editing
        $("#confirmEditBtn").prop("disabled",true); 
        $("#closeEditBtn").prop("disabled",true);

        $.ajax({
          data: $('#editDataForm').serialize(),
          url: url,
          type: "PUT",
          dataType: 'json',
          success: function (data) {
            $('#editDataForm').trigger("reset");
            $('#editDataModal').modal('hide');
            table.ajax.reload();
            Swal.fire({
              title: 'Berhasil',
              text: 'Berhasil disimpan',
              icon: 'success',
              confirmButtonText: 'OK'
            })
          },
          error: function (data) {
            let html = "";
            const { status, message } = data.responseJSON;

            for (const key in message) {
              html += `<p style="">${message[key]}</p>`
            }
            Swal.fire({
              title: 'Terjadi kesalahan',
              html: status === 'validation error' ? html : message,
              icon: status === 'validation error' || status === 'warning' ? 'warning' : 'error',
              confirmButtonText: 'OK'
            })
          },
          complete: function(data) {
            $('#confirmEditBtn').html('Simpan');

            // enable button
            $("#confirmEditBtn").prop("disabled",false); 
            $("#closeEditBtn").prop("disabled",false);
          }
        });
      });

    });
  </script>
@endpush