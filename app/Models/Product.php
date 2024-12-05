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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public static function getProductsWithPagination($requestData){
        $vendorId = $requestData['vendor_id'] ?? null;    
        $vendorName = $requestData['name'] ?? null;    
        return Product::with(['vendor:id,name', 'ratings:product_id,name,rating,text'])
            ->when($vendorId || $vendorName, function ($query) use ($vendorId, $vendorName) {
                $query->whereHas('vendor', function ($query) use ($vendorId, $vendorName) {
                    if ($vendorId) {
                        $query->where('id', $vendorId);
                    }
                    if ($vendorName) {
                        $query->where('name', 'like', '%' . $vendorName . '%');
                    }
                });
            })
            ->paginate(15);
    }
}
