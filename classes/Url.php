<?php

class Url
{
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

    public function __construct()
    {
        $this->process();
    }

    public function process()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (!empty($uri)) {
            $uriQ = explode('?', $uri);
            $uri = $uriQ[0];
            if (count($uriQ) > 1) {
                $this->stringRaw = $uriQ[1];
                $uriRaw = explode('&', $uriQ[1]);
                if (count($uriRaw) > 1) {
                    foreach ($uriRaw as $key => $row) {
                        $this->splitRaw($row);
                    }
                } else {
                    $this->splitRaw($uriRaw[0]);
                }
            }
            $uri = Helper::clearString($uri, PAGE_EXT);
            $firstChar = substr($uri, 0, 1);
            if ($firstChar == '/') {
                $uri = substr($uri, 1);
            }
            $lastChar = substr($uri, -1);
            if ($lastChar == '/') {
                $uri = substr($uri, 0, -1);
            }
            if (!empty($uri)) {
                $uri = explode('/', $uri);
                $first = array_shift($uri);
                if (in_array($first, $this->key_modules)) {
                    $this->module = $first;
                    $first = empty($uri) ? $this->main : array_shift($uri);
                }
                $this->main = $first;
                $this->cpage = $this->main;
                if (count($uri) > 1) {
                    $pairs = [];
                    foreach ($uri as $key => $value) {
                        $pairs[] = $value;
                        if (count($pairs) > 1) {
                            if (!Helper::isEmpty($pairs[1])) {
                                if ($pairs[0] == $this->key_page) {
                                    $this->cpage = $pairs[1];
                                } else if ($pairs[0] == 'c') {
                                    $this->c = $pairs[1];
                                } else if ($pairs[0] == 'a') {
                                    $this->a = $pairs[1];
                                }
                                $this->params[$pairs[0]] = $pairs[1];
                            }
                            $pairs = [];
                        }
                    }
                }
            }
        }
    }
    public function splitRow($item = null){
        if(!empty($item) && !is_array($item)){
            $itemRaw = explode('=', $item);
            if(count($itemRaw) > 1 && !Helper::isEmpty($itemRaw[1])){
                $this->paramsRaw[$itemRaw[0]] = $itemRaw[1];
            }
        }
    }
}