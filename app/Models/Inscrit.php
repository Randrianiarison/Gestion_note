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
    ];
}
