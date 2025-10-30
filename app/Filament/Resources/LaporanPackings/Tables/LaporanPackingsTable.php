<?php

namespace App\Filament\Resources\LaporanPackings\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;

class LaporanPackingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->formatStateUsing(fn($record) => $record->tanggal->format('d/m/Y') . ' / Shift ' . $record->shift)
                    ->sortable()
                    ->label('Tanggal / Shift')
                    ->icon('heroicon-m-calendar-days')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge()
                    ->color('info'),

                TextColumn::make('no_pro')
                    ->searchable()
                    ->sortable()
                    ->label('No. PRO')
                    ->weight('bold')
                    ->copyable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('work_center')
                    ->searchable()
                    ->sortable()
                    ->label('Work Center')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-building-office')
                    ->alignment('center'),

                TextColumn::make('qty_gi')
                    ->numeric()
                    ->sortable()
                    ->label('Qty GI')
                    ->badge()
                    ->color('success')
                    ->alignment('center'),

                TextColumn::make('qty_gr')
                    ->numeric()
                    ->sortable()
                    ->label('Qty GR')
                    ->badge()
                    ->color('warning')
                    ->alignment('center'),

                TextColumn::make('qty_reject')
                    ->numeric()
                    ->sortable()
                    ->label('Qty Reject')
                    ->badge()
                    ->color('danger')
                    ->alignment('center'),

                TextColumn::make('keterangan')
                    ->limit(50)
                    ->label('Keterangan')
                    ->tooltip(fn(string $state): string => $state)
                    ->wrap(),

                ImageColumn::make('attachments')
                    ->label('Lampiran')
                    ->disk('public')
                    ->getStateUsing(function ($record) {
                        if (!is_array($record->attachments)) {
                            return [];
                        }
                        return collect($record->attachments)->map(fn($att) => is_array($att) ? $att['file'] : $att)->toArray();
                    })
                    ->width(80)
                    ->height(80)
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->defaultImageUrl(url('/images/no-image.png'))
                    ->action(
                        Action::make('preview_images')
                            ->modalHeading('Preview Lampiran')
                            ->modalContent(fn($record) => view('filament.modals.image-preview', [
                                'images' => $record->attachment_files
                            ]))
                            ->modalWidth('4xl')
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->slideOver()
                    )
                    ->extraAttributes(['class' => 'cursor-pointer hover:opacity-80 transition-opacity'])
                    ->tooltip('Klik untuk melihat semua gambar'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton(),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->poll('5s');
    }
}
