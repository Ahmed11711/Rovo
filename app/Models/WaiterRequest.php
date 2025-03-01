<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Table;
use App\Models\Branch;
use App\Traits\HasBranch;

class WaiterRequest extends Model
{
    use HasBranch;

    protected $fillable = ['table_id', 'branch_id', 'status'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
