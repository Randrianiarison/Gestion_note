<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;
    protected $fillable = [
        'sigle',
        'titre',
        'id_prof'
    ];
    public function inscrits()
    {
        return $this->hasMany(Inscrit::class, 'id_cours');
    }

//    public function etudiants()
//    {
//        return $this->belongsToMany(Etudiant::class, 'inscrits', 'id_cours', 'id_etudiant')
//            ->withPivot('semestre', 'annee_scolaire')
//            ->withTimestamps();
//    }
//    public function etudiants()
//    {
//        return $this->belongsToMany(Etudiant::class, 'inscrits', 'id_cours', 'id_etudiant');
//    }
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'inscrits', 'id_cours', 'id_etudiant')
            ->withPivot('semestre', 'annee_scolaire')
            ->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'id_cours');
    }



    public function devoirs()
    {
        return $this->hasMany(Devoir::class, 'id_cours');
    }
    public function categories()
    {
        return $this->hasMany(Category::class, 'id_cours');
    }
}
