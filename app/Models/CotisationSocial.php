<?php

namespace App\Models;

use App\Models\Mission;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CotisationSocial extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;

    protected $fillable = ['mission_id', 'montant', 'status', 'created_by', 'updated_by', 'deleted_by'];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }
}
