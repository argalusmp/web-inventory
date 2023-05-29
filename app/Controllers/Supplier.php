<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;

class Supplier extends BaseController
{
    protected $supplierModel;
    protected $session;
    protected $data;


    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->session = \Config\Services::session();
        $this->data["session"] = $this->session;
    }

    public function index()
    {
        $this->data['list'] = $this->supplierModel->findAll();
        echo view('template/header', $this->data);
        echo view('supplier/supplier', $this->data);
        echo view('template/footer');
    }

    //tambahUser
    public function tambahSupplier()
    {
        $dataUser = [
            'nama_supplier' => $this->request->getPost('namaSupplier'),
            'alamat' => $this->request->getPost('alamatSupplier'),
            'email' => $this->request->getPost('emailSupplier'),
        ];

        $query = $this->supplierModel->insert($dataUser);

        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_supplier', 'Data is inserted!');
            return redirect()->to('/supplier/supplier');
        } else {
            echo view('template/header', $this->data);
            echo view('supplier/supplier', $this->data);
            echo view('template/footer');
        }
    }

    public function editSupplier()
    {
        $dataUser = [
            'nama_supplier' => $this->request->getPost('namaSupplier'),
            'alamat' => $this->request->getPost('alamatSupplier'),
            'email' => $this->request->getPost('emailSupplier'),
        ];

        $query = $this->supplierModel->where('id_supplier', $this->request->getPost('IdSupplierEdit'))->set($dataUser)->update();

        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_supplier', 'Data is inserted!');
            return redirect()->to('/supplier/supplier');
        } else {
            echo view('template/header', $this->data);
            echo view('supplier/supplier', $this->data);
            echo view('template/footer');
        }
    }

    public function deleteSupplier()
    {

        $builder = $this->supplierModel->where('id_supplier', $this->request->getPost('IdSupplierHapus'));
        $query = $builder->delete();
        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_supplier', 'Selected Data is Delete!');
            return redirect()->to('/supplier/supplier');
        } else {
            echo view('template/header', $this->data);
            echo view('supplier/supplier', $this->data);
            echo view('template/footer');
        }
    }
}
