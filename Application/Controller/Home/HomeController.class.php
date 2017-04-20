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
        $this->display('top2');
        $this->display('member');
        $this->display('footer');
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