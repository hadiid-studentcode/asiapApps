@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-content">
        <div class="">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                        <h2 class="text-dark-75 text-center ">Riwayat Peminjaman </h2>
                        <p class="text-dark-50 text-center">Riwayat peminjaman buku diperpustakaan</p>
                    </div>
                </div>
            </div>
        </div>



        <div class="card">


            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">  <!-- id id="example" Dihapus meruasak tampilan tabel -->
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center" style="width:40%;">Buku</th>
                                <th class="text-center">Peminjam</th>
                                <th class="text-center">Tanggal Peminjaman</th>
                               
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th class="text-center">1</th>
                                <td></td>
                                <td></td>
                                <td></td>
                               
                            </tr>




                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush
