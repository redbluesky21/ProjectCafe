<?php

namespace App\Http\Livewire\Resto;

use Livewire\Component;
use App\Models\User;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public function render()
    {
        $admin =   User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.name as nama_roles')
            ->where('roles.name', '=', 'admin')
            ->get()->count();
        $pelayan =   User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.name as nama_roles')
            ->where('roles.name', '=', 'pelayan')
            ->get()->count();
        $chef =   User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.name as nama_roles')
            ->where('roles.name', '=', 'chef')
            ->get()->count();
        $kasir =   User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.name as nama_roles')
            ->where('roles.name', '=', 'kasir')
            ->get()->count();

        $menu =   Menu::all()->count();
        $transaksi =   Transaksi::all()->count();
        $transaksi_day =   Transaksi::all()->where('created_at', '=', date('Y-m-d'))->count();
        $transaksi_hold =   Transaksi::all()->where('status', '=', 'x')->count();

        $data = [
            'admin' => $admin,
            'pelayan' => $pelayan,
            'chef' => $chef,
            'kasir' => $kasir,
            'menu' => $menu,
            'transaksi' => $transaksi,
            'transaksi_day' => $transaksi_day,
            'transaksi_hold' => $transaksi_hold,
        ];
        return view('livewire.resto.home.main', $data);
    }
}
