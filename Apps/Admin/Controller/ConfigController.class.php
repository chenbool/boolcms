<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends PublicController {
    public function index(){
        $config=C('CONFIG');
        $config_img =C('UPLOAD');

        if(IS_POST){
            $data=I('post./a');
 
            //判断是否有文件上传
            if($_FILES['logo']['error']==0){
                //删除原来的图片
                is_file( $config_img['rootPath'].$data['logo'] ) && unlink($config_img['rootPath'].$data['logo']);

                $info=upload_one($_FILES['logo']);  //上传图片

                isset($info['error']) && die( $this->error($info['error']) );   //检测是否上传错误

                //略缩图
                // img_thumb( $config_img['rootPath'].$info['savepath'].$info['savename'],$config['logo_width'],$config['logo_height'] );
                $data['logo']=$info['savepath'].$info['savename'];
            }

            //水印
            if($_FILES['watermark']['error']==0){
                //删除原来的图片
                is_file( $config_img['rootPath'].$data['watermark'] ) && unlink($config_img['rootPath'].$data['watermark']);

                $info=upload_one($_FILES['watermark']);  //上传图片

                isset($info['error']) && die( $this->error($info['error']) );   //检测是否上传错误
                //略缩图
                img_thumb( $config_img['rootPath'].$info['savepath'].$info['savename'],$config['watermark_width'],$config['watermark_height'] );
                $data['watermark']=$info['savepath'].$info['savename'];
            }


            if( write_config( $data,'./Config/config.php' )  ){
                die( $this->success('修改成功') );

            }
        }
        $this->assign('config',$config)->display();
    }
}