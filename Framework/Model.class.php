<?php

class Model {
    //取得db类事例 
    protected   $db;
    //声明属性保存所有字段名
    private $fields=array();
    //构造函数实例化db
    public function __construct() {
        //引入db类;
//        require "./Framework/Tool/DB.class.php";
        // 取得实例
        $this->db=DB::getInstance($GLOBALS["config"]["db"]);
        //调用保存字段名的方法
        $this->getFields();
    }
    //取得表名
    protected function getTable(){
        //  事例取得类名
        $tableName =  get_class($this);
        //去掉Model
        $tableName=substr($tableName,0,-5);
        return "`$tableName`";        
    }
    //声明一个方法取得所有字段名
    private function getFields(){
        $sql="desc {$this->getTable()}";
        $rows=$this->db->fetchAll($sql);
        // 遍历数据 取出字段名 对主键单独表示
        foreach($rows as $row){
            if($row["Key"]=="PRI"){
                $this->fields["pk"]=$row["Field"];
            }else{
                $this->fields[]=$row["Field"];
            }
        }
    }
    
    //查询所有数据
    protected function getAll($fields="*",$condition=""){
        if(empty($condition)){
        //构建sql
            $sql="select $fields from {$this->getTable()}";
        }else{
            $sql="select $fields from {$this->getTable()} where $condition";
        }
        return $this->db->fetchAll($sql);
    }

    //构建方法分页读取数据
    protected  function getPage($page,$pageSize,$fields="*",$condition=""){
        //求取开始位置
        $start = ($page - 1) * $pageSize;
        if (empty($condition)) {
            //构建sql
            $sql = "select $fields from {$this->getTable()} limit $start,$pageSize";
        } else {
            $sql = "select $fields from {$this->getTable()} where $condition  limit $start,$pageSize";
        }
        return $this->db->fetchAll($sql);
    }

    // 按主键查找一条数据
    protected function getRowByPk($val,$fields="*"){
        $sql="select $fields from {$this->getTable()} where `{$this->fields['pk']}`='$val'";
        // 执行语句
        return $this->db->fetchRow($sql);
    }
    //按照主键删除一条数据
    protected function deleteRowByPk($val){
        $sql="delete from {$this->getTable()} where `{$this->fields['pk']}`='$val'";
//        echo $sql;exit;
        // 执行
        return $this->db->query($sql);
    }
     // 过滤有效的字段 删除无效的字段
     private function  filterFileds(&$data){
         //遍历$data
         foreach($data as $key=>$val){
             if(!in_array($key, $this->fields)){
                 //删除多余数据
                 unset($data[$key]);
             }
         }
     }
    //插入数据
    protected function insert($data){
        // 过滤有效的字段 删除无效的字段
         $this->filterFileds($data);
         //声明一个字符串 保存键值对
         $str="";
         // 遍历  $data
         foreach($data as $key=>$val){
//             key=val,key=val
             $str.="`$key`='$val',";
         }
         //去掉逗号
         $str=  substr($str, 0,-1);
         //构建sql
          $sql="insert into {$this->getTable()} set $str";
          //执行语句
          return $this->db->query($sql);
    }
    //修改语句
    protected function updateByPk($data){
        // 过滤有效的字段 删除无效的字段
         $this->filterFileds($data);
         $str="";
         // 遍历  $data
         foreach($data as $key=>$val){
//             key=val,key=val
             $str.="`$key`='$val',";
         }
//         记录主键名
         $pk=$this->fields['pk'];
         //去掉逗号
         $str=  substr($str, 0,-1);
         //构建sql
         $sql="update {$this->getTable()} set $str where $pk='{$data[$pk]}'";
         //执行语句
         return $this->db->query($sql);
    }
   //按条件读取一条数据的方法
   public function getRow($condition,$fields="*"){
        //构建sql语句
    $sql ="select $fields from {$this->getTable()} where $condition";
    return $this->db->fetchRow($sql);
   }

    //获取表里的记录总条数
    public function getCount(){
        $sql = "select count(*) from {$this->getTable()}";
        return $this->db->fetchColumn($sql);
    }
    
}
