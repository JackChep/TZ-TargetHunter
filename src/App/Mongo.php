<?php

namespace App;

//require '..\vendor\autoload.php';

use MongoDB;

class Mongo{

    public $connect = false;
    
    public function __construct($server)
    {
        
        $this->connect = new MongoDB\Client($server);

    }

    public function insertMany($data){
        //создать исключение если нет такой базы и коллекции
        $collection = $this->connect->newdb->users;
        $collection = $collection->insertMany($data);
    }

}