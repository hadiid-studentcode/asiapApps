@extends('layouts.main')


@push('css')
    <link href="{{ asset('assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-content" x-data="alpineData">

        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
            <div class="col">
            <div class="card radius-10 overflow-hidden shadow">
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                    <p class="mb-0 text-muted">Total Buku</p>
                    <h5 class="mb-0 text-primary" x-text="totalBuku"></h5>
                    </div>
                    <div class="ms-auto"> <i class='bx bx-book font-30 text-primary'></i> </div>
                </div>
                </div>
                {{-- <div class="" id="chart4"></div> --}}
            </div>
            </div>
            <div class="col">
            <div class="card radius-10 overflow-hidden shadow">
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                    <p class="mb-0 text-muted">Buku Dipinjam</p>
                    <h5 class="mb-0 text-warning" x-text="totalBukuDipinjam"></h5>
                    </div>
                    <div class="ms-auto"> <i class='bx bx-bookmark font-30 text-warning'></i> </div>
                </div>
                </div>
                {{-- <div class="" id="chart2"></div> --}}
            </div>
            </div>

            <div class="col">
            <div class="card radius-10 overflow-hidden shadow">
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                    <p class="mb-0 text-muted">Anggota Perpustakaan</p>
                    <h5 class="mb-0 text-success" x-text="totalAnggota"></h5>
                    </div>
                    <div class="ms-auto"> <i class='bx bx-user font-30 text-success'></i> </div>
                </div>
                </div>
                <div class="" id="chart3"></div>
            </div>
            </div>
        </div>



        <div class="card">
            <h5 class="text-start p-3" style="margin-bottom: -2vh">Data Pengunjung </h5>
            <hr>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">📚 Daftar Buku Baru</h5>
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">📖 Buku Dipinjam atau Dikembalikan</h5>
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
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/exporting.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/variable-pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/export-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/index2.js') }}"></script> --}}

    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                totalBuku: 0,
                totalBukuDipinjam: 0,
                totalAnggota: 0,

                init() {
                    this.startPolling(); // Mulai polling data

                },
                startPolling() {

                    window.addEventListener('load', () => {
                        setInterval(async () => {
                            await this.getDataDashboard();
                        }, 5000);
                    });




                },

                async getDataDashboard() {
                    try {
                        const [resTotalBuku, resTotalBukuDipinjam, resTotalAnggota] = await Promise
                            .all([
                                axios.get('{{ route('totalBuku') }}'),
                                axios.get('{{ route('totalBukuDipinjam') }}'),
                                axios.get('{{ route('totalAnggota') }}')
                            ]);

                        this.totalBuku = resTotalBuku.data.totalBuku;
                        this.totalBukuDipinjam = resTotalBukuDipinjam.data.totalBukuDipinjam;
                        this.totalAnggota = resTotalAnggota.data.totalAnggota;
                    } catch (error) {
                        console.error('Error fetching dashboard data:', error);
                    }
                }
            }))
        })
    </script>
@endpush
