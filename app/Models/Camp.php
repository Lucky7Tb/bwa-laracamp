<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Camp extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getIsRegisteredAttribute()
    {
        if (!auth()->check()) {
            return false;
        }

        return Checkout::where([
            'camp_id' => $this->id,
            'user_id' => auth()->user()->id
        ])->exists();
    }

    public function campBenefits()
    {
        return $this->hasMany(CampBenefit::class);
    }
}
