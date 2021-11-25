<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NghienCuuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\ThongKeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('login.index');
// });

// Route::get('/admin', function () {
//     return view('admin.home');
// });

Route::get('/login', [LoginController::class,'getLogin']);
Route::post('/login', [LoginController::class,'postLogin']);



Route::group(['prefix'=>'admin', 'middleware'=>'adminLogin'], function (){
    Route::group(['prefix'=>'khoa'], function(){
        Route::get('index', [\App\Http\Controllers\KhoaController::class, 'getList']);
        Route::get('update/{MaKhoa}', [\App\Http\Controllers\KhoaController::class, 'getUpdate']);
        Route::post('update/{MaKhoa}', [\App\Http\Controllers\KhoaController::class, 'postUpdate']);
        Route::get('add', [\App\Http\Controllers\KhoaController::class, 'getAdd']);
        Route::post('add', [\App\Http\Controllers\KhoaController::class, 'postAdd']);
        Route::get('delete/{MaKhoa}', [\App\Http\Controllers\KhoaController::class, 'getDelete']);
        Route::get('export', [ExportController::class,'export_Khoa'])->name('export_Khoa');
    });
    Route::group(['prefix'=>'giangvien'], function(){
        Route::get('index', [\App\Http\Controllers\GiangVienController::class, 'getList']);
        Route::get('update/{MaGV}', [\App\Http\Controllers\GiangVienController::class, 'getUpdate']);
        Route::post('update/{MaGV}', [\App\Http\Controllers\GiangVienController::class, 'postUpdate']);
        Route::get('add', [\App\Http\Controllers\GiangVienController::class, 'getAdd']);
        Route::post('add', [\App\Http\Controllers\GiangVienController::class, 'postAdd']);
        Route::get('delete/{MaGV}', [\App\Http\Controllers\GiangVienController::class, 'getDelete']);
    });
    Route::group(['prefix'=>'loaidetai'], function(){
        Route::get('index', [\App\Http\Controllers\LoaiDeTaiController::class, 'getList']);
        Route::get('update/{id}', [\App\Http\Controllers\LoaiDeTaiController::class, 'getUpdate']);
        Route::post('update/{id}', [\App\Http\Controllers\LoaiDeTaiController::class, 'postUpdate']);
        Route::get('add', [\App\Http\Controllers\LoaiDeTaiController::class, 'getAdd']);
        Route::post('add', [\App\Http\Controllers\LoaiDeTaiController::class, 'postAdd']);
        Route::get('delete/{id}', [\App\Http\Controllers\LoaiDeTaiController::class, 'getDelete']);
        Route::get('export', [ExportController::class,'export_LoaiDeTai'])->name('export_LoaiDeTai');
        Route::post('import', [ExportController::class,'import_LoaiDeTai'])->name('import_LoaiDeTai');
    });
    Route::group(['prefix'=>'taikhoan'], function(){
        Route::get('index', [TaiKhoanController::class, 'getList']);
        Route::get('quyen/{id}', [TaiKhoanController::class, 'getQuyen']);
        Route::get('pass/{id}', [TaiKhoanController::class, 'getPass']);
        Route::get('delete/{id}', [TaiKhoanController::class, 'getDelete']);
    });

    Route::group(['prefix'=>'nghiencuu'], function(){
        Route::group(['prefix'=>'detai'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_DT']);
            Route::get('add', [NghienCuuController::class, 'getAdd_DT']);
            Route::post('add', [NghienCuuController::class, 'postAdd_DT']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_DT']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_DT']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_DT']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_DT']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_DT']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_DT']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_DT']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_DT']);
            Route::get('excel', [ExportController::class, 'excel_dt_admin']);
        });
        Route::group(['prefix'=>'baibao'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_BB']);
            Route::get('add', [NghienCuuController::class, 'getAdd_BB']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_BB']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_BB']);
            Route::post('add', [NghienCuuController::class, 'postAdd_BB']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_BB']);
            Route::get('download/{id}', [NghienCuuController::class, 'getDownload_BB']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_BB']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_BB']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_BB']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_BB']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_BB']);
            Route::get('excel', [ExportController::class, 'excel_bb_admin']);
        });
        Route::group(['prefix'=>'tlgd'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_TLGD']);
            Route::get('add', [NghienCuuController::class, 'getAdd_TLGD']);
            Route::post('add', [NghienCuuController::class, 'postAdd_TLGD']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_TLGD']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_TLGD']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_TLGD']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_TLGD']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_TLGD']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_TLGD']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_TLGD']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_TLGD']);
            Route::get('excel', [ExportController::class, 'excel_tlgd_admin']);
        });
        Route::group(['prefix'=>'khac'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_Khac']);
            Route::get('add', [NghienCuuController::class, 'getAdd_KH']);
            Route::post('add', [NghienCuuController::class, 'postAdd_KH']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_KH']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_KH']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_KH']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_KHAC']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_KHAC']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_KHAC']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_KHAC']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_KHAC']);
            Route::get('excel', [ExportController::class, 'excel_khac_admin']);
        });

    });

    Route::group(['prefix'=>'thongke'], function(){
        Route::group(['prefix'=>'theokhoa'], function(){
            Route::get('index', [\App\Http\Controllers\ThongKeController::class, 'getListTK']);
            Route::post('index', [\App\Http\Controllers\ThongKeController::class, 'postListTK']);
        });
        Route::group(['prefix'=>'theogiangvien'], function(){
            Route::get('index', [\App\Http\Controllers\ThongKeController::class, 'getListTGV']);
            Route::post('index', [\App\Http\Controllers\ThongKeController::class, 'postListTGV']);
        });
        Route::group(['prefix'=>'theoloai'], function(){
            Route::get('index', [\App\Http\Controllers\ThongKeController::class, 'getListLoai']);
            Route::post('index', [\App\Http\Controllers\ThongKeController::class, 'postListLoai']);
            Route::get('excel_all/{hk}/{nk}', [ExportController::class, 'excel_thongke_LoaiAll_admin']);
            Route::get('excel_detai/{hk}/{nk}', [ExportController::class, 'excel_thongke_LoaiDT_admin']);
            Route::get('excel_baibao/{hk}/{nk}', [ExportController::class, 'excel_thongke_LoaiBB_admin']);
            Route::get('excel_tlgd/{hk}/{nk}', [ExportController::class, 'excel_thongke_LoaiTL_admin']);
            Route::get('excel_khac/{hk}/{nk}', [ExportController::class, 'excel_thongke_LoaiKH_admin']);
        });


    });

    Route::get('home', [ProfileController::class, 'getHome']);
    Route::get('logout', [ProfileController::class, 'logout']);
});


