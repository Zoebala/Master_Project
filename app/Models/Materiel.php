<?php

namespace App\Models;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materiel extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib",
        "experience_id",
        "image"
    ];

    public function experience():BelongsTo
    {
        return $this->BelongsTo(Experience::class);
    }
}
