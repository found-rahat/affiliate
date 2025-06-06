<?php

namespace App\Models;

use App\Models\UserPanal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerInfo extends Model
{
    use HasFactory;
    protected $table = 'customer_infos';
    protected $fillable =[
        'user_id',
        'order_number',
        'name',
        'address',
        'phone',
        'item_quentity',
        'total_paid',
        'order_create_time',
        'discount',
        'discount_user',
        'payment_method',
        'payment_status',
        'confirm_time',
        'confirm_user',
        'shipping_fee',
        'shipping_provider',
        'shipping_provider_delivery_code',
        'shipped_type',
        'shipped_time',
        'shipped_user',
        'shippment_id',
        'pre_payment',
        'pre_payment_user',
        'order_note',
        'hold_reason',
        'hold_time',
        'cancel_reason',
        'cancel_time',
        'delivery_time',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserPanal::class, 'user_id');
    }

    public function orderlist()
    {
        return $this->hasMany(OrderList::class);
    }

    public function orderProducts()
    {
        return $this->hasManyThrough(
            AdminProduct::class,
            OrderList::class,
            'order_number',     // Foreign key on OrderList table
            'id',               // Foreign key on AdminProduct table
            'order_number',     // Local key on CustomerInfo table
            'product_id'        // Local key on OrderList table
        );
    }

    public function orderLists()
{
    return $this->hasMany(OrderList::class, 'order_number', 'order_number');
}

public function items()
{
    return $this->hasMany(OrderListItem::class, 'customer_info_id');
}

}
