<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {   
        //if user is not login, redirect to login page
        if (!session()->has('userId')) {
            return redirect()->to('/auth/login');
        }else{
            $taskDto = new \App\Models\TaskDto();
            $data['grid'] = $taskDto->getAllCategoryAndTask(session('userId'));
            return view('Dashboard/index', $data);
        }
        
        
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
        //check if user is manager
        $userDto = new \App\Models\UserDto();
        $userID = session()->get('userId');
        $userInfo = $userDto->find($userID);
        if($userInfo['privilege'] == 'manager' || $userInfo['privilege'] == 'admin'){
            $taskDto = new \App\Models\TaskDto();

            $categoryName = $this->request->getVar('categoryName');
            $values = [
                'role' => 'category',
                'content' => $categoryName,
                'userId' => session('userId'),
            ];

            $taskDto->insert($values);

            return redirect()->to('/Dashboard/index');
        }else{
            //if not manager, redirect to index with error message
            return redirect()->to('/Dashboard/index')->with('error', 'You are not manager');
        }

        
    }

    public function addTask()
    {   
        $userDto = new \App\Models\UserDto();
        $userID = session()->get('userId');
        $userInfo = $userDto->find($userID);
        if($userInfo['privilege'] == 'manager' || $userInfo['privilege'] == 'admin' ){
            $taskDto = new \App\Models\TaskDto();
            $categoryId = $this->request->getVar('categoryId'); //we can get categoryId of the task from website input field
            $taskName = $this->request->getVar('taskName'); //we can get taskName from website input field
            $values = [
                'role' => 'task',
                'content' => $taskName,
                'parentId' => $categoryId,
            ];

            $taskDto->insert($values);

            return redirect()->to('/Dashboard/index');
        }else{
            //if not manager, redirect to index with error message and log to the log table
            $logDto = new \App\Models\LogDto();
            $wrongInput = $this->request->getVar('taskName');
            //put all the params into the function and call it....
        
            return redirect()->to('/Dashboard/index')->with('error', 'You are not manager');
        }
    }

    public function completeTask()
    {
        $taskDto = new \App\Models\TaskDto();

        $taskId = $this->request->getVar('taskId');
        $values = [
            'finished' => '1',
        ];

        $taskDto->update($taskId, $values);


        return redirect()->to('/Dashboard/index');
    }

    public function deleteTask($taskid)
    {
        $userDto = new \App\Models\UserDto();
        $userID = session()->get('userId');
        $userInfo = $userDto->find($userID);
        if($userInfo['privilege'] == 'manager' || $userInfo['privilege'] == 'admin' ){
            $taskDto = new \App\Models\TaskDto();
            $taskId = $taskid;
            $taskDto->where('taskId', $taskId)->delete();

            //TODO delete task

            return redirect()->to('/Dashboard/index');
        }else{
            //if not manager, redirect to index with error message
            return redirect()->to('/Dashboard/index')->with('error', 'You are not manager');
        }
    }

    public function deleteCategory($catID){
        $userDto = new \App\Models\UserDto();
        $userID = session()->get('userId');
        $userInfo = $userDto->find($userID);
        if($userInfo['privilege'] == 'manager' || $userInfo['privilege'] == 'admin' ){
            $taskDto = new \App\Models\TaskDto();
            $catId = $catID;
            $taskDto->where('taskId', $catId)->delete();
            return redirect()->to('/Dashboard/index');
        }else{
            //if not manager, redirect to index with error message
            return redirect()->to('/Dashboard/index')->with('error', 'You are not manager');
        }
    }

}