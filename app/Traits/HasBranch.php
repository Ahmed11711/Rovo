<?php

namespace App\Traits;

use App\Models\Branch;
use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasBranch
{

    protected static function booted()
    {
        static::addGlobalScope(new BranchScope());
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

}
