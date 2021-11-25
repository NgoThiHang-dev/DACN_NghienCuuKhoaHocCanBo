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

    <h2 style="text-align: center">Danh sách bài báo nghiêm cứu khoa học</h2>

    <table border="0" align="center" cellpadding="5" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td style="text-align: center;">STT</td>
                <td style="text-align: center;">ID</td>
                <td style="text-align: center;">Tên đề tài</td>
                <td style="text-align: center;">Tác giả</td>
                <td style="text-align: center;">Đồng tác giả</td>
                <td style="text-align: center;">Tên tạp chí</td>
                <td style="text-align: center;">Năm</td>
                <td style="text-align: center;">Tình trạng</td>
                <td style="text-align: center;">Ngày nghiệm thu</td>
                <td style="text-align: center;">Tập tin đính kèm</td>
                <td style="text-align: center;">Loại đề tài</td>
            </tr>

        </thead>
        <?php $i=1;?>
        @foreach ($detai as $row)
            <tr style="background: #fff;">
                <td style="text-align: center;">
                    <span>{{ $i++ }}</span>
                </td>
                <td style="text-align: center;">
                    <span>{{ $row->id_DeTai }}</span>
                </td>
                <td>
                    <span>{{ App\Models\DeTai::find($row->id_DeTai)->TenDeTai }}</span>
                </td>
                <td>
                    <span>
                        <?php $ma_tg=App\Models\GiangVien_DeTai::where([['id_DeTai','=',$row->id_DeTai],['VaiTro','=',"Tác giả chính"]])->get();?>
                        @foreach ($ma_tg as $ma)
                        {{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}
                        - Giờ NCKH: {{$ma->SoTiet}}
                        @endforeach
                    </span>
                </td>
                <td>
                    <span>
                        <?php $ma_tg = App\Models\GiangVien_DeTai::where([['id_DeTai', '=',
                        $row->id_DeTai], ['VaiTro', '=', 'Đồng tác giả']])->get(); ?>
                        @foreach ($ma_tg as $ma)
                            {{ App\Models\GiangVien::find($ma->MaGV)->TenGV }}
                            - Giờ NCKH: {{ $ma->SoTiet }}
                        @endforeach
                    </span>
                </td>
                <td>
                    <span>{{ App\Models\DeTai::find($row->id_DeTai)->TenTapChi }}</span>
                </td>
                <td style="text-align: center;">
                    <span>{{ App\Models\DeTai::find($row->id_DeTai)->NamXB }}</span>
                </td>
                <td>
                    <span>{{ App\Models\DeTai::find($row->id_DeTai)->TinhTrang }}</span>
                </td>
                <td>
                    <span>{{ App\Models\DeTai::find($row->id_DeTai)->NgayNghiemThu }}</span>
                </td>
                <td>
                    <span>
                        {{ App\Models\DeTai::find($row->id_DeTai)->TepDinhKem }}
                    </span>
                </td>
                <td>
                    <span>
                        <?php
                            $id_loaiDT=App\Models\DeTai::find($row->id_DeTai)->id_LoaiDeTai;
                            echo App\Models\LoaiDeTai::find($id_loaiDT)->TenLoaiDeTai;
                        ?>
                    </span>
                </td>
            </tr>
        @endforeach
    </table>

</body>

</html>
