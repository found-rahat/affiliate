<?php
namespace App\Filament\Resources\CollectionUserInfoResource\Pages;

use App\Models\AdminProduct;
use Filament\Facades\Filament;
use App\Models\CollectionUserInfo;
use Filament\Resources\Pages\Page;
use App\Models\CollectProductStock;
use App\Filament\Resources\CollectionUserInfoResource;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ViewCollectedProducts extends Page
{
    protected static string $resource = CollectionUserInfoResource::class;

    protected static string $view = 'filament.resources.collection-user-info-resource.pages.view-collected-products';

    public ?CollectionUserInfo $user = null;
    public EloquentCollection $products;

    public function mount($recordId): void
    {
        $currentUser = Filament::auth()->user();
        $this->user = CollectionUserInfo::with('user')->findOrFail($recordId);
        $this->products = CollectProductStock::with('adminProducts')->where('collection_number', $this->user->collection_number)->get();

    }
}