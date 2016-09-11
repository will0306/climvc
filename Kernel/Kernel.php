<?php
//include_once('./autoloader.php');
include_once(dirname(__FILE__).'/autoloader.php');
register_shutdown_function('Kernel\Cerror::error_alert');
class Kernel{

    private static $_m;
    private static $_c;
    private static $_a;

    public static function work(){
        if("cli" == php_sapi_name()){
            $params = getopt("m:c:a:p:");
        } else {
            $params = $_REQUEST;
        }
        empty($params['m']) ? die("error:Please specify the module to run\n") : self::$_m = $params['m'];
        empty($params['c']) ? die("error:Please specify the controller to run\n") : self::$_c = $params['c'].'Controller';
        self::$_a = empty($params['a']) ? 'def' : $params['a'];
        $controller = 'app\\' . self::$_m . '\\controller\\' . self::$_c;
        $c = new $controller();
        $c->params = $params;
        $method = self::$_a;
        method_exists($c, $method) ? $c->$method($params) : die("method not exists!\n");
    }

    public function end(){

    }
}
