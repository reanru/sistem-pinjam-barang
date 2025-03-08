@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Peminjaman Barang</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Peminjaman Barang</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <button id="showAddModalBtn" type="button" class="btn btn-primary">
                Permintaan <i class="fas fa-plus-square"></i>
              </button>
            </div>
            <div class="card-body p-4">
              <div class="table-responsive">
                <table id="datatable" class="table table-striped table-md">
                  <thead>
                      <tr>
                        <th>No</th>
                        <th>Peminjam</th>
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

  <!-- Modal Add New peminjaman -->
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
              <label>Stok</label><br>
              <select id="category" class="form-control" name="user_id" required=""></select>

            </div>

          </div>
          <div class="modal-footer">
            <button type="button" id="closeAddBtn" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" id="confirmAddBtn" class="btn btn-primary" >Simpan</button>
          </div>
        </form>


      </div>
    </div>
  </div>

  <!-- Modal Delete Jadwal -->
  <div class="modal fade" id="deleteDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Hapus Jadwal</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="deleteDataId">
          Anda yakin akan menghapus?
        </div>
        <div class="modal-footer">
          <button type="button" id="closeDeleteBtn" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-primary">Ya</button>
        </div>
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
        ajax: "{{ route('peminjaman-barang.datatable') }}",
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'nama_user', name: 'nama_user'},
          {data: 'kode_barang', name: 'kode_barang'},
          {data: 'nama_barang', name: 'nama_barang'},
          {data: 'mulai', name: 'mulai'},
          {data: 'selesai', name: 'selesai'},
          {data: 'deskripsi', name: 'deskripsi'},
          {data: 'status', name: 'status'},

          // {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
          { className: "dt-center", targets: [ 0, 1, 2, 3, 4, 5, 6, 7 ] }
        ]
      });

    });

    // /*------------------------------------------ Show modal button add new peminjaman --------------------------------------------*/ 
    $('#showAddModalBtn').click(function () {
      $('#addNewDataModal').modal('show');
    });

    // /*------------------------------------------ Create new peminjaman --------------------------------------------*/ 
    $('#newDataForm').submit(function (e) {
      e.preventDefault();
      $('#confirmAddBtn').html('Menyimpan...');
    
      // disable button while editing
      $("#confirmAddBtn").prop("disabled",true); 
      $("#closeAddBtn").prop("disabled",true);

      $.ajax({
        data: $('#newDataForm').serialize(),
        url: "{{ route('peminjaman-barang.store') }}",
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

    // /*------------------------------------------ Show modal delete peminjaman --------------------------------------------*/ 
    $(document).on('click', '.show-delete-modal', function () {
      $('#deleteDataModal').modal('show');
      $('#deleteDataId').val($(this).data("id"));
    });

    // /*------------------------------------------ Delete data peminjaman --------------------------------------------*/ 
    $('#confirmDeleteBtn').click(function (e) {
      $(this).html('Menghapus...');

      let dataId = $('#deleteDataId').val();
      let url = '{{ route('peminjaman-barang.destroy', ':id') }}'; url = url.replace(':id', dataId);

      // disable button while deleting
      $("#confirmDeleteBtn").prop("disabled",true); 
      $("#closeDeleteBtn").prop("disabled",true);

      $.ajax({
        type: "DELETE",
        url : url,
        success: function (data) {
          $('#deleteDataModal').modal('hide');
          table.ajax.reload();
          Swal.fire({
            title: 'Berhasil',
            text: 'Jadwal berhasil dihapus',
            icon: 'success',
            confirmButtonText: 'OK'
          })
        },
        error: function (data) {
          const { status, message } = data.responseJSON;
          Swal.fire({
            title: 'Terjadi kesalahan',
            text: message,
            icon: 'error',
            confirmButtonText: 'OK'
          })
        },
        complete: function(data) {
          $('#confirmDeleteBtn').html('Ya'); 

          // enable button
          $("#confirmDeleteBtn").prop("disabled",false);
          $("#closeDeleteBtn").prop("disabled",false);
        }
      });
    });


    $(document).ready(function() {
      $('#category').select2({
          width: '100%',
          dropdownParent: $('#addNewDataModal'),
          minimumInputLength: 3,
          placeholder: "Cari nama pengguna...",
          allowClear: true, 
          ajax: {
              url: '/user/search',
              dataType: 'json',
              delay: 250,
              data: function (params) {
                  return {
                      q: params.term
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data, function (item) {
                          return {
                              text: item.name,
                              id: item.id,
                          };
                      })
                  };
              },
              cache: true
          }
      });
      $('#category').on('change', function() {
          var selectedValue = $(this).val();
          console.log("ID kategori yang dipilih:", selectedValue);
      });
  });
  </script>
@endpush