<?php

namespace App\Exports;

use App\Models\DeTai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable as ConcernsExportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners as ConcernsRegistersEventListeners;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\GiangVien_DeTai;
use Illuminate\Support\Facades\DB;

class TLGDExport_User implements FromView
{
    use ConcernsExportable, ConcernsRegistersEventListeners;
    public function view(): View
    {
        $user = Auth::user();
        $detai=DB::table('gv_dt')
        ->join('detai','gv_dt.id_DeTai','=','detai.id_DeTai')
        ->select('gv_dt.id_DeTai')
        ->where([['MaGV', '=', $user->MaGV],['gv_dt.id_DeTai','LIKE','%TL%']])
        ->orderBy('detai.NgayCapNhat', 'DESC')
        ->get();
        return view('users.nghiencuu.tlgd.excel', ['detai' => $detai,'user' => $user]);
    }
}
