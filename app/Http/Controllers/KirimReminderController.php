<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KirimReminderController extends Controller
{
    // Display Users Table
    public function index()
    {
        return view('kirim_reminder');
    }

    // Show the form for creating a new user

}
