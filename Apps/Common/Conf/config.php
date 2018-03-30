<?php
return array(
	//'配置项'=>'配置值'

    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'boolcms', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'bool_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

    //数据库配置2
    'DB_CONFIG2' => 'mysql://root:@localhost:3306/information_schema',
    'SQL_PATH'  =>  '/Public/databases/',
    'SHOW_PAGE_TRACE'=>1,    //显示调试信息
    'CONFIG'    =>   require_once('./Config/config.php'),
    'UPLOAD'    =>   require_once('./Config/upload.php'),
    'WATER'    =>   require_once('./Config/water.php'),
    'VERIFY'    =>  require_once('./Config/verify.php'),
);