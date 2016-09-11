<?php
namespace Kernel;
use Kernel\Model;
use Config\db;
class BModel extends Model{
    
    public function __construct($key = '') {
        $this->__init();
        $key = empty($key) ? 'default' : $key ;
        if( empty(property_exists('Config\db',$key))) 
            return false;
        $this->config = db::$$key ;
        parent::__construct();
    }

    public function __init(){
    }

}
