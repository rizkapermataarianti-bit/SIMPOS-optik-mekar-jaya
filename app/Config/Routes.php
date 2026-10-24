<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Halaman utama langsung menampilkan login.
$routes->get('/', 'Auth::login');

// Login
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::prosesLogin');

// Logout
$routes->post('logout', 'Auth::logout');

// Dashboard hanya untuk pengguna yang sudah login.
$routes->get('dashboard', 'Dashboard::index', [
    'filter' => 'auth',
]);

// Master data: hanya admin dan pemilik.
$routes->group('kategori', ['filter' => ['auth', 'role:admin,pemilik']], static function ($routes): void {
    $routes->get('/', 'Master\Kategori::index');
    $routes->get('baru', 'Master\Kategori::create');
    $routes->post('/', 'Master\Kategori::store');
    $routes->get('(:num)/edit', 'Master\Kategori::edit/$1');
    $routes->post('(:num)', 'Master\Kategori::update/$1');
    $routes->post('(:num)/hapus', 'Master\Kategori::delete/$1');
});
