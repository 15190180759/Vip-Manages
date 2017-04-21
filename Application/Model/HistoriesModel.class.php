<?php

/**
 * Created by PhpStorm.
 * Users: work1
 * Date: 2017/4/20
 * Time: 14:26
 */
class HistoriesModel extends Model
{
    public function Count($condition){
        if(empty($condition)){
            $sql_count = "select count(*) from histories limit 1";
        }else{
            $sql_count = "select count(*) from histories where {$condition} limit 1";
        }
        $num = $this->db->fetchColumn($sql_count);//总条数
        return $num;
    }
    public function getlist($condition){
        if(empty($condition)){
            $sql_rows = "select * from histories";
        }else{
            $sql_rows = "select * from histories {$condition} ";
        }
//        var_dump($sql_rows);exit;
        $rows = $this->db->fetchAll($sql_rows);
        return $rows;

    }
    public function Chongzhi($data){
        $time=date('Y-m-d h:i:s');
//        var_dump($time);exit;
        $remainder=$data['remainder']+$data['amount'];
//        var_dump($remainder);exit;
        $sql = "insert into `histories`(user_id,member_id,remainder,amount,time,type) values ({$data['user_id']},{$data['member_id']},'{$remainder}','{$data['amount']}','{$time}',1)";
//        var_dump($sql);exit;
        $res=$this->db->query($sql);
        return $res;
    }
    public function getOne($id){
        $sql = "select * from `histories` where history_id={$id}";
        $row = $this->db->fetchRow($sql);
        return $row;
    }
}