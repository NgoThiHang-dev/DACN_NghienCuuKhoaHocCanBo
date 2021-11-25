<?php

namespace App\Http\Controllers;

use App\Imports\LoaiDeTaiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import_LoaiDeTai(){
        Excel::import(new LoaiDeTaiImport, request()->file('file'));
        return back();
    }
}
