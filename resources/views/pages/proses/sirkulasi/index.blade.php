@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.5rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
        }

        .select2-container .select2-selection--single:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
        }

        .select2-container .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            z-index: 1055;
        }

        .select2-container .select2-results__option {
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
        }

        .select2-container .select2-results__option--highlighted {
            background-color: #e9ecef;
            color: #212529;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }


    </style>
@endpush

@section('content')
    <div class="page-content" x-data="alpineData">
        @include('components.alertsComponents')
        <div class="">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                        <h2 class="text-dark-75 text-center">Management Sirkulasi</h2>
                        <p class="text-dark-50 text-center">Silahkan Atur Data Sirkulasi untuk menambah atau mengelola data
                            peminjaman buku.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5>Konfigurasi Denda</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sirkulasi.updateDenda') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="denda" class="form-label">Denda per Hari (Rp)</label>
                            <input type="text" class="form-control" id="denda" name="denda"
                                value="{{ number_format($denda->jumlah ?? 0, 0, ',', '.') }}" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-start">
                    <button class="btn btn-info text-white" @click="openModal()" data-bs-target="#tambahSirkulasi">
                        Tambah Peminjaman
                    </button>
                </div>
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="tambahSirkulasi" tabindex="-1" aria-labelledby="tambahSirkulasiLabel"
            aria-hidden="true" x-bind:aria-hidden="!isOpen" x-show="isOpen" x-transition x-cloak>
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahSirkulasiLabel">Tambah Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.sirkulasi.store') }}" method="POST" id="circulationForm"
                            x-ref="form">
                            @csrf
                            <input type="hidden" name="cartData" x-ref="cartData">
                            <div class="modal-body">
                                <div class="row h-100">
                                    <div class="col-md-8 d-flex flex-column" style="max-height: 100vh;">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="card-title text-warning mb-2">Pilih Anggota</p>
                                                    <select class="form-select mb-3" name="member_id" id="member_id"
                                                        required>
                                                        <option value="" selected disabled>Pilih Anggota</option>
                                                        @foreach ($members as $member)
                                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="row g-2 mt-2">
                                                        <div class="col-md-6">
                                                            <label for="tgl_pinjam" class="form-label text-info">Tanggal
                                                                Pinjam</label>
                                                            <input type="date" class="form-control" id="tgl_pinjam"
                                                                name="tgl_pinjam" value="{{ date('Y-m-d') }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="tgl_kembali" class="form-label text-primary">Tanggal
                                                                Kembali</label>
                                                            <input type="date" class="form-control" id="tgl_kembali"
                                                                name="tgl_kembali"
                                                                min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="input-group ">
                                                    <input type="text" class="form-control" placeholder="Cari buku..."
                                                        x-model="searchQuery" @input="handleSearch">
                                                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3" style="overflow-y: auto;" @scroll="handleScroll">
                                            <template x-for="book in books" :key="index">
                                                <div class="col-md-4 d-flex justify-content-center">
                                                    <div class="card shadow-sm" style="max-width: 90%; height: auto;">



                                                        <img :src="`${book.cover && book.cover !== '' ? '{{ asset('storage/') }}' + '/' + book.cover : '{{ asset('assets/images/errors-images/not_found.png') }}'}`"
                                                            class="card-img-top" alt="Buku IPS">





                                                        <div class="card-body d-flex flex-column p-3">
                                                            <h6 class="card-title text-info text-center"
                                                                x-text="book.judul"></h6>
                                                            <ul class="list-group list-group-flush flex-grow-1 small">
                                                                <li class="list-group-item">ISBN: <span
                                                                        x-text="book.isbn"></span></li>
                                                                <li class="list-group-item">Pengarang: <span
                                                                        x-text="book.pengarang"></span></li>
                                                                <li class="list-group-item">Penerbit: <span
                                                                        x-text="book.penerbit"></span></li>
                                                                <li class="list-group-item">Tahun Terbit: <span
                                                                        x-text="book.thn_terbit"></span></li>
                                                                <li class="list-group-item">Stok Tersedia: <span
                                                                        x-text="book.available_qty"></span></li>
                                                            </ul>
                                                            <div class="d-grid mt-2">
                                                                <button class="btn btn-outline-primary btn-sm select-book"
                                                                    type="button" @click="addToCart(book)"
                                                                    :class="{
                                                                        'btn-primary': cart.find(item => item.id ===
                                                                            book
                                                                            .id)
                                                                    }"
                                                                    :disabled="book.available_qty === 0 || (cart.find(item => item
                                                                            .id === book.id)?.qty ?? 0) >= book
                                                                        .available_qty">
                                                                    <span
                                                                        x-text="book.available_qty === 0 ? 'Stok Habis' : 'Pilih Buku'"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>


                                        </div>



                                        <div class="col-12 text-center mt-4" x-show="isLoading">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex flex-column">
                                        <div class="col-md-12 d-flex flex-column" style="overflow-y: auto;">

                                            <div class="card shadow border-0 "
                                                style="overflow-y: auto; max-height: 100vh;">
                                                <div class="card-body">
                                                    <template x-for="item in cart" :key="item.id">
                                                        <div class="d-flex align-items-center border p-2 mb-2">
                                                            <img :src="`${item.cover && item.cover !== '' ? '{{ asset('storage/') }}' + '/' + item.cover : '{{ asset('assets/images/errors-images/not_found.png') }}'}`"
                                                                class="me-3" alt="Book cover" style="width: 20%">


                                                            <div class="flex-grow-1">
                                                                <h6 x-text="item.judul"></h6>
                                                                <li class="list-group-item">ISBN: <span
                                                                        x-text="item.isbn"></span></li>
                                                                <li class="list-group-item">Pengarang: <span
                                                                        x-text="item.pengarang"></span></li>
                                                                <li class="list-group-item">Penerbit: <span
                                                                        x-text="item.penerbit"></span></li>
                                                                <li class="list-group-item">Tahun Terbit: <span
                                                                        x-text="item.thn_terbit"></span></li>
                                                            </div>
                                                            <div class="d-flex flex-column align-items-end">
                                                                <input type="number" class="form-control w-40 mb-2"
                                                                    :value="item.qty"
                                                                    @input="updateQty(item.id, $event.target.value)"
                                                                    :max="item.available_qty" min="1"
                                                                    @keypress="(evt) => ['e', 'E', '+', '-'].includes(evt.key) && evt.preventDefault()">
                                                                <button class="btn btn-danger btn-sm"
                                                                    @click="removeFromCart(item.id)">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </template>

                                                    <div x-show="cart.length === 0" class="text-center py-4">
                                                        <p class="text-muted">Belum ada buku yang dipilih</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectedBooks" name="selectedBooks">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between align-items-center">
                                <div class="pagination text-start">
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-success" @click="submitForm">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-8">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Data Sirkulasi</h5>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari data..."
                                x-model="searchCirculation" @input="handleSearchCirculation">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">No</th>
                                <th class="text-center" scope="col">Buku</th>
                                <th class="text-center" scope="col">Jumlah</th>
                                <th class="text-center" scope="col">Peminjam</th>
                                <th class="text-center" scope="col">Tanggal Pinjam</th>
                                <th class="text-center" scope="col">Jatuh Tempo</th>
                                <th class="text-center" scope="col">Denda (Rp)</th>
                                <th class="text-center" scope="col" style="width:10%;">Total Terlambat (Hari)</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(circulation, index) in circulations" :key="index">
                                <tr>
                                    <td
                                        x-text="isNaN(((pagination.current_page - 1) * pagination.per_page) + index + 1) ? '' : ((pagination.current_page - 1) * pagination.per_page) + index + 1">
                                    </td>
                                    <td class="text-center" x-text="circulation.book.judul"></td>
                                    <td class="text-center" x-text="circulation.qty"></td>
                                    <td class="text-center" x-text="circulation.member.name"></td>
                                    <td class="text-center" x-text="circulation.tgl_pinjam_formatted"></td>
                                    <td class="text-center" x-text="circulation.tgl_kembali_formatted"></td>
                                    <td class="text-center" x-text="calculateFine(circulation.tgl_kembali)"></td>
                                    <td class="text-center" x-text="calculateLateDays(circulation.tgl_kembali)"></td>
                                    <td class="text-center">
                                        <button class="btn btn-success btn-sm"
                                            @click="returnBook(circulation.kode_pinjam)"><i class="bx bx-check"></i></button>
                                        <button class="btn btn-info btn-sm"
                                            @click="extendBook(circulation.kode_pinjam)">
                                            <i class='bx bx-calendar' style='color:#fdf8f8'  ></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-end">
                        <!-- Previous button -->
                        <li class="page-item" :class="{ 'disabled': !pagination.prev_page_url }">
                            <a class="page-link" href="#"
                                @click.prevent="changePage(pagination.prev_page_url)">Previous</a>
                        </li>

                        <!-- First page -->
                        <template x-if="pagination.links && pagination.current_page > 3">
                            <li class="page-item">
                                <a class="page-link" href="#"
                                    @click.prevent="changePage(pagination.first_page_url)">1</a>
                            </li>
                        </template>

                        <!-- Left ellipsis -->
                        <template x-if="pagination.links && pagination.current_page > 4">
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        </template>

                        <!-- Page numbers -->
                        <template x-if="pagination.links">
                            <template x-for="(link, index) in pagination.links" :key="index">
                                <template
                                    x-if="index !== 0 && index !== pagination.links.length - 1 &&
                                        (Math.abs(pagination.current_page - link.label) <= 2 ||
                                        link.label == 1 ||
                                        link.label == pagination.last_page)">
                                    <li class="page-item" :class="{ 'active': link.active }">
                                        <a class="page-link" href="#" @click.prevent="changePage(link.url)"
                                            x-text="link.label"></a>
                                    </li>
                                </template>
                            </template>
                        </template>

                        <!-- Right ellipsis -->
                        <template x-if="pagination.links && pagination.current_page < pagination.last_page - 3">
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        </template>

                        <!-- Last page -->
                        <template x-if="pagination.links && pagination.current_page < pagination.last_page - 2">
                            <li class="page-item">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page_url)"
                                    x-text="pagination.last_page"></a>
                            </li>
                        </template>

                        <!-- Next button -->
                        <li class="page-item" :class="{ 'disabled': !pagination.next_page_url }">
                            <a class="page-link" href="#"
                                @click.prevent="changePage(pagination.next_page_url)">Next</a>
                        </li>
                    </ul>
                </nav>
                <div class="">
                    <h5>Notes</h5>
                    <p>Masa peminjaman buku adalah 7 hari dari tanggal peminjaman. Jika buku dikembalikan lebih dari masa
                        peminjaman, maka akan dikenakan denda sebesar Rp
                        {{ number_format($denda->jumlah ?? 1000, 0, ',', '.') }}/hari.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2-custom.js') }}"></script>

    @include('pages.proses.sirkulasi.scriptAlpine')

    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        document.getElementById('denda').addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value, 'Rp. ');
        });

        $(document).ready(function() {
            $("#member_id").select2({
                dropdownParent: $("#tambahSirkulasi"),
                placeholder: "Pilih Anggota",
                allowClear: true,
                width: '100%'
            });

            $('#example').DataTable();

            let selectedBooks = new Set();

            let booksTable = $('#booksTable').DataTable({
                'paging': true,
                'info': false,
                'searching': true,
                'ordering': true,
                'drawCallback': function(settings) {
                    $('input[name="book_ids[]"]').each(function() {
                        if (selectedBooks.has($(this).val())) {
                            $(this).prop('checked', true);
                        }
                    });
                }
            });

            $(document).on('click', '.select-book', function() {
                let bookId = $(this).data('book-id');
                if (selectedBooks.has(bookId)) {
                    selectedBooks.delete(bookId);
                    $(this).removeClass('btn-primary').addClass('btn-outline-primary').text('Pilih Buku');
                } else {
                    selectedBooks.add(bookId);
                    $(this).removeClass('btn-outline-primary').addClass('btn-primary').text('Pilih Buku');
                }
                updateHiddenInput();
            });

            function updateHiddenInput() {
                $('#selectedBooks').val(Array.from(selectedBooks).join(','));
            }

            updateHiddenInput();
        });

        function deleteConfirm(event, id) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form_' + id).submit();
                } else {
                    Swal.fire('Cancelled', 'Your data is safe :)', 'error');
                }
            });
        }
    </script>
@endpush
