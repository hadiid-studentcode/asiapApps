@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .container {
            width: 100%;
            max-width: 500px;
            margin: 5px;
        }

        .container h1 {
            color: #ffffff;
        }

        .section {
            background-color: #ffffff;
            padding: 50px 30px;
            border: 1.5px solid #b2b2b2;
            border-radius: 0.25em;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
        }

        #my-qr-reader {
            padding: 20px !important;
            border: 1.5px solid #b2b2b2 !important;
            border-radius: 8px;
        }

        #my-qr-reader img[alt="Info icon"] {
            display: none;
        }

        #my-qr-reader img[alt="Camera based scan"] {
            width: 100px !important;
            height: 100px !important;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        /* button:hover {
                                                                                            background-color: #008000;
                                                                                        } */

        #scanner-container {
            position: relative;
        }

        #scan-line {
            ntuk memperbaiki tampilan pagination agar sesuai dengan yang diinginkan,
            Anda bisa menggunakan Bootstrap untuk mengatur tampilan pagination. Berikut adalah contoh bagaimana Anda bisa memperbaiki pagination:
                position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: green;
            z-index: 1000;
            animation: fadeInOut 1s ease-in-out infinite;
        }

        @keyframes fadeInOut {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }

        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #007bff;
            z-index: 1050;
            animation: loading 2s linear infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
                width: 100%;
            }

            50% {
                left: 25%;
                width: 50%;
            }

            100% {
                left: 100%;
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-content" x-data="alpineData">
        @include('components.alertsComponents')
        <!-- Loading bar -->
        <div x-show="isLoading" class="loading-bar"></div>

        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <h2 class="text-dark-75 text-center">Manajemen Buku</h2>
                    <p class="text-dark-50 text-center">Silahkan Atur Pengelolaan buku sesuai keadaan buku yang tersedia
                        atau yang akan ditambahkan diperpustakaan.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="tombol">
                    <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#tambahBuku">Tambah
                        Buku</button>
                    <button class="btn btn-info text-white mx-2" data-bs-toggle="modal"
                        data-bs-target="#tambahBukuQr">Tambah Buku (QR)</button>
                </div>
            </div>
        </div>

        <div class="card">

            <!-- Modal Tambah Buku -->
            <div class="modal fade" id="tambahBuku" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('admin.kelolaBuku.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="cover" class="form-label">Upload Cover</label>
                                        <input type="file" class="form-control" id="cover" name="cover"
                                            placeholder="Masukkan Judul Buku" value="{{ old('cover') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="judulbuku" class="form-label">Judul Buku</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            placeholder="Masukkan Judul Buku" value="{{ old('judul') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="isbn" class="form-label">ISBN Buku</label>
                                        <input type="text" class="form-control" id="isbn" name="isbn"
                                            placeholder="Masukkan ISBN Buku" value="{{ old('isbn') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pengarang" class="form-label">Pengarang</label>
                                        <input type="text" class="form-control" id="pengarang" name="pengarang"
                                            placeholder="Masukkan Nama Pengarang" value="{{ old('pengarang') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="penerbit" class="form-label">Penerbit</label>
                                        <input type="text" class="form-control" id="penerbit" name="penerbit"
                                            placeholder="Masukkan Nama Penerbit" value="{{ old('penerbit') }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="number" class="form-control" id="thn_terbit" name="thn_terbit"
                                            placeholder="Masukkan Tahun Terbit" value="{{ old('thn_terbit') }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="20" rows="4">{{ old('deskripsi') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Tambah Buku QR -->

            <div class="card-body mb-5 modal fade" id="tambahBukuQr" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku QR</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div id="my-qr-reader"></div>
                                <div id="scan-line" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card-body">
                <!-- Add search input -->

                <div class="row mb-3">
                    <div class="col-sm-8">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Data Buku</h5>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari buku..." x-model="searchQuery"
                                @input="handleSearch">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <th>Kode</th>
                                <th>ISBN</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <template x-for="(book, index) in books" :key="index">
                                <tr>
                                    <td
                                        x-text="isNaN(((pagination.current_page - 1) * pagination.per_page) + index + 1) ? '' : ((pagination.current_page - 1) * pagination.per_page) + index + 1">
                                    </td>


                                    <td x-text="book.codes"></td>
                                    <td x-text="book.isbn"></td>
                                    <td x-text="book.judul"></td>
                                    <td x-text="book.pengarang"></td>
                                    <td x-text="book.qty"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">


                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#detailbuku" style="margin-right: 5px;"
                                                @click="openModal(book.id)">
                                                <i class='bx bxs-show' style="color: white;"></i>
                                            </button>


                                            <button class="btn btn-warning" @click="openModal(book.id)"
                                                style="margin-right: 5px;" data-bs-toggle="modal"
                                                data-bs-target="#editBukuModal">
                                                <i class='bx bx-edit' style="color: white;"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger" @click="deleteBook(book.id)">
                                                <i class='bx bx-trash' style="color: white;"></i>
                                            </button>


                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <!-- Modal edit -->
                            <div class="modal fade" id="editBukuModal" tabindex="-1"
                                aria-labelledby="editBukuModalLabel" x-show="isOpen" x-transition
                                @click.away="closeModal" x-bind:aria-hidden="!isOpen">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form @submit.prevent="updateBook(selectedBook.id)" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editBukuModalLabel">Edit Buku </h5>
                                                <button type="button" class="btn-close btn-close-dark"
                                                    @click="closeModal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label for="cover" class="form-label">Upload Cover</label>
                                                        <input type="file" class="form-control" name="cover" 
                                                            x-ref="coverInput">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="judulbuku" class="form-label">Judul Buku</label>
                                                        <input type="text" class="form-control" name="judul"
                                                            x-ref="judulInput" x-bind:value="selectedBook?.judul ?? ''">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="isbn" class="form-label">ISBN Buku</label>
                                                        <input type="text" class="form-control" name="isbn"
                                                            x-ref="isbnInput" x-bind:value="selectedBook?.isbn ?? ''">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pengarang" class="form-label">Pengarang</label>
                                                        <input type="text" class="form-control" name="pengarang"
                                                            x-ref="pengarangInput"
                                                            x-bind:value="selectedBook?.pengarang ?? ''">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="penerbit" class="form-label">Penerbit</label>
                                                        <input type="text" class="form-control" name="penerbit"
                                                            x-ref = "penerbitInput"
                                                            x-bind:value="selectedBook?.penerbit ?? ''">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="tahun" class="form-label">Tahun</label>
                                                        <input type="number" class="form-control" name="thn_terbit" x-ref="thn_terbitInput"
                                                            x-bind:value="selectedBook?.thn_terbit ?? ''">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="20" rows="4" x-ref="deskripsiInput"
                                                            x-bind:value="selectedBook?.deskripsi ?? ''"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    @click="closeModal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal detail buku -->
                            <div class="modal fade" id="detailbuku" tabindex="-1" aria-labelledby="detailLabel"
                                x-show="isOpen" x-transition @click.away="closeModal"
                                x-bind:aria-hidden="!isOpen">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailbuku"
                                                x-bind:text="selectedBook?.judul ?? ''"></h5>
                                            <button type="button" class="btn-close" @click="closeModal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <img :src="`{{ asset('storage/') }}/${selectedBook.cover ?? ''}`"
                                                    alt="Cover Buku" class="img-fluid rounded shadow-sm w-75">
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong>Pengarang: </strong><span
                                                        x-text="selectedBook?.pengarang ?? ''"></span></li>
                                                <li class="list-group-item"><strong>Penerbit: </strong><span
                                                        x-text="selectedBook?.penerbit ?? ''"></span></li>
                                                <li class="list-group-item"><strong>ISBN: </strong><span
                                                        x-text="selectedBook?.isbn ?? ''"></span></li>
                                                <li class="list-group-item"><strong>KODE: </strong><span
                                                        x-text="selectedBook?.kode ?? ''"></span></li>
                                                <li class="list-group-item"><strong>Tahun Terbit: </strong><span
                                                        x-text="selectedBook?.thn_terbit ?? ''"></span></li>
                                                <li class="list-group-item"><strong>Deskripsi: </strong><span
                                                        x-text="selectedBook?.deskripsi ?? ''"></span></li>
                                            </ul>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                @click="closeModal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

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
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                // Add these new properties
                searchQuery: '',
                searchTimeout: null,
                isLoading: false, // Add this line to track loading state


                // Add to existing properties
                isProcessing: false,
                books: [],
                isOpen: false,
                selectedBook: {},
                pagination: {},
                currentPage: 1, // Add this line to track current page

                init() {
                    if (!document.getElementById('my-qr-reader').hasChildNodes()) {
                        this.scanQR();
                    }

                    this.featchData();
                },
                openModal(bookId) {
                    this.selectedBook = this.books.find(book => book.id === bookId);
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                    this.selectedBook = {};
                    $('#editBukuModal').modal('hide'); // Ensure the modal is hidden
                    $('#detailbuku').modal('hide'); // Ensure the modal is hidden
                },

                scanQR() {
                    const onScanSuccess = async (decodedText, decodedResult) => {
                        if (this.isProcessing) return;
                        this.isProcessing = true;
                        const scanLine = document.getElementById("scan-line");
                        scanLine.style.display = "block";
                        setTimeout(() => {
                            scanLine.style.display = "none";
                        }, 2000);

                        try {
                            const response = await axios.post(
                                '{{ route('admin.kelolaBuku.store') }}', {
                                    isbnScan: decodedText
                                }, {
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                }
                            );

                            if (response.data.status == 'warning') {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Warning",
                                    text: response.data.message ||
                                        "Terjadi kesalahan. Silakan coba lagi.",
                                });
                                return;
                            }

                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: response.data.message ||
                                    "Data berhasil disimpan.",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            location.reload();
                        } catch (error) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: error.response?.data?.message ||
                                    "Terjadi kesalahan. Silakan coba lagi.",
                            });
                            location.reload();
                        } finally {
                            setTimeout(() => {
                                this.isProcessing = false;
                            }, 3000);
                        }
                    };

                    const onScanFailure = (error) => {};

                    const qrboxSize = window.innerWidth < 768 ? {
                        width: 250,
                        height: 150
                    } : {
                        width: 450,
                        height: 250
                    };
                    const htmlscanner = new Html5QrcodeScanner("my-qr-reader", {
                        fps: 10,
                        qrbox: qrboxSize
                    });

                    htmlscanner.render(onScanSuccess, onScanFailure);
                },
                async featchData(url = '{{ route('admin.kelolaBuku.getDataBuku') }}') {
                    try {
                        const response = await axios.post(url, {
                            page: this.currentPage, // Add page parameter
                            search: this.searchQuery // Add search parameter
                        });
                        this.books = response.data.data;
                        console.log(this.books);
                        this.pagination = response.data;
                    } catch (error) {
                        console.error(error);
                    }
                },
                changePage(url) {
                    if (url) {
                        // Extract page number from URL
                        const urlParams = new URLSearchParams(new URL(url).search);
                        this.currentPage = urlParams.get('page') || 1;
                        this.featchData(url);
                    }
                },
                deleteBook(id) {
                    try {
                        Swal.fire({
                            title: 'Apakah anda yakin?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'

                        }).then((result) => {

                            if (result.isConfirmed == true) {
                                this.isLoading = true; // Show loading bar

                                axios.delete(
                                    `{{ route('admin.kelolaBuku.destroy', '') }}/${id}`, {
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    }).then(response => {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Data berhasil dihapus.',
                                        'success'
                                    )
                                    // Reload current page
                                    this.featchData(
                                        `{{ route('admin.kelolaBuku.getDataBuku') }}?page=${this.currentPage}`
                                    );
                                }).catch(error => {
                                    Swal.fire(
                                        'Gagal!',
                                        'Data gagal dihapus. Coba lagi.',
                                        'error'
                                    )
                                }).finally(() => {
                                    this.isLoading = false; // Hide loading bar
                                });
                            } else if (result.isConfirmed == false) {
                                Swal.fire("Data Tidak Dihapus", "", "info");
                            }
                        });

                    } catch (error) {

                    }
                },
                async updateBook(book_id) {
                    this.isLoading = true; // Show loading bar

                    let formData = new FormData();
                    formData.append('_method', 'PUT');
                    formData.append('judul', this.$refs.judulInput.value);
                    formData.append('isbn', this.$refs.isbnInput.value);
                    formData.append('pengarang', this.$refs.pengarangInput.value);
                    formData.append('penerbit', this.$refs.penerbitInput.value);
                    formData.append('thn_terbit', this.$refs.thn_terbitInput.value);
                    formData.append('deskripsi', this.$refs.deskripsiInput.value);


                    // Check if a new cover file is selected
                    if (this.$refs.coverInput.files.length > 0) {
                        formData.append('cover', this.$refs.coverInput.files[0]);
                    }

                    try {
                        const response = await axios.post(
                            `{{ route('admin.kelolaBuku.update', '') }}/${book_id}`,
                            formData, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'multipart/form-data',
                                },
                            }
                        );

                        Swal.fire({
                            title: "Data buku berhasil di update",
                            icon: "success",
                            draggable: true
                        });

                        formData = new FormData(); // Reset FormData setelah update
                        this.$refs.coverInput.value = null;

                        this.closeModal();

                        // Reload current page
                        // reload window
                        // location.reload();



                        this.featchData(
                            `{{ route('admin.kelolaBuku.getDataBuku') }}?page=${this.currentPage}`
                        );

                    } catch (error) {
                        Swal.fire({
                            title: "Terjadi kesalahan",
                            icon: "error",
                            draggable: true
                        });
                    } finally {
                        this.isLoading = false; // Hide loading bar
                    }
                },
                // Add this new method
                handleSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.currentPage = 1;
                        this.featchData();
                    }, 300);
                },
            }));
        });
    </script>
@endpush
