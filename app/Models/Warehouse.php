<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'streetNumber',
        'zipCode',
        'user_id',
        'contact_id',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantityAvailable','minimumStockLevel','maximumStockLevel','reoredPoint')->withTimestamps();
    }

    public function transfersSent(): HasMany
    {
        return $this->hasMany(Transfer::class, 'source_warehouse_id');
    }

    public function transfersReceived(): HasMany
    {
        return $this->hasMany(Transfer::class, 'destination_warehouse_id');
    }
}
