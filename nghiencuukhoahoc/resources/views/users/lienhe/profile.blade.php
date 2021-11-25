<!DOCTYPE html>
<html lang="en">

<head>
    <title>Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- Load Require CSS -->
    <link href="{{ asset('users/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font CSS -->
    <link href="{{ asset('users/assets/css/boxicon.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Load Tempalte CSS -->
    <link rel="stylesheet" href="{{ asset('users/assets/css/templatemo.css') }}">
    <link rel="stylesheet" href="{{ asset('users/lienhe/assets/css/fontawsom-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('users/lienhe/assets/css/style.css') }}" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('users/assets/css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
</head>


{{-- @include('users.layout.index') --}}

<body>
    @include('users.partials.header')
    <div class="container-fluid">

        <div class="container profile-container">
            
            <div class="row">
                <div id="menu-jk" class="col-md-4">
                    <div class="pro-s-cover">
                        <img style="border-radius: 100%; width: 150px; height: 150px" src="{{asset('upload/giangvien')}}/{{$giangvien->HinhAnh}}" alt="{{$giangvien->HinhAnh}}">

                        <h6>{{ $giangvien->TenGV }}</h6>
                        <p>{{ $giangvien->NgaySinh }}</p>

                    </div>
                    <div class="con-cover">
                        <h4>Liên kết</h4>
                        <div>
                            <nav class="navbar navbar-expand-sm">
                                <ul class="navbar-nav">
                                    <li class="nav-item"><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="nav-item"><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                                    <li class="nav-item"><a href=""><i class="fab fa-github"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="cd-ro row no-margin">
                            <span>Địa chỉ: </span>
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg> {{ $giangvien->DiaChi }}</p>
                        </div>
                        <div class="cd-ro row no-margin">
                            <span>Số điện thoại: </span>
                            <p><i class="fas fa-phone-square"></i> {{ $giangvien->SDT }}</p>
                        </div>
                        <div class="cd-ro row no-margin">
                            <span>Địa chỉ email: </span>
                            <p><i class="fas fa-envelope-square"></i> {{ $giangvien->email }}</p>
                        </div>
                        

                    </div>
                    
                </div>
                <div class="col-md-8">
                    
                    <div class="data-box">
                        <h2>Nơi đang công tác</h2>
                        <div class="row exp-row">
                            <h6>Trường/viện</h6>
                            <p>Đại học Đà Lạt</p>
                        </div>
                        <div class="row exp-row">
                            <h6>Phòng/Khoa</h6>
                            <p><?php echo App\Models\Khoa::find($giangvien->MaKhoa)->TenKhoa; ?></p>
                        </div>
                        <div class="row exp-row last">
                            <h6>Chức vụ</h6>
                            <p>{{ $giangvien->ChucVu }}</p>
                        </div>
                    </div>

                    

                    <div class="data-box contact-tab">
                        <h2>Chỉnh sửa thông tin liên hệ</h2>
                        <div class="row no-margin">
                            <div class="col-md-12">
                                <br>
                                <div class="row cont-row no-margin">
                                    <div class="col-sm-6">
                                        <label for="">Họ và tên</label>
                                        <input placeholder="Tên" type="text" class="form-control form-control-sm"
                                            value="{{ $giangvien->TenGV }}">
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="" >Số điện thoại</label>
                                        <input placeholder="Số điện thoại" type="text"
                                            class="form-control form-control-sm" value="{{ $giangvien->SDT }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Ngày sinh</label>
                                        <input placeholder="Ngày sinh" type="date" class="form-control form-control-sm"
                                            value="{{ $giangvien->NgaySinh }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Giới tính</label>
                                        <select class="form-control" name="GioiTinh" >
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
                                <div class="row cont-row no-margin">
                                    
                                    <div class="col-sm-6">
                                        <label for="">Email</label>
                                        <input placeholder="Email" type="email" class="form-control form-control-sm"
                                            value="{{ $giangvien->email }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Địa chỉ</label>
                                        <input placeholder="Địa chỉ" type="text" class="form-control form-control-sm"
                                            value="{{ $giangvien->DiaChi }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Học vị</label>
                                        <select class="form-control" name="HocVi">
                                            <?php
                                            if($giangvien->HocVi=="Tiến sĩ")
                                            {
                                                echo '<option value="Tiến sĩ" selected>Tiến sĩ</option>
                                                <option value="Thạc sĩ">Thạc sĩ</option>
                                                <option value="Kỹ sư">Kỹ sư</option>
                                                <option value="Cử nhân">Cử nhân</option>
                                                <option value="Khác">Khác</option>';
                                            }
                                            if($giangvien->HocVi=="Thạc sĩ")
                                                {
                                                    echo '<option value="Tiến sĩ">Tiến sĩ</option>
                                                    <option value="Thạc sĩ" selected>Thạc sĩ</option>
                                                    <option value="Kỹ sư">Kỹ sư</option>
                                                    <option value="Cử nhân">Cử nhân</option>
                                                    <option value="Khác">Khác</option>';

                                                }
                                                if($giangvien->HocVi=="Kỹ sư")
                                                {
                                                    echo '<option value="Tiến sĩ" >Tiến sĩ</option>
                                                <option value="Thạc sĩ">Thạc sĩ</option>
                                                <option value="Kỹ sư" selected>Kỹ sư</option>
                                                <option value="Cử nhân">Cử nhân</option>
                                                <option value="Khác">Khác</option>';

                                                }
                                                if($giangvien->HocVi=="Cử nhân")
                                                {
                                                    echo '<option value="Tiến sĩ" selected>Tiến sĩ</option>
                                                <option value="Thạc sĩ">Thạc sĩ</option>
                                                <option value="Kỹ sư">Kỹ sư</option>
                                                <option value="Cử nhân" selected>Cử nhân</option>
                                                <option value="Khác">Khác</option>';
                                                }
                                                if($giangvien->HocVi=="Khác")
                                                {
                                                    echo '<option value="Tiến sĩ" selected>Tiến sĩ</option>
                                                <option value="Thạc sĩ">Thạc sĩ</option>
                                                <option value="Kỹ sư">Kỹ sư</option>
                                                <option value="Cử nhân" >Cử nhân</option>
                                                <option value="Khác" selected>Khác</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label for="" >Chức vụ</label>
                                        <input placeholder="Số điện thoại" type="text"
                                            class="form-control form-control-sm" value="{{ $giangvien->SDT }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Hình ảnh</label><br>
                                        <a href="">{{$giangvien->HinhAnh}}</a>
                                        <input type="file" name="TepDinhKem" id="" class="form-control">
                                    </div>

                                </div>
                                <br>
                                <div class="row cont-row no-margin">
                                    <div class="col-sm-6">
                                        <button class="btn btn-sm" style="font-size: 15px; color: #fff; background-color: #28a745">Lưu kết quả</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                
            </div>
        </div>

    </div>
</body>

<script src="{{ asset('users/lienhe/assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('users/lienhe/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('users/lienhe/assets/js/bootstrap.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('users/lienhe/assets/js/jquery-scrolltofixed-min.js') }}">
</script>
<script src="{{ asset('users/lienhe/assets/js/script.js') }}"></script>


</html>
