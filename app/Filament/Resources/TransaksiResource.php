<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Harga;
use App\Models\Pertanian;
use App\Models\Tanaman;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pertanian_id')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->getSearchResultsUsing(function (string $search) {
                        return Pertanian::query()
                            ->join('petani', 'petani.id', '=', 'pertanian.petani_id')
                            ->join('anggota', 'petani.anggota_id', '=', 'anggota.id')
                            ->where('anggota.nama', 'like', "%{$search}%")
                            ->limit(10) // Limit the number of results
                            ->pluck('anggota.nama', 'pertanian.id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $petani = Pertanian::find($value);
                        return $petani ? $petani->anggota->nama : null;
                    }),
                Repeater::make('transaksi')
                    ->relationship('detail_transaksi')
                    ->schema([
                        Select::make('tanaman_id')
                            ->options(Tanaman::all()->pluck('tanaman', 'id'))
                            ->required()
                            ->label('Tanaman')
                            ->reactive() // Make it reactive to trigger changes in the next field
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('harga_id', null);
                            }),
                        Select::make('harga_id')
                            ->required()
                            ->label('Grade')
                            ->options(function (callable $get) {
                                $selectedTanamanId = $get('tanaman_id');
                                if ($selectedTanamanId) {
                                    return Harga::where('tanaman_id', $selectedTanamanId)->pluck('grade', 'id');
                                }
                                return [];
                            })
                            ->dependsOn(['tanaman_id']),
                        Harga::make('jumlah')
                            ->numeric()
                            ->required(),
                    ])
                    ->label('Jumlah Tanaman')
                    ->addActionLabel('Tambah Tanaman')
                    ->columnStart(1)
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
