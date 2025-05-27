<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderList extends Model
{
   use HasFactory;
   protected $fillable=[
      'user_id',
      'product_id',
      'customer_info_id',
      'order_number',
      'order_create_time',
      'item_price',
      'item_quentity',
      'unit_price',
      'paid_price',
      'status',
   ];
}
