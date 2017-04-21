<?php

class historiesController extends Controller
{
    public function index(){
        $condition = [];
        $search=[];
        $search['type']='';
        if(!empty($_REQUEST['type'])){
            $condition[] = "type = {$_REQUEST['type']}-1";
            $search['type']=$_REQUEST['type'];
        }
        $search['keyword']='';
        if(!empty($_REQUEST['keyword'])){
            $condition[] = "(user_id like '%{$_REQUEST['keyword']}%' or member_id like '%{$_REQUEST['keyword']}%' or amount like '%{$_REQUEST['keyword']}%' or content like '%{$_REQUEST['keyword']}%' or time like '%{$_REQUEST['keyword']}%' or remainder like '%{$_REQUEST['keyword']}%')";
            $search['keyword']=$_REQUEST['keyword'];
        }
        $condition = implode(' and ',$condition);

        //将搜索填写的内容分配到视图
        $this->assign('search',$search);

        //分页
        $historiesModel = new HistoriesModel();
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pagesize = 3;
        $num=$historiesModel->Count($condition);
        $pageTool = new PageTool();
        $url = "index.php?p=Admin&c=Histories&a=index&".http_build_query($search);
        $pageResult=$pageTool->show($url,$num,$page,$pagesize);
        $start=($page-1)*$pagesize;
        //搜索分页
        //如果搜索输入了内容，将$condition变为
        //where type = 1-1 and (user_id like '%1%' or member_id like '%1%' or amount like '%1%' or content like '%1%' or time like '%1%' or remainder like '%1%') order by history_id asc limit 0,3
        if( (!empty($_REQUEST['type'])) || (!empty($_REQUEST['keyword'])) ){
            $condition= "  where  $condition order by history_id asc limit $start,$pagesize";
        }else{
            $condition.= " order by history_id asc limit $start,$pagesize";
        }
        $historiesModel = new HistoriesModel();
        //因为如果搜索输入有内容则$condition带了where的，就不能有Model里的getAll方法
        $list = $historiesModel->getlist($condition);
        $this->assign('list', $list);
        $this->assign('pageResult',$pageResult);
        $this->display('index');
    }
    public function chongzhi(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = $_POST;
//            var_dump($data);exit;
            $historiesModel = new HistoriesModel();
            $res=$historiesModel->Chongzhi($data);
//            var_dump($res);exit;
            $this->redirect('index.php?p=Admin&c=Histories&a=index');
        }else{
//            $id = $_GET['id'];
//            $historiesModel = new HistoriesModel();
//            $row = $historiesModel->getOne($id);
////            var_dump($row);exit;
//            $this->assign('data',$row);
            $this->display('chongzhi');
        }
    }
}