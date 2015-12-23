<?php
class Url{
    public $key_page = 'page';
    public $key_modules = ['panel'];
    public $module = 'front';
    public $main = 'index';
    public $cpage = 'index';
    public $c = 'login';
    public $a = 'index';
    public $params = [];
    public $paramsRaw = [];
    public $stringRaw;

    public function __construct(){
        $this->process();
    }
    public function process(){
        $uri = $_SERVER['REQUEST_URI'];
        if(!empty($uri)){
            $uriQ = explode('?', $uri);
            $uri = $uriQ[0];
            if(count($uriQ) > 1){
                $this->stringRaw = $uriQ[1];
                $uriRaw = explode('&', $uriQ[1]);
                if(count($uriRaw) > 1 ){
                    foreach($uriRaw as $key => $row){
                        $this->splitRaw($row);
                    }
                } else {
                    $this->splitRaw($uriRaw[0]);
                }
            }
        }
    }
 }