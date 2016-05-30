<?php
namespace Home\Controller;
use Think\Controller;

//前台模块
class IndexController extends Controller{
    public function index(){
    	//$this->redirect('Admin/login');

    	$this->redirect(Admin . '/Public/login');

    }
}



