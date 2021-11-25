<?php

namespace App\Http\Controllers;
use App\Models\DeTai;
use App\Models\LoaiDeTai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoaiDeTaiController extends Controller
{
    public function getList()
    {
        //$loaidetai=LoaiDeTai::all();
        $loaidetai = LoaiDeTai::paginate(6);
        $user = Auth::user();

        return view('admin.loaidetai.index', ['loaidetai' => $loaidetai, 'user' => $user]);
    }
    public function getAdd()
    {
        $loaidetai = LoaiDeTai::all();;
        $user = Auth::user();
        return view('admin.loaidetai.add', ['loaidetai' => $loaidetai, 'user' => $user]);
    }
    public function postAdd(Request $request)
    {
        $this->validate(
            $request,
            [
                'TenLoaiDeTai' => 'required|min:3|max:255',
                'DonViTinh' => 'required|min:3|max:255',
                'TietQuyDoi' => 'required|min:3|max:255',

            ],
            [
                'TenLoaiDeTai.required' => 'Bạn chưa nhập tên Loại đề tài',
                'DonViTinh.required' => 'Bạn chưa nhập tên Đơn vị tính',
                'TietQuyDoi.required' => 'Bạn chưa nhập tên Tiết quy đổi',
                'TenLoaiDeTai.min' => 'Tên nhập phải có độ dài 3 đến 255 ký tự',
                'TenLoaiDeTai.max' => 'Tên nhập phải có độ dài 3 đến 255 ký tự',
            ]
        );
        $loaidetai = new LoaiDeTai();
        $loaidetai->TenLoaiDeTai = $request->TenLoaiDeTai;
        $loaidetai->DonViTinh = $request->DonViTinh;
        $loaidetai->TietQuyDoi = $request->TietQuyDoi;
        $loaidetai->save();
        return redirect('admin/loaidetai/add')->with('thongbao', 'Thêm loại đề tài mới thành công');
    }

    public function getUpdate($id)
    {
        $loaidetai = LoaiDeTai::where(['id_LoaiDeTai' => $id])->first();
        $user = Auth::user();
        return view('admin.loaidetai.update', ['loaidetai' => $loaidetai, 'user' => $user]);
    }

    public function postUpdate(Request $request, $id)
    {
        $loaidetai = LoaiDeTai::find($id);
        $loaidetai->TenLoaiDeTai = $request->TenLoaiDeTai;
        $loaidetai->DonViTinh = $request->DonViTinh;
        $loaidetai->TietQuyDoi = $request->TietQuyDoi;
        $loaidetai->save();
        return redirect('admin/loaidetai/update/' . $id)->with('thongbao', 'Sửa thông tin loại đề tài thành công');
    }

    public function getDelete($id)
    {
        if (DeTai::where('id_LoaiDeTai', $id)->exists()) {
            return redirect('admin/loaidetai/index')->with('thongbao1', 'Không thể xóa loại đề tài này!');
        } else {
            $loaidetai = LoaiDeTai::where(['id_LoaiDeTai' => $id]);
            $loaidetai->delete();
            return redirect('admin/loaidetai/index')->with('thongbao', 'Xóa thành công');
        }
    }
}
