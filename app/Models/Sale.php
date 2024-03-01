<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'is_active',
    ];

    public function byId($id)
    {
        return $this->find($id);
    }

    public function productSales() 
    {
        return $this->hasMany(ProductSale::class);
    }
}
