<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AddCustomerWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Customer Pria', Customer::customerCount('pria')),
            Stat::make('Customer Wanita', Customer::customerCount('wanita')),
        ];
    }
}
