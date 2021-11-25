<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{asset('admin/home')}}" class="brand-link">
        <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản lý NCKH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php $hinh = App\Models\GiangVien::find($user->MaGV)->HinhAnh;?>
                <img src="{{asset('upload/giangvien')}}/{{$hinh}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php echo App\Models\GiangVien::find($user->MaGV)->TenGV;?>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                {{--                Khoa--}}
                <li class="nav-item menu-open">
                    <a href="{{asset('admin/khoa/index')}}" class="nav-link active">
                        <i class="bi bi-building"></i>
                        <p style="margin-left: 10px;">
                            Khoa
                        </p>
                    </a>
                </li>
                {{-- Giang Vien --}}
                <li class="nav-item menu-open">
                    <a href="{{asset('admin/giangvien/index')}}" class="nav-link active">
                        <i class="bi bi-briefcase"></i>
                        <p style="margin-left: 10px;">
                            Giảng viên

                        </p>
                    </a>
                </li>
                {{-- TaiKhoan --}}
                <li class="nav-item menu-open">
                    <a href="{{asset('admin/taikhoan/index')}}" class="nav-link active">
                        <i class="bi bi-person-lines-fill"></i>
                        <p style="margin-left: 10px;">
                            Tài khoản

                        </p>
                    </a>
                </li>
{{--                Loai de tai--}}
                <li class="nav-item menu-open">
                    <a href="{{asset('admin/loaidetai/index')}}" class="nav-link active">
                        <i class="bi bi-view-list"></i>
                        <p style="margin-left: 10px;">
                            Loại đề tài

                        </p>
                    </a>
                </li>

                {{--                Quan ly de tai--}}
                <li class="nav-item menu-close">
                    <a href="{{asset('admin/nghiencuu/detai/index')}}" class="nav-link active">
                        <i class="bi bi-kanban"></i>
                        <p style="margin-left: 10px;">
                            Quản lý đề tài
                        </p>
                    </a>
                  
                </li>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link active">

                        <i class="bi bi-graph-up"></i>
                        <p style="margin-left: 10px;">
                            Thống kê
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{asset('admin/thongke/theokhoa/index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Theo khoa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{asset('admin/thongke/theogiangvien/index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Theo giảng viên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{asset('admin/thongke/theoloai/index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Theo loại NCKH</p>
                            </a>
                        </li>
                    </ul>
                </li>


                {{--  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Khác
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Xuất File</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Import File</p>
                            </a>
                        </li>

                    </ul>
                </li>  --}}
                {{-- Đăng xuất --}}
                <li class="nav-item menu-open">
                    <a href="{{asset('admin/logout')}}" class="nav-link active" style="background-color: rgb(175, 35, 35);">
                        <i class="bi bi-box-arrow-left"></i>
                        <p style="margin-left: 10px;">
                            Đăng xuất

                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
