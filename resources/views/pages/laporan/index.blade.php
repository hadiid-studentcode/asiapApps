@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.1/b-3.2.0/b-html5-3.2.0/datatables.min.css"
        rel="stylesheet">
@endpush


@section('content')
    <div class="page-content">

        @include('components.alertsComponents')


        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <h2 class="text-dark-75 text-center">Pengelolaan Cetak Data Sirkulasi Buku</h2>
                    <p class="text-dark-50 text-center">Silahkan atur data sirkulasi untuk Mencetak data sesuai yang telah
                        anda pilih</p>
                </div>
            </div>
        </div>




        <div class="card card custom">
            <div class="card-body">
                <form action="{{ route('admin.laporanSirkulasi.show') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="tanggalAwal" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggalAwal" name="tanggalAwal" required
                                value="{{ Request::get('tanggalAwal') }}">
                        </div>
                        <div class="col">
                            <label for="tanggalAkhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggalAkhir" name="tanggalAkhir" required
                                value="{{ Request::get('tanggalAkhir') }}">
                        </div>
                        <div class="col">
                            <label for="jenisData" class="form-label">Pilih Data</label>
                            <select class="form-select" id="jenisData" name="jenisData" required>
                                <option selected hidden value="{{ Request::get('jenisData') ?? '' }}">
                                    {{ Request::get('jenisData') ?? 'Pilih Data' }}</option>
                                <option value="pinjam">Peminjaman</option>
                                <option value="kembali">Pengembalian</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Pilih dan Cetak</button>
                        </div>
                    </div>
                </form>


                @if (Request::get('tanggalAwal') && Request::get('tanggalAkhir') && Request::get('jenisData'))
                    <div class="table-responsive mt-4">
                        <table id="example" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">No</th>
                                    <th class="text-center" scope="col">Buku</th>
                                    <th class="text-center" scope="col">Peminjam</th>
                                    <th class="text-center" scope="col">Tanggal Pinjam</th>
                                    <th class="text-center" scope="col">Jatuh Tempo</th>
                                    <th class="text-center" scope="col">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($circulations as $circulation)
                                    <tr>
                                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>

                                        <td>{{ $circulation->book->judul }}</td>
                                        <td>{{ $circulation->member->name }}</td>
                                        <td>{{ $circulation->tgl_pinjam }}</td>
                                        <td>{{ $circulation->tgl_kembali }}</td>
                                        <td>{{ $circulation->status }}</td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif


            </div>
        </div>









    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                paging: true, // Enable pagination
                pageLength: 10 // Set the number of records per page
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function deleteBook(url) {
            if (confirm('Are you sure you want to delete this book?')) {
                axios.delete(url, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',

                        }
                    })
                    .then(response => {
                        alert('Book deleted successfully');
                        location.reload(); // Refresh page after deletion
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to delete the book');
                    });
            }
        }
    </script>
@endpush
