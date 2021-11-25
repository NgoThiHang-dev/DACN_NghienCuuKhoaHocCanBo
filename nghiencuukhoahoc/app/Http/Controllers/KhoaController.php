<?php

namespace App\Http\Controllers;

use App\Models\GiangVien;
use Illuminate\Http\Request;
use App\Models\Khoa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KhoaController extends Controller
{
    public function getList(){
        //$khoa=Khoa::all();
        $khoa=Khoa::paginate(5);
        $user=Auth::user();
        return view('admin.khoa.index', ['khoa'=>$khoa,'user'=>$user]);
    }

    public function getAdd(){
        $user=Auth::user();
        return view('admin.khoa.add', ['user'=>$user]);
    }
    public function postAdd(Request $request){
         $this->validate($request,
             [
                'MaKhoa' =>'required',
                'TenKhoa'=>'required|min:3|max:35'
             ],
             [
                'MaKhoa.required'=>'Bạn chưa nhập mã khoa',
                'TenKhoa.required'=>'Bạn chưa nhập tên khoa',
                'Ten.min'=>'Tên nhập phải có độ dài 3 đến 35 ký tự',
                 'Ten.max'=>'Tên nhập phải có độ dài 3 đến 35 ký tự',
             ]);
        if (Khoa::where('MaKhoa', $request->MaKhoa)->exists()) {
            return redirect('admin/khoa/add')->with('thongbao', 'Mã khoa bạn nhập đã tồn tại!');
        }
        else
        {
            $khoa=new Khoa;
            $khoa->MaKhoa=$request->MaKhoa;
            $khoa->TenKhoa=$request->TenKhoa;
            $khoa->save();
            return redirect('admin/khoa/add')->with('thongbao', 'Thêm Khoa mới thành công');
        }

    }

    public function getUpdate($MaKhoa){
        $user=Auth::user();
        $khoa=Khoa::where(['MaKhoa'=>$MaKhoa])->first();
        return view('admin.khoa.update', ['khoa'=>$khoa, 'user'=>$user]);
    }

    public function postUpdate(Request $request, $MaKhoa){
        $this->validate($request,
            [
                'MaKhoa' =>'required',
                'TenKhoa'=>'required|min:3|max:35'
            ],
            [
                'MaKhoa.required'=>'Bạn chưa nhập mã khoa',
                'TenKhoa.required'=>'Bạn chưa nhập tên khoa',
                'Ten.min'=>'Tên nhập phải có độ dài 3 đến 35 ký tự',
                'Ten.max'=>'Tên nhập phải có độ dài 3 đến 35 ký tự',
            ]);

        $data = request()->except(['_token']);
        Khoa::where(['MaKhoa'=> $MaKhoa])->update($data);
        return redirect('admin/khoa/update/'.$MaKhoa)->with('thongbao', 'Sửa thành công');
    }

    public function getDelete($MaKhoa){
        if (GiangVien::where('MaKhoa', $MaKhoa)->exists()) {
            return redirect('admin/khoa/index')->with('thongbao1', 'Không thể xóa vì còn giảng viên đang công tác trong Khoa');
        }
        else
        {
            $khoa=Khoa::where(['MaKhoa'=>$MaKhoa]);
            $khoa->delete();
            return redirect('admin/khoa/index')->with('thongbao', 'Xóa thành công');
        }

    }


}
