<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\User;
use http\Env\Response;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{

    public function index(){
        $etudiants = Etudiant::all();
        $cours = Cours::all();
        $users= User::all();
//        if (request()->ajax()) {
//            return response()->json($etudiants);
//        }
//        return response()->json($etudiants);
         return view('student.index', compact('etudiants','cours','users'));

    }

    public function inscrit()
    {
        $etudiants = Etudiant::all();
        $cours = Cours::all();
        return view('cours.inscrit',compact('etudiants','cours'));
    }
    public function store(Request $request)
    {
       $studentId = $request->id;
       $student = Etudiant::updateOrCreate(
           [
               'id'=>$studentId
           ],
           [
               'nom'=>$request->nom,
               'prenom'=>$request->prenom,
               'email'=>$request->email
           ]
       );
//       return Response()->json($student);
        return redirect()->route('etudiant')->with('success', 'Étudiant ajouté ou mis à jour avec succès.');

    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:etudiants,email,'.$id,
        ]);

        try {
            $etudiant = Etudiant::findOrFail($id);
            $etudiant->nom = $validatedData['nom'];
            $etudiant->prenom = $validatedData['prenom'];
            $etudiant->email = $validatedData['email'];
            $etudiant->save();

            return redirect()->route('etudiant')->with('success', 'Étudiant ajouté ou mis à jour avec succès.');
        } catch (\Throwable $th) {
            return back(['message' => 'Erreur lors de la mise à jour de l\'étudiant'], 500);
        }
    }

    public function delete($id)
{
    try {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();
        return redirect()->route('etudiant')->with('success', 'Étudiant ajouté ou mis à jour avec succès.');
    } catch (\Throwable $th) {
        return redirect()->route('etudiant')->with('error', 'Erreur.');
    }
}




}





