<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    use HasFactory, HasRoles, SoftDeletes, Userstamps;


    public $guarded = ['id'];

    // Définir les relations éventuelles avec d'autres modèles
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Définir les relations éventuelles avec d'autres modèles
    public function etatStock(): HasMany
    {
        return $this->hasMany(EtatStock::class);
    }

    public function sortieArticle(): HasMany
    {
        return $this->hasMany(SortieArticle::class);
    }

    public function demande(): HasMany
    {
        return $this->hasMany(DemandeArticle::class);
    }
}
