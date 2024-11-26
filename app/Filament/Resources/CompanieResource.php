<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanieResource\Pages;
use App\Filament\Resources\CompanieResource\RelationManagers;
use App\Models\Companie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;

class CompanieResource extends Resource
{
    protected static ?string $model = Companie::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Entreprises';
    protected static ?string $label = 'Entreprises';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label("Nom")
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('siret')
                    ->required()
                    ->minLength(14)
                    ->maxLength(14)
                    ->numeric(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->label("Téléphone")
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                FileUpload::make('cover')
                    ->required()
                    ->image()
                    ->label('Image de profil'),
                Forms\Components\Toggle::make('actif')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('siret')
                    ->numeric(
                        decimalPlaces: 0,
                        thousandsSeparator: '',
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label("Téléphone")
                    ->numeric(
                        decimalPlaces: 0,
                        thousandsSeparator: '',
                    )
                    ->sortable(),
                Tables\Columns\IconColumn::make('actif')
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompanie::route('/create'),
            'edit' => Pages\EditCompanie::route('/{record}/edit'),
        ];
    }
}