<?php

class GroupController extends Controller
{
    public function index()
    {
        //分页
        $condition='';
        $groupModel = new GroupModel();
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pagesize = 3;
        $num=$groupModel->Count();
//        var_dump($num);exit;
        $pageTool = new PageTool();
        $pageResult=$pageTool->show('index.php?p=Admin&c=Group&a=index',$num,$page,$pagesize);
//        var_dump($pageResult);exit;
        //展示所在页码的数据，所以加上LIMIT限制
        $start=($page-1)*$pagesize;
        $condition.= " 1=1 order by group_id asc limit $start,$pagesize";

//        var_dump($condition);exit;
        $groupModel = new GroupModel();
        $list = $groupModel->getAll($condition);
//        var_dump($list);exit;
        $this->assign('list', $list);
        $this->assign('pageResult',$pageResult);
        $this->display('index');

    }
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = $_POST;
            $groupModel = new GroupModel();
            $groupModel->add($data);
            $this->redirect('index.php?p=Admin&c=Group&a=index');
        }else{
            $this->display('add');
        }
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $id = $_GET['id'];
            $groupModel = new GroupModel();
            $row = $groupModel->getOne($id);
//            var_dump($row);exit;
            $this->assign('data',$row);
            $this->display('edit');
        }
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data = $_POST;
//            var_dump($data);exit;
            $groupModel = new GroupModel();
            $res=$groupModel->update($data);
//            var_dump($res);exit;
            if ($res === false) {
                $this->redirect('index.php?p=Admin&c=Group&a=edit&id='.$data['group_id'], $groupModel->getError(),3);
            }
            $this->redirect('index.php?p=Admin&c=Group&a=index');
        }
    }
    public function del(){
//        var_dump($_GET);exit;
        $group_id = $_GET['group_id'];
        $groupModel=new GroupModel();
        $res=$groupModel->del($group_id);
        if($res==false){
            $this->redirect('index.php?p=Admin&c=Group&a=index', $groupModel->getError(),3);
        }
        $this->redirect('index.php?p=Admin&c=Group&a=index');
    }
}