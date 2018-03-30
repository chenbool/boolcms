<?php
class mysqli_db{

    private $link=null;

	function __construct($host,$user,$pass,$database,$charset){	
		$this->link=mysqli_connect($host,$user,$pass,$database) or die("连接失败".mysqli_connect_error() );
		$this->link->set_charset($charset);
	}

	function exec_sql($sql){
		$this->link->query($sql);
	}


	function backup($path=""){
		
		$dbfile=$path; 
		$content=file_get_contents($dbfile); //获取创建的数据 
		
		//去掉注释 
		$content=preg_replace("/--.*\n/iU","",$content); 

		$drop=array();
		$carr=array(); 
		$iarr=array(); 

		//提取drop 
		preg_match_all("#DROP TABLE IF EXISTS `.+`;#",$content,$drop); 
		$drop=$drop[0]; 
		foreach($drop as $c) { 
			$this->exec_sql($c); 
		} 

		//提取create 
		preg_match_all("/Create table .*\(.*\).*\;/iUs",$content,$carr); 
		$carr=$carr[0]; 

		foreach($carr as $c) { 
			$this->exec_sql($c); 
		} 

		//提取insert 
		preg_match_all("/INSERT INTO .*\(.*\)\;/iUs",$content,$iarr); 
		$iarr=$iarr[0]; 
		//插入数据 
		foreach($iarr as $c) { 
			$this->exec_sql($c); 
		} 


	}


	function __destruct(){
		$this->link->close();
	}

} 

