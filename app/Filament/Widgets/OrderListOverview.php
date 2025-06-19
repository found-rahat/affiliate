<?php

namespace App\Filament\Widgets;

use App\Models\CustomerInfo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderListOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $startDate = now()->subDays(6)->startOfDay(); // 6 days ago + today = 7 days
        $endDate = now()->endOfDay();

        //------------------Pending--------------
        $Pending = CustomerInfo::selectRaw('DATE(order_create_time) as date, COUNT(*) as count')
            ->where('status', 'Pending')
            ->whereBetween('order_create_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        //------------------Processing--------------
        $Processing = CustomerInfo::selectRaw('DATE(confirm_time) as date, COUNT(*) as count')
            ->where('status', 'Processing')
            ->whereBetween('confirm_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
        //------------------Shipped--------------
        $shipped = CustomerInfo::selectRaw('DATE(shipped_time) as date, COUNT(*) as count')
            ->where('status', 'Shipped')
            ->whereBetween('shipped_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

            //------------------Packing--------------
        $Packing = CustomerInfo::selectRaw('DATE(packing_time) as date, COUNT(*) as count')
            ->where('status', 'Packing')
            ->whereBetween('packing_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
        
        //------------------Hold--------------
        $Hold = CustomerInfo::selectRaw('DATE(hold_time) as date, COUNT(*) as count')
            ->where('status', 'Hold')
            ->whereBetween('hold_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        //------------------Delivery_failed--------------
        $Delivery_failed = CustomerInfo::selectRaw('DATE(delivery_failed_time) as date, COUNT(*) as count')
            ->where('status', 'Delivery_Failed')
            ->whereBetween('delivery_failed_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        //------------------Return--------------
        $Return = CustomerInfo::selectRaw('DATE(return_time) as date, COUNT(*) as count')
            ->where('status', 'Return')
            ->whereBetween('return_time', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

            
        $PendingData = [];
        $ProcessingData = [];
        $PackingData = [];
        $shippedData = [];
        $HoldData = [];
        $Delivery_failedData = [];
        $ReturnData = [];
        foreach (range(0, 6) as $i) {
            $date = now()
                ->subDays(6 - $i)
                ->toDateString();
            $PendingData[] = $Pending[$date] ?? 0;
            $ProcessingData[] = $Processing[$date] ?? 0;
            $shippedData[] = $shipped[$date] ?? 0;
            $PackingData[] = $Packing[$date] ?? 0;
            $HoldData[] = $Hold[$date] ?? 0;
            $Delivery_failedData[] = $Delivery_failed[$date] ?? 0;
            $ReturnData[] = $Return[$date] ?? 0;
        }

        return [
            Stat::make('', CustomerInfo::where('status', 'Pending')->count())
                ->description('Pending Order')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($PendingData),

            Stat::make('', CustomerInfo::where('status', 'Processing')->count())
                ->description('Processing Order')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($ProcessingData),

            Stat::make('', CustomerInfo::where('status', 'Packing')->count())
                ->description('Packing Order')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning')
                ->chart($PackingData),

            Stat::make('', CustomerInfo::where('status', 'Shipped')->count())
                ->description('Shipped Order')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success')
                ->chart($shippedData),

            Stat::make('', CustomerInfo::where('status', 'Hold')->count())
                ->description('Hold Order')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart($HoldData),

            Stat::make('', CustomerInfo::where('status', 'Delivery_Failed')->count())
                ->description('Delivery Failed Order')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart($Delivery_failedData),

            Stat::make('', CustomerInfo::where('status', 'Return')->count())
                ->description('Return Order')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart($ReturnData),
        ];
    }
}
