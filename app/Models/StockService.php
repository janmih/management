<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockService extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasRoles;

    public $guarded = ['id'];

    // Définir les relations éventuelles avec d'autres modèles
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
