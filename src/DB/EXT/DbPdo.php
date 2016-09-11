<?php
namespace DB\EXT;

class DbPdo extends \PDO{
    

    private $cursor;
    
    /**
     *生成pdo实例
     *
     */
    public static function connect($host,$db,$user,$pwd,$port=3306){
        try{
            $instace = new self("mysql:host={$host};port={$port};dbname={$db}",$user,$pwd);
        }catch( \PDOException $Exception ) {
            //var_dump( $Exception->getMessage( ) , $Exception->getCode( ) );
            throw $Exception; 
            unset($instace);
            return false;
        }
        return $instace;
    }

    /**
     *查询
     *
     */
    public function inquiry($sql, $param){
        $this->cursor = parent::prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        $this->cursor->execute($param);
        return $cursor->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *查询一条
     */
    public function fetchOne($query){
        $result = $this->query($query);
        return empty($result) ? array() : $result[0];
    }

    /**
     *查询多条
     */
    public function query($query){ //secured query with prepare and execute
        $this->doit(func_get_args());
        return $this->cursor->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *插入
     */
    public function insert($query){ //secured query with prepare and execute
        $this->doit(func_get_args());
        return $this->lastInsertId();
    }

    /**
     *编辑
     */
    public function update($query){
        $this->doit(func_get_args());
    }
    public function up($sql){
        return $this->exec($sql);
    }
    public function doit($query){
        $sql = $query[0];
        array_shift($query); //first element is not an argument but the query itself, should removed
        $this->cursor = parent::prepare($sql);
        $result = $this->cursor->execute($query);
        if(!empty($this->cursor->errorInfo()[1])){
            var_dump($this->cursor->errorInfo());
        }
        return $result;
    }

    /**
     *删除
     */
    public function delete($query){
        $this->doit(func_get_args());
    }
    public function del($sql){
        return $this->exec($sql);
    }

    public function __destruct(){
        $this->cursor->closeCursor();
    }
}

