<?php


//后台统一权限验证控制器(需要验证的都要继承该控制器)
class PlatformController extends Controller
{
    //构造方法判断是否有登录权限
    public function __construct(){
        $r = $this->checkLoginAction();
        if($r === false) {
            $this->redirect("index.php?p=Admin&c=Login&a=login", '登录已超时，请重新登录', 3);
        }
    }
    //验证用户登录情况的方法
    private function checkLoginAction(){
        //开启session
        session_start();

        if(!isset($_SESSION['user'])) {
            //用户没有SESSION登录痕迹
            //判断COOKIE是否有id,password

            if (isset($_COOKIE['id']) && isset($_COOKIE['password'])) {
                //如果id和password同时存在，则根据它们登录
                $id = $_COOKIE['id'];
                $password = $_COOKIE['password'];
                $membersModel = new MembersModel();
                $r = $membersModel->checkByCookie($id, $password);
                if($r === false){
                    return false;
                }else{
                    //Cookie登录成功,记录session
                    $_SESSION['user']=$r;
                    //跳转到后台首页
                    return true;

                }
            }
            return false;
        }

    }

}