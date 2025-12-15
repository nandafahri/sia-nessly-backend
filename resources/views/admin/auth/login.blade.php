<!-- {--UI BIASA--} -->
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: url("{{ asset('admin/img/bg_log.png') }}") no-repeat center center fixed;
            background-size: cover;
        }

        .full-height-row {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            border-radius: 12px !important;
            overflow: hidden;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 30px;
            background: rgba(255, 255, 255, 0.85);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logo-container img {
            max-width: 75%;
            object-fit: contain;
        }

        .form-section {
            padding: 50px 40px !important;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
    </style>
</head>

<body>
    <div class="container full-height-row">
        <div class="col-xl-10 col-lg-11 col-md-10">
            <div class="card shadow-lg login-card">
                <div class="row no-gutters">

                    {{-- Kolom Logo --}}
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="logo-container">
                            <img src="{{ asset('admin/img/logo_sma.png') }}" alt="Logo Sekolah">
                        </div>
                    </div>

                    {{-- Kolom Form Login --}}
                    <div class="col-lg-6">
                        <div class="form-section">

                            <div class="text-center mb-4">
                                <h1 class="h4 text-gray-900">Selamat Datang Admin!</h1>
                                <p class="small text-muted mt-1">Silakan login untuk melanjutkan</p>
                            </div>

                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        name="email" placeholder="Masukkan Alamat Email..." value="{{ old('email') }}"
                                        required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        name="password" placeholder="Kata Sandi" required>
                                    @error('password')
                                        <div class="invalid-feedback mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="remember"
                                            name="remember">
                                        <label class="custom-control-label" for="remember">Ingat Saya</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>

                                <hr>
                            </form>

                            <div class="text-center">
                                <a class="small" href="#">Lupa Kata Sandi?</a>
                            </div>

                        </div>
                    </div>
                    {{-- End Kolom Form --}}

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

</body>
</html> -->



<!-- {-- MODERN UI TRANSPARAN --} -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Background utama */
        body {
            background: url("{{ asset('admin/img/bg_web.png') }}") no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(5px);
        }

        /* Posisi tengah */
        .full-height-row {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        /* Card Login Transparent Modern */
        .login-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        /* Panel logo kiri */
        .logo-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.25);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-container img {
            max-width: 80%;
            filter: drop-shadow(0 3px 8px rgba(0, 0, 0, 0.3));
        }

        /* Bagian form */
        .form-section {
            padding: 50px 40px;
        }

        .form-section h1 {
            font-weight: 700;
            color: #fff;
        }

        .form-section p {
            color: #f1f1f1;
        }

        /* Input lebih modern */
        .form-control-user {
            border-radius: 12px !important;
            padding: 12px 20px !important;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.35);
            color: #fff !important;
        }

        .form-control-user::placeholder {
            color: #e3e3e3 !important;
        }

        .form-control-user:focus {
            background: rgba(255, 255, 255, 0.55);
            border-color: #fff;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
        }

        /* Tombol login */
        .btn-primary {
            background: linear-gradient(135deg, #4e73df, #224abe);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2e59d9, #1d3a99);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        /* Link */
        .text-center a {
            color: #fff !important;
            text-decoration: underline;
            opacity: 0.9;
        }

        .text-center a:hover {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container full-height-row">
        <div class="col-xl-10 col-lg-11 col-md-11">
            <div class="card login-card shadow-lg">
                <div class="row no-gutters">

                    {{-- KIRI: LOGO --}}
                    <div class="col-lg-6 d-none d-lg-flex">
                        <div class="logo-container">
                            <img src="{{ asset('admin/img/logo_sma.png') }}" alt="Logo Sekolah">
                        </div>
                    </div>

                    {{-- KANAN: FORM LOGIN --}}
                    <div class="col-lg-6">
                        <div class="form-section">

                            <div class="text-center mb-4">
                                <h1 class="h4 mb-1">Selamat Datang Admin!</h1>
                                <p class="small mt-1">Login untuk melanjutkan ke dashboard</p>
                            </div>

                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        name="email"
                                        placeholder="Masukkan Alamat Email..."
                                        value="{{ old('email') }}"
                                        required autofocus>

                                    @error('email')
                                        <div class="invalid-feedback mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        name="password"
                                        placeholder="Kata Sandi"
                                        required>

                                    @error('password')
                                        <div class="invalid-feedback mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <div class="custom-control custom-checkbox small text-white">
                                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                        <label class="custom-control-label" for="remember">Ingat Saya</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>

                                <hr>
                            </form>

                            <div class="text-center">
                                <a class="small" href="#">Lupa Kata Sandi?</a>
                            </div>

                        </div>
                    </div>
                    {{-- END FORM --}}

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
