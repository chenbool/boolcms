<?php
/**
 * 得到操作系统信息
 * @return string
 */
function get_system() {
    $sys = $_SERVER['HTTP_USER_AGENT'];

    if (stripos($sys, "NT 6.1")) {
        $os = "Windows 7";
    } else if (stripos($sys, "NT 6.0")) {
        $os = "Windows Vista";
    }  else if (stripos($sys, "NT 5.1")) {
        $os = "Windows XP";
    } else if (stripos($sys, "NT 5.2")) {
        $os = "Windows Server 2003";
    } else if (stripos($sys, "NT 5")) {
        $os = "Windows 2000";
    } else if (stripos($sys, "NT 4.9")) {
        $os = "Windows ME";
    } else if (stripos($sys, "NT 4")) {
        $os = "Windows NT 4.0";
    } else if (stripos($sys, "98")) {
        $os = "Windows 98";
    } else if (stripos($sys, "95")) {
        $os = "Windows 95";
    } else if (stripos($sys, "Mac")) {
        $os = "Mac";
    } else if (stripos($sys, "Linux")) {
        $os = "Linux";
    } else if (stripos($sys, "Unix")) {
        $os = "Unix";
    } else if (stripos($sys, "FreeBSD")) {
        $os = "FreeBSD";
    } else if (stripos($sys, "SunOS")) {
        $os = "SunOS";
    } else if (stripos($sys, "BeOS")) {
        $os = "BeOS";
    } else if (stripos($sys, "OS/2")) {
        $os = "OS/2";
    } else if (stripos($sys, "PC")) {
        $os = "Macintosh";
    } else if(stripos($sys, "AIX")) {
        $os = "AIX";
    } else {
        $os = "未知操作系统";
    }

    return $os;
}


//转换文件大小
function transByte($size){

    $arr=array('B','KB','MB','GB','TB','EB');
    $i=0;
    while ( $size>=1024) {
        $size/=1024;
        $i++;
    }

    return round($size,2).$arr[$i];
}

//备份数据库
function backup_mysql($filename,$tables){
    include './Lib/backup.php';
    return backup( $filename,$tables );
}


//恢复数据库
function source_mysql($filename){
    include './Lib/source.php';
    $db=New mysqli_db(C('DB_HOST'),C('DB_USER'),C('DB_PWD'),C('DB_NAME'),C('DB_CHARSET'));
    return $db->backup($filename);
}

//打开指定目录
/**
 * 遍历目录函数，只读取目录中的最外层的内容
 * @param string $path
 * @return array
 */
function readDirectory($path) {
    $handle = opendir ( $path );
    while ( ($item = readdir ( $handle )) !== false ) {
        //.和..这2个特殊目录
        if ($item != "." && $item != "..") {
            if (is_file ( $path . "/" . $item )) {
                $arr ['file'] [] = $item;
            }
            if (is_dir ( $path . "/" . $item )) {
                $arr ['dir'] [] = $item;
            }
        
        }
    }
    closedir ( $handle );
    return $arr;
}


//下载
function downFile($filename){
    header("content-disposition:attachment;filename=".basename($filename));
    header("content-length:".filesize($filename));
    readfile($filename);
}

