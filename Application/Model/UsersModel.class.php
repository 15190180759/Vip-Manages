<?php
class UsersModel extends Model{

    public function add($data){

        $data['password'] = md5($data['password']);
        $sql = "insert into users(photo,username,password,realname,sex,telephone,vip_level,money,score,remark)
        values('{$data['thumb_logo']}','{$data['username']}','{$data['password']}','{$data['realname']}','{$data['sex']}','{$data['telephone']}',
        '{$data['vip_level']}','{$data['money']}','{$data['score']}','{$data['remark']}')";
        var_dump($sql);
        $rs = $this->db->query($sql);
        return $rs;
    }
    public function delete($id){
        //构造sql
        $sql="delete from users where user_id={$id}";
        //执行sql
        $rs=$this->db->query($sql);
        //返回数据
        return $rs;
    }
    public function getOne($id){
        $sql="select * from users where user_id=$id";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
    public function update($data){
        $id=$data['id'];
        $sql = "select * from users where user_id ={$id}";
        $row=$this->db->fetchRow($sql);
        $data['photo']=$row['photo'];

        $sql = "update users set photo='{$data['photo']}',username='{$data['username']}',password='{$data['password']}',
        realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',
        vip_level='{$data['vip_level']}',money='{$data['money']}',score='{$data['score']}',remark='{$data['remark']}' where user_id={$data['id']}";

        //执行sql
        $r=$this->db->query($sql);
        //返回结果
        return $r;

    }
    //前台会员中心登录验证
    public function checkLogin($data){
        //验证数据
        if(empty($data['username'])){
            $this->error = '用户名为空';
            return false;
        }
        if(empty($data['password'])){
            $this->error = '密码为空';
            return false;
        }
        //比对登录信息
        $username = $data['username'];
        $password = md5($data['password']);
        $condition = "username = '{$username}' and password = '{$password}'";
        $row = parent::getRow($condition);
        if(empty($row)){
            $this->error = '用户名或者密码不正确';
            return false;
        }else{
            return $row;
        }

    }


}