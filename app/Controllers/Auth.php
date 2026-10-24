<?php

namespace App\Controllers;

use App\Enums\Role;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Auth extends BaseController
{
    /**
     * Konfigurasi tiap halaman login.
     *
     * @var array<string, array{dokumen: string, judul: string, sub: string, chip: string, bantuan: string, aksi: string}>
     */
    private const HALAMAN = [
        'kasir' => [
            'dokumen' => 'Masuk Kasir',
            'judul'   => 'Selamat Datang',
            'sub'     => 'Silakan masuk untuk mengakses sistem kasir Optik Mekar Jaya.',
            'chip'    => 'Cabang mengikuti akun',
            'bantuan' => 'Hubungi admin di cabang atau tim IT.',
            'aksi'    => 'login',
        ],
        'admin' => [
            'dokumen' => 'Masuk Admin Cabang',
            'judul'   => 'Masuk sebagai Admin Cabang',
            'sub'     => 'Kelola produk, stok, dan pesanan untuk cabang Anda.',
            'chip'    => 'Cabang tetap, mengikuti akun',
            'bantuan' => 'Hubungi pemilik sistem atau tim IT.',
            'aksi'    => 'admin/login',
        ],
        'pemilik' => [
            'dokumen' => 'Masuk Pemilik',
            'judul'   => 'Masuk sebagai Pemilik',
            'sub'     => 'Pantau seluruh lokasi dan tentukan alokasi distribusi.',
            'chip'    => 'Seluruh cabang + Pusat',
            'bantuan' => 'Hubungi tim IT.',
            'aksi'    => 'owner/login',
        ],
    ];

    public function login(string $peran = 'kasir')
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $halaman = $this->halamanLogin($peran);

        return view('auth/login', [
            'judul'             => $halaman['dokumen'],
            'judulMasuk'        => $halaman['judul'],
            'subJudul'          => $halaman['sub'],
            'chipCabang'        => $halaman['chip'],
            'bantuan'           => $halaman['bantuan'],
            'aksiLogin'         => $halaman['aksi'],
            'usernameTersimpan' => (string) ($this->request->getCookie('simpos_username') ?? ''),
            'pesanError'        => session()->getFlashdata('error'),
            'pesanSukses'       => session()->getFlashdata('success'),
        ]);
    }

    public function prosesLogin(string $peran = 'kasir')
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $halaman = $this->halamanLogin($peran);

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->to($halaman['aksi'])
                ->withInput()
                ->with('error', 'Username dan password wajib diisi.');
        }

        $userModel = new UserModel();

        $user = $userModel
            ->where('username', $username)
            ->first();

        if (! $user || $user['status'] !== 'aktif') {
            return redirect()->to($halaman['aksi'])
                ->withInput()
                ->with('error', 'Username atau password salah, atau akun tidak aktif.');
        }

        $storedPassword = (string) $user['password'];
        $passwordValid  = password_verify($password, $storedPassword);

        if (! $passwordValid && hash_equals($storedPassword, $password)) {
            $passwordValid = true;

            // Password lama masih plaintext: simpan ulang lewat model
            // agar otomatis di-hash oleh UserModel::hashPassword().
            $userModel->update($user['id'], [
                'password' => $password,
            ]);
        }

        if (! $passwordValid) {
            return redirect()->to($halaman['aksi'])
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        $role = Role::tryFrom((string) $user['role']);

        if ($role === null) {
            return redirect()->to($halaman['aksi'])
                ->withInput()
                ->with('error', 'Peran akun tidak valid.');
        }

        if ($role->value !== $peran) {
            return redirect()->to($halaman['aksi'])
                ->withInput()
                ->with('error', 'Akun ini adalah akun ' . $role->label() . '. Silakan masuk melalui halaman login ' . $role->label() . '.');
        }

        if ($role->requiresCabang() && empty($user['cabang_id'])) {
            return redirect()->to($halaman['aksi'])
                ->withInput()
                ->with('error', 'Akun belum terhubung dengan cabang.');
        }

        session()->regenerate(true);

        session()->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'role'       => $role->value,
            'cabang_id'  => $user['cabang_id'],
            'isLoggedIn' => true,
        ]);

        $redirect = redirect()->to('/dashboard');

        if ($this->request->getPost('remember') !== null) {
            $redirect->setCookie([
                'name'     => 'simpos_username',
                'value'    => $user['username'],
                'expire'   => 30 * DAY,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        } else {
            $redirect->deleteCookie('simpos_username');
        }

        return $redirect;
    }

    public function logout()
    {
        $session = session();

        $session->remove([
            'user_id',
            'nama',
            'username',
            'role',
            'cabang_id',
            'isLoggedIn',
        ]);

        $session->regenerate(true);
        $session->setFlashdata('success', 'Kamu berhasil logout.');

        return redirect()->to('/login');
    }

    /**
     * @return array{dokumen: string, judul: string, sub: string, chip: string, bantuan: string, aksi: string}
     */
    private function halamanLogin(string $peran): array
    {
        if (! isset(self::HALAMAN[$peran])) {
            throw PageNotFoundException::forPageNotFound();
        }

        return self::HALAMAN[$peran];
    }
}
