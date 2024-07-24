<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Etudiant;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;
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
        }, 'categories'])->get();

        $moyennes = [];
        $totalNotesPonderees = 0;
        $totalPourcentage = 0;

        foreach ($cours as $unCours) {
            $categories = Category::where('id_cours', $unCours->id)->get();
            $totalNotesPondereesCours = 0;
            $totalPourcentageCours = 0;

            foreach ($categories as $category) {
                $devoirs = $unCours->devoirs->where('category_id', $category->id);
                $pourcentageCategory = $category->pourcentage / 100;

                $totalNotes = 0;
                $noteCount = 0;

                foreach ($devoirs as $devoir) {
                    $note = $devoir->notes->where('id_etudiant', $idEtudiant)->first();

                    if ($note && $note->note !== null) {
                        $totalNotes += $note->note;
                        $noteCount++;
                    }
                }

                if ($noteCount > 0) {
                    $moyenneDevoirs = $totalNotes / $noteCount;
                    $totalNotesPondereesCours += $moyenneDevoirs * $pourcentageCategory;
                    $totalPourcentageCours += $pourcentageCategory;
                }
            }

            $averageCours = $totalPourcentageCours > 0 ? $totalNotesPondereesCours / $totalPourcentageCours : 0;

            $moyennes[$unCours->id] = [
                'cours' => $unCours,
                'average' => $averageCours,
            ];

            $totalNotesPonderees += $averageCours * ($totalPourcentageCours > 0 ? $totalPourcentageCours : 1);
            $totalPourcentage += $totalPourcentageCours;
        }

        $averageGeneral = $totalPourcentage > 0 ? $totalNotesPonderees / $totalPourcentage : 0;

        return view('student.note', compact('moyennes', 'etudiant', 'averageGeneral'));
    }








    public function afficherMoyennes()
    {
        $idProf = Auth::id();
        $cours = Cours::where('id_prof', $idProf)
            ->with(['inscrits.etudiant', 'devoirs.notes', 'categories'])
            ->get();

        $moyennes = [];
        foreach ($cours as $unCours) {
            foreach ($unCours->inscrits as $inscrit) {
                $etudiant = $inscrit->etudiant;
                $notes = Note::where('id_etudiant', $etudiant->id)
                    ->whereIn('id_devoir', $unCours->devoirs->pluck('id'))
                    ->get();

                $totalNotesPonderees = 0;
                $totalPourcentage = 0;

                foreach ($unCours->categories as $categorie) {
                    $pourcentageCategorie = $categorie->pourcentage / 100;
                    $devoirs = $unCours->devoirs->where('category_id', $categorie->id);

                    $totalNotesCategorie = 0;
                    $countDevoirsCategorie = 0;

                    foreach ($devoirs as $devoir) {
                        $note = $notes->firstWhere('id_devoir', $devoir->id);
                        if ($note) {
                            $totalNotesCategorie += $note->note;
                            $countDevoirsCategorie++;
                        }
                    }

                    if ($countDevoirsCategorie > 0) {
                        $moyenneCategorie = $totalNotesCategorie / $countDevoirsCategorie;
                        $totalNotesPonderees += $moyenneCategorie * $pourcentageCategorie;
                        $totalPourcentage += $pourcentageCategorie;
                    }
                }

                if ($totalPourcentage > 0) {
                    $average = $totalNotesPonderees / $totalPourcentage;
                } else {
                    $average = 0; // Si aucune catégorie n'a de notes
                }

                $moyennes[$unCours->id][$etudiant->id] = [
                    'etudiant' => $etudiant,
                    'average' => $average,
                ];
            }
        }

        return view('prof.moyennes', compact('moyennes', 'cours'));
    }






    public function calculerMoyenne($id_cours, $semestre, $annee_scolaire)
    {
        $cours = Cours::findOrFail($id_cours);
        $categories = Category::where('id_cours', $id_cours)->get();

        $etudiants = Etudiant::whereHas('inscrits', function($query) use ($id_cours, $semestre, $annee_scolaire) {
            $query->where('id_cours', $id_cours)
                ->where('semestre', $semestre)
                ->where('annee_scolaire', $annee_scolaire);
        })->get();

        $moyennes = [];

        foreach ($etudiants as $etudiant) {
            $totalNotesPonderees = 0;
            $totalPourcentage = 0;

            foreach ($categories as $category) {
                $devoirs = Devoir::where('category_id', $category->id)
                    ->where('semestre', $semestre)
                    ->where('annee_scolaire', $annee_scolaire)
                    ->get();
                $pourcentageCategory = $category->pourcentage / 100;

                foreach ($devoirs as $devoir) {
                    $note = Note::where('id_devoir', $devoir->id)
                        ->where('id_etudiant', $etudiant->id)
                        ->first();

                    if ($note && $note->note !== null) {
                        $totalNotesPonderees += $note->note * $pourcentageCategory;
                        $totalPourcentage += $pourcentageCategory;
                    }
                }
            }

            if ($totalPourcentage > 0) {
                $moyenne = $totalNotesPonderees / $totalPourcentage;
                $moyennes[$etudiant->id] = $moyenne;
            } else {
                $moyennes[$etudiant->id] = null;
            }
        }

        return view('prof.note', compact('cours', 'etudiants', 'moyennes', 'semestre', 'annee_scolaire'));
    }

    public function genererPDF($id_cours, $semestre, $annee_scolaire)
    {
        $cours = Cours::findOrFail($id_cours);
        $categories = Category::where('id_cours', $id_cours)->get();

        $etudiants = Etudiant::whereHas('inscrits', function($query) use ($id_cours, $semestre, $annee_scolaire) {
            $query->where('id_cours', $id_cours)
                ->where('semestre', $semestre)
                ->where('annee_scolaire', $annee_scolaire);
        })->get();

        $moyennes = [];

        foreach ($etudiants as $etudiant) {
            $totalNotesPonderees = 0;
            $totalPourcentage = 0;

            foreach ($categories as $category) {
                $devoirs = Devoir::where('category_id', $category->id)
                    ->where('semestre', $semestre)
                    ->where('annee_scolaire', $annee_scolaire)
                    ->get();
                $pourcentageCategory = $category->pourcentage / 100;

                foreach ($devoirs as $devoir) {
                    $note = Note::where('id_devoir', $devoir->id)
                        ->where('id_etudiant', $etudiant->id)
                        ->first();

                    if ($note && $note->note !== null) {
                        $totalNotesPonderees += $note->note * $pourcentageCategory;
                        $totalPourcentage += $pourcentageCategory;
                    }
                }
            }

            if ($totalPourcentage > 0) {
                $moyenne = $totalNotesPonderees / $totalPourcentage;
                $moyennes[$etudiant->id] = number_format($moyenne * 20, 2); // Conversion en note sur 20
            } else {
                $moyennes[$etudiant->id] = 'N/A';
            }
        }
        $pdf = Pdf::loadView('prof.pdf', compact('cours', 'etudiants', 'moyennes', 'semestre', 'annee_scolaire'));

        return $pdf->download('moyennes.pdf');
    }

}
