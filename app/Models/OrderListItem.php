<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderListItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'customer_info_id',
        'order_list_id',
        'order_number',
        'item_quentity',
        'order_create_time',
        'item_price',
        'unit_price'
    ];
}
