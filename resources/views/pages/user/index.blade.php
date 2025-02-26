@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Daftar Anggota Jemaat</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Daftar Anggota Jemaat</div>
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
                        <th>Name</th>
                        <th>Email / No HP</th>
                        <th>Kolom</th>
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

  <!-- Modal Add New user -->
  <div class="modal fade" id="addNewDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="newDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Anggota Jemaat</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="name" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Kolom</label>
              <input type="number" name="kolom" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Email / No HP</label>
              <input type="text" name="email" class="form-control" required="">
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

  <!-- Modal Edit user -->
  <div class="modal fade" id="editDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="editDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Anggota Jemaat</h5>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editDataId">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" id="name" name="name" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Kolom</label>
              <input type="number" id="kolom" name="kolom" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Email / No HP</label>
              <input type="text" id="email" name="email" class="form-control" required="">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" id="password" name="password" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="closeEditBtn" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" id="confirmEditBtn" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Detail user -->
  <div class="modal fade" id="detailDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="editDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Jemaat</h5>
          </div>
          <div class="modal-body">

            <div class="row justify-content-center">
              <div class="col-12 col-md-12">
                
                <div class="row">      
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom: 15px;">
                      <div class="" style="font-weight: bold">Nama</div>
                      <span id="detail_name"></span>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom: 15px;">
                      <div class="" style="font-weight: bold">Email</div>
                      <span id="detail_email"></span>
                    </div>
                  </div>
                </div>

                <div class="row">      
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom: 15px;">
                      <div class="" style="font-weight: bold">Kolom</div>
                      <span id="detail_kolom"></span>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom: 15px;">
                      <div class="" style="font-weight: bold">Umur</div>
                      <span id="detail_umur"></span>
                    </div>
                  </div>
                </div>

                <div class="row">      
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom: 15px;">
                      <div class="" style="font-weight: bold">Pekerjaan</div>
                      <span id="detail_pekerjaan"></span>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom: 15px;">
                      <div class="" style="font-weight: bold">Jenis Kelamin</div>
                      <span id="detail_jenis_kelamin"></span>
                    </div>
                  </div>
                </div>

                <div class="row">      
                  <div class="col-md-6 col-12">
                    <div class="" style="padding-top: 15px; padding-bottom:">
                      <div class="" style="font-weight: bold">Status Pernikahan</div>
                      <span id="detail_status_pernikahan"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" id="closeEditBtn" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
        ajax: "{{ route('anggota-jemaat.datatable') }}",
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'name', name: 'name'},
          {data: 'email', name: 'email'},
          {data: 'kolom', name: 'kolom'},

          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
          { className: "dt-center", targets: [ 0, 1, 2, 3, 4 ] }
        ]
      });

      // /*------------------------------------------ Show modal button add new user --------------------------------------------*/ 
      $('#showAddModalBtn').click(function () {
        $('#addNewDataModal').modal('show');
      });

      // /*------------------------------------------ Create new user --------------------------------------------*/ 
      $('#newDataForm').submit(function (e) {
        e.preventDefault();
        $('#confirmAddBtn').html('Menyimpan...');
      
        // disable button while editing
        $("#confirmAddBtn").prop("disabled",true); 
        $("#closeAddBtn").prop("disabled",true);

        $.ajax({
          data: $('#newDataForm').serialize(),
          url: "{{ route('anggota-jemaat.store') }}",
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

      // /*------------------------------------------ Show modal button edit user --------------------------------------------*/
      $(document).on('click', '.show-edit-modal', function () {
        $('#editDataModal').modal('show');

        let dataId = $(this).data('id');
        let name = $(this).data('name');
        let kolom = $(this).data('kolom');
        let email = $(this).data('email');

        $('#editDataModal').modal('show');

        $('#editDataId').val(dataId);
        $('#name').val(name);
        $('#kolom').val(kolom);
        $('#email').val(email);
      });

      // /*------------------------------------------ Edit data user --------------------------------------------*/ 
      $('#editDataForm').submit(function (e) {
        e.preventDefault();
        $('#confirmEditBtn').html('Menyimpan...');
      
        let dataId = $('#editDataId').val();
        let url = '{{ route('anggota-jemaat.update', ':id') }}'; url = url.replace(':id', dataId);

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

        // /*------------------------------------------ Show modal button detail user --------------------------------------------*/
        $(document).on('click', '.show-detail-modal', function () {
        $('#detailDataModal').modal('show');

        let name = $(this).data('name');
        let email = $(this).data('email');
        let kolom = $(this).data('kolom');
        let umur = $(this).data('umur');
        let pekerjaan = $(this).data('pekerjaan');
        let jenis_kelamin = $(this).data('jenis_kelamin');
        let status_pernikahan = $(this).data('status_pernikahan');

        $('#detailDataModal').modal('show');

          console.log('check ', pekerjaan, umur);
          

        $('#detail_name').text(name ?? '');
        $('#detail_email').text(email ?? '');
        $('#detail_kolom').text(kolom ?? '');
        $('#detail_umur').text(umur ?? '');
        $('#detail_pekerjaan').text(pekerjaan ?? '');
        $('#detail_jenis_kelamin').text(jenis_kelamin === 'L' ? 'Laki-laki' : jenis_kelamin === 'P' ? 'Perempuan' : '');
        $('#detail_status_pernikahan').text(status_pernikahan === 'menikah' ? 'Menikah' : status_pernikahan === 'belum_menikah' ? 'Belum Menikah' : '');
      });

    });
  </script>
@endpush