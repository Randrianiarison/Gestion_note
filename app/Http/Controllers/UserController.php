<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return view('user.index',compact('users'));
    }


    public function store(Request $request)
    {
        $userData = $request->only(['name', 'email', 'role_id', 'password']);
        $user = new User();
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->role_id = $userData['role_id'];
        $user->password = bcrypt($userData['password']);

        $user->save();
        return redirect()->route('user.home')->with('success', 'Utilisateur ajouté avec succès.');
    }
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('user.home')->with('success', 'L\'utilisateur a été supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.home')->with('error', 'Utilisateur non trouvé.');
        } catch (\Throwable $th) {
            return redirect()->route('user.home')->with('error', $th->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('user.home')->with('success', 'Utilisateur mis à jour avec succès.');
    }

}
