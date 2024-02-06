<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Categorie;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategorieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategorieResource\RelationManagers;
use App\Filament\Resources\CategorieResource\Widgets\CreateCategorieWidget;
use App\Filament\Resources\CategorieResource\RelationManagers\ExperiencesRelationManager;

class CategorieResource extends Resource
{
    protected static ?string $model = Categorie::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                   return Categorie::Where("categorie_id")->count() >0;
                })
                ->label(function(Get $get){
                    if($get('SousCategorie')==false){
                        return "Sous_Catégorie ?";
                    }else{
                        return "Catégorie ?";
                    }
                }),


            Group::make([

                TextInput::make("lib")
                ->label(function(Get $get){
                    if($get('SousCategorie')==false){
                        return "Catégorie";
                    }else{
                        return "Sous_catégorie";
                    }
                })
                ->placeHolder("Ex: Mécanique")
                ->columnSpan(function(Get $get){
                    if($get("SousCategorie")==false){
                        return 2;
                    }else{
                        return 1;
                    }
                })
                ->required(),

                Select::make("categorie_id")
                ->label("Catégorie d'appartenance")
                ->hidden(fn(Get $get):bool => $get("SousCategorie")==false)
                ->options(function()
                {
                    return Categorie::query()
                    ->where('categorie_id')
                    ->pluck("lib","id");
                 })
                 ->required(fn(Get $get):bool => $get("SousCategorie")==true)
                ->preload(),
            ])->columnSpan(2)->columns(2),






        ])->columns(2),

    ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("lib")
                ->label("thème")
                ->sortable()
                ->searchable(),
                TextColumn::make("parent.lib")
                ->label("Catégorie")
                ->sortable()
                ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            CreateCategorieWidget::class,
        ];
    }
    public static function getRelations(): array
    {
        return [
            //
            ExperiencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategorie::route('/create'),
            'edit' => Pages\EditCategorie::route('/{record}/edit'),
        ];
    }
}
