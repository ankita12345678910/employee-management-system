<?php

namespace App\Models;

use CodeIgniter\Model;

class Employee extends Model
{
    protected $table = 'emp_details';
    protected $primaryKey = 'id'; // Foreign key to logindetails.id
    protected $allowedFields = ['id', 'name', 'address', 'designation', 'salary', 'picture'];

    protected $validationRules = [
        'name' => 'required',
        'address' => 'required',
        'designation' => 'required',
        'salary' => 'required',
        'picture' => 'permit_empty|alpha_numeric_punct'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required'
        ],
        'address' => [
            'required' => 'The address field is required'
        ],
        'designation' => [
            'required' => 'The designation field is required'
        ],
        'salary' => [
            'required' => 'The salary field is required'
        ],
    ];
}
