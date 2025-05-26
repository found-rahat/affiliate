<?php

namespace App\Models;

use App\Models\User;
use App\Models\AdminProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectProductStock extends Model
{
    protected $table = 'collect_product_stocks';
    protected $fillable = ['collection_number','admin_product_id','quantity','paid_price','collection_user','created_at','updated_at'];

    public function AdminProduct():BelongsTo
    {

        return $this->belongsTo(AdminProduct::class);
    }

    public function collectionUserInfo()
    {
        return $this->belongsTo(CollectionUserInfo::class, 'collection_number', 'collection_number');

    }

    public function collectproductstocklist()
    {

        return $this->hasMany(collectproductstocklist::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collection_user');
    }

    public function adminProducts()
{
    return $this->belongsTo(AdminProduct::class, 'admin_product_id');
}



}


