<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Inscrit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InscritController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->query('id');
        $etudiant = Etudiant::findOrFail($id);
        $cours = Cours::all();
        return view('student.liste', compact('etudiant', 'cours'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_etudiant' => 'required|integer',
            'cours' => 'required|array',
            'cours.*' => 'integer',
            'semestre' => 'required|integer|in:1,2',
            'annee_scolaire_debut' => 'required|integer|min:2024',
            'annee_scolaire_fin' => 'required|integer|min:2024',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id_etudiant = $request->id_etudiant;
        $cours = $request->cours;
        $semestre = $request->semestre;
        $annee_scolaire_debut = $request->annee_scolaire_debut;
        $annee_scolaire_fin = $request->annee_scolaire_fin;
        $annee_scolaire = $annee_scolaire_debut . '-' . $annee_scolaire_fin;

        foreach ($cours as $id_cours) {
            Inscrit::create([
                'id_etudiant' => $id_etudiant,
                'id_cours' => $id_cours,
                'semestre' => $semestre,
                'annee_scolaire' => $annee_scolaire
            ]);
        }
        return redirect()->route('etudiant')->with('success', 'Inscription réussie !');
    }



    public function etudiantInsc($cours_id, $semestre, $annee_scolaire)
    {
        $cours = Cours::with(['etudiants' => function($query) use ($semestre, $annee_scolaire) {
            $query->wherePivot('semestre', $semestre)
                ->wherePivot('annee_scolaire', $annee_scolaire);
        }])->findOrFail($cours_id);
        $etudiants = $cours->etudiants;
        return view('prof.etudiant', compact('cours', 'etudiants', 'semestre', 'annee_scolaire'));
    }



}
