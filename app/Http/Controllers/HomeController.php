<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use VCDT\Services\ProcessBoxes;

class HomeController extends Controller
{
    public function home():array
    {
        $minutes = 5;
        $now = Carbon::now();
        $yesterday = Carbon::now('UTC')->subDay();

        $max = Cache::remember('max', $minutes, function () use ($now, $yesterday) {
            return DB::table('downloads')
                     ->whereBetween('created_at', [$yesterday, $now])
                     ->max('downloads');
        });

        $min = Cache::remember('min', $minutes, function () use ($now, $yesterday) {
            return DB::table('downloads')
                     ->whereBetween('created_at', [$yesterday, $now])
                     ->min('downloads');
        });

        $first = Cache::remember('first', $minutes, function () {
            return DB::table('downloads')->where('id', '=', 1)->first();
        });

        $last = Cache::remember('last', $minutes, function () {
            return DB::table('downloads')->where('id', \DB::table('downloads')->max('id'))->first();
        });

        $downloads = $last->downloads - $first->downloads;
//        dd($downloads);
        return [
            'status' => 'ok',
            'msg' => 'nothing to see here',
            'last_24_hours' => $max - $min,
            'since_'.str_replace(' ', '_', $first->created_at) => $downloads,
        ];
    }
}
