<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SousChapitre extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'contenu', 'lien_ressource', 'chapitre_id', 'ordre'];

    public function chapitre(): BelongsTo
    {
        return $this->belongsTo(Chapitre::class);
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class, 'sous_chapitre_id');
    }
}
