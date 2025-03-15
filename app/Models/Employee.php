<?php

namespace App\Models;

use CodeIgniter\Model;

class Employee extends Model
{
    protected $table = 'emp_details';
    protected $primaryKey = 'id'; // Foreign key to logindetails.id
    protected $allowedFields = ['id', 'name', 'address', 'designation', 'salary', 'picture'];
}
