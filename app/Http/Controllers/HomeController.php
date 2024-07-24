<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Inscrit;
use App\Models\Note;
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
            return redirect()->route('homeHome');
        } elseif (auth()->user()->role_id == 2) {
            return redirect()->route('professeur.acceuil');
        } else {
            return view('default');
        }
    }




//        public function index()
//    {
//        if (auth()->user()->role_id == 1) {
////            return view('home');
//            return redirect()->route('homeHome');
//        } elseif (auth()->user()->role_id == 2) {
//            return redirect()->route('cours.homeTTT');
//        } else {
//            return view('default');
//        }





    public function home(){
        $count = Etudiant::count();
        $prof = User::count();
        $notes = Note::all();
        $moyenne = $notes->avg('note');
        $cours = cours::count();
        return view('home',compact('count','prof','cours','moyenne'));
    }


    public function profCours(){
        $cours = Cours::all();
        $prof = User::where('role_id', 2)->get();
        return view('prof.cours', compact('cours', 'prof'));
    }


}
