<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'formation_id', 'ordre'];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function souschapitres(): HasMany
    {
        return $this->hasMany(SousChapitre::class, 'chapitre_id');
    }
}
