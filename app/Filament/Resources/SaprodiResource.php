<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaprodiResource\Pages;
use App\Filament\Resources\SaprodiResource\RelationManagers;
use App\Models\Saprodi;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaprodiResource extends Resource
{
    protected static ?string $model = Saprodi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Anggota";
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('anggota_id'),
                TextInput::make('nama'),
                TextInput::make('phone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('anggota.nama')
                    ->label('Nama Saprodi')
                    ->sortable(),
                TextColumn::make('anggota.saldo')
                    ->label('Saldo')
                    ->formatStateUsing(fn ($state) => 'Rp. ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('anggota.phone')
                    ->label('No. HP'),
                //
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
            'index' => Pages\ListSaprodis::route('/'),
            'create' => Pages\CreateSaprodi::route('/create'),
            'edit' => Pages\EditSaprodi::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getLabel(): string
    {
        return 'Saprodi';
    }

    public static function getPluralLabel(): string
    {
        return 'Saprodi';
    }
}
