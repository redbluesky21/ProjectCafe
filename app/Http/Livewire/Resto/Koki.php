<?php

namespace App\Http\Livewire\Resto;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Koki extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $paginate = 6, $search, $orderId, $userId;
    protected $listeners = ['pagination' => 'selectPagination'];
    public function selectPagination($paginateVal)
    {
        $this->paginate = $paginateVal;
    }
    public function mount()
    {
        if (Gate::denies('manage-koki')) {
            abort(404);
        }
        $this->userId = Auth::user()->id;
    }
    public function render()
    {
        if ($this->search != null) {
            $result = Order::join('transaksi', 'orders.id', '=', 'transaksi.orders_id')
                ->select(
                    "*",
                    "orders.status as status_order",
                    "orders.id as id_orders",
                    DB::raw("DATE_FORMAT(transaksi.created_at, '%d-%m-%Y') as tanggal_transaksi"),
                    DB::raw("DATE_FORMAT(transaksi.created_at, '%H:%i:%s') as jam_transaksi"),
                )
                ->where(
                    'orders.status',
                    '<>',
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
                ->orderBy('transaksi.created_at', 'asc')
                ->paginate($this->paginate);
        } else {
            $result = Order::join('transaksi', 'orders.id', '=', 'transaksi.orders_id')
                ->select(
                    "*",
                    "orders.status as status_order",
                    "orders.id as id_orders",
                    DB::raw("DATE_FORMAT(transaksi.created_at, '%d-%m-%Y') as tanggal_transaksi"),
                    DB::raw("DATE_FORMAT(transaksi.created_at, '%H:%i:%s') as jam_transaksi"),
                )
                ->where(
                    'orders.status',
                    '<>',
                    '2'
                )
                ->orderBy('transaksi.created_at', 'asc')
                ->paginate($this->paginate);
        }

        return view('livewire.resto.koki.main', [
            'result' => $result,
            "rows" => $result->count(),
        ]);
    }
    public function saveProses()
    {
        $order = Order::find($this->orderId);
        $order->update([
            'status' =>  '1',
            'koki_id' =>  $this->userId,
        ]);
        session()->flash('message', 'Data Updated Successfully.');

        $this->resetInputFields();
        // $this->emit('kokiStore');
    }
    public function saveSelesaiProses()
    {
        $order = Order::find($this->orderId);
        $order->update([
            'status' =>  '2',
            'koki_id' =>  $this->userId,
        ]);
        session()->flash('message', 'Data Updated Successfully.');

        $this->resetInputFields();
        // $this->emit('kokiStoreSelesai');
    }
    public function orderIdSave($id)
    {
        $this->orderId = $id;
        $this->saveProses();
    }
    public function orderIdSaveEnd($id)
    {
        $this->orderId = $id;
        $this->saveSelesaiProses();
    }
    public function resetInputFields()
    {
        $this->paginate = 6;
        $this->search = '';
        $this->orderId = '';
    }
}
