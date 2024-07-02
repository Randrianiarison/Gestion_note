<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Etudiant;
use App\Models\Inscrit;
use App\Models\Note;
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

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $id_etudiant = $request->id_etudiant;
        $cours = $request->cours;
        $semestre = $request->semestre;
        $annee_scolaire_debut = $request->annee_scolaire_debut;
        $annee_scolaire_fin = $request->annee_scolaire_fin;

        try {
            DB::beginTransaction();

            foreach ($cours as $id_cours) {
                $coursData = Cours::find($id_cours);
                if (!$coursData) {
                    throw new \Exception('Le cours sélectionné est invalide.');
                }
                $id_prof = $coursData->id_prof;

                // Vérifier si l'étudiant est déjà inscrit à ce cours pour le même semestre et année scolaire
                $existingInscription = Inscrit::where('id_etudiant', $id_etudiant)
                    ->where('id_cours', $id_cours)
                    ->where('semestre', $semestre)
                    ->where('annee_scolaire', $annee_scolaire_debut . '-' . $annee_scolaire_fin)
                    ->first();

                if ($existingInscription) {
                    throw new \Exception('L\'étudiant est déjà inscrit à ce cours pour le même semestre et année scolaire.');
                }

                Inscrit::create([
                    'id_etudiant' => $id_etudiant,
                    'id_cours' => $id_cours,
                    'id_prof' => $id_prof,
                    'semestre' => $semestre,
                    'annee_scolaire' => $annee_scolaire_debut . '-' . $annee_scolaire_fin,
                ]);
            }

            DB::commit();
            return redirect()->route('etudiant')->with('success', 'Inscription réussie !');

        } catch (\Exception $e) {
            DB::rollback();
            if ($e->getMessage() === 'L\'étudiant est déjà inscrit à ce cours pour le même semestre et année scolaire.') {
                return redirect()->route('etudiant')->withErrors(['error' => $e->getMessage()]);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }







//    public function etudiantInsc($cours_id, $semestre, $annee_scolaire)
//    {
//        $cours = Cours::with(['etudiants' => function($query) use ($semestre, $annee_scolaire) {
//            $query->wherePivot('semestre', $semestre)
//                ->wherePivot('annee_scolaire', $annee_scolaire);
//        }])->findOrFail($cours_id);
//
//        $etudiants = $cours->etudiants;
//
//        $devoirs = Devoir::where('id_cours', $cours_id)
//            ->where('semestre', $semestre)
//            ->where('annee_scolaire', $annee_scolaire)
//            ->get();
//        return view('prof.etudiant', compact('cours', 'etudiants', 'semestre', 'annee_scolaire', 'devoirs'));
//    }


//    public function etudiantInsc($cours_id, $semestre, $annee_scolaire)
//    {
//        // Charger le cours et les étudiants inscrits
//        $cours = Cours::with(['etudiants' => function($query) use ($semestre, $annee_scolaire) {
//            $query->wherePivot('semestre', $semestre)
//                ->wherePivot('annee_scolaire', $annee_scolaire);
//        }])->findOrFail($cours_id);
//
//        // Charger les devoirs pour le cours spécifié
//        $devoirs = Devoir::where('id_cours', $cours_id)
//            ->where('semestre', $semestre)
//            ->where('annee_scolaire', $annee_scolaire)
//            ->get();
//
//        // Charger les notes des étudiants pour chaque devoir
//        $notes = Note::whereIn('id_devoir', $devoirs->pluck('id'))->get();
//
//        return view('prof.etudiant', compact('cours', 'devoirs', 'semestre', 'annee_scolaire', 'notes'));
//    }



    public function etudiantInsc($cours_id, $semestre, $annee_scolaire)
    {
        $cours = Cours::with(['etudiants' => function($query) use ($semestre, $annee_scolaire) {
            $query->wherePivot('semestre', $semestre)
                ->wherePivot('annee_scolaire', $annee_scolaire);
        }])->findOrFail($cours_id);

        $etudiants = $cours->etudiants;

        // Charger les devoirs pour le cours spécifié
        $devoirs = Devoir::where('id_cours', $cours_id)
            ->where('semestre', $semestre)
            ->where('annee_scolaire', $annee_scolaire)
            ->with('notes')
            ->get();

        return view('prof.etudiant', compact('cours', 'etudiants', 'semestre', 'annee_scolaire', 'devoirs'));
    }


    public function acceuil($id_cours)
    {
        $cours = Cours::findOrFail($id_cours);
        return view('prof.acceuil', compact('cours'));
    }

}
