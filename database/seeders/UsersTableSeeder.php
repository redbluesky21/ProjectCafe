<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();

        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $pelayanRole = Role::where('name', 'pelayan')->first();
        $chefRole = Role::where('name', 'chef')->first();
        $kasirRole = Role::where('name', 'kasir')->first();

        $admin = User::create([
            'name' => 'Admin Users',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
        $pelayan = User::create([
            'name' => 'Author Users',
            'email' => 'pelayan@pelayan.com',
            'password' => Hash::make('password'),
        ]);
        $chef = User::create([
            'name' => 'Chef Users',
            'email' => 'chef@chef.com',
            'password' => Hash::make('password'),
        ]);
        $kasir = User::create([
            'name' => 'Kasir Users',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('password'),
        ]);

        $admin->roles()->attach($adminRole);
        $pelayan->roles()->attach($pelayanRole);
        $chef->roles()->attach($chefRole);
        $kasir->roles()->attach($kasirRole);
    }
}
