<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class SubscriberController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.subscribers',compact("users"));
    }
}
