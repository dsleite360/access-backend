<?php

namespace App\Models\Commerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total', 'status_id'];

    public function items()
    {
        return $this->belongsToMany(Product::class, 'produto_purchases');
    }
}
