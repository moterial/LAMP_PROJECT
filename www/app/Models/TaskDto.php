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

    protected $allowedFields = ['role', 'content', 'parentId', 'userId','finished'];


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
    
    public function getAllCategory(){
        return $this->where('role', 'category')->findAll();
    }

    public function getAllTaskByCategoryID($catID){
        //find all task by category id and role = task order by finished asc
        return $this->where('parentId', $catID)->where('role', 'task')->orderBy('finished', 'asc')->findAll();
    }


    public function getAllCategoryAndTask($userId)
    {
        $userDto = new \App\Models\UserDto();
        $user = $userDto->getUserInfoByUserId($userId);
        if ($user != null) {
            $categoryList = $this->getAllCategory();
            for ($i=0; $i < count($categoryList); $i++) {
                $categoryList[$i]['taskList'] = $this->getAllTaskByCategoryID($categoryList[$i]['taskId']);
            }
            return $categoryList;
        }
    }

}

?>