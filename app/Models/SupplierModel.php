<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table            = 'suppliers';
    protected $allowedFields    = ['nama_supplier', 'alamat', 'email'];
}
