<?php
namespace Kernel;
use Email\Email;
//error_reporting(0);
class Cerror{

    public static function error_alert() {

        if(is_null($e = error_get_last()) === false){
        //    var_dump($e);
            set_error_handler('self::errorHandler');
            if($e['type'] == 1 || $e['type'] == 64){
               trigger_error("fatal error", E_USER_ERROR);
            }elseif($e['type'] == 8){
               trigger_error("notice", E_USER_NOTICE);
            }elseif($e['type'] == 2){
               trigger_error("warning", E_USER_WARNING);
            }else{
                trigger_error("other", $e['type']);
            }
        }

    }


    public static function errorHandler($errno, $errstr, $errfile, $errline,$errcontext) {
        switch ($errno) {
        case E_USER_ERROR:
            $content = $errcontext['e']['message']."<br /> in " .$errcontext['e']['file'] .' line '. $errcontext['e']['line'].' <br/> ';
            //Email::sendEmail('',array('418989069@qq.com','unuse@qq.com'),'Fatal error!',$content,0,False);
            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            break;

        case E_USER_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            echo "  warning on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            break;

        case E_USER_NOTICE:
             echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
             echo "  notice on line $errline in file $errfile";
             echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
             break;

        default:
            //$content = $errcontext['e']['message']."<br /> in " .$errcontext['e']['file'] .' line '. $errcontext['e']['line'].' <br/> ';
            //Email::sendEmail('',array('418989069@qq.com','unuse@qq.com'),'Unknown error!',$content,0,False);
             echo "Unknown error type: [$errno] $errstr<br />\n";
             echo "  warning on line $errline in file $errfile";
             echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
             break;
         }
        return true;
    }
}
