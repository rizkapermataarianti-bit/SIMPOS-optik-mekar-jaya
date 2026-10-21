<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function prosesLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Username dan password wajib diisi.');
        }

        $userModel = new UserModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        if (!$user || $user['status'] !== 'aktif') {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Username atau password salah, atau akun tidak aktif.');
        }

        $storedPassword = (string) $user['password'];
        $passwordValid = password_verify($password, $storedPassword);

        if (!$passwordValid && hash_equals($storedPassword, $password)) {
            $passwordValid = true;

            $userModel->update($user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        if (!$passwordValid) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        $rolesDiizinkan = ['kasir', 'admin', 'pemilik'];

        if (!in_array($user['role'], $rolesDiizinkan, true)) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Peran akun tidak valid.');
        }

        if (
            in_array($user['role'], ['kasir', 'admin'], true) &&
            empty($user['cabang_id'])
        ) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Akun belum terhubung dengan cabang.');
        }

        session()->regenerate(true);

        session()->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'role'       => $user['role'],
            'cabang_id'  => $user['cabang_id'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'Kamu berhasil logout.');
    }
}
