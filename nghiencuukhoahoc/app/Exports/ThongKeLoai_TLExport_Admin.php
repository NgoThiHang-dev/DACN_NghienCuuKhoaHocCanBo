<?php

namespace App\Exports;

use App\Models\DeTai;
use App\Models\GiangVien;
use App\Models\GiangVien_DeTai;
use App\Models\ThoiGian;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable as ConcernsExportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners as ConcernsRegistersEventListeners;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThongKeLoai_TLExport_Admin implements FromView
{
    use ConcernsExportable, ConcernsRegistersEventListeners;
    public function view(): View
    {
        $gv=GiangVien::all();
        $tacgia = GiangVien_DeTai::all();
        $user = Auth::user();
        $uri = $_SERVER['REQUEST_URI'];
        $a=explode('/', $uri);
        $hk=$a[7];
        $nh=$a[8];
        $id_ThoiGian=ThoiGian::where([['HocKy','=',$hk],['NamHoc','=',$nh]])->first();
        $thongke=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%TL%']])->get();
        $count=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%TL%']])->count('id_ThoiGian');
       
        return view('admin.thongke.loaiNCKH.export.excel_tlgd', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hk,'namhoc'=>$nh]);
        
    }
}
