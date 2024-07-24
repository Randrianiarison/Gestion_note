<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DevoirController;
use App\Http\Controllers\InscritController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home-admin', [HomeController::class, 'home'])->name('homeHome');
Route::get('/afficher-notes', [NoteController::class, 'afficherNotes'])->name('afficher.notes');
Route::get('/etudiant/{idEtudiant}', [NoteController::class, 'afficherMoyenneEtudiant'])->name('etudiant.moyenne');


Route::get('/etudiant',[EtudiantController::class,'index'])->name('etudiant');
Route::post('/etudiant', [EtudiantController::class, 'store'])->name('etudiant.store');
Route::put('/student/{id}', [EtudiantController::class, 'update'])->name('etudiant.update');
Route::delete('/etudiant/{id}', [EtudiantController::class, 'delete'])->name('etudiant.delete');
Route::get('/student',[EtudiantController::class,'inscrit'])->name('etudiant.inscrit');
Route::get('/cours',[CoursController::class,'index'])->name('cours.home');
Route::get('cours-index',[CoursController::class,'ProfCours'])->name('cours.index');
Route::post('/cours', [CoursController::class, 'store'])->name('cours.store');
Route::delete('/cours/{id}', [CoursController::class, 'delete'])->name('cours.delete');
Route::put('/cours/{id}', [CoursController::class, 'update'])->name('cours.update');
Route::get('/cours/search', [CoursController::class, 'search'])->name('cours.search');
Route::get('/user',[UserController::class,'index'])->name('user.home');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');


Route::get('/inscription', [InscritController::class, 'index'])->name('inscription.home');
Route::get('inscription/acceuil/{id_cours}', [InscritController::class, 'acceuil'])->name('inscription.acceuil');
Route::post('/inscription/store', [InscritController::class, 'store'])->name('inscription.store');





//
//Route::get('/cours/{cours_id}/etudiants/{semestre}/{annee_scolaire}', [InscritController::class, 'etudiantInsc'])->name('cours.etudiants.inscrits');
//Route::get('/pro',[CoursController::class,'index'])->name('prof.home');
//Route::post('/devoirs/store', [DevoirController::class, 'store'])->name('devoir.store');
//Route::post('/devoirs', [DevoirController::class, 'store'])->name('devoirs.store');
//Route::get('/{cours_id}/etudiants/{semestre}/{annee_scolaire}', [DevoirController::class, 'etudiantInsc'])->name('cours.etudiants.devoir');
//Route::get('/cours/{id_cours}/semestre/{semestre}/annee_scolaire/{annee_scolaire}/devoirs', [DevoirController::class, 'show'])
//    ->name('devoir.show');
//
//Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
//Route::get('/cours/{cours_id}/semestre/{semestre}/annee/{annee_scolaire}/somme-notes', [NoteController::class, 'calculerSommeNotes'])->name('cours.somme_notes');
//Route::get('/etudiants/{idEtudiant}/moyenne', [PdfController::class, 'afficherMoyenneEtudiant'])->name('etudiants.moyenne');
//
//Route::get('/professeurs/moyennes', [NoteController::class, 'afficherMoyennes'])
//    ->name('professeur.moyennes')
//    ->middleware('auth');
//Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
//Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
//Route::get('/cours/{id_cours}/somme-pourcentage', [CategoryController::class, 'verifierPourcentage']);
//Route::get('/cours/{id}/moyennes/{semestre}/{annee_scolaire}', [NoteController::class, 'calculerMoyenne'])->name('notes.moyennes');
//Route::get('/moyennes/pdf/{id_cours}/{semestre}/{annee_scolaire}', [NoteController::class, 'genererPDF'])->name('moyennes.pdf');
//Route::get('/prof-cours', [HomeController::class, 'profCours'])->name('professeur.acceuil');
//


Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/cours/{cours_id}/etudiants/{semestre}/{annee_scolaire}', [InscritController::class, 'etudiantInsc'])->name('cours.etudiants.inscrits');
    Route::get('/pro', [CoursController::class, 'index'])->name('prof.home');
    Route::post('/devoirs/store', [DevoirController::class, 'store'])->name('devoir.store');
    Route::post('/devoirs', [DevoirController::class, 'store'])->name('devoirs.store');
    Route::get('/{cours_id}/etudiants/{semestre}/{annee_scolaire}', [DevoirController::class, 'etudiantInsc'])->name('cours.etudiants.devoir');
    Route::get('/cours/{id_cours}/semestre/{semestre}/annee_scolaire/{annee_scolaire}/devoirs', [DevoirController::class, 'show'])->name('devoir.show');

    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/cours/{cours_id}/semestre/{semestre}/annee/{annee_scolaire}/somme-notes', [NoteController::class, 'calculerSommeNotes'])->name('cours.somme_notes');
    Route::get('/etudiants/{idEtudiant}/moyenne', [PdfController::class, 'afficherMoyenneEtudiant'])->name('etudiants.moyenne');

    Route::get('/professeurs/moyennes', [NoteController::class, 'afficherMoyennes'])->name('professeur.moyennes');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/cours/{id_cours}/somme-pourcentage', [CategoryController::class, 'verifierPourcentage']);
    Route::get('/cours/{id}/moyennes/{semestre}/{annee_scolaire}', [NoteController::class, 'calculerMoyenne'])->name('notes.moyennes');
    Route::get('/moyennes/pdf/{id_cours}/{semestre}/{annee_scolaire}', [NoteController::class, 'genererPDF'])->name('moyennes.pdf');
    Route::get('/prof-cours', [HomeController::class, 'profCours'])->name('professeur.acceuil');
});

