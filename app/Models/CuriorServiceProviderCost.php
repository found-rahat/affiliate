<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuriorServiceProviderCost extends Model
{
    use HasFactory;
    protected $table = 'curior_service_provider_costs';
    protected $fillable =['name','amount','title','status'];
}
