<?php

namespace App\Http\Livewire\Resto;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cetak extends Component
{
    public function render(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $laporan = null;
        if (isset($_GET['laporan'])) {
            $laporan = $request->input('laporan');
        }
        $result = Order::join('transaksi', 'orders.id', '=', 'transaksi.orders_id')
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
                'transaksi.id',
                '=',
                $id_transaksi
            )->get()->first();
        return view('livewire.resto.cetak.main', [
            'id' => $id_transaksi,
            'row' => $result,
            'laporan' => $laporan,
        ]);
    }
}
