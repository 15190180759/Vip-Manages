<?php

/**
 * Created by PhpStorm.
 * User: 周骁
 * Date: 2017/4/21
 * Time: 21:31
 */
class OrderModel extends Model
{
    public function getList(){
        return parent::getAll();
    }

    public function add($data){
        //验证数据
        if(empty($data['date'])){
            $this->error = '请填写预约时间';
            return false;
        }
        if(empty($data['realname'])){
            $this->error = '请填写姓名';
            return false;
        }
        if(empty($data['date'])){
            $this->error = '请填写联系电话';
            return false;
        }
        //转换日期为时间戳
        $data['date'] = strtotime($data['date']);
        //确保预约时间没有过期
        if($data['date']<time()){
            $this->error = '预约时间已过期';
            return false;
        }
        parent::insertData($data);
    }
}