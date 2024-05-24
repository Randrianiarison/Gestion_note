<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\User;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index(){
        $cours = Cours::all();
        $prof = User::where('role_id', 2)->get();
        return view('cours.index', compact('cours', 'prof'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sigle' => 'required|string',
            'titre' => 'required|string',
        ]);

        try {
            $cours = new Cours();
            $cours->sigle = $validatedData['sigle'];
            $cours->titre = $validatedData['titre'];
            $cours->save();
            return redirect()->route('cours.index')->with('success', 'Le cours a été enregistré avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement du cours. Veuillez réessayer.');
        }
    }
    public function delete($id)
    {
        try {
            $cours = Cours::findOrFail($id);
            $cours->delete();
            return redirect()->route('cours.index')->with('success', 'Le cours a été supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du cours. Veuillez réessayer.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sigle' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'prof_id' => 'required|integer'
        ]);
        $cours = Cours::findOrFail($id);
        if ($cours->id_prof !== null && $cours->id_prof != $request->prof_id) {
            return redirect()->route('cours.home')->with('error', 'Le cours a déjà un professeu.');
        }
        $cours->sigle = $request->sigle;
        $cours->titre = $request->titre;
        // Mettre à jour id_prof uniquement s'il est null
        if ($cours->id_prof === null) {
            $cours->id_prof = $request->prof_id;
        }
        $cours->save();
        return redirect()->route('cours.home')->with('success', 'Cours mis à jour avec succès.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $results = Cours::where('sigle', 'like', "%$searchTerm%")
            ->orWhere('titre', 'like', "%$searchTerm%")
            ->get();

        return response()->json($results);
    }


    public function updateProf(Request $request, $id)
    {
        $request->validate([
            'sigle' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'prof_id' => 'required|integer'

        ]);
        $cours = Cours::findOrFail($id);
        $cours->sigle = $request->sigle;
        $cours->titre = $request->titre;
        $cours->id_prof = $request->prof_id;
        $cours->save();
        return redirect()->route('cours.home')->with('success', 'Cours mis à jour avec succès.');
    }


}
