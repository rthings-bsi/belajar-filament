<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LaporanPacking extends Model
{
    protected $table = 'laporan_packings';

    protected $fillable = [
        'tanggal',
        'shift',
        'no_pro',
        'work_center',
        'qty_gi',
        'qty_gr',
        'qty_reject',
        'keterangan',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'tanggal' => 'date',
    ];

    protected static function booted(): void
    {
        static::deleting(function ($laporanPacking) {
            if (is_array($laporanPacking->attachments)) {
                foreach ($laporanPacking->attachments as $attachment) {
                    $filePath = is_array($attachment) ? $attachment['file'] : $attachment;
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->shift) {
                $model->shift = self::calculateShift();
            }
        });
    }

    public static function calculateShift(): int
    {
        $hour = now()->hour;

        if ($hour >= 7 && $hour < 15) {
            return 1; // Shift 1: 07:00 - 14:59
        } elseif ($hour >= 15 && $hour < 23) {
            return 2; // Shift 2: 15:00 - 22:59
        } else {
            return 3; // Shift 3: 23:00 - 06:59
        }
    }

    public function getTanggalShiftAttribute(): string
    {
        return $this->tanggal->format('d/m/Y') . ' / Shift ' . $this->shift;
    }

    public function getAttachmentFilesAttribute(): array
    {
        if (!is_array($this->attachments)) {
            return [];
        }

        return collect($this->attachments)->map(function ($attachment) {
            return [
                'url' => Storage::disk('public')->url(is_array($attachment) ? $attachment['file'] : $attachment),
                'caption' => is_array($attachment) ? ($attachment['caption'] ?? '') : '',
            ];
        })->toArray();
    }
}
