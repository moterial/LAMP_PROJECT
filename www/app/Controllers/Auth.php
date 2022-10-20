<?php

namespace App\Controllers;
use App\Libraries\Hash;

class Auth extends BaseController
{

    public function __construct()
    {
        helper(['url', 'auth']);
    }

    public function index()
    {
        return view('Auth/login');
    }

    public function register()
    {
        return view('Auth/register');
    }

    public function login()
    {
        return view('Auth/login');
    }

    public function validateRegister()
    {

        $authDto = new \App\Models\AuthDto();
        
        $validation =  $this->validate($authDto->getValidationRules());
        if (!$validation) {
            return view('Auth/register', [
                'validation' => $this->validator
            ]);
        } else {
            
            $ac = $this->request->getVar('ac');
            $email = $this->request->getVar('email');
            $pw = $this->request->getVar('pw');

            $values = [
                'ac' => $ac,
                'pw' => Hash::hash($pw),
                'email' => $email,
            ];
            
            // $query = $authDto->insert($values);  <-- default but not working
            $db = \Config\Database::connect();
            $query = $db->table('users')->insert($values);
            if ($query) {
                return redirect()->to('Auth/register')->with('success', 'You are successfully registered.');
            } else {
                return redirect()->back()->with('fail', 'Something went wrong');
            }

        }
    }

    public function validateLogin()
    {
        $validation = $this->validate([
            'ac' => [
                'label' => 'Account',
                'rules' => 'required|is_not_unique[users.ac]',
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
        ]);

        if (!$validation) {
            return view('Auth/login', [ 'validation' => $this->validator]);
        } else {
            $ac = $this->request->getVar('ac');
            $pw = $this->request->getVar('pw');

            $authDto = new \App\Models\AuthDto();
            $user = $authDto->where('ac', $ac)->first();

            if (Hash::verify($pw, $user['pw'])) {
                session()->set('userID', $user['id']);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('fail', 'Incorrect password.');
                return redirect()->to('/login')->withInput();
            }
        }
        
    }

    public function logout()
    {
        if (session()->has('userID')) {
            session()->remove('userID');
            return redirect()->to('/auth?access=out')->with('fail', 'You are successfully logged out.');
        }
    }
}
