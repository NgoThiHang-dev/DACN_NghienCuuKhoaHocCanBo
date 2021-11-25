<div class="col-md-12">
    <table class="table table-hover table-bordered">
        <thead>
            <tr style="border: 1px solid #bee5eb;background: #fff">
                <th rowspan="2" style="text-align: center;">Mã giảng viên</th>
                <th rowspan="2" style="text-align: center;">Tên giảng viên</th>
                <th rowspan="2" style="text-align: center;">Khoa</th>
                <th colspan="4" style="text-align: center;">Giờ nghiên cứu khoa học</th>
                <th rowspan="2" style="text-align: center;">Cộng</th>
                <th rowspan="2" style="text-align: center;">Ghi chú</th>
            </tr>
            <tr style="background: #fff">
                <th style="text-align: center">Thực hiện NCKH</th>
                <th style="text-align: center">Bài báo</th>
                <th style="text-align: center">Sách, giáo trình, TLGD</th>
                <th style="text-align: center">Hoạt động nghiên cứu khác</th>
            </tr>
        </thead>
        {{--  <tr style="background: #fff">
            <th colspan="8" style="text-align: center;"></th>
        </tr>  --}}
         @foreach ($thongke as $tk) 
        <tr style="background: #fff">
            <td style="text-align: center;">
                {{ $_POST['MaGV'] }}
            </td>
            <td style="text-align: center;">
                <span>
                    {{ App\Models\GiangVien::find($_POST['MaGV'])->TenGV }}
                </span>
            </td>
            <td>
                <span>
                    Khoa {{ App\Models\GiangVien::find($_POST['MaGV'])->MaKhoa }}
                </span>
            </td>
            <td style="text-align: center;">
                <span>
                    <?php $thongke_bb=DB::table('gv_dt')
                    ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
                    ->select('gv_dt.SoTiet')
                    ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$_POST['MaGV']],['gv_dt.id_DeTai', 'LIKE', 'DT%']])
                    ->get();?>
@foreach ($thongke_bb as $item)
    {{$item->SoTiet}}
    <br>
@endforeach
                </span>
            </td>
            <td style="text-align: center;">
                <span>
                    <?php $thongke_bb=DB::table('gv_dt')
                    ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
                    ->select('gv_dt.SoTiet')
                    ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$_POST['MaGV']],['gv_dt.id_DeTai', 'LIKE', 'BB%']])
                    ->get();?>
@foreach ($thongke_bb as $item)
    {{$item->SoTiet}}
    <br>
@endforeach
                </span>
            </td>
            <td style="text-align: center;">
                <span>
                    <?php $thongke_bb=DB::table('gv_dt')
                    ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
                    ->select('gv_dt.SoTiet')
                    ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$_POST['MaGV']],['gv_dt.id_DeTai', 'LIKE', 'TL%']])
                    ->get();?>
@foreach ($thongke_bb as $item)
    {{$item->SoTiet}}
    <br>
@endforeach
                </span>
            </td>
            <td style="text-align: center;">
                <span>
                    <?php $thongke_bb=DB::table('gv_dt')
                                            ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
                                            ->select('gv_dt.SoTiet')
                                            ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$_POST['MaGV']],['gv_dt.id_DeTai', 'LIKE', 'HD%']])
                                            ->get();?>
                        @foreach ($thongke_bb as $item)
                            {{$item->SoTiet}}
                            <br>
                        @endforeach
                </span>
            </td>
            <td style="text-align: center; font-weight:bold">
                <span>{{ $tk->Tong }}</span>
            </td>
            <td>
                <span>
                    <?php $thongke_bb=DB::table('gv_dt')
                    ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
                    ->select('gv_dt.SoTiet','detai.id_ThoiGian')
                    ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$_POST['MaGV']]])
                    ->get();?>
                    @foreach ($thongke_bb as $item)
                        - <b>Học kỳ:</b> {{ App\Models\ThoiGian::find($item->id_ThoiGian)->HocKy }} - <b>Năm học:</b> {{ App\Models\ThoiGian::find($item->id_ThoiGian)->NamHoc }} ({{$item->SoTiet}} giờ nghiên cứu)
                        <br>
                    @endforeach
                </span>
        </tr>
         @endforeach 
        
    </table>
</div>
