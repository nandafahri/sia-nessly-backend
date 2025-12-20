<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password Admin</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: url("{{ asset('admin/img/bg_web.png') }}") no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(5px);
        }
        .full-height-row {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }
        .form-section {
            padding: 50px 40px;
            color: #fff;
        }
        .form-control-user {
            border-radius: 12px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.35);
            color: #fff;
        }
        .btn-primary {
            border-radius: 12px;
            font-weight: 600;
        }
        .invalid-feedback { display: block; color: #ff6b6b; }
    </style>
</head>
<body>
<div class="container full-height-row">
    <div class="col-lg-6">
        <div class="card login-card">
            <div class="form-section">

                <div class="text-center mb-4">
                    <h1 class="h4">Reset Password</h1>
                    <p class="small">Masukkan kata sandi baru Anda</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.password.reset') }}">
                    @csrf

                    <div class="form-group">
                        <input type="password"
                               class="form-control form-control-user @error('password') is-invalid @enderror"
                               name="password"
                               placeholder="Kata Sandi Baru"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password"
                               class="form-control form-control-user"
                               name="password_confirmation"
                               placeholder="Konfirmasi Kata Sandi Baru"
                               required>
                    </div>

                    <button class="btn btn-primary btn-block">
                        Simpan Kata Sandi
                    </button>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small text-white" href="{{ route('admin.login.form') }}">
                        Kembali ke Login
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
