<?php

namespace App\Models;

use CodeIgniter\Model;

class LogDto extends Model
{

    protected $table = 'Logs';
    protected $primaryKey = 'eventId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true; //true --> not deleted but not show when query, false --> direct deleted

    protected $allowedFields = ['userId', 'content'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at'; //auto add created time



    protected $skipValidation = true;

    function __construct()
    {
        parent::__construct();
    }
    


    // Can add some function here
    public function writeToLog($content,$userId){
       //insert the content and userId into the log table using mysql statement.....
    }



}

?>