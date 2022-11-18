<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $taskDto = new \App\Models\TaskDto();
        $data['grid'] = $taskDto->getAllCategoryAndTask(session('userId'));
        return view('Dashboard/index', $data);
    }

    public function profile()
    {
        $userDto = new \App\Models\UserDto();
        $userID = session()->get('userId');
        $userInfo = $userDto->find($userID);
        $data = [
            'userInfo' => $userInfo
        ];

        return view('Dashboard/profile', $data);
    }

    public function addCategory()
    {
        $taskDto = new \App\Models\TaskDto();

        $categoryName = $this->request->getVar('categoryName');
        $values = [
            'role' => 'category',
            'content' => $categoryName,
            'userId' => session('userId'),
        ];

        $taskDto->insert($values);

        return redirect()->to('/Dashboard/index');
    }

    public function addTask()
    {
        $taskDto = new \App\Models\TaskDto();

        $categoryId = $this->request->getVar('categoryName');
        $taskName = $this->request->getVar('taskName');
        $values = [
            'role' => 'task',
            'content' => $taskName,
            'parentId' => $categoryId,
        ];

        $taskDto->insert($values);

        return redirect()->to('/Dashboard/index');
    }

    public function completeTask()
    {
        $taskDto = new \App\Models\TaskDto();

        $categoryId = $this->request->getVar('categoryName');
        $taskName = $this->request->getVar('taskName');
        //TODO complete task

        return redirect()->to('/Dashboard/index');
    }

    public function deleteTask()
    {
        $taskDto = new \App\Models\TaskDto();

        $categoryId = $this->request->getVar('categoryName');
        $taskName = $this->request->getVar('taskName');
        //TODO delete task

        return redirect()->to('/Dashboard/index');
    }

}