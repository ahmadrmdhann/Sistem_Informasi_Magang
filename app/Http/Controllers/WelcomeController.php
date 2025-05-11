<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
    
        if (!Auth::check()) {
            return redirect('login');
        }


        return view('welcome', [
            'user' => Auth::user()
        ]);
    }
}