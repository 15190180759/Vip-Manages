<?php



class IndexController extends PlatformController
{
    public function index(){
        $this->display('index');
    }
    public function top(){
        @session_start();
        $this->assign($_SESSION['user']);
        $this->display('top');
    }
    public function menu(){
        $this->display('menu');
    }
    public function main(){
        $this->display('main');
    }
}