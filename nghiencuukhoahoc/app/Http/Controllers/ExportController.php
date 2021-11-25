<?php

namespace App\Http\Controllers;

use App\Exports\BaiBaoExport;
use App\Exports\BaiBaoExport_Admin;
use App\Exports\DeTaiExport_Admin;
use App\Exports\DeTaiExport_User;
use App\Exports\HDKExport_User;
use App\Exports\HoatDongNCKHExport_Admin;
use App\Exports\KhoaExport;
use App\Exports\LoaiDeTaiExport;
use App\Exports\ThongKeLoai_BBExport_Admin;
use App\Exports\ThongKeLoai_DTExport_Admin;
use App\Exports\ThongKeLoai_KHExport_Admin;
use App\Exports\ThongKeLoai_TLExport_Admin;
use App\Exports\ThongKeLoaiExport_Admin;
use App\Exports\TLGDExport_Admin;
use App\Exports\TLGDExport_User;
use App\Models\DeTai;
use App\Models\GiangVien;
use App\Models\GiangVien_DeTai;
use App\Models\LoaiDeTai;
use App\Models\ThoiGian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export_LoaiDeTai(){
        return Excel::download(new LoaiDeTaiExport,'LoaiDeTai.xlsx');
    }
    public function export_Khoa(){
        return Excel::download(new KhoaExport,'Khoa_DLU.xlsx');
    }
    public function excel_dt_admin(){
        // $detai = DeTai::where('id_DeTai','LIKE','%DT%')->get();
        // $user = Auth::user();
        // return view('admin.nghiencuu.detai.excel',['detai'=>$detai, 'user'=>$user]);
        return Excel::download(new DeTaiExport_Admin,'DeTai_NCKH.xlsx');
    }
    public function excel_bb_admin(){
        // $detai = DeTai::where('id_DeTai','LIKE','%BB%')->get();
        // $user = Auth::user();
        // return view('admin.nghiencuu.baibao.excel',['detai'=>$detai, 'user'=>$user]);
        return Excel::download(new BaiBaoExport_Admin,'Baibao_NCKH.xlsx');
    }
    public function excel_tlgd_admin(){
        // $detai = DeTai::where('id_DeTai','LIKE','%TL%')->orderBy('NgayCapNhat', 'DESC')->get();
        // $user = Auth::user();
        // return view('admin.nghiencuu.tlgd.excel',['detai'=>$detai, 'user'=>$user]);
        return Excel::download(new TLGDExport_Admin,'TLGD_NCKH.xlsx');
    }
    public function excel_khac_admin(){
        // $detai = DeTai::where('id_DeTai','LIKE','%HD%')->orderBy('NgayCapNhat', 'DESC')->get();
        // $user = Auth::user();
        // return view('admin.nghiencuu.khac.excel',['detai'=>$detai, 'user'=>$user]);
        return Excel::download(new HoatDongNCKHExport_Admin,'HoatDong_NCKH.xlsx');
    }
    public function excel_bb_user(){
        // $user = Auth::user();
        // $detai=DB::table('gv_dt')
        // ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        // ->select('gv_dt.id_DeTai')
        // ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%BB%']])
        // ->orderBy('detai.NgayCapNhat', 'DESC')
        // ->get();
        // $loai = LoaiDeTai::all();
        // return view('users.nghiencuu.baibao.excel', ['detai' => $detai,'user' => $user,'loai' => $loai]);
        return Excel::download(new BaiBaoExport,'BaibaoNCKH.xlsx');
    }
    public function excel_dt_user(){
        // $user = Auth::user();
        // $detai=DB::table('gv_dt')
        // ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        // ->select('gv_dt.id_DeTai')
        // ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%DT%']])
        // ->orderBy('detai.NgayCapNhat', 'DESC')
        // ->get();
        // $loai = LoaiDeTai::all();
        // return view('users.nghiencuu.detai.excel', ['detai' => $detai,'user' => $user,'loai' => $loai]);
        return Excel::download(new DeTaiExport_User,'DeTaiNCKH.xlsx');
    }
    public function excel_tl_user(){
        // $user = Auth::user();
        // $detai=DB::table('gv_dt')
        // ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        // ->select('gv_dt.id_DeTai')
        // ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%TL%']])
        // ->orderBy('detai.NgayCapNhat', 'DESC')
        // ->get();
        // $loai = LoaiDeTai::all();
        // return view('users.nghiencuu.tlgd.excel', ['detai' => $detai,'user' => $user,'loai' => $loai]);
        return Excel::download(new TLGDExport_User,'TL_NCKH.xlsx');
    }
    public function excel_hd_user(){
        // $user = Auth::user();
        // $detai=DB::table('gv_dt')
        // ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        // ->select('gv_dt.id_DeTai')
        // ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%HD%']])
        // ->orderBy('detai.NgayCapNhat', 'DESC')
        // ->get();
        // $loai = LoaiDeTai::all();
        // return view('users.nghiencuu.khac.excel', ['detai' => $detai,'user' => $user,'loai' => $loai]);
        return Excel::download(new HDKExport_User,'HoatDongNCKH.xlsx');
    }
    public function excel_thongke_LoaiAll_admin(){
        // $gv=GiangVien::all();
        // $tacgia = GiangVien_DeTai::all();
        // $user = Auth::user();
        // $uri = $_SERVER['REQUEST_URI'];
        // $a=explode('/', $uri);
        // $hk=$a[7];
        // $nh=$a[8];
        // $id_ThoiGian=ThoiGian::where([['HocKy','=',$hk],['NamHoc','=',$nh]])->first();
        // $thongke=DeTai::where(['id_ThoiGian'=>$id_ThoiGian->id_ThoiGian])->get();
        // $count=DeTai::where(['id_ThoiGian'=>$id_ThoiGian->id_ThoiGian])->count('id_ThoiGian');
       
        // return view('admin.thongke.loaiNCKH.export.excel_all', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hk,'namhoc'=>$nh]);
        return Excel::download(new ThongKeLoaiExport_Admin,'DS_NCKH.xlsx');
    }
    public function excel_thongke_LoaiDT_admin(){
        // $gv=GiangVien::all();
        // $tacgia = GiangVien_DeTai::all();
        // $user = Auth::user();
        // $uri = $_SERVER['REQUEST_URI'];
        // $a=explode('/', $uri);
        // $hk=$a[7];
        // $nh=$a[8];
        // $id_ThoiGian=ThoiGian::where([['HocKy','=',$hk],['NamHoc','=',$nh]])->first();
        // $thongke=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%DT%']])->get();
        // $count=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%DT%']])->count('id_ThoiGian');
       
        // return view('admin.thongke.loaiNCKH.export.excel_detai', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hk,'namhoc'=>$nh]);
        return Excel::download(new ThongKeLoai_DTExport_Admin,'DS_DeTai_NCKH.xlsx');
    }
    public function excel_thongke_LoaiBB_admin(){
        // $gv=GiangVien::all();
        // $tacgia = GiangVien_DeTai::all();
        // $user = Auth::user();
        // $uri = $_SERVER['REQUEST_URI'];
        // $a=explode('/', $uri);
        // $hk=$a[7];
        // $nh=$a[8];
        // $id_ThoiGian=ThoiGian::where([['HocKy','=',$hk],['NamHoc','=',$nh]])->first();
        // $thongke=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%BB%']])->get();
        // $count=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%BB%']])->count('id_ThoiGian');
       
        // return view('admin.thongke.loaiNCKH.export.excel_baibao', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hk,'namhoc'=>$nh]);
        return Excel::download(new ThongKeLoai_BBExport_Admin,'DS_BB_NCKH.xlsx');
    }
    public function excel_thongke_LoaiTL_admin(){
        // $gv=GiangVien::all();
        // $tacgia = GiangVien_DeTai::all();
        // $user = Auth::user();
        // $uri = $_SERVER['REQUEST_URI'];
        // $a=explode('/', $uri);
        // $hk=$a[7];
        // $nh=$a[8];
        // $id_ThoiGian=ThoiGian::where([['HocKy','=',$hk],['NamHoc','=',$nh]])->first();
        // $thongke=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%TL%']])->get();
        // $count=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%TL%']])->count('id_ThoiGian');
       
        // return view('admin.thongke.loaiNCKH.export.excel_tlgd', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hk,'namhoc'=>$nh]);
        return Excel::download(new ThongKeLoai_TLExport_Admin,'DS_TL_NCKH.xlsx');
    }
    public function excel_thongke_LoaiKH_admin(){
        // $gv=GiangVien::all();
        // $tacgia = GiangVien_DeTai::all();
        // $user = Auth::user();
        // $uri = $_SERVER['REQUEST_URI'];
        // $a=explode('/', $uri);
        // $hk=$a[7];
        // $nh=$a[8];
        // $id_ThoiGian=ThoiGian::where([['HocKy','=',$hk],['NamHoc','=',$nh]])->first();
        // $thongke=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%HD%']])->get();
        // $count=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%HD%']])->count('id_ThoiGian');
       
        // return view('admin.thongke.loaiNCKH.export.excel_khac', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hk,'namhoc'=>$nh]);
        return Excel::download(new ThongKeLoai_KHExport_Admin,'DS_HD_NCKH.xlsx');
    }
}
