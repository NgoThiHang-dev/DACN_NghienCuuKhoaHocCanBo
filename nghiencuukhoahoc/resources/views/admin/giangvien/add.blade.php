@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Giảng viên', 'key'=>'Thêm'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $err)
                                    {{ $err }}<br>
                                @endforeach
                            </div>

                        @endif

                        @if (session('thongbao'))
                            <div class="alert alert-success">
                                {{ session('thongbao') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif
                        @if (session('thongbao1'))
                            <div class="alert" style="background: #F8D7DA; border: 1px solid #F5C2C7" role="alert">
                                {{ session('thongbao1') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif

                        <div class="col-12">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Thêm giảng viên</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" style="width: 100%;" enctype="multipart/form-data">
                                        <div class="panel panel-default">

                                            <div class="panel-body">
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        @csrf

                                                                <div class="mb-3">
                                                                    <label>Mã giảng viên <label style="color: red">*</label></label>
                                                                    <input type="text" class="form-control" name="MaGV">
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label>Họ và tên giảng viên <label style="color: red">*</label></label>
                                                                    <input type="text" class="form-control" name="TenGV">
                                                                </div>



                                                        <div class="row g-2">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label>Ngày sinh <label style="color: red">*</label></label>
                                                                    <input type="date" class="form-control" name="NgaySinh" id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label>Giới tính <label style="color: red">*</label></label>
                                                                    <select class="form-control" name="GioiTinh">
                                                                        <option value="Nam">Nam</option>
                                                                        <option value="Nữ">Nữ</option>
                                                                        <option value="Khác">Khác</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label>Email <label style="color: red">*</label></label>
                                                            <input type="email" class="form-control" name="email" id="">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Số điện thoại liên lạc <label style="color: red">*</label></label>
                                                            <input type="tel" class="form-control" name="SDT" maxlength="11"
                                                                pattern="[0-9]{4}[0-9]{3}[0-9]{3}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="mb-3">
                                                            <label>Địa chỉ <label style="color: red">*</label></label>
                                                            <input type="text" class="form-control" name="DiaChi">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label>Khoa công tác <label style="color: red">*</label></label>
                                                            <select class="form-control" name="MaKhoa">
                                                                <option value="">Chọn Khoa công tác</option>
                                                                @foreach ($khoa as $value)
                                                                    <option value="{{ $value['MaKhoa'] }}">{{ $value['TenKhoa'] }}
                                                                    </option>;
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Học vị <label style="color: red">*</label></label>
                                                            <select class="form-control" name="HocVi">
                                                                <option value="">Chọn học vị</option>
                                                                <option value="Kỹ sư">Kỹ sư</option>
                                                                <option value="Thạc sĩ">Thạc sĩ</option>
                                                                <option value="Tiến sĩ">Tiến sĩ</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Chức vụ <label style="color: red">*</label></label>
                                                            <input type="text" class="form-control" name="ChucVu">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Hình ảnh <label style="color: red">*</label></label>
                                                            <input type="file" class="form-control-file" name="HinhAnh">
                                                        </div>
                                                        <div class="row g-2" style="float: right;">
                                                            <div class="col-md-6">
                                                                <div class="mb-3" style="width: 130px;">
                                                                    <button name="THEM" type="submit" class="btn btn-success">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                            fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                        </svg> Lưu kết quả
                                                                    </button>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3" style="float: right">
                                                                    <a class="btn btn-danger them"
                                                                        href="{{ asset('admin/giangvien/index') }}" role="button">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                            fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
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
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                        {{--  <form action="" method="post" style="width: 100%;" enctype="multipart/form-data">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            @csrf
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Mã giảng viên <label style="color: red">*</label></label>
                                                        <input type="text" class="form-control" name="MaGV">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Họ và tên giảng viên <label style="color: red">*</label></label>
                                                        <input type="text" class="form-control" name="TenGV">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Ngày sinh <label style="color: red">*</label></label>
                                                        <input type="date" class="form-control" name="NgaySinh" id="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Giới tính <label style="color: red">*</label></label>
                                                        <select class="form-control" name="GioiTinh">
                                                            <option value="Nam">Nam</option>
                                                            <option value="Nữ">Nữ</option>
                                                            <option value="Khác">Khác</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Email <label style="color: red">*</label></label>
                                                <input type="email" class="form-control" name="email" id="">
                                            </div>
                                            <div class="mb-3">
                                                <label>Số điện thoại liên lạc <label style="color: red">*</label></label>
                                                <input type="tel" class="form-control" name="SDT" maxlength="11"
                                                    pattern="[0-9]{4}[0-9]{3}[0-9]{3}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="mb-3">
                                                <label>Địa chỉ <label style="color: red">*</label></label>
                                                <input type="text" class="form-control" name="DiaChi">
                                            </div>

                                            <div class="mb-3">
                                                <label>Khoa công tác <label style="color: red">*</label></label>
                                                <select class="form-control" name="MaKhoa">
                                                    <option value="">Chọn Khoa công tác</option>
                                                    @foreach ($khoa as $value)
                                                        <option value="{{ $value['MaKhoa'] }}">{{ $value['TenKhoa'] }}
                                                        </option>;
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Chức vụ <label style="color: red">*</label></label>
                                                <input type="text" class="form-control" name="ChucVu">
                                            </div>
                                            <div class="mb-3">
                                                <label>Hình ảnh <label style="color: red">*</label></label>
                                                <input type="file" class="form-control-file" name="HinhAnh">
                                            </div>
                                            <div class="row g-2" style="float: right;">
                                                <div class="col-md-6">
                                                    <div class="mb-3" style="width: 130px;">
                                                        <button name="THEM" type="submit" class="btn btn-success">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                            </svg> Lưu kết quả
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3" style="float: right">
                                                        <a class="btn btn-danger them"
                                                            href="{{ asset('admin/giangvien/index') }}" role="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
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
                        </form>  --}}
                    </div>


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
