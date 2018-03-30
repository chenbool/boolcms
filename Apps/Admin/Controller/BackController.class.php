<?php
namespace Admin\Controller;
use Think\Controller;
class BackController extends PublicController {
    //首页
    public function index(){
        //查询表信息
        $database=C('DB_NAME');
        $sql="select table_name,engine,table_rows,data_length,index_length,create_time,table_collation,table_comment,data_free from tables where table_schema='".C('DB_NAME')."' order by table_rows desc";
        $res=M()->db(2,C('DB_CONFIG2') )->query($sql);

        $this->assign('tables',$res);


        $this->display();
    }


    //备份
    public function backup(){
        
        if(IS_POST){
            // $data=I('post.tables');
            // dump($data);die;
            $rootpath=str_replace('\\','/',dirname(THINK_PATH));
            $filename=$rootpath.C('SQL_PATH').I('post.file_name/s').'.sql';
            
            backup_mysql($filename,I('post.tables')) && die($this->success('备份成功',U('Back/recovery') ));
        }

    }

    //恢复页面
    public function recovery(){
            $rootpath=str_replace('\\','/',dirname(THINK_PATH));
            $path=$rootpath.C('SQL_PATH');
            $dir=readDirectory($path);
            krsort($dir['file']);   //对数组排序
            $this->assign(array(
                'path'  =>  $path,
                'list'  =>  $dir['file'],  
            ));
        $this->display();
    }

    //下载
    public function downfile(){
        $rootpath=str_replace('\\','/',dirname(THINK_PATH));
        $path=$rootpath.C('SQL_PATH');
        $file=I('get.file/s');
        downFile($path.$file);
    }

    //恢复
    public function back(){
        $rootpath=str_replace('\\','/',dirname(THINK_PATH));
        $path=$rootpath.C('SQL_PATH');
        $file=I('get.file/s');
        source_mysql($path.$file) ;
        die($this->success('恢复成功',U('Back/recovery') ) );
    }



    /**
    *删除
     */
    public function delete(){
        $rootpath=str_replace('\\','/',dirname(THINK_PATH));
        $path=$rootpath.C('SQL_PATH');
        $file=I('get.file/s');
        
        if ( unlink($path.$file)  ){
            $this->success('删除成功',U('Back/recovery') ) ;
        }else{
            $this->error('删除失败');
        }
       
    }

}