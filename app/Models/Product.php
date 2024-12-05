<?php

namespace App\Models;

use App\Utils\Constants;
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
        $productName = $requestData['name'] ?? null;
        $perPage =  $requestData['per_page'] ?? Constants::PER_PAGE_DEFAULT;
        return Product::with(['vendor:id,name', 'ratings:product_id,name,rating,text'])
            ->when($vendorId || $productName, function ($query) use ($vendorId, $productName) {
                if ($vendorId) {
                    $query->where('vendor_id', $vendorId);
                }
                if ($productName) {
                    $query->where('name', 'like', '%' . strtolower($productName) . '%');
                }
            })
            ->paginate($perPage);
    }
}
