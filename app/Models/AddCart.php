<?php

namespace App\Models;

use App\Models\AdminProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddCart extends Model
{
    use HasFactory;
    protected $fillable = ['user_name','product_id','sell_price','quentity','status'];

    public function product()
    {
        return $this->belongsTo(AdminProduct::class, 'product_id');
    }
}
