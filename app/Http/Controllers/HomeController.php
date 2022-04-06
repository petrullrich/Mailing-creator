<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function home()
    {
        // dd(Auth::id());
        return view('index');
    }

    public function downloadFeed()
    {
        //return dd('hello');
        Storage::disk('local')->put('feed.xml', Http::get('https://eshop.indigoumi.cz/export-zbozi')->body());
        //return view('index');
        //return redirect()->route('index');
    }
}