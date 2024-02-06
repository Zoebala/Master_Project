<?php

namespace App\Filament\Resources\ExperienceResource\Pages;

use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ExperienceResource;
use App\Filament\Resources\ExperienceResource\Widgets\CreateExperienceWidget;

class ListExperiences extends ListRecords
{
    protected static string $resource = ExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CreateExperienceWidget::class,
        ];
    }
    #[On('Experience-created')]
    public function refresh() {}
}
