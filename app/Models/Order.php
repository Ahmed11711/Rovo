<?php

namespace App\Models;

use App\Traits\HasBranch;
use App\Models\OrderCharge;
use App\Scopes\BranchScope;
use App\Models\DeliveryExecutive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use HasBranch;

    protected $guarded = ['id'];

    protected $casts = [
        'date_time' => 'datetime'
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function waiter(): BelongsTo
    {
        return $this->belongsTo(User::class)->withoutGlobalScope(BranchScope::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function taxes(): HasMany
    {
        return $this->hasMany(OrderTax::class);
    }

    public function charges(): HasMany
    {
        return $this->hasMany(OrderCharge::class);
    }

    public function kot(): HasMany
    {
        return $this->hasMany(Kot::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class)->withoutGlobalScopes();
    }

    public function deliveryExecutive(): BelongsTo
    {
        return $this->belongsTo(DeliveryExecutive::class);
    }

    public static function generateOrderNumber($branch)
    {
        $lastOrder = Order::where('branch_id', $branch->id)->latest()->first();

        if ($lastOrder) {
            return $lastOrder->order_number + 1;
        }

        return 1;
    }

}
