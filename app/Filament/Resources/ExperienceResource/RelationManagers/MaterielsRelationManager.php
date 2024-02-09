<?php

namespace App\Filament\Resources\ExperienceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Materiel;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;

class MaterielsRelationManager extends RelationManager
{
    protected static string $relationship = 'materiels';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lib')
            ->columns([
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
