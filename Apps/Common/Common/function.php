<?php
//写出php
function write_config($data,$path){
    return file_put_contents($path,'<?php return '.var_export($data,true).';' );
}

//上传图片
function upload_one($file){
    $config =C('UPLOAD'); //读取配置文件
    $upload = new \Think\Upload($config);// 实例化上传类

    // 上传文件
    $info   =   $upload->uploadOne($file);
    if(!$info) {
        // 上传错误提示错误信息
        return array(
            'error'       =>  $upload->getError(),
        );
    }else{
        // 上传成功 获取上传文件信息
        return $info;
    }
}

//略缩图
function img_thumb($path,$width=100,$height=100){
    $config =C('CONFIG'); //读取配置文件
    if( !(int)$config['thumb']){
        unlink($path) && die('请开启略缩<script> setTimeout("javascript:history.go(-1)",2000); </script> ' );
    }
    $image = new \Think\Image();

    //透明
    imagesavealpha($img, true);

    $image->open($path);
    // 按照原图的比例生成一个缩略图并保存
    return $image->thumb($width, $height)->save($path);
}


//添加水印
/**
 * @filename 文件名
 * @path 路径
 * @water 水印图片
 * @text水印文字
*/
function water($path,$water=''){
    $water_config=C('WATER');
    $config =C('CONFIG'); //读取配置文件
    if( !(int)$config['water']){
        unlink($path) && die( '请开启水印 <script> setTimeout("javascript:history.go(-1)",2000); </script> ' );
    }

    $image = new \Think\Image();
    //透明
    imagesavealpha($img, true);


    //检测是否开启字体水印
    if($water_config['font']==1){  
        return $image->open($path)->text($water_config['fonttext'],$water_config['fontpath'],$water_config['fontsize'],$water_config['fontcolor'],\Think\Image::IMAGE_WATER_SOUTHEAST)->save($path);
    }else{
        return $image->open($path)->water($water,\Think\Image::IMAGE_WATER_SOUTHEAST,$water_config['opacity'] )->save($path);
    }

}


//移除xss
function removeXSS($data){

    $path='./Public/htmlpurifier/HTMLPurifier.auto.php';

    //判断是否 是有效文件
    is_file($path) || die('HTMLPurifier url is not valid！');

    //引入
    require_once $path;

    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    //设置保留标签
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);

    //执行过滤
    return $_clean_xss_obj->purify($data);
}
