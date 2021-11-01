<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\User;

class Helper
{
    public static function kodeTransaksi()
    {
        $get = Transaksi::select('*')
            ->orderBy('kode', 'asc')
            ->get()
            ->max('kode');

        $maxId = (intval(substr($get, 3, 3)));
        if ($maxId == null) {
            $kode_urut = "INV001";
        }
        if ($maxId <= 999) {
            $noUrut = (int) substr($maxId, 0, 3);
            $noUrut++;

            $kode_urut = "INV" . sprintf("%03s", $noUrut);
        } else {
            $noUrut = (int) $maxId;
            $noUrut++;
            $kode_urut = "INV" . $noUrut;
        }
        return $kode_urut;
    }

    public static function count_cook()
    {
        return Order::all()->where('status', '<>', 2)->count();
    }

    public static function count_cashier()
    {
        return  Order::join('transaksi', 'orders.id', '=', 'transaksi.orders_id')
            ->select(
                "*",
                "orders.status as status_order",
                "orders.id as id_orders",
                "transaksi.id as id_transaksi",
                "transaksi.status as status_transaksi",
                DB::raw("DATE_FORMAT(transaksi.created_at, '%d-%m-%Y') as tanggal_transaksi"),
                DB::raw("DATE_FORMAT(transaksi.created_at, '%H:%i:%s') as jam_transaksi"),
            )
            ->where(
                'orders.status',
                '=',
                '2'
            )
            ->where(
                'transaksi.status',
                '=',
                '0'
            )->count();
    }

    public static function getUser($id)
    {
        return (User::find($id));
    }
    public static function orderDetails($id)
    {
        return DB::table('order_details')
            ->join('menu', 'menu.id', '=', 'order_details.menu_id')
            ->select("*", 'order_details.id as id_order_details')
            ->where('orders_id', '=', $id)->get();
    }
}
