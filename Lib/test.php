<?php
class install{
private $dbhost;
private $dbname;
private $dbpw;
private $dbuser;
//初始化类
function __construct($dbhost='',$dbname='',$dbpw='',$dbuser=''){
$this->dbhost=$dbhost;
$this->dbname=$dbname;
$this->dbpw=$dbpw;
$this->dbuser=$dbuser;
}

//初始化数据库
function init_db(){
$file="../install/import.sql";
$conn=mysql_connect($this->dbhost,$this->dbuser,$this->dbpw) or die("数据库连接错误");
    $db=mysql_select_db($this->dbname);
    if($db){
mysql_query("DROP DATABASE `".$this->dbname."`");
    }
    mysql_query("setnames 'GBK'");
$creatdb=mysql_query("CREATE DATABASE `".$this->dbname."` DEFAULT CHARACTER SET gb2312 COLLATE gb2312_bin");//建立数据库
$mysql=mysql_select_db($this->dbname);
$content=file($file); //转换为数组
foreach($content as $key=>$val){     //遍历，删除注释
$flag=substr($val,0,2);	 //去前两位字符
if($flag=="--"){                 //判断是否为注释
$content[$key]="";           //删除
}
}
$content=implode("",$content);         //转换为字符串
$content=trim($content);
$content=explode(";\n",$content);      //转换为数组
foreach($content as $key=>$val){     //遍历执行
mysql_query($val);
}
}



}