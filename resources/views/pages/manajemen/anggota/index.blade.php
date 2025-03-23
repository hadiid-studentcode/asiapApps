@extends('layouts.main')

@push('css')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    <div class="page-content" x-data="alpineData">
        @include('components.alertsComponents')


        <div class="">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                        <h2 class="text-dark-75 text-center ">Management Anggota </h2>
                        <p class="text-dark-50 text-center">Silahkan Atur Data Anggota untuk menambah annggota perpustakaan
                            agar masuk kedalam sistem.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class=" d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-start gap-2">
                        <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#tambahAnggota">
                            Tambah Anggota
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <div class="card">
            <!-- Modal Tambah Anggota -->
            <div class="modal fade" id="tambahAnggota" tabindex="-1" aria-labelledby="tambahAnggotaLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('admin.dataAnggota.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahAnggotaLabel">Tambah Anggota</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="kartu_slot" class="form-label">Kartu Slot</label>

                                        <input type="text" class="form-control mt-2" id="cards" name="cards"
                                            placeholder="Kartu Slot">



                                    </div>
                                    <div class="col-12">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Masukkan Nama Lengkap" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" name="kelas" id="kelas" class="form-control"
                                            placeholder="Masukkan Kelas">
                                    </div>
                                    <div class="col-12">
                                        <label for="telp" class="form-label">No HP</label>
                                        <input type="text" class="form-control" id="telp" name="telp"
                                            placeholder="Masukkan Nomor Telepon" required>
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




            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-sm-8">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Data Anggota</h5>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari anggota..." x-model="searchQuery"
                                @input="handleSearch">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th> <!-- Add this line -->
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jenis Kelamin</th>
                                {{-- <th class="text-center">Kelas</th> --}}
                                <th class="text-center">No HP</th>
                                <th class="text-center">Kelola</th>
                            </tr>
                        </thead>
                        <tbody>

                            <template x-for="(member, index) in members">
                                <tr>
                                    <td class="text-center"
                                        x-text="isNaN(((pagination.current_page - 1) * pagination.per_page) + index + 1) ? '' : ((pagination.current_page - 1) * pagination.per_page) + index + 1">
                                    </td>
                                    <td x-text="member.name"></td>
                                    <td x-text="member.gender"></td>
                                    <td x-text="member.telp"></td>
                                    <td>
                                        <button @click="openModal(member.id)" class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#editAnggotaModal">
                                            <i class='bx bx-edit' style="color: white;"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm" @click="deleteMember(member.id)">
                                            <i class='bx bxs-trash' style="color: white;"></i>
                                        </button>
                                    </td>
                                </tr>

                            </template>

                            <div class="modal fade" id="editAnggotaModal" tabindex="-1"
                                aria-labelledby="editAnggotaModalLabel" x-show="isOpen" x-transition
                                @click.away="closeModal" x-bind:aria-hidden="!isOpen">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form @submit.prevent="updateMember(selectedMember.id)">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAnggotaModalLabel">Edit Anggota</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    @click="closeModal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="kartu_slot" class="form-label">Kartu Slot</label>

                                                        <input type="text" class="form-control mt-2" id="cards"
                                                            name="cards" placeholder="Kartu Slot"
                                                            x-model="selectedMember.cards">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="nama" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama"
                                                            name="nama" placeholder="Masukkan Nama Lengkap"
                                                            x-model="selectedMember.name">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="jenis_kelamin" class="form-label">Jenis
                                                            Kelamin</label>
                                                        <select class="form-select" name="jenis_kelamin"
                                                            id="jenis_kelamin" x-model="selectedMember.gender">
                                                            <option value="" disabled
                                                                :selected="selectedMember.gender === null">Pilih Jenis
                                                                Kelamin
                                                            </option>
                                                            <option value="laki-laki"
                                                                :selected="selectedMember.gender === 'laki-laki'">Laki-laki
                                                            </option>
                                                            <option value="perempuan"
                                                                :selected="selectedMember.gender === 'perempuan'">Perempuan
                                                            </option>
                                                        </select>

                                                    </div>

                                                    <div class="col-12">
                                                        <label for="kelas" class="form-label">Kelas</label>
                                                        <input type="text" class="form-control" id="kelas"
                                                            name="kelas" placeholder="Masukkan Kelas"
                                                            x-model="selectedMember.kelas">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="telp" class="form-label">No HP</label>
                                                        <input type="text" class="form-control" id="telp"
                                                            name="telp" placeholder="Masukkan Nomor Telepon"
                                                            x-model="selectedMember.telp">
                                                    </div>




                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                    @click="closeModal">Close</button>
                                                <button type="submit" class="btn btn-warning" style="color:white;">
                                                    Simpan
                                                </button>
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
            </div>
        </div>

    </div>
