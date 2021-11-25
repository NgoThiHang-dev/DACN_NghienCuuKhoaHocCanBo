<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiangVien;
use App\Models\Khoa;
use App\Models\TaiKhoan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GiangVienController extends Controller
{
    //
    // public function __construct()
    // {
    //     if(Auth::check()){
    //         view()->share('users', Auth::user());
    //     }
    // }
    public function getList()
    {
        //$giangvien = GiangVien::all();
        $giangvien = GiangVien::paginate(5);
        $user = Auth::user();
        return view('admin.giangvien.index', ['giangvien' => $giangvien, 'user'=>$user]);
    }

    public function getListGV_DT()
    {
        $user = Auth::user();
        //$user = Auth::user()->MaGV;

        $giangvien = GiangVien::find($user);
        //Auth::id();

        return view('user.index', ['giangvien' => $giangvien, 'user'=>$user]);
    }

    public function getAdd()
    {

        $khoa = Khoa::all()->toArray();
        $user = Auth::user();
        return view('admin.giangvien.add', ['khoa' => $khoa, 'user'=>$user]);
    }

    public function postAdd(Request $request)
    {
        $this->validate(
            $request,
            [
                'MaGV' => 'required',
                'TenGV' => 'required|min:3|max:35'
            ],
            [
                'MaGV.required' => 'Bạn chưa nhập mã giảng viên',
                'TenGV.required' => 'Bạn chưa nhập tên giảng viên',
                'Ten.min' => 'Tên nhập phải có độ dài 3 đến 35 ký tự',
                'Ten.max' => 'Tên nhập phải có độ dài 3 đến 35 ký tự',
            ]
        );
        if (GiangVien::where('MaGV', $request->MaGV)->exists()) {
            return redirect('admin/giangvien/add')->with('thongbao1', 'Mã giảng viên bạn nhập đã tồn tại!');
        } else {
            $giangvien = new GiangVien();
            $user = new User();
            $giangvien->MaGV = $request->MaGV;
            $giangvien->TenGV = $request->TenGV;
            $giangvien->MaKhoa = $request->MaKhoa;
            $giangvien->email = $request->email;
            $giangvien->SDT = $request->SDT;
            $giangvien->ChucVu = $request->ChucVu;
            $giangvien->HocVi = $request->HocVi;
            $giangvien->NgaySinh = $request->NgaySinh;
            $giangvien->GioiTinh = $request->GioiTinh;
            $giangvien->DiaChi = $request->DiaChi;
            if ($request->hasFile('HinhAnh')) {
                $file = $request->file('HinhAnh');
                $duoi = $file->getClientOriginalExtension();
                if ($duoi != 'jpg' && $duoi !='png') {
                    return redirect('admin/giangvien/add')->with('thongbao', 'Bạn chỉ được chọn file có đuôi jpg, png');
                }
                $fileName = $file->getClientOriginalName();
                echo $fileName;
                $file->move('upload/giangvien', $fileName);
                $giangvien->HinhAnh = $fileName;
            } else {
                $giangvien->HinhAnh = "";
            }
            $user->MaGV = $request->MaGV;
            $user->email = $request->email;
            $user->Password = bcrypt('123');
            $user->LoaiTK = "0";
            $giangvien->save();
            $user->save();

            return redirect('admin/giangvien/add')->with('thongbao', 'Thêm thành công');
        }
    }

    public function getUpdate($MaGV)
    {
        $giangvien = GiangVien::where(['MaGV' => $MaGV])->first();
        $khoa = Khoa::all()->toArray();
        $user = Auth::user();
        return view('admin.giangvien.update', ['giangvien' => $giangvien,'khoa' => $khoa, 'user'=>$user]);
    }

    public function postUpdate(Request $request, $MaGV)
    {
        // $data = $request->except(['_token']);
        $giangvien=GiangVien::find($MaGV);

            $giangvien->TenGV = $request->TenGV;
            $giangvien->MaKhoa = $request->MaKhoa;
            $giangvien->email = $request->email;
            $giangvien->SDT = $request->SDT;
            $giangvien->ChucVu = $request->ChucVu;
            $giangvien->HocVi = $request->HocVi;
            $giangvien->NgaySinh = $request->NgaySinh;
            $giangvien->GioiTinh = $request->GioiTinh;
            $giangvien->DiaChi = $request->DiaChi;
            if ($request->hasFile('HinhAnh')) {
                # code...

                $file = $request->file('HinhAnh');
                $duoi = $file->getClientOriginalExtension();
                if ($duoi != 'jpg' && $duoi !='png') {
                    # code...
                    return redirect('admin/giangvien/update/' . $MaGV)->with('loifile','Bạn chỉ được chọn file có đuôi jpg, png');
                }
                $fileName = $file->getClientOriginalName();

                $file->move('upload/giangvien',$fileName);
                if ($giangvien->HinhAnh != null) {
                    # code...
                    unlink('upload/giangvien/'.$giangvien->HinhAnh);
                }
                $giangvien->HinhAnh = $fileName;
            }
            $giangvien->save();
            // $giangvien->update($data);
        return redirect('admin/giangvien/update/' . $MaGV)->with('thongbao', 'Sửa thông tin giảng viên thành công');
    }

    public function getDelete($MaGV)
    {
        $giangvien=GiangVien::find($MaGV);
        $user = User::where(['MaGV' => $MaGV]);
        $user->delete();
        $giangvien->delete();
        unlink('upload/giangvien/'.$giangvien->HinhAnh);
        return redirect('admin/giangvien/index')->with('thongbao', 'Đã xóa giảng viên');
    }
}
