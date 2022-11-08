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

    public function getCategoryIdByName($name)
    {
        return $this->where('content', $name)->select('taskId')->first();
    }

    public function listCategoryNameAndIdByUserId($userId)
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
        }
        return $this->where('userId', $ownerId)->select('content,taskId')->findAll();
    }

    public function listCategoryNameByOwnerId($userId)
    {
        return $this->where('userId', $userId)->select("content as 'categoryName'")->findAll();
    }

    public function listCategoryIdByOwnerId($userId)
    {
        return $this->where('userId', $userId)->select('taskId')->findAll();
    }

    public function listTaskByCategoryId($parentId)
    {
        return $this->where('parentId', $parentId)->findAll();
    }

    public function listTaskNameByCategoryId($parentId)
    {
        return $this->where('parentId', $parentId)->select("content as 'taskName'")->findAll();
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

            $categoryIdList = $this->listCategoryIdByOwnerId($ownerId);
            $categoryNameList = $this->listCategoryNameByOwnerId($ownerId);
            for ($i=0; $i < count($categoryIdList); $i++) {
                $categoryNameList[$i]['taskList'] = $this->listTaskNameByCategoryId($categoryIdList[$i]['taskId']);
            }

            return $categoryNameList;
        }
    }
}

?>