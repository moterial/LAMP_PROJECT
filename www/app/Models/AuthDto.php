<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthDto extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ac', 'pw', 'email'];

    protected $validationRules = [
        'ac' => [
            'label' => 'Account',
            'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.ac]',
            'errors' => [
                'required' => '{field} is required.',
                'alpha_numeric_space' => '{field} only accepts alphanumeric characters and spaces.',
                'min_length' => '{field} must be at least {param} characters in length.',
                'max_length' => '{field} cannot exceed {param} characters in length.',
                'is_unique' => '{field} {value} already exists.',
            ]
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => '{field} is required.',
                'valid_email' => '{field} is not valid.',
                'is_unique' => '{field} {value} already exists.',
            ]
        ],
        'pw' => [
            'label' => 'Password',
            'rules' => 'required|min_length[6]|max_length[20]',
            'errors' => [
                'required' => '{field} is required.',
                'min_length' => '{field} must be at least {param} characters in length.',
                'max_length' => '{field} cannot exceed {param} characters in length.',
            ]
        ],
        'pw2' => [
            'label' => 'Password Confirmation',
            'rules' => 'required|matches[pw]',
            'errors' => [
                'required' => '{field} is required.',
                'matches' => '{field} does not match {param}.',
            ]
        ],
    ];
    
}

?>