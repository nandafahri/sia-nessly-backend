<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body id="page-top">

    <div id="wrapper">

        {{-- Sidebar (Ambil dari template SB Admin 2) --}}
        @include('admin.layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                {{-- Topbar (Ambil dari template SB Admin 2) --}}
                @include('admin.layouts.topbar')

                <div class="container-fluid">
                    @yield('content')
                </div>
                </div>
            {{-- Footer --}}
            @include('admin.layouts.footer')

        </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('admin.layouts.logout-modal')

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    @stack('scripts')

    
</body>
</html>

