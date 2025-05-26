<?php

namespace App\Models;

use App\Models\CollectProductStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionUserInfo extends Model
{
protected $table = 'collection_user_infos';
protected $fillable = ['collection_user','collection_number','total_value','quantity'];


    public function collectProductStocks(): HasMany
    {
        return $this->hasMany(CollectProductStock::class, 'collection_number', 'collection_number','collection_user','buy_price');
    }

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collection_user');
    }
    
}
