<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Materiel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\MaterielResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MaterielResource\RelationManagers;
use App\Filament\Resources\MaterielResource\Widgets\CreateMaterielWidget;

class MaterielResource extends Resource
{
    protected static ?string $model = Materiel::class;
    protected static ?string $navigationGroup ="App Management";
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgecolor():string|array|null
    {
        return 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Wizard::make([

                    Step::make("Détails du matériel")
                    ->schema([

                        Section::make(" Matériel ?")
                            ->icon("heroicon-o-wrench-screwdriver")
                            ->collapsible()
                            ->description("Enregistrer un nouveau matériel ici!")
                            ->schema([

                            // Select::make("experience_id")
                            // ->label("Expérience")
                            // ->preload()
                            // ->required()
                            // ->relationship("experience","sujet"),
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
                            ->description("Uploader l'image du matériel")
                            ->schema([
                            FileUpload::make("image")->disk("public")->directory("images"),

                        ])->columnSpan(1),
                    ])->columnSpanFull(),
                    Step::make("Description sur le matériel")
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
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                // TextColumn::make("experience.sujet")->sortable()->searchable(),
                TextColumn::make("lib")
                ->label("Nom du matériel")
                ->sortable()->searchable(),
                ImageColumn::make("image"),
                TextColumn::make("description")->sortable()->searchable()->toggleable(),
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
            'index' => Pages\ListMateriels::route('/'),
            'create' => Pages\CreateMateriel::route('/create'),
            'edit' => Pages\EditMateriel::route('/{record}/edit'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            CreateMaterielWidget::class,
        ];
    }

}
