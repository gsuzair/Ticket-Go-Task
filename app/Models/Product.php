<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'vendor_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public static function getProductsWithPagination(){    
        return Product::paginate(15);
    }
}
