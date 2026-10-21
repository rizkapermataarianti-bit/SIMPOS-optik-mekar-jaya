<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        $namaDashboard = [
            'kasir'        => 'Dashboard Kasir',
            'admin'        => 'Dashboard Admin',
            'pemilik'      => 'Dashboard Pemilik',
        ];

        if (!isset($namaDashboard[$role])) {
            session()->destroy();

            return redirect()->to('/login');
        }

        return view('dashboard/index', [
            'judul' => $namaDashboard[$role],
        ]);
    }
}
