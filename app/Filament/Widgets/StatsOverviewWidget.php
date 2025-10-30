<?php

namespace App\Filament\Widgets;

use App\Models\LaporanPacking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public ?string $selectedDate = null;

    public function mount(): void
    {
        // Default ke tanggal operasional (dengan cutoff jam 07:00)
        $this->selectedDate = $this->selectedDate ?? $this->getOperationalDate()->toDateString();
    }

    /**
     * Mendapatkan tanggal operasional berdasarkan cutoff jam 07:00
     * Jika jam < 07:00, maka masih dihitung tanggal kemarin
     */
    private function getOperationalDate(): Carbon
    {
        $now = now();

        if ($now->hour < 7) {
            return $now->subDay();
        }

        return $now;
    }

    protected function getStats(): array
    {
        $selectedDate = Carbon::parse($this->selectedDate);

        // Query dengan cutoff jam 07:00
        // Dari jam 07:00 tanggal dipilih sampai jam 06:59 tanggal berikutnya
        $startDateTime = $selectedDate->copy()->setTime(7, 0, 0);
        $endDateTime = $selectedDate->copy()->addDay()->setTime(6, 59, 59);

        $baseQuery = LaporanPacking::whereBetween('tanggal', [$startDateTime, $endDateTime]);

        $todayReports = $baseQuery->count();

        // Hitung shift saat ini
        $currentShift = LaporanPacking::calculateShift();
        $currentShiftReports = (clone $baseQuery)
            ->where('shift', $currentShift)
            ->count();

        $totalQtyGI = $baseQuery->sum('qty_gi');
        $totalQtyGR = $baseQuery->sum('qty_gr');
        $totalQtyReject = $baseQuery->sum('qty_reject');

        $rejectPercentage = $totalQtyGI > 0 ? round(($totalQtyReject / $totalQtyGI) * 100, 2) : 0;
        $grPercentage = $totalQtyGI > 0 ? round(($totalQtyGR / $totalQtyGI) * 100, 2) : 0;

        return [
            Stat::make('📋 Laporan Tanggal ' . $selectedDate->format('d/m/Y'), $todayReports)
                ->description('Total laporan (07:00 - 06:59)')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart($this->getWeeklyReportsChart($selectedDate))
                ->extraAttributes(['class' => 'cursor-pointer hover:scale-105 transition']),

            Stat::make('⏰ Shift Saat Ini', "Shift {$currentShift}")
                ->description($this->getShiftDescription($currentShift) . " • {$currentShiftReports} laporan")
                ->descriptionIcon('heroicon-m-clock')
                ->color($this->getShiftColor($currentShift))
                ->extraAttributes(['class' => 'cursor-pointer hover:scale-105 transition']),

            Stat::make('📦 Total Qty GI', number_format($totalQtyGI))
                ->description("GR: " . number_format($totalQtyGR) . " pcs ({$grPercentage}%)")
                ->descriptionIcon('heroicon-m-cube')
                ->color('success')
                ->chart($this->getWeeklyGIChart($selectedDate))
                ->extraAttributes(['class' => 'cursor-pointer hover:scale-105 transition']),

            Stat::make('⚠️ Qty Reject', number_format($totalQtyReject))
                ->description("Reject Rate: {$rejectPercentage}% dari total GI")
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($rejectPercentage > 5 ? 'danger' : ($rejectPercentage > 2 ? 'warning' : 'success'))
                ->chart($this->getWeeklyRejectChart($selectedDate))
                ->extraAttributes(['class' => 'cursor-pointer hover:scale-105 transition']),
        ];
    }

    private function getWeeklyReportsChart(Carbon $selectedDate): array
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $selectedDate->copy()->subDays($i);
            $start = $date->copy()->setTime(7, 0, 0);
            $end = $date->copy()->addDay()->setTime(6, 59, 59);

            $count = LaporanPacking::whereBetween('tanggal', [$start, $end])->count();
            $data[] = $count;
        }

        return $data;
    }

    private function getWeeklyGIChart(Carbon $selectedDate): array
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $selectedDate->copy()->subDays($i);
            $start = $date->copy()->setTime(7, 0, 0);
            $end = $date->copy()->addDay()->setTime(6, 59, 59);

            $total = LaporanPacking::whereBetween('tanggal', [$start, $end])->sum('qty_gi');
            $data[] = $total;
        }

        return $data;
    }

    private function getWeeklyRejectChart(Carbon $selectedDate): array
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $selectedDate->copy()->subDays($i);
            $start = $date->copy()->setTime(7, 0, 0);
            $end = $date->copy()->addDay()->setTime(6, 59, 59);

            $total = LaporanPacking::whereBetween('tanggal', [$start, $end])->sum('qty_reject');
            $data[] = $total;
        }

        return $data;
    }

    private function getShiftDescription(int $shift): string
    {
        return match($shift) {
            1 => '🌅 07:00 - 14:59 (Pagi)',
            2 => '🌆 15:00 - 22:59 (Sore)',
            3 => '🌙 23:00 - 06:59 (Malam)',
            default => 'Unknown'
        };
    }

    private function getShiftColor(int $shift): string
    {
        return match($shift) {
            1 => 'info',
            2 => 'warning',
            3 => 'primary',
            default => 'gray'
        };
    }
}