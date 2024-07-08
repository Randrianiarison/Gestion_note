<?php

namespace App\Http\Controllers;


use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Etudiant;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
//    public function generatePDF()
//    {
//        $etudiants = Etudiant::all();
//
//        $pdf = PDF::loadView('prof.pdf', compact('etudiants'));
//
//        return $pdf->download('notes_etudiants.pdf');
//    }

    public function generatePDF($cours_id, $semestre, $annee_scolaire)
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
            return ($totalScore / $maxPossibleScore) * 20;
        });

        $etudiants = Etudiant::whereHas('inscrits', function ($query) use ($cours_id, $semestre, $annee_scolaire) {
            $query->where('id_cours', $cours_id)
                ->where('semestre', $semestre)
                ->where('annee_scolaire', $annee_scolaire);
        })->get();

        $etudiants->each(function ($etudiant) use ($sommeNotesNormalized) {
            $etudiant->somme_notes = $sommeNotesNormalized->get($etudiant->id, 0);
        });

        $cours = Cours::find($cours_id);
        $titre_cours = $cours ? $cours->titre : 'Cours inconnu';

        $pdf = PDF::loadView('prof.pdf', compact('etudiants', 'titre_cours', 'semestre', 'annee_scolaire'));

        return $pdf->download('notes_etudiants.pdf');
    }
}
