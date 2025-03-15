<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\LoginDetails;
use CodeIgniter\Controller;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
    }

    public function manageEmployee($id = 'new')
    {
        $session = session();
        // die(var_dump(!$session->get('logged_in')));
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        } else {

            $data = [];
            $db = db_connect();
            helper(['form', 'session']);
            $session = session();
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

                $existingUser = $db->query(
                    "SELECT id FROM login_details WHERE user_name = ? AND id != ?",
                    [$this->request->getPost('username'), $id]
                )->getRowArray();

                if ($existingUser) {
                    $session->setFlashdata('error', 'Username already exists! Choose a different one.');
                    return redirect()->back()->withInput();
                }
                if ($this->request->getPost('salary') < 0) {
                    $session->setFlashdata('error', 'Salary must be a positive value');
                    return redirect()->back()->withInput();
                }
                $password = $this->request->getPost('password');
                $uploadPath = FCPATH . 'uploads/employees/';
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
                    $session->setFlashdata('success', 'Employee added successfully');
                } else {
                    $login->update($id, $login_details);
                    $emp->update($id, $emp_details);
                    $session->setFlashdata('success', 'Employee updated successfully');
                }

                // return redirect()->to(route_to('employee_manage', $id));
                return redirect()->to(route_to('all_employees', 1));
            }
            return view('manage_employee', $data);
        }
    }

    public function listEmployee($page = 1)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
        $db = db_connect();
        $limit = 4;
        $offset = ($page - 1) * $limit;
        $total_row = model(LoginDetails::class)->findAll();
        $sql = "select l.id ,e.name as name,e.address,e.designation,e.salary,e.picture,l.user_name as username from login_details as l , emp_details as e where l.id=e.id order by l.id desc limit {$offset},{$limit}";
        $query = $db->query($sql);
        $employees = $query->getResultArray();
        $total_record = count($total_row);
        $total_page = ceil($total_record / $limit);
        return view('list_employees', [
            'employees' => $employees,
            'page' => $page,
            'totalPage' => $total_page,
            'offset' => $offset
        ]);
    }
    public function deleteEmployee($id)
    {
        $session = session();
        $current_id = $session->get('id');
        $db = db_connect();
        $employee = model(Employee::class)->where('id', $id)->first();

        if ($employee && !empty($employee['picture'])) {
            $imagePath = FCPATH . 'uploads/employees/' . $employee['picture'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $db->table('login_details')->delete(['id' => $id]);

        // If the logged-in user deleted themselves, destroy the session and redirect to login
        if ($current_id == $id) {
            $session->destroy();
            return $this->response->setJSON(['logout' => true]);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
