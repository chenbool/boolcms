<?php
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model {

    protected $insertFields =  'username,password,status,email,code';
    protected $updateFields =  'username,password,status,email,id,code';

    //验证规则
    protected $_validate = array(
        array('username','require','用户名不能为空',1),
        array('password','require','密码不能为空',1),
        array('email','email','邮箱格式不对',1),
        array('username', '1,30', '用户名最长不能超过 30 个字符！', 1, 'length', 3),
    );


    //自动完成
    protected $_auto = array (
        array('add_time','time',1,'function'), // 对add_time字段在新增的时候写入当前时间戳
        array('last_time','time',1,'function'),
        array('password','md5',3,'function'), 
    );


    //删除之后
    protected function _after_delete($option){
        // $option['child_id']
    }

   
    /*************登陆验证*******************************************************/
    
    // 为登录的表单定义一个验证规则 
    public $_login_validate = array(
    array('username', 'require', '用户名不能为空！', 1),
    array('password', 'require', '密码不能为空！', 1),
    array('code', 'require', '验证码不能为空！', 1),
    array('code', 'check_verify', '验证码不正确！', 1, 'callback'),
    );    
    
    // 验证验证码是否正确
    function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
    }  
    
    //登陆
    public function login(){
    // 从模型中获取用户名和密码
    $username = $this->username;
    $password = $this->password;
        
    // 先查询这个用户名是否存在
    $user = $this->where(array('username' => array('eq', $username),))->find();
        if($user){
            if($user['password'] == md5($password)){
                            //保存到session
                            session('uid',$user['id']);
                            return TRUE;
            }else{
                            $this->error = '密码不正确！';
                            return FALSE;
            }
        }else {
            $this->error = '用户名不存在！';
            return FALSE;
        }
    }    

    
}