@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Bài báo nghiên cứu khoa học', 'key'=>'Sửa'])
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
                                        Chỉnh sửa thông tin bài báo
                                    </h4>
                                </div>
                            </a>
                            <br>
                            <form action="" method="post" style="width: 100%;" enctype="multipart/form-data">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        @csrf

                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>ID bài báo <i style="color: red">*</i></label>
                                                    <input type="text" class="form-control" name="id_DeTai" value="{{ $baibao->id_DeTai }}" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tên bài báo <i style="color: red">*</i></label>
                                                    <input type="text" class="form-control" name="TenDeTai" id="" value="{{ $baibao->TenDeTai }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tên tạp trí <i style="color: red">*</i></label>
                                                    <input type="text" class="form-control" name="TenTapChi" id="" value="{{ $baibao->TenTapChi }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tóm tắt <i style="color: red">*</i></label>
                                                    <textarea class="form-control" name="TomTat" rows="6">{{ $baibao->TomTat }}</textarea>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Loại đề tài <i style="color: red">*</i></label>
                                                    <select class="form-control" name="id_LoaiDeTai" >
                                                        @foreach ($loaidetai as $value)
                                                            <option value="{{$value['id_LoaiDeTai']}}"
                                                            <?php if ($baibao['id_LoaiDeTai']==$value['id_LoaiDeTai']):?>
                                                                selected="selected"
                                                                <?php endif ?>>
                                                                    {{$value['TenLoaiDeTai']}}
                                                            </option>;
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Năm Xuất bản<i style="color: red">*</i></label>
                                                            <input type="text" class="form-control" name="NamXB" id="" value="{{ $baibao->NamXB }}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Năm học <i style="color: red">*</i></label>
                                                            <select class="form-control" name="id_ThoiGian">
                                                                @foreach ($thoigian as $value)
                                                                <option value="{{$value['id_ThoiGian']}}"
                                                                <?php if ($baibao['id_ThoiGian']==$value['id_ThoiGian']):?>
                                                                selected="selected"
                                                                <?php endif ?>>
                                                                Năm học: {{$value['NamHoc']}} - Học kỳ: {{$value['HocKy']}}
                                                                </option>;
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tình trạng<i style="color: red">*</i></label>
                                                            <select class="form-control" name="TinhTrang">
                                                                <?php
                                                                if($baibao->TinhTrang=="Hoàn thành"){
                                                                    echo'<option value="Hoàn thành" selected>Hoàn thành</option>
                                                                    <option value="Chưa hoàn thành">Chưa hoàn thành</option>';
                                                                }
                                                                if($baibao->TinhTrang=="Chưa hoàn thành"){
                                                                    echo'<option value="Hoàn thành">Hoàn thành</option>
                                                                    <option value="Chưa hoàn thành" selected >Chưa hoàn thành</option>';
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Ngày nghiệm thu <i style="color: red">*</i></label>
                                                            <input type="date" class="form-control" name="NgayNghiemThu" id="" value="{{ $baibao->NgayNghiemThu }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Trang <i style="color: red">*</i></label>
                                                    <input type="text" class="form-control" name="Trang" id="" value="{{ $baibao->Trang }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tệp đính kèm <label style="color: red">*</label></label>
                                                    <p>{{ $baibao->TepDinhKem }}</p>
                                                    <input type="file" class="form-control-file" name="TepDinhKem" value="{{ $baibao->TepDinhKem }}">
                                                </div>
                                                <div class="row g-2" style="float: right">
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
                                                                href="{{ asset('admin/nghiencuu/baibao/index') }}" role="button">
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


                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
