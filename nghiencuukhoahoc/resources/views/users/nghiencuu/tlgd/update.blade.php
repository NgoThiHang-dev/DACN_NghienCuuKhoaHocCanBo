@include('users.layout.index')
<body>
    @include('users.partials.header')
    <div id="container" style="margin:0px auto; width:95%">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        <ol class="breadcrumb" style="float: right; font-size:15px;">
                            <li class="breadcrumb-item">
                                <a style="text-decoration:none; font-weight:bold;" href="{{ asset('users/index') }}">
                                    <p style="font-weight:bold;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"
                                            style="margin-top: -5px">
                                            <path fill-rule="evenodd"
                                                d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                            <path fill-rule="evenodd"
                                                d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                                        </svg> Trang chủ</p>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a style="text-decoration:none;font-weight:bold;" href="{{ asset('users/nghiencuu/detai/index') }}">
                                    NCKH
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a style="text-decoration:none;font-weight:bold;" href="{{ asset('users/nghiencuu/tlgd/index') }}">
                                    Tài liệu
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a style="text-decoration:none; color:black" href="{{ asset('users/nghiencuu/tlgd/add') }}">
                                    Sửa thông tin
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h3 class="title" style="color: green">Chỉnh sửa thông tin</h3>
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
                    <div class="col-12">
                        <form action="" method="post" style="width: 90%; margin: 0px auto; " enctype="multipart/form-data">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @csrf

                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">ID đề tài<i style="color: red">*</i></label>
                                                <input type="text" class="form-control" name="id_DeTai" value="{{$detai->id_DeTai}}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tên sách, giáo trình, tài liệu giảng dạy <i style="color: red">*</i></label>
                                                <input type="text" class="form-control" name="TenDeTai" id="" value="{{$detai->TenDeTai}}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Loại đề tài <i style="color: red">*</i></label>
                                                <select class="form-select" aria-label="Default select example" name="id_LoaiDeTai" >
                                                    @foreach ($loaidetai as $value)
                                                        <option value="{{$value['id_LoaiDeTai']}}"
                                                        <?php if ($detai['id_LoaiDeTai']==$value['id_LoaiDeTai']):?>
                                                            selected="selected"
                                                            <?php endif ?>>
                                                                {{$value['TenLoaiDeTai']}}
                                                        </option>;
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Năm học <i style="color: red">*</i></label>
                                                <select class="form-select" name="id_ThoiGian">
                                                    @foreach ($thoigian as $value)
                                                        <option value="{{ $value['id_ThoiGian'] }}"
                                                        <?php if ($detai['id_ThoiGian']==$value['id_ThoiGian']):?>
                                                            selected="selected"
                                                        <?php endif ?>>
                                                            Năm học: {{ $value->NamHoc }} - Học kỳ: {{$value->HocKy}}
                                                        </option>;
                                                    @endforeach
                                                    </select>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Năm xuất bản<i style="color: red">*</i></label>
                                                        <input type="text" class="form-control" name="NamXB" id="" value="{{$detai->NamXB}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Định dạng <i style="color: red">*</i></label>
                                                        <select class="form-control" name="DinhDang">
                                                            <?php
                                                                    if($detai->DinhDang=="Sách"){
                                                                        echo'<option value="Sách" selected>Sách</option>
                                                                        <option value="Giáo trình">Giáo trình</option>
                                                                        <option value="Tài liệu tham khảo">Tài liệu tham khảo</option>';
                                                                    }
                                                                    if($detai->DinhDang=="Giáo trình"){
                                                                        echo'<option value="Sách" >Sách</option>
                                                                        <option value="Giáo trình" selected>Giáo trình</option>
                                                                        <option value="Tài liệu tham khảo">Tài liệu tham khảo</option>';
                                                                    }
                                                                    if($detai->DinhDang=="Tài liệu tham khảo"){
                                                                        echo'<option value="Sách">Sách</option>
                                                                        <option value="Giáo trình">Giáo trình</option>
                                                                        <option value="Tài liệu tham khảo" selected>Tài liệu tham khảo</option>';
                                                                    }
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Loại biên tập<i style="color: red">*</i></label>
                                                <select class="form-control" name="LoaiBienTap">
                                                    <?php
                                                            if($detai->LoaiBienTap=="Ban đầu"){
                                                                echo'<option value="Ban đầu" selected>Ban đầu</option>
                                                                <option value="Chỉnh lý - Lần 1">Chỉnh lý - Lần 1</option>
                                                                <option value="Chỉnh lý - Lần 2">Chỉnh lý - Lần 2</option>
                                                                <option value="Chỉnh lý - Lần 3">Chỉnh lý - Lần 3</option>';
                                                            }
                                                            if($detai->LoaiBienTap=="Chỉnh lý - Lần 1"){
                                                                echo'<option value="Ban đầu" selected>Ban đầu</option>
                                                                <option value="Chỉnh lý - Lần 1" selected>Chỉnh lý - Lần 1</option>
                                                                <option value="Chỉnh lý - Lần 2">Chỉnh lý - Lần 2</option>
                                                                <option value="Chỉnh lý - Lần 3">Chỉnh lý - Lần 3</option>';
                                                            }
                                                            if($detai->LoaiBienTap=="Chỉnh lý - Lần 2"){
                                                                echo'<option value="Ban đầu" selected>Ban đầu</option>
                                                                <option value="Chỉnh lý - Lần 1">Chỉnh lý - Lần 1</option>
                                                                <option value="Chỉnh lý - Lần 2" selected>Chỉnh lý - Lần 2</option>
                                                                <option value="Chỉnh lý - Lần 3">Chỉnh lý - Lần 3</option>';
                                                            }
                                                            if($detai->LoaiBienTap=="Chỉnh lý - Lần 3"){
                                                                echo'<option value="Ban đầu" selected>Ban đầu</option>
                                                                <option value="Chỉnh lý - Lần 1">Chỉnh lý - Lần 1</option>
                                                                <option value="Chỉnh lý - Lần 2">Chỉnh lý - Lần 2</option>
                                                                <option value="Chỉnh lý - Lần 3" selected>Chỉnh lý - Lần 3</option>';
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tình trạng<i style="color: red">*</i></label>
                                                        <select class="form-control" name="TinhTrang">
                                                            <option value="Hoàn thành">Hoàn thành</option>
                                                            <option value="Chưa hoàn thành">Chưa hoàn thành</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Ngày nghiệm thu <i style="color: red">*</i></label>
                                                        <input type="date" class="form-control" name="NgayNghiemThu" id="" value="{{$detai->NgayNghiemThu}}">
                                                    </div>
                                                </div>

                                            </div>                            
                                            <div class="mb-3">
                                                <label>Tệp đính kèm <label style="color: red">*</label></label>
                                                <p>{{ $detai->TepDinhKem }}</p>
                                                <input type="file" class="form-control-file" name="TepDinhKem">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tóm tắt <i style="color: red">*</i></label>
                                                <textarea class="form-control" name="TomTat" rows="5">{{$detai->TomTat}}</textarea>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-3">
                                                    <div class="mb-3" style="float: right">
                                                        <button type="submit" class="btn btn-success" style="color: #fff">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-save"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                            </svg> Lưu kết quả
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" >
                                                    <div class="mb-3" style="float: right">
                                                        <a style="color: #fff" class="btn btn-danger them"
                                                            href="{{ asset('users/nghiencuu/tlgd/index') }}" role="button">
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
                <br><br>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->


    </div>
    @include('users.partials.footer')
</body>
