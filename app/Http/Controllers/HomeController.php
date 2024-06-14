<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            return view('home');
        } elseif (auth()->user()->role_id == 2) {
            return redirect()->route('prof.home');
        } else {
        return view('default');
    }
}


}
