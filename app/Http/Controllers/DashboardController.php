<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // // check role id of user
        // $role_id = Auth::user()->roles->first()->pivot->roles_id;
        
        // if($role_id == 3) {
        //     $tahfidz_muhafidzs = DB::select('CALL tahfidz_muhafidz(?)', array($role_id));
        //     dd($tahfidz_muhafidzs);
        // }
        return view('dashboard');
    }
}
