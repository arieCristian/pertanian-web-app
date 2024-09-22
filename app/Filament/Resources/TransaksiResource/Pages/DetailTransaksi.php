<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class DetailTransaksi extends Page

{
    use InteractsWithRecord;

    protected static string $resource = TransaksiResource::class;

    protected static string $view = 'filament.resources.transaksi-resource.pages.detail-transaksi';
}
