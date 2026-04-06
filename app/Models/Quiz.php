<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $fillable = ['titre', 'sous_chapitre_id'];

    public function sousChapitre(): BelongsTo
    {
        return $this->belongsTo(SousChapitre::class, 'sous_chapitre_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
