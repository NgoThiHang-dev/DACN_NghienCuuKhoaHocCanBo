@include('users.layout.index')

<body>
    @include('users.partials.header')
    <div id="container" style="margin:0px auto; width:95%">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb" style="float: right; font-size:15px;">
                            <li class="breadcrumb-item">
                                <a style="text-decoration:none; font-weight:bold;" href="{{ asset('users/index') }}">
                                    <p style="font-weight:bold;"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"
                                            style="margin-top: -5px">
                                            <path fill-rule="evenodd"
                                                d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                            <path fill-rule="evenodd"
                                                d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                                        </svg> Trang chủ</p>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a style="text-decoration:none;font-weight:bold;"
                                    href="{{ asset('users/nghiencuu/detai/index') }}">
                                    NCKH
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a style="text-decoration:none;font-weight:bold;"
                                    href="{{ asset('users/nghiencuu/tlgd/index') }}">
                                    Tài liệu
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a style="text-decoration:none; color:black"
                                    href="{{ asset('users/nghiencuu/detai/update') }}">
                                    Sửa thông tin tác giả
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h3 class="title" style="color: green">Chỉnh sửa thông tin tác giả</h3>
                    </div>
                    @if (session('thongbao'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('thongbao') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    @endif
                    @if (session('thongbao1'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('thongbao1') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                    <div class="col-12">
                        <form action="" method="post" style="width: 90%; margin: 0px auto; "
                            enctype="multipart/form-data">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">ID đề tài<i style="color: red">*</i></label>
                                                <input type="text" class="form-control" name="id_DeTai"
                                                    value="{{ $detai->id_DeTai }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mã giảng viên<i style="color: red">*</i></label>
                                                <input type="text" class="form-control" name="MaGV"
                                                    value="{{ $tacgia->MaGV }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label">Tên đề tài<i style="color: red">*</i></label>
                                                <input type="text" class="form-control" name="TenDeTai"
                                                    value="{{ $detai->TenDeTai }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Họ tên giảng viên<i style="color: red">*</i></label>
                                                <input type="text" class="form-control" name="TenGV"
                                                    value="{{ $tacgia->TenGV }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Vai trò<i style="color: red">*</i></label>
                                                <select class="form-control" name="VaiTro" disabled>
                                                    <?php
                                                        if($tg_dt->VaiTro=="Tác giả chính")
                                                        {
                                                            echo '<option selected value="Tác giả chính">Tác giả chính</option>
                                                            <option value="Đồng tác giả">Đồng tác giả</option>';

                                                        }
                                                        if($tg_dt->VaiTro=="Đồng tác giả")
                                                        {
                                                            echo '<option value="Tác giả chính">Tác giả chính</option>
                                                            <option selected value="Đồng tác giả">Đồng tác giả</option>';

                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Ngày bắt đầu tham gia<i style="color: red">*</i></label>
                                                <input type="date" class="form-control" name="NgayThamGia" value="{{$tg_dt->NgayThamGia}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Ngày kết thúc<i style="color: red">*</i></label>
                                                <input type="date" class="form-control" name="NgayKetThucTG" value="{{$tg_dt->NgayKetThucTG}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row g-2" style="float: right; width:30%;">
                                                <div class="col-md-7">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success"
                                                            style="color: #fff">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-save"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                            </svg> Lưu kết quả
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="mb-3">
                                                        <a style="color: #fff" class="btn btn-danger them"
                                                            href="{{ asset('users/nghiencuu/tlgd/index') }}" role="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-x"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                            </svg> Thoát
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div><br><br>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    </div>
    @include('users.partials.footer')
</body>
