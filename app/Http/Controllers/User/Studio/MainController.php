<?php

namespace App\Http\Controllers\User\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
}
