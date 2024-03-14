<?php

namespace App\Models;

use App\Models\Personnel;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CongePrise extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;


    protected $fillable = [
        'cc_id',
        'personnel_id',
        'annee',
        'date_debut',
        'date_fin',
        'nombre_jour',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Relationships
    public function conge_cumule(): BelongsTo
    {
        return $this->belongsTo(CongeCumule::class);
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
