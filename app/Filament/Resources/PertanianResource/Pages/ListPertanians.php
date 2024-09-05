<?php

namespace App\Filament\Resources\PertanianResource\Pages;

use App\Filament\Resources\PertanianResource;
use App\Models\Tanaman;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;

class ListPertanians extends ListRecords
{
    protected static string $resource = PertanianResource::class;

    protected function getHeaderActions(): array
    {

        // $tanamanList = Tanaman::all();

        // // Initialize an array to hold the columns
        // $columns = [];
        // $columns[] =    Column::make('id')
        // $columns[] =        Column::make('desa.nama')
        // $columns[] =       Column::make('lokasi')
        // $columns[] =        Column::make('lahan.nama')
        // $columns[] =       Column::make('petani.nama')
        // $columns[] =  Column::make('saprodi.nama')
        // $columns[] = Column::make('bibit.nama')
        // $columns[] = Column::make('korlap.nama')
        // $columns[] = Column::make('luas_area')
        // foreach ($tanamanList as $tanaman) {
        //     $columns[] = Column::make('tanaman_' . $tanaman->id)
        //         ->getStateUsing(function ($record) use ($tanaman) {
        //             return $record->getTanamanData($tanaman->id) ?? 0;
        //         });
        // }
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('updated_at'),
                        ])
                ]),
        ];
    }
}
