<div class="col-md-12">
    <div class="form-group mx-sm-3 mb-2" style="float: right;">
        <a href="{{asset('admin/thongke/theoloai/excel_detai')}}/{{ $_POST['HocKy'] }}/{{ $_POST['NamHoc'] }} " class="btn btn-success float-right"
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
    
</div>
<div class="col-md-12">
    <h3 style="color: green">Danh sách các đề tài</h3>
</div>
<div class="col-md-12">
    <p> 
        <u>Tổng số bài:</u> 
        <b style="font-size: 20px; color:rgb(146, 13, 13)">
            @if ($count>0)
                {{ $count }}
            @else
                {{ '0' }}
            @endif
        </b>
    </p>
</div>
<div class="col-md-12">
    <table class="table table-hover table-bordered" style="background: #fff" cellspacing="0"
        cellpadding="5">
        <thead>
            <tr style="font-weight: bold;background:rgb(202, 201, 201)">
                <td style="text-align: center;" rowspan="2">STT</td>
                <td style="text-align: center;" rowspan="2">ID</td>
                <td style="text-align: center; width:18%" rowspan="2">Tên đề tài</td>
                <td colspan="2" style="text-align: center;width:26%">Tác giả</td>
                <td style="text-align: center;" rowspan="2">Năm</td>
                <td style="text-align: center;" rowspan="2">Tình trạng</td>
                <td style="text-align: center;" rowspan="2">Ngày nghiệm thu</td>
                <td style="text-align: center;" rowspan="2">Tập tin đính kèm</td>
                <td style="text-align: center;" rowspan="2">Cấp nghiên cứu</td>
                <td style="text-align: center;" rowspan="2">Loại đề tài</td>
            </tr>
            <tr style="font-weight: bold;background:rgb(202, 201, 201)">
                <td style="text-align: center;">Tác giả</td>
                <td style="text-align: center;">Đồng tác giả</td>
            </tr>
        </thead>
        <?php $i=1;?>
        @foreach ($thongke as $row)
            <tr >
                <td style="text-align: center;">
                    <span>{{ $i++ }}</span>
                </td>
                <td style="text-align: center;">
                    <span>{{ $row->id_DeTai }}</span>
                </td>
                <td>
                    <span>{{ $row->TenDeTai }}</span>
                </td>
                <td>
                    <span>
                        <?php $ma_tg =
                        App\Models\GiangVien_DeTai::where([['id_DeTai', '=', $row->id_DeTai],
                        ['VaiTro', '=', 'Tác giả chính']])->get(); ?>
                        @foreach ($ma_tg as $ma)
                            
                            <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b><br>
                            <li>Giờ NCKH: {{ $ma->SoTiet }}</li>
                            <br>
                        @endforeach
                    </span>
                </td>
                <td>
                    <span>
                        <?php $ma_tg =
                        App\Models\GiangVien_DeTai::where([['id_DeTai', '=', $row->id_DeTai],
                        ['VaiTro', '=', 'Đồng tác giả']])->get(); ?>
                        @foreach ($ma_tg as $ma)
                            
                            <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b><br>
                            <li>Giờ NCKH: {{ $ma->SoTiet }}</li>
                            <br>
                        @endforeach
                    </span>
                </td>
                <td>
                    <span>{{ $row->NamXB }}</span>
                </td>
                <td>
                    <span>{{ $row->TinhTrang }}</span>
                </td>
                <td>
                    <span>{{ $row->NgayNghiemThu }}</span>
                </td>
                <td>
                    <span>{{ $row->TepDinhKem }}</span>
                </td>
                <td>
                    <span>{{ $row->CapNC }}</span>
                </td>
                <td>
                    <span>{{ App\Models\LoaiDeTai::find($row->id_LoaiDeTai)->TenLoaiDeTai }}</span>
                </td>
            </tr>
        @endforeach
    </table>
</div>
