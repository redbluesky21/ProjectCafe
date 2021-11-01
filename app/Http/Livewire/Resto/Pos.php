<?php

namespace App\Http\Livewire\Resto;

use App\Facades\Cart;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\SubKategori;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\Helper;
use App\Models\Order;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Pos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public  $pelanggan, $kode, $bayar = null, $paginate = 8, $search, $isKategori = true, $kategori_id = null, $sub_kategori_id = null, $cartTotal = 0, $cartGet, $totalTransaksi, $discount = null, $pajak = null, $total_transaksi, $kembalian = null, $users_id, $authUser;

    protected $listeners = ['handlerSubKategori', 'handlerBackwardKategori', 'handlermenuPesanan', 'pagination' => 'selectPagination', 'handlerCountCart', 'handlerDiscountHarga', 'handlerPajakHarga', 'handlerBayarTransaksi'];
    public function resetInputFields()
    {
        $this->pelanggan = '';
        $this->kode = Helper::kodeTransaksi();
        $this->bayar = 0;
        $this->cartTotal = count(Cart::empty());
        $this->cartGet = Cart::empty();
        $this->totalTransaksi = 0;
        $this->discount = 0;
        $this->pajak = 0;
        $this->total_transaksi = 0;
        $this->kembalian = 0;
    }
    public function mount()
    {
        if (Gate::denies('manage-pos')) {
            abort(404);
        }
        $this->cartTotal = count(Cart::get()['menu']);
        $this->cartGet = Cart::get();
        $this->total_transaksi = ($this->totalTransaksi * $this->pajak / 100) - $this->discount;
        foreach ($this->cartGet['menu'] as $value) {
            $this->total_transaksi += $value['harga'] * $value['jumlah'];
        }
        $this->kode = Helper::kodeTransaksi();
        $this->users_id = Auth::id();
        $this->authUser = Auth::user()->name;
    }
    public function handlerBayarTransaksi($bayar)
    {
        if ($bayar != null) {
            $bayar = str_replace(',', '', $bayar);
            $this->bayar = $bayar;
            $this->kembalian = $this->bayar - $this->total_transaksi;
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
    public function handlerPajakHarga($pajak)
    {
        if ($pajak != null) {
            $total = $pajak[0];
            $pajak = str_replace(',', '', $pajak[1]);
            $this->pajak = $pajak;
            if ($pajak != 0) {
                $calculate = ($total * $this->pajak) / 100;
                $this->total_transaksi = $total - $calculate;
            } else {
                $this->total_transaksi = $total;
            }
        }
    }
    public function handlerCountCart($val)
    {
        $id = $val[0];
        $jumlah = intval($val[1]);

        $check = Menu::where('id', $id)->first();
        if ($check->stok < $jumlah) {
            $this->emit('stokLebihKecil', ['jumlah' => $jumlah, 'stok' => $check->stok, 'id' => $check->id]);
            return false;
        }

        Cart::add(Menu::where('id', $id)->first(), $jumlah);
        $this->cartGet = Cart::get();
        $this->cartTotal = count(Cart::get()['menu']);

        
        $cart = session()->get('cart');
        $total = 0;
        foreach ($cart['menu'] as $key => $value) {
            $total += $value['harga'] * $value['jumlah'];
        }
        $this->total_transaksi = $total;
    }
    public function selectPagination($paginateVal)
    {
        $this->paginate = $paginateVal;
    }
    public function handlerSubKategori($id)
    {
        $this->kategori_id = $id;
        if ($id != null) {
            $this->isKategori = false;
        } else {
            $this->sub_kategori_id = null;
        }
    }
    public function handlerBackwardKategori()
    {
        $this->kategori_id = null;
        $this->isKategori = true;
    }
    public function handlermenuPesanan($id)
    {
        $this->sub_kategori_id = $id;
    }

    public function render()
    {
        if ($this->isKategori) {
            $result = Kategori::all();
        } else {
            $result = SubKategori::all()
                ->where('kategori_id', '=', $this->kategori_id);
        }
        if ($this->sub_kategori_id != null) {
            if ($this->search != null) {
                $menu = Menu::select('*')
                    ->where('sub_kategori_id', '=', $this->sub_kategori_id)
                    ->orWhere('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('harga', 'like', '%' . $this->search . '%')
                    ->paginate($this->paginate);
            } else {
                $menu = Menu::select('*')
                    ->where('sub_kategori_id', '=', $this->sub_kategori_id)
                    ->paginate($this->paginate);
            }
        } else {
            if ($this->search != null) {
                $menu = Menu::select('*')
                    ->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('harga', 'like', '%' . $this->search . '%')
                    ->paginate($this->paginate);
            } else {
                $menu = Menu::select('*')
                    ->paginate($this->paginate);
            }
        }
        return view('livewire.resto.pos.main', [
            'result' => $result,
            'menu' => $menu,
            'rows' => $menu->count(),
        ]);
    }
    public function addToCart(int $menuid)
    {
        $check = Menu::where('id', $menuid)->first();
        if ($check->stok == 0) {
            $this->emit('stokHabis');
            return false;
        }
        $get = Cart::add(Menu::where('id', $menuid)->first());
        $this->cartGet = Cart::get();
        $this->cartTotal = count(Cart::get()['menu']);
        $cart = session()->get('cart');
        $total = 0;
        foreach ($cart['menu'] as $key => $value) {
            $total += $value['harga'] * $value['jumlah'];
        }
        $this->total_transaksi = $total;
    }
    public function removeItem($id)
    {
        Cart::remove($id);
        $this->cartGet = Cart::get();
        $this->cartTotal = count(Cart::get()['menu']);
    }
    public function savePos()
    {
        $validation = $this->validate([
            'kode'        =>    'required',
            'pelanggan'        =>    'required',
            'total_transaksi'        =>    'required',
            // 'bayar'        =>    'required',
            // 'kembalian'        =>    'required',
        ]);
        $cart = (session()->get('cart'));

        // Orders
        $order = new Order;
        $order->customer = $this->pelanggan;
        $order->pelayan_id = $this->users_id;
        $order->koki_id = null;
        $order->status = '0';
        $order->save();
        $idOrder = $order->id;

        // $Orders Detail
        foreach ($cart['menu'] as $value) {
            $data[] = [
                'jumlah' => $value['jumlah'],
                'menu_id' => $value['id'],
                'orders_id' => $idOrder,
            ];
        }
        DB::table('order_details')->insert($data);


        $transaksi = new Transaksi;
        $transaksi->kode = $this->kode;
        $transaksi->orders_id = $idOrder;
        $transaksi->total_harga = $this->total_transaksi;
        $transaksi->bayar = $this->bayar;
        $transaksi->kembalian = $this->kembalian;
        $transaksi->status = '0';
        $transaksi->discount = $this->discount;
        $transaksi->pajak = $this->pajak;
        $transaksi->save();
        $idTransaksi = $transaksi->id;


        session()->flash('message', 'Data Created Successfully.');
        $this->resetInputFields();
        $cart = Cart::empty();
        Cart::set($cart);
        $this->cartTotal = 0;
        $this->emit('posStore');
    }
}
