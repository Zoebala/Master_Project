<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Categorie;
use App\Models\Experience;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ExperienceResource\Pages;
use App\Filament\Resources\ExperienceResource\RelationManagers;
use App\Filament\Resources\ExperienceResource\Widgets\CreateExperienceWidget;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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
                    ->live()
                    ->placeholder("Ex: élements de base de la cinématique"),
                    MarkdownEditor::make("description")
                    ->visible(fn(Get $get):bool => filled($get("sujet")))
                    ->label("Description du sujet")

                    ->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("categorie.lib")
                ->label("Sous Catégorie")->sortable()->searchable(),
                TextColumn::make("sujet")->sortable()->searchable(),
                TextColumn::make("description")->toggleable(),

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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            CreateExperienceWidget::class,
        ];
    }
}
