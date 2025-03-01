<?php

namespace App\Models;

use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingStep extends Model
{
    use HasFactory;
    use HasBranch;

    protected $guarded = ['id'];
}
