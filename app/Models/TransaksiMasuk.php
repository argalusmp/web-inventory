<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiMasuk extends Model
{
    protected $table            = 'masuk';
    protected $allowedFields    = ['id_barang', 'tanggal_masuk', 'jumlah_barang', 'keterangan_masuk', 'ppn_masuk', 'total_biaya_masuk'];
}
