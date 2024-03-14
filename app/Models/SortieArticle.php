<?php

namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

class SortieArticle extends Model
{
    use HasFactory, HasRoles, Userstamps, SoftDeletes;

    public $guarded = ["id"];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function personnel(): BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }

    public function demandeArticle(): BelongsTo
    {
        return $this->belongsTo(DemandeArticle::class);
    }
}
