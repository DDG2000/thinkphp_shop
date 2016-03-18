<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    public function top(){
//        var_dump($_SESSION);
//        exit;
        $userinfo=login();
        $username=$userinfo['username'];
        $this->assign('username',$username);
        $this->display();
    }
    public function menu(){
        $menus=D('Menu')->getAdminMenu();
        $this->assign('menus',$menus);
        $this->display();
    }
    public function main(){
        $this->display();
    }
}