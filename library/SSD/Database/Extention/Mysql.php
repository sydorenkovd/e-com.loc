<?php
namespace SSD\Database\Extension;

use SSD\Database\DataBase;

class MySql extends DataBase
{
    protected $_schema = 'mysql';
    protected $_host = DB_HOST;
    protected $_database = DB_NAME;
    protected $_username = DB_USER;
    protected $_password = DB_PASSWORD;

    public function __construct(array $array = null){
        if(!empty($array)){
            foreach($array as $key => $value){
                $this->{$key} = $value;
            }
        }
        parent::__construct();
    }

}