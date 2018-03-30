<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends PublicController {

    public function index(){
        //显示
        $res=D('Admin/Show')->show();

        $this->assign(array(
            'slide'  =>  $res['show'],
        ));
        // dump($res);
        $this->display();
    }


    public function page(){
    	$id=I('get.id/d');
        $pid=I('get.parent_id');
    	$page=D('Admin/Page')->field('a.*,b.cat_name')
    						 ->alias('a')
    						 ->join('left join __CATEGORY__ as b on a.id=b.child_id')
    						 ->where(array('id'=>$id))
    						 ->find();

        $child_menu=D('Menu')->field('a.*,b.cat_name as parent_name')
                             ->alias('a')
                             ->join('left join __MENU__ as b on a.parent_id=b.child_id')
                             ->where(array('a.parent_id',$pid))
                             ->select();

    	$this->assign(array(
            'page'  =>  $page,
            'child_menu'    =>$child_menu
        ));
        $this->display();
    }


    public function lists(){
        $id=I('get.id/d');
        $child_menu=D('Category')->where(array('parent_id'=>$id))->select();
        $model=D('Admin/Content');
        $res=$model->show();
        // dump($child_menu);
        $this->assign(array(
            'list'  =>  $res['list'],
            'page'  =>  $res['page'],
            'child_menu'    =>$child_menu
        ));       

        $this->display();
    }

}