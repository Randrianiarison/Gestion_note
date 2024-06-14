<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrit extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_etudiant',
        'id_cours',
        'id_prof',
        'semestre',
        'annee_scolaire',
    ];
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'id_cours');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_prof');
    }
}
