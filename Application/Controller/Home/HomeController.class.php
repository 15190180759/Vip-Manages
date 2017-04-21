<?php

/**
 * Created by PhpStorm.
 * Members: ����
 * Date: 2017/4/2
 * Time: 9:03
 */
class HomeController extends Controller
{
      public function index(){
         $this->display('top1');
          $this->display('index');
          $this->display('footer');
      }

    public function member(){
        //判断会员是否登录
        @session_start();
        if(!isset($_SESSION['user_info'])){//没有session则载入登录视图
            $this->display('top2');
            $this->display('login');
            $this->display('footer');
        }
        else {
            //如果存在session，则进入会员中心
            $users = $_SESSION['user_info'];
            //查出所有美发师信息用于分配到会员中心
            $membersModel = new MembersModel();
            $barbers = $membersModel->getAll();
            //分配所有信息
            $this->assign('barber',$barbers);
            $this->assign($users);
            $this->display('top2');
            $this->display('member');
            $this->display('footer');
        }
    }
    public function points(){
        $this->display('top2');
        $this->display('points');
        $this->display('footer');
    }
    //活动中心
    public function article(){
        if(!isset($_GET['id'])) {
            //取出所有未过期的活动数据
            $articleModel = new ArticleModel();
            $condition = ' end > now() order by article_id desc limit 4';
            $rows = $articleModel->getAll($condition);
            //随机查询出一条没有过期的活动数据用来分配
            $row = $articleModel->getRandom();
            //分配数据
            $this->assign('list', $rows);
            $this->assign($row);
            $this->display('top2');
            $this->display('article');
            $this->display('footer');
        }else{
            //取出所有未过期的活动数据
            $articleModel = new ArticleModel();
            $condition = ' end > now() order by article_id desc limit 4';
            $rows = $articleModel->getAll($condition);
            //接收ID值,根据它查询一条活动数据
            $id = $_GET['id'];
            $row = $articleModel->getByPk($id);
            //分配数据
            $this->assign($row);
            $this->assign('list', $rows);
            $this->display('top2');
            $this->display('article');
            $this->display('footer');
        }
    }
    public function contact(){
        $this->display('top2');
        $this->display('contact');
        $this->display('footer');
    }
}