<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    protected $session;
    protected $data;


    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        $this->data["session"] = $this->session;
    }

    public function index()
    {
        $this->data['list'] = $this->userModel->findAll();
        echo view('template/header', $this->data);
        echo view('user/user', $this->data);
        echo view('template/footer');
    }

    //tambahUser
    public function tambahUser()
    {
        $dataUser = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('nohp'),
            'user_type' => $this->request->getPost('tingkatanUser'),
        ];

        $query = $this->userModel->insert($dataUser);

        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_user', 'Data is inserted!');
            return redirect()->to('/user/user');
        } else {
            echo view('template/header', $this->data);
            echo view('user/user', $this->data);
            echo view('template/footer');
        }
    }

    public function editUser()
    {
        $dataUser = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('nohp'),
            'user_type' => $this->request->getPost('tingkatanUser'),
        ];

        $query = $this->userModel->where('id_user', $this->request->getPost('IdUserEdit'))->set($dataUser)->update();

        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_user', 'Data is Updated!');
            return redirect()->to('/user/user');
        } else {
            echo view('template/header', $this->data);
            echo view('user/user', $this->data);
            echo view('template/footer');
        }
    }

    public function deleteUser()
    {

        $builder = $this->userModel->where('id_user', $this->request->getPost('IdUserHapus'));
        $query = $builder->delete();
        if ($query) {
            //berhasil
            $this->session->setFlashdata('success_user', 'Selected Data is Deleted!');
            return redirect()->to('/user/user');
        } else {
            echo view('template/header', $this->data);
            echo view('user/user', $this->data);
            echo view('template/footer');
        }
    }
}
