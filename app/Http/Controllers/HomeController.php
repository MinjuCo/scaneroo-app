<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('layout');
    }


    public function favoriet()
    {
        return view('favoriet');
    }

    public function profile()
    {
        return view('profile');
    }
}
