<?php

namespace App\Models;

use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable=[
        "lib",
        "categorie_id",
    ];


    // public function categories():HasMany
    // {
    //    return $this->hasMany(Categorie::class, 'categorie_id', 'id');
    // }
    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function children()
    {
        return $this->hasMany(Categorie::class, 'categorie_id');
    }
}
