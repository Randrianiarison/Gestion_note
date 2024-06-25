<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Devoir;
use Illuminate\Http\Request;

class DevoirController extends Controller
{
    public function index(){
        $devoir = Devoir::all();
        return view('devoir.devoir',compact('devoir'));
    }
    public function etudiantInsc($cours_id, $semestre, $annee_scolaire)
    {
        $devoir = Devoir::all();
        $cours = Cours::with(['etudiants' => function($query) use ($semestre, $annee_scolaire) {
            $query->wherePivot('semestre', $semestre)
                ->wherePivot('annee_scolaire', $annee_scolaire);
        }])->findOrFail($cours_id);
        $etudiants = $cours->etudiants;
        return view('devoir.devoir', compact('cours', 'etudiants', 'semestre', 'annee_scolaire','devoir'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'commentaire' => 'nullable|string',
            'id_prof' => 'required|exists:users,id',
            'id_cours' => 'required|exists:cours,id',
            'semestre' => 'required|integer',
            'annee_scolaire' => 'required|string|max:255',
        ]);

        Devoir::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'commentaire' => $request->commentaire,
            'id_prof' => $request->id_prof,
            'id_cours' => $request->id_cours,
            'semestre' => $request->semestre,
            'annee_scolaire' => $request->annee_scolaire,
        ]);

        return redirect()->route('devoir.home')->with('success', 'Devoir ajouté avec succès.');
    }

}
