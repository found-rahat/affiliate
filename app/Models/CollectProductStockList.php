<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectProductStockList extends Model
{
   use HasFactory;
    protected $fillable = [
        'collection_number',
        'collect_product_stock_id',
        'admin_product_id',
        'buy_price',
        'collection_user',
        'stock_status',
        'Order_number',
        'track_number',
        'packing_user',
        'packing_time',
        'droaping_user',
        'droaping_time',
        'return_user',
        'return_time',
        'return_confirm_status',
        'return_confirm_user',
        'return_confirm_time',
        'sell_price'

    ];

    public function AdminProduct():BelongsTo
    {

        return $this->belongsTo(AdminProduct::class);
    }
    public function collectproductstock()
    {

        return $this->belongsTo(collectproductstock::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collection_user');
    }
}
