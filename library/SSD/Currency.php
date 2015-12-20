<?php
namespace SSD;
use \Exception;
class Currency{
    private $_list = [
        'USD' => [
            'symbol'=>'$',
            'html' => '&#36'
    ]];
    private $_default = 'USD';
    private $_index;

    public $code;
    public $symbol;
    public $html;

    public function __construct(){
        $this->_process();
    }
    public function display($value = null){
        switch($this->_index){
            case 'USD':
                return $this->symbol.$value;
            break;
        }
    }
    private function _codeExists($code = null){
        return (!empty($code) && array_key_exists($code, $this->_list));
    }
    private function _getCurrentIndex(){
        try{
            $this->_index = $this->_default;
            if(!$this->_codeExists($this->_index)){
                throw new Exception("The currency code could not be found");

            }
        } catch(Exception $e){
            $e->getMessage();
            exit();
        }
    }
    private function _process(){
        $this->_getCurrentIndex();
        $this->code = $this->_index;
        $this->symbol = $this->_list[$this->_index]['symbol'];
        $this->html = $this->_list[$this->_index]['html'];
    }

}