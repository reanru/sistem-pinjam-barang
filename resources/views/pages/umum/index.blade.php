<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Layout &rsaquo; Top Navigation &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">


  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>

<!-- /END GA --></head>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg" style="height: 80px; z-index: 99999" ></div>
      <nav class="navbar navbar-expand-lg main-navbar" style="height: 80px; z-index: 99999">
        <a href="index.html" class="navbar-brand sidebar-gone-hide">SISTEM PINJAM BARANG</a>
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        <form class="form-inline ml-auto">
          <ul class="navbar-nav">
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>

        </form>
        <button id="showAddModalBtn" type="button" class="btn btn-secondary">
          Masuk
        </button>
      </nav>



      <!-- Main Content -->
      <div class="main-content" >
        <section class="section">
          <div class="row">
            @foreach ($barang as $item)
              <div class="col-12 col-md-4 col-lg-4">
                <div class="pricing pricing-highlight">
                  <div class="pricing-title">
                    {{$item->kode ?? '-'}}
                  </div>
                  <div class="pricing-padding">
                    <div class="pricing-price">
                      {{-- <div>$60</div> --}}
                      <h4>{{$item->nama ?? '-'}}</h4>
                    </div>
                    <div class="pricing-details">
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Stok : {{$item->stok ?? '-'}}</div>
                      </div>
                      <div class="pricing-item">
                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                        <div class="pricing-item-label">Status : {{$item->status ?? '-'}}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </section>
      </div>
      {{-- <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer> --}}
    </div>
  </div>

  <div class="modal fade" id="addNewDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Barang</h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" tabindex="1" placeholder="Masukan Email" required autofocus>
            </div>
            <div class="form-group">
              <div class="d-block">
                <label for="password" class="control-label">Password</label>
              </div>
              <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Masukan Password" required>
            </div>
            <input type="hidden" class="form-control @error('username') is-invalid @enderror" tabindex="1">
            @error('email')
              <div class="text-center mt-4 mb-3">
                <div class="text-job text-muted">Email / Password salah.</div>
              </div>
            @enderror  
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                Masuk
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
      $(function () {
          /*------------------------------------------ Pass Header Token --------------------------------------------*/ 
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
      });
  </script>

  <script>
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
    url: "{{ route('login-baru') }}",
    type: "POST",
    dataType: 'json',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json' // ⬅️ penting untuk mencegah redirect
    },
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
</script>

</body>
</html>