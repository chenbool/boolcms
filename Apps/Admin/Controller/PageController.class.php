<?php
namespace Admin\Controller;
use Think\Controller;
class PageController extends PublicController {
    public function index(){
        $page_list=D('Page')->select();
        $this->assign('page_list',$page_list)->display();
    }

    //添加
    public function add(){
        $menu_list=D('Menu')->menu();
        $this->assign('menu_list',$menu_list);

        //添加
        if(IS_POST){
                $data=I('post./a');
                if($data){
                    $model=D('Page');
                    if( $model->create($data,1) ){
                        if( $model->add() ){
                            $this->success('添加成功',U('index'));
                            exit();
                        }
                    }else{
                        $this->error( $model->getError() );
                    }

                }

        }
        $this->display();
    }


    //修改
    public function edit(){
        //导航栏
        $menu_list=D('Menu')->menu();
        $this->assign('menu_list',$menu_list);

        //获取信息
        $info=D('Page')->where( array('id'=>I('get.id/d') ) )->find();

        //添加
        if(IS_POST){
                $data=I('post./a');
                if($data){
                    $model=D('Page');
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
        $this->assign('info',$info)->display();
    }



    //删除
    public function delete(){
        $id=I('get.id/d');
        // dump($id);
        $model=D('Page');
       if( $model->where( array('id'=>$id) )->delete()  ){
           die( $this->success('修改成功',U('index') )  );
       }else{
           die( $this->error( $model->getError() ) );
       }
    }


}