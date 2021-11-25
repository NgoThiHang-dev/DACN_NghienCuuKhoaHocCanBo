@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Thống kê', 'key'=>'Theo Khoa'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="container">
                    {{--  @include('admin.thongke.layout')  --}}
                    <form action="" method="POST" style="width: 100%;" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col ">
                                <p>Chọn khoa:
                                @if (isset($_POST['TK']))
                                    @include('admin.thongke.theokhoa.s2')
                                @else
                                    @include('admin.thongke.theokhoa.s1')
                                @endif
                            </p>
                            </div>
                            <div class="col ">
                                <p>Từ ngày:<input type="date" id="datepicker" class="form-control" name="Tu" value="<?php echo @$_POST['Tu'];?>"></p>
                            </div>
                            <div class="col ">
                                <p>Đến ngày:<input type="date" id="datepicker2" class="form-control" name="Den" value="<?php echo @$_POST['Den'];?>"></p>
                            </div>

                            <div class="col">
                                <br>
                                <input type="submit" style="height: 36px" class="btn btn-primary btn-sm" value="Lọc kết quả"
                                    name="TK">

                            </div>
                        </div>
                    </form>

                    @if (isset($_POST['TK']))
                        @include('admin.thongke.theokhoa.kq_khoa')
                    @endif


            <br>
            <br>
                </div>

            </div>
        </div>
    </div>
@endsection

