<?php

namespace App\Filament\Resources\LaporanPackings\Pages;

use App\Filament\Resources\LaporanPackings\LaporanPackingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporanPacking extends EditRecord
{
    protected static string $resource = LaporanPackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
