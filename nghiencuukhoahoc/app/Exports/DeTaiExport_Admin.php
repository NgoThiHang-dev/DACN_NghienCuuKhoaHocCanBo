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

class DeTaiExport_Admin implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use ConcernsExportable, ConcernsRegistersEventListeners;
    public function view(): View
    {
        $user = Auth::user();
        $detai = DeTai::where('id_DeTai','LIKE','%DT%')->get();
        return view('admin.nghiencuu.detai.excel', ['detai' => $detai,'user' => $user]);
    }
}
