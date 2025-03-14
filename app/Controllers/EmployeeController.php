<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\LoginDetails;
use CodeIgniter\Controller;

class EmployeeController extends Controller
{
    public function dashboard(){
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('dashboard_view/',[
          'username'=>$session->get('username')  
        ]);
    }

    public function manageEmployee($id = 'new')
    {
        $data = [];
        $db = db_connect();
        helper(['form']);
        $sql = "select e.name as name,e.address as address ,e.designation,e.salary,e.picture,l.user_name as username,l.password from login_details as l , emp_details as e where l.id=e.id and l.id=?";
        $query = $db->query($sql, [$id]);
        $employee = $query->getRowArray();
        if (!$employee) {
            $employee = [];
        }

        $data = ['employee' => $employee, 'id' => $id];
        if ($this->request->getMethod() == 'POST') {
            $emp = new Employee();
            $login = new LoginDetails();
            if ($emp->validate($this->request->getPost())) {
                $data['validation'] = \Config\Services::validation();
            }

            $password = $this->request->getPost('password');
            $uploadPath = WRITEPATH . 'uploads/employees/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $picture = $this->request->getFile('picture');

            if ($picture && $picture->isValid() && !$picture->hasMoved()) {
                $newName = uniqid() . "-" . $picture->getClientName();
                $picture->move($uploadPath, $newName);
            }

            if ($this->request->getPost('password')) {
                $password = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
            } else {
                $password = $employee['password'];
            }

            $login_details = [
                'user_name' => $this->request->getPost('username'),
                'password' => $password,
                'name' => $this->request->getPost('name')
            ];
            $emp_details = [
                'name' => $this->request->getPost('name'),
                'address' => $this->request->getPost('address'),
                'designation' => $this->request->getPost('designation'),
                'salary' => $this->request->getPost('salary'),
                'picture' => isset($newName) ? $newName : ($id === 'new' ? null : $employee['picture'])

            ];

            if ($id === 'new') {
                $login->insert($login_details);
                $loginId = $login->getInsertID();
                $emp_details['id'] = $loginId;
                $emp->insert($emp_details);
            } else {
                $login->update($id, $login_details);
                $emp->update($id, $emp_details);
            }

            // return redirect()->to(route_to('employee_manage', $id));
            return redirect()->to(route_to('all_employee'));
        }
        return view('manage_employee', $data);
    }

    public function listEmployee()
    {
        $db = db_connect();
        $sql = "select l.id ,e.name as name,e.address,e.designation,e.salary,e.picture,l.user_name as username from login_details as l , emp_details as e where l.id=e.id";
        $query = $db->query($sql);
        $employees = $query->getResultArray();
        return view('list_employee', [
            'employees' => $employees
        ]);
    }
    public function deleteEmployee($id)
    {
        $db = db_connect();
        $db->table('login_details')->delete(['id' => $id]);
        return $this->response->setJSON(['success' => true]);
    }
}
