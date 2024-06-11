<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'sku',
        'description',
        'user_id',
        'category_id',
    ];

/*     public function user_product(){
        return $this -> belongsTo(User::class);
    } */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class)->withPivot('quantityAvailable','minimumStockLevel','maximumStockLevel','reoredPoint')->withTimestamps();
    }

    public function transfers(): BelongsToMany
    {
        return $this->belongsToMany(Transfer::class)->withPivot('quantity')->withTimestamps();
    }

    public function getTransferData($product_id, $warehouse_id)
    {
        $table = 'product_warehouse'; // Replace with your actual table name


        $data = DB::table($table)
            ->where('product_id', $product_id)
            ->where('warehouse_id', $warehouse_id)
        ->get();

        foreach ($data as $value) {
            $tr = $value->quantityAvailable;
        }
        
        return $tr;
    }
}
