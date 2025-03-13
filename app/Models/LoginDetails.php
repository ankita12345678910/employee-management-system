<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginDetails extends Model
{
    protected $table = "login_details";
    protected $primaryKey = "id";
    protected $allowedFields = ['user_name', 'password', 'name'];

    protected $validationRules = [
        'user_name' => 'required|is_unique[login_details.user_name]',
        'password' => 'required|min_length[6]',
        'name' => 'required'
    ];

    protected $validationMessages = [
        'user_name' => [
            'required' => 'The username field is required',
            'is_unique' => 'This username is already taken. Please choose a different one.'
        ],
        'password' => [
            'required' => 'The password is required.',
            'min_length' => 'The password must be at least 6 characters long.'
        ],
    ];
}
