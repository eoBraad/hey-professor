<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @return HasMany<Vote> */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    protected $casts = [
        'draft' => 'boolean',
    ];

    public function publish(): void
    {
        $this->draft = false;
        $this->save();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
