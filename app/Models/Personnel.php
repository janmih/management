<?php

namespace App\Models;

use App\Models\Service;
use App\Models\ReposMedical;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Personnel extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;

    protected $guarded = ['id'];

    /**
     * Get the service that owns the personnel.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Relation avec la table des repos_medical
    public function reposMedical()
    {
        return $this->hasMany(ReposMedical::class);
    }

    // Relation avec la table des repos_medical
    public function congeCumule()
    {
        return $this->hasMany(CongeCumule::class);
    }

    // Relation avec la table des repos_medical
    public function mission(): HasMany
    {
        return $this->hasMany(Mission::class);
    }

    // Relation avec la table des conge prose
    public function congePrise(): HasMany
    {
        return $this->hasMany(CongePrise::class);
    }

    // Relation avec la table des conge prose
    public function autorisatonAbsence(): HasMany
    {
        return $this->hasMany(AutorisationAbsence::class);
    }

    public function sortieArticle(): HasMany
    {
        return $this->hasMany(SortieArticle::class);
    }

    public function demande(): HasMany
    {
        return $this->hasMany(DemandeArticle::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getFullNameAttribute(): String
    {
        return $this->nom . ' ' . $this->prenom;
    }
}
