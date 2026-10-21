<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CabangSeeder extends Seeder
{
    public function run()
    {
        // Periksa apakah data cabang sudah tersedia.
        $jumlahCabang = $this->db
            ->table('cabang')
            ->countAllResults();

        if ($jumlahCabang > 0) {
            echo "Data cabang sudah tersedia. Seeder dilewati.\n";
            return;
        }

        // Data awal tujuh cabang Optik Mekar Jaya.
        $data = [
            [
                'kode_cabang' => 'CBG001',
                'nama_cabang' => 'Pasar Raya 1',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'kode_cabang' => 'CBG002',
                'nama_cabang' => 'Pasar Raya 2',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'kode_cabang' => 'CBG003',
                'nama_cabang' => 'Pasar Raya 3',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'kode_cabang' => 'CBG004',
                'nama_cabang' => 'Pasar Raya 4',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'kode_cabang' => 'CBG005',
                'nama_cabang' => 'Pasar Raya 5',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'kode_cabang' => 'CBG006',
                'nama_cabang' => 'Bandar Buat',
                'alamat'      => 'Bandar Buat',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'kode_cabang' => 'CBG007',
                'nama_cabang' => 'Payakumbuh',
                'alamat'      => 'Payakumbuh',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
        ];

        $this->db->table('cabang')->insertBatch($data);

        echo "Data tujuh cabang berhasil ditambahkan.\n";
    }
}
