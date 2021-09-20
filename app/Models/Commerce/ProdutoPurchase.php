<?php

namespace App\Models\Commerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoPurchase extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_id', 'product_id'];
}
