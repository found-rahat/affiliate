<?php

namespace App\Filament\Resources\CollectionUserInfoResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use App\Models\CollectionUserInfo;
use App\Models\CollectProductStock;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CollectionUserInfoResource;

class ViewCollectionUserInfo extends ViewRecord
{
    //
    protected static string $resource = CollectionUserInfoResource::class;

    public function getView(): string
    {
        return 'filament.resources.collection-user-info-resource.pages.view-collected-products';
    }

    protected function getViewData(): array
    {
        $user = $this->record;

        // Admin = dekhe sob
        if (Auth::user()->can('view all shipped lists')) {
            $products = CollectProductStock::with('adminProducts')->where('collection_number', $user->collection_number)->get();
        } else {
            // Normal user = only nijer data
            $products = CollectProductStock::with('adminProducts')
                ->where('collection_number', $user->collection_number)
                ->where('collection_user', Auth::id()) // ✅ Important filter
                ->get();
        }

        return [
            'user' => $user,
            'products' => $products,
        ];
    }
}
