<?php

namespace App\Models;

use App\Models\Personnel;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, Userstamps, SoftDeletes, HasRoles;

    // Spécifier le nom de la colonne d'identifiant personnalisée
    protected $fillable = ['nom', 'description'];

    /**
     * Get the personnel for the service.
     */
    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class);
    }

    /**
     * Get the personnel for the service.
     */
    public function stockService(): HasMany
    {
        return $this->hasMany(StockService::class);
    }

    /**
     * Get the personnel for the service.
     */
    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
    /**
     * Get the users associated with the service.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
