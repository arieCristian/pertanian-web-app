<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KorlapResource\Pages;
use App\Filament\Resources\KorlapResource\RelationManagers;
use App\Models\Korlap;
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

class KorlapResource extends Resource
{
    protected static ?string $model = Korlap::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Anggota";
    protected static ?int $navigationSort = 4;

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
                    ->label('Nama Petani')
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
            'index' => Pages\ListKorlaps::route('/'),
            'create' => Pages\CreateKorlap::route('/create'),
            'edit' => Pages\EditKorlap::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getLabel(): string
    {
        return 'Korlap';
    }

    public static function getPluralLabel(): string
    {
        return 'Korlap';
    }
}
