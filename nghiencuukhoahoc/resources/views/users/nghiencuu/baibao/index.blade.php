@include('users.layout.index')

<body>
    @include('users.partials.header')
    <div id="container" style="margin: 0px auto; width:95%">
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
                                <a style="text-decoration:none; color:black"
                                    href="{{ asset('users/nghiencuu/baibao/index') }}">
                                    Bài báo
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h3 class="title" style="color: green">Nghiên cứu khoa học</h3>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page"
                                    href="{{ asset('users/nghiencuu/detai/index') }}">Đề tài nghiên cứu khoa học</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ asset('users/nghiencuu/baibao/index') }}">Bài báo
                                    đăng trên các tạp chí khoa học</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ asset('users/nghiencuu/tlgd/index') }}">Sách, giáo trình,
                                    tài liệu giảng dạy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ asset('users/nghiencuu/khac/index') }}">Các hoạt động
                                    nghiên cứu khoa học khác</a>
                            </li>
                        </ul>
                        <div class="tab-panels">
                            <br>
                        </div>

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
                    <div class="col-md-12">
                        <div class="form-group mx-sm-3 mb-2" style="float: right;">
                            <a href="{{ asset('users/nghiencuu/baibao/excel') }}" class="btn btn-success float-right"
                                style="color:#fff">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-download" viewBox="0 0 16 16">
                                    <path
                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path
                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                </svg> Xuất Excel
                            </a>
                        </div>
                        <div class="form-group mb-2" style="float: right;">
                            <a href="{{ asset('users/nghiencuu/baibao/add') }}" class="btn btn-success float-right"
                                style="color:#fff">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg> Thêm bài báo mới
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h3 style="color: green">Danh sách các bài báo</h3>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered" style="background: #fff" cellspacing="0"
                            cellpadding="5">
                            <thead>
                                <tr
                                    style="border: 2px solid rgb(173, 172, 172);background: rgb(212, 211, 211);font-weight:bold">
                                    <td style="text-align: center;" rowspan="2">ID</td>
                                    <td style="text-align: center; width:18%" rowspan="2">Tên đề tài</td>
                                    <td colspan="2" style="text-align: center;width:26%">Tác giả</td>
                                    <td style="text-align: center;" rowspan="2">Tên tạp chí</td>
                                    <td style="text-align: center;" rowspan="2">Năm</td>
                                    <td style="text-align: center;" rowspan="2">Tình trạng</td>
                                    <td style="text-align: center;" rowspan="2">Ngày nghiệm thu</td>
                                    <td style="text-align: center;" rowspan="2">Tập tin đính kèm</td>
                                    <td style="text-align: center;" rowspan="2">Sửa</td>
                                    <td style="text-align: center;" rowspan="2">Xóa</td>
                                </tr>
                                <tr
                                    style="border: 2px solid rgb(173, 172, 172);background: rgb(212, 211, 211);font-weight:bold">
                                    <td style="text-align: center;">Tác giả</td>
                                    <td style="text-align: center;">Đồng tác giả</td>
                                </tr>
                            </thead>
                            @foreach ($detai as $row)
                                <tr style="background: #fff;border: 2px solid rgb(173, 172, 172)">
                                    <td style="text-align: center;">
                                        <span>{{ $row->id_DeTai }}</span>
                                    </td>
                                    <td>
                                        <span>{{ App\Models\DeTai::find($row->id_DeTai)->TenDeTai }}</span>
                                    </td>
                                    <td>
                                        <?php $dem=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');?>
                                        @if ($dem==0)
                                        <a type="button" class="btn btn-link" href="{{ asset('users/nghiencuu/baibao/addTG') }}/{{ $row->id_DeTai }}">Thêm tác giả</a>
                                        @endif
                                            <span>
                                                <?php $ma_tg=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Tác giả chính"]])->get();?>
                                                @foreach ($ma_tg as $ma)
                                                <br>
                                                <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b><br>
                                                <li style="font-size: 14px; color:gray">Giờ NCKH: {{$ma->SoTiet}}</li>
                                                @if ($ma->MaGV == $user->MaGV)
                                                <a style="margin-right: 5px;" href="{{ asset('users/nghiencuu/baibao/updateTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}">Sửa</a>
                                                <a style="color: red" href="{{ asset('users/nghiencuu/baibao/deleteTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}">Xóa</a>
                                                <br>
                                            @endif
                                                @endforeach
                                            </span>
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-link"
                                            href="{{ asset('users/nghiencuu/baibao/addTG') }}/{{ $row->id_DeTai }}">Thêm
                                            tác giả</a>
                                            <span>
                                                <?php $ma_tg=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Đồng tác giả"]])->get();?>
                                                @foreach ($ma_tg as $ma)
                                                <br>
                                                <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b><br>
                                                <li style="font-size: 14px; color:gray">Giờ NCKH: {{$ma->SoTiet}}</li>
                                                @if ($ma->MaGV == $user->MaGV)
                                                <a style="margin-right: 5px;" href="{{ asset('users/nghiencuu/baibao/updateTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}">Sửa</a>
                                                <a style="color: red" href="{{ asset('users/nghiencuu/baibao/deleteTG') }}/{{ $row->id_DeTai }}/{{ $ma->MaGV }}">Xóa</a>
                                                <br>
                                            @endif
                                                @endforeach
                                            </span>
                                    </td>
                                    <td><span>{{ App\Models\DeTai::find($row->id_DeTai)->TenTapChi }}</span></td>
                                    <td style="text-align: center;"><span>{{ App\Models\DeTai::find($row->id_DeTai)->NamXB }}</span></td>
                                    <td><span>{{ App\Models\DeTai::find($row->id_DeTai)->TinhTrang }}</span></td>
                                    <td><span>{{ App\Models\DeTai::find($row->id_DeTai)->NgayNghiemThu }}</span></td>
                                    <td>
                                        <span>
                                            <a href="">{{ App\Models\DeTai::find($row->id_DeTai)->TepDinhKem }}</a>
                                        </span>
                                    </td>

                                    <td style="text-align: center;">
                                        <a href="{{asset('users/nghiencuu/baibao/update')}}/{{$row->id_DeTai}}">
                                            <button class="btn btn-secondary" style="color:#fff">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                            </button>
                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{asset('users/nghiencuu/baibao/delete')}}/{{$row->id_DeTai}}">
                                            <button class="btn btn-danger" style="color:#fff" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd"
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
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
    @include('users.partials.footer')
</body>
