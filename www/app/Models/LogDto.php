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
    public function writeToLog($userId, $content){
        //insert the content and userId into the log table using mysql statement.....
    //     // Create connection
    //     $conn = new mysqli($servername, $username, $password, $dbname);
    //     // Check connection
    //     if ($conn->connect_error) {
    //         die("Connection failed: " . $conn->connect_error);
    //     } 

    //    $sql = "INSERT INTO Logs ('eventId', 'userId', 'content', 'datetime') VALUES ($eventId, $userId, $content, $datetime)";

    //    if ($conn->query($sql) === TRUE) {
    //         echo "New record created successfully";
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //     }
    //     $conn->close();
        $this->insert(['userId' => $userId, 'content' => $content]); 
    }



}

?>