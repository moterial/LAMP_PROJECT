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

    
    
}

?>