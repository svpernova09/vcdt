<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VCDT\Services\ProcessBoxes;

class HomeController extends Controller
{
    public function home():array
    {
        $run = new ProcessBoxes();
        $run();

        return [
            'status' => 'ok',
            'msg' => 'nothing to see here',
        ];
    }
}
