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
        return $this->with('productSales')->find($id);
    }

    public function cancel($id)
    {
        $this->whereId($id)->update(['is_active' => 0]);
    }
 
    public function productSales() 
    {
        return $this->hasMany(ProductSale::class);
    }
}
