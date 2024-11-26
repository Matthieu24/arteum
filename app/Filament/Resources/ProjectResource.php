<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use App\Models\Companie;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Projets';
    protected static ?string $label = 'Projets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_id')
                    ->label('Entreprise')
                    ->options(Companie::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label("Nom")
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label("Description")
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Section::make('Page de projet existante chez le client')
                    ->schema([
                        Forms\Components\Toggle::make('existing_page')
                            ->label("Page existante ?"),
                        Forms\Components\TextInput::make('Lien')
                            ->label("Lien")
                            ->maxLength(65535),
                    ])
                    ->columns(2),
                Forms\Components\Toggle::make('is_priority')
                    ->required()
                    ->label("Prioritaire")
                    ->helperText(function (callable $get) {
                        $priorityProject = Project::where('company_id', $get('company_id'))->priority();
                        if (!$priorityProject || $get('is_priority')) {
                            return;
                        } else {
                            return '/!\\ Un projet est déjà prioritaire, l\'ancien projet perdra sa priorité';
                        }
                    }),
                Forms\Components\Toggle::make('actif')
                    ->required(),
                FileUpload::make('cover')
                    ->required()
                    ->image()
                    ->label('Image de couverture'),
                Repeater::make('images')
                    ->schema([
                        FileUpload::make('path')
                            ->required()
                            ->image()
                            ->label('Image'),
                        Forms\Components\TextInput::make('position')
                            ->required()
                            ->minValue(1)
                            ->numeric(),
                    ])
                    ->collapsible()
                    ->relationship()
                    ->grid(2)
                    ->columnSpanFull(),
            ])->columns(7);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->label("Entreprise"),
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_priority')
                    ->label("Prioritaire")
                    ->boolean(),
                Tables\Columns\IconColumn::make('actif')
                    ->boolean(),
                Tables\Columns\IconColumn::make('existing_page')
                    ->label("Page existante")
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}