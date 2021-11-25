<?php

namespace App\Exports;

use App\Models\DeTai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Exportable, RegistersEventListeners;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable as ConcernsExportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners as ConcernsRegistersEventListeners;

class BaiBaoExport_Admin implements FromView
{
    // use ConcernsExportable, ConcernsRegistersEventListeners;
    // public function view(): View
    // {
    //     $detai = DeTai::where('id_DeTai','LIKE','%BB%')->get();
    //     $user = Auth::user();
    //     return view('admin.nghiencuu.baibao.index',['detai'=>$detai, 'user'=>$user]);
    // }
    /**
    * @return \Illuminate\Support\Collection
    */
    use ConcernsExportable, ConcernsRegistersEventListeners;
    public function view(): View
    {
        $user = Auth::user();
        $detai = DeTai::where('id_DeTai','LIKE','%BB%')->get();
        return view('admin.nghiencuu.baibao.excel', ['detai' => $detai,'user' => $user]);
    }
}
