<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }
}
