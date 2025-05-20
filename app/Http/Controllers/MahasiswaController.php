<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Mahasiswacontroller extends Controller
{
    public function index()
    {
        return view('layouts.dashboard');
    }
}
