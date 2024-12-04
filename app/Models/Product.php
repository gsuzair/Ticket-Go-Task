<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'vendor_id'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
