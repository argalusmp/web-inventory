<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $session;
    protected $data;
    protected $modelUser;


    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->data["session"] = $this->session;
        $this->modelUser = new UserModel();
    }

    public function index()
    {
        if ($this->session->isLoggedIn) {
            return redirect()->to('/');
        } else {
            return view('login/login');
        }
    }

    public function cekLogin()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $this->modelUser->where('email', $email)->first();

        if ($user) {
            if ($email == 'admin@gmail.com' && $password == 'admin') {
                $sessData = [
                    'id_user' => $user['id_user'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'user_type' => $user['user_type'],
                    'isLoggedIn' => TRUE,
                ];
                session()->set($sessData);
                return redirect()->to('/');
            } elseif (password_verify($password, $user['password'])) {
                $sessData = [
                    'id_user' => $user['id_user'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'user_type' => $user['user_type'],
                    'isLoggedIn' => TRUE,
                ];
                session()->set($sessData);
                return redirect()->to('/');
            } else {
                session()->setFlashdata('error_login', 'Wrong password');
                return redirect()->to('/login');
            }
        } else {
            session()->setFlashdata('error_login', 'Email not found');
            return redirect()->to('/login');
        }
    }

    public function registerPage()
    {
        return view('register/register');
    }

    public function register()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => 'Username sudah digunakan sebelumnya'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 50 Karakter',
                ]
            ],
            'email' => [
                'rules' => 'required|min_length[4]|max_length[100]|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 100 Karakter',
                    'is_unique' => 'Email sudah digunakan sebelumnya'
                ]
            ],
        ])) {
            session()->setFlashdata('error_register', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
        $users = new UserModel();
        $passhash = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        $users->insert([
            'email' => $this->request->getPost('email'),
            'password' => $passhash,
            'username' => $this->request->getPost('username'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('nohp'),
            'user_type' => 'user'
        ]);
        return redirect()->to('/login')->with('register_success', "Akun berhasil didaftar");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
