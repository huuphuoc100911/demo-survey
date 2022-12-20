<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DemoController extends Controller
{
    public function postDemo(Request $request)
    {
        $inputs = $request->all();
        $arr = json_decode($inputs['inputs'], true);
        Log::info($arr);
    }
}
