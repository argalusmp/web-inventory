<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{

    protected $table            = 'barang';
    protected $allowedFields    = ['nama_barang', 'harga_beli', 'harga_jual', 'stock', 'id_supplier_barang', 'keterangan', 'kode_barang', 'gambar_barang'];
}
