<?php
class Navigation{
    public $objUrl;
    public $classActive = 'act';

    public function __construct($objUrl = null){
        $this->objUrl = is_object($objUrl) ? $objUrl : new Url();
    }
    public function active($main = null, $pairs = null, $single = null){
        if(!empty($main)){
            if(empty($pairs)){
                if($main == $this->objUrl->main){
                    return !$single ? ' ' . $this->classActive : ' class="' . $this->classActive . '"';
                }
            } else {
                $exceptions = [];
                foreach($pairs as $key => $value){
                    $paramsUrl = $this->objUrl->get($key);
                    if($paramsUrl != $value){
                        $exceptions[] = $key;
                    }
                }
                if($main == $this->objUrl->main && empty($exceptions)){
                    return !$single ? ' ' . $this->classActive : ' class="' . $this->classActive . '"';
                }
            }
        }
    }
}