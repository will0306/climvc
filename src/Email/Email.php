<?php
namespace Email;
use Email\EXT\Smtp;
use Config\email as cemail;
/**
 * 邮件发送
 *
 * @param: $name[string]        接收人姓名
 * @param: $email[string]       接收人邮件地址
 * @param: $subject[string]     邮件标题
 * @param: $content[string]     邮件内容
 * @param: $type[int]           0 普通邮件， 1 HTML邮件
 * @param: $notification[bool]  true 要求回执， false 不用回执
 *
 * @return boolean
 */
class Email{
    public static function sendEmail($name, $email, $subject, $content, $type = 0, $notification=false,$from = '') {

        if(empty($email)) return false;
        $reciver = '';
        if(is_array($email)) {
            foreach($email as $v){
                $reciver .= '<' . $v . '>;';
            }
        } else {
            $reciver .= '<' . $email . '>;';
        }
        /*
        $charset   = "utf-8";
        $smtp_mail = 'linyuewill@163.com';
        $port = "25";
        $host = 'smtp.163.com';
        $password = 'will0306';
        $smtp_ssl = 0;
        */
        $charset = cemail::$smtp_charset;
        $smtp_mail = cemail::$smtp_mail;
        $port = cemail::$smtp_port;
        $host = cemail::$smtp_host;
        $password = cemail::$smtp_pwd;
        $smtp_ssl = cemail::$smtp_ssl;
        $shop_name = $subject;
        $from = empty($from) ? cemail::$smtp_from : $from ;
        /* 邮件的头部信息 */
        //$content_type = ($type == 0) ? 'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
        $content_type = 'Content-Type: text/html; charset=' . $charset;
        $content   =  base64_encode($content);
        $headers = array();
        $headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
        $headers[] = 'To: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" '.$reciver;
        //$headers[] = 'CC: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" <544457252@qq.com>';
        $headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode($subject) . '?='.'" <'.$smtp_mail.'>';
        $headers[] = 'Subject: ' . '=?' . $charset . '?B?' . base64_encode($subject) . '?=';
        $headers[] = $content_type . '; format=flowed';
        $headers[] = 'Content-Transfer-Encoding: base64';
        $headers[] = 'Content-Disposition: inline';
        if ($notification) {
            $headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'"<'.$smtp_mail.'>';
        }

        /* 获得邮件服务器的参数设置 */
        $params['host'] = $host;
        $params['port'] = $port;
        $params['user'] = $smtp_mail;
        $params['pass'] = $password;
        $params['smtp_ssl'] = $smtp_ssl;

        if (empty($params['host']) || empty($params['port'])) {
            // 如果没有设置主机和端口直接返回 false
            echo "邮箱没有设置主机和端口";

            return false;
        } else {
            // 发送邮件
            if (!function_exists('fsockopen')) {
                //如果fsockopen被禁用，直接返回
                echo "fsockopen被禁用";

                return false;
            }

            static $smtp;

            $send_params['recipients'] = $email;
            $send_params['headers']    = $headers;
            $send_params['from']       = $smtp_mail;
            $send_params['body']       = $content;

            if (!isset($smtp)) {
                $smtp = new Smtp($params);
            }

            if ($smtp->connect() && $smtp->send($send_params)) {
                return true;
            } else {
            $err_msg = $smtp->error_msg();
            if (empty($err_msg)) {
                    //$GLOBALS['err']->add('Unknown Error');
                    echo "Unknown Error";
            } else {
                    if (strpos($err_msg, 'Failed to connect to server') !== false){
                            //$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['smtp_connect_failure'], $params['host'] . ':' . $params['port']));
                            echo 'smtp_connect_failure,'.$params['host'] . ':' . $params['port'];
                    } else if (strpos($err_msg, 'AUTH command failed') !== false) {
                            //$GLOBALS['err']->add($GLOBALS['_LANG']['smtp_login_failure']);
                            echo 'smtp_login_failure';
                    } elseif (strpos($err_msg, 'bad sequence of commands') !== false) {
                            //$GLOBALS['err']->add($GLOBALS['_LANG']['smtp_refuse']);
                            echo 'smtp_refuse';
                    } else {
                            //$GLOBALS['err']->add($err_msg);
                            echo $err_msg;
                    }
                }

                return false;
            }
        }
    }
}
