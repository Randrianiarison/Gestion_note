<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cours;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /*public function store(Request $request)
    {
        $request->validate([
            'type_devoir' => 'required|string',
            'pourcentage' => 'required|numeric|min:0|max:100',
            'id_cours' => 'required|exists:cours,id',
        ]);
        Category::create($request->all());
        if (!Category::sommePourcentageEstValide($request->id_cours)) {
            return redirect()->back()->withErrors('La somme des pourcentages pour le cours doit totaliser 100%');
        }

        return redirect()->back()->with('success', 'Catégorie ajoutée avec succès');
    }*/



    public function store(Request $request)
    {
        $request->validate([
            'type_devoir' => 'required|string',
            'pourcentage' => 'required|numeric|min:0|max:100',
            'id_cours' => 'required|exists:cours,id',
        ]);

        if (!Category::sommePourcentageEstValide($request->id_cours, $request->id)) {
            return redirect()->back()->withErrors('La somme des pourcentages pour le cours doit totaliser 100%');
        }

        Category::create($request->all());

        return redirect()->back()->with('success', 'Catégorie ajoutée avec succès');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Catégorie supprimée avec succès');
    }





    public function verifierPourcentage($id_cours)
    {
        $totalPourcentage = Category::sommePourcentage($id_cours);
        return response()->json([
            'id_cours' => $id_cours,
            'total_pourcentage' => $totalPourcentage
        ]);
    }

}
