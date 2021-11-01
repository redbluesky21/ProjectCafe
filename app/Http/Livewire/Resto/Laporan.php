<?php

namespace App\Http\Livewire\Resto;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Laporan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $paginate = 10, $search, $start_date, $end_date, $total_harga=0;
    protected $listeners = ['pagination' => 'selectPagination'];
    public function mount()
    {
        if (Gate::denies('admin-users')) {
            abort(404);
        }
    }
    public function selectPagination($paginateVal)
    {
        $this->paginate = $paginateVal;
        $this->total_harga = 0;
    }
    public function render()
    {
        if ($this->search != null) {
            if ($this->start_date != null && $this->end_date != null) {
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
                        'transaksi.status',
                        '=',
                        '1'
                    )
                    ->where(
                        'orders.customer',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->where(
                        'transaksi.created_at',
                        '>=',
                        $this->start_date
                    )
                    ->where(
                        'transaksi.created_at',
                        '<=',
                        $this->end_date
                    )
                    ->orWhere(
                        'transaksi.kode',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.total_harga',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.pajak',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.discount',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        DB::raw("DATE_FORMAT(transaksi.created_at, '%d-%m-%Y')"),
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        DB::raw("DATE_FORMAT(transaksi.created_at, '%H:%i:%s')"),
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orderBy('transaksi.created_at', 'desc')
                    ->paginate($this->paginate);
            } else {
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
                        'transaksi.status',
                        '=',
                        '1'
                    )
                    ->where(
                        'orders.customer',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.kode',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.total_harga',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.pajak',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        'transaksi.discount',
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        DB::raw("DATE_FORMAT(transaksi.created_at, '%d-%m-%Y')"),
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orWhere(
                        DB::raw("DATE_FORMAT(transaksi.created_at, '%H:%i:%s')"),
                        'like',
                        '%' . $this->search . '%'
                    )
                    ->orderBy('transaksi.created_at', 'desc')
                    ->paginate($this->paginate);
            }
        } else {
            if ($this->start_date != null && $this->end_date != null) {
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
                        'transaksi.status',
                        '=',
                        '1'
                    )
                    ->where('transaksi.created_at', '>=', $this->start_date)
                    ->where('transaksi.created_at', '<=', $this->end_date)
                    ->orderBy('transaksi.created_at', 'desc')
                    ->paginate($this->paginate);
            } else {
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
                        'transaksi.status',
                        '=',
                        '1'
                    )
                    ->orderBy('transaksi.created_at', 'desc')
                    ->paginate($this->paginate);
            }
        }

        $total_harga = $result->pluck('total_harga')->toArray();
        foreach($total_harga as $total_harga){
            $this->total_harga += $total_harga;
        }
        return view('livewire.resto.laporan.main', [
            'result' => $result,
            'rows' => $result->count(),
            'total_harga' => $this->total_harga,
        ]);
    }
    public function deleteTransaksi($id)
    {
        $order = Order::find($id);
        $order->delete();
        session()->flash('message', 'Data Deleted Successfully.');
    }
}
