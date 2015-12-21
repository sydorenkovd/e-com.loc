<?php

namespace SSD\Database;

use \PDO;
use \PDOExeption;
use SSD\Helper;
abstract class DataBase
{
    protected $_schema;
    protected $_hostname;
    protected $_database;
    protected $_username;
    protected $_password;

    private $_persistent = true;
    private $_fetchMode = PDO::FETCH_ASSOC;
    private $_driverOptions = [];
    private $_connectionString = null;
    private $_pdoObject = null;

    public $affectedRows;
    public $id;

    public function __construct(){
        $this->_connect();
    }
    private function _exceptionOutput($e = null, $message = null){
        if(is_object($e)){
            if(ENVIRONMENT == 1){
                return $e->getMessage();
            } else{
                return "<p>" . $message . "</p>";
            }
        }
    }
    public function setDriverOption($key = null, $value = null){
        $this->_driverOptions[$key] = $value;
    }
    private function _setConnection(){
        switch($this->_schema){
            case 'mysql':
                $this->_connectionString = "mysql:dbname={$this->_database};host={$this->_hostname}";
                break;
            case 'sqlite':
                $this->_connectionString = "sqlite:{$this->_database}";
                break;
            case 'pgsql':
                $this->_connectionString = "pgsql:dbname={$this->_database};host={$this->_hostname}";
                break;
        }
        $this->setDriverOption(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf-8");
        $this->setDriverOption(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($this->_persistent){
            $this->setDriverOption(PDO::ATTR_PERSISTENT, true);
        }

    }
    private function _connect(){
        $this->_setConnection();
        try{

            $this->_pdoObject = new PDO($this->_connectionString,
                $this->_username,
                $this->_password,
                $this->_driverOptions);
        } catch(\PDOException $e){
            echo $this->_exceptionOutput($e, 'There was a problem with the database connection');
        }
    }
    private function _query($sql = null, $params = null){
        if(!empty($sql)){
            if(!is_object($this->_pdoObject)){
                $this->_connect();
            }
            $statement = $this->_pdoObject->prepare($sql, $this->_driverOptions);
            if(!$statement){
                $errorInfo = $this->_pdoObject->errorInfo();
                throw new \PDOException("Database error {$errorInfo[0]} : {$errorInfo[2]}, driver error code is {$errorInfo[1]}");
            }
            $paramsConverted = [];
            $paramsConverted = is_array($params) ? $params : array($params);
        }
    }

}