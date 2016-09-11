<?php
namespace Kernel;
use DB\DbCtrl;
class Model{

    protected $dbInstance;
    public $config;

    public function __construct(){
        $this->dbInstance = DbCtrl::connect($this->config['host'],$this->config['db'],$this->config['user'],$this->config['pwd']);
        $this->dbInstance->query("set names ".$this->config['charset']);
    }

    public function query($sql) {
        $stmt = $this->dbInstance->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function test(){
        /*$stmt = $this->dbInstance->prepare('select * from user where id = :id', array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
         $result = $stmt->execute(array(':id'=>2));
         while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            var_dump($row);
         }*/
        //$this->dbInstance->inquiry('select * from user limit 10',array());
        /*
        $id = 1;
        $ret = $this->dbInstance->query("select * from user where id = 1");
        while ($o = $ret->fetch(\PDO::FETCH_ASSOC))
        {
            var_dump($o);
        }
         */
        $id = 1;
       // var_dump($this->dbInstance->fetchOne("select * from user where id = 100"));
       // var_dump($this->dbInstance->insert("insert into `user`(`username`,`password`) value(?,?)","linyue","linyue"));
        //var_dump($this->dbInstance->query("select * from user where id in (1,2,3,4)"));
        //var_dump($this->dbInstance->update("update `user` set `username` = ? , `password` = ? where id = ?","linyue","linyue",1));
        // var_dump($this->dbInstance->up("update `user` set `username` = 'n' , `password` = '123321' where id = 1"));
        //var_dump($this->dbInstance->delete("delete from `user` where id = ?",1000011));
        //var_dump($this->dbInstance->del("delete from `user`  where id = 1000014"));

    }

    public function __destruct(){
    }
}
