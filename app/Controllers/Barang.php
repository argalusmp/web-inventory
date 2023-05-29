<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use Config\Services;

class Barang extends BaseController
{
    protected $session;
    protected $data;
    protected $barangModel;
    protected $supplierModel;
    protected $validation;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->supplierModel = new SupplierModel();
        $this->session = \Config\Services::session();
        $this->data["session"] = $this->session;
        $this->validation = Services::validation();
    }


    //list barang
    public function listBarang()
    {
        $this->data['list'] = $this->barangModel->select('*')->join('suppliers', 'suppliers.id_supplier = barang.id_supplier_barang')->findAll();
        $this->data['listSupplier'] = $this->supplierModel->findAll();
        echo view('template/header', $this->data);
        echo view('barang/barang', $this->data);
        echo view('template/footer');
    }

    //list stock barang
    public function listStock()
    {
        $this->data['listStock'] = $this->barangModel->select('*')->join('suppliers', 'suppliers.id_supplier = barang.id_supplier_barang')->findAll();
        echo view('template/header', $this->data);
        echo view('barang/stock', $this->data);
        echo view('template/footer');
    }

    //tambahBarang
    public function tambahBarang()
    {

        // Validasi file gambar
        $validateImage = $this->validate([
            'gambar' => [
                'uploaded[gambar]',
                'mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'max_size[gambar,2048]',
            ],
        ]);
        if ($validateImage) {
            $gambar = $this->request->getFile('gambar');

            // $resizeImg = \Config\Services::image()->withFile($gambar)->resize(150, 150, true, 'height');

            // Generate nama acak untuk file gambar
            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/uploads', $namaGambar);
            $dataBarang = [
                'nama_barang' => $this->request->getPost('namaBarang'),
                'harga_beli' => $this->request->getPost('hargaBeli'),
                'harga_jual' => $this->request->getPost('hargaJual'),
                'stock' => 0,
                'id_supplier_barang' => $this->request->getPost('supplier'),
                'keterangan' => $this->request->getPost('keterangan'),
                'kode_barang' => $this->request->getPost('kodeBarang'),
                'gambar_barang' => $namaGambar
            ];
            $query = $this->barangModel->insert($dataBarang);
            if ($query) {
                //berhasil
                $this->session->setFlashdata('success_barang', 'Data is inserted!');
                return redirect()->to('/barang/barang');
            } else {
                echo view('template/header', $this->data);
                echo view('barang/barang', $this->data);
                echo view('template/footer');
            }
        } else {
            //gambar tidak terverifikasi
            $this->session->setFlashdata('error_gambar', 'Gambar not Verified');
            return redirect()->to('/barang/barang');
        }
    }

    public function editBarang()
    {
        $dataBarang = [
            'id' => $this->request->getPost('IdBarangEdit'),
            'nama_barang' => $this->request->getPost('namaBarang'),
            'harga_beli' => $this->request->getPost('hargaBeli'),
            'harga_jual' => $this->request->getPost('hargaJual'),
            'kode_barang' => $this->request->getPost('kodeBarang')
        ];

        $query = $this->barangModel->where('id', $this->request->getPost('IdBarangEdit'))->set($dataBarang)->update();

        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_barang', 'Data is Updated!');
            return redirect()->to('/barang/barang');
        } else {
            echo view('template/header', $this->data);
            echo view('barang/barang', $this->data);
            echo view('template/footer');
        }
    }

    public function deleteBarang()
    {
        $barang = $this->barangModel->find($this->request->getPost('IdBarangHapus'));
        $namaGambar = $barang['gambar_barang'];
        $builder = $this->barangModel->where('id', $this->request->getPost('IdBarangHapus'));
        $query = $builder->delete();
        if ($query) {
            //berhasil
            $path = FCPATH . 'img/uploads/' . $namaGambar;
            if (is_file($path) &&  $namaGambar !== 'default_img.jpg') {
                unlink($path);
            }
            $this->session->setFlashdata('success_barang', 'Selected Data is Deleted!');
            return redirect()->to('/barang/barang');
        } else {
            echo view('template/header', $this->data);
            echo view('barang/barang', $this->data);
            echo view('template/footer');
        }
    }
}
