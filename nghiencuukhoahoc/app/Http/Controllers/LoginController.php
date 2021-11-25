<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     if(Auth::check()){
    //         view()->share('users', Auth::user());
    //     }
    // }
    public function getLogin(){
        return view('login.index');
    }
    public function postLogin(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->LoaiTK==1){
                return redirect('admin/home');
            }
            else
            return redirect('users/nghiencuu/detai/index');

        }
        else
        {
            return redirect('login')->with('thongbao','Thông tin email hoặc mật khẩu sai');
        }

    }
    
}
