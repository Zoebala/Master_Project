<?php

namespace App\Filament\Resources\MaterielResource\Pages;

use App\Filament\Resources\MaterielResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMateriel extends EditRecord
{
    protected static string $resource = MaterielResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
