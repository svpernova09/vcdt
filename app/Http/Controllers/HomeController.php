<?php

namespace App\Http\Controllers;

use App\Box;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use VCDT\Services\ProcessBoxes;

class HomeController extends Controller
{
    public function home():array
    {
        $minutes = 15;
        $now = Carbon::now();
        $yesterday = Carbon::now('UTC')->subDay();
        $results = [];
        foreach (Box::all() as $box) {
            $max = Cache::remember('max_'.$box->id, $minutes, function () use ($now, $yesterday)
            {
                return DB::table('downloads')->whereBetween('created_at', [$yesterday, $now])->max('downloads');
            });

            $min = Cache::remember('min_'.$$box->id, $minutes, function () use ($now, $yesterday)
            {
                return DB::table('downloads')->whereBetween('created_at', [$yesterday, $now])->min('downloads');
            });

            $first = Cache::remember('first_'.$box->id, $minutes, function ()
            {
                return DB::table('downloads')->where('id', '=', 1)->first();
            });

            $last = Cache::remember('last_'.$box->id, $minutes, function ()
            {
                return DB::table('downloads')->where('id', \DB::table('downloads')->max('id'))->first();
            });
            $downloads = $last->downloads - $first->downloads;
            $results[] = [
                'status' => 'ok',
                'box' => $box->username.'/'.$box->name,
                'last_24_hours' => $max - $min,
                'since_'.str_replace(' ', '_', $first->created_at) => $downloads,
            ];
        }

        return $results;
    }
}
