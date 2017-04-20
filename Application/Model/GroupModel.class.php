<?php


class GroupModel extends Model
{
    public function Count(){
        $sql_count = "select count(*) from `group` limit 1";
        $num = $this->db->fetchColumn($sql_count);//总条数
        return $num;
    }
    public function add($data){
//        var_dump($data);exit;
        $sql = "insert into `group`(`name`) values ('{$data['name']}')";
        $res=$this->db->query($sql);
        return $res;
    }
    public function getOne($id){
        $sql = "select * from `group` where group_id={$id}";
        $row = $this->db->fetchRow($sql);
        return $row;
    }
    public function update($data){
//        var_dump($data);exit;
        $sql = "update  `group` set name='{$data['name']}' where group_id={$data['group_id']}";
//        var_dump($sql);exit;
        $result = $this->db->query($sql);
        return $result;
    }
    public function del($group_id){
//        var_dump($group_id);exit;
        $sql_count="select count(*) from members where group_id=$group_id";
        $num = $this->db->fetchColumn($sql_count);
//        var_dump($num);exit;
        if($num>0){
            $this->error='该部门下有员工，不能删除！';
            return false;
        }else{
            $sql = "delete from `group` where  group_id=";
            $sql.=$group_id;
//            var_dump($sql);exit;
            $result = $this->db->query($sql);
            return $result;
        }

    }


}