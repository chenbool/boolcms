<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends PublicController {

    public function index(){
    	$admin_list=D('Admin')->select();
    	$this->assign('admin_list', $admin_list);

        $this->display();
    }

    
    /**
     * [add 添加]
     */
    public function add(){

        $data=I('post./a');
        if($data){
            $model=D('Admin');
            if( $model->create($data,1) ){
                if( $model->add() ){
                    $this->success('添加成功',U('index'));
                    exit();
                }
            }else{
                $this->error( $model->getError() );
            }

        }

    	$this->display();
    }   


    public function edit(){
        //获取信息
        $info=D('Admin')->where( array('id'=>I('get.id/d') ) )->find();

        //添加
        if(IS_POST){
                $data=I('post./a');
                if($data){
                    $model=D('Admin');
                    if( $model->create($data,2) ){
                        if( $model->save() ){
                            $this->success('修改成功',U('index'));
                            exit();
                        }
                    }else{
                        $this->error( $model->getError() );
                    }

                }

        }
        dump($info);
        $this->assign('info',$info)->display();
    }



}