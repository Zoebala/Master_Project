<?php

namespace App\Models;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Materiel extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib",
        "description",
        "experience_id",
        "image"
    ];

    public function experience():BelongsTo
    {
        return $this->BelongsTo(Experience::class);
    }

    public function experiences():BelongsToMany
    {
        return $this->belongsToMany(Experience::class,"avoirs")->withTimestamps();
    }
}