@endsection


@push('js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                stateSave: true,
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById("reset-kartu").addEventListener("click", function() {
            document.getElementById("cards").value = "";
        });
    </script>

    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                isProcessing: false,
                members: [],
                isOpen: false,
                selectedMember: {},
                pagination: {},
                currentPage: 1, // Add this line to track current page
                searchQuery: '',

                init() {
                    this.fetchData();

                    document.getElementById("reset-kartu").addEventListener("click", function() {
                        document.getElementById("cards").value = "";
                    });
                },

                handleSearch() {
                    this.currentPage = 1; // Reset to first page when searching
                    this.fetchData();
                },

                async fetchData(url = '{{ route('admin.dataAnggota.getDataAnggota') }}') {
                    try {
                        const response = await axios.post(url, {
                            page: this.currentPage,
                            search: this.searchQuery // Add search parameter
                        });
                        this.members = response.data.data;
                        this.pagination = response.data;
                    } catch (error) {
                        console.error('Error fetching data:', error);
                    }
                },

                openModal(memberId) {
                    this.selectedMember = this.members.find(member => member.id === memberId);
                },

                closeModal() {
                    this.isOpen = false;
                    this.selectedMember = {};
                    $('#editAnggotaModal').modal('hide'); // Ensure the modal is hidden
                },

                changePage(url) {
                    if (url) {
                        // Extract page number from URL
                        const urlParams = new URLSearchParams(new URL(url).search);
                        this.currentPage = urlParams.get('page') || 1;
                        this.fetchData(url);
                    }
                },

                deleteMember(id) {
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
                                    `{{ route('admin.dataAnggota.destroy', '') }}/${id}`, {
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
                                    this.fetchData(
                                        `{{ route('admin.dataAnggota.getDataAnggota') }}?page=${this.currentPage}`
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

                async updateMember(member_id) {
                    try {
                        if (!member_id) {
                            return;
                        }

                        const response = await axios.put(
                            `{{ route('admin.dataAnggota.update', ':id') }}`.replace(':id',
                                member_id),
                            this.selectedMember, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }
                        );

                        if (response.data.status === 'success') {
                            Swal.fire({
                                title: "Data Anggota berhasil di update",
                                icon: "success",
                                draggable: true
                            });

                            this.closeModal();
                            // Reload current page
                            await this.fetchData(
                                `{{ route('admin.dataAnggota.getDataAnggota') }}?page=${this.currentPage}`
                            );
                        }
                    } catch (error) {
                        Swal.fire({
                            title: "Terjadi kesalahan",
                            text: error.message || "Gagal mengupdate data anggota",
                            icon: "error",
                            draggable: true
                        });
                    }
                },
                resetKartu() {
                    this.selectedMember.cards = '';
                }
            }));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk modal "Tambah Anggota"
            const tambahAnggotaModal = document.getElementById('tambahAnggota');
            tambahAnggotaModal.addEventListener('shown.bs.modal', function() {
                document.getElementById('cards').focus();
            });


        });
    </script>
@endpush
