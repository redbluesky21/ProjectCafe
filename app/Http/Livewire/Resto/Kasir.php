<?php

namespace App\Http\Livewire\Resto;

use App\Models\Order;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Kasir extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $paginate = 6, $search, $transaksiId, $usersId, $pajak, $total_transaksi, $discount, $bayar, $kembalian;
    protected $listeners = ['pagination' => 'selectPagination', 'handlerPajakHarga', 'handlerDiscountHarga', 'handleTotalTransaksi', 'resetFormTransaksi', 'handleBayarHarga'];
    public function handleTotalTransaksi($total)
    {
        $this->transaksiId = $total[0];
        $this->total_transaksi = $total[1];
    }
    public function resetFormTransaksi()
    {
        $this->pajak = 0;
        $this->total_transaksi = 0;
        $this->discount = 0;
        $this->bayar = 0;
        $this->kembalian = 0;
        $this->emit('resetForm');
    }
    public function handlerPajakHarga($pajak)
    {
        if ($pajak != null) {
            $total = $pajak[0];
            $pajak = $pajak[1];
            $this->pajak = $pajak;
            if ($pajak != 0) {
                $calculate = ($total * $this->pajak) / 100;
                $this->total_transaksi = $total + $calculate;
            } else {
                $this->total_transaksi = $total;
            }
        }
    }
    public function handleBayarHarga($bayar)
    {
        if ($bayar != null) {
            $total = $bayar[0];
            $bayar = str_replace(',', '', $bayar[1]);
            $this->bayar = $bayar;
            if ($bayar != 0) {
                $calculate = $this->bayar - $total;
                $this->kembalian = $calculate;
            }
        }
    }
    public function handlerDiscountHarga($discount)
    {
        if ($discount != null) {
            $total = $discount[0];
            $discount = str_replace(',', '', $discount[1]);
            $this->discount = $discount;
            $this->total_transaksi = $total - $this->discount;
        }
    }
    public function mount()
    {
        if (Gate::denies('manage-kasir')) {
            abort(404);
        }
        $this->usersId = Auth::id();
    }
    public function selectPagination($paginateVal)
    {
        $this->paginate = $paginateVal;
    }
    public function render()
    {
        if ($this->search != null) {
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
                    '0'
                )
                ->where(
                    'orders.status',
                    '=',
                    '2'
                )
                ->orWhere(
                    'transaksi.kode',
                    'like',
                    '%' . $this->search . '%'
                )
                ->orWhere('orders.customer', 'like', '%' . $this->search . '%')
                ->orWhere('orders.pelayan_id', 'like', '%' . $this->search . '%')
                ->orWhere('transaksi.created_at', 'like', '%' . $this->search . '%')
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
                    'orders.status',
                    '=',
                    '2'
                )
                ->where(
                    'transaksi.status',
                    '=',
                    '0'
                )
                ->orderBy('transaksi.created_at', 'desc')
                ->paginate($this->paginate);
        }
        return view('livewire.resto.kasir.main', [
            'result' => $result,
            "rows" => $result->count(),
        ]);
    }
    public function transaksiProcess($id)
    {
        $this->transaksiId = $id;
    }
    public function saveTransaksi()
    {
        $transaksi = Transaksi::find($this->transaksiId);
        $transaksi->update([
            'status' =>  '1',
            'pajak' => $this->pajak,
            'discount' => $this->discount,
            'kembalian' => $this->kembalian,
            'bayar' => $this->bayar,
            'cashier_id' => $this->usersId
        ]);
        session()->flash('message', 'Data Updated Successfully.');

        $this->resetInputFields();
        $this->emit('transaksiStore');
        redirect('/resto/cetak?id_transaksi=' . $this->transaksiId);
    }
    public function transaksiId($id)
    {
        $this->transaksiId = $id;
    }
    public function resetInputFields()
    {
        $this->paginate = 6;
        $this->search = '';
        $this->resetFormTransaksi();
    }
}
