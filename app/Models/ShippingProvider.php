<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingProvider extends Model
{
    use HasFactory;
    protected $fillable = ['provider_name','total_product','user_name','status'];
}
