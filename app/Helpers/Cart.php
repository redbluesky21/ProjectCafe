<?php

namespace App\Helpers;

use App\Models\Menu;
use Illuminate\Http\Request;

class Cart
{
    public function __construct()
    {
        if ($this->get() === null) {
            $this->set($this->empty());
        }
    }
    public function add(Menu $menu, $jumlah = null)
    {
        $cart = $this->get();
        if ($cart['menu'] != null) {
            $item_array_id = array_column($cart['menu'], "id");
            if (!in_array($menu->id, $item_array_id)) {
                $count = count($cart['menu']);
                if ($jumlah != null) {
                    $item_array = array(
                        'id'         => $menu->id,
                        'nama'       => $menu->nama,
                        'harga'      => $menu->harga,
                        'jumlah'     => $jumlah
                    );
                } else {
                    $item_array = array(
                        'id'         => $menu->id,
                        'nama'       => $menu->nama,
                        'harga'      => $menu->harga,
                        'jumlah'     => 1
                    );
                }
                $cart["menu"][$count] = $item_array;
                $this->set($cart);
            } else {
                foreach ($cart['menu'] as $index => $value) {
                    if ($value['id'] == $menu->id) {
                        if ($jumlah != null) {
                            $item_array = array(
                                'id'         => $menu->id,
                                'nama'       => $menu->nama,
                                'harga'      => $menu->harga,
                                'jumlah'     => $jumlah
                            );
                        } else {
                            $item_array = array(
                                'id'         => $menu->id,
                                'nama'       => $menu->nama,
                                'harga'      => $menu->harga,
                                'jumlah'     => $value['jumlah'] += 1
                            );
                        }
                        $cart['menu'][$index] = $item_array;
                        $this->set($cart);
                    }
                }
            }
        } else {
            $cart = $this->get();
            $item_array = array(
                'id'         => $menu->id,
                'nama'       => $menu->nama,
                'harga'      => $menu->harga,
                'jumlah'     => 1
            );
            $cart['menu'][0] = $item_array;
            $this->set($cart);
        }
    }

    public function empty()
    {
        return [
            'menu' => [],
        ];
    }
    public function get()
    {
        return session()->get('cart');
    }

    public function set($cart)
    {
        session()->put('cart', $cart);
    }
    public function remove(int $id)
    {
        $cart = $this->get();
        array_splice($cart['menu'], array_search($id, array_column($cart['menu'], 'id')), 1);
        $this->set($cart);
    }
}
