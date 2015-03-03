<?php

require 'appconf.php';

class admin_ORM {

     static $conn;
    private $dbconn;
    protected $table;
    
    static function getInstance(){
        if(self::$conn == null){
            self::$conn = new admin_ORM();
        }
        return self::$conn;
    }
    
    function __construct() {
        
        extract($GLOBALS['conf']);
        $this->dbconn = new mysqli($host, $username, $password, $database);
        
    }
    
    function getConnection(){
        return $this->dbconn;
    }
    
    function setTable($table){
        $this->table = $table;
    }

     function insert($data){
        $query = "insert into $this->table set ";
        foreach ($data as $col => $value) {
            $query .= $col."= '".$value."', ";
            
        }
        $query[strlen($query)-2]=" ";
        $state = $this->dbconn->query($query);
        if(! $state){
            return $this->dbconn->error;
        }
        
        return $this->dbconn->affected_rows;
        
    }
    function __destruct() {
          mysqli_close($this->dbconn);
        
    }

}