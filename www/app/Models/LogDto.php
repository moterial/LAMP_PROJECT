<?php

namespace App\Models;

use CodeIgniter\Model;

class LogDto extends Model
{

    protected $table = 'Logs';
    protected $primaryKey = 'eventId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['userId', 'content','created_at'];







    protected $skipValidation = true;

    function __construct()
    {
        parent::__construct();
    }
    


    // Can add some function here
    public function writeToLog($userId, $content){
        //get the current datetime as log time
        $date = date('Y-m-d H:i:s');
        $values = [
            'userId' => $userId,
            'content' => $content,
            'created_at' => $date,
        ];
        $this->insert($values);
        
    }

    public function getAllLog(){
        //get all log 3 days ago
        $date = date('Y-m-d H:i:s', strtotime('-3 days'));
        return $this->where('created_at >', $date)->findAll();
    }



}

?>