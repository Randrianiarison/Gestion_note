<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/student',[EtudiantController::class,'index'])->name('etudiant');
Route::post('/etudiant', [EtudiantController::class, 'store'])->name('etudiant.store');
Route::put('/student/{id}', [EtudiantController::class, 'update'])->name('etudiant.update');
Route::delete('/etudiant/{id}', [EtudiantController::class, 'delete'])->name('etudiant.delete');




Route::get('/cours',[CoursController::class,'index'])->name('cours.home');
Route::post('/cours', [CoursController::class, 'store'])->name('cours.store');
Route::delete('/cours/{id}', [CoursController::class, 'delete'])->name('cours.delete');
Route::put('/cours/{id}', [CoursController::class, 'update'])->name('cours.update');
Route::get('/cours/search', [CoursController::class, 'search'])->name('cours.search');




Route::get('/user',[UserController::class,'index'])->name('user.home');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');





