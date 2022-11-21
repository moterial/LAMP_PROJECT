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

        $userDto = new \App\Models\UserDto();
        
        $validation =  $this->validate($userDto->getRegisterValidationRules());
        if (!$validation) {
            return view('Auth/register', [
                'validation' => $this->validator
            ]);
        } else {
            
            $ac = $this->request->getVar('ac');
            $email = $this->request->getVar('email');
            $pw = $this->request->getVar('pw');

            //prevent sql injection
            $ac = htmlspecialchars($ac);
            $email = htmlspecialchars($email);
            $pw = htmlspecialchars($pw);

            
            $values = [
                'ac' => $ac,
                'pw' => Hash::hash($pw),
                'email' => $email,
            ];
            
            $query = $userDto->insert($values);
            if ($query) {
                return redirect()->to('Auth/register')->with('success', 'You are successfully registered.');
            } else {
                return redirect()->back()->with('fail', 'Something went wrong');
            }

        }
    }

    public function validateLogin()
    {
        $userDto = new \App\Models\UserDto();
        $validation = $this->validate($userDto->getLoginValidationRules());

        if (!$validation) {
            return view('Auth/login', [ 'validation' => $this->validator]);
        } else {
            $ac = $this->request->getVar('ac');
            $pw = $this->request->getVar('pw');

            //prevent sql injection
            $ac = htmlspecialchars($ac);
            $pw = htmlspecialchars($pw);

            $userDto = new \App\Models\UserDto();
            $user = $userDto->where('ac', $ac)->first();

            if (Hash::verify($pw, $user['pw'])) {
                $sessionData = [
                    'userId' => $user['userId'],
                    'ac' => $user['ac'],
                    'email' => $user['email'],
                    'isLoggedIn' => true,
                    'privilege' => $user['privilege'],
                ];

                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('fail', 'Incorrect password.');
                return redirect()->to('Auth/login')->withInput();
            }
        }
        
    }

    public function logout()
    {
        if (session()->has('userId')) {
            session()->remove('userId');
            session()->remove('ac');
            session()->remove('email');
            session()->remove('isLoggedIn');
            session()->set('isLoggedIn', false);
        }
        return redirect()->to('/auth?access=out')->with('fail', 'You are successfully logged out.');
    }
}
