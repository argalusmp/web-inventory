<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiKeluar extends Model
{
    protected $table            = 'keluar';
    protected $allowedFields    = ['id_barang', 'tanggal_keluar', 'jumlah_barang', 'keterangan_keluar', 'total_keluar'];
}
