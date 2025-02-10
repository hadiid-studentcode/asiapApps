<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/logos/iconWebsite.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">

    <title>Asiap Apps Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(to right, #FFD54F, #82B1FF);
        color: #fff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .btn-custom {
        background-color: #ff7a18;
        color: #fff;
        border: none;
        transition: all 0.3s ease-in-out;
    }

    .btn-custom:hover {
        background-color: #ff5200;
    }

    .form-control {
        border-radius: 30px;
    }

    .input-group-text {
        background: #ff7a18;
        color: #fff;
        border: none;
        border-radius: 30px 0 0 30px;
    }

    a {
        color: #ff7a18;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-6">
            <div class="card p-5">
                <div class="text-center mb-4">
                    <h3 class="mt-3">Welcome Back!</h3>
                    <p class="text-muted">Please log in to your account.</p>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom btn-lg">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--app JS-->
<script src="assets/js/app.js"></script>
</body>

</html>
