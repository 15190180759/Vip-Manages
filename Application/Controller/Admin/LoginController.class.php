<?php


class LoginController extends Controller
{
    public function login(){
        $this->display('login');
    }
    //验证登录信息
    public function check(){
        //接收参数
        $username = $_POST['username'];
        $password = $_POST['password'];
        $no_captcha = $_POST['captcha'];
        //首先通过验证码工具类 验证 验证码信息
        $captcha = new CaptchaTool();
        $r = $captcha->checkCode($no_captcha);
        if($r===false){
            $this->redirect('index.php?p=Admin&c=Login&a=login','验证码不正确',3);
        }
        //处理数据,返回结果
        $membersModel = new MembersModel();
        $r = $membersModel->checkLogin($username,$password);
        if($r===false){
            $this->redirect('index.php?p=Admin&c=Login&a=login',$membersModel->getError(),3);
        }else {
            //登陆成功 记录用户登录痕迹
            //使用COOKIE记录登录信息（标示）

            //使用session保存登录痕迹
            @session_start();
            $_SESSION['user'] = $r;
            //如果用户点了自动登录
            if (isset($_POST['remember'])) {
                $password = md5($r['password']);
                setcookie("id", $r['member_id'], time() + 60 * 60 * 24 * 7, '/');
                setcookie("password", $password, time() + 60 * 60 * 24 * 7, '/');
            }
            //调用模型更新管理员最后登录时间
            $membersModelModel = new MembersModel();
            $membersModelModel->adminAction($r);
        }

        //跳转
        $this->redirect('index.php?p=Admin&c=Index&a=index');

    }
    //生成验证码
    public function captcha(){

        //通过验证码工具类输出验证码
        $captcha = new CaptchaTool();
        $captcha->makeImage(4);
    }
    //退出功能
    public function login_out(){
        session_start();
        //$_SESSION=array();
        unset($_SESSION['user']);
        session_destroy();
        setcookie("id",null,-1,'/');
        setcookie("password",null,-1,'/');
        setcookie("PHPSESSID",null,-1,'/');
        $this->redirect("index.php?p=Admin&c=Login&a=login");
    }
}