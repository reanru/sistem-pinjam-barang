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

      <div class="alert alert-light alert-has-icon">
        <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
        <div class="alert-body">
          <div class="alert-title">Informasi</div>
          <ul style="margin-left: -20px; margin-bottom: 0px">
            <li>Jika sementara meminjam barang A, tidak dapat meminjam barang yang sama tapi bisa meminjam barang lain.</li>
            <li>Jika sementara meminjam barang A (telah melewati batas peminjaman dan belum dikembalikan), tidak boleh meminjam barang lain.</li>
          </ul> 
        </div>
      </div>

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

  <!-- Modal Add New peminjaman -->
  <div class="modal fade" id="addNewDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="newDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Buat Permintaan</h5>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label>Pengguna <span style="color: red">*</span></label><br>
              <div id="formContainer">
                <select id="pengguna" class="form-control" name="user_id" required=""></select>
              </div>

            </div>

            <div class="form-group">
              <label>No HP  <span style="color: gray; font-size: 10px">(Bisa Diubah) <span style="color: red">*</span></label>
              <input type="text" id="noHp" name="no_hp" class="form-control" required="">
            </div>

            <div class="form-group">
              <label>Barang <span style="color: red">*</span></label><br>
              <select class="form-control" name="barang" required="">
                <option value="">Pilih</option>
                @foreach ($daftarBarang as $item)
                  <option value="{{$item->id}}~{{$item->kode}}~{{$item->nama}}">{{$item->kode}} ~ {{$item->nama}} (Stok : {{$item->stok}})</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Mulai <span style="color: red">*</span></label>
              <input type="date" name="mulai" class="form-control" required="">
            </div>

            <div class="form-group">
              <label>Selesai <span style="color: red">*</span></label>
              <input type="date" name="selesai" class="form-control" required="">
            </div>

            <div class="form-group">
              <label>Keterangan <span style="color: red">*</span></label>
              <textarea type="text" name="deskripsi" class="form-control" required=""></textarea>
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

  <!-- Modal Edit peminjaman -->
  <div class="modal fade" id="editDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="editDataForm">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Status Peminjaman</h5>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning alert-has-icon">
              <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
              <div class="alert-body">
                <div class="alert-title">Informasi</div>
                <span>Status hanya bisa diubah satu kali.</span>
              </div>
            </div>

            <input type="hidden" id="editDataId">
            <div class="form-group">
              <label>Status</label>
              <select id="status" name="status" class="custom-select" required>
                <option value="">Pilih</option>
                <option value="dibatalkan">Dibatalkan</option>
                <option value="selesai">Selesai</option>
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

          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
          { className: "dt-center", targets: [ 0, 1, 2, 3, 4, 5, 6, 7 ] }
        ]
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
            // Hapus elemen Select2 yang ada
            $('#pengguna').select2('destroy').remove();

            // Buat elemen baru
            $('#formContainer').append(`
              <select id="pengguna" class="form-control" name="user_id" required=""></select>
            `);

            // Inisialisasi Select2 lagi
            $('#pengguna').select2({
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
                                  id: `${item.id}~${item.no_hp}`,
                              };
                          })
                      };
                  },
                  // cache: true
              }
            });

            $('#pengguna').on('change', function() {
              var selectedValue = $(this).val();
              console.log("ID kategori yang dipilih:", selectedValue.split("~")[0]);
    
              if(selectedValue){
                $('#noHp').val(selectedValue.split("~")[1]);
              }else{
                $('#noHp').val('');
              }
          });

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
            // console.log('check ', status, ' - ', message, ' - ', html);
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
  
      // /*------------------------------------------ Show modal button edit peminjaman --------------------------------------------*/
      $(document).on('click', '.show-edit-modal', function () {
        $('#editDataModal').modal('show');

        let dataId = $(this).data('id');

        $('#editDataModal').modal('show');

        $('#editDataId').val(dataId);
      });

      // /*------------------------------------------ Edit data peminjaman --------------------------------------------*/ 
      $('#editDataForm').submit(function (e) {
        e.preventDefault();
        $('#confirmEditBtn').html('Menyimpan...');
      
        let dataId = $('#editDataId').val();
        let url = '{{ route('peminjaman-barang.update', ':id') }}'; url = url.replace(':id', dataId);

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
  
  
      $(document).ready(function() {
        $('#pengguna').select2({
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
                                id: `${item.id}~${item.no_hp}`,
                            };
                        })
                    };
                },
                // cache: true
            }
        });
  
        $('#pengguna').on('change', function() {
            var selectedValue = $(this).val();
            console.log("ID kategori yang dipilih:", selectedValue.split("~")[0]);
  
            if(selectedValue){
              $('#noHp').val(selectedValue.split("~")[1]);
            }else{
              $('#noHp').val('');
            }
        });
      });
    });

  </script>
@endpush