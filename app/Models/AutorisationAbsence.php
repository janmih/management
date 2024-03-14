<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutorisationAbsence extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;

    protected $fillable = [
        'personnel_id',
        'date_debut',
        'date_fin',
        'jour_prise',
        'jour_reste',
        'motif',
        'observation',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get the personnel record associated with the conge cumule.
     */
    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }
}
