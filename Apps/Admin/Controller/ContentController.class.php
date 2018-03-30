<?php
namespace Admin\Controller;
use Think\Controller;
class ContentController extends PublicController {

    public function index(){
        $menu=D('Category')->menu();

        $model=D('Content');
        $res=$model->content();
        // dump($res);
        $this->assign(array(
            'list'  =>  $res['list'],
            'page'  =>  $res['page'],
            'menu_list'=>$menu,
        ));
        $this->display();
    }
    

    /**
     * 添加内容
     */
    public function add(){

        $data=I('post./a');
        if($data){
            $model=D('Content');
            $this->img($data); 
            if( $model->create($data,1) ){
                if( $model->add() ){
                    $this->success('添加成功',U('index'));
                    exit();
                }
            }else{
                $this->error( $model->getError() );
            }

        }

        $res=D('Category')->menu();
        $this->assign(array(
            'menu_list'=>$res,
        ));

        $this->display();
    }


    /**
     * [edit 编辑]
     * @return [type] [description]
     */
    public function edit(){
        //查询信息
        $id=I('get.id/d');
        $info=D('Content')->content();

        //获取菜单
        $res=D('Category')->menu();
        $this->assign(array(
            'menu_list'=>$res,
            'info'  =>  $info['list'][0],
        ));


        $data=I('post./a');
        if($data){
            
            $model=D('Content');
            $this->img($data); 
            if( $model->create($data,2) ){
                if( $model->save($data) ){
                    $this->success('修改成功',U('index'));
                    exit();
                }
            }else{
                $this->error( $model->getError() );
            }

        }

        $this->display();
    }



    /**
     * [img 图片处理类]
     * @param  [type] &$data [description]
     * @return [type]  bool      [description]
     */
    public function  img(&$data){

        if($_FILES['image']['error']==0){
            $config=C('CONFIG');
            $config_img =C('UPLOAD');

            //删除原来的图片
            is_file( $config_img['rootPath'].$data['image'] ) && unlink($config_img['rootPath'].$data['image']);


            $info=upload_one($_FILES['image']);
            if(!info){
                die($this->error( '上传失败' ));
            }else{
                $data['img']=$info['savepath'].$info['savename'];

                //是否略缩图
                if($data['thumb']==1){
                    img_thumb($config_img['rootPath'].$data['img'],$config['show_width'],$config['show_height']);

                    //添加水印
                    if($data['water']==1){
                        water($config_img['rootPath'].$data['img'],$config_img['rootPath'].$config['watermark']);
                    }

                }
            }

        }else{
            if(empty($data['img']) ){ return flase ; die();}

            //是否略缩图
            if($data['thumb']==1){
                $config=C('CONFIG');
                $config_img =C('UPLOAD');
                img_thumb($config_img['rootPath'].$data['img'],$config['show_width'],$config['show_height']);

                //添加水印
                if($data['water']==1){
                    water($config_img['rootPath'].$data['img'],$config_img['rootPath'].$config['watermark']);
                }
            }
           // $this->success('修改成功','index') ;
        }
    }



    //删除
    public function del(){
        $id=I('get.id/d');
        $model=D('Content');
        if( D('Content')->delete($id) ){
            $this->success('删除成功',U('index'));
        }else{
            $this->error( '错误'.$model->getError() );
        }
    }



    //ajax更新排序
    public function AjaxOrder(){
        IS_AJAX || die('error');
        $res=I('post./a');
        M('Content')->where(array('cont_id'=>$res['child_id']) )->save($res) ||  $this->ajaxReturn(array('status'=>0),'json');
    }



    /**
     * [category 移动分类]
     * @return [type] [description]
     */
    public function category(){
        $data=I('post.');
        
        $data['action'] || die($this->error('请选择...') );
        
        //删除
        if( $data['action']=='del' ){
            $ids=implode(',',$data['checkbox']);

            $model=D('Content');
            if( $model->where( array('cont_id'=>array('in',$ids))  )->delete() !=flase ){
                $this->success('删除成功',U('index'));
            }else{
                $this->error( '删除失败' );
            }
        }

        //移动分类
        if( $data['action']=='category_move' ){
            $data['action'] || die($this->error('请选择移动到那个分类...') );
            $model=D('Content');
            if( $model->category_move($data['checkbox'],$data['new_cat_id']) ){
                $this->success('移动成功',U('index'));
            }else{
                $this->error( '移动失败' );
            }
        }        

    }



        
}