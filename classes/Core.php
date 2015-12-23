<?php
class Core {
    public $objectuUrl;
    public $objectNavigation;

    public $_meta_title = 'E-com project';
    public $_meta_description = 'E-com project';
    public $_meta_keywords = 'E-com project';

    public function __construct(){
        $this->objectuUrl = new Url();
        $this->objectNavigation = new Navigation($this->objectuUrl);
    }

	public function run() {
		ob_start();
		switch($this->objectuUrl->module){
            case 'panel' :
                set_include_path(implode(PATH_SEPARATOR, [
                    realpath(ROOT_PATH . DS . 'admin' . DS . TEMPLATE_DIR),
                    realpath(ROOT_PATH . DS . 'admin' . DS . PAGES_DIR),
                    get_include_path()
                ]));
                require_once(ROOT_PATH . DS . 'admin' . DS.PAGES_DIR . DS . $this->objectuUrl->cpage . '.php');
                break;
            default:
                set_include_path(implode(PATH_SEPARATOR, [
                    realpath(ROOT_PATH . DS . TEMPLATE_DIR),
                    realpath(ROOT_PATH . DS . PAGES_DIR),
                    get_include_path()
                ]));
                require_once(ROOT_PATH . DS . PAGES_DIR . DS . $this->objectuUrl->cpage . '.php');
        }

		ob_get_flush();
	}

}