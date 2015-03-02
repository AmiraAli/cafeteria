<?php

require 'appconf.php';

/**
 * this class contain all orm of users
 */
class login_ORM {

    static $conn;
    private $dbconn;
    protected $table;
    private $_results;
    private $_count;
    private $_query;
    private $_errors;

    /**
     * static function to get instance of user_orm
     * @return type
     */
    static function getInstance() {
        if (self::$conn == null) {
            self::$conn = new login_ORM();
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
        return $state->fetch_object();
    }
      public function query($sql) {
        if ($this->_query = $this->dbconn->prepare($sql));
            if ($this->_query->execute()) {
                echo "sucess";
                $this->_results = $this->_query->fetch_array();
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_errors = TRUE;
            }

            return $this;
        
    }

    function select($values) {
        $query = "select * from " . $this->table . " where ";
        foreach ($values as $key => $value) {
            $query.=$key . " = '" . $value . "' and ";
        } $query = explode(" ", $query);
        unset($query[count($query) - 2]);
        $query = implode(" ", $query);
        $result = $this->dbconn->query(trim($query));
        return $result;
    }
    
     public function results() {
       return $this->_results;
    }

    public function count() {
        return $this->_count;
    }

    /**
     * deconstractor to close connection
     */
    function __destruct() {
        mysqli_close($this->dbconn);
    }

}
