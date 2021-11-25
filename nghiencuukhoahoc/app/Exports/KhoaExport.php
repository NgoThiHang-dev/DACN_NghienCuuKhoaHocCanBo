<?php

namespace App\Exports;

use App\Khoa;
use App\Models\Khoa as ModelsKhoa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KhoaExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ModelsKhoa::all();
    }
    public function headings(): array {
        return [
            'Mã Khoa',
            'Tên Khoa'
            
        ];
    }
    public function map($khoa): array {
        return [
            $khoa->MaKhoa,
            $khoa->TenKhoa
        ];
    }
}
