<?php

namespace App\Filament\Resources\CategorieResource\Widgets;

use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Categorie;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateCategorieWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.categorie-resource.widgets.create-categorie-widget';
    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function form(Form $form): Form
    {
      return $form
            ->schema([
                //
                Section::make("Nouvel Enregistrement?")
                ->icon("heroicon-o-plus-circle")
                // ->aside()
                ->description("Enregisterz une catégorie ou un sous catégorie")
                ->collapsible()
                ->schema([

                        Toggle::make("SousCategorie")
                        ->live()
                        ->visible(function():bool
                        {
                           return count(DB::select("SELECT * FROM Categories WHERE categorie_id IS NULL")) >0;
                        })
                        ->label("Sous-Catégorie ?"),


                    Group::make([

                        TextInput::make("lib")
                        ->label("Thème")
                        ->placeHolder("Ex: Mécanique")
                        // ->columnSpan(2)
                        ->required(),

                        Select::make("categorie_id")
                        ->label("Categorie")
                        ->hidden(fn(Get $get):bool => $get("SousCategorie")==false)
                        ->options(function()
                        {
                            return Categorie::query()
                            ->where('categorie_id')
                            ->pluck("lib","id");
                         })
                        ->preload(),
                    ])->columnSpan(2),






                ])->columns(2),

            ])->statePath('data');


    }
    public function create(): void
    {
        Categorie::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('Categorie-created');

        Notification::make()
            ->title('Enregistrement effectué avec succès')
            ->success()
             ->duration(5000)
            ->send();
        // $this->successNotificationTitle(__('filament-actions::create.single.notifications.created.title'));
    }


}
