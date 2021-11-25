<?php

namespace App\Exports;

use App\LoaiDeTai;
use App\Models\LoaiDeTai as ModelsLoaiDeTai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings as ConcernsWithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping as ConcernsWithMapping;

class LoaiDeTaiExport implements FromCollection,ConcernsWithHeadings,ConcernsWithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ModelsLoaiDeTai::all();
    }
    public function headings(): array {
        return [
            'ID_LoaiDeTai',
            'TenLoaiDeTai',
            'DonViTinh',    
            "TietQuyDoi"
            
        ];
    }
    public function map($loaidetai): array {
        return [
            $loaidetai->id_LoaiDeTai,
            $loaidetai->TenLoaiDeTai,
            $loaidetai->DonViTinh,
            $loaidetai->TietQuyDoi
        ];
    }
}
