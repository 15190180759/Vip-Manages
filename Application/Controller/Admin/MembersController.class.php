<?php

class MembersController extends Controller{
    public function index(){
        $condition = [];
        if(!empty($_POST['group_id'])){
            $condition[] = "group_id = {$_POST['group_id']}";
        }
        if(!empty($_POST['keyword'])){
            $condition[] = "(realname like '%{$_POST['keyword']}%' or telephone like '%{$_POST['keyword']}%')";
        }
        //将数组转化成字符串
        $condition = implode(' and ',$condition);
        $MembersModel=new MembersModel();
        $row=$MembersModel->getList();

        $GroupModel=new GroupModel();
        $groups=$GroupModel->getAll();

        $this->assign('groups',$groups);
        $this->assign('list',$row);
        $this->display('index');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $data=$_POST;
            $UploadTool=new UploadTool();
            $MembersPath=$UploadTool->uploadOne($_FILES['photo'],"members/");
            if($MembersPath === false){
                $this->redirect('index.php?p=Admin&c=Members&a=add',$UploadTool->getError(),3);
            }else{
                $data['photo']=$MembersPath;
                $ThumbPath=$UploadTool->thumb($MembersPath,50,50);
                if($ThumbPath ===  false){
                    $this->redirect('index.php?p=Admin&c=Members&a=add',$UploadTool->getError(),3);
                }else{
                    $data['thumb_logo'] = $ThumbPath;
                }
                $MembersModel=new MembersModel();
                $MembersModel->add($data);
                

                $this->redirect('index.php?p=Admin&c=Members&a=index');
            }
        }else{
            $GroupModel=new GroupModel();
            $groups=$GroupModel->getAll();
            $this->assign('groups',$groups);
            $this->display('add');
        }
    }
    public function delete(){
        $id=$_GET['id'];
        $MembersModel=new MembersModel();
        $MembersModel->delete($id);
        $this->redirect('index.php?p=Admin&c=Members&a=index');
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=$_POST;
            $UploadTool=new UploadTool();
            $logoPath=$UploadTool->uploadOne($_FILES['photo'],'members/');
            if($logoPath === false){
                $this->redirect('index.php?p=Admin&c=Members&a=edit&id='.$data['id'],"上传图片失败",3);
            }elseif(!empty($logoPath)){
                $data['photo'] = $logoPath;
                $thumb_logo=$UploadTool->thumb($logoPath,80,80);
                if($thumb_logo === false){
                    $this->redirect('index.php?p=Admin&c=Members&a=edit',"缩略图上传失败",3);
                }else{
                    $data['photo'] = $thumb_logo;
                }
            }

            $MembersModel=new MembersModel();
            $r=$MembersModel->update($data);
            if($r === false){
                $this->redirect('index.php?p=Admin&c=Members&a=edit&id='.$data['id'],$MembersModel->getError(),2);
            }

            $this->redirect('index.php?p=Admin&c=Members&a=index');
        }else{
            $id=$_GET['id'];
            $MembersModel=new MembersModel();
            $row = $MembersModel->getone($id);
            //var_dump($row);exit;
            $GroupModel=new GroupModel();
            $groups=$GroupModel->getAll();

            $this->assign('groups',$groups);
            $this->assign($row);
            $this->display('edit');
        }

    }

}