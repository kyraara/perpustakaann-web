<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Get count of overdue loans (terlambat)
     */
    public static function getOverdueCount(): int
    {
        return Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::now())
            ->count();
    }

    /**
     * Get count of low stock books (stok < 3)
     */
    public static function getLowStockCount(): int
    {
        return Buku::where('stok', '<', 3)->count();
    }

    /**
     * Get count of active loans today
     */
    public static function getTodayLoansCount(): int
    {
        return Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->count();
    }

    /**
     * Get all notification data for admin
     */
    public static function getAdminNotifications(): array
    {
        $overdue = self::getOverdueCount();
        $lowStock = self::getLowStockCount();
        $todayLoans = self::getTodayLoansCount();

        return [
            'overdue' => $overdue,
            'lowStock' => $lowStock,
            'todayLoans' => $todayLoans,
            'total' => $overdue + $lowStock,
            'items' => self::getNotificationItems($overdue, $lowStock, $todayLoans),
        ];
    }

    /**
     * Get notification items for dropdown display
     */
    private static function getNotificationItems(int $overdue, int $lowStock, int $todayLoans): array
    {
        $items = [];

        if ($overdue > 0) {
            $items[] = [
                'icon' => 'exclamation-circle',
                'color' => 'red',
                'title' => "{$overdue} Peminjaman Terlambat",
                'desc' => 'Perlu segera ditindaklanjuti',
                'link' => route('admin.peminjaman.index', ['status' => 'terlambat']),
            ];
        }

        if ($lowStock > 0) {
            $items[] = [
                'icon' => 'box-open',
                'color' => 'amber',
                'title' => "{$lowStock} Buku Stok Rendah",
                'desc' => 'Stok kurang dari 3 eksemplar',
                'link' => route('admin.buku.index'),
            ];
        }

        if ($todayLoans > 0) {
            $items[] = [
                'icon' => 'hand-holding',
                'color' => 'blue',
                'title' => "{$todayLoans} Peminjaman Hari Ini",
                'desc' => 'Transaksi peminjaman terbaru',
                'link' => route('admin.peminjaman.index'),
            ];
        }

        return $items;
    }
}
