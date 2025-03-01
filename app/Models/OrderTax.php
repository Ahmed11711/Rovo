<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTax extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

}
