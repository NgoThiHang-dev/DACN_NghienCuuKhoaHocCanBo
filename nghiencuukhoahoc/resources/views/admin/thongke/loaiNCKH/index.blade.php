@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.partials.content-header', ['name'=>'Thống kê', 'key'=>'Theo loại NCKH'])
        <!-- /.content-header -->

        <!-- Main content -->

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @include('admin.thongke.loaiNCKH.layout')
                </div>
                <div class="row">
                    @if (isset($_POST['TK']))
                        @if ($_POST['Loc']=="BB")
                            @include('admin.thongke.loaiNCKH.loai.baibao')
                        @endif
                        @if ($_POST['Loc']=="DT")
                            @include('admin.thongke.loaiNCKH.loai.detai')
                        @endif
                        @if ($_POST['Loc']=="TL")
                            @include('admin.thongke.loaiNCKH.loai.tlgd')
                        @endif
                        @if ($_POST['Loc']=="HD")
                            @include('admin.thongke.loaiNCKH.loai.hoatdongkhac')
                        @endif
                        @if ($_POST['Loc']=="")
                            @include('admin.thongke.loaiNCKH.loai.all')
                        @endif
                    @else
                        {{ 'Chưa chọn thông tin' }}

                    @endif
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
