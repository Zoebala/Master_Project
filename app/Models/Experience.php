<?php

namespace App\Models;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;

    protected $fillable=[
        "lib",
        "sujet",
        "description",
        "categorie_id"
    ];


    public function categorie():BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
