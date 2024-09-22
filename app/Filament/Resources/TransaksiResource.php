<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Harga;
use App\Models\Pertanian;
use App\Models\Petani;
use App\Models\Tanaman;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NumberFormatter;

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
                        $petani = Petani::find($value);
                        return $petani ? $petani->anggota->nama : null;
                    }),
                Grid::make(6)
                    ->schema([
                        Grid::make()
                            ->schema(self::transaction_form())
                            ->columnSpan(3),
                        Grid::make()
                            ->schema([
                                Hidden::make('total')
                                    ->afterStateHydrated(function (Get $get, Set $set) {
                                        self::updateTotals($get, $set);
                                    }),
                                TextInput::make('total_displayed')
                                    ->readOnly()
                                    ->dehydrated(false)
                                    ->columnSpan('full')
                                    ->label('Total')
                                    ->afterStateHydrated(function (Get $get, Set $set) {
                                        self::updateTotals($get, $set);
                                    }),
                            ])
                            ->columnSpan(3),
                    ]),
            ]);
    }

    // public static function details_form()
    // {
    //     return [
    //         Fieldset::make('Pembagian Hasil Penjualan')
    //             ->schema([
    //                 Fieldset::make('Petani')
    //                 ->schema([
    //                     TextInput::make('info_petani')
    //                     ->readOnly(),
    //                     TextInput::make('info_petani_total')
    //                     ->

    //                 ])
    //             ])
    //             ->columns(3)
    //     ];
    // }
    public static function transaction_form()
    {
        return array(
            Repeater::make('detail_transaksi')
                ->relationship('detail_transaksi')
                ->schema([
                    Select::make('tanaman_id')
                        ->options(Tanaman::all()->pluck('nama', 'id'))
                        ->required()
                        ->reactive()
                        ->label('Tanaman'),
                    Select::make('harga_id')
                        ->options(function (callable $get, callable $set) {
                            $selectedTanamanId = $get('tanaman_id');
                            if ($selectedTanamanId) {
                                return Harga::where('tanaman_id', $selectedTanamanId)->pluck('grade', 'id');
                            }
                            return [];
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $harga = Harga::find($state);
                            if ($harga) {
                                $set('harga', $harga->harga);
                                $set('harga_displayed', formatRupiah($harga->harga));
                            }
                        })
                        ->label('Grade'),
                    Hidden::make('harga')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $set('harga_displayed', formatRupiah($state));
                            }
                        })
                        ->required(),
                    TextInput::make('harga_displayed')
                        ->label('Harga')
                        ->readOnly()
                        ->dehydrated(false)
                        ->required(),
                    TextInput::make('qty')
                        ->numeric()
                        ->required(),
                ])
                ->live()
                // After adding a new row, we need to update the totals
                ->afterStateUpdated(function (Get $get, Set $set) {
                    self::updateTotals($get, $set);
                })
                // After deleting a row, we need to update the totals
                ->deleteAction(
                    fn($action) => $action->after(fn(Get $get, Set $set) => self::updateTotals($get, $set)),
                )
                ->label('Detail Transaksi')
                ->addActionLabel('Tambah Transaksi')
                ->columnSpan('full')
        );
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('detail_transaksi'))->filter(fn($item) => !empty($item['harga_id']) && !empty($item['qty']));
        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) {
            return $subtotal + ($product['harga'] * $product['qty']);
        }, 0);
        // dd($selectedProducts);
        $set('total', $subtotal);
        $set('total_displayed', formatRupiah($subtotal));
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
            'view' => Pages\DetailTransaksi::route('/sort'),
        ];
    }
}
