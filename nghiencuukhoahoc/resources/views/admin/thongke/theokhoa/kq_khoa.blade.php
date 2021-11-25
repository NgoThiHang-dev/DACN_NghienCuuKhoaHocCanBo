<div class="col-md-12">
    <table class="table table-hover table-bordered">
        <thead>
            <tr style="border: 1px solid #bee5eb;background: #fff">
                <th rowspan="2" style="text-align: center">STT</th>
                <th rowspan="2" style="text-align: center;">Mã giảng viên</th>
                <th rowspan="2" style="text-align: center;">Tên giảng viên</th>
                {{-- <th rowspan="2" style="text-align: center;">Khoa</th> --}}
                <th colspan="4" style="text-align: center;">Giờ nghiên cứu khoa học</th>
                <th rowspan="2" style="text-align: center;">Tổng số giờ NCKH</th>
            </tr>
            <tr style="background: #fff">
                <th style="text-align: center">Thực hiện NCKH</th>
                <th style="text-align: center">Bài báo</th>
                <th style="text-align: center">Sách, giáo trình, TLGD</th>
                <th style="text-align: center">Hoạt động nghiên cứu khác</th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        @foreach ($thongke as $tk)
            <tr style="background: #fff">
                <td style="text-align: center;">
                    <?php echo $i++; ?>
                </td>
                <td style="text-align: center;">
                    <span>

                        {{ $tk->MaGV }}
                    </span>
                </td>
                <td>
                    <span>
                        {{ App\Models\GiangVien::find($tk->MaGV)->TenGV }}
                    </span>
                </td>

                <td style="text-align: center;">
                    <span>
                        <?php $thongke_bb=DB::table('gv_dt')
                                            ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
                                            ->select('gv_dt.SoTiet')
                                            ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$tk->MaGV],['gv_dt.id_DeTai', 'LIKE', 'DT%']])
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
                        ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$tk->MaGV],['gv_dt.id_DeTai', 'LIKE', 'BB%']])
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
                                            ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$tk->MaGV],['gv_dt.id_DeTai', 'LIKE', 'TL%']])
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
                                            ->where([['detai.NgayNghiemThu','>=',$_POST['Tu']],['detai.NgayNghiemThu','<=',$_POST['Den']],['gv_dt.MaGV','=',$tk->MaGV],['gv_dt.id_DeTai', 'LIKE', 'HD%']])
                                            ->get();?>
                        @foreach ($thongke_bb as $item)
                            {{$item->SoTiet}}
                            <br>
                        @endforeach
                    </span>
                </td>
                <td style="font-weight: bold; text-align: center;">
                    <span>{{ $tk->Tong }}</span>
                </td>

            </tr>

        @endforeach
    </table>
</div>
