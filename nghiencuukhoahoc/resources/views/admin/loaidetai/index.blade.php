@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Loại đề tài', 'key'=>'Danh sách'])
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
                <div class="row" style=" float: right;">
                    <div class="form-group mb-2" style="float: right;">
                        <a href="{{ asset('admin/loaidetai/add') }}" class="btn btn-success float-right">
                            <i class="bi bi-plus"></i>Thêm</a>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <a href="{{ asset('admin/loaidetai/export') }}" class="btn btn-success float-right">
                            <i class="bi bi-download"></i> Xuất Excel</a>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr style="background: #32CD32;border: 1px solid #bee5eb;">
                                    <th style="text-align: center;">ID</th>
                                    <th style="text-align: center;">Tên loại sản phẩm</th>
                                    <th style="text-align: center;">Đơn vị tính</th>
                                    <th style="text-align: center;">Tiết quy đổi</th>
                                    <th style="text-align: center;">Sửa</th>
                                    <th style="text-align: center;">Xóa</th>

                                </tr>
                            </thead>
                            @foreach ($loaidetai as $row)
                                <tr style="background: #fff">
                                    <td style="text-align: center;">
                                        <span>{{ $row->id_LoaiDeTai }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->TenLoaiDeTai }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->DonViTinh }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->TietQuyDoi }}</span>
                                    </td>

                                    <td style="text-align: center;">
                                        <a href="{{ asset('admin/loaidetai/update') }}/{{ $row->id_LoaiDeTai }}">
                                            <button class="btn btn-secondary">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ asset('admin/loaidetai/delete') }}/{{ $row->id_LoaiDeTai }}">
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
                {{-- <span style="float: right">{!! $loaidetai->render() !!}</span> --}}
                {{-- {!! $loaidetai->render() !!} --}}
                <span style="float: right">
                    {{ $loaidetai->appends(['sort' => 'id'])->links() }}
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
