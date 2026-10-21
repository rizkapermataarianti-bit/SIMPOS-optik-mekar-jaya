<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, langsung ke dashboard.
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login');
    }

    public function prosesLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        // Periksa input kosong.
        if ($username === '' || $password === '') {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('error', 'Username dan password wajib diisi.');
        }

        $usersModel = new UsersModel();

        // Cari akun berdasarkan username.
        $user = $usersModel
            ->where('username', $username)
            ->first();

        // Tolak jika username tidak ditemukan.
        if (!$user) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Username atau password salah.');
        }

        // Tolak jika akun tidak aktif.
        if (($user['status'] ?? '') !== 'aktif') {
            return redirect()->to(site_url('login'))
                ->with('error', 'Akun tidak aktif.');
        }

        // Verifikasi password hash.
        $passwordTersimpan = (string) ($user['password'] ?? '');

        if (
            $passwordTersimpan === '' ||
            !password_verify($password, $passwordTersimpan)
        ) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Username atau password salah.');
        }

        // Periksa role akun.
        $rolesDiizinkan = ['kasir', 'admin_cabang', 'pemilik'];

        if (!in_array($user['role'] ?? '', $rolesDiizinkan, true)) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Peran akun tidak valid.');
        }

        // Kasir dan admin cabang harus memiliki cabang.
        if (
            in_array($user['role'], ['kasir', 'admin_cabang'], true) &&
            empty($user['cabang_id'])
        ) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Akun belum terhubung dengan cabang.');
        }

        // Buat sesi hanya setelah semua pemeriksaan berhasil.
        session()->regenerate(true);

        session()->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'role'       => $user['role'],
            'cabang_id'  => $user['cabang_id'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(site_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'))
            ->with('success', 'Kamu berhasil logout.');
    }
}
