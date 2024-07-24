<?php

namespace App\Http\Controllers;


use App\Models\Cours;
use App\Models\Devoir;
use App\Models\Etudiant;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class PdfController extends Controller
{


    public function afficherMoyenneEtudiant($idEtudiant)
    {
        $etudiant = Etudiant::findOrFail($idEtudiant);

        $cours = Cours::with(['devoirs.notes' => function ($query) use ($idEtudiant) {
            $query->where('id_etudiant', $idEtudiant);
        }, 'categories'])->get();

        $moyennes = [];

        foreach ($cours as $unCours) {
            $categories = $unCours->categories;
            $notes = $unCours->devoirs->flatMap->notes->where('id_etudiant', $idEtudiant);

            $totalNotesPonderees = 0;
            $totalPourcentage = 0;

            foreach ($categories as $category) {
                $pourcentageCategory = $category->pourcentage / 100;
                $devoirsCategory = $unCours->devoirs->where('category_id', $category->id);

                foreach ($devoirsCategory as $devoir) {
                    $note = $notes->where('id_devoir', $devoir->id)->first();

                    if ($note) {
                        $totalNotesPonderees += $note->note * $pourcentageCategory;
                        $totalPourcentage += $pourcentageCategory;
                    }
                }
            }

            if ($totalPourcentage > 0) {
                $average = $totalNotesPonderees / $totalPourcentage;
            } else {
                $average = 0;
            }

            $moyennes[$unCours->id] = [
                'cours' => $unCours,
                'average' => $average,
            ];
        }

        $html = view('pdf.etudiant', compact('moyennes', 'etudiant'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('moyenne_etudiant.pdf');
    }

}
