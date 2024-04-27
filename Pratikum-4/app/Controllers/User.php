<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();
        return view('user/index', compact('users', 'title'));
    }
    public function login()
    {
        helper(['form']);

        // Memeriksa apakah form telah disubmit dengan method POST
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Memeriksa apakah email dan password tersedia
            if ($email && is_string($password)) {
                $model = new UserModel();

                // Memeriksa apakah email ada di database
                $login = $model->where('useremail', $email)->first();
                if ($login) {
                    // Memeriksa password
                    $pass = $login['userpassword'];
                    if (is_string($pass) && password_verify($password, $pass)) {
                        $login_data = [
                            'user_id' => $login['id'],
                            'user_name' => $login['username'],
                            'user_email' => $login['useremail'],
                            'logged_in' => TRUE,
                        ];
                        session()->set($login_data);
                        return redirect()->to('admin/artikel');
                    } else {
                        session()->setFlashdata("flash_msg", "Password salah.");
                    }
                } else {
                    session()->setFlashdata("flash_msg", "Email tidak terdaftar.");
                }
            } else {
                session()->setFlashdata("flash_msg", "Email dan password harus diisi.");
            }
        }

        return view('user/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
