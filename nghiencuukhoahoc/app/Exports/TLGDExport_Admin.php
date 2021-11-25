<?php

namespace App\Exports;

use App\Models\DeTai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable as ConcernsExportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners as ConcernsRegistersEventListeners;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TLGDExport_Admin implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use ConcernsExportable, ConcernsRegistersEventListeners;
    public function view(): View
    {
        $user = Auth::user();
        $detai = DeTai::where('id_DeTai','LIKE','%TL%')->get();
        return view('admin.nghiencuu.tlgd.excel', ['detai' => $detai,'user' => $user]);
    }
}
