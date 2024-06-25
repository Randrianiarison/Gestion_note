<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Inscrit;
use GuzzleHttp\Promise\Coroutine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Validation des données soumises
        $validator = Validator::make($request->all(), [
            'id_etudiant' => 'required|integer', // ajuster selon vos besoins
            'cours' => 'required|array',
            'cours.*' => 'integer|exists:cours,id',
            'semestre' => 'required|integer|in:1,2',
            'annee_scolaire_debut' => 'required|integer|min:2024',
            'annee_scolaire_fin' => 'required|integer|min:2024|gte:annee_scolaire_debut',
        ], [
            'annee_scolaire_fin.gte' => 'L\'année scolaire de fin doit être supérieure ou égale à l\'année scolaire de début.'
        ]);

        // Vérification de la validation
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Récupération des données du formulaire
        $id_etudiant = $request->id_etudiant;
        $cours = $request->cours;
        $semestre = $request->semestre;
        $annee_scolaire_debut = $request->annee_scolaire_debut;
        $annee_scolaire_fin = $request->annee_scolaire_fin;

        try {
            // Début de la transaction pour assurer l'intégrité des données
            DB::beginTransaction();

            foreach ($cours as $id_cours) {
                // Vérification si le cours existe
                $coursData = Cours::find($id_cours);
                if (!$coursData) {
                    throw new \Exception('Le cours sélectionné est invalide.');
                }

                // Récupération de l'id du professeur associé au cours
                $id_prof = $coursData->id_prof;

                // Création de l'inscription
                Inscrit::create([
                    'id_etudiant' => $id_etudiant,
                    'id_cours' => $id_cours,
                    'id_prof' => $id_prof,
                    'semestre' => $semestre,
                    'annee_scolaire' => $annee_scolaire_debut . '-' . $annee_scolaire_fin,
                ]);
            }

            // Validation réussie, on commit la transaction
            DB::commit();

            // Redirection avec un message de succès
            return redirect()->route('etudiant')->with('success', 'Inscription réussie !');

        } catch (\Exception $e) {
            // En cas d'erreur, rollback de la transaction
            DB::rollback();

            // Retourner à la page précédente avec les erreurs et les données soumises
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
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

    public function acceuil($id_cours)
    {
        // Récupérer les informations du cours en fonction de $id_cours
        $cours = Cours::findOrFail($id_cours); // Supposant que Cours est le modèle pour les cours

        // Passer les informations du cours à la vue
        return view('prof.acceuil', compact('cours'));
    }

}
