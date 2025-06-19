<?php

namespace App\Filament\Resources\CustomerInfoResource\Pages;

use Filament\Actions;
use App\Models\CustomerInfo;
use Filament\Actions\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\CustomerInfoResource;

class ViewCustomerInfo extends ViewRecord
{
    protected static string $resource = CustomerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->visible(fn (CustomerInfo $record) => in_array($record->status, ['Pending', 'Hold','Processing'])),
//-----------------Processing Button-----------------
            Action::make('markAsDeliveredProcessing')
                ->label('Confirm Order')
                ->color('success')
                ->icon('heroicon-o-check-badge')
                ->requiresConfirmation()
                ->action(function (CustomerInfo $record) {
                    $record->status = 'Processing';
                    $record->confirm_user = Auth::user()->name;
                    $record->confirm_time = \Carbon\Carbon::now();
                    $record->save();

                Notification::make()
                    ->title('Status updated')
                    ->body("Order #{$record->order_number} marked as Processing.")
                    ->success()
                    ->send();
                    
                return redirect(\App\Filament\Resources\CustomerInfoResource::getUrl('index'));
                    
            })
            ->visible(fn (CustomerInfo $record) => in_array($record->status, ['Pending', 'Hold'])),
//-----------------Hold Button-----------------
            Action::make('markAsHold')
            ->label('Mark as Hold')
            ->icon('heroicon-o-pause-circle')
            ->color('warning')
            ->requiresConfirmation()
            ->form([
                Textarea::make('hold_reason')
                    ->label('Reason for Hold')
                    ->maxLength(255),
            ])
            ->action(function (array $data, $record) {
                $record->status = 'Hold';
                $record->hold_reason = $data['hold_reason'];
                $record->hold_time = Carbon::now();
                $record->save();

                Notification::make()
                    ->title('Record marked as Hold')
                    ->body("Order Number #{$record->order_number} marked as Hold.")
                    ->success()
                    ->send();
                // return redirect()->to(CustomerInfoResource::getUrl('view', ['record' => $record->getKey()]));
                return redirect(\App\Filament\Resources\CustomerInfoResource::getUrl('index'));
            })
            ->visible(fn (CustomerInfo $record) => in_array($record->status, ['Pending', 'Processing'])),

        ];
    }
}
