<?php

namespace SSD\Database;

use PDO;
use PDOExeption;
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

    public function __construct()
    {
        $this->_connect();
    }

    private function _exceptionOutput($e = null, $message = null)
    {
        if (is_object($e)) {
            if (ENVIRONMENT == 1) {
                return $e->getMessage();
            } else {
                return "<p>" . $message . "</p>";
            }
        }
    }

    public function setDriverOption($key = null, $value = null)
    {
        $this->_driverOptions[$key] = $value;
    }

    private function _setConnection()
    {
        switch ($this->_schema) {
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

        if ($this->_persistent) {
            $this->setDriverOption(PDO::ATTR_PERSISTENT, true);
        }

    }

    private function _connect()
    {
        $this->_setConnection();
        try {

            $this->_pdoObject = new PDO($this->_connectionString,
                $this->_username,
                $this->_password,
                $this->_driverOptions);
        } catch (\PDOException $e) {
            echo $this->_exceptionOutput($e, 'There was a problem with the database connection');
        }
    }

    private function _query($sql = null, $params = null)
    {
        if (!empty($sql)) {
            if (!is_object($this->_pdoObject)) {
                $this->_connect();
            }
            $statement = $this->_pdoObject->prepare($sql, $this->_driverOptions);
            if (!$statement) {
                $errorInfo = $this->_pdoObject->errorInfo();
                throw new \PDOException("Database error {$errorInfo[0]} : {$errorInfo[2]}, driver error code is {$errorInfo[1]}");
            }
            $paramsConverted = [];
            $paramsConverted = is_array($params) ? $params : array($params);

            if (!$statement->execute($paramsConverted) || $statement->errorCode() != '00000') {
                $errorInfo = $statement->errorInfo();
                throw new \PDOException("Database error {$errorInfo[0]} : {$errorInfo[2]}, driver error code is {$errorInfo[1]} <br> SQL: {$sql}");
            }
            $this->affectedRows = $statement->rowCount();
            return $statement;
        }
    }

    public function setFetchMode($fetchMode = null)
    {
        if (!empty($fetchMode)) {
            $this->_fetchMode = $fetchMode;
        }
    }

    public function getLastInsertId($sequenceName = null)
    {
        return $this->_pdoObject->lastInsertId($sequenceName);
    }

    public function fetchAll($sql = null, $params = null)
    {
        if (!empty($sql)) {
            try {
                $statement = $this->_query($sql, $params);
                return $statement->fetchAll($this->_fetchMode);

            } catch (\PDOException $e) {
                echo $this->_exceptionOutput($e, "Something wrong trying to fetch records");
            }
        }
        return false;
    }

    public function fetchOne($sql = null, $params = null)
    {
        if (!empty($sql)) {
            try {
                $statement = $this->_query($sql, $params);
                return $statement->fetch($this->_fetchMode);
            } catch (\PDOException $e) {
                echo $this->_exceptionOutput($e, "Something went wrong during fetch one record");
            }
        }
        return false;
    }

    public function execute($sql = null, $params = null)
    {
        if (!empty($sql)) {
            try {
                return $this->_query($sql, $params);
            } catch (\PDOException $e) {
                echo $this->_exceptionOutput($e, "Execution sql statement went wrong");
            }
        }
        return false;
    }

    private function _insert($array = null, $pre = null)
    {
        if (!empty($array) && is_array($array)) {
            $fields = $array;
            $holders = $array;
            $values = $array;
            foreach ($array as $key => $value) {
                $fields[] = !empty($pre) ? "`{$pre}.{$key}`" : "`{$key}`";
                $holders[] = "?";
                $values[] = $value;
            }
            return array($fields, $holders, $values);
        }
    }

    private function _updateArray($array = null, $pre = null)
    {
        if (!empty($array) && is_array($array)) {
        }
    }
}