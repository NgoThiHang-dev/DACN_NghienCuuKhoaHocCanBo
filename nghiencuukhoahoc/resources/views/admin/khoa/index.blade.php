@extends('admin.layouts.admin')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('admin.partials.content-header', ['name'=>'Khoa', 'key'=>'Danh sách'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @if (session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('thongbao1'))
                <div class="alert" style="background: #F8D7DA; border: 1px solid #F5C2C7" role="alert">
                    {{session('thongbao1')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
                <div class="row" style=" float: right;">
                    <div class="form-group mb-2" style="float: right;">
                        <a href="{{asset('admin/khoa/add')}}" class="btn btn-success float-right">
                            <i class="bi bi-plus"></i>Thêm</a>
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <a href="{{asset('admin/khoa/export')}}" class="btn btn-success float-right">
                            <i class="bi bi-download"></i>  Xuất Excel</a>
                      </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-12" style="margin: 0 auto">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr style="background: #32CD32;border: 1px solid #bee5eb;">
                                <th style="width:50px;text-align: center;">STT</th>
                                <th style="text-align: center;">Mã khoa</th>
                                <th style="text-align: center;">Tên Khoa</th>
                                <th style="text-align: center;">Sửa</th>
                                <th style="text-align: center;">Xóa</th>
                                </tr>
                            </thead>
                            <?php $i=1;?>
                            @foreach($khoa as $row)
                            <tr style="background: #fff">
                                <td style="text-align: center;">
                                    <?php echo $i++;?>
                                </td>
                                <td>
                                    <span>{{$row->MaKhoa}}</span>
                                 </td>
                                <td>
                                    <span>{{$row->TenKhoa}}</span>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{asset('admin/khoa/update')}}/{{$row->MaKhoa}}" >
                                        <button class="btn btn-secondary">
                                            <i class="bi bi-pencil-square"></i></i>
                                        </button>
                                        {{-- {{url('/khoa/edit')}}/{{$row->MaKhoa}} --}}
                                        {{-- {{route('khoa.edit')}} --}}
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{asset('admin/khoa/delete')}}/{{$row->MaKhoa}}" >
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
                <span style="float: right">
                    {{ $khoa->appends(['sort' => 'id'])->links() }}
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



