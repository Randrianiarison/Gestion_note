<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_devoir',
        'id_etudiant',
        'note',
    ];

    public static function get()
    {

    }

    public function devoir()
    {
        return $this->belongsTo(Devoir::class, 'id_devoir');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'id_cours');
    }

}
