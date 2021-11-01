<?php
// Kategori
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('resto.home'));
});
Breadcrumbs::for('kategori', function ($trail) {
    $trail->parent('home');
    $trail->push('Kategori', route('resto.kategori'));
});
Breadcrumbs::for('sub-kategori', function ($trail) {
    $trail->parent('home');
    $trail->push('Sub Kategori', route('resto.sub-kategori'));
});
Breadcrumbs::for('menu-pesanan', function ($trail) {
    $trail->parent('home');
    $trail->push('Menu Pesanan', route('resto.menupesanan'));
});
Breadcrumbs::for('usersmanagement', function ($trail) {
    $trail->parent('home');
    $trail->push('Users Management', route('resto.users-management'));
});
Breadcrumbs::for('pos', function ($trail) {
    $trail->parent('home');
    $trail->push('Pos', route('resto.pos'));
});
Breadcrumbs::for('koki', function ($trail) {
    $trail->parent('home');
    $trail->push('Koki', route('resto.koki'));
});
Breadcrumbs::for('kasir', function ($trail) {
    $trail->parent('home');
    $trail->push('Kasir', route('resto.kasir'));
});
Breadcrumbs::for('cetak', function ($trail) {
    $trail->parent('home');
    $trail->push('Cetak', route('resto.cetak'));
});
Breadcrumbs::for('laporan', function ($trail) {
    $trail->parent('home');
    $trail->push('Laporan', route('resto.laporan'));
});
Breadcrumbs::for('profile', function ($trail) {
    $trail->parent('home');
    $trail->push('My Profile', route('resto.user'));
});
