<?php

//前台会员中心控制器
class UsersController extends Controller
{
    public function check(){
        //接收数据
        $data =  $_POST;
        //调用模型检验用户登录信息
        $usersModel = new UsersModel();
        $r = $usersModel->checkLogin($data);
        if( $r === false ){
            $this->redirect('index.php?p=Home&c=Home&a=member',$usersModel->getError(),1);
        }else{
            //用户登录成功，记录SESSION
            @session_start();
            $_SESSION['user_info'] = $r;
            $this->redirect('index.php?p=Home&c=Home&a=member');
        }
    }
}