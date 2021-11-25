<?php

namespace App\Http\Controllers;

use App\Exports\BaiBaoExport;
use App\Models\DeTai;
use App\Models\GiangVien;
use App\Models\GiangVien_DeTai;
use App\Models\LoaiDeTai;
use App\Models\ThoiGian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NghienCuuController extends Controller
{
    //-----------------------Admin----------------------------------
    //Đề tài nghiên cứu khoa học
    public function getList_DT(){
        $detai = DeTai::where('id_DeTai','LIKE','%DT%')->orderBy('NgayCapNhat', 'DESC')->get();
        $user = Auth::user();
        return view('admin.nghiencuu.detai.index',['detai'=>$detai, 'user'=>$user]);
    }
    public function getAdd_DT(Request $request){
        $user=Auth::user();
        $dt="đề tài";
        $dt1="chương trình";
        $dt2="dự án";
        $thoigian=ThoiGian::all();
        // $loaidetai = LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$b.'%')->get();
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$dt.'%')->orWhere('TenLoaiDeTai','LIKE','%'.$dt1.'%')->orWhere('TenLoaiDeTai','LIKE','%'.$dt2.'%')->get();
        return view('admin.nghiencuu.detai.add', ['user'=>$user,'loaidetai'=>$loaidetai, 'thoigian'=>$thoigian]);
    }
    public function postAdd_DT(Request $request)
    {
        $detai = new DeTai();
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $detai->id_DeTai = "DT" . random_int ( 1 , 99999 );
        $detai->TenDeTai = $request->TenDeTai;
        $detai->NgayTao = $dt->toDateString();
        $detai->NgayCapNhat = $dt->toDateString();
        $detai->TinhTrang = $request->TinhTrang;
        $detai->NgayNghiemThu = $request->NgayNghiemThu;
        $detai->TomTat = $request->TomTat;
        $detai->CapNC = $request->CapNC;
        $detai->NamXB = $request->NamXB;
        $detai->id_LoaiDeTai = $request->id_LoaiDeTai;
        $detai->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('admin/nghiencuu/detai/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/detai', $fileName);
            $detai->TepDinhKem = $fileName;
        } else {
            $detai->TepDinhKem = "";
        }
        $detai->save();
        return redirect('admin/nghiencuu/detai/index')->with('thongbao', 'Đã thêm một bài báo mới');
    }
    public function getUpdate_DT($id_detai)
    {
        $user = Auth::user();
        $thoigian=ThoiGian::all();
        $detai = DeTai::where(['id_DeTai' => $id_detai])->first();
        $dt="đề tài";
        $dt1="chương trình";
        $dt2="dự án";
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$dt.'%')->orWhere('TenLoaiDeTai','LIKE','%'.$dt1.'%')->orWhere('TenLoaiDeTai','LIKE','%'.$dt2.'%')->get();
        return view('admin.nghiencuu.detai.update', ['user' => $user, 'detai' => $detai, 'loaidetai' => $loaidetai, 'thoigian'=>$thoigian]);
    }
    public function postUpdate_DT(Request $request, $id_detai)
    {
        $detai = DeTai::find($id_detai);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $detai->TenDeTai = $request->TenDeTai;
        $detai->NgayCapNhat = $dt->toDateString();
        $detai->TinhTrang = $request->TinhTrang;
        $detai->NgayNghiemThu = $request->NgayNghiemThu;
        $detai->TomTat = $request->TomTat;
        $detai->CapNC = $request->CapNC;
        $detai->NamXB = $request->NamXB;
        $detai->id_LoaiDeTai = $request->id_LoaiDeTai;
        $detai->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                # code...
                return redirect('admin/nghiencuu/detai/update/' . $id_detai)->with('loifile', 'Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/detai/', $fileName);
            if ($detai->TepDinhKem != null) {
                unlink('upload/nghiencuu/detai/' . $detai->TepDinhKem);
            }
            $detai->TepDinhKem = $fileName;

        }
        $detai->save();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet==2){
            $sotiet=round($ldt->TietQuyDoi*(2/3),3);
            $sotiet1=round($ldt->TietQuyDoi*(1/3),3);
            $sotiet2=round($ldt->TietQuyDoi/4,3);

            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            if($so_tg_p==1){
                //$tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
                //$tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p>1){
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id_detai,'Đồng tác giả']);
            }

        }
        if($tiet>2){
            //$so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');

            if($so_tg_p==2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet1=round($sotiet/2,3);
                //$tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
                //$tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p>2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet2=round($sotiet/$so_tg_p,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id_detai,'Đồng tác giả']);
            }
        }
        return redirect('admin/nghiencuu/detai/update/' . $id_detai)->with('thongbao', 'Sửa thông tin bài báo thành công');
    }
    public function getDelete_DT($id)
    {
        $detai = DeTai::find($id);
        $tg_bb = GiangVien_DeTai::find($id);

        if(!isset($tg_bb->id_DeTai)){
            if($detai->TepDinhKem==null){
                $detai->delete();
            }
            else{
                $detai->delete();
                unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
            }
        }
        else{
            if($detai->TepDinhKem==null){
                $tg_bb->delete();
                $detai->delete();
            }
            else{
                $tg_bb->delete();
                unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
                $detai->delete();
            }
        }


        return redirect('admin/nghiencuu/detai/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID ' . $id);
    }
     //Tác giả đề tài
     public function getAddTG_DT($id){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.detai.addTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv]);
    }
    public function postAddTG_DT(Request $request, $id){
        $tg_bb = new GiangVien_DeTai();
        $tg_bb->MaGV=$request->MaGV;
        $tg_bb->id_DeTai=$id;
        $tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
        if($dem==1&&$tg_bb->VaiTro=="Tác giả chính"){
            return redirect('admin/nghiencuu/baibao/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
        }
        $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
        if($ss!=null){
            return redirect('admin/nghiencuu/detai/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
        }
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();

        if($tiet==1){
            if($tg_bb->VaiTro=="Tác giả chính"){
                $sotiet=$ldt->TietQuyDoi;
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
        }
        if($tiet==2){
            if($tg_bb->VaiTro=="Tác giả chính"){
                $sotiet=round($ldt->TietQuyDoi*(2/3),3);
                $sotiet1=round($ldt->TietQuyDoi*(1/3),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                $sotiet1=round($ldt->TietQuyDoi*(2/3),3);
                $sotiet2=round($sotiet1/2,2);
                $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
                if($so_tg_p>1){
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id,'Đồng tác giả']);
                }
                else{
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
                }

            }

        }
        if($tiet>2){
            if($tg_bb->VaiTro=="Tác giả chính"){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','<>','Tác giả chính']])->count();
                $sotiet1=round($sotiet/$so_tg_p,3);
                $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
            }
            else{
                $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
                echo $so_tg_p;
                echo $sotiet=round($ldt->TietQuyDoi/2,3);
                echo $sotiet1=round($sotiet/$so_tg_p,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro LIKE ?', [$sotiet,$id,'Tác giả chính']);
                for ($i = 1; $i <= $so_tg_p; $i++){
                    //$updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ? AND VaiTro<> ?', [$sotiet1, $id, $request->MaGV,'Tác giả chính']);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet1,$id,'Đồng tác giả']);
                }

            }

        }
        return redirect('admin/nghiencuu/detai/index')->with('thongbao','Đã thêm tác giả vào bài báo có '.$id.' thành công');
    }
    public function getUpdateTG_DT($id, $MaGV){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $tg=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.detai.updateTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv, 'tg'=>$tg]);
    }
    public function postUpdateTG_DT(Request $request, $id, $MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $tg_bb->SoTiet= $ldt->TietQuyDoi/$tiet;
        $tg_bb->save();
        return redirect('admin/nghiencuu/detai/index')->with('thongbao','Sửa thông tin tác giả thành công');
    }
    public function getDeleteTG_DT($id,$MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_bb->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        if($tiet==1){
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();


            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            }

        }
        if($tiet==2){
            $sotiet=round($ldt->TietQuyDoi*(2/3),3);
            $sotiet1=round($ldt->TietQuyDoi*(1/3),3);
            $sotiet2=round($ldt->TietQuyDoi/4,3);

            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            if($so_tg_p==1){
                $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
                $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p>1){
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id,'Đồng tác giả']);
            }

        }
        if($tiet>2){
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');

            if($so_tg_p==2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet1=round($sotiet/2,3);
                $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
                $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p>2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet2=round($sotiet/$so_tg_p,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id,'Đồng tác giả']);
            }
        }
        return redirect('admin/nghiencuu/detai/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID '.$id);
    }
    //---------------Bài báo nghiên cứu khoa học----------------------
    public function getList_BB(){
        if(Auth::check()){
            $detai = DeTai::where('id_DeTai','LIKE','%BB%')->orderBy('NgayCapNhat', 'DESC')->get();
            $user = Auth::user();
            return view('admin.nghiencuu.baibao.index',['detai'=>$detai, 'user'=>$user]);
        }
        return redirect('login');
    }
    public function getAdd_BB(Request $request)
    {
        $user = Auth::user();
        $bb = "bài báo";
        $thoigian=ThoiGian::all();
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai', 'LIKE', '%' . $bb . '%')->get();
        return view('admin.nghiencuu.baibao.add', ['user' => $user, 'thoigian'=>$thoigian, 'loaidetai' => $loaidetai]);
    }
    public function postAdd_BB(Request $request)
    {
        $baibao = new DeTai();
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $baibao->id_DeTai = "BB" . random_int ( 1 , 99999 );
        $baibao->TenDeTai = $request->TenDeTai;
        $baibao->NgayTao = $dt->toDateString();
        $baibao->NgayCapNhat = $dt->toDateString();
        $baibao->TinhTrang = $request->TinhTrang;
        $baibao->NgayNghiemThu = $request->NgayNghiemThu;
        $baibao->TomTat = $request->TomTat;
        $baibao->TenTapChi = $request->TenTapChi;
        $baibao->NamXB = $request->NamXB;
        $baibao->Trang = $request->Trang;
        $baibao->id_LoaiDeTai = $request->id_LoaiDeTai;
        $baibao->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('admin/nghiencuu/baibao/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/baibao', $fileName);
            $baibao->TepDinhKem = $fileName;
        } else {
            $baibao->TepDinhKem = "";
        }
        $baibao->save();
        return redirect('admin/nghiencuu/baibao/index')->with('thongbao', 'Đã thêm một bài báo mới');
    }
    public function getUpdate_BB($id_detai)
    {
        $user = Auth::user();
        $thoigian=ThoiGian::all();
        $baibao = DeTai::where(['id_DeTai' => $id_detai])->first();
        $bb = "bài báo";
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai', 'LIKE', '%' . $bb . '%')->get();
        return view('admin.nghiencuu.baibao.update', ['user' => $user, 'baibao' => $baibao, 'loaidetai' => $loaidetai, 'thoigian'=>$thoigian]);
    }
    public function postUpdate_BB(Request $request, $id_detai)
    {
        $baibao = DeTai::find($id_detai);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $baibao->TenDeTai = $request->TenDeTai;
        $baibao->NgayCapNhat = $dt->toDateString();
        $baibao->TinhTrang = $request->TinhTrang;
        $baibao->NgayNghiemThu = $request->NgayNghiemThu;
        $baibao->TomTat = $request->TomTat;
        $baibao->TenTapChi = $request->TenTapChi;
        $baibao->NamXB = $request->NamXB;
        $baibao->Trang = $request->Trang;
        $baibao->id_LoaiDeTai = $request->id_LoaiDeTai;
        $baibao->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                # code...
                return redirect('admin/nghiencuu/baibao/update/' . $id_detai)->with('loifile', 'Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/baibao/', $fileName);
            if ($baibao->TepDinhKem != null) {
                unlink('upload/nghiencuu/baibao/' . $baibao->TepDinhKem);
            }
            $baibao->TepDinhKem = $fileName;
        }
        $baibao->save();
        //$id_dt=$request->id_DeTai;
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);

        }
        return redirect('admin/nghiencuu/baibao/update/' . $id_detai)->with('thongbao', 'Sửa thông tin bài báo thành công');
    }
    public function getDelete_BB($id)
    {
        $detai = DeTai::find($id);
        $tg_bb = GiangVien_DeTai::find($id);
        if(!isset($tg_bb->id_DeTai)){
            if($detai->TepDinhKem==null){
                $detai->delete();
            }
            else{
                $detai->delete();
                unlink('upload/nghiencuu/baibao/'.$detai->TepDinhKem);
            }
        }
        else{
            if($detai->TepDinhKem==null){
                $tg_bb->delete();
                $detai->delete();
            }
            else{
                $tg_bb->delete();
                unlink('upload/nghiencuu/baibao/'.$detai->TepDinhKem);
                $detai->delete();
            }
        }



        return redirect('admin/nghiencuu/baibao/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID ' . $id);
    }
    //Tác giả bài báo
    public function getAddTG_BB($id){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.baibao.addTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv]);
    }
    public function postAddTG_BB(Request $request, $id){
        $tg_bb = new GiangVien_DeTai();
        $tg_bb->MaGV=$request->MaGV;
        $tg_bb->id_DeTai=$id;
        $tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
        if($dem==1&&$tg_bb->VaiTro=="Tác giả chính"){
            return redirect('admin/nghiencuu/baibao/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
        }
        $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
        if($ss!=null){
            return redirect('admin/nghiencuu/baibao/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
        }
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        if($tiet==1){
            if($tg_bb->VaiTro=="Tác giả chính"){
                $sotiet=$ldt->TietQuyDoi;
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
            else{
                $sotiet=$ldt->TietQuyDoi/2;
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
        }
        else{
            $sotiet=$ldt->TietQuyDoi/$tiet;
            $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet,$id, $request->MaGV]);
        }
        return redirect('admin/nghiencuu/baibao/index')->with('thongbao','Đã thêm tác giả vào bài báo có '.$id.' thành công');
    }
    public function getUpdateTG_BB($id, $MaGV){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $tg=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.baibao.updateTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv, 'tg'=>$tg]);
    }
    public function postUpdateTG_BB(Request $request, $id, $MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
        if($dem==1&&$tg_bb->VaiTro=="Tác giả chính"){
            return redirect('admin/nghiencuu/baibao/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
        }
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $tg_bb->SoTiet= $ldt->TietQuyDoi/$tiet;
        $tg_bb->save();
        return redirect('admin/nghiencuu/baibao/index')->with('thongbao','Sửa thông tin tác giả thành công');
    }
    public function getDeleteTG_BB($id,$MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_bb->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();

        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);

        }
        return redirect('admin/nghiencuu/baibao/index')->with('thongbao','Xóa thành công tác giả bài báo có ID '.$id);
    }
    public function getDownload_BB($id){
        //$dl=DeTai::find($id);
        $file_path = public_path('upload/nghiencuu/baibao/'.$id);
        return response()->download($file_path);

    }
    //Sách, giáo trình, tài liệu giang day
    public function getList_TLGD(){
        $detai = DeTai::where('id_DeTai','LIKE','%TL%')->orderBy('NgayCapNhat', 'DESC')->get();
        $user = Auth::user();
        return view('admin.nghiencuu.tlgd.index',['detai'=>$detai, 'user'=>$user]);
    }
    public function getAdd_TLGD(){
        $user=Auth::user();
        $thoigian=ThoiGian::all();
        $loaidetai = LoaiDeTai::all();
        $bt=GiangVien_DeTai::all();
        return view('admin.nghiencuu.tlgd.add', ['user'=>$user,'loaidetai'=>$loaidetai, 'thoigian'=>$thoigian, 'bt'=>$bt]);
    }
    public function postAdd_TLGD(Request $request)
    {
        $detai = new DeTai();
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $detai->id_DeTai = "TL" . random_int ( 1 , 99999 );
        $detai->TenDeTai = $request->TenDeTai;
        $detai->NgayTao = $dt->toDateString();
        $detai->NgayCapNhat = $dt->toDateString();
        $detai->TinhTrang = $request->TinhTrang;
        $detai->NgayNghiemThu = $request->NgayNghiemThu;
        $detai->TomTat = $request->TomTat;
        $detai->DinhDang = $request->DinhDang;
        $detai->LoaiBienTap = $request->LoaiBienTap;
        $detai->NamXB = $request->NamXB;
        $detai->id_LoaiDeTai = $request->id_LoaiDeTai;
        $detai->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('admin/nghiencuu/tlgd/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/tlgd', $fileName);
            $detai->TepDinhKem = $fileName;
        } else {
            $detai->TepDinhKem = "";
        }
        $detai->save();


        return redirect('admin/nghiencuu/tlgd/index')->with('thongbao', 'Thêm thành công');
    }
    public function getUpdate_TLGD($id_detai)
    {
        $user = Auth::user();
        $thoigian=ThoiGian::all();
        $detai = DeTai::where(['id_DeTai' => $id_detai])->first();
        $dt="đề tài";
        $dt1="chương trình";
        $dt2="dự án";
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$dt.'%')->orWhere('TenLoaiDeTai','LIKE','%'.$dt1.'%')->orWhere('TenLoaiDeTai','LIKE','%'.$dt2.'%')->get();
        return view('admin.nghiencuu.tlgd.update', ['user' => $user, 'detai' => $detai, 'loaidetai' => $loaidetai, 'thoigian'=>$thoigian]);
    }
    public function postUpdate_TLGD(Request $request, $id_detai)
    {
        $detai = DeTai::find($id_detai);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $detai->TenDeTai = $request->TenDeTai;
        $detai->NgayCapNhat = $dt->toDateString();
        $detai->TinhTrang = $request->TinhTrang;
        $detai->NgayNghiemThu = $request->NgayNghiemThu;
        $detai->TomTat = $request->TomTat;
        $detai->DinhDang = $request->DinhDang;
        $detai->LoaiBienTap = $request->LoaiBienTap;
        $detai->NamXB = $request->NamXB;
        $detai->id_LoaiDeTai = $request->id_LoaiDeTai;
        $detai->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                # code...
                return redirect('admin/nghiencuu/tlgd/update/' . $id_detai)->with('loifile', 'Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName = $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/tlgd/', $fileName);
            if ($detai->TepDinhKem != null) {
                unlink('upload/nghiencuu/tlgd/' . $detai->TepDinhKem);
            }
            $detai->TepDinhKem = $fileName;
        }
        $detai->save();
        //$tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($id_ldt->LoaiBienTap=="Ban đầu"){
            $gio_QD=$ldt->TietQuyDoi;
        }
        if($id_ldt->LoaiBienTap=="Chỉnh lý - Lần 1"){
            $gio_QD=$ldt->TietQuyDoi*0.5;
        }
        if($id_ldt->LoaiBienTap=="Chỉnh lý - Lần 2"){
            $gio_QD=$ldt->TietQuyDoi*0.25;
        }
        if($id_ldt->LoaiBienTap=="Chỉnh lý - Lần 3"){
            $gio_QD=$ldt->TietQuyDoi*0.125;
        }
        if($tiet==1){
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round($gio_QD,3);
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round(($gio_QD*1)/(3*$so_tg_p),3);
            if($so_tg_c==0){
                if($so_tg_p==1){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
                }
                if($so_tg_p==2){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
                }
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
            }
        }
        if($tiet>=4){
            $sotiet=round($gio_QD*(1/3),3);
            $sotiet1=round($gio_QD*(2/3),3);
            $sotiet2=round(($gio_QD*2)/(3*$so_tg_p),3);
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
            }
        }
        return redirect('admin/nghiencuu/tlgd/update/' . $id_detai)->with('thongbao', 'Sửa thông tin thành công');
    }
    public function getDelete_TLGD($id)
    {
        $detai = DeTai::find($id);
        $tg_bb = GiangVien_DeTai::find($id);

        if(!isset($tg_bb->id_DeTai)){
            if($detai->TepDinhKem==null){
                $detai->delete();
            }
            else{
                $detai->delete();
                unlink('upload/nghiencuu/tlgd/'.$detai->TepDinhKem);
            }
        }
        else{
            if($detai->TepDinhKem==null){
                $tg_bb->delete();
                $detai->delete();
            }
            else{
                $tg_bb->delete();
                unlink('upload/nghiencuu/tlgd/'.$detai->TepDinhKem);
                $detai->delete();
            }
        }
        return redirect('admin/nghiencuu/tlgd/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID ' . $id);
    }
     //Tác giả đề tài
     public function getAddTG_TLGD($id){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.tlgd.addTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv]);
    }
    public function postAddTG_TLGD(Request $request, $id){
        $tg_bb = new GiangVien_DeTai();
        $tg_bb->MaGV=$request->MaGV;
        $tg_bb->id_DeTai=$id;
        $tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
        if($dem==1&&$tg_bb->VaiTro=="Tác giả chính"){
            return redirect('admin/nghiencuu/tlgd/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
        }
        $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
        if($ss!=null){
            return redirect('admin/nghiencuu/tlgd/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
        }
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_detai=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_detai->id_LoaiDeTai])->first();
        if($id_detai->LoaiBienTap=="Ban đầu"){
            $gio_QD=$ldt->TietQuyDoi;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 1"){
            $gio_QD=$ldt->TietQuyDoi*0.5;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 2"){
            $gio_QD=$ldt->TietQuyDoi*0.25;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 3"){
            $gio_QD=$ldt->TietQuyDoi*0.125;
        }
        if($tiet==1){
            $sotiet=$gio_QD;
            $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
        }
        if($tiet>=2){
            $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            if($tg_bb->VaiTro=="Tác giả chính"){
                $sotiet=round($gio_QD*(2/3),3);
                $sotiet1=round(($gio_QD*1)/(3*$so_tg_p),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
            }
            else{

                $sotiet=round($gio_QD*(2/3), 3);
                $sotiet1=round(($gio_QD*1)/(3*$so_tg_p), 3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro LIKE ?', [$sotiet,$id,'Tác giả chính']);
                for ($i = 1; $i <= $so_tg_p; $i++) {
                    //$updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ? AND VaiTro<> ?', [$sotiet1, $id, $request->MaGV,'Tác giả chính']);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet1,$id,'Đồng tác giả']);
                }

            }

        }
        if ($tiet>=4) {
            $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','<>','Tác giả chính']])->count();
            if ($tg_bb->VaiTro=="Tác giả chính") {
                $sotiet=round($gio_QD*(1/3), 3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                $sotiet1=round(($gio_QD*2)/(3*$so_tg_p), 3);
                $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
            } else {
                $sotiet=round($gio_QD*(1/3), 3);
                $sotiet1=round(($gio_QD*2)/(3*$so_tg_p), 3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro LIKE ?', [$sotiet,$id,'Tác giả chính']);
                for ($i = 1; $i <= $so_tg_p; $i++) {
                    //$updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ? AND VaiTro<> ?', [$sotiet1, $id, $request->MaGV,'Tác giả chính']);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet1,$id,'Đồng tác giả']);
                }
            }
        }
        return redirect('admin/nghiencuu/tlgd/index')->with('thongbao','Đã thêm tác giả vào bài báo có '.$id.' thành công');
    }
    public function getUpdateTG_TLGD($id, $MaGV){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $tg=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.tlgd.updateTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv, 'tg'=>$tg]);
    }
    public function postUpdateTG_TLGD(Request $request, $id, $MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_bb->save();
        return redirect('admin/nghiencuu/tlgd/index')->with('thongbao','Sửa thông tin tác giả thành công');
    }
    public function getDeleteTG_TLGD($id,$MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_bb->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_detai=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_detai->id_LoaiDeTai])->first();
        if($id_detai->LoaiBienTap=="Ban đầu"){
            $gio_QD=$ldt->TietQuyDoi;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 1"){
            $gio_QD=$ldt->TietQuyDoi*0.5;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 2"){
            $gio_QD=$ldt->TietQuyDoi*0.25;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 3"){
            $gio_QD=$ldt->TietQuyDoi*0.125;
        }
        if($tiet==1){
            // $tg_bb->SoTiet= round($gio_QD,3);
            // $tg_bb->save();
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round($gio_QD,3);
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);

            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_c->VaiTro]);
            }
        }
        if($tiet==2){
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round(($gio_QD*1)/(3*$so_tg_p),3);
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($so_tg_c==0){
                if($so_tg_p==1){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
                }
                if($so_tg_p==2){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_p->VaiTro]);
                }
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
            }
        }
        if($tiet>=3){
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $sotiet=round($gio_QD*(1/3),3);
            $sotiet1=round($gio_QD*(2/3),3);
            $sotiet2=round(($gio_QD*2)/(3*$so_tg_p),3);
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_p->VaiTro]);
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_p->VaiTro]);
            }
        }
        return redirect('admin/nghiencuu/tlgd/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID '.$id);
    }
    //Các hoạt động khoa học khác
    public function getList_Khac(){
        $detai = DeTai::where('id_DeTai','LIKE','%HD%')->orderBy('NgayCapNhat', 'DESC')->get();
        $user = Auth::user();
        return view('admin.nghiencuu.khac.index',['detai'=>$detai, 'user'=>$user]);
    }
    public function getAdd_KH()
    {
        $user = Auth::user();
        $thoigian=ThoiGian::all();
        $loaidetai = LoaiDeTai::all();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.khac.add', ['user' => $user, 'thoigian'=>$thoigian, 'loaidetai' => $loaidetai, 'gv' => $gv]);
    }
    public function postAdd_KH(Request $request)
    {
        $hoatdong = new DeTai();
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $hoatdong->id_DeTai = "HD" . random_int ( 1 , 99999 );
        $hoatdong->TenDeTai = $request->TenDeTai;
        $hoatdong->NgayTao = $dt->toDateString();
        $hoatdong->NgayCapNhat = $dt->toDateString();
        $hoatdong->TomTat = $request->TomTat;
        $hoatdong->CoSoTC = $request->CoSoTC;
        $hoatdong->NamXB = $request->NamXB;
        $hoatdong->NgayNghiemThu = $request->NgayNghiemThu;
        $hoatdong->TinhTrang = $request->TinhTrang;
        $hoatdong->DinhDang = $request->DinhDang;
        $hoatdong->id_LoaiDeTai = $request->id_LoaiDeTai;
        $hoatdong->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('admin/nghiencuu/khac/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/khac', $fileName);
            $hoatdong->TepDinhKem = $fileName;
        } else {
            $hoatdong->TepDinhKem = "";
        }
        $hoatdong->save();
        return redirect('admin/nghiencuu/khac/index')->with('thongbao', 'Đã thêm một bài báo mới');
    }
    public function getUpdate_KH($id_detai)
    {
        $user = Auth::user();
        $thoigian=ThoiGian::all();
        $detai = DeTai::where(['id_DeTai' => $id_detai])->first();
        $loaidetai = LoaiDeTai::all();
        return view('admin.nghiencuu.khac.update', ['user' => $user, 'detai' => $detai, 'loaidetai' => $loaidetai, 'thoigian'=>$thoigian]);
    }
    public function postUpdate_KH(Request $request, $id_detai)
    {
        $hoatdong = DeTai::find($id_detai);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $hoatdong->TenDeTai = $request->TenDeTai;
        $hoatdong->NgayCapNhat = $dt->toDateString();
        $hoatdong->TomTat = $request->TomTat;
        $hoatdong->CoSoTC = $request->CoSoTC;
        $hoatdong->NamXB = $request->NamXB;
        $hoatdong->DinhDang = $request->DinhDang;
        $hoatdong->TinhTrang = $request->TinhTrang;
        $hoatdong->NgayNghiemThu = $request->NgayNghiemThu;
        $hoatdong->id_LoaiDeTai = $request->id_LoaiDeTai;
        $hoatdong->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('admin/nghiencuu/khac/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/khac', $fileName);
            if ($hoatdong->TepDinhKem != null) {
                unlink('upload/nghiencuu/khac/'.$hoatdong->TepDinhKem);
            }
            $hoatdong->TepDinhKem = $fileName;
        }
        $hoatdong->save();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);

        }
        return redirect('admin/nghiencuu/khac/update/' . $id_detai)->with('thongbao', 'Sửa thông tin bài báo thành công');
    }
    public function getDelete_KH($id){
        $hoatdong=DeTai::find($id);
        $tg=GiangVien_DeTai::find($id);

        if(!isset($tg->id_DeTai)){
            if($hoatdong->TepDinhKem==null){
                $hoatdong->delete();
            }
            else{
                $hoatdong->delete();
                unlink('upload/nghiencuu/khac/'.$hoatdong->TepDinhKem);
            }
        }
        else{
            if($hoatdong->TepDinhKem==null){
                $tg->delete();
                $hoatdong->delete();
            }
            else{
                $tg->delete();
                unlink('upload/nghiencuu/khac/'.$hoatdong->TepDinhKem);
                $hoatdong->delete();
            }
        }

        return redirect('admin/nghiencuu/khac/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID '.$id);
    }
     //Tác giả đề tài
     public function getAddTG_KHAC($id){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.khac.addTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv]);
    }
    public function postAddTG_KHAC(Request $request, $id){
        $tg_bb = new GiangVien_DeTai();
        $tg_bb->MaGV=$request->MaGV;
        $tg_bb->id_DeTai=$id;
        $tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
        if($dem==1&&$tg_bb->VaiTro=="Tác giả chính"){
            return redirect('admin/nghiencuu/khac/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
        }
        $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
        if($ss!=null){
            return redirect('admin/nghiencuu/khac/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
        }
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        if($tiet==1){
            if($tg_bb->VaiTro=="Tác giả chính"){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
        }
        else{
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet,$id, $request->MaGV]);
        }
        return redirect('admin/nghiencuu/khac/index')->with('thongbao','Đã thêm tác giả vào bài báo có '.$id.' thành công');
    }
    public function getUpdateTG_KHAC($id, $MaGV){
        $user=Auth::user();
        $detai = DeTai::where(['id_DeTai'=>$id])->first();
        $tg=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $gv=GiangVien::all();
        return view('admin.nghiencuu.khac.updateTG', ['user'=>$user, 'detai'=>$detai,'gv'=>$gv, 'tg'=>$tg]);
    }
    public function postUpdateTG_KHAC(Request $request, $id, $MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_bb->save();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $tg_bb->SoTiet= $ldt->TietQuyDoi/$tiet;
        $tg_bb->save();
        return redirect('admin/nghiencuu/khac/index')->with('thongbao','Sửa thông tin tác giả thành công');
    }
    public function getDeleteTG_KHAC($id,$MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_bb->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        echo $tiet;
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);

        }
        return redirect('admin/nghiencuu/khac/index')->with('thongbao', 'Xóa thành công tác giả bài báo có ID '.$id);
    }
    //-----------------------users--------------------------------------------------------------------------------

    // public function getList_DT_US(){
    //     $detai = DeTai::all();
    //     $user = Auth::user();
    //     return view('users.nghiencuu.detai.index',['detai'=>$detai, 'user'=>$user]);
    // }
    public function getHome_User(){
        $user = Auth::user();
        $detai = DeTai::all();
        return view('users.index',['detai'=>$detai, 'user'=>$user]);
    }
    //--------De tai---------------------------------
    public function getList_DT_US(){
        $user = Auth::user();
        //$dt1=GiangVien_DeTai::where([['MaGV', '=', $user->MaGV],['id_DeTai','LIKE','%DT%']])->get();
        $dt1=DB::table('gv_dt')
        ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        ->select('gv_dt.id_DeTai')
        ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%DT%']])
        ->orderBy('detai.NgayCapNhat', 'DESC')
        ->get();
        return view('users.nghiencuu.detai.index', ['detai' => $dt1,'user' => $user]);
    }

    public function getAdd_DT_US(Request $request){
        $user=Auth::user();
        $dt="đề tài";
        $thoigian=ThoiGian::all();
        $MaGV = $user->MaGV;
        $giangvien = GiangVien::where(['MaGV'=>$MaGV])->first();
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$dt.'%')->get();
        return view('users.nghiencuu.detai.add', ['user'=>$user,'loaidetai'=>$loaidetai, 'giangvien'=>$giangvien, 'thoigian'=>$thoigian]);
    }

    public function postAdd_DT_US(Request $request){
        $detai = new DeTai();
        $dt=Carbon::now('Asia/Ho_Chi_Minh');
        $detai->id_DeTai = "DT".random_int ( 1 , 99999 );
        $detai->TenDeTai = $request->TenDeTai;
        $detai->NgayTao = $dt->toDateString();
        $detai->NgayCapNhat = $dt->toDateString();
        $detai->CapNC = $request->CapNC;
        $detai->TomTat = $request->TomTat;
        $detai->TinhTrang = $request->TinhTrang;
        $detai->NgayNghiemThu = $request->NgayNghiemThu;
        $detai->id_ThoiGian = $request->id_ThoiGian;
        $detai->NamXB = $request->NamXB;
        $detai->id_LoaiDeTai = $request->id_LoaiDeTai;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('users/nghiencuu/detai')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/detai', $fileName);
            $detai->TepDinhKem = $fileName;
        } else {
            $detai->TepDinhKem = "";
        }
        $detai->save();
        $tg_dt= new GiangVien_DeTai();
        $tg_dt->id_DeTai=$detai->id_DeTai;
        $tg_dt->id_DeTai;
        $tg_dt->MaGV=$request->MaGV;
        $detai->id_DeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$detai->id_LoaiDeTai])->first();

        $tg_dt->VaiTro= $request->VaiTro;
        if($request->VaiTro=="Tác giả chính"){
            $tg_dt->SoTiet= $ldt->TietQuyDoi;
        }
        else{
            $sotiet=round($ldt->TietQuyDoi*(1/3),3);
            $tg_dt->SoTiet= $sotiet;
        }
        $tg_dt->NgayThamGia=$request->NgayThamGia;
        $tg_dt->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_dt->save();
        return redirect('users/nghiencuu/detai/index')->with('thongbao','Đã thêm một đề tài nghiên cứu mới');
    }

    public function getAddTG_DT_US($id){
        if (Auth::check()) {
            $user=Auth::user();
            $giangvien = GiangVien::all();
            $detai = DeTai::where(['id_DeTai'=>$id])->first();
            return view('users.nghiencuu.detai.addTG', ['user'=>$user, 'detai'=>$detai,'giangvien'=>$giangvien]);
        }
        return redirect('login');
    }
    public function postAddTG_DT_US(Request $request, $id){
        if (Auth::check()) {
            $tg_dt = new GiangVien_DeTai();
            $tg_dt->MaGV=$request->MaGV;
            $tg_dt->id_DeTai=$id;
            $tg_dt->VaiTro=$request->VaiTro;
            $tg_dt->NgayThamGia=$request->NgayThamGia;
            $tg_dt->NgayKetThucTG=$request->NgayKetThucTG;
            $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
            if($dem==1 && $tg_dt->VaiTro=="Tác giả chính"){
                return redirect('users/nghiencuu/detai/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
            }
            $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
            if($ss!=null){
                return redirect('users/nghiencuu/detai/index')->with('thongbao1','Giảng viên đã là tác giả của đề tài. Không thể thêm');
            }
            $tg_dt->save();
            $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
            $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
            $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
            $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
            if($tiet==2){
                if($tg_bb->VaiTro=="Tác giả chính"){
                    $sotiet=round($ldt->TietQuyDoi*(2/3),3);
                    $sotiet1=round($ldt->TietQuyDoi*(1/3),3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                    $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
                }
                else{
                    $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                    $sotiet1=round($ldt->TietQuyDoi*(2/3),3);
                    $sotiet2=round($sotiet1/2,2);
                    $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
                    if($so_tg_p>1){
                        $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id,'Đồng tác giả']);
                    }
                    else{
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                    $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
                    }

                }

            }
            if($tiet>2){
                if($tg_bb->VaiTro=="Tác giả chính"){
                    $sotiet=round($ldt->TietQuyDoi/2,3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                    $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','<>','Tác giả chính']])->count();
                    $sotiet1=round($sotiet/$so_tg_p,3);
                    $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
                }
                else{
                    $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
                    $sotiet=round($ldt->TietQuyDoi/2,3);
                    $sotiet1=round($sotiet/$so_tg_p,3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro LIKE ?', [$sotiet,$id,'Tác giả chính']);
                    for ($i = 1; $i <= $so_tg_p; $i++){
                        $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ? AND VaiTro<> ?', [$sotiet1, $id, $request->MaGV,'Tác giả chính']);
                        $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet1,$id,'Đồng tác giả']);
                    }

                }

            }
            return redirect('users/nghiencuu/detai/index')->with('thongbao','Đã thêm tác giả '.$request->MaGV.' vào đề tài có '.$id.' thành công');
        }
        return redirect('login');
    }

    public function getUpdate_DT_US($id_detai){
        if (Auth::check()) {
            $user=Auth::user();
            $detai = DeTai::where(['id_DeTai' => $id_detai])->first();
            $dt="đề tài";
            $thoigian=ThoiGian::all();
            $loaidetai=LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$dt.'%')->get();
            return view('users.nghiencuu.detai.update', ['user'=>$user,'detai' => $detai, 'loaidetai'=>$loaidetai, 'thoigian'=>$thoigian]);
        }
        return redirect('login');
    }
    public function postUpdate_DT_US(Request $request, $id_detai){
        $detai = DeTai::find($id_detai);
        $dt=Carbon::now('Asia/Ho_Chi_Minh');
        $detai->id_DeTai = $request->id_DeTai;
        $detai->TenDeTai = $request->TenDeTai;
        $detai->NgayTao = $dt->toDateString();
        $detai->NgayCapNhat = $dt->toDateString();
        $detai->CapNC = $request->CapNC;
        $detai->TomTat = $request->TomTat;
        $detai->TinhTrang = $request->TinhTrang;
        $detai->NgayNghiemThu = $request->NgayNghiemThu;
        $detai->id_ThoiGian = $request->id_ThoiGian;
        $detai->NamXB = $request->NamXB;
        $detai->id_LoaiDeTai = $request->id_LoaiDeTai;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                # code...
                return redirect('users/nghiencuu/detai/update/' . $id_detai)->with('loifile','Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/detai/',$fileName);
            if ($detai->TepDinhKem != null) {
                unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
            }
            $detai->TepDinhKem = $fileName;
        }
        $detai->save();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet==2){
            $sotiet=round($ldt->TietQuyDoi*(2/3),3);
            $sotiet1=round($ldt->TietQuyDoi*(1/3),3);
            $sotiet2=round($ldt->TietQuyDoi/4,3);

            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            if($so_tg_p==1){
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p>1){
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id_detai,'Đồng tác giả']);
            }

        }
        if($tiet>2){
            if($so_tg_p==2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet1=round($sotiet/2,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p>2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet2=round($sotiet/$so_tg_p,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id_detai,'Đồng tác giả']);
            }
        }
        return redirect('users/nghiencuu/detai/update/'.$id_detai)->with('thongbao','Sửa thông tin đề tài thành công');
    }

    public function getUpdateTG_DT_US($id,$MaGV){
        $user=Auth::user();
        $dt=DeTai::where(['id_DeTai'=>$id])->first();
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg=GiangVien::where(['MaGV'=>$MaGV])->first();
        return view('users.nghiencuu.detai.updateTG',['detai'=>$dt,'tacgia'=>$tg, 'user'=>$user, 'tg_dt'=>$tg_dt]);


    }
    public function postUpdateTG_DT_US($id,$MaGV, Request $request){
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        //$tg_bb->VaiTro=$request->VaiTro;
        $tg_dt->NgayThamGia=$request->NgayThamGia;
        $tg_dt->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_dt->save();
        return redirect('users/nghiencuu/detai/updateTG/'.$id.'/'.$MaGV)->with('thongbao','Sửa thông tin tác giả thành công');
    }

    public function getDelete_DT_US($id){
        $detai=DeTai::find($id);
        $user=Auth::user();
        $ma=$user->MaGV;
        $tg_dt=GiangVien_DeTai::where('MaGV','=',$ma)->get();
        foreach ($tg_dt as $value) {
            if ($user->MaGV=$value->MaGV) {
                GiangVien_DeTai::find($id)->delete();
                if(!isset($tg_dt->id_DeTai)){
                    if($detai->TepDinhKem==null){
                        $detai->delete();
                    }
                    else{
                        $detai->delete();
                        unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
                    }
                }
                else{
                    if($detai->TepDinhKem==null){
                        $tg_dt->delete();
                        $detai->delete();
                    }
                    else{
                        $tg_dt->delete();
                        unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
                        $detai->delete();
                    }

                }
                return redirect('users/nghiencuu/detai/index')->with('thongbao','Xóa thành công bài báo có ID '.$id);
            }

        }
        return redirect('users/nghiencuu/detai/index')->with('thongbao1','Bạn không phải tác giả của bài báo có ID '.$id.' - không thể xóa');
    }

    public function getDeleteTG_DT_US($id,$MaGV){
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_dt->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        if($tiet==1){
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();


            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi*(1/3),3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
            }
            else{
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            }

        }
        if($tiet==2){
            $sotiet=round($ldt->TietQuyDoi*(2/3),3);
            $sotiet1=round($ldt->TietQuyDoi*(1/3),3);
            $sotiet2=round($ldt->TietQuyDoi/4,3);

            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            if($so_tg_p==1){
                $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
                $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p>1){
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id,'Đồng tác giả']);
            }

        }
        if($tiet>2){
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');

            if($so_tg_p==2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet1=round($sotiet/2,3);
                $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
                $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p>2){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $sotiet2=round($sotiet/$so_tg_p,3);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet2,$id,'Đồng tác giả']);
            }
        }
        return redirect('users/nghiencuu/detai/index')->with('thongbao','Xóa thành công tác giả đề tài có ID '.$id);
    }



    //-----------------Bài báo------------------------
    //Bài báo
    public function getList_BB_US(){
        $user = Auth::user();
        $dt1=DB::table('gv_dt')
        ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        ->select('gv_dt.id_DeTai')
        ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%BB%']])
        ->orderBy('detai.NgayCapNhat', 'DESC')
        ->get();
        return view('users.nghiencuu.baibao.index', ['detai' => $dt1,'user' => $user]);
    }
    public function getAdd_BB_US(Request $request){
        $user=Auth::user();
        $bb="bài báo";
        $thoigian=ThoiGian::all();
        $MaGV = $user->MaGV;
        $giangvien = GiangVien::where(['MaGV'=>$MaGV])->first();
        $loaidetai = LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$bb.'%')->get();
        return view('users.nghiencuu.baibao.add', ['user'=>$user,'loaidetai'=>$loaidetai, 'giangvien'=>$giangvien, 'thoigian'=>$thoigian]);
    }
    public function postAdd_BB_US(Request $request){
        $baibao = new DeTai();
        $dt=Carbon::now('Asia/Ho_Chi_Minh');
        $baibao->id_DeTai = "BB".random_int ( 1 , 99999 );
        $baibao->TenDeTai = $request->TenDeTai;
        $baibao->NgayCapNhat = $dt->toDateString();
        $baibao->NgayCapNhat = $dt->toDateString();
        $baibao->TomTat = $request->TomTat;
        $baibao->TenTapChi = $request->TenTapChi;
        $baibao->Trang = $request->Trang;
        $baibao->TinhTrang = $request->TinhTrang;
        $baibao->NgayNghiemThu = $request->NgayNghiemThu;
        $baibao->id_ThoiGian = $request->id_ThoiGian;
        $baibao->NamXB = $request->NamXB;
        $baibao->id_LoaiDeTai = $request->id_LoaiDeTai;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('users/nghiencuu/baibao')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/baibao', $fileName);
            $baibao->TepDinhKem = $fileName;
        } else {
            $baibao->TepDinhKem = "";
        }
        $baibao->save();
        $tg_bb= new GiangVien_DeTai();
        $tg_bb->id_DeTai=$baibao->id_DeTai;
        $tg_bb->id_DeTai.'<br>';
        $tg_bb->MaGV=$request->MaGV;
        $baibao->id_DeTai.'<br>';
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$baibao->id_LoaiDeTai])->first();
        $tg_bb->SoTiet= $ldt->TietQuyDoi;
        $tg_bb->VaiTro= $request->VaiTro;
        if($request->VaiTro=="Tác giả chính"){
            $tg_bb->SoTiet= $ldt->TietQuyDoi;
        }
        else{
            $sotiet=round($ldt->TietQuyDoi/2,3);
            $tg_bb->SoTiet= $sotiet;
        }
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        echo $ldt->TietQuyDoi;
        $tg_bb->save();
        return redirect('users/nghiencuu/baibao/index')->with('thongbao','Đã thêm một bài báo mới');
    }
    //Chỉnh sửa thông tin bài báo
    public function getUpdate_BB_US($id_detai){
        if (Auth::check()) {
            $user=Auth::user();
            $baibao = DeTai::where(['id_DeTai' => $id_detai])->first();
            $bb="bài báo";
            $thoigian=ThoiGian::all();
            $loaidetai=LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$bb.'%')->get();
            return view('users.nghiencuu.baibao.update', ['user'=>$user,'baibao' => $baibao, 'loaidetai'=>$loaidetai, 'thoigian'=>$thoigian]);
        }
        return redirect('login');
    }
    public function postUpdate_BB_US(Request $request, $id_detai){
        $baibao=DeTai::find($id_detai);
        $dt=Carbon::now('Asia/Ho_Chi_Minh');
        $baibao->id_DeTai = $request->id_DeTai;
        $baibao->TenDeTai = $request->TenDeTai;
        $baibao->NgayCapNhat = $dt->toDateString();
        $baibao->TomTat = $request->TomTat;
        $baibao->TenTapChi = $request->TenTapChi;
        $baibao->NamXB = $request->NamXB;
        $baibao->Trang = $request->Trang;

        $baibao->TinhTrang = $request->TinhTrang;
        $baibao->NgayNghiemThu = $request->NgayNghiemThu;
        $baibao->id_ThoiGian = $request->id_ThoiGian;
        $baibao->id_LoaiDeTai = $request->id_LoaiDeTai;

        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                # code...
                return redirect('users/nghiencuu/baibao/update/' . $id_detai)->with('loifile','Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/baibao/',$fileName);
            if ($baibao->TepDinhKem != null) {
                unlink('upload/nghiencuu/baibao/'.$baibao->TepDinhKem);
            }
            $baibao->TepDinhKem = $fileName;
        }

        $baibao->save();
        //SELECT COUNT(id_DeTai) FROM gv_dt WHERE id_DeTai='BB54321'
        $tg_bb=GiangVien_DeTai::find($id_detai);;
        //$id_dt=$request->id_DeTai;
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);

        }

        return redirect('users/nghiencuu/baibao/update/'.$id_detai)->with('thongbao','Sửa thông tin bài báo thành công');
    }
    public function getDelete_BB_US($id){
        $detai=DeTai::find($id);
        $user=Auth::user();
        $ma=$user->MaGV;
        $tg_bb=GiangVien_DeTai::where('MaGV','=',$ma)->get();
        foreach ($tg_bb as $value) {
            if ($user->MaGV=$value->MaGV) {
                GiangVien_DeTai::find($id)->delete();
                if(!isset($tg_bb->id_DeTai)){
                    if($detai->TepDinhKem==null){
                        $detai->delete();
                    }
                    else{
                        $detai->delete();
                        unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
                    }

                }
                else{
                    if($detai->TepDinhKem==null){
                        $tg_bb->delete();
                        $detai->delete();
                    }
                    else{
                        $tg_bb->delete();
                        unlink('upload/nghiencuu/detai/'.$detai->TepDinhKem);
                        $detai->delete();
                    }

                }
                return redirect('users/nghiencuu/baibao/index')->with('thongbao','Xóa thành công bài báo có ID '.$id);
            }
        }
        return redirect('users/nghiencuu/baibao/index')->with('thongbao1','Bạn không phải tác giả của bài báo có ID '.$id.' - không thể xóa');
    }
    //Tác giả bài báo
    public function getAddTG_BB_US($id){
        if (Auth::check()) {
            $user=Auth::user();
            $giangvien = GiangVien::all();
            $detai = DeTai::where(['id_DeTai'=>$id])->first();
            return view('users.nghiencuu.baibao.addTG', ['user'=>$user, 'detai'=>$detai,'giangvien'=>$giangvien]);
        }
        return redirect('login');
    }
    public function postAddTG_BB_US(Request $request, $id){
        if (Auth::check()) {
            $tg_bb = new GiangVien_DeTai();
            $tg_bb->MaGV=$request->MaGV;
            $tg_bb->id_DeTai=$id;
            $tg_bb->VaiTro=$request->VaiTro;
            $tg_bb->NgayThamGia=$request->NgayThamGia;
            $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
            $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
            if($dem==1&&$tg_bb->VaiTro=="Tác giả chính"){
                return redirect('users/nghiencuu/baibao/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
            }
            $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
            if($ss!=null){
            return redirect('users/nghiencuu/baibao/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
            }
            $tg_bb->save();
            //$id_dt="BB".$request->id_DeTai;
            $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
            $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
            $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
            if($tiet==1){
                if($tg_bb->VaiTro=="Tác giả chính"){
                    $sotiet=$ldt->TietQuyDoi;
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                }
                else{
                    $sotiet=$ldt->TietQuyDoi/2;
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                }
            }
            else{
                $sotiet=$ldt->TietQuyDoi/$tiet;
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet,$id, $request->MaGV]);
            }
            return redirect('users/nghiencuu/baibao/index')->with('thongbao','Đã thêm tác giả '.$request->MaGV.' vào bài báo có '.$id.' thành công');
        }
        return redirect('login');
    }
    public function getUpdateTG_BB_US($id,$MaGV){
        $user=Auth::user();
        $bb=DeTai::where(['id_DeTai'=>$id])->first();
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg=GiangVien::where(['MaGV'=>$MaGV])->first();
        return view('users.nghiencuu.baibao.updateTG',['baibao'=>$bb,'tacgia'=>$tg, 'user'=>$user, 'tg_bb'=>$tg_bb]);
    }
    public function postUpdateTG_BB_US($id,$MaGV, Request $request){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        //$tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_bb->save();
        return redirect('users/nghiencuu/baibao/updateTG/'.$id.'/'.$MaGV)->with('thongbao','Sửa thông tin tác giả thành công');
    }
    public function getDeleteTG_BB_US($id,$MaGV){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_bb->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();

        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);

        }
        return redirect('users/nghiencuu/baibao/index')->with('thongbao','Xóa thành công tác giả bài báo có ID '.$id);
    }




    //--------TLGD---------------------------------
    public function getList_TLGD_US(){
        $user = Auth::user();
        $dt1=DB::table('gv_dt')
        ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        ->select('gv_dt.id_DeTai')
        ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%TL%']])
        ->orderBy('detai.NgayCapNhat', 'DESC')
        ->get();
        return view('users.nghiencuu.tlgd.index', ['tailieu' => $dt1,'user' => $user]);
    }

    public function getAdd_TLGD_US(Request $request){
        $user=Auth::user();
        $thoigian=ThoiGian::all();
        $MaGV = $user->MaGV;
        $giangvien = GiangVien::where(['MaGV'=>$MaGV])->first();
        $loaidetai = LoaiDeTai::all();
        return view('users.nghiencuu.tlgd.add', ['user'=>$user,'loaidetai'=>$loaidetai, 'giangvien'=>$giangvien, 'thoigian'=>$thoigian]);
    }

    public function postAdd_TLGD_US(Request $request){
        $tailieu = new DeTai();
        $tl=Carbon::now('Asia/Ho_Chi_Minh');
        $tailieu->id_DeTai = "TL" .random_int ( 1 , 99999 );
        $tailieu->TenDeTai = $request->TenDeTai;
        $tailieu->NgayTao = $tl->toDateString();
        $tailieu->NgayCapNhat = $tl->toDateString();
        $tailieu->TomTat = $request->TomTat;
        $tailieu->TinhTrang = $request->TinhTrang;
        $tailieu->NgayNghiemThu = $request->NgayNghiemThu;
        $tailieu->id_ThoiGian = $request->id_ThoiGian;
        $tailieu->NamXB = $request->NamXB;
        $tailieu->LoaiBienTap = $request->LoaiBienTap;
        $tailieu->DinhDang = $request->DinhDang;
        $tailieu->id_LoaiDeTai = $request->id_LoaiDeTai;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('users/nghiencuu/tlgd')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $tl->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/tlgd', $fileName);
            $tailieu->TepDinhKem = $fileName;
        } else {
            $tailieu->TepDinhKem = "";
        }
        $tailieu->save();
        $tg_hd = new GiangVien_DeTai();
        $tg_hd->id_DeTai=$tailieu->id_DeTai;
        //$tg_hd->id_DeTai.'<br>';
        $tg_hd->MaGV=$request->MaGV;
        $tailieu->id_DeTai.'<br>';
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$tailieu->id_LoaiDeTai])->first();

        $tg_hd->VaiTro= $request->VaiTro;
        if($request->LoaiBienTap=="Ban đầu"){
            $gio_QD=$ldt->TietQuyDoi;
        }
        if($request->LoaiBienTap=="Chỉnh lý - Lần 1"){
            $gio_QD=round($ldt->TietQuyDoi*0.5,3);
        }
        if($request->LoaiBienTap=="Chỉnh lý - Lần 2"){
            $gio_QD=round($ldt->TietQuyDoi*0.25,3);
        }
        if($request->LoaiBienTap=="Chỉnh lý - Lần 3"){
            $gio_QD=round($ldt->TietQuyDoi*0.125,3);
        }
        if($request->VaiTro=="Tác giả chính"){
            $tg_hd->SoTiet= $gio_QD;
        }
        else{
            $sotiet=round($gio_QD*(1/3),3);
            $tg_hd->SoTiet= $sotiet;
        }
        $tg_hd->NgayThamGia=$request->NgayThamGia;
        $tg_hd->NgayKetThucTG=$request->NgayKetThucTG;
        echo $ldt->TietQuyDoi;
        $tg_hd->save();
        return redirect('users/nghiencuu/tlgd/index')->with('thongbao','Đã thêm một đề tài nghiên cứu mới');
    }

    public function getAddTG_TLGD_US($id){
        if (Auth::check()) {
            $user=Auth::user();
            $giangvien = GiangVien::all();
            $detai = DeTai::where(['id_DeTai'=>$id])->first();
            return view('users.nghiencuu.tlgd.addTG', ['user'=>$user, 'detai'=>$detai,'giangvien'=>$giangvien]);
        }
        return redirect('login');
    }
    public function postAddTG_TLGD_US(Request $request, $id){
        if (Auth::check()) {
            $tg_dt = new GiangVien_DeTai();
            $tg_dt->MaGV=$request->MaGV;
            $tg_dt->id_DeTai=$id;
            $tg_dt->VaiTro=$request->VaiTro;
            $tg_dt->NgayThamGia=$request->NgayThamGia;
            $tg_dt->NgayKetThucTG=$request->NgayKetThucTG;
            $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
            if($dem==1&&$tg_dt->VaiTro=="Tác giả chính"){
                return redirect('users/nghiencuu/tlgd/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
            }
            $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
            if($ss!=null){
            return redirect('users/nghiencuu/tlgd/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
            }
            $tg_dt->save();
            $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
            $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
            $id_detai=DeTai::where(['id_DeTai'=>$id])->first();
            $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_detai->id_LoaiDeTai])->first();
            if($id_detai->LoaiBienTap=="Ban đầu"){
                $gio_QD=$ldt->TietQuyDoi;
            }
            if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 1"){
                $gio_QD=$ldt->TietQuyDoi*0.5;
            }
            if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 2"){
                $gio_QD=$ldt->TietQuyDoi*0.25;
            }
            if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 3"){
                $gio_QD=$ldt->TietQuyDoi*0.125;
            }
            if($tiet==1){
                $sotiet=$gio_QD;
                $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
            }
            if($tiet>=2){
                $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
                if($tg_bb->VaiTro=="Tác giả chính"){
                    $sotiet=round($gio_QD*(2/3),3);
                    $sotiet1=round(($gio_QD*1)/(3*$so_tg_p),3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                    $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
                }
                else{

                    $sotiet=round($gio_QD*(2/3), 3);
                    $sotiet1=round(($gio_QD*1)/(3*$so_tg_p), 3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro LIKE ?', [$sotiet,$id,'Tác giả chính']);
                    for ($i = 1; $i <= $so_tg_p; $i++) {
                        //$updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ? AND VaiTro<> ?', [$sotiet1, $id, $request->MaGV,'Tác giả chính']);
                        $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet1,$id,'Đồng tác giả']);
                    }

                }

            }
            if ($tiet>=4) {
                $so_tg_p =GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','<>','Tác giả chính']])->count();
                if ($tg_bb->VaiTro=="Tác giả chính") {
                    $sotiet=round($gio_QD*(1/3), 3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV= ?', [$sotiet,$id, $request->MaGV]);
                    $sotiet1=round(($gio_QD*2)/(3*$so_tg_p), 3);
                    $updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ?', [$sotiet1, $id, $request->MaGV]);
                } else {
                    $sotiet=round($gio_QD*(1/3), 3);
                    $sotiet1=round(($gio_QD*2)/(3*$so_tg_p), 3);
                    $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro LIKE ?', [$sotiet,$id,'Tác giả chính']);
                    for ($i = 1; $i <= $so_tg_p; $i++) {
                        //$updated1 = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND MaGV<> ? AND VaiTro<> ?', [$sotiet1, $id, $request->MaGV,'Tác giả chính']);
                        $updated = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro = ?', [$sotiet1,$id,'Đồng tác giả']);
                    }
                }
            }
                return redirect('users/nghiencuu/tlgd/index')->with('thongbao','Đã thêm tác giả '.$request->MaGV.' vào đề tài có '.$id.' thành công');
            }
        return redirect('login');
    }

    public function getUpdate_TLGD_US($id_detai){
        if (Auth::check()) {
            $user=Auth::user();
            $detai = DeTai::where(['id_DeTai' => $id_detai])->first();
            $dt="đề tài";
            $thoigian=ThoiGian::all();
            $loaidetai=LoaiDeTai::where('TenLoaiDeTai','LIKE','%'.$dt.'%')->get();
            return view('users.nghiencuu.tlgd.update', ['user'=>$user,'detai' => $detai, 'loaidetai'=>$loaidetai, 'thoigian'=>$thoigian]);
        }
        return redirect('login');
    }
    public function postUpdate_TLGD_US(Request $request, $id_detai){
        $tailieu = DeTai::find($id_detai);
        $tl=Carbon::now('Asia/Ho_Chi_Minh');
        $tailieu->NgayCapNhat = $tl->toDateString();
        $tailieu->TenDeTai = $request->TenDeTai;
        $tailieu->TomTat = $request->TomTat;
        $tailieu->TinhTrang = $request->TinhTrang;
        $tailieu->NgayNghiemThu = $request->NgayNghiemThu;
        $tailieu->id_ThoiGian = $request->id_ThoiGian;
        $tailieu->NamXB = $request->NamXB;
        $tailieu->LoaiBienTap = $request->LoaiBienTap;
        $tailieu->DinhDang = $request->DinhDang;
        $tailieu->id_LoaiDeTai = $request->id_LoaiDeTai;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                # code...
                return redirect('users/nghiencuu/tlgd/update/' . $id_detai)->with('loifile','Bạn chỉ được chọn file có đuôi pdf');
            }
            $fileName =  $tl->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/tlgd/',$fileName);
            if ($tailieu->TepDinhKem != null) {
                unlink('upload/nghiencuu/tlgd/'.$tailieu->TepDinhKem);
            }
            $tailieu->TepDinhKem = $fileName;
        }
        $tailieu->save();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($id_ldt->LoaiBienTap=="Ban đầu"){
            $gio_QD=$ldt->TietQuyDoi;
        }
        if($id_ldt->LoaiBienTap=="Chỉnh lý - Lần 1"){
            $gio_QD=$ldt->TietQuyDoi*0.5;
        }
        if($id_ldt->LoaiBienTap=="Chỉnh lý - Lần 2"){
            $gio_QD=$ldt->TietQuyDoi*0.25;
        }
        if($id_ldt->LoaiBienTap=="Chỉnh lý - Lần 3"){
            $gio_QD=$ldt->TietQuyDoi*0.125;
        }
        if($tiet==1){
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round($gio_QD,3);
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round(($gio_QD*1)/(3*$so_tg_p),3);
            if($so_tg_c==0){
                if($so_tg_p==1){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id_detai,$tg_p->VaiTro]);
                }
                if($so_tg_p==2){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
                }
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
            }
        }
        if($tiet>=4){
            $sotiet=round($gio_QD*(1/3),3);
            $sotiet1=round($gio_QD*(2/3),3);
            $sotiet2=round(($gio_QD*2)/(3*$so_tg_p),3);
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id_detai,$tg_p->VaiTro]);
            }
        }
        return redirect('users/nghiencuu/tlgd/update/'.$id_detai)->with('thongbao','Sửa thông tin đề tài thành công');
    }

    public function getUpdateTG_TLGD_US($id,$MaGV){
        $user=Auth::user();
        $bb=DeTai::where(['id_DeTai'=>$id])->first();
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg=GiangVien::where(['MaGV'=>$MaGV])->first();
        return view('users.nghiencuu.tlgd.updateTG',['detai'=>$bb,'tacgia'=>$tg, 'user'=>$user, 'tg_dt'=>$tg_dt]);
    }
    public function postUpdateTG_TLGD_US($id,$MaGV, Request $request){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        //$tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
        $tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_bb->save();
        return redirect('users/nghiencuu/tlgd/updateTG/'.$id.'/'.$MaGV)->with('thongbao','Sửa thông tin tác giả thành công');
    }

    public function getDelete_TLGD_US($id){
        $detai=DeTai::find($id);
        $user=Auth::user();
        $ma=$user->MaGV;
        $tg_dt=GiangVien_DeTai::where('MaGV','=',$ma)->get();
        foreach ($tg_dt as $value) {
            if ($user->MaGV=$value->MaGV) {
                GiangVien_DeTai::find($id)->delete();
                if(!isset($tg_dt->id_DeTai)){
                    if($detai->TepDinhKem==null){
                        $detai->delete();
                    }
                    else{
                        $detai->delete();
                        unlink('upload/nghiencuu/tlgd/'.$detai->TepDinhKem);
                    }
                }
                else{
                    if($detai->TepDinhKem==null){
                        $tg_dt->delete();
                        $detai->delete();
                    }
                    else{
                        $tg_dt->delete();
                        unlink('upload/nghiencuu/tlgd/'.$detai->TepDinhKem);
                        $detai->delete();
                    }

                }
                return redirect('users/nghiencuu/tlgd/index')->with('thongbao','Xóa thành công bài báo có ID '.$id);
            }

        }
        return redirect('users/nghiencuu/tlgd/index')->with('thongbao1','Bạn không phải tác giả của bài báo có ID '.$id.' - không thể xóa');
    }

    public function getDeleteTG_TLGD_US($id,$MaGV){
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_dt->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_detai=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_detai->id_LoaiDeTai])->first();
        if($id_detai->LoaiBienTap=="Ban đầu"){
            $gio_QD=$ldt->TietQuyDoi;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 1"){
            $gio_QD=$ldt->TietQuyDoi*0.5;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 2"){
            $gio_QD=$ldt->TietQuyDoi*0.25;
        }
        if($id_detai->LoaiBienTap=="Chỉnh lý - Lần 3"){
            $gio_QD=$ldt->TietQuyDoi*0.125;
        }
        if($tiet==1){
            // $tg_bb->SoTiet= round($gio_QD,3);
            // $tg_bb->save();
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round($gio_QD,3);
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);

            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_c->VaiTro]);
            }
        }
        if($tiet==2){
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $sotiet=round($gio_QD*(2/3),3);
            $sotiet1=round($gio_QD*(1/3),3);
            $sotiet2=round(($gio_QD*1)/(3*$so_tg_p),3);
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($so_tg_c==0){
                if($so_tg_p==1){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
                }
                if($so_tg_p==2){
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_p->VaiTro]);
                }
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet1,$id,$tg_p->VaiTro]);
            }
        }
        if($tiet>=3){
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $sotiet=round($gio_QD*(1/3),3);
            $sotiet1=round($gio_QD*(2/3),3);
            $sotiet2=round(($gio_QD*2)/(3*$so_tg_p),3);
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($so_tg_c==0){
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_p->VaiTro]);
            }
            else{
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet2,$id,$tg_p->VaiTro]);
            }
        }
        return redirect('users/nghiencuu/tlgd/index')->with('thongbao','Xóa thành công tác giả đề tài có ID '.$id);
    }



    //--------Khac---------------------------------
    public function getList_Khac_US(){
        $user = Auth::user();
        $dt1=GiangVien_DeTai::where([['MaGV', '=', $user->MaGV],['id_DeTai','LIKE','%HD%']])->get();
        return view('users.nghiencuu.khac.index', ['detai' => $dt1,'user' => $user]);
    }

    public function getAdd_Khac_US(Request $request){
        $user=Auth::user();
        $thoigian=ThoiGian::all();
        $MaGV = $user->MaGV;
        $giangvien = GiangVien::where(['MaGV'=>$MaGV])->first();
        $loaidetai = LoaiDeTai::all();

        return view('users.nghiencuu.khac.add', ['user'=>$user,'loaidetai'=>$loaidetai,'giangvien'=>$giangvien, 'thoigian'=>$thoigian, ]);
    }

    public function postAdd_Khac_US(Request $request){
        $hoatdong = new DeTai();
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $hoatdong->id_DeTai = "HD" . random_int ( 1 , 99999 );
        $hoatdong->TenDeTai = $request->TenDeTai;
        $hoatdong->NgayTao = $dt->toDateString();
        $hoatdong->NgayCapNhat = $dt->toDateString();
        $hoatdong->TomTat = $request->TomTat;
        $hoatdong->CoSoTC = $request->CoSoTC;
        $hoatdong->TinhTrang = $request->TinhTrang;
        $hoatdong->NgayNghiemThu = $request->NgayNghiemThu;
        $hoatdong->DinhDang = $request->DinhDang;
        $hoatdong->id_LoaiDeTai = $request->id_LoaiDeTai;
        $hoatdong->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('users/nghiencuu/khac/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            echo $fileName;
            $file->move('upload/nghiencuu/khac', $fileName);
            $hoatdong->TepDinhKem = $fileName;
        } else {
            $hoatdong->TepDinhKem = "";
        }
        $hoatdong->save();
        $tg_hd = new GiangVien_DeTai();
        $tg_hd->id_DeTai=$hoatdong->id_DeTai;
        $tg_hd->id_DeTai.'<br>';
        $tg_hd->MaGV=$request->MaGV;
        $hoatdong->id_DeTai.'<br>';
        //$id_ldt=DeTai::where(['id_DeTai'=>$hoatdong->id_DeTai])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$hoatdong->id_LoaiDeTai])->first();
        $tg_hd->SoTiet= $ldt->TietQuyDoi;
        $tg_hd->VaiTro= $request->VaiTro;
        if($request->VaiTro=="Tác giả chính"){
            $tg_hd->SoTiet= $ldt->TietQuyDoi;
        }
        else{
            $sotiet=round($ldt->TietQuyDoi/2,3);
            $tg_hd->SoTiet= $sotiet;
        }
        $tg_hd->NgayThamGia=$request->NgayThamGia;
        $tg_hd->NgayKetThucTG=$request->NgayKetThucTG;
        echo $ldt->TietQuyDoi;
        $tg_hd->save();


        return redirect('users/nghiencuu/khac/index')->with('thongbao','Đã thêm một đề tài nghiên cứu mới');
    }


    public function getUpdate_Khac_US($id_detai, $MaGV){
        if (Auth::check()) {
            $user=Auth::user();
            $detai = DeTai::where(['id_DeTai' => $id_detai])->first();
            $thoigian=ThoiGian::all();
            $loaidetai=LoaiDeTai::all();
            // $tg=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['MaGV','=',$MaGV]])->first();
            // $gv=GiangVien::where(['MaGV' => $MaGV])->first();
            return view('users.nghiencuu.khac.update', ['user'=>$user,'detai' => $detai, 'loaidetai'=>$loaidetai, 'thoigian'=>$thoigian]);
        }
        return redirect('login');

    }
    public function postUpdate_Khac_US(Request $request, $id_detai, $MaGV){
        $hoatdong = DeTai::find($id_detai);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
        $hoatdong->TenDeTai = $request->TenDeTai;
        $hoatdong->NgayCapNhat = $dt->toDateString();
        $hoatdong->TomTat = $request->TomTat;
        $hoatdong->CoSoTC = $request->CoSoTC;
        $hoatdong->NamXB = $request->NamXB;
        $hoatdong->DinhDang = $request->DinhDang;
        $hoatdong->TinhTrang = $request->TinhTrang;
        $hoatdong->NgayNghiemThu = $request->NgayNghiemThu;
        $hoatdong->id_LoaiDeTai = $request->id_LoaiDeTai;
        $hoatdong->id_ThoiGian = $request->id_ThoiGian;
        if ($request->hasFile('TepDinhKem')) {
            $file = $request->file('TepDinhKem');
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'pdf') {
                return redirect('users/nghiencuu/khac/add')->with('thongbao1', 'Bạn chỉ được chọn file có đuôi .pdf');
            }
            $fileName =  $dt->toDateString().'_'.$file->getClientOriginalName();
            $file->move('upload/nghiencuu/khac', $fileName);
            if ($hoatdong->TepDinhKem != null) {
                unlink('upload/nghiencuu/khac/'.$hoatdong->TepDinhKem);
            }
            $hoatdong->TepDinhKem = $fileName;
        }
        $hoatdong->save();
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id_detai])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id_detai])->first();
        echo $id_ldt->id_LoaiDeTai;
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id_detai],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id_detai,$tg_p->VaiTro]);

        }
        return redirect('users/nghiencuu/khac/update/'.$id_detai.'/'.$MaGV)->with('thongbao','Sửa thông tin đề tài thành công');
    }

    public function getDelete_Khac_US($id){
        $detai=DeTai::find($id);
        $user=Auth::user();
        $ma=$user->MaGV;
        $tg_dt=GiangVien_DeTai::where('MaGV','=',$ma)->get();
        foreach ($tg_dt as $value) {
            if ($user->MaGV=$value->MaGV) {
                GiangVien_DeTai::find($id)->delete();
                if(!isset($tg_dt->id_DeTai)){
                    if($detai->TepDinhKem==null){
                        $detai->delete();
                    }
                    else{
                        $detai->delete();
                        unlink('upload/nghiencuu/khac/'.$detai->TepDinhKem);
                    }
                }
                else{
                    if($detai->TepDinhKem==null){
                        $tg_dt->delete();
                        $detai->delete();
                    }
                    else{
                        $tg_dt->delete();
                        unlink('upload/nghiencuu/khac/'.$detai->TepDinhKem);
                        $detai->delete();
                    }

                }
                return redirect('users/nghiencuu/khac/index')->with('thongbao','Xóa thành công bài báo có ID '.$id);
            }

        }
        return redirect('users/nghiencuu/khac/index')->with('thongbao1','Bạn không phải tác giả của bài báo có ID '.$id.' - không thể xóa');
    }


    //HD khac tac gia user
    public function getAddTG_khac_US($id){
        if (Auth::check()) {
            $user=Auth::user();
            $giangvien = GiangVien::all();
            $detai = DeTai::where(['id_DeTai'=>$id])->first();
            return view('users.nghiencuu.khac.addTG', ['user'=>$user, 'detai'=>$detai,'giangvien'=>$giangvien]);
        }
        return redirect('login');
    }
    public function postAddTG_khac_US(Request $request, $id){
        if (Auth::check()) {
            $tg_dt = new GiangVien_DeTai();
            $tg_dt->MaGV=$request->MaGV;
            $tg_dt->id_DeTai=$id;
            $tg_dt->VaiTro=$request->VaiTro;
            $tg_dt->NgayThamGia=$request->NgayThamGia;
            $tg_dt->NgayKetThucTG=$request->NgayKetThucTG;
            $dem=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','=',"Tác giả chính"]])->count('VaiTro');
            if($dem==1&&$tg_dt->VaiTro=="Tác giả chính"){
                return redirect('users/nghiencuu/khac/index')->with('thongbao1','Bài báo đã có tác giả chính. Không thể thêm');
            }
            $ss=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$request->MaGV]])->first();
            if($ss!=null){
                return redirect('users/nghiencuu/khac/index')->with('thongbao1','Đã tồn tại tác giả. Không thể thêm');
            }
            $tg_dt->save();
            $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
            $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
            echo $id_ldt->id_LoaiDeTai;
            $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();
            $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
            $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
            $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
            $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
            if($tiet==1){
                if($so_tg_c==0){
                    $sotiet=round($ldt->TietQuyDoi/2,3);
                    $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
                }
                if($so_tg_p==0){
                    $sotiet=round($ldt->TietQuyDoi,3);
                    $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                }
            }
            if($tiet>=2){
                $sotiet=round($ldt->TietQuyDoi/$tiet,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);

            }
            return redirect('users/nghiencuu/khac/index')->with('thongbao','Đã thêm tác giả '.$request->MaGV.' vào đề tài có '.$id.' thành công');
        }
        return redirect('login');
    }

    public function getUpdateTG_khac_US($id,$MaGV){
        $user=Auth::user();
        $bb=DeTai::where(['id_DeTai'=>$id])->first();
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        $tg=GiangVien::where(['MaGV'=>$MaGV])->first();
        return view('users.nghiencuu.khac.updateTG',['detai'=>$bb,'tacgia'=>$tg, 'user'=>$user, 'tg_dt'=>$tg_dt]);
    }
    public function postUpdateTG_khac_US($id,$MaGV, Request $request){
        $tg_bb=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]])->first();
        //$tg_bb->VaiTro=$request->VaiTro;
        $tg_bb->NgayThamGia=$request->NgayThamGia;
