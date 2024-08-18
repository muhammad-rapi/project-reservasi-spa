<?php

namespace App\Filament\Customer\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingTotalWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('', 'List Treatment')
                ->url('admin/treatments'),
            Stat::make('', 'Riwayat Booking')
                ->url('admin/reservations'),
        ];
    }
}
