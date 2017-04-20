<?php



class IndexController extends PlatformController
{
    public function index(){
        $this->display('index');
    }
    public function top(){
        $this->display('top');
    }
    public function menu(){
        $this->display('menu');
    }
    public function main(){
        $this->display('main');
    }
}