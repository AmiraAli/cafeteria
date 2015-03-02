<?php

require 'appconf.php';

/**
 * this class contain all orm of users
 */
class user_ORM {

    static $conn;
    private $dbconn;
    protected $table;

    /**
     * static function to get instance of user_orm
     * @return type
     */
    static function getInstance() {
        if (self::$conn == null) {
            self::$conn = new user_ORM();
        }
        return self::$conn;
    }

    /**
     * constractor to connect in database
     */
    function __construct() {

        extract($GLOBALS['conf']);
        $this->dbconn = new mysqli($host, $username, $password, $database);
    }

    /**
     * Get connection
     * @return type
     */
    function getConnection() {
        return $this->dbconn;
    }

    /**
     * function to set table name
     * @param type $table
     */
    function setTable($table) {
        $this->table = $table;
    }

    /**
     * this function used to insert query
     * @param type $data
     * @return type
     */
    function insert($data) {
        $query = "insert into $this->table set ";
        foreach ($data as $col => $value) {
            $query .= $col . "= '" . $value . "', ";
        }
        $query[strlen($query) - 2] = " ";
        $state = $this->dbconn->query($query);
        if (!$state) {
            return $this->dbconn->error;
        }

        return $this->dbconn->affected_rows;
    }

    /**
     * this function to select all query
     * @return type
     */
    function select_all() {
        $query = "select * from " . $this->table;
        $state = $this->dbconn->query($query);
        if (!$state) {
            return $this->dbconn->error;
        }
        return $state;
        
    }

    /**
     * Select last row of table with where condition
     * @return type
     */
    function select_last_row($values) {
        $query = "select * from " . $this->table . " where id = (SELECT MAX(id) FROM " . $this->table . ") and ";
        foreach ($values as $key => $value) {
            $query.=$key . " = '" . $value . "' and ";
        }
        $query = explode(" ", $query);
        unset($query[count($query) - 2]);
        $query = implode(" ", $query);
        $query.=" LIMIT 1";

        $state = $this->dbconn->query(trim($query));
        if (!$state) {
            return $this->dbconn->error;
        }
        return $state->fetch_assoc();
    }
    /**
     * Select with Where conditions
     * @param type $values
     * @return type
     */
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


    /**
     * deconstractor to close connection
     */
    function __destruct() {
        mysqli_close($this->dbconn);
    }

}
