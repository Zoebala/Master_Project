<?php

namespace App\Filament\Resources\ExperienceResource\Widgets;

use Filament\Forms\Form;
use App\Models\Categorie;
use App\Models\Experience;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateExperienceWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.experience-resource.widgets.create-experience-widget';
    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make("Nouvelle Expérience ?")
            ->icon("heroicon-o-briefcase")
            ->collapsible()
            ->description("Ajouter une nouvelle expérience ici!")
            ->schema([

                Select::make("categorie_id")
                ->options(function(){
                    return Categorie::query()->whereNot("Categorie_id")
                    ->pluck("lib","categorie_id");
                })
                ->required()
                ->label("Sous-Catéggorie d'appartenance")
                ->searchable(),
                //
                TextInput::make("sujet")
                ->required()
                ->placeholder("Ex: élements de base de la cinématique"),
                MarkdownEditor::make("description")
                ->label("Description du sujet")
                
                ->columnSpanFull(),
            ])->columns(2),
        ])->statePath('data');
    }


    public function create(): void
    {
        Experience::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('Experience-created');
        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }

}

