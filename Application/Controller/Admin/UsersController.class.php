<?php

class UsersController extends Controller{
    public function index(){
        $UsersModel=new UsersModel();
        $rows=$UsersModel->getAll();

        $this->assign('rows',$rows);
        $this->display('index');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $data=$_POST;
//            var_dump($data);exit;
            $UploadTool=new UploadTool();
            $UserPath=$UploadTool->uploadOne($_FILES['photo'],"user/");
            if($UserPath === false){
                $this->redirect('index.php?p=Admin&c=Users&a=add',$UploadTool->getError(),3);
            }else{
                //$data['photo']=$UserPath;
                //给定一个默认路径，以作为用户的默认头像
                $MorenPath = 'user/login.png';
                $UserPath = !empty($UserPath) ? $UserPath : $MorenPath ;
               //var_dump($UserPath);exit;
                $ThumbPath=$UploadTool->thumb($UserPath,50,50);
                if($ThumbPath ===  false){
                    $this->redirect('index.php?p=Admin&c=Users&a=add',$UploadTool->getError(),3);
                }else{
                    $data['thumb_logo'] = $ThumbPath;
                }

                $UsersModel=new UsersModel();
                $UsersModel->add($data);
            }
//            //用户不上传图片，则上传一张默认图片作为头像
//            else{
//                $data['thumb_logo'] =
//            }



            $this->redirect('index.php?p=Admin&c=Users&a=index');
        }else{

            $this->display('add');
        }
    }
    public function delete(){
        $id=$_GET['id'];
        $UsersModel=new UsersModel();
        $UsersModel->delete($id);
        $this->redirect('index.php?p=Admin&c=Users&a=index');
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data=$_POST;
//            var_dump($data);exit;
            $UploadTool=new UploadTool();
            $logoPath=$UploadTool->uploadOne($_FILES['photo'],'members/');
            if($logoPath === false){
                $this->redirect('index.php?p=Admin&c=Users&a=edit&id='.$data['id'],"上传图片失败",3);
            }elseif(!empty($logoPath)){
                $data['photo'] = $logoPath;
                $thumb_logo=$UploadTool->thumb($logoPath,80,80);
                if($thumb_logo === false){
                    $this->redirect('index.php?p=Admin&c=Users&a=edit',"缩略图上传失败",3);
                }else{
                    $data['photo'] = $thumb_logo;
                }
            }

            $UsersModel=new UsersModel();
            $r=$UsersModel->update($data);
            if($r === false){
                $this->redirect('index.php?p=Admin&c=Users&a=edit&id='.$data['id'],$UsersModel->getError(),2);
            }

            $this->redirect('index.php?p=Admin&c=Users&a=index');
        }else{
            $id=$_GET['id'];

            $UsersModel=new UsersModel();
            $row=$UsersModel->getOne($id);
            $this->assign($row);
            $this->display('edit');
        }

    }

}