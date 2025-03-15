<?php

namespace App\Controllers;

use App\Models\LoginDetails;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() == 'POST') {
            $session = session();
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $employee = model(LoginDetails::class)->where('user_name', $username)->first();
            if ($employee && password_verify($password, $employee['password'])) {
                $session->set([
                    'id' => $employee['id'],
                    'username' => $employee['user_name'],
                    'logged_in' => true
                ]);
                // die(var_dump($session->get()));
                // return view('dashboard_view', [
                //     'username' => $session->get('username')
                // ]);
                return redirect()->to(route_to('all_employees', 1));
            } else {
                $session->setFlashdata('error', 'Invalid Username or Password');
                return redirect()->to('login');
            }
        }
        return view('auth/login');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
