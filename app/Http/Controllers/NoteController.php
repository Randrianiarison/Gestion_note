<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Etudiant;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'id_devoir' => 'required|exists:devoirs,id',
            'id_etudiant' => 'required|exists:etudiants,id',
            'note' => 'required|numeric|min:0|max:20',
        ]);

        $existingNote = Note::where('id_devoir', $request->id_devoir)
            ->where('id_etudiant', $request->id_etudiant)
            ->first();

        if ($existingNote) {
            $existingNote->update(['note' => $request->note]);
            return back()->with('success', 'Note mise à jour avec succès !');
        } else {
            Note::create([
                'id_devoir' => $request->id_devoir,
                'id_etudiant' => $request->id_etudiant,
                'note' => $request->note,
            ]);
            return back()->with('success', 'Note enregistrée avec succès !');
        }
    }






    public function calculerSommeNotes($cours_id, $semestre, $annee_scolaire)
    {
        $devoirs = Devoir::where('id_cours', $cours_id)
            ->where('semestre', $semestre)
            ->where('annee_scolaire', $annee_scolaire)
            ->pluck('id');

        $notes = Note::whereIn('id_devoir', $devoirs)->get();

        $sommeNotes = $notes->groupBy('id_etudiant')->map(function ($noteGroup) {
            return $noteGroup->sum('note');
        });

        $maxPossibleScore = count($devoirs) * 20;
        $sommeNotesNormalized = $sommeNotes->map(function ($totalScore) use ($maxPossibleScore) {
            return number_format(($totalScore / $maxPossibleScore) * 20, 2);
        });

        $etudiants = Etudiant::whereHas('inscrits', function ($query) use ($cours_id, $semestre, $annee_scolaire) {
            $query->where('id_cours', $cours_id)
                ->where('semestre', $semestre)
                ->where('annee_scolaire', $annee_scolaire);
        })->get();

        $cours = Cours::find($cours_id);
        $titre_cours = $cours ? $cours->titre : 'Cours inconnu';

        $etudiants->each(function ($etudiant) use ($sommeNotesNormalized) {
            $etudiant->somme_notes = $sommeNotesNormalized->get($etudiant->id, 0);
        });

        return view('prof.note', compact('titre_cours', 'etudiants', 'cours_id', 'semestre', 'annee_scolaire'));
    }





    public function afficherNotes()
    {
        $cours = Cours::with(['inscrits.etudiant', 'devoirs.notes'])->get();

        $moyennes = [];

        foreach ($cours as $unCours) {
            foreach ($unCours->inscrits as $inscrit) {
                $etudiant = $inscrit->etudiant;
                $notes = Note::where('id_etudiant', $etudiant->id)
                    ->whereIn('id_devoir', $unCours->devoirs->pluck('id'))
                    ->get();

                if ($notes->count() > 0) {
                    $average = $notes->avg('note');
                } else {
                    $average = 0;
                }

                $moyennes[$unCours->id][$etudiant->id] = [
                    'etudiant' => $etudiant,
                    'average' => $average,
                ];
            }
        }

        return view('prof.acceuil',  compact('moyennes', 'cours'));
    }




    public function afficherMoyenneEtudiant($idEtudiant)
    {
        $etudiant = Etudiant::findOrFail($idEtudiant);
        $cours = Cours::with(['devoirs.notes' => function ($query) use ($idEtudiant) {
            $query->where('id_etudiant', $idEtudiant);
        }])->get();
        $moyennes = [];

        foreach ($cours as $unCours) {
            $notes = $unCours->devoirs->flatMap->notes->where('id_etudiant', $idEtudiant);

            if ($notes->count() > 0) {
                $average = $notes->avg('note');
            } else {
                $average = 0;
            }

            $moyennes[$unCours->id] = [
                'cours' => $unCours,
                'average' => $average,
            ];
        }

        return view('student.note', compact('moyennes', 'etudiant'));
    }






    public function afficherMoyennes()
    {
        // Récupérer l'ID du professeur connecté
        $idProf = Auth::id();

        // Récupérer les cours enseignés par le professeur
        $cours = Cours::where('id_prof', $idProf)->with(['inscrits.etudiant', 'devoirs.notes'])->get();

        $moyennes = [];

        // Calculer la moyenne des notes pour chaque étudiant dans chaque cours
        foreach ($cours as $unCours) {
            foreach ($unCours->inscrits as $inscrit) {
                $etudiant = $inscrit->etudiant;
                $notes = Note::where('id_etudiant', $etudiant->id)
                    ->whereIn('id_devoir', $unCours->devoirs->pluck('id'))
                    ->get();

                if ($notes->count() > 0) {
                    $average = $notes->avg('note');
                } else {
                    $average = 0; // Si l'étudiant n'a pas de notes pour ce cours
                }

                $moyennes[$unCours->id][$etudiant->id] = [
                    'etudiant' => $etudiant,
                    'average' => $average,
                ];
            }
        }
        return view('prof.moyennes', compact('moyennes', 'cours'));
    }



}
