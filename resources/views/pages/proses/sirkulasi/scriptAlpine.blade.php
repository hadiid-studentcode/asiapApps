<script defer>
    document.addEventListener('alpine:init', () => {
        Alpine.data('alpineData', () => ({
            books: [],
            cart: [], // Add cart array
            isLoading: false,
            isOpen: false,
            page: 1,
            allDataLoaded: false,
            searchTimeout: null,
            filters: {
                search: '',
            },
            searchQuery: '',
            //  sirkulasi
            circulations: [],
            pagination: {},
            currentPage: 1, // Add this line to track current page
            searchCirculation: '',



            init() {
                this.cart = [];
                this.getDataCirculation();
            },

            addToCart(book) {
                const existingItem = this.cart.find(item => item.id === book.id);
                const availableQty = book.available_qty;

                if (!existingItem && availableQty > 0) {
                    // Always add with qty=1 initially
                    this.cart.push({
                        ...book,
                        qty: 1
                    });
                } else {
                    Swal.fire(
                        'Info',
                        'Buku sudah ada di keranjang. Gunakan input quantity untuk mengubah jumlah.',
                        'info'
                    );
                }
                this.updateSelectedBooks();
            },

            removeFromCart(bookId) {
                this.cart = this.cart.filter(item => item.id !== bookId);
                this.updateSelectedBooks();
            },

            updateQty(bookId, newQty) {
                const item = this.cart.find(item => item.id === bookId);
                if (item) {
                    newQty = parseInt(newQty);
                    const book = this.books.find(b => b.id === bookId);
                    const availableQty = book ? book.available_qty : 0;

                    // Handle invalid input
                    if (isNaN(newQty) || newQty <= 0) {
                        Swal.fire({
                            title: 'Input Tidak Valid',
                            text: 'Jumlah buku harus lebih dari 0',
                            icon: 'warning'
                        });
                        item.qty = 1;
                        return;
                    }

                    // Check if quantity exceeds available stock
                    if (newQty > availableQty) {
                        Swal.fire({
                            title: 'Stok Tidak Mencukupi',
                            text: `Stok buku yang tersedia hanya ${availableQty} buku`,
                            icon: 'warning'
                        });
                        item.qty = availableQty;
                    } else {
                        item.qty = newQty;
                    }
                }
                this.updateSelectedBooks();
            },

            updateSelectedBooks() {
                document.getElementById('selectedBooks').value = this.cart.map(item => item.id)
                    .join(',');
            },

            async getDataBooks() {
                this.isLoading = true;
                try {
                    const response = await axios.post(
                        '{{ route('admin.sirkulasi.getDataBuku') }}',
                        this.filters
                    );
                    this.books = response.data.data;
                    this.isLoading = false;
                } catch (error) {
                    console.error(error);
                }
            },

            openModal() {
                $('#tambahSirkulasi').modal('show');
                this.getDataBooks();
            },
            handleScroll(event) {

                const target = event.target;
                if (target.scrollHeight - target.scrollTop === target.clientHeight && !this
                    .allDataLoaded && !this.isLoading) {
                    this.loadMore();
                    // Add your logic here to load more data
                }
            },
            async loadMore() {
                this.isLoading = true;
                this.page++;
                const response = await axios.post('{{ route('admin.sirkulasi.loadMore') }}', {
                        page: this.page,
                        ...this.filters

                    })
                    .then(response => {
                        this.books = [...this.books, ...response.data.data];
                        this.allDataLoaded = response.data.current_page >= response.data
                            .last_page;
                    })
                    .catch(error => {})
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            handleSearch() {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.page = 1;
                    this.filters.search = this.searchQuery;
                    this.getDataBooks();
                }, 300);
            },

            submitForm() {
                // Update hidden input with cart data including quantities
                this.$refs.cartData.value = JSON.stringify(this.cart);
                this.$refs.form.submit();
            },

            async getDataCirculation(url = '{{ route('admin.sirkulasi.getDataCirculation') }}') {
                this.isLoading = true;
                try {
                    const response = await axios.post(
                        url, {
                            page: this.currentPage, // Add page parameter
                            search: this.searchCirculation // Add search parameter

                        }
                    );
                    this.circulations = response.data.data;
                    this.pagination = response.data;
                    this.isLoading = false;
                } catch (error) {
                    console.error(error);
                }
            },
            changePage(url) {
                if (url) {
                    // Extract page number from URL
                    const urlParams = new URLSearchParams(new URL(url).search);
                    this.currentPage = urlParams.get('page') || 1;
                    this.getDataCirculation(url);
                }
            },
            handleSearchCirculation() {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.currentPage = 1;
                    this.getDataCirculation();
                }, 300);
            },
            calculateLateDays(tgl_kembali) {
                const today = new Date();
                const returnDate = new Date(tgl_kembali);
                const diffTime = today - returnDate;
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                return diffDays > 0 ? diffDays : 0;
            },
            calculateFine(tgl_kembali) {
                const lateDays = this.calculateLateDays(tgl_kembali);
                const finePerDay = {{ $denda->jumlah ?? 1000 }};
                return lateDays > 0 ? lateDays * finePerDay : 0;
            },
            async returnBook(kode_pinjam) {
                this.isLoading = true;
                try {
                    const response = await axios.post(
                        '{{ route('admin.sirkulasi.return', '') }}/' + kode_pinjam);
                    if (response.data.status === 'success') {
                        this.isLoading = false;
                        // Pass current search query and page when refreshing data

                        Swal.fire('Success', response.data.message, 'success');

                        this.getDataCirculation(
                            `{{ route('admin.sirkulasi.getDataCirculation') }}?page=${this.currentPage}`
                        );
                    }
                } catch (error) {
                    this.isLoading = false;
                    Swal.fire('Error', error.response.data.message, 'error');
                    this.getDataCirculation(
                        `{{ route('admin.sirkulasi.getDataCirculation') }}?page=${this.currentPage}`
                    );
                }
            },
            async extendBook(kode_pinjam) {
                const today = new Date().toISOString().split('T')[0];
                const nextWeek = new Date();
                nextWeek.setDate(nextWeek.getDate() + 7);
                const nextWeekStr = nextWeek.toISOString().split('T')[0];

                const circulation = this.circulations.find(c => c.kode_pinjam === kode_pinjam);
                const currentDueDate = circulation ? circulation.tgl_kembali : today;

                // const {
                //     value: date
                // } = await Swal.fire({
                //     title: 'Perpanjang Tanggal Jatuh Tempo',
                //     html: `
                //         <div class="text-start">
                //             <p class="mb-2">Tanggal Jatuh Tempo Saat Ini: <strong>${circulation.tgl_kembali_formatted}</strong></p>
                //             <p class="mb-2">Denda Saat Ini: <strong>Rp ${this.calculateFine(circulation.tgl_kembali).toLocaleString()}</strong></p>
                //             <p class="mb-3">Keterlambatan: <strong>${this.calculateLateDays(circulation.tgl_kembali)} hari</strong></p>
                //         </div>
                //     `,
                //     input: 'date',
                //     inputLabel: 'Pilih tanggal jatuh tempo baru',
                //     inputClass: 'swal-input-date',
                //     inputValue: circulation.tgl_kembali,
                //     inputAttributes: {
                //         min: today,
                //     },
                //     showCancelButton: true,
                //     confirmButtonText: 'Perpanjang',
                //     cancelButtonText: 'Batal',
                //     confirmButtonColor: '#28a745',
                //     cancelButtonColor: '#dc3545',
                //     customClass: {
                //         popup: 'swal-popup-custom'
                //     },
                //     inputValidator: (value) => {
                //         if (!value) {
                //             return 'Anda harus memilih tanggal!';
                //         }
                //         if (value <= today) {
                //             return 'Tanggal harus lebih dari hari ini!';
                //         }
                //         if (value <= currentDueDate) {
                //             return 'Tanggal harus lebih dari tanggal jatuh tempo saat ini!';
                //         }
                //     }
                // });

                const {
                    value: date
                } = await Swal.fire({
                    title: 'Perpanjang Tanggal Jatuh Tempo',
                    html: `
        <div class="text-center">
            <p class="mb-2 fw-bold">Tanggal Jatuh Tempo Saat Ini: <span class="text-primary">${circulation.tgl_kembali_formatted}</span></p>
            <p class="mb-2">Denda Saat Ini: <span class="text-danger fw-bold">Rp ${this.calculateFine(circulation.tgl_kembali).toLocaleString()}</span></p>
            <p class="mb-3">Keterlambatan: <span class="text-warning fw-bold">${this.calculateLateDays(circulation.tgl_kembali)} hari</span></p>

            <div class="d-flex justify-content-center">
                <div class="input-group w-75 shadow-sm">
                    <span class="input-group-text bg-primary text-white"><i class="bx bx-calendar"></i></span>
                    <input id="swal-input-date" type="date" class="form-control text-center border-primary" min="${today}" value="${circulation.tgl_kembali}">
                </div>
            </div>
        </div>
    `,
                    showCancelButton: true,
                    confirmButtonText: 'Perpanjang',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    customClass: {
                        popup: 'swal-popup-custom'
                    },
                    preConfirm: () => {
                        const selectedDate = document.getElementById(
                            'swal-input-date').value;
                        if (!selectedDate) {
                            Swal.showValidationMessage(
                                'Anda harus memilih tanggal!');
                        } else if (selectedDate <= today) {
                            Swal.showValidationMessage(
                                'Tanggal harus lebih dari hari ini!');
                        } else if (selectedDate <= circulation.tgl_kembali) {
                            Swal.showValidationMessage(
                                'Tanggal harus lebih dari tanggal jatuh tempo saat ini!'
                            );
                        }
                        return selectedDate;
                    }
                });



                if (date) {
                    try {
                        const response = await axios.post(
                            '{{ route('admin.sirkulasi.extend', '') }}/' + kode_pinjam, {
                                jatuhtempo: date
                            });
                        if (response.data.status === 'success') {
                            this.getDataCirculation();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Tanggal jatuh tempo berhasil diperpanjang',
                                confirmButtonColor: '#28a745'
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: error.response?.data?.message ||
                                'Terjadi kesalahan saat memperpanjang tanggal jatuh tempo',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                }
            },

        }))
    })
</script>
