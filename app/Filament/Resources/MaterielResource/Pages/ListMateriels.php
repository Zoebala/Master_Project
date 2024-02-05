<?php

namespace App\Filament\Resources\MaterielResource\Pages;

use App\Filament\Resources\MaterielResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMateriels extends ListRecords
{
    protected static string $resource = MaterielResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
