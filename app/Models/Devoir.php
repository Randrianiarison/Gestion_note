<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_prof',
        'id_cours',
        'titre',
        'description',
        'semestre',
        'annee_scolaire'
    ];

    public function notes()
    {
        return $this->hasMany(Note::class, 'id_devoir');
    }
}
