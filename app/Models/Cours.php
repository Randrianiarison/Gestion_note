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

    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'inscrits', 'id_cours', 'id_etudiant')
            ->withPivot('semestre', 'annee_scolaire')
            ->withTimestamps();
    }
}
