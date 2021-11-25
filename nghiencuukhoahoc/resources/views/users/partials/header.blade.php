<!-- Header -->
<nav id="main_nav" class="navbar navbar-expand-lg navbar-light bg-white shadow" style="width:95%; margin:0px auto;">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand h1" href="index.html">
            <i class='bx bx-buildings bx-sm text-dark'></i>
            <span class="text-dark h4">Trường đại học</span> <span class="text-primary h4">Đà Lạt</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar-toggler-success" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between"
            id="navbar-toggler-success">
            <div class="flex-fill mx-xl-3 mb-2">
                <ul class="nav navbar-nav d-flex  mx-xl-5 text-center text-dark">
                    {{--  <li class="nav-item">
                        <a class="nav-link btn-outline-primary rounded-pill px-3"
                            href="{{ asset('users/index') }}">Trang chủ</a>
                    </li>  --}}
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary rounded-pill px-3"
                            href="{{ asset('users/nghiencuu/detai/index') }}">NCKH</a>
                    </li>
                    {{--  <li class="nav-item">
                        <a class="nav-link btn-outline-primary rounded-pill px-3" href="work.html">Thống kê</a>
                    </li>  --}}
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary rounded-pill px-3"
                            href="#">Liên hệ</a>
                    </li>

                </ul>
            </div>
            <div class="navbar" style="margin-top: -10px;">
                <ul class="nav nav-pills ">
                    <li class="nav-item dropdown sua">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false">Xin chào, <?php echo
                            App\Models\GiangVien::find($user->MaGV)->TenGV; ?></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ asset('users/my') }}">Trang cá nhân</a></li>
                            <li><a class="dropdown-item" href="{{ asset('users/doimatkhau') }}" >Đổi mật khẩu</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ asset('users/logout') }}">Đăng xuất</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>
<img class="rounded mx-auto d-block" src="{{ asset('users/assets/images/DLU-Logo-and-Slogan.png') }}" alt=""
    style="width:95%; margin:0px auto;">
<!-- Close Header -->
