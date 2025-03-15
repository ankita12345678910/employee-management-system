<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {

        $employees = [
            ['username' => 'employee@1', 'password' => 'employee1', 'name' => 'T Sen', 'address' => 'Kolkata', 'designation' => 'Manager', 'salary' => 70000],
            ['username' => 'employee@2', 'password' => 'employee2', 'name' => 'M Das', 'address' => 'Howrah', 'designation' => 'Web Developer', 'salary' => 40000],
        ];

        foreach ($employees as $emp) {
            $loginData = ['user_name' => $emp['username'], 'password' => password_hash($emp['password'], PASSWORD_BCRYPT), 'name' => $emp['name']];
            $this->db->table('login_details')->insert($loginData);
            $loginId = $this->db->insertID();
            $emp['id'] = $loginId;
            unset($emp['username'], $emp['password']);

            $this->db->table('emp_details')->insert($emp);
        }
    }
}
