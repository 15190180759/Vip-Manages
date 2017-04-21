<?php


//前台预约美发管理控制器
class OrderController extends Controller
{
    public function add(){
        //接收数据
        $data = $_POST;
        //处理数据
        $orderModel = new OrderModel();
        $r = $orderModel->add($data);
        if($r === false){
            $this->redirect('index.php?p=Home&c=Home&a=member',$orderModel->getError(),2);
        }
        $this->redirect('index.php?p=Home&c=Home&a=member','预约成功',1);
    }
}