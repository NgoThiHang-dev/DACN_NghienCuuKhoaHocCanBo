@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('admin.partials.content-header', ['name'=>'Giảng viên', 'key'=>'Sửa thông tin'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (count($errors)>0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>

                        @endif

                        @if (session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif
                        @if (session('loifile'))
                            <div class="alert alert-danger">
                                {{session('loifile')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif
                        <form method="post" style="width: 100%;" action="{{asset('admin/giangvien/update')}}/{{$giangvien->MaGV}}" enctype="multipart/form-data">
                            @csrf
                            <div class="panel panel-default" >

                                <div class="panel-body">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            @csrf
                                            <div class="mb-3">
                                                <label>Hình ảnh</label>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <img style="" height="125px" width="100px" src="{{asset('upload/giangvien')}}/{{$giangvien->HinhAnh}}" alt="{{$giangvien['HinhAnh']}}" srcset="">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <br><br><br><br>
                                                        <input type="file" class="form-control-file" name="HinhAnh">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label>Mã giảng viên</label>
                                                <input type="text" class="form-control" name="MaGV" value="{{$giangvien->MaGV}}" readonly>

                                            </div>

                                            <div class="mb-3">
                                                <label>Họ và tên giảng viên</label>
                                                <input type="text" class="form-control" name="TenGV" value="{{$giangvien->TenGV}}">
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Ngày sinh</label>
                                                        <input type="date" class="form-control" name="NgaySinh" value="{{$giangvien->NgaySinh}}" id="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Giới tính</label>
                                                        <select class="form-control" name="GioiTinh" >

                                                            {{--  <option value="Nam">Nam</option>
                                                            <option value="Nữ">Nữ</option>
                                                            <option value="Khác">Khác</option>  --}}
                                                            <?php
                                                                if($giangvien->GioiTinh=="Nam")
                                                                {
                                                                    echo '<option value="Nam" selected>Nam</option>
                                                                    <option value="Nữ">Nữ</option>
                                                                    <option value="Khác">Khác</option>';

                                                                }
                                                                if($giangvien->GioiTinh=="Nữ")
                                                                {
                                                                    echo '<option value="Nam">Nam</option>
                                                                    <option value="Nữ" selected>Nữ</option>
                                                                    <option value="Khác">Khác</option>';

                                                                }
                                                                if($giangvien->GioiTinh=="Khác")
                                                                {
                                                                    echo '<option value="Nam">Nam</option>
                                                                    <option value="Nữ">Nữ</option>
                                                                    <option value="Khác" selected>Khác</option>';

                                                                }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" id="" value="{{$giangvien->email}}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Số điện thoại liên lạc </label>
                                                <input type="tel" class="form-control" name="SDT" value="{{$giangvien->SDT}}" maxlength="11" pattern="[0-9]{4}[0-9]{3}[0-9]{3}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Địa chỉ</label>
                                                <input type="text" class="form-control" name="DiaChi" value="{{$giangvien->DiaChi}}">
                                            </div>

                                            <div class="mb-3">
                                                <label>Khoa công tác</label>
                                                <select class="form-control" name="MaKhoa" >

                                                    @foreach ($khoa as $value)
                                                    <option value="{{$value['MaKhoa']}}"
                                                    <?php if ($giangvien['MaKhoa']==$value['MaKhoa']):?>
                                                        selected="selected"
                                                        <?php endif ?>>
                                                            {{$value['TenKhoa']}}
                                                    </option>;
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="mb-3">
                                                <label>Chức vụ</label>
                                                <input type="text" class="form-control" name="ChucVu" value="{{$giangvien->ChucVu}}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Học vị</label>
                                                <select class="form-control" name="HocVi">
                                                    <option value="">Chọn học vị</option>
                                                    <?php
                                                        if($giangvien->HocVi=="Kỹ sư")
                                                        {
                                                            echo '<option value="Kỹ sư" selected>Kỹ sư</option>
                                                            <option value="Thạc sĩ">Thạc sĩ</option>
                                                            <option value="Tiến sĩ">Tiến sĩ</option>';

                                                        }
                                                        if($giangvien->HocVi=="Thạc sĩ")
                                                        {
                                                            echo '<option value="Kỹ sư">Kỹ sư</option>
                                                            <option value="Thạc sĩ" selected>Thạc sĩ</option>
                                                            <option value="Tiến sĩ">Tiến sĩ</option>';

                                                        }
                                                        if($giangvien->HocVi=="Tiến sĩ")
                                                        {
                                                            echo '<option value="Kỹ sư">Kỹ sư</option>
                                                            <option value="Thạc sĩ">Thạc sĩ</option>
                                                            <option value="Tiến sĩ" selected>Tiến sĩ</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="row g-2" style="float: right;">
                                                <div class="col-md-6">
                                                    <div class="mb-3" style="width: 130px;">
                                                        <button type="submit" class="btn btn-success">
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
                                                            href="{{asset('admin/giangvien/index')}}" role="button">
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


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection




