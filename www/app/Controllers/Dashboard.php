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
        $authDto = new \App\Models\AuthDto();
        $userID = session()->get('userID');
        $userInfo = $authDto->find($userID);
        $data = [
            'userInfo' => $userInfo
        ];

        return view('Dashboard/profile', $data);
    }
}