@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Đề tài nghiên cứu khoa học', 'key'=>'Thêm'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            @if (session('thongbao'))
                <div class="alert alert-success">
                    {{ session('thongbao') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline" style="padding: 5px">
                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                <div class="card-header">
                                    <h4 class="card-title w-100" style="text-align: center; text-transform: uppercase">
                                        Chỉnh sửa thông tin tác giả
                                    </h4>
                                </div>
                            </a>
                            <br>
                            <form action="" method="post" style="width: 100%;" enctype="multipart/form-data">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label>ID bài báo</label>
                                                    <input type="text" class="form-control" name="id_DeTai"
                                                        value="{{ $detai->id_DeTai }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tên bài báo <i style="color: red">*</i></label>
                                                    <input type="text" class="form-control" name="TenDeTai" id=""
                                                        value="{{ $detai->TenDeTai }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-7">
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label>Tác giả <i style="color: red">*</i></label>
                                                            <select class="form-control" name="MaGV" disabled>
                                                                @foreach ($gv as $value)
                                                                <option value="{{$value['MaGV']}}"
                                                                <?php if ($tg['MaGV']==$value['MaGV']):?>
                                                                    selected="selected"
                                                                    <?php endif ?>>
                                                                        {{$value['TenGV']}}
                                                                </option>;
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label>Vai trò <i style="color: red">*</i></label>
                                                            <select class="form-control" name="VaiTro" disabled>
                                                                <?php
                                                                    if($tg->VaiTro=="Tác giả chính")
                                                                    {
                                                                        echo '<option selected value="Tác giả chính">Tác giả chính</option>
                                                                        <option value="Đồng tác giả">Đồng tác giả</option>';

                                                                    }
                                                                    if($tg->VaiTro=="Đồng tác giả")
                                                                    {
                                                                        echo '<option value="Tác giả chính">Tác giả chính</option>
                                                                        <option selected value="Đồng tác giả">Đồng tác giả</option>';

                                                                    }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label>Ngày bắt đầu tham gia</label>
                                                            <input type="date" class="form-control" name="NgayThamGia" value="{{ $tg->NgayThamGia }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label>Ngày kết thúc</label>
                                                            <input type="date" class="form-control" name="NgayKetThucTG" value="{{ $tg->NgayKetThucTG }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2" style="float: right">
                                                    <div class="col-md-6">
                                                        <div class="mb-3" style="width: 130px;">
                                                            <button type="submit" class="btn btn-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-save"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                </svg> Lưu kết quả
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3" style="float: right">
                                                            <a class="btn btn-danger them" style="text-decoration: none; color: #fff"
                                                                href="{{ asset('admin/nghiencuu/tlgd/index') }}"
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
                    </div>


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
