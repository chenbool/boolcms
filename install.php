<?php
/**
 * BoolCMS 内容管理系统安装程序
 * 使用方式：浏览器访问此文件，填写数据库信息后点击安装
 * 安全提示：安装完成后请立即删除此文件
 */

$lockFile = __DIR__ . '/install.lock';

// 检查是否已安装
if (file_exists($lockFile)) {
    exit('<!DOCTYPE html><html><head><meta charset="utf-8"><title>系统已安装</title><style>body{background:#f5f5f5;padding-top:80px}.box{width:360px;margin:0 auto;background:#fff;padding:30px;border-radius:4px;box-shadow:0 2px 10px rgba(0,0,0,.1);text-align:center}h2{color:#333;margin-bottom:15px}p{color:#666;margin-bottom:20px}.btn{background:#00a2ff;color:#fff;padding:8px 20px;border-radius:3px;border:none;cursor:pointer}.red{color:#dd514c}</style></head><body><div class="box"><h2>✓ 系统已安装</h2><p>如需重新安装，请先删除 install.lock 文件</p><p class="red">install.lock</p><button class="btn" onclick="location.reload()">刷新页面</button></div></body></html>');
}

// 处理安装请求
if (isset($_POST['host'], $_POST['username'], $_POST['db'])) {
    // 获取表单数据
    $dbHost = trim($_POST['host']);
    $dbUsername = trim($_POST['username']);
    $dbPassword = $_POST['password'];
    $dbName = trim($_POST['db']);
    $dbPrefix = trim($_POST['prefix']) ?: 'bool_';
    
    // 连接数据库
    $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword);
    if ($mysqli->connect_errno) {
        exit('<center style="margin-top:100px"><h2 style="color:#dd514c">连接数据库失败</h2><p>' . $mysqli->connect_error . '</p><br><a href="javascript:history.back()" style="background:#00a2ff;color:#fff;padding:8px 20px;border-radius:3px;text-decoration:none">返回重试</a></center>');
    }
    
    // 创建数据库
    $mysqli->query("CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
    $mysqli->select_db($dbName);
    
    // 导入SQL文件
    $sqlFile = __DIR__ . '/bool_admin.sql';
    if (!file_exists($sqlFile)) {
        exit('<center style="margin-top:100px"><h2 style="color:#dd514c">SQL文件不存在</h2><p>请确保 bool_admin.sql 文件存在于项目根目录</p></center>');
    }
    $sql = str_replace('`bool_', '`' . $dbPrefix, file_get_contents($sqlFile));
    $mysqli->multi_query($sql);
    do { if ($r = $mysqli->store_result()) $r->free(); } while ($mysqli->more_results() && $mysqli->next_result());
    $mysqli->close();
    
    // 写入数据库配置文件
    file_put_contents(__DIR__ . '/Apps/Common/Conf/config.php', "<?php\nreturn array(\n    'DB_TYPE'   => 'mysql',\n    'DB_HOST'   => '{$dbHost}',\n    'DB_NAME'   => '{$dbName}',\n    'DB_USER'   => '{$dbUsername}',\n    'DB_PWD'    => '{$dbPassword}',\n    'DB_PORT'   => 3306,\n    'DB_PREFIX' => '{$dbPrefix}',\n    'DB_CHARSET'=> 'utf8',\n);");
    
    // 创建安装锁定文件
    file_put_contents($lockFile, date('Y-m-d H:i:s'));
    
    // 显示安装成功页面
    exit('<!DOCTYPE html><html><head><meta charset="utf-8"><title>安装成功</title><style>body{background:#f5f5f5;padding-top:80px}.box{width:360px;margin:0 auto;background:#fff;padding:30px;border-radius:4px;box-shadow:0 2px 10px rgba(0,0,0,.1);text-align:center}.ok{font-size:48px;color:#5eb95e;margin-bottom:15px}h2{color:#333;margin-bottom:10px}p{color:#666;margin-bottom:20px}.btn{display:inline-block;background:#00a2ff;color:#fff;padding:10px 30px;border-radius:3px;text-decoration:none}.warn{color:#dd514c;font-size:12px;margin-top:15px}</style></head><body><div class="box"><div class="ok">✓</div><h2>安装成功</h2><p>数据库配置已完成</p><a href="./admin.php" class="btn">进入后台</a><p class="warn">⚠ 请立即删除 install.php 文件！</p></div></body></html>');
}

// 显示安装表单页面
?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>系统安装</title><style>body{background:#2d3a4b;padding-top:60px;font-family:"Microsoft YaHei",sans-serif}.box{width:380px;margin:0 auto;background:#fff;padding:25px 30px;border-radius:4px;box-shadow:0 4px 20px rgba(0,0,0,.2)}.head{text-align:center;margin-bottom:20px;padding-bottom:15px;border-bottom:1px solid #eee}.head h2{color:#333;margin:0;font-size:20px}.head p{color:#999;margin:5px 0 0;font-size:12px}.group{margin-bottom:12px}.group label{display:block;margin-bottom:5px;color:#555;font-size:13px}.group label .red{color:#dd514c}.input{width:100%;height:34px;padding:0 10px;border:1px solid #ddd;border-radius:3px;font-size:13px;box-sizing:border-box}.input:focus{border-color:#00a2ff;outline:none}.btn{width:100%;height:38px;background:#00a2ff;color:#fff;border:none;border-radius:3px;font-size:14px;cursor:pointer;margin-top:10px}.btn:hover{background:#0088dd}.tips{margin-top:15px;padding-top:15px;border-top:1px solid #eee;font-size:12px;color:#999;text-align:center}.tips .red{color:#dd514c}</style></head><body><div class="box"><div class="head"><h2>� BoolCMS 内容管理系统</h2><p>请填写数据库连接信息</p></div><form method="post"><div class="group"><label>数据库主机 <span class="red">*</span></label><input type="text" class="input" name="host" value="localhost" required></div><div class="group"><label>数据库账号 <span class="red">*</span></label><input type="text" class="input" name="username" value="root" required></div><div class="group"><label>数据库密码</label><input type="password" class="input" name="password"></div><div class="group"><label>数据库名称 <span class="red">*</span></label><input type="text" class="input" name="db" value="boolcms" required></div><div class="group"><label>数据表前缀</label><input type="text" class="input" name="prefix" value="bool_"></div><button type="submit" class="btn">开始安装</button></form><div class="tips"><p>请确保 MySQL 服务已启动</p><p class="red">安装完成后请删除此文件</p></div></div></body></html>
