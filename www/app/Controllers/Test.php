<?php

namespace App\Controllers;
use App\Libraries\Hash;

class Test extends BaseController
{
    public function index()
    {
        // $t = new \App\Models\TaskDto();
        // $q=$t->insert([
        //     'role' => 'category',
        //     'content' => 'test',
        //     'parentId' => 0,
        //     'userId' => 2,
        // ]);
        // $q = $t->listAllCategoryAndTaskByUserId(4);

        $userDto = new \App\Models\UserDto();
        $user = $userDto->where('ac', "jimmy")->first();
        session_unset();

        echo '<pre>' . var_export($user, true) . '</pre>';

        return view('Test/index');
    }
}
