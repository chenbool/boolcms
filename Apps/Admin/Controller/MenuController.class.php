<?php
namespace Admin\Controller;
use Think\Controller;

class MenuController extends PublicController {
    public function index(){
        $res=D('Menu')->menu();
        $this->assign(array(
            'menu_list'=>$res,
        ));
        // $info=D('Menu')->get_child_id($res,5);
        // dump($info);
        $this->display();
    }

    //添加
    public function add(){
        $data=I('post./a');
        if($data){
            $model=D('Menu');
            if( $model->create($data,1) ){
                if( $model->add() ){
                    $this->success('添加成功',U('index'));
                    exit();
                }
            }else{
                $this->error( $model->getError() );
            }

        }

        $page_list=D('Page')->select();
        $res=D('Category')->menu();
        $this->assign(array(
            'menu_list' =>  $res,
            'page_list' =>  $page_list
        ));
        $this->display();
    }

    //修改
    public function edit(){
        //获取信息
        $id=I('get.id');
        $info=M('Menu')->where(array('child_id'=>$id) )->find();

        //提交修改
        if(IS_POST){
            $data=I('post./a');
            //接受数据修改
            if($data){
                $model=D('Menu');
                if( $model->create($data,2) ){
                    $data=$model->parseFieldsMap($data);
                    
                    if( $model->save($data)!= false ){
                        $this->success('修改成功',U('index'));
                        exit();
                    }else{
                        $this->error( '内容错误或内容没有改变' );
                    }
                }else{
                    $this->error( $model->getError() );
                }

            }
        }
        
        $page_list=D('Page')->select();
        $res=D('Category')->menu();

        $this->assign(array(
            'menu_list' =>  $res,
            'page_list' =>  $page_list,
            'info'      =>  $info,
        ));

        $this->display();
    }

    //删除
    public function del(){
        $id=I('get.id/d');
        $model=D('Menu');
        if( D('Menu')->delete($id) ){
            $this->success('删除成功',U('index'));
        }else{
            $this->error( '错误'.$model->getError() );
        }
    }

    //ajax获取菜单
    public function AjaxMenu(){
        $res=D('Menu')->menu();
        $this->ajaxReturn($res,'json');
    }

    //ajax更新排序
    public function AjaxOrder(){
        IS_AJAX || die('error');
        $res=I('post./a');
        M('menu')->where(array('child_id'=>$res['child_id']) )->save($res) ||  $this->ajaxReturn(array('status'=>0),'json');
    }

}