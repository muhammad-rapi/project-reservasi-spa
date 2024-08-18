<?php

namespace App\Filament\Customer\Resources\TreatmentResource\Pages;

use App\Filament\Customer\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTreatment extends EditRecord
{
    protected static string $resource = TreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
