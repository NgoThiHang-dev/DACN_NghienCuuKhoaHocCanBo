<?php

namespace App\Imports;

use App\LoaiDeTai;
use App\Models\LoaiDeTai as ModelsLoaiDeTai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LoaiDeTaiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ModelsLoaiDeTai([
            'TenLoaiDeTai'=>$row['TenLoaiDeTai'],
            'DonViTinh'=>$row['DonViTinh'],
            'TietQuyDoi'=>$row['TietQuyDoi'],
        ]);
    }
}
