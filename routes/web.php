<?php

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
    $years = ['2025', '2024', '2023', '2022', '2021', '2020', '2019'];

    foreach ($years as $year) {
        $first = Download::where('box_id', 1)
            ->whereYear('created_at', $year)
            ->orderBy('created_at')
            ->first();

        $last = Download::where('box_id', 1)
            ->whereYear('created_at', $year)
            ->orderByDesc('created_at')
            ->first();

        if ($first && $last) {
            echo "For year $year, the total downloads are ".number_format($last->downloads - $first->downloads).'<br>';
        }
    }

    $years = ['2025', '2024'];

    foreach ($years as $year) {
        $first = Download::where('box_id', 5)
            ->whereYear('created_at', $year)
            ->orderBy('created_at')
            ->first();

        $last = Download::where('box_id', 5)
            ->whereYear('created_at', $year)
            ->orderByDesc('created_at')
            ->first();

        if ($first && $last) {
            echo "For year $year, the total downloads are ".number_format($last->downloads - $first->downloads).'<br>';
        }
    }
});
