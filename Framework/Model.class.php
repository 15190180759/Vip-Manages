<?php

/**
 * Created by PhpStorm.
 * Members: Administrator
 * Date: 2016/5/27
 * Time: 10:46
 */
abstract class Model
{
    //可以让继承提交中的类都使用该属性.
    protected $db;
    protected $table_name;
    //储存当前模型对应表的字段信息
    private $fields = [];

    //存放错误信息
    protected  $error;

    public function __construct()
    {
        $this->db = DB::getInstance($GLOBALS['config']['db']);
        $this->initFields();
    }


    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(){
        return $this->error;
    }
    //获取真实表名
    private function table(){
        if(empty($this->table_name)){
            //从子类的名字上得到表名
            $class_name = get_class($this);//得到类名
            $class_name = substr($class_name,0,-5);
            //将类名小写
            $this->table_name = strtolower($class_name);
        }
        //拼接表前缀
        return '`'.$GLOBALS['config']['db']['prefix'].$this->table_name.'`';
    }
    private function initFields()
    {
        $sql = "desc {$this->table()}";
        $rows = $this->db->fetchAll($sql);
        foreach ($rows as $row) {
            if ($row['Key'] == 'PRI') {
                //通过pk键来指向主键
                $this->fields['pk'] = $row['Field'];
            } else {
                //列表直接放在数组中
                $this->fields[] = $row['Field'];
            }
        }
    }
    public function insertData($data){
        //$data为用户提交的一个关联数组，要求其建名必须与当前模型操作的表的字段名一致
        $data = $this->ignoreErrorField($data);
        $sql = "insert into {$this->table()} set  ";
        $fieldValues = [];
        foreach ($data as $key=>$value){
            //将字段和值放在数组中
            $fieldValues[] = "`{$key}`='{$value}'";
        }
        //连接字段和值
        $sql .=implode(",",$fieldValues);
        $this->db->query($sql);
    }
    //删除$data中不匹配的数据
    private function ignoreErrorField($data){
        //如果$data中的建不在fields中，删除$data中建对应的值.
        foreach($data as $k=>$v){
            if(!in_array($k,$this->fields)){
                unset($data[$k]);
            }
        }
        return $data;
    }
    //通过主键删除记录的方法
    public function deleteByPk($pk){
        $sql = "delete from {$this->table()} where {$this->fields['pk']} = {$pk}";
        $this->db->query($sql);
    }
    //修改数据的方法
    public function updateData($new_data,$condition=''){
        //过滤数据源
        $new_data =$this->ignoreErrorField($new_data);
        $sql = "update {$this->table()} set ";
        $fieldValues = [];
        foreach ($new_data as $key=>$value){
            //将字段和值放在数组中
            $fieldValues[] = "`{$key}`='{$value}'";
        }
        $sql .=implode(",",$fieldValues)." where ";
        if(empty($condition)){
            $sql .= "{$this->fields['pk']} = {$new_data["{$this->fields['pk']}"]}";
        }else{
            $sql .= $condition;
        }
        $this->db->query($sql);
    }
    //获取所有数据的功能
    public function getAll($condition=''){
        $sql = "select * from {$this->table()}";
        if(!empty($condition)){
            $sql .= " where ".$condition;
        }
        return $this->db->fetchAll($sql);
    }

    //根据主键查询一条数据
    public function getByPk($pk){
        $sql ="select * from {$this->table()} where {$this->fields['pk']} = {$pk} limit 1";
        return $this->db->fetchRow($sql);
    }
    //根据用户给出的条件获取一行数据
    public function getRow($condition)
    {
        $sql = "select * from {$this->table()} where {$condition} limit 1";
        return $this->db->fetchRow($sql);
    }
        //根据条件统计总条数
    public function getCount($condition=''){
            $sql ="select count(*) from {$this->table()}";
            if(!empty($condition)){
                $sql .= " where ".$condition;
            }

        return $this->db->fetchColumn($sql);
    }
    //根据条件获取数据中的一个字段的值
    public function getColumn($field,$condition){
        $sql = "select {$field} from {$this->table()} where {$condition} limit 1";
        return $this->db->fetchColumn($sql);
    }
    //获取刚加入数据库的一条的数据的id
    public function last_insert_id(){
        return $this->db->last_insert_id();
    }
}