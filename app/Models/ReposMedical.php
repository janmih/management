<?php

namespace App\Models;

use App\Models\Personnel;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReposMedical extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;


    protected $guarded = [
        'id',
    ];

    // Relation avec la table des personnels
    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }
}
