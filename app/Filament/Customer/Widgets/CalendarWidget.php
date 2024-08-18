<?php

namespace App\Filament\Customer\Widgets;

use App\Filament\Customer\Resources\ReservationResource;
use App\Models\Reservation;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Reservation::query()
            ->where('created_at', '>=', $fetchInfo['start'])
            ->get()
            ->map(
                fn (Reservation $reservation) => [
                    'title' => $reservation->id,
                    'start' => $reservation->reservasi_date,
                    'url' => ReservationResource::getUrl(name: 'view', parameters: ['record' => $reservation]),
                ]
            )
            ->all();
    }
}
