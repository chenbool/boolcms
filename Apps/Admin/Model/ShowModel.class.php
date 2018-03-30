<?php
namespace Admin\Model;
use Think\Model;

class ShowModel extends Model {

    protected $insertFields =  'title,link,sort,status,thumb,water,img';
    protected $updateFields =   'title,img,link,sort,status,thumb,water,id';

    //验证规则
    protected $_validate = array(
        array('title','require','幻灯名不能为空',1),
        array('link','url','无效的url地址',2),
        array('sort','number','排序只能为数值类型',1),
        array('status','number','状态只能为数值类型',1),
        array('title', '1,30', '导航栏名最长不能超过 30 个字符！', 1, 'length', 3),
    );

    //自动完成
    protected $_auto = array (
        array('add_time','time',1,'function'), // 对add_time字段在新增的时候写入当前时间戳
    );

    //插入之前
    protected  function _before_insert(&$data, $option){
//        if($_FILES['img']['error']==0){
//            $info=upload_one($_FILES['img']);
//            if(!info){
//                $this->error='图片上传失败!';
//                return false;
//            }else{
//                $data['img']=$info['savepath'].$info['savename'];
//
//                //是否略缩图
//                if($data['thumb']==1){
//                    $config=C('CONFIG');
//                    $config_img =C('UPLOAD');
//                    img_thumb($info['savename'],$config_img['rootPath'].$info['savepath'],$config['show_width'],$config['show_height']);
//
//                    //添加水印
//                    if($data['water']==1){
//                      water($config_img['rootPath'].$info['savepath'].$info['savename'],$config_img['rootPath'].$config['watermark']);
//                    }
//
//                }
//            }
//
//
//
//        }else{
//            $this->error='图片不存在1';
//            return false;
//        }
    }

    //更新之前
    protected function _before_update(&$data, $option){
        if($_FILES['img']['error']==0){
            $res=$this->where( array('id'=>$option['where']['id']) )->find();
            $upload_config=C('UPLOAD');
            unlink($upload_config['rootPath'].$res['img']);
        }

    }

    //删除之前
    protected function _before_delete($option){
        echo $option['where']['id'];
        $img=$this->where(array('id'=>$option['where']['id']))->field('img')->find();
        //删除
        $upload_config=C('UPLOAD');
        unlink($upload_config['rootPath'].$img['img']);
    }

    //删除之后
    protected function _after_delete($option){
//        $id=$option['child_id'];
    }


    //显示
    public function show(){
        $info='';
        //有id就查找信息
        if( $id=I('get.id/d') ){
            $info=$this->where( array( 'id'=>$id ) )->find();
        }

        $show=$this->where( array( 'status'=>0 ) )->order('sort asc')->select();

        return array(
            'show'  =>  $show,
            'info'  => $info,
        );
    }
    
}