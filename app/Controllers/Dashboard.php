<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Config\Services;
use PhpParser\Node\Stmt\Echo_;

class Dashboard extends BaseController
{
    protected $session;
    protected $data;
    protected $masukModel;
    protected $keluarModel;


    public function __construct()
    {
        $this->masukModel = new TransaksiMasuk();
        $this->keluarModel = new TransaksiKeluar();
        $this->session = Services::session();
        $this->data["session"] = $this->session;
    }

    public function index()
    {
        $pendapatanBulan = $this->keluarModel->selectSum('total_keluar', 'total_data')
            ->where('MONTH(tanggal_keluar)', date('m'))
            ->where('YEAR(tanggal_keluar)', date('Y'))
            ->get()
            ->getRow();

        $pendapatanTahun = $this->keluarModel->selectSum('total_keluar', 'total_data')
            ->where('YEAR(tanggal_keluar)', date('Y'))
            ->get()
            ->getRow();

        $totalBarangMasuk = $this->masukModel->selectSum('jumlah_barang', 'total_data')
            ->get()
            ->getRow();

        $totalBarangKeluar = $this->keluarModel->selectSum('jumlah_barang', 'total_data')
            ->get()
            ->getRow();

        $this->data['pendapatanBulanIni'] = $pendapatanBulan->total_data;
        $this->data['pendapatanTahunIni'] = $pendapatanTahun->total_data;
        $this->data['barangMasuk'] = $totalBarangMasuk->total_data;
        $this->data['barangKeluar'] = $totalBarangKeluar->total_data;

        echo view('template/header', $this->data);
        echo view('dashboard/index', $this->data);
        echo view('template/footer');
    }
}
