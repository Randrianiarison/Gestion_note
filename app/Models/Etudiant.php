<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email'
    ];
    public function inscrits()
    {
        return $this->hasMany(Inscrit::class, 'id_etudiant');
    }


    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'inscrits', 'id_etudiant', 'id_cours','id_prof')
            ->withPivot('semestre', 'annee_scolaire')
            ->withTimestamps();
    }
}
