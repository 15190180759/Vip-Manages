<?php

/**
 * Created by PhpStorm.
 * Users: 周骁
 * Date: 2017/4/20
 * Time: 10:25
 */
//活动管理控制器
class ArticleController extends Controller
{
    public function index(){
        //接收数据
        //处理数据
        $ArticleModel = new ArticleModel();
       // $rows = $ArticleModel->getAll();
          //准备数据实现分页
            $url = 'index.php?p=Admin&c=Article&a=index';
            $count = $ArticleModel->getCount();
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $pageSize = 2;
        $pageTool = new PageTool();
        $pageHtml = $pageTool->show($url,$count,$page,$pageSize);
          //按分页条件查询数据
        $start = ($page-1)*$pageSize;
        $condition = " 1=1 limit {$start},{$pageSize}";
        $rows = $ArticleModel->getAll($condition);
       //分配数据
        $this->assign('indexHtml',$pageHtml);
        $this->assign('list',$rows);
        $this->display('index');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //接受数据
            $data = $_POST;
            //处理数据
            $ArticleModel = new ArticleModel();
            $ArticleModel->add($data);
            //跳转
            $this->redirect('index.php?p=Admin&c=Article&a=index');

        }else{
            $this->display('add');
        }
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //接收数据
            $data = $_POST;
            //处理数据
            $ArticleModel = new ArticleModel();
            $ArticleModel->edit($data);
            //跳转
            $this->redirect('index.php?p=Admin&c=Article&a=index');

        }else{
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $ArticleModel = new ArticleModel();
            $row = $ArticleModel->getByPk($id);
            //分配数据
            $this->assign($row);
            //修改视图
            $this->display('edit');
        }
    }
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $ArticleModel = new ArticleModel();
        $ArticleModel->deleteByPk($id);
        //跳转
        $this->redirect('index.php?p=Admin&c=Article&a=index');
    }

}