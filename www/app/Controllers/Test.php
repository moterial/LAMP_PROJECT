<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        $t = new \App\Models\TaskDto();
        // $q=$t->insert([
        //     'role' => 'category',
        //     'content' => 'test',
        //     'parentId' => 0,
        //     'userId' => 2,
        // ]);
        $q = $t->listCategoryNameAndIdByUserId(4);

        echo '<pre>' . var_export($q, true) . '</pre>';

        return view('Test/index');
    }
}
