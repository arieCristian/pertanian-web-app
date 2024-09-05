<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PertanianResource\Pages;
use App\Filament\Resources\PertanianResource\RelationManagers;
use App\Models\Anggota;
use App\Models\Bibit;
use App\Models\Desa;
use App\Models\Korlap;
use App\Models\Lahan;
use App\Models\Pertanian;
use App\Models\Petani;
use App\Models\Saprodi;
use App\Models\Tanaman;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\select;

class PertanianResource extends Resource
{
    protected static ?string $model = Pertanian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                Select::make('desa_id')
                    ->relationship('desa', 'nama')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->optionsLimit(20)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        return Desa::create($data)->nama;
                    }),
                Textarea::make('lokasi')
                    ->columnSpan(4),
                Select::make('lahan_id')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->getSearchResultsUsing(function (string $search) {
                        return Lahan::query()
                            ->join('anggota', 'lahan.anggota_id', '=', 'anggota.id')
                            ->where('anggota.nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('anggota.nama', 'lahan.id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $lahan = Lahan::find($value);
                        return $lahan ? $lahan->anggota->nama : null;
                    })
                    ->createOptionForm([
                        Toggle::make('is_select')
                            ->label('Pilih dari Anggota yang telah terdaftar')
                            ->reactive()
                            ->requiredWith(array('anggota_id', 'nama'))
                            ->afterStateUpdated(
                                function ($state, callable $set) {
                                    if ($state) {
                                        $set('anggota_id', null);
                                        $set('nama', 'hidden');
                                    } else {
                                        $set('nama', null);
                                        $set('anggota_id', 'hidden');
                                    }
                                }
                            ),
                        TextInput::make('nama')
                            ->label('Nama Anggota Baru')
                            ->required()
                            ->maxLength(255)
                            ->hidden(
                                fn($get) => $get('is_select') == true
                            ),
                        Select::make('anggota_id')
                            ->label('Daftar Anggota')
                            ->searchable()
                            ->getSearchResultsUsing(fn(string $search): array => Anggota::where('nama', 'like', "%{$search}%")->limit(20)->pluck('nama', 'id')->toArray())
                            ->hidden(
                                fn($get) => $get('is_select') == false
                            ),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        if ($data['is_select']) {
                            $lahan = Lahan::where('anggota_id', $data['anggota_id'])->first();
                            return $lahan ? $lahan->id :  Lahan::create(['anggota_id' => $data['anggota_id']])->id;
                        }
                        $new_anggota = Anggota::create($data);
                        return Lahan::create(['anggota_id' => $new_anggota->id])->id;
                    }),
                Select::make('petani_id')
                    ->label('Petani')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->getSearchResultsUsing(function (string $search) {
                        return Petani::query()
                            ->join('anggota', 'petani.anggota_id', '=', 'anggota.id')
                            ->where('anggota.nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('anggota.nama', 'petani.id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $petani = Petani::find($value);
                        return $petani ? $petani->anggota->nama : null;
                    })
                    ->createOptionForm([
                        Toggle::make('is_select')
                            ->label('Pilih dari Anggota yang telah terdaftar')
                            ->reactive()
                            ->requiredWith(array('anggota_id', 'nama'))
                            ->afterStateUpdated(
                                function ($state, callable $set) {
                                    if ($state) {
                                        $set('anggota_id', null);
                                        $set('nama', 'hidden');
                                    } else {
                                        $set('nama', null);
                                        $set('anggota_id', 'hidden');
                                    }
                                }
                            ),
                        TextInput::make('nama')
                            ->label('Nama Anggota Baru')
                            ->required()
                            ->maxLength(255)
                            ->hidden(
                                fn($get) => $get('is_select') == true
                            ),
                        Select::make('anggota_id')
                            ->label('Daftar Anggota')
                            ->searchable()
                            ->getSearchResultsUsing(fn(string $search): array => Anggota::where('nama', 'like', "%{$search}%")->limit(20)->pluck('nama', 'id')->toArray())
                            ->hidden(
                                fn($get) => $get('is_select') == false
                            ),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        if ($data['is_select']) {
                            $petani = Petani::where('anggota_id', $data['anggota_id'])->first();
                            return $petani ? $petani->id :  Petani::create(['anggota_id' => $data['anggota_id']])->id;
                        }
                        $new_anggota = Anggota::create($data);
                        return Petani::create(['anggota_id' => $new_anggota->id])->id;
                    }),
                Select::make('saprodi_id')
                    ->relationship('saprodi', 'nama')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->getSearchResultsUsing(function (string $search) {
                        return Saprodi::query()
                            ->join('anggota', 'saprodi.anggota_id', '=', 'anggota.id')
                            ->where('anggota.nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('anggota.nama', 'saprodi.id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $saprodi = Saprodi::find($value);
                        return $saprodi ? $saprodi->anggota->nama : null;
                    })
                    ->createOptionForm([
                        Toggle::make('is_select')
                            ->label('Pilih dari Anggota yang telah terdaftar')
                            ->reactive()
                            ->requiredWith(array('anggota_id', 'nama'))
                            ->afterStateUpdated(
                                function ($state, callable $set) {
                                    if ($state) {
                                        $set('anggota_id', null);
                                        $set('nama', 'hidden');
                                    } else {
                                        $set('nama', null);
                                        $set('anggota_id', 'hidden');
                                    }
                                }
                            ),
                        TextInput::make('nama')
                            ->label('Nama Anggota Baru')
                            ->required()
                            ->maxLength(255)
                            ->hidden(
                                fn($get) => $get('is_select') == true
                            ),
                        Select::make('anggota_id')
                            ->label('Daftar Anggota')
                            ->searchable()
                            ->getSearchResultsUsing(fn(string $search): array => Anggota::where('nama', 'like', "%{$search}%")->limit(20)->pluck('nama', 'id')->toArray())
                            ->hidden(
                                fn($get) => $get('is_select') == false
                            ),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        if ($data['is_select']) {
                            $saprodi = Saprodi::where('anggota_id', $data['anggota_id'])->first();
                            return $saprodi ? $saprodi->id :  Saprodi::create(['anggota_id' => $data['anggota_id']])->id;
                        }
                        $new_anggota = Anggota::create($data);
                        return Saprodi::create(['anggota_id' => $new_anggota->id])->id;
                    }),
                Select::make('bibit_id')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->getSearchResultsUsing(function (string $search) {
                        return Bibit::query()
                            ->join('anggota', 'bibit.anggota_id', '=', 'anggota.id')
                            ->where('anggota.nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('anggota.nama', 'bibit.id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $bibit = Bibit::find($value);
                        return $bibit ? $bibit->anggota->nama : null;
                    })
                    ->createOptionForm([
                        Toggle::make('is_select')
                            ->label('Pilih dari Anggota yang telah terdaftar')
                            ->reactive()
                            ->requiredWith(array('anggota_id', 'nama'))
                            ->afterStateUpdated(
                                function ($state, callable $set) {
                                    if ($state) {
                                        $set('anggota_id', null);
                                        $set('nama', 'hidden');
                                    } else {
                                        $set('nama', null);
                                        $set('anggota_id', 'hidden');
                                    }
                                }
                            ),
                        TextInput::make('nama')
                            ->label('Nama Anggota Baru')
                            ->required()
                            ->maxLength(255)
                            ->hidden(
                                fn($get) => $get('is_select') == true
                            ),
                        Select::make('anggota_id')
                            ->label('Daftar Anggota')
                            ->searchable()
                            ->getSearchResultsUsing(fn(string $search): array => Anggota::where('nama', 'like', "%{$search}%")->limit(20)->pluck('nama', 'id')->toArray())
                            ->hidden(
                                fn($get) => $get('is_select') == false
                            )
                    ])
                    ->createOptionUsing(function (array $data): string {
                        if ($data['is_select']) {
                            $bibit = Bibit::where('anggota_id', $data['anggota_id'])->first();
                            return $bibit ? $bibit->id : Bibit::create(['anggota_id' => $data['anggota_id']])->id;
                        }
                        $new_anggota = Anggota::create($data);
                        return Bibit::create(['anggota_id' => $new_anggota->id])->id;
                    }),
                Select::make('korlap_id')
                    ->relationship('korlap', 'nama')
                    ->columnSpan(4)
                    ->searchable()
                    ->searchDebounce(500)
                    ->getSearchResultsUsing(function (string $search) {
                        return Korlap::query()
                            ->join('anggota', 'korlap.anggota_id', '=', 'anggota.id')
                            ->where('anggota.nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('anggota.nama', 'korlap.id');
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $korlap = Korlap::find($value);
                        return $korlap ? $korlap->anggota->nama : null;
                    })
                    ->createOptionForm([
                        Toggle::make('is_select')
                            ->label('Pilih dari Anggota yang telah terdaftar')
                            ->reactive()
                            ->requiredWith(array('anggota_id', 'nama'))
                            ->afterStateUpdated(
                                function ($state, callable $set) {
                                    if ($state) {
                                        $set('anggota_id', null);
                                        $set('nama', 'hidden');
                                    } else {
                                        $set('nama', null);
                                        $set('anggota_id', 'hidden');
                                    }
                                }
                            ),
                        TextInput::make('nama')
                            ->label('Nama Anggota Baru')
                            ->required()
                            ->maxLength(255)
                            ->hidden(
                                fn($get) => $get('is_select') == true
                            ),
                        Select::make('anggota_id')
                            ->label('Daftar Anggota')
                            ->searchable()
                            ->getSearchResultsUsing(fn(string $search): array => Anggota::where('nama', 'like', "%{$search}%")->limit(20)->pluck('nama', 'id')->toArray())
                            ->hidden(
                                fn($get) => $get('is_select') == false
                            ),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        if ($data['is_select']) {
                            $korlap = Korlap::where('anggota_id', $data['anggota_id'])->first();
                            return $korlap ? $korlap->id : Korlap::create(['anggota_id' => $data['anggota_id']])->id;
                        }
                        $new_anggota = Anggota::create($data);
                        return Korlap::create(['anggota_id' => $new_anggota->id])->id;
                    }),
                TextInput::make('luas_area')
                    ->columnSpan(1)
                    ->numeric()
                    ->label('Luas Area (Dalam Are)'),
                Repeater::make('list_tanaman')
                    ->relationship('jumTanaman')
                    ->schema([
                        Select::make('tanaman_id')
                            ->options(Tanaman::all()->pluck('nama', 'id'))
                            ->required()
                            ->label('Tanaman'),
                        TextInput::make('jumlah')
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

        $tanamanList = Tanaman::all();

        // Initialize an array to hold the columns
        $columns = [];
        $columns[] =    TextColumn::make('id')
            ->sortable();
        $columns[] =        TextColumn::make('desa.nama')
            ->label('Desa')
            ->sortable();
        $columns[] =       TextColumn::make('lokasi')
            ->label('Lokasi')
            ->sortable();
        $columns[] =        TextColumn::make('lahan.nama')
            ->label('Lahan');
        $columns[] =       TextColumn::make('petani.nama')
            ->searchable()
            ->label('Petani Peng');
        $columns[] =  TextColumn::make('saprodi.nama')
            ->label('Saprodi');
        $columns[] = TextColumn::make('bibit.nama')
            ->label('Inv Bitit');
        $columns[] = TextColumn::make('korlap.nama')
            ->label('Korlap');
        $columns[] = TextColumn::make('luas_area')
            ->label('Luas Lahan (Are)');
        foreach ($tanamanList as $tanaman) {
            $columns[] = TextColumn::make('tanaman_' . $tanaman->id)
                ->label($tanaman->nama)
                ->getStateUsing(function ($record) use ($tanaman) {
                    return $record->getTanamanData($tanaman->id) ?? 0;
                });
        }


        return $table
            ->columns($columns)
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPertanians::route('/'),
            'create' => Pages\CreatePertanian::route('/create'),
            'edit' => Pages\EditPertanian::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function query(): Builder
    {
        return parent::query()
            ->with(['lahan', 'petani', 'saprodi', 'bibit', 'korlap']);
    }
}