$tg_bb->NgayKetThucTG=$request->NgayKetThucTG;
        $tg_bb->save();
        return redirect('users/nghiencuu/khac/updateTG/'.$id.'/'.$MaGV)->with('thongbao','Sửa thông tin tác giả thành công');
    }

    public function getDeleteTG_khac_US($id,$MaGV){
        $tg_dt=GiangVien_DeTai::where([['id_DeTai','=',$id],['MaGV','=',$MaGV]]);
        $tg_dt->delete();
        $tg_bb=GiangVien_DeTai::find($id);
        $tiet=GiangVien_DeTai::where(['id_DeTai'=>$id])->count();
        $id_ldt=DeTai::where(['id_DeTai'=>$id])->first();
        $ldt=LoaiDeTai::where(['id_LoaiDeTai'=>$id_ldt->id_LoaiDeTai])->first();

        $so_tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->count('VaiTro');
        $so_tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->count('VaiTro');
        $tg_c=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Tác giả chính']])->first();
        $tg_p=GiangVien_DeTai::where([['id_DeTai','=',$id],['VaiTro','LIKE','Đồng tác giả']])->first();
        if($tiet==1){
            if($so_tg_c==0){
                $sotiet=round($ldt->TietQuyDoi/2,3);
                $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);
            }
            if($so_tg_p==0){
                $sotiet=round($ldt->TietQuyDoi,3);
                $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            }
        }
        if($tiet>=2){
            $sotiet=round($ldt->TietQuyDoi/$tiet,3);
            $updated_chinh = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_c->VaiTro]);
            $updated_phu = DB::update('update gv_dt set SoTiet = ? where id_DeTai = ? AND VaiTro= ?', [$sotiet,$id,$tg_p->VaiTro]);

        }
        return redirect('users/nghiencuu/khac/index')->with('thongbao','Xóa thành công tác giả đề tài có ID '.$id);
    }
}
