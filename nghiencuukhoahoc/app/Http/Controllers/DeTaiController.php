<?php

namespace App\Http\Controllers;

use App\Models\DeTai;
use Illuminate\Http\Request;

class DeTaiController extends Controller
{
    //
    public function getList()
    {
        $detai=DeTai::all();
        return view('users/detai/index', ['detai' => $detai]);
    }
}
