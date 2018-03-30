<?php
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller {
    
    //初始化
    function _initialize(){
        //判断session id是否存在
        if( !session('uid') ){
            $this->redirect('Login/index'); //跳转到登陆页面
        }
    }
        
    
    
}

