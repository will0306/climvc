<?php
namespace DB;
use DB\EXT\DbPdo;

class DbCtrl{

    public static $_instances = array();

    public static function connect($host, $db, $user, $pwd, $port=3306, $key='') {
        $key = empty($key) ? $host.$db.$user.$port : $key ;
        $instance = empty(self::$_instances[$key]) ? self::dbConnect($host, $db, $user, $pwd, $port) : self::$_instances[$key] ;
        self::$_instances[$key] = $instance;
        return $instance;
    }


    private static function dbConnect($host, $db, $user, $pwd, $port=3306) {
        return DbPdo::connect($host, $db, $user, $pwd, $port=3306);
    }

    static function test(){
        return "DbCtrl";
    }

}
