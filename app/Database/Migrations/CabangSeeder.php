<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CabangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_cabang' => 'Pasar Raya 1',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'nama_cabang' => 'Pasar Raya 2',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'nama_cabang' => 'Pasar Raya 3',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'nama_cabang' => 'Pasar Raya 4',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'nama_cabang' => 'Pasar Raya 5',
                'alamat'      => 'Pasar Raya',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'nama_cabang' => 'Bandar Buat',
                'alamat'      => 'Bandar Buat',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
            [
                'nama_cabang' => 'Payakumbuh',
                'alamat'      => 'Payakumbuh',
                'telepon'     => '',
                'status'      => 'aktif',
            ],
        ];

        $this->db->table('cabang')->insertBatch($data);
    }
}
