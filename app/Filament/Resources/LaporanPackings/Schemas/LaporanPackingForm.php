<?php

namespace App\Filament\Resources\LaporanPackings\Schemas;

use Illuminate\Support\Carbon;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

class LaporanPackingForm
{
    public static function schema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    DatePicker::make('tanggal')
                        ->required()
                        ->label('Tanggal')
                        ->default(Carbon::now())
                        ->native(false),

                    TextInput::make('no_pro')
                        ->numeric()
                        ->required()
                        ->label('No. PRO')
                        ->maxLength(255)
                        ->placeholder('Cth: 12345'),
                ]),

            Select::make('work_center')
                ->required()
                ->label('Work Center')
                ->options([
                    'WC-001' => 'Work Center 001',
                    'WC-002' => 'Work Center 002',
                    'WC-003' => 'Work Center 003',
                ])
                ->searchable()
                ->preload()
                ->native(false),

            Section::make('Detail Kuantitas')
                ->columns(3)
                ->schema([
                    TextInput::make('qty_gi')
                        ->required()
                        ->numeric()
                        ->label('Qty GI')
                        ->helperText('Goods Issue')
                        ->minValue(0)
                        ->suffix('pcs'),

                    TextInput::make('qty_gr')
                        ->required()
                        ->numeric()
                        ->label('Qty GR')
                        ->helperText('Goods Receipt')
                        ->minValue(0)
                        ->suffix('pcs'),

                    TextInput::make('qty_reject')
                        ->required()
                        ->numeric()
                        ->label('Qty Reject')
                        ->minValue(0)
                        ->suffix('pcs')
                        ->helperText('Jumlah yang ditolak'),
                ]),

            Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(4)
                ->maxLength(500)
                ->placeholder('Masukkan catatan atau keterangan penting')
                ->helperText('Maksimal 500 karakter'),

            Repeater::make('attachments')
                ->label('Lampiran')
                ->schema([
                    FileUpload::make('file')
                        ->label('File Gambar')
                        ->disk('public')
                        ->directory('laporan-packing-attachments')
                        ->visibility('public')
                        ->image()
                        ->maxSize(1024)
                        ->imageEditor()
                        ->openable()
                        ->downloadable()
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('caption')
                        ->label('Caption/Keterangan Gambar')
                        ->maxLength(255)
                        ->placeholder('Masukkan keterangan gambar...')
                        ->columnSpanFull(),
                ])
                ->columns(1)
                ->defaultItems(0)
                ->addActionLabel('Tambah Lampiran')
                ->reorderable()
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['caption'] ?? 'Lampiran baru')
                ->deleteAction(
                    fn ($action) => $action->requiresConfirmation()
                ),
        ];
    }
}