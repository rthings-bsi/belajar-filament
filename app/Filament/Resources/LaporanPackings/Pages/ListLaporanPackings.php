<?php

namespace App\Filament\Resources\LaporanPackings\Pages;

use App\Filament\Resources\LaporanPackings\LaporanPackingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaporanPackings extends ListRecords
{
    protected static string $resource = LaporanPackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
