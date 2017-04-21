<?php


//预约美发管理控制器
class OrderController extends PlatformController
{
    public function index(){

        $orderModel = new OrderModel();
        $rows = $orderModel->getList();
        $this->assign('list',$rows);
        $this->display('index');
    }
    public function action()
    {
        //如果act== 'pass'执行通过预约操作
        if (isset($_GET['act']) && $_GET['act'] == 'pass') {
            //准备通过所需要的信息
            $id = $_GET['id'];
            $new_data = ['status' => 1];
            $condition = "order_id = {$id}";
            //调用模型完成下架操作
            $orderModel = new OrderModel();
            $orderModel->updateData($new_data, $condition);
            $this->redirect('index.php?p=Admin&c=Order&a=index');
        } else {
            //准备拒绝操作所需要的信息
            $id = $_GET['id'];
            $new_data = ['status' => -1];
            $condition = "order_id = {$id}";
            //调用模型完成下架操作
            $orderModel = new OrderModel();
            $orderModel->updateData($new_data, $condition);
            $this->redirect('index.php?p=Admin&c=Order&a=index');
        }
    }
}