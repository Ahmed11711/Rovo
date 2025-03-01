<?php

namespace App\Models;

use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kot extends Model
{
    use HasFactory;
    use HasBranch;

    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(KotItem::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function generateKotNumber($branch)
    {
        $lastKot = Kot::where('branch_id', $branch->id)->latest()->first();

        if ($lastKot) {
            return $lastKot->kot_number + 1;
        }

        return 1;
    }

}
