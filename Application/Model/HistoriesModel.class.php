<?php

/**
 * Created by PhpStorm.
 * User: work1
 * Date: 2017/4/20
 * Time: 14:26
 */
class HistoriesModel extends Model
{
    public function Count(){
        $sql_count = "select count(*) from `histories` limit 1";
        $num = $this->db->fetchColumn($sql_count);//总条数
        return $num;
    }
//    public function user_name($user_id){
//        $sql_user="select username from users where user_id={$user_id}";
//        $row_user = $this->db->fetchRow($sql_user);
//        return $row_user;
//    }
//    public function member_name($member_id){
//        $sql_member="select username from members where member_id={$member_id}";
//        $row_member = $this->db->fetchRow($sql_member);
//        return $row_member;
//    }
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