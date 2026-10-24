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
