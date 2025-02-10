<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css" rel="stylesheet') }}" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
     <!-- Favicons -->
  <link href="{{ asset('assets/landingpages/img/iconWebsite.png') }}" rel="icon">
  <link href="{{ asset('assets/landingpages/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>Monitoring Perpustakaan</title>
  </head>

  <body style=" background: linear-gradient(to right, #FFD54F, #82B1FF);">

    <div class="container">

            <div class="card card-custom mt-3">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                        <h2 class="text-dark-75 text-center ">Monitoring Perpustakaan </h2>
                        <p class="text-dark-50 text-center">Menampilkan Data Perpustakaan seacara realtime termasuk jumlah anggota,jumlah buku dan jumlah buku yang dipinjam.</p>
                    </div>
                </div>
            </div>





            <div class="row row-cols-4">
                <div class="col">
                  <div class="card radius-10 overflow-hidden shadow">
                      <div class="card-body">
                          <div class="d-flex align-items-center">
                              <div>
                                  <p class="mb-0 text-muted">Total Buku</p>
                                  <h5 class="mb-0 text-primary" x-text="totalBuku">56</h5>
                              </div>
                              <div class="ms-auto">
                                  <i class='bx bx-book font-30 text-primary'></i>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col">
                  <div class="card radius-10 overflow-hidden shadow">
                      <div class="card-body">
                          <div class="d-flex align-items-center">
                              <div>
                                  <p class="mb-0 text-muted">Buku Dipinjam</p>
                                  <h5 class="mb-0 text-warning" x-text="totalBukuDipinjam">33</h5>
                              </div>
                              <div class="ms-auto">
                                  <i class='bx bx-bookmark font-30 text-warning'></i>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col">
                  <div class="card radius-10 overflow-hidden shadow">
                      <div class="card-body">
                          <div class="d-flex align-items-center">
                              <div>
                                  <p class="mb-0 text-muted">Anggota Perpustakaan</p>
                                  <h5 class="mb-0 text-success" x-text="totalAnggota">111</h5>
                              </div>
                              <div class="ms-auto">
                                  <i class='bx bx-user font-30 text-success'></i>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col">
                  <div class="card radius-10 overflow-hidden shadow bg-dark text-white">
                      <div class="card-body">
                          <div class="d-flex align-items-center">
                              <div>
                                  <p class="mb-0 " id="date">Loading...</p>
                                  <h5 class="mb-0 text-white" id="time">Loading...</h5>
                              </div>
                              <div class="ms-auto">
                                  <i class='bx bx-time font-30 text-white animated-icon'></i>
                              </div>
                              <style>
                                  @keyframes pulse {
                                      0% { transform: scale(1); opacity: 1; }
                                      50% { transform: scale(1.2); opacity: 0.7; }
                                      100% { transform: scale(1); opacity: 1; }
                                  }
                                  .animated-icon {
                                      display: inline-block;
                                      animation: pulse 1.5s infinite ease-in-out;
                                  }
                              </style>
                          </div>
                      </div>
                  </div>

                  <script>
                      function updateDateTime() {
                          const now = new Date();
                          const formattedDate = now.toLocaleDateString('id-ID', {
                              weekday: 'long',
                              year: 'numeric',
                              month: 'long',
                              day: 'numeric'
                          });
                          const formattedTime = now.toLocaleTimeString('id-ID', {
                              hour: '2-digit',
                              minute: '2-digit',
                              second: '2-digit'
                          });
                          document.getElementById("date").textContent = formattedDate;
                          document.getElementById("time").textContent = formattedTime;
                      }
                      setInterval(updateDateTime, 1000);
                      updateDateTime();
                  </script>
                </div>
              </div>


            <div class="card shadow-lg rounded-3">
                <h5 class="text-start p-3 bg-info text-white rounded-top">Data Pengunjung</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengunjung</th>
                                    <th>Asal Pengunjung</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Hadiid Andri Yulison</td>
                                    <td>Surabaya</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>John Doe</td>
                                    <td>Surabaya</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Jane Smith</td>
                                    <td>Jakarta</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Michael Johnson</td>
                                    <td>Bandung</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Daftar Buku Baru -->
                <div class="col-md-6 mb-4">
                <div class="card radius-10 shadow">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 bg-warning p-2 rounded">
                        <h5 class="mb-0" style="color: whitesmoke">📚 Daftar Buku Baru</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                            <th>ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>#00123</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/world-forest-day-poster-template_23-2148899237.jpg?t=st=1731925544~exp=1731929144~hmac=711d15902982d45c05803ef012b2274f024d9fe3b39d578a776db3e3439c81f3&w=740"
                                    alt="Buku 1" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Pengantar Teknologi Informasi</h6>
                                </div>
                                </div>
                            </td>
                            <td>John Doe</td>
                            <td>14 Nov, 2024</td>
                            </tr>
                            <tr>
                            <td>#00124</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/flat-design-halloween-celebration-poster-template_23-2149619067.jpg?t=st=1731925618~exp=1731929218~hmac=348a21d3b1134559fd438b63f915e180c3e747eaa467aad0065973b7253f6b50&w=740"
                                    alt="Buku 2" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Dasar Pemrograman</h6>
                                </div>
                                </div>
                            </td>
                            <td>Jane Smith</td>
                            <td>14 Nov, 2024</td>
                            </tr>
                            <tr>
                            <td>#00124</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/flat-design-halloween-celebration-poster-template_23-2149619067.jpg?t=st=1731925618~exp=1731929218~hmac=348a21d3b1134559fd438b63f915e180c3e747eaa467aad0065973b7253f6b50&w=740"
                                    alt="Buku 2" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Dasar Pemrograman</h6>
                                </div>
                                </div>
                            </td>
                            <td>Jane Smith</td>
                            <td>14 Nov, 2024</td>
                            </tr>
                            <tr>
                            <td>#00124</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/flat-design-halloween-celebration-poster-template_23-2149619067.jpg?t=st=1731925618~exp=1731929218~hmac=348a21d3b1134559fd438b63f915e180c3e747eaa467aad0065973b7253f6b50&w=740"
                                    alt="Buku 2" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Dasar Pemrograman</h6>
                                </div>
                                </div>
                            </td>
                            <td>Jane Smith</td>
                            <td>14 Nov, 2024</td>
                            </tr>
                            <tr>
                            <td>#00124</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/flat-design-halloween-celebration-poster-template_23-2149619067.jpg?t=st=1731925618~exp=1731929218~hmac=348a21d3b1134559fd438b63f915e180c3e747eaa467aad0065973b7253f6b50&w=740"
                                    alt="Buku 2" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Dasar Pemrograman</h6>
                                </div>
                                </div>
                            </td>
                            <td>Jane Smith</td>
                            <td>14 Nov, 2024</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Buku Dipinjam atau Dikembalikan -->
                <div class="col-md-6">
                <div class="card radius-10 shadow">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 bg-success p-2 rounded">
                        <h5 class="mb-0" style="color: white">📖 Buku Dipinjam atau Dikembalikan</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                            <th>ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>#00112</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/flat-design-halloween-celebration-poster-template_23-2149619067.jpg?t=st=1731925618~exp=1731929218~hmac=348a21d3b1134559fd438b63f915e180c3e747eaa467aad0065973b7253f6b50&w=740"
                                    alt="Buku 3" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Algoritma dan Pemrograman</h6>
                                </div>
                                </div>
                            </td>
                            <td>Ucok Saepudin</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                            </tr>
                            <tr>
                            <td>#00115</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/world-forest-day-poster-template_23-2148899237.jpg?t=st=1731925544~exp=1731929144~hmac=711d15902982d45c05803ef012b2274f024d9fe3b39d578a776db3e3439c81f3&w=740"
                                    alt="Buku 4" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Basis Data Lanjut</h6>
                                </div>
                                </div>
                            </td>
                            <td>Ucok Saepudin</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                            </tr>
                            <tr>
                            <td>#00112</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/flat-design-halloween-celebration-poster-template_23-2149619067.jpg?t=st=1731925618~exp=1731929218~hmac=348a21d3b1134559fd438b63f915e180c3e747eaa467aad0065973b7253f6b50&w=740"
                                    alt="Buku 3" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Algoritma dan Pemrograman</h6>
                                </div>
                                </div>
                            </td>
                            <td>Ucok Saepudin</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                            </tr>
                            <tr>
                            <td>#00115</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/world-forest-day-poster-template_23-2148899237.jpg?t=st=1731925544~exp=1731929144~hmac=711d15902982d45c05803ef012b2274f024d9fe3b39d578a776db3e3439c81f3&w=740"
                                    alt="Buku 4" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Basis Data Lanjut</h6>
                                </div>
                                </div>
                            </td>
                            <td>Ucok Saepudin</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                            </tr>
                            <tr>
                            <td>#00115</td>
                            <td>
                                <div class="d-flex align-items-center">
                                <img src="https://img.freepik.com/free-psd/world-forest-day-poster-template_23-2148899237.jpg?t=st=1731925544~exp=1731929144~hmac=711d15902982d45c05803ef012b2274f024d9fe3b39d578a776db3e3439c81f3&w=740"
                                    alt="Buku 4" class="rounded" width="40">
                                <div class="ms-3">
                                    <h6 class="mb-1">Basis Data Lanjut</h6>
                                </div>
                                </div>
                            </td>
                            <td>Ucok Saepudin</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>
            </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
