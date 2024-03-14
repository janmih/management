<?php

namespace App\Models;

use App\Models\CotisationSocial;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mission extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;

    protected $fillable = [
        'personnel_id',
        'date_debut',
        'date_fin',
        'observation',
        'lieu',
        'nombre_jour',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Définir les relations éventuelles avec d'autres modèles
    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }

    // Relation avec la table des repos_medical
    public function cotisationSocial(): HasMany
    {
        return $this->hasMany(CotisationSocial::class);
    }

    // Définir d'autres propriétés ou méthodes nécessaires
}
