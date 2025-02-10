@extends('layouts.main')

@push('css')
    <script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
@endpush


@section('content')
    <div class="page-content" x-data="alpineData">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Settings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Settings</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex flex-column align-items-center text-center">
                                    <template x-if="!qrcode && !serverError">
                                        <div id="canvas" style="text-align: center;" width="110"
                                            class="rounded-circle p-1 bg-primary"></div>
                                    </template>

                                    <template x-if="qrcode">
                                        <img src="{{ asset('assets/images/icons/checklist.png') }}"
                                            class="img-thumbnail" alt="QR Code Success">
                                    </template>

                                    <template x-if="serverError">
                                        <img src="{{ asset('assets/images/loading.gif') }}"
                                            class="rounded mx-auto d-block" alt="Server Error">
                                    </template>

                                    <div class="mt-3">
                                        <h4>Scan QR Code Whatsapp</h4>
                                        <template x-if="isloading">
                                            <p class="text-secondary mb-1">Loading ...</p>
                                        </template>

                                        <template x-if="!isloading">
                                            <p class="text-muted font-size-sm" x-text="qrcode ? 'Connected' : (serverError ? 'Server tidak merespon' : 'Please scan QR code')"></p>
                                        </template>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <form action="{{ route('admin.settings.update', Auth::user()->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    @include('components.alertsComponents')

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="fullname"
                                                value="{{ Auth::user()->name }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Username</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="username"
                                                value="{{ Auth::user()->username }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="email"
                                                value="{{ Auth::user()->email }}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Password</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="password" name="password" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alpineData', () => ({
                open: false,
                isloading: false,
                qrcode: false,
                serverError: false,

                init() {
                    setInterval(() => {
                        this.renderQRCode();
                    }, 5000);
                },

                async renderQRCode() {
                    this.isloading = true;

                    try {
                        const response = await axios.get('{{ route('generateWA') }}');
                        const qrcode = response.data.response.qrCode;
                        
                        const canvasContainer = document.getElementById("canvas");
                        if (canvasContainer) {
                            canvasContainer.innerHTML = "";
                        }

                        if (!qrcode) {
                            this.qrcode = true;
                            this.serverError = false;
                        } else {
                            this.qrcode = false;
                            this.serverError = false;
                            const qrCodeConfig = {
                                width: 270,
                                height: 270,
                                type: "png",
                                data: qrcode,
                                dotsOptions: {
                                    color: "#000000",
                                    type: "rounded",
                                },
                                backgroundOptions: {
                                    color: "#ffffff",
                                },
                                imageOptions: {
                                    crossOrigin: "anonymous",
                                    margin: 10,
                                },
                            };
                            const qrCode = new QRCodeStyling(qrCodeConfig);
                            qrCode.append(canvasContainer);
                        }
                    } catch (error) {
                        console.error('Error fetching QR code:', error);
                        this.serverError = true;
                        this.qrcode = false;
                    } finally {
                        this.isloading = false;
                    }
                },
            }))
        })
    </script>
@endpush
