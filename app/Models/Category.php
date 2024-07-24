<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_devoir',
        'pourcentage',
        'id_cours',
    ];

    public function devoirs()
    {
        return $this->hasMany(Devoir::class, 'category_id');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'id_cours');
    }

    public static function sommePourcentageEstValide($coursId, $currentCategoryId = null)
    {
        $query = self::where('id_cours', $coursId);
        if ($currentCategoryId) {
            $query->where('id', '!=', $currentCategoryId);
        }

        $totalPourcentage = $query->sum('pourcentage');
        return $totalPourcentage + request('pourcentage') <= 100;
    }



    public static function sommePourcentage($id_cours)
    {
        return self::where('id_cours', $id_cours)->sum('pourcentage');
    }

}
