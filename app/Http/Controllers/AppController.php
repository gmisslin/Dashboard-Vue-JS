<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Job;
class AppController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return view('app',compact('user'));
    }

    public function getStats()
    {
        $jobs = Job::count();

        return json_encode(['jobs' => $jobs, 'flats' => 0, 'purchases' => 0]);
    }
}
