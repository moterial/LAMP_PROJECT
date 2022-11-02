<?php

namespace App\Models;

use CodeIgniter\Model;

class UserDto extends Model
{

    protected $table = 'Users';
    protected $primaryKey = 'userId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true; //true --> not deleted but not show when query, false --> direct deleted
    //temp false for testing

    protected $allowedFields = ['ac', 'pw', 'email'];

    protected $useTimestamps = true;
    //temp false for testing
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    protected $registerValidationRules = [
        'ac' => [
            'label' => 'Account',
            'rules' => 'required|min_length[3]|max_length[20]|is_unique[Users.ac]',
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
            'rules' => 'required|valid_email|is_unique[Users.email]',
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

    protected $loginValidationRules = [
        'ac' => [
            'label' => 'Account',
            'rules' => 'required|is_not_unique[Users.ac]',
            'errors' => [
                'required' => '{field} is required.',
                'is_not_unique' => '{field} {value} does not exist.',
            ]
        ],
        'pw' => [
            'label' => 'Password',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
    ];

    function getRegisterValidationRules()
    {
        return $this->registerValidationRules;
    }

    function getLoginValidationRules()
    {
        return $this->loginValidationRules;
    }
    
}

?>