<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaiKhoanController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            view()->share('users', Auth::user());
        }
    }


    public function getList(){
        $users=User::all();
        $user=Auth::user();
        return view('admin.taikhoan.index', ['users'=>$users,'user'=>$user]);
    }
    public function getQuyen($id){
        $user=User::find($id);
        if($user->LoaiTK=="1"){
            $user->LoaiTK="0";
            $user->save();
            return redirect('admin/taikhoan/index')->with('thongbao', 'Đã thu hồi quyền Admin của tài khoản có ID là '.$id);
        }
        else{
            $user->LoaiTK="1";
            $user->save();
            return redirect('admin/taikhoan/index')->with('thongbao', 'Đã cấp quyền Admin cho tài khoản có ID là '.$id);
        }
    }
    public function getPass($id){
        $user=User::find($id);
        $user->password = bcrypt('P@ssw0rd');
        $user->save();
        return redirect('admin/taikhoan/index')->with('thongbao', 'Đã khôi phục lại mật khẩu cho tài khoản có ID là '.$id);
    }
    public function getDelete($id){
        $user=User::find($id);
        $user->delete();
        return redirect('admin/taikhoan/index')->with('thongbao', 'Đã xóa tài khoản có ID là '.$id);
    }
}
