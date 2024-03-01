<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;

    public $timestamps = true;

    public function store($data)
    {
        return $this->insert($data);
    }

    public function sale() 
    {
        return $this->belongsTo(Sale::class);
    }
}
