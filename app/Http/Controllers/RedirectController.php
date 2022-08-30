<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            return redirect('/admin');
            // if(Auth::user()->position == 1)
            // {
            //     // Admin
            //     return redirect('/admin');
            // }
            // elseif(Auth::user()->position == 2)
            // {
            //     // Supervisor
            //     return redirect('/supervisor');
            // }
            // elseif(Auth::user()->position == 3)
            // {
            //     // Accountant
            //     return redirect('/accountant');
            // }
            // elseif(Auth::user()->position == 4)
            // {
            //     // Secretary
            //     return redirect('/secretary');
            // }
        }
        else
        {
            return redirect('/auth/login');
        }
    }
}
