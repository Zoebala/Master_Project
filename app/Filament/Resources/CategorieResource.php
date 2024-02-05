<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Categorie;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategorieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategorieResource\RelationManagers;

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
                ->aside()
                ->description("Enregisterz une catégorie ou un sous catégorie")
                ->collapsible()
                ->schema([
                    Toggle::make("SousCategorie")
                    ->live()
                    ->label("Sous-Catégorie ?"),
                    Group::make([

                        TextInput::make("lib")
                        ->label("Désignation/Thème")
                        ->placeHolder("Ex: Mécanique")
                        ->required(),

                        TextInput::make("categorie_id")
                        ->label("Categorie")
                        ->hidden(fn(Get $get):bool => $get("SousCategorie")==false)
                        ->datalist([
                                "categorie" =>"categorie"
                        ]),
                    ])






                ])->columns(2),

            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("lib")
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
