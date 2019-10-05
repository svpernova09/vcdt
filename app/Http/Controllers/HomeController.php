<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use VCDT\Services\ProcessBoxes;

class HomeController extends Controller
{
    public function home():array
    {
        $now = Carbon::now();
        $yesterday = Carbon::now('UTC')->subDay();
        $max = DB::table('downloads')
                 ->whereBetween('created_at', [$yesterday, $now])
                 ->max('downloads');
        $min = DB::table('downloads')
                 ->whereBetween('created_at', [$yesterday, $now])
                 ->min('downloads');

        $result = [
            'status' => 'ok',
            'msg' => 'nothing to see here',
            'last_24_hours' => $max - $min,
        ];

        return $result;
    }
}
