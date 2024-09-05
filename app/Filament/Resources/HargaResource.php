<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HargaResource\Pages;
use App\Filament\Resources\HargaResource\RelationManagers;
use App\Models\Harga;
use App\Models\Tanaman;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NumberFormatter;

class HargaResource extends Resource
{
    protected static ?string $model = Harga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tanaman_id')
                    ->required()
                    ->label('Tanaman')
                    ->options(Tanaman::all()->pluck('nama', 'id')),
                TextInput::make('grade')
                    ->label('Grade Buah')
                    ->required(),
                TextInput::make('harga')
                    ->label('Harga')
                    ->afterStateHydrated(function (TextInput $component, $state) {
                        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
                        $formatted = $formatter->formatCurrency($state, 'IDR');
                        $component->state($formatted);
                    })
                    ->extraInputAttributes(['class' => 'currency-input']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanaman.nama')
                    ->label('Nama Buah'),
                TextColumn::make('grade')
                    ->label('Grade Buah'),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(function ($state) {
                        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
                        return $formatter->formatCurrency($state, 'IDR');
                    })
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
            'index' => Pages\ListHargas::route('/'),
            'create' => Pages\CreateHarga::route('/create'),
            'edit' => Pages\EditHarga::route('/{record}/edit'),
        ];
    }
}
