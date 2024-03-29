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
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ExperienceResource\Pages;
use App\Filament\Resources\ExperienceResource\RelationManagers;
use App\Filament\Resources\ExperienceResource\Widgets\CreateExperienceWidget;
use App\Filament\Resources\ExperienceResource\RelationManagers\MaterielsRelationManager;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup ="App Management";
    protected static ?string $recordTitleAttribute ="sujet";
    public static function getGlobalSearchResultTitle(Model $record):string
    {
        return $record->sujet;
    }
    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgecolor():string|array|null
    {
        return 'success';
    }
    public static function getGloballySearchableAttributes():array
    {
        return [
            "sujet",
            "categorie.lib"
        ];
    }
    public static function getGlobalSearchResultDetails(Model $record):array
    {
        return [
            "Sous_Categorie "=>$record->categorie->lib,
        ];
    }
    public static function getGlobalSearchResultEloquentQuery(Model $record):Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['categorie']);
    }

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
                TextColumn::make("description")->toggleable(isToggledHiddenByDefault: true),

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
            MaterielsRelationManager::class,
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
