<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
    public function index(){
        $this->display();
    }
    
        //验证码
    public function code(){
        $config =   C('VERIFY');
        $Verify = new \Think\Verify($config);
        $Verify->entry();  
    }
    

    //注销登陆
    public function loginout(){
        session('uid',null);
        $this->error('正在退出...',U('Login/index') );        
    }
    
    //登陆
    public function login(){

        $model=D('admin');
	   	// 接收表单并且验证表单
	   	if($model->validate($model->_login_validate)->create()){
	   		if($model->login()){
	                    $this->success('登录成功!', U('Index/index'));
	                    exit;
	                }else{
	                    $this->error($model->getError());   
	                }
	        }else{
	           $this->error($model->getError());   
	        }
	        
	    }   

        
}