<?php

namespace App\Filament\Resources\MaterielResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MaterielResource;
use App\Filament\Resources\MaterielResource\Widgets\CreateMaterielWidget;

class ListMateriels extends ListRecords
{
    protected static string $resource = MaterielResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            CreateMaterielWidget::class,
        ];
    }
    #[On('Materiel-created')]
    public function refresh() {}
}
