<?php

namespace App\Models\Commerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commerce\ProductType;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'qtd', 'thumb', 'type_id'];

    public function type()
    {
        return $this->hasOne(ProductType::class, 'type_id');
    }
}
