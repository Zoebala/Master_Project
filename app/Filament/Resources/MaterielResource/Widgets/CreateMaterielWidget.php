<?php

namespace App\Filament\Resources\MaterielResource\Widgets;

use App\Models\Materiel;
use Filament\Forms\Form;
use App\Models\Experience;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateMaterielWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.materiel-resource.widgets.create-materiel-widget';
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
            //
            Wizard::make([

                Step::make("Détails du matériel")
                    // ->icon("heroicon-o-document")
                    ->schema([

                    Section::make(" Matériel ?")
                        ->icon("heroicon-o-wrench-screwdriver")
                        ->collapsible()
                        ->description("Enregistrer un nouveau matériel ici!")
                        ->schema([

                        
                        TextInput::make("lib")
                        ->label("Nom du matériel")
                        ->minLength(3)
                        ->maxLength(50)
                        ->placeHolder("Ex: caméra")
                        ->required(),
                    ])->columnSpan(2),
                    Section::make("Image du matériel")
                        ->icon("heroicon-o-camera")
                        ->collapsible()
                        // ->description("Uploader l'image du matériel")
                        ->schema([
                        FileUpload::make("image")->disk("public")->directory("images"),

                    ])->columnSpan(1),
                ])->columnSpanFull(),
                Step::make("Description sur le matériel")
                    // ->icon("heroicon-o-document-text")
                    ->schema([

                    Section::make()
                        ->collapsible()
                        ->description("Renseignement sur le matériel utilisé")
                        ->icon('heroicon-o-document')
                        ->schema([
                            MarkdownEditor::make("description")
                            ->label("Déscripiton du matériel"),

                    ]),
                ]),
            ])->columnSpanFull()->columns(3),
        ])->columns(3)
            ->statePath('data');
    }
    public function create(): void
    {
        Materiel::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('Materiel-created');
        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }
}
