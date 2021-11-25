<!DOCTYPE html>
<html>

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

    </style>
</head>

<body>

    <h2 style="text-align: center">DANH SÁCH NGHIÊN CỨU KHOA HỌC HỌC KỲ: {{ $hocky }} - NĂM HỌC: {{ $namhoc }}</h2>
    <h3><u>Tổng số bài:</u> 
        <b style="font-size: 20px; color:rgb(146, 13, 13)">
            @if ($count>0)
                {{ $count }}
            @else
                {{ '0' }}
            @endif
        </b>
    </h3>

    <table border="0" align="center" cellpadding="5" style="border-collapse: collapse; width:100%">
        <thead>
            <tr>
                <td style="text-align: center;">STT</td>
                <td style="text-align: center;">ID</td>
                <td style="text-align: center;">Tên đề tài</td>
                <td style="text-align: center;">Tác giả</td>
                <td style="text-align: center;">Đồng tác giả</td>
                <td style="text-align: center;">Tình trạng</td>
                <td style="text-align: center;">Ngày nghiệm thu</td>
                <td style="text-align: center;">Tập tin đính kèm</td>
                <td style="text-align: center;">Loại đề tài</td>
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
                        ['VaiTro', '=', "Tác giả chính"]])->get(); ?>
                        @foreach ($ma_tg as $ma)
                            
                            <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b>
                             - Giờ NCKH: {{ $ma->SoTiet }}
                            <br>
                        @endforeach
                    </span>
                </td>
                <td>
                    <span>
                        <?php $ma_tg =
                        App\Models\GiangVien_DeTai::where([['id_DeTai', '=', $row->id_DeTai],
                        ['VaiTro', '=', "Đồng tác giả"]])->get(); ?>
                        @foreach ($ma_tg as $ma)
                            
                            <b>{{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}</b>
                             - Giờ NCKH: {{ $ma->SoTiet }}
                            <br>
                        @endforeach
                    </span>
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
                    <span>{{ App\Models\LoaiDeTai::find($row->id_LoaiDeTai)->TenLoaiDeTai }}</span>
                </td>
                
            </tr>
        @endforeach
    </table>

</body>

</html>
