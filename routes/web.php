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
    $years =['2023','2022', '2021', '2020', '2019'];

    foreach ($years as $year) {
        $downloads = Download::where('box_id', 1)->where('created_at', 'LIKE', $year . '%')->get();
        if($downloads->count() > 0 ) {
            $start = $downloads->first()->downloads;
            $end = $downloads->last()->downloads;
            //        var_dump($start, $end, $end - $start);
            print("For year $year, the total downloads are " . number_format($end - $start) . "<br>");
        }
    }
});
