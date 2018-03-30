<?php
namespace Admin\Controller;
use Think\Controller;
class ShowController extends PublicController {
    public function index(){
        //显示
        $res=D('show')->show();

        $this->assign(array(
            'show'  =>  $res['show'],
            'info'   =>  $res['info'],
        ));
        $this->display();
    }

    //添加
    public function add(){

        $id=I('post.id/d');
        $data=I('post./a');
        //修改
        if($id){
            $this->update($data,$id);
        }else{

            if($data){
                $this->img($data); //处理图片
                $model=D('Show');
                if( $model->create($data,1) ){
                    if( $model->add($data) ){
                        $this->success('添加成功',U('index'));
                        exit();
                    }
                }else{
                    $this->error( $model->getError() );
                }

            }
        }

    }

    //更新 修改
    public function update($data,$id){
            if($data){
                $this->img($data); //处理图片
                $model=D('Show');
                if( $model->create($data,2) ){
                    if( $model->save($data) !=false ){
                       die( $this->success('修改成功',U('Show/index/id/'.$id))  );
                    }
                }else{
                    die( $this->error( $model->getError() ) );
                }

            }


    }

    //删除
    public function delete(){
        $id=I('get.id/d');
        $model=D('Show');
       if( $model->where( array('id'=>$id) )->delete()  ){
           die( $this->success('修改成功',U('index') )  );
       }else{
           die( $this->error( $model->getError() ) );
       }
    }


    //图片处理类
    public function  img(&$data){
        if($_FILES['img']['error']==0){

            $info=upload_one($_FILES['img']);
            if(!info){
                die($this->error( '上传失败' ));
            }else{
                $data['img']=$info['savepath'].$info['savename'];

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
           $this->success('修改成功','index') ;
        }
    }






}