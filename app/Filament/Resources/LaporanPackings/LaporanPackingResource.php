<?php

namespace App\Filament\Resources\LaporanPackings;

use App\Filament\Resources\LaporanPackings\Pages\CreateLaporanPacking;
use App\Filament\Resources\LaporanPackings\Pages\EditLaporanPacking;
use App\Filament\Resources\LaporanPackings\Pages\ListLaporanPackings;
use App\Filament\Resources\LaporanPackings\Schemas\LaporanPackingForm;
use App\Filament\Resources\LaporanPackings\Tables\LaporanPackingsTable;
use App\Models\LaporanPacking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LaporanPackingResource extends Resource
{
    protected static ?string $model = LaporanPacking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components(LaporanPackingForm::schema());
    }

    public static function table(Table $table): Table
    {
        return LaporanPackingsTable::configure($table);
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
            'index' => ListLaporanPackings::route('/'),
            'create' => CreateLaporanPacking::route('/create'),
            'edit' => EditLaporanPacking::route('/{record}/edit'),
        ];
    }
}
