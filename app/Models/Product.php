<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'vendor_id'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
