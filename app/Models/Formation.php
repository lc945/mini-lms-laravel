<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'niveau', 'duree'];

    public function chapitres(): HasMany
    {
        return $this->hasMany(Chapitre::class);
    }

    public function apprenants(): HasMany
    {
        return $this->hasMany(User::class, 'formation_id');
    }
}
