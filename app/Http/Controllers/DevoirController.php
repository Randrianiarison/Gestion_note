<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cours;
use App\Models\Devoir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevoirController extends Controller
{
    public function index(){
        $devoir = Devoir::all();
        return view('devoir.devoir',compact('devoir'));
    }
    public function etudiantInsc($cours_id, $semestre, $annee_scolaire)
    {
        $devoirs = Devoir::all();
        $cours = Cours::with(['etudiants' => function($query) use ($semestre, $annee_scolaire) {
            $query->wherePivot('semestre', $semestre)
                ->wherePivot('annee_scolaire', $annee_scolaire);
        }])->findOrFail($cours_id);
        $etudiants = $cours->etudiants;
        return view('devoir.devoir', compact('cours', 'etudiants', 'semestre', 'annee_scolaire','devoirs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_cours' => 'required|integer|exists:cours,id',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'semestre' => 'required|integer|in:1,2',
            'annee_scolaire' => 'required|string',
        ]);
        $id_prof = Auth::id();
        Devoir::create([
            'id_prof' => $id_prof,
            'id_cours' => $request->id_cours,
            'titre' => $request->titre,
            'description' => $request->description,
            'category_id' =>$request->type_devoir_id,
            'semestre' => $request->semestre,
            'annee_scolaire' => $request->annee_scolaire,
        ]);
        return back()->with('success', 'Devoir créé avec succès !');
    }

   /* public function show($id_cours, $semestre, $annee_scolaire)
    {
        $cours = Cours::findOrFail($id_cours);
        $devoirs = Devoir::where('id_cours', $id_cours)
            ->where('semestre', $semestre)
            ->where('annee_scolaire', $annee_scolaire)
            ->get();

        return view('prof.cours', compact('cours', 'semestre', 'annee_scolaire', 'devoirs'));
    }*/
//    public function show($id_cours, $semestre, $annee_scolaire)
//    {
//        $cours = Cours::findOrFail($id_cours);
//        $devoirs = Devoir::where('id_cours', $id_cours)
//            ->where('semestre', $semestre)
//            ->where('annee_scolaire', $annee_scolaire)
//            ->get();
//
//        $categories = Category::where('id_cours', $id_cours)->get();
//        $total = Category::sommePourcentage($id_cours);
//
//
//        return view('prof.cours', compact('total','cours', 'semestre', 'annee_scolaire', 'devoirs', 'categories'));
//    }



//    public function show($id_cours, $semestre, $annee_scolaire)
//    {
//        $cours = Cours::findOrFail($id_cours);
//        $devoirs = Devoir::where('id_cours', $id_cours)
//            ->where('semestre', $semestre)
//            ->where('annee_scolaire', $annee_scolaire)
//            ->get();
//
//        $categories = Category::where('id_cours', $id_cours)->get();
//        $total = Category::sommePourcentage($id_cours);
//
//        dd($total);
//
//       // return view('prof.cours', compact('cours', 'semestre', 'annee_scolaire', 'devoirs', 'categories', 'total'));
//    }



}
