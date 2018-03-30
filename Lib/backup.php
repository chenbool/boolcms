<?php
/**
*@filename string
*@tables array or string
*@retuen  bool 
*/
function backup($filename,$tables){
	
	//如果不是数组就压入数组
	if(!is_array($tables) ){
		$temp[]=$tables;
		$tables=$temp;
	}

	 //头部信息
	 $header = "-- -----------------------------\r\n";
	 $header .= "--BoolCMS MySQL Data Transfer--\r\n";
	 $header .= "-- 日期：".date("Y-m-d H:i:s",time())." --\r\n";
	 $header .= "-- -----------------------------\r\n\r\n";
	 file_put_contents($filename,$header) || die('导出失败!');
	 

	 //获取表结构
	 foreach ($tables as $v) {
		 $structure=M()->query('show create table '.$v);
		 $desc = "-- -----------------------------------\r\n";
		 $desc .= "-- Table structure for `".$structure[0]['table']."` --\r\n";
		 $desc .= "-- -----------------------------------\r\n";
		 $desc .= "DROP TABLE IF EXISTS `".$structure[0]['table']."`;\r\n";
		 $desc .= $structure[0]['create table'].";\r\n\r\n\r\n";
		 file_put_contents($filename,$desc,FILE_APPEND) || die('导出失败!');
	 }


	 //取出所有数据
    foreach($tables as $tableName){
        $all=M()->query('select * from '.$tableName);

        //判断取出的结果是否小于1
        if( count($all)<1 ){
        	continue;
        } 

        //insert头部信息
        $insert = "-- ---------------------------------\r\n";
        $insert .= "-- insert of `".$tableName."` --\r\n";
        $insert .= "-- ---------------------------------\r\n";
        file_put_contents($filename,$insert,FILE_APPEND) || die('导出失败!');

        foreach ($all as $k => $v) {

            $rows=" INSERT INTO `".$tableName."` VALUES (";

            //获取键值
            $values=array_values($v);

            //循环值拼接sql语句
            foreach ($values as $key => $value) {
                $rows .="'".$value."',";
            }
            //去除最后一个逗号
            $rows = substr($rows,0,strlen($sqlStr)-1);
            $rows .= ");\r\n";

            file_put_contents($filename,$rows,FILE_APPEND) || die('导出失败!');

        }
    }

    return true;
   
}

?>