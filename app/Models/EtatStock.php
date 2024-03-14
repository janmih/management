<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtatStock extends Model
{
    use HasFactory, Userstamps, SoftDeletes, HasRoles;

    public $guarded = ['id'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
