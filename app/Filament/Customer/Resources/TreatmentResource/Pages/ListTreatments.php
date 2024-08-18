<?php

namespace App\Filament\Customer\Resources\TreatmentResource\Pages;

use App\Filament\Customer\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListTreatments extends ListRecords
{
    protected static string $resource = TreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'Ibu' => Tab::make()->query(fn ($query) => $query->where('jenis', 'Ibu')),
            'Anak' => Tab::make()->query(fn ($query) => $query->where('jenis', 'Anak')),
        ];
    }
}
