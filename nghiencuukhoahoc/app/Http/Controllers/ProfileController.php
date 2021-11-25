<?php

namespace App\Http\Controllers;

use App\Models\GiangVien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getHome(){
        if (Auth::check()) {
            $user=Auth::user();
            return view('admin.home', ['user'=>$user]);
        }
        return redirect('login');
    }
    
    public function logout(){
        Auth::logout();
        return redirect('login');
    }
    public function getHome_User(){
        if (Auth::check()) {
            $user=Auth::user();
            return view('users.index', ['user'=>$user]);
        }
        return redirect('login');
    }
    public function getThongTinUser(){
        $user=Auth::user();
        $MaGV = $user->MaGV;
        $giangvien = GiangVien::where(['MaGV'=>$MaGV])->first();
        return view('users.lienhe.profile',['user'=>$user,'giangvien'=>$giangvien]);
    }
    
    // public function doimatkhau(Request $request){

    // }
    public function getDoiMatKhau(){
        $user=Auth::user();
        return view('users.lienhe.doimatkhau',['user'=>$user]);
    }
    public function postDoiMatKhau(Request $request){
        $user=Auth::user();
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Mật khẩu hiện tại của bạn không khớp với mật khẩu bạn cung cấp. Vui lòng thử lại.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Mật khẩu mới không thể giống với mật khẩu hiện tại của bạn. Vui lòng chọn một mật khẩu khác.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $tk=User::find($user->id);
        $tk->password = bcrypt($request->get('new-password'));
        $tk->save();

        return redirect()->back()->with("success","Đổi mật khẩu thành công !");
    }

}
