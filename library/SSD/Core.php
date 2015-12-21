<?php
namespace SSD;

class Core {
    public $objUrl;
    public $objNavigation;
    public $objCurrency;
    public $objAdmin;

    public function __construct(){
        $this->objUrl = new \Url();
        $this->objNavigation = new \Navigation($this->objUrl);
        $this->objCurrency = new \Currency();
    }
	
	public function run() {
		ob_start();
		require_once(\Url::getPage());
		ob_get_flush();
	}

}