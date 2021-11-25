@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Loại đề tài', 'key'=>'Sửa thông tin'])
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
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Thêm Loại đề tài</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ asset('admin/loaidetai/update') }}/{{ $loaidetai->id_LoaiDeTai }}"
                                    method="post" style="width: 100%;">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <label>ID loại đề tài</label>
                                                        <input type="text" class="form-control" name="id_LoaiDeTai" readonly
                                                            value="{{ $loaidetai->id_LoaiDeTai }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tên loại đề tài</label>
                                                        <input type="text" class="form-control" name="TenLoaiDeTai" id=""
                                                            value="{{ $loaidetai->TenLoaiDeTai }}">
                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="mb-3">
                                                        <label>Đơn vị tính</label>
                                                        <input type="text" class="form-control" name="DonViTinh"
                                                            value="{{ $loaidetai->DonViTinh }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tiết quy đổi</label>
                                                        <input type="text" class="form-control" name="TietQuyDoi"
                                                            value="{{ $loaidetai->TietQuyDoi }}">
                                                    </div>
                                                    <div class="row g-2" style="float: right">
                                                        <div class="col-md-6">
                                                            <div class="mb-3" style="width: 130px;">
                                                                    <button type="submit" class="btn btn-success">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                            height="16" fill="currentColor"
                                                                            class="bi bi-save" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                        </svg> Lưu kết quả
                                                                    </button>

                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3" style="float: right">
                                                                <a class="btn btn-danger them"
                                                                    href="{{ asset('admin/loaidetai/index') }}"
                                                                    role="button">
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
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
