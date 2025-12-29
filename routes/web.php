<?php

use App\Models\Box;
use App\Models\Download;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $boxConfigs = [
        ['id' => 1, 'years' => ['2025', '2024', '2023', '2022', '2021', '2020', '2019']],
        ['id' => 5, 'years' => ['2025', '2024']],
    ];

    $boxes = [];

    foreach ($boxConfigs as $config) {
        $box = Box::find($config['id']);

        if (! $box) {
            continue;
        }

        $stats = [];

        foreach ($config['years'] as $year) {
            $first = Download::where('box_id', $config['id'])
                ->whereYear('created_at', $year)
                ->orderBy('created_at')
                ->first();

            $last = Download::where('box_id', $config['id'])
                ->whereYear('created_at', $year)
                ->orderByDesc('created_at')
                ->first();

            if ($first && $last) {
                $stats[] = [
                    'year' => $year,
                    'downloads' => $last->downloads - $first->downloads,
                ];
            }
        }

        $boxes[] = [
            'name' => $box->username.'/'.$box->name,
            'username' => $box->username,
            'boxname' => $box->name,
            'stats' => $stats,
        ];
    }

    return view('stats', ['boxes' => $boxes]);
});
