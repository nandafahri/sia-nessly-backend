<nav class="navbar navbar-expand topbar-modern mb-4 static-top">

    <!-- Sidebar Toggle (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto align-items-center">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline username">
                    {{ Auth::guard('admin')->user()->name }}
                </span>

                <!-- Foto Profil Modern -->
                <img class="img-profile rounded-circle"
                     src="{{ Auth::guard('admin')->user()->foto_profil 
                        ? asset('profile_photos/' . Auth::guard('admin')->user()->foto_profil)
                        : asset('admin/img/undraw_profile.svg') }}">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<style>
    /* Topbar Modern */
.topbar-modern {
    background: #ffffff;
    border-bottom: 1px solid #e4e6ef;
    height: 64px;
    box-shadow: 0px 2px 10px rgba(0,0,0,0.04);
}

/* Nama user */
.topbar-modern .username {
    font-weight: 600;
    color: #4a4a4a !important;
    font-size: 15px;
}

/* Foto Profil */
.topbar-modern .img-profile {
    width: 38px;
    height: 38px;
    object-fit: cover;
    border: 2px solid #e4e6ef;
}

/* Dropdown menu */
.navbar .dropdown-menu {
    border-radius: 10px;
    padding: 8px 0;
    border: 1px solid #e5e7eb;
}

/* Dropdown Item Modern */
.dropdown-item {
    font-size: 14px;
    padding: 10px 18px;
    transition: 0.2s;
}

.dropdown-item:hover {
    background: #f2f4f8;
    color: #000;
}

/* Divider */
.topbar-divider {
    border-left: 1px solid #d1d3e2;
    margin: 0 10px;
}

</style>