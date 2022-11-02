<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskDto extends Model
{

    protected $table = 'Tasks';
    protected $primaryKey = 'taskId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true; //true --> not deleted but not show when query, false --> direct deleted
    //temp false for testing

    protected $allowedFields = ['role', 'content', 'parentId', 'userId'];

    protected $useTimestamps = true;
    //temp false for testing
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = true;

    function __construct()
    {
        parent::__construct();
    }
    
    public function getCategoryOrTaskById($taskId)
    {
        return $this->where('taskId', $taskId)->first();
    }

    public function listCategoryIdByManagerId($userId)
    {
        return $this->where('userId', $userId)->select('taskId')->findAll();
    }

    public function listTaskByCategoryId($parentId)
    {
        return $this->where('parentId', $parentId)->findAll();
    }

    public function listAllCategoryAndTaskByUserId($userId)
    {
        $userDto = new \App\Models\UserDto();
        $user = $userDto->getUserInfoByUserId($userId);
        if ($user != null) {
            $userRole = $user['privilege'];

            if ($userRole == 'admin') {
                # code...
            }elseif ($userRole == 'manager') {
                $ownerId = $userId;
            }elseif ($userRole == 'user') {
                $ownerId = $user['parentId'];
            }

            $categoryList = $this->listCategoryIdByManagerId($ownerId);

            for ($i=0; $i < count($categoryList); $i++) {
                $categoryList[$i]['taskList'] = $this->listTaskByCategoryId($categoryList[$i]['taskId']);
            }

            return $categoryList;
        }
    }
}

?>