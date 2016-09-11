<?php
namespace app\test\controller;
use app\test\model\testModel;
use Kernel\Controller;
use Email\Email;
class testController extends Controller{

    public function def(){
        $model = new testModel();
        var_dump($model);
        //$model->test();
    }
    public function sendEmail(){
        var_dump(Email::sendEmail('',array('xxxx@qq.com','xxx@qq.com'),'hello world','hello world\n,this is a test<br /><h1>hahahah</h1>',0,false));
    }


}
