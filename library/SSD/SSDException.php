<?php

namespace SSD;
use \Exception;

class SSDException extends Exception
{
    private static function _isDevelopment(){
        return (ENVIRONMENT == 1);
    }
    public static function getOutput($e = null){
        if(is_object($e) && $e instanceof Exception){
            if(self::_isDevelopment()){
            $out = [];
                $out[] = "Message: " . $e->getMessage();
                $out[] = "File: " . $e->getFile();
                $out[] = "Line: " . $e->getLine();
                $out[] = "Code: " . $e->getCode();
                echo '<ul><li>' . implode('</li><li>',$out). '</li></ul>';
                exit();
            } else {
                echo "Please, contact us explaining what happened";
                exit();
            }
        }
    }

}