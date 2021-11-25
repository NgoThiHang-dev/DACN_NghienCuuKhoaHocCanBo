@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Nghiên cứu', 'key'=>'Danh sách'])
        <!-- /.content-header -->

        <!-- Main content -->

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link" href="{{asset('admin/nghiencuu/detai/index')}}">Đề tài nghiên cứu khoa học</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{asset('admin/nghiencuu/baibao/index')}}">Bài báo đăng trên các tạp chí khoa học</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{asset('admin/nghiencuu/tlgd/index')}}">Sách, giáo trình, tài liệu giảng dạy</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="{{asset('admin/nghiencuu/khac/index')}}">Các hoạt động nghiên cứu khoa học khác</a>
                        </li>
                      </ul>
                </div>
                <br>
                <div class="row">
                    <p style="color: rgb(100, 99, 99)">(<b>Các hoạt động nghiên cứu khác bao gồm: </b> Hướng dẫn luận văn Thạc sĩ, luận án Tiến sĩ, thẩm định các công trình khoa học, tham gia các Hội đồng khoa học chấm luận văn Thạc sĩ, luận án Tiến sĩ,...)</p>
                </div>
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
                        <a href="{{ asset('admin/nghiencuu/khac/add') }}" class="btn btn-success float-right">
                            <i class="bi bi-plus"></i>Thêm</a>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <a href="{{ asset('admin/nghiencuu/khac/excel') }}" class="btn btn-success float-right">
                            <i class="bi bi-download"></i> Xuất Excel</a>
                    </div>
                </div>
                <br>
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered" style="background: #fff" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr style="border: 1px solid #fff; font-weight:bold">
                                    <td style="text-align: center;" rowspan="2">ID</td>
                                    <td style="text-align: center;" rowspan="2">Tên hoạt động khoa học khác</td>
                                    <td colspan="2" style="text-align: center;width:26%">Tác giả</td>
                                    <td style="text-align: center;" rowspan="2">Năm thực hiện</td>
                                    <td style="text-align: center;" rowspan="2">Loại hoạt động</td>
                                    <td style="text-align: center;" rowspan="2">Tại cơ sở</td>
                                    <td style="text-align: center;" rowspan="2">Tệp đính kèm</td>
                                    <td style="text-align: center;" rowspan="2">Sửa</td>
                                    <td style="text-align: center;" rowspan="2">Xóa</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;width:13%">Tác giả</td>
                                    <td style="text-align: center;width:13%">Đồng tác giả</td>
                                </tr>

                            </thead>
                            @foreach ($detai as $row)
                                <tr style="background: #fff">
                                    <td style="text-align: center">
                                        <span>{{ $row->id_DeTai }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->TenDeTai }}</span>
                                    </td>
                                    <td>
                                        <?php $dem=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');?>
                                        @if ($dem==0)
                                        <a type="button" class="btn btn-link" href="{{ asset('admin/nghiencuu/khac/addTG') }}/{{ $row->id_DeTai }}">Thêm tác giả</a>
                                        @endif
                                        <span>
                                            <?php $ma_tg=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Tác giả chính"]])->get();?>
                                            @foreach ($ma_tg as $ma)
                                            <br>
                                            <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b><br>
                                            <li style="font-size: 14px; color:gray">Giờ NCKH: {{$ma->SoTiet}}</li>
                                                <a style="float: right;" href="{{ asset('admin/nghiencuu/khac/deleteTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}" >
                                                    <i class="bi bi-x-square-fill" style="color:red;"></i>
                                                </a>
                                                <a style="float: right; margin-right:10px;" href="{{ asset('admin/nghiencuu/khac/updateTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                            @endforeach
                                        </span>
                                    </td>
                                    <td>

                                        <span>
                                            <?php $ma_tg=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Đồng tác giả"]])->get();?>
                                            @foreach ($ma_tg as $ma)
                                                <br>
                                                <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b><br>
                                                <li style="font-size: 14px; color:gray">Giờ NCKH: {{$ma->SoTiet}}</li>
                                                <a style="float: right;" href="{{ asset('admin/nghiencuu/khac/deleteTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}" >
                                                    <i class="bi bi-x-square-fill" style="color:red;"></i>
                                                </a>
                                                <a style="float: right; margin-right:10px;" href="{{ asset('admin/nghiencuu/khac/updateTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endforeach
                                        </span>
                                        <a type="button" class="btn btn-link" href="{{ asset('admin/nghiencuu/khac/addTG') }}/{{ $row->id_DeTai }}">Thêm tác giả</a>
                                    </td>
                                    <td style="text-align: center;">
                                        <span>
                                           {{ $row->NgayNghiemThu }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{ $row->DinhDang }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $row->CoSoTC }}</span>
                                    </td>
                                    <td>
                                        <span>
                                            <a href="{{asset('admin/nghiencuu/download/')}}/{{ $row->TepDinhKem }}">{{ $row->TepDinhKem }}</a>
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ asset('admin/nghiencuu/khac/update') }}/{{ $row->id_DeTai }}">
                                            <button class="btn btn-secondary">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ asset('admin/nghiencuu/khac/delete') }}/{{ $row->id_DeTai }}">
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
