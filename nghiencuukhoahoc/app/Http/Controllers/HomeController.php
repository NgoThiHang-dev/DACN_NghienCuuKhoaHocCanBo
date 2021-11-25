<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GiangVien;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    function fetch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('giangvien')
                ->where('TenGV', 'LIKE', "%{$query}%")
                ->get();
            echo $data;
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
       <li><a href="#">' . $row->TenGV . '</a></li>
       ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
