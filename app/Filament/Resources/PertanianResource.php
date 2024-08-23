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
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->label('Lahan')
                    ->columnSpan(4)
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) =>
                        Anggota::query()
                            ->where('nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('nama', 'id')
                    )
                    ->searchDebounce(500)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): mixed {
                        return Anggota::create($data)->id;
                    })
                    ->getOptionLabelUsing(fn($value) => Anggota::find($value)?->nama)
                    ->required(),
                Select::make('petani_id')
                    ->label('Petani')
                    ->columnSpan(4)
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) =>
                        Anggota::query()
                            ->where('nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('nama', 'id')
                    )
                    ->searchDebounce(500)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): mixed {
                        return Anggota::create($data)->id;
                    })
                    ->getOptionLabelUsing(fn($value) => Anggota::find($value)?->nama)
                    ->required(),
                Select::make('saprodi_id')
                    ->label('Saprodi')
                    ->columnSpan(4)
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) =>
                        Anggota::query()
                            ->where('nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('nama', 'id')
                    )
                    ->searchDebounce(500)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): mixed {
                        return Anggota::create($data)->id;
                    })
                    ->getOptionLabelUsing(fn($value) => Anggota::find($value)?->nama)
                    ->required(),
                Select::make('bibit_id')
                    ->label('Bibit')
                    ->columnSpan(4)
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) =>
                        Anggota::query()
                            ->where('nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('nama', 'id')
                    )
                    ->searchDebounce(500)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): mixed {
                        return Anggota::create($data)->id;
                    })
                    ->getOptionLabelUsing(fn($value) => Anggota::find($value)?->nama)
                    ->required(),
                Select::make('korlap_id')
                    ->columnSpan(4)
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) =>
                        Anggota::query()
                            ->where('nama', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('nama', 'id')
                    )
                    ->searchDebounce(500)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data): mixed {
                        return Anggota::create($data)->id;
                    })
                    ->getOptionLabelUsing(fn($value) => Anggota::find($value)?->nama)
                    ->required(),
                TextInput::make('luas_area')
                    ->columnSpan(1)
                    ->numeric()
                    ->label('Luas Area (Dalam Are)')
                    ->required(),
                Repeater::make('list_tanaman')
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
        return $table
            ->columns([
                //
            ])
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
}
