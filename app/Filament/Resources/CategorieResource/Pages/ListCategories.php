<?php

namespace App\Filament\Resources\CategorieResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CategorieResource;
use App\Filament\Resources\CategorieResource\Widgets\CreateCategorieWidget;

class ListCategories extends ListRecords
{
    protected static string $resource = CategorieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            CreateCategorieWidget::class,
        ];
    }

    #[On('Categorie-created')]
    public function refresh() {

    }
}