Route::group(['prefix'=>'users'], function (){
    Route::group(['prefix'=>'nghiencuu'], function(){
        Route::group(['prefix'=>'detai'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_DT_US']);
            Route::get('add', [NghienCuuController::class, 'getAdd_DT_US']);
            Route::post('add', [NghienCuuController::class, 'postAdd_DT_US']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_DT_US']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_DT_US']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_DT_US']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_DT_US']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_DT_US']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_DT_US']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_DT_US']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_DT_US']);
            Route::get('excel', [ExportController::class, 'excel_dt_user']);

        });
        Route::group(['prefix'=>'baibao'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_BB_US']);
            Route::get('add', [NghienCuuController::class, 'getAdd_BB_US']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_BB_US']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_BB_US']);
            Route::post('add', [NghienCuuController::class, 'postAdd_BB_US']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_BB_US']);
            Route::get('download/{id}', [NghienCuuController::class, 'getDownload_BB_US']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_BB_US']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_BB_US']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_BB_US']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_BB_US']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_BB_US']);
            Route::get('excel', [ExportController::class, 'excel_bb_user']);

        });
        Route::group(['prefix'=>'tlgd'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_TLGD_US']);
            Route::get('add', [NghienCuuController::class, 'getAdd_TLGD_US']);
            Route::post('add', [NghienCuuController::class, 'postAdd_TLGD_US']);
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_TLGD_US']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_TLGD_US']);
            Route::get('update/{id_detai}', [NghienCuuController::class, 'getUpdate_TLGD_US']);
            Route::post('update/{id_detai}', [NghienCuuController::class, 'postUpdate_TLGD_US']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_TLGD_US']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_TLGD_US']);
            Route::get('delete/{id}', [NghienCuuController::class, 'getDelete_TLGD_US']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_TLGD_US']);
            Route::get('excel', [ExportController::class, 'excel_tl_user']);
        });
        Route::group(['prefix'=>'khac'], function(){
            Route::get('index', [NghienCuuController::class, 'getList_Khac_US']);
            Route::get('add', [NghienCuuController::class, 'getAdd_Khac_US']);
            Route::post('add', [NghienCuuController::class, 'postAdd_Khac_US']);
            Route::get('update/{id_detai}/{MaGV}', [NghienCuuController::class, 'getUpdate_Khac_US']);
            Route::post('update/{id_detai}/{MaGV}', [NghienCuuController::class, 'postUpdate_Khac_US']);
            Route::get('delete/{id}/{MaGV}', [NghienCuuController::class, 'getDelete_Khac_US']);
            //tacgia
            Route::get('addTG/{id}', [NghienCuuController::class, 'getAddTG_khac_US']);
            Route::post('addTG/{id}', [NghienCuuController::class, 'postAddTG_khac_US']);
            Route::get('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'getUpdateTG_khac_US']);
            Route::post('updateTG/{id}/{MaGV}', [NghienCuuController::class, 'postUpdateTG_khac_US']);
            Route::get('deleteTG/{id}/{MaGV}', [NghienCuuController::class, 'getDeleteTG_khac_US']);
            Route::get('excel', [ExportController::class, 'excel_hd_user']);
        });


    });
    Route::get('my', [ProfileController::class, 'getThongTinUser']);
    Route::get('index', [NghienCuuController::class, 'getHome_User']);
    Route::get('logout', [ProfileController::class, 'logout']);
    // Route::get('confilm', function () {
    //     return view('users.lienhe.confilmpw');
    // });

    Route::get('doimatkhau', [ProfileController::class, 'getDoiMatKhau']);
    Route::post('doimatkhau', [ProfileController::class, 'postDoiMatKhau']);

});



Route::get('/home', 'HomeController@index');
Route::post('/home/fetch', 'HomeController@fetch')->name('home.fetch');



