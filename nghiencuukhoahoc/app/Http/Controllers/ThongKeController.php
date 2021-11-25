<?php

namespace App\Http\Controllers;

use App\Models\DeTai;
use App\Models\GiangVien;
use App\Models\GiangVien_DeTai;
use App\Models\Khoa;
use App\Models\ThoiGian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    
    //Thống kê theo thời gian
    // public function getList(){
    //     $user = Auth::user();
    //     return view('admin.thongke.index', ['user'=>$user]);
    // }
    // public function postList(Request $request){
    //     $loai=$request->Loc;
    //     $tungay=$request->Tu;
    //     $denngay=$request->Den;
    //     $thongke=DeTai::all();
    //     $tacgia = GiangVien_DeTai::all();
    //     $user = Auth::user();
    //     return view('admin.thongke.index', ['thongke'=>$thongke,'user'=>$user,'tacgia'=>$tacgia,'loai'=>$loai,'tungay'=>$tungay,'denngay'=>$denngay]);
    // }
    public function getListTK(){
        $khoa = Khoa::all()->toArray();
        $thongke=DeTai::all();
        $tacgia = GiangVien_DeTai::all();
        $user = Auth::user();
        return view('admin.thongke.theokhoa.index', ['thongke'=>$thongke,'khoa'=>$khoa,'user'=>$user,'tacgia'=>$tacgia]);
    }
    public function postListTK(Request $request){
        $MaKhoa=$request->MaKhoa;
        $tungay=$request->Tu;
        $denngay=$request->Den;
        $user = Auth::user();
        $khoa = Khoa::all();
        $thongke=DB::table('gv_dt')
        ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        ->join('giangvien','giangvien.MaGV','=','gv_dt.MaGV')
        ->select('gv_dt.MaGV', DB::raw('SUM(SoTiet) as Tong'))
        ->where([['detai.NgayNghiemThu','>=',$tungay],['detai.NgayNghiemThu','<=',$denngay],['giangvien.MaKhoa','=',$MaKhoa]])
        ->groupBy('MaGV')
        ->get();
        
        return view('admin.thongke.theokhoa.index', ['thongke'=>$thongke,'khoa'=>$khoa,'user'=>$user]);
    }

     //Thống kê theo giảng viên
     public function getListTGV(){
        $gv=GiangVien::all();
        $thongke=DeTai::all();
        $tacgia = GiangVien_DeTai::all();
        $user = Auth::user();
        return view('admin.thongke.theogiangvien.index', ['thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia]);
    }
    public function postListTGV(Request $request){
        $gv=GiangVien::all();
        $thongke=DeTai::all();
        $tacgia = GiangVien_DeTai::all();
        $user = Auth::user();
        $MaGV=$request->MaGV;
        $tungay=$request->Tu;
        $denngay=$request->Den;
        $thongke=DB::table('gv_dt')
        ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        ->join('giangvien','giangvien.MaGV','=','gv_dt.MaGV')
        ->select('gv_dt.MaGV', DB::raw('SUM(SoTiet) as Tong'))
        ->where([['detai.NgayNghiemThu','>=',$tungay],['detai.NgayNghiemThu','<=',$denngay],['giangvien.MaGV','=',$MaGV]])
        ->groupBy('MaGV')
        ->get();
        return view('admin.thongke.theogiangvien.index', ['thongke'=>$thongke,'gv'=>$gv,'user'=>$user,'tacgia'=>$tacgia]);
    }

    //Thống kê theo loai
    public function getListLoai(){
        $gv=GiangVien::all();
        $thongke=DeTai::all();
        $tacgia = GiangVien_DeTai::all();
        $user = Auth::user();
        $hocky=DB::table('thoigian')
        ->select('HocKy')
        ->groupBy('HocKy')
        ->get();
        $namhoc=DB::table('thoigian')
        ->select('NamHoc')
        ->groupBy('NamHoc')
        ->orderByDesc('NamHoc')
        ->get();
        return view('admin.thongke.loaiNCKH.index', ['thongke'=>$thongke,'gv'=>$gv, 'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hocky,'namhoc'=>$namhoc]);
    }
    public function postListLoai(Request $request){
        $gv=GiangVien::all();
        $tacgia = GiangVien_DeTai::all();
        $user = Auth::user();
        $HocKy=$request->HocKy;
        $NamHoc=$request->NamHoc;
        $loai=$request->Loc;
        $hocky=DB::table('thoigian')
        ->select('HocKy')
        ->groupBy('HocKy')
        ->get();
        $namhoc=DB::table('thoigian')
        ->select('NamHoc')
        ->groupBy('NamHoc')
        ->orderByDesc('NamHoc')
        ->get();
        $id_ThoiGian=ThoiGian::where([['HocKy','=',$HocKy],['NamHoc','=',$NamHoc]])->first();
        if($loai==""){
            $thongke=DeTai::where(['id_ThoiGian'=>$id_ThoiGian->id_ThoiGian])->get();
            $count=DeTai::where(['id_ThoiGian'=>$id_ThoiGian->id_ThoiGian])->count('id_ThoiGian');
        }
        else{
            $thongke=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%' . $loai . '%']])->get();
            $count=DeTai::where([['id_ThoiGian','=',$id_ThoiGian->id_ThoiGian],['id_DeTai','LIKE','%' . $loai . '%']])->count('id_ThoiGian');
        }
        return view('admin.thongke.loaiNCKH.index', ['count'=>$count,'thongke'=>$thongke,'gv'=>$gv,'user'=>$user,'tacgia'=>$tacgia,'hocky'=>$hocky,'namhoc'=>$namhoc]);
    }

}
