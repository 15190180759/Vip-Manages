<?php


class MembersModel extends Model{
    public function checkByCookie($id,$password){
        //根据id得到一行数据
        $row=parent::getByPk($id);
        if(empty($row)){
            return false;
        }
        //根据该行记录取出数据库中的password再加密
        $password_in_db = md5($row['password']);
        //与COOKIE中的password对比
        if($password == $password_in_db){
            //登录成功
            return $row;
        }else{
            return false;
        }
    }
    public function checkLogin($username,$password){
        //验证数据
        if(empty($username)){
            $this->error = '用户名不能为空';
            return false;
        }
        if(empty($password)){
            $this->error = '密码不能为空';
            return false;
        }
        //通过传入的用户名密码统计条数
        //将传入的密码加密与数据库中的比对
        //var_dump($username,$password);exit;
        $password = md5($password);
        //查询匹配成功的一行数据
        $condition = "username = '$username' and password = '$password' and is_admin=1";
        $row =parent::getRow($condition);
        //var_dump($row);exit;
        if(empty($row)){
            $this->error = '用户名或者密码不正确';
            return false;
        }else{
            return $row;
        }
    }
    public function adminAction($data){
        //更新最后登录时间
        $data['last_login']=time();
        parent::updateData($data);
    }
    public function getList(){
        $sql="select *,name from members,`group` where members.group_id = `group`.group_id";
        $members=$this->db->fetchAll($sql);
        return $members;


    }
    public function add($data){

        $time = time();
        $data['password'] = md5($data['password']);
        $sql = "insert into members(photo,username,password,realname,sex,telephone,group_id,is_admin,last_login)
        values('{$data['thumb_logo']}','{$data['username']}','{$data['password']}','{$data['realname']}','{$data['sex']}','{$data['telephone']}',
        '{$data['group_id']}','{$data['is_admin']}','$time')";
        $rs = $this->db->query($sql);
        return $rs;
    }

    public function delete($id){
        //构造sql
        $sql="delete from members where member_id={$id}";
        //执行sql
        $rs=$this->db->query($sql);
        //返回数据
        return $rs;
    }
    public function getone($id){//根据id构造sql
        $sql="select * from members where member_id={$id}";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
    public function update($data){
        $id=$data['id'];
        $sql = "select * from members where member_id ={$id}";
        $row=$this->db->fetchRow($sql);
        $data['photo']=$row['photo'];

        $sql = "update members set photo='{$data['photo']}',username='{$data['username']}',password='{$data['password']}',
        realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',
        group_id='{$data['group_id']}',is_admin='{$data['is_admin']}' where member_id={$data['id']}";

        //执行sql
        $r=$this->db->query($sql);
        //返回结果
        return $r;

    }



}