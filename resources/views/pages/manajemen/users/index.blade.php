@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endpush


@section('content')
    <div class="page-content" x-data="alpineData">

        <div class="page-content">
            @include('components.alertsComponents')


            <div class="" style="margin-top: -20px;">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <h2 class="text-dark-75 text-center">Manajemen Pengguna</h2>
                            <p class="text-dark-50 text-center">Silahkan atur data pengguna untuk menambah, mengedit, atau
                                menghapus pengguna</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-info  text-white" data-bs-toggle="modal"
                            data-bs-target="#tambahUserModal">
                            Tambah Pengguna
                        </button>
                    </div>
                </div>

                <div class="card ">
                    <div class="card-body">

                        <!-- Modal Tambah Pengguna -->
                        <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.manajemenUsers.store') }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahUserModalLabel">Tambah Pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama"
                                                    placeholder="Masukkan Nama" name="name" value="{{ old('name') }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" placeholder="Masukkan username"
                                                    name="username" value="{{ old('username') }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Masukkan Email" name="email" value="{{ old('email') }}">
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="Masukkan Password" name="password">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info text-white">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title">Data Pengguna</h5>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari pengguna..."
                                            x-model="searchQuery" @input="handleSearch">
                                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">No</th>
                                        <th class="text-center" scope="col">username</th>
                                        <th class="text-center" scope="col">username</th>
                                        <th class="text-center" scope="col">Email</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <template x-for="(user, index) in users" :key="user.id">

                                        <tr>
                                            <td class="text-center"
                                                x-text="isNaN(((pagination.current_page - 1) * pagination.per_page) + index + 1) ? '' : ((pagination.current_page - 1) * pagination.per_page) + index + 1">
                                            </td>
                                            <td class="text-center" x-text="user.name"></td>
                                            <td class="text-center" x-text="user.username"></td>
                                            <td class="text-center" x-text="user.email"></td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm" @click="openModal(user.id)"
                                                    data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                                                <button class="btn btn-danger btn-sm"
                                                    @click="deleteUser(user.id)">Hapus</button>
                                            </td>
                                        </tr>
                                    </template>

                                    <!-- Modal Edit Pengguna -->
                                    <div class="modal fade" id="editUserModal" tabindex="-1"
                                        aria-labelledby="editUserModalLabel" x-show="isOpen" x-transition
                                        @click.away="closeModal" x-bind:aria-hidden="!isOpen">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form @submit.prevent="updateUser(selectedUser.id)">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserModalLabel">Edit
                                                            Pengguna</h5>
                                                        <button type="button" class="btn-close" @click="closeModal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label for="editNama">Nama</label>
                                                            <input type="text" class="form-control" name="name"
                                                                x-model="selectedUser.name">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="editUsername">Username</label>
                                                            <input type="text" class="form-control" name="username"
                                                                x-model="selectedUser.username">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="editEmail">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                x-model="selectedUser.email">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="editPassword">Password</label>
                                                            <input type="password" class="form-control" name="password"
                                                                placeholder="Masukkan Password Baru">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            @click="closeModal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-info text-white">Simpan</button>
                                                    </div>
                                                </form>
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

                        <div class="mt-4">
                            <h5>Notes</h5>
                            <p>Pastikan email yang digunakan valid dan password memenuhi standar keamanan minimal 8 karakter
                                dengan kombinasi huruf dan angka.</p>
                        </div>
                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function deleteUser(url) {
            if (confirm('Are you sure you want to delete this user?')) {
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
                        alert('Failed to delete the user');
                    });
            }
        }
    </script>


    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                // Add these new properties
                searchQuery: '',
                searchTimeout: null,

                // Add to existing properties
                isProcessing: false,
                users: [],
                isOpen: false,
                selectedUser: {},
                pagination: {},
                currentPage: 1, // Add this line to track current page

                init() {


                    this.featchData();
                },
                openModal(userId) {
                    this.selectedUser = this.users.find(user => user.id === userId);
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                    this.selectedUser = {};
                    $('#editUserModal').modal('hide'); // Ensure the modal is hidden
                },


                async featchData(url = '{{ route('admin.manajemenUsers.getDataUsers') }}') {
                    try {
                        const response = await axios.post(url, {
                            page: this.currentPage, // Add page parameter
                            search: this.searchQuery // Add search parameter
                        });
                        this.users = response.data.data;
                        this.pagination = response.data;
                    } catch (error) {
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
                deleteUser(id) {
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

                                axios.delete(
                                    `{{ route('admin.manajemenUsers.destroy', '') }}/${id}`, {
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
                                        `{{ route('admin.manajemenUsers.getDataUsers') }}?page=${this.currentPage}`
                                    );
                                }).catch(error => {
                                    Swal.fire(
                                        'Gagal!',
                                        'Data gagal dihapus. Coba lagi.',
                                        'error'
                                    )
                                });
                            } else if (result.isConfirmed == false) {
                                Swal.fire("Data Tidak Dihapus", "", "info");
                            }
                        });

                    } catch (error) {

                    }
                },
                async updateUser(user_id) {

                  
                    try {


                       


                        const response = await axios.put(
                            `{{ route('admin.manajemenUsers.update', ':id') }}`.replace(':id',
                                user_id),
                            this.selectedUser, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                              method: 'PUT',

                            }
                        ).then(response => {
                            Swal.fire({
                                title: "Data User berhasil di update",
                                icon: "success",
                                draggable: true
                            });
                            this.closeModal();
                            // Reload current page
                            this.featchData(
                                `{{ route('admin.manajemenUsers.getDataUsers') }}?page=${this.currentPage}`
                            );

                        });




                    } catch (error) {
                        Swal.fire({
                            title: "Terjadi kesalahan",
                            icon: "error",
                            draggable: true
                        });
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
