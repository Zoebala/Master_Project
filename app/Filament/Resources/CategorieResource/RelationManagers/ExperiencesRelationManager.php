<?php

namespace App\Filament\Resources\CategorieResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Categorie;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ExperiencesRelationManager extends RelationManager
{
    protected static string $relationship = 'experiences';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
            ->schema([

                // Select::make("categorie_id")
                // ->options(function(){
                //     return Categorie::query()->whereNot("Categorie_id")
                //     ->pluck("lib","categorie_id");
                // })
                // ->required()
                // ->label("Sous-Catéggorie d'appartenance")
                // ->searchable(),
                //
                TextInput::make("sujet")
                ->required()
                ->columnSpanFull()
                ->placeholder("Ex: élements de base de la cinématique"),
                MarkdownEditor::make("description")
                ->label("Description du sujet")

                ->columnSpanFull(),
            ])->columns(2),
        ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sujet')
            ->columns([
                TextColumn::make("categorie.lib")
                ->label("Sous Catégorie")->sortable()->searchable(),
                TextColumn::make("sujet")->sortable()->searchable(),
                TextColumn::make("description")->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
