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
    
     function select_all() {
        $query = "select * from " . $this->table;
        $state = $this->dbconn->query($query);
        if (!$state) {
            return $this->dbconn->error;
        }
        return $state;
        
    }
    
    function select($values){
		$query="select * from ".$this->table." where ";
		foreach($values as $key =>$value)
		{
			$query.=$key." = '".$value."' and ";
		}
		$query=explode(" ",$query);
		unset($query[count($query)-2]);
		$query=implode(" ",$query);

		$result =  $this->dbconn->query(trim($query));

		return $result;

	}
    
    function setTable($table) {
        $this->table = $table;
    }
    
    function getConnection(){
        return $this->dbconn;
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
    
    
    function delete($values) {
        $query = "delete from " . $this->table . " where ";
        foreach ($values as $key => $value) {
            $query.=$key . " = '" . $value . "' and ";
        }
        $query = explode(" ", $query);
        unset($query[count($query) - 2]);
        $query = implode(" ", $query);

        $result = $this->dbconn->query(trim($query));

        if (!$result) {
            return $this->dbconn->error;
        }
    }
        
            function __destruct() {
          mysqli_close($this->dbconn);
        
    }
}
