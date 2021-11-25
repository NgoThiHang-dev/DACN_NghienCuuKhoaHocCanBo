@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('admin.partials.content-header', ['name'=>'Tài khoản', 'key'=>'Danh sách'])
        <!-- /.content-header -->

        <!-- Main content -->

            <div class="container-fluid">
                <div class="content">
                    @if (session('thongbao'))
                    <div class="alert alert-success" role="alert">
                        {{ session('thongbao') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr style="background: #32CD32;border: 1px solid #bee5eb;">
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Tên giảng viên</th>
                                <th style="text-align: center;">Loại tài khoản</th>
                                <th style="text-align: center;">Đổi quyền</th>
                                <th style="text-align: center;">Reset Password</th>
                                <th style="text-align: center;">Xóa</th>

                                </tr>
                            </thead>
                            @foreach ($users as $row)
                            <tr style="background: #fff">
                                <td style="text-align: center;">
                                    {{$row->id}}
                                </td>
                                <td>
                                    {{$row->email}}
                                </td>
                                <td>
                                    <?php
                                        echo App\Models\GiangVien::find($row->MaGV)->TenGV;
                                    ?>

                                </td>
                                <td>
                                    @if ($row->LoaiTK=="1")
                                        {{ "Admin" }}
                                    @else
                                        {{ "User" }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($row->LoaiTK=="1")
                                    <a href="{{asset('admin/taikhoan/quyen') }}/{{$row->id}}" class="btn btn-outline-danger">Thu hồi quyền</a>
                                    @else
                                    <a href="{{asset('admin/taikhoan/quyen') }}/{{$row->id}}" class="btn btn-outline-success">Cấp quyền Admin</a>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ asset('admin/taikhoan/pass') }}/{{$row->id}}" >
                                        <button class="btn btn-info">
                                            <i class="bi bi-key"></i>
                                        </button>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{asset('admin/taikhoan/delete') }}/{{$row->id}}" >
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
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection



