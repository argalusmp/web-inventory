<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;

class Transaksi extends BaseController
{
    protected $session;
    protected $data;
    protected $masukModel;
    protected $keluarModel;
    protected $barangModel;
    protected $idBarang;

    public function __construct()
    {
        $this->masukModel = new TransaksiMasuk();
        $this->keluarModel = new TransaksiKeluar();
        $this->barangModel = new BarangModel();
        $this->session = \Config\Services::session();
        $this->data["session"] = $this->session;
    }

    public function listMasuk()
    {
        $this->data['listMasuk'] = $this->masukModel->select('*')->join('barang', 'barang.id = masuk.id_barang')->join('suppliers', 'suppliers.id_supplier = barang.id_supplier_barang')->findAll();
        $this->data['listBarang'] = $this->barangModel->findAll();
        echo view('template/header', $this->data);
        echo view('transaksi/masuk', $this->data);
        echo view('template/footer');
    }

    public function listKeluar()
    {
        $this->data['listKeluar'] = $this->keluarModel->select('*')->join('barang', 'barang.id = keluar.id_barang')->join('suppliers', 'suppliers.id_supplier = barang.id_supplier_barang')->findAll();
        $this->data['listBarang'] = $this->barangModel->findAll();
        echo view('template/header', $this->data);
        echo view('transaksi/keluar', $this->data);
        echo view('template/footer');
    }

    // Controller Untuk Masukkkkkkkk
    public function tambahMasuk()
    {
        $this->data['barang'] = $this->barangModel->select('*')->where('id', $this->request->getPost('IdBarang'))->first();

        $dataBarang = [
            'id_barang' => $this->request->getPost('IdBarang'),
            'tanggal_masuk' => $this->request->getPost('tanggalMasuk'),
            'jumlah_barang' => $this->request->getPost('jumlahBarang'),
            'keterangan_masuk' => $this->request->getPost('keterangan'),
            'total_biaya_masuk' => $this->data['barang']['harga_beli'] * $this->request->getPost('jumlahBarang')
        ];

        $query = $this->masukModel->insert($dataBarang);

        $addStock = $this->data['barang']['stock'] + $this->request->getPost('jumlahBarang');
        $updateStock = $this->barangModel->where('id', $this->request->getPost('IdBarang'))->set('stock', $addStock)->update();


        if ($query && $updateStock) {
            //berhasil
            $this->session->setFlashdata('success_masuk', 'Data is inserted!');
            return redirect()->to('/barang/masuk');
        } else {
            echo view('template/header', $this->data);
            echo view('transaksi/masuk', $this->data);
            echo view('template/footer');
        }
    }

    public function editMasuk()
    {
        $this->data['barang'] = $this->barangModel->select('*')->where('id', $this->request->getPost('IdBarang'))->first();
        $this->data['masuk'] = $this->masukModel->select('*')->where('id_masuk', $this->request->getPost('IdBarangMasuk'))->first();


        $jumlahBarangMasukSebelum = $this->data['masuk']['jumlah_barang'];
        $jumlahBarang = $this->request->getPost('jumlahBarang');
        $stock = $this->data['barang']['stock'];
        $keterangan = $this->request->getPost('keterangan');
        $tanggalMasuk = $this->request->getPost('tanggalMasuk');
        $total_biaya =  $this->data['barang']['harga_beli'] * $jumlahBarang;

        if ($jumlahBarang > $jumlahBarangMasukSebelum) {
            $selisih = $jumlahBarang - $jumlahBarangMasukSebelum;
            $kurangi = $stock + $selisih;
            $kurangiStock = $this->barangModel->where('id', $this->request->getPost('IdBarang'))->set('stock', $kurangi)->update();

            $updateMasuk = $this->masukModel->where('id_masuk', $this->request->getPost('IdBarangMasuk'))
                ->set([
                    'jumlah_barang' => $jumlahBarang,
                    'keterangan_masuk' => $keterangan,
                    'tanggal_masuk' => $tanggalMasuk,
                    'total_biaya_masuk' => $total_biaya
                ])
                ->update();


            if ($updateMasuk && $kurangiStock) {
                //berhasil
                $this->session->setFlashdata('success_masuk', 'Edit Data Success!');
                return redirect()->to('/barang/masuk');
            } else {
                echo view('template/header', $this->data);
                echo view('transaksi/masuk', $this->data);
                echo view('template/footer');
            }
        } else {
            $selisih = $jumlahBarangMasukSebelum - $jumlahBarang;
            $kurangi = $stock - $selisih;
            $kurangiStock = $this->barangModel->where('id', $this->request->getPost('IdBarang'))->set('stock', $kurangi)->update();
            $updateMasuk = $this->masukModel->where('id_masuk', $this->request->getPost('IdBarangMasuk'))
                ->set([
                    'jumlah_barang' => $jumlahBarang,
                    'keterangan_masuk' => $keterangan,
                    'tanggal_masuk' => $tanggalMasuk,
                    'total_biaya_masuk' => $total_biaya
                ])
                ->update();


            if ($updateMasuk && $kurangiStock) {
                //berhasil
                $this->session->setFlashdata('success_masuk', 'Edit Data Success!');
                return redirect()->to('/barang/masuk');
            } else {
                echo view('template/header', $this->data);
                echo view('transaksi/masuk', $this->data);
                echo view('template/footer');
            }
        }
    }

    public function deleteMasuk()
    {
        $this->data['barang'] = $this->barangModel->select('*')->where('id', $this->request->getPost('IdBarang'))->first();
        $this->data['masuk'] = $this->masukModel->select('*')->where('id_masuk', $this->request->getPost('IdBarangMasuk'))->first();

        $builder = $this->masukModel->where('id_masuk', $this->request->getPost('IdBarangMasuk'));
        $stock = $this->data['barang']['stock'];
        $jumlahBarang = $this->request->getPost('jumlahBarang');
        $kurangi = $stock - $jumlahBarang;
        $kurangiStock = $this->barangModel->where('id', $this->request->getPost('IdBarang'))->set('stock', $kurangi)->update();
        $query = $builder->delete();

        if ($query && $kurangiStock) {
            //berhasil
            $this->session->setFlashdata('success_masuk', 'Selected Data is Deleted!');
            return redirect()->to('/barang/masuk');
        } else {
            echo view('template/header', $this->data);
            echo view('transaksi/masuk', $this->data);
            echo view('template/footer');
        }
    }

    // akhir controller masukkk

    //Controller Untuk Keluar

    //Tambah Keluar
    public function tambahKeluar()
    {
        $this->data['barang'] = $this->barangModel->select('*')->where('id', $this->request->getPost('IdBarang'))->first();
        $stock =  $this->data['barang']['stock'];
        $hargaJual = $this->data['barang']['harga_jual'];


        $jumlah = $this->request->getPost('jumlahBarang');
        $totalhargaJual = $hargaJual * $jumlah;
        $dataBarang = [
            'id_barang' => $this->request->getPost('IdBarang'),
            'tanggal_keluar' => $this->request->getPost('tanggalKeluar'),
            'jumlah_barang' => $this->request->getPost('jumlahBarang'),
            'keterangan_masuk' => $this->request->getPost('keterangan'),
            'total_keluar' => $totalhargaJual
        ];

        if ($stock >= $jumlah) {
            $kurangiStock = $stock - $jumlah;

            $tambahBarangKeluar = $this->keluarModel->insert($dataBarang);

            //Update Jumlah Stock
            $updateStock = $this->barangModel->where('id', $this->request->getPost('IdBarang'))->set('stock', $kurangiStock)->update();

            if ($tambahBarangKeluar && $updateStock) {
                //berhasil
                $this->session->setFlashdata('success_keluar', 'Data is inserted!');
                return redirect()->to('/barang/keluar');
            } else {
                echo view('template/header', $this->data);
                echo view('transaksi/keluar', $this->data);
                echo view('template/footer');
            }
        } else {
            $this->session->setFlashdata('error_keluar', 'Stok tidak mencukupi!');
            return redirect()->to('/barang/keluar');
        }
    }

    //Edit Keluar
    public function editKeluar($id_keluar, $id_barang)
    {
        $this->data['barang'] = $this->barangModel->select('*')->where('id', $id_barang)->first();
        $this->data['keluar'] = $this->keluarModel->select('*')->where('id_keluar', $id_keluar)->first();

        $jumlahBarangKeluarSebelum = $this->data['keluar']['jumlah_barang'];
        $jumlahBarang = $this->request->getPost('jumlahBarang');
        $stock = $this->data['barang']['stock'];
        $hargaJual = $this->data['barang']['harga_jual'];
        $totalKeluar = $jumlahBarang * $hargaJual;

        if ($jumlahBarang > $jumlahBarangKeluarSebelum) {
            $selisih = $jumlahBarang - $jumlahBarangKeluarSebelum;
            $kurangi = $stock - $selisih;
            if ($selisih <= $stock) {
                $kurangiStock = $this->barangModel->where('id', $id_barang)->set('stock', $kurangi)->update();
                $updateKeluar = $this->keluarModel->where('id_keluar', $id_keluar)
                    ->set([
                        'tanggal_keluar' => $this->request->getPost('tanggalKeluar'),
                        'jumlah_barang' => $jumlahBarang,
                        'keterangan_keluar' => $this->request->getPost('keterangan'),
                        'total_keluar' => $totalKeluar
                    ])->update();
                if ($updateKeluar && $kurangiStock) {
                    //berhasil
                    $this->session->setFlashdata('success_keluar', 'Data is Updated!');
                    return redirect()->to('/barang/keluar');
                } else {
                    echo view('template/header', $this->data);
                    echo view('transaksi/keluar', $this->data);
                    echo view('template/footer');
                }
            } else {
                $this->session->setFlashdata('error_keluar', 'Stok tidak mencukupi!');
                return redirect()->to('/barang/keluar');
            }
        } else {
            $selisih = $jumlahBarangKeluarSebelum - $jumlahBarang;
            $kurangi = $stock + $selisih;
            $kurangiStock = $this->barangModel->where('id', $id_barang)->set('stock', $kurangi)->update();
            $updateKeluar = $this->keluarModel->where('id_keluar', $id_keluar)
                ->set([
                    'tanggal_keluar' => $this->request->getPost('tanggalKeluar'),
                    'jumlah_barang' => $jumlahBarang,
                    'keterangan_keluar' => $this->request->getPost('keterangan'),
                    'total_keluar' => $totalKeluar
                ])->update();
            if ($updateKeluar && $kurangiStock) {
                //berhasil
                $this->session->setFlashdata('success_keluar', 'Data is Updated!');
                return redirect()->to('/barang/keluar');
            } else {
                echo view('template/header', $this->data);
                echo view('transaksi/keluar', $this->data);
                echo view('template/footer');
            }
        }
    }

    //Delete Keluar
    public function deleteKeluar($id_keluar, $id_barang)
    {
        $this->data['barang'] = $this->barangModel->select('*')->where('id', $id_barang)->first();
        $this->data['keluar'] = $this->keluarModel->select('*')->where('id_keluar', $id_keluar)->first();

        $jumlahBarangKeluarSebelum = $this->data['keluar']['jumlah_barang'];
        $stock = $this->data['barang']['stock'];

        $updateStock = $stock + $jumlahBarangKeluarSebelum;
        $updateStockBarang = $this->barangModel->where('id', $id_barang)->set('stock', $updateStock)->update();

        $hapusBarangKeluar = $this->keluarModel->where('id_keluar', $id_keluar)->delete();

        if ($updateStockBarang && $hapusBarangKeluar) {
            //berhasil
            $this->session->setFlashdata('success_keluar', 'Data is deleted!');
            return redirect()->to('/barang/keluar');
        } else {
            echo view('template/header', $this->data);
            echo view('transaksi/keluar', $this->data);
            echo view('template/footer');
        }
    }

    // akhir controller keluar
}
