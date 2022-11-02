<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('Dashboard/index');
    }

    public function profile()
    {
        $userDto = new \App\Models\UserDto();
        $userID = session()->get('userID');
        $userInfo = $userDto->find($userID);
        $data = [
            'userInfo' => $userInfo
        ];

        return view('Dashboard/profile', $data);
    }
}