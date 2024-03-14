<?php

namespace App\Models;

use App\Models\Personnel;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CongeCumule extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personnel_id',
        'annee',
        'jour_total',
        'jour_prise',
        'jour_reste',
    ];

    /**
     * Get the personnel record associated with the conge cumule.
     */
    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }
}
