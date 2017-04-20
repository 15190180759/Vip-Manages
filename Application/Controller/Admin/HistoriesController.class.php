<?php

class historiesController extends Controller
{
    public function index(){
        $condition = [];
//        var_dump($_POST);exit;
        if(!empty($_POST['type'])){
            $condition[] = "type = {$_POST['type']}-1";
        }
        if(!empty($_POST['keyword'])){
            $condition[] = "(user_id like '%{$_POST['keyword']}%' or member_id like '%{$_POST['keyword']}%' or amount like '%{$_POST['keyword']}%' or content like '%{$_POST['keyword']}%' or time like '%{$_POST['keyword']}%' or remainder like '%{$_POST['keyword']}%')";
        }
        $condition = implode(' and ',$condition);
//        var_dump($condition);exit;

     //分页
        $historiesModel = new HistoriesModel();
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pagesize = 3;
        $num=$historiesModel->Count();
        $pageTool = new PageTool();
        $pageResult=$pageTool->show('index.php?p=Admin&c=Histories&a=index',$num,$page,$pagesize);
        $start=($page-1)*$pagesize;
        if(empty($_POST['type'])&&empty($_POST['keyword'])){
            $condition.= " 1=1 order by history_id asc limit $start,$pagesize";
        }else{
            $condition.= " order by history_id asc limit $start,$pagesize";
        }
        $historiesModel = new HistoriesModel();
        $list = $historiesModel->getAll($condition);
//        var_dump($list);exit;
        $this->assign('list', $list);
        $this->assign('pageResult',$pageResult);
//        foreach($list as $list){
////            var_dump($list);exit;
//            $user_name[] = $historiesModel->user_name($list['user_id']);
//            $member_name[] = $historiesModel->member_name($list['member_id']);
//        }
////        var_dump($user_name);exit;
//        $this->assign('user_name', $user_name);
//        $this->assign('member_name', $member_name);
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