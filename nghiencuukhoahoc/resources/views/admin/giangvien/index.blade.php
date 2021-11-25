@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Giảng viên', 'key'=>'Danh sách'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
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
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ asset('admin/giangvien/add') }}" class="btn btn-success float-right"
                            style="margin-bottom: 10px">
                            <i class="bi bi-plus"></i>Thêm
                        </a>

                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered" >
                            <thead>
                                <tr style="background: #32CD32;border: 1px solid #bee5eb;">
                                    <th style="width:50px;text-align: center">STT</th>
                                    <th style="text-align: center;">Mã giảng viên</th>
                                    <th style="text-align: center;">Tên giảng viên</th>
                                    <th style="text-align: center;">Khoa</th>
                                    <th style="text-align: center;">Email</th>
                                    <th style="text-align: center;">SĐT</th>
                                    <th style="text-align: center;">Chức vụ</th>
                                    <th style="text-align: center;">Ngày sinh</th>
                                    <th style="text-align: center;">Giới tính</th>
                                    <th style="text-align: center;">Địa chỉ</th>
                                    <th style="text-align: center;">Sửa</th>
                                    <th style="text-align: center;">Xóa</th>

                                </tr>
                            </thead>
                            <?php $i=1;?>
                            @foreach ($giangvien as $row)
                                <tr style="background: #fff">
                                    <td style="text-align: center;">
                                        <?php echo $i++;?>
                                    </td>
                                    <td style="text-align: center;">
                                        <span>{{ $row->MaGV }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->TenGV }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span>{{ $row->MaKhoa }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->email }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->SDT }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->ChucVu }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->NgaySinh }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span>{{ $row->GioiTinh }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->DiaChi }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ asset('admin/giangvien/update') }}/{{ $row->MaGV }}">
                                            <button class="btn btn-secondary">
                                                <i class="bi bi-pencil-square"></i></i>
                                            </button>

                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ asset('admin/giangvien/delete') }}/{{ $row->MaGV }}">
                                            <button class="btn btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
                <span style="float: right">
                    {{ $giangvien->appends(['sort' => 'id'])->links() }}
                </span>
                <br>
                <br>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->




@endsection
