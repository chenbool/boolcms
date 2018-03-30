-- -----------------------------
--BoolCMS MySQL Data Transfer--
-- 日期：2016-06-29 12:48:05 --
-- -----------------------------

-- -----------------------------------
-- Table structure for `bool_menu` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_menu`;
CREATE TABLE `bool_menu` (
  `child_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` mediumint(9) unsigned NOT NULL,
  `cat_name` varchar(16) NOT NULL COMMENT '分类名称',
  `link` varchar(100) DEFAULT NULL COMMENT '描述',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `type` enum('top','bottom','main') NOT NULL DEFAULT 'main' COMMENT '导航类型',
  `add_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='菜单表';


-- -----------------------------------
-- Table structure for `bool_category` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_category`;
CREATE TABLE `bool_category` (
  `child_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` mediumint(9) unsigned NOT NULL,
  `cat_name` varchar(16) NOT NULL COMMENT '分类名称',
  `desc` varchar(150) NOT NULL,
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `add_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='菜单表';


-- -----------------------------------
-- Table structure for `bool_show` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_show`;
CREATE TABLE `bool_show` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `img` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `sort` tinyint(4) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='幻灯广告';


-- -----------------------------------
-- Table structure for `bool_page` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_page`;
CREATE TABLE `bool_page` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `alias` varchar(60) NOT NULL,
  `parent_id` mediumint(9) NOT NULL,
  `content` mediumtext NOT NULL,
  `keywords` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='单页';


-- -----------------------------------
-- Table structure for `bool_content_desc` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_content_desc`;
CREATE TABLE `bool_content_desc` (
  `cont_id` mediumint(9) unsigned NOT NULL COMMENT '关联文章id',
  `content` mediumtext NOT NULL COMMENT '文件内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章内容表';


-- -----------------------------------
-- Table structure for `bool_admin` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_admin`;
CREATE TABLE `bool_admin` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否被禁止 ：0 正常  1 禁用',
  `last_ip` varchar(30) DEFAULT NULL COMMENT '最后登录ip',
  `last_time` int(11) unsigned DEFAULT NULL COMMENT '最后登录时间',
  `email` varchar(30) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';


-- -----------------------------------
-- Table structure for `bool_content` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_content`;
CREATE TABLE `bool_content` (
  `cont_id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL COMMENT '文章标题',
  `author` varchar(16) NOT NULL DEFAULT '' COMMENT '发布作者',
  `img` varchar(80) DEFAULT NULL COMMENT '略缩图',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键字',
  `desc` varchar(100) DEFAULT NULL COMMENT '描述',
  `click` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `add_time` int(11) unsigned NOT NULL COMMENT '发布时间',
  `sort` mediumint(5) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `parent_id` mediumint(9) unsigned DEFAULT '0',
  PRIMARY KEY (`cont_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='文章表';


-- -----------------------------------
-- Table structure for `bool_config` --
-- -----------------------------------
DROP TABLE IF EXISTS `bool_config`;
CREATE TABLE `bool_config` (
  `name` varchar(60) NOT NULL COMMENT '名称',
  `value` mediumtext NOT NULL COMMENT '值',
  `type` varchar(20) NOT NULL DEFAULT 'text' COMMENT '类型',
  `tab` enum('main') NOT NULL COMMENT 'main',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '10',
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置表';


-- ---------------------------------
-- insert of `bool_menu` --
-- ---------------------------------
 INSERT INTO `bool_menu` VALUES ('1','0','首页','这是首页11111','0','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('2','0','关于我们','公司介绍1','1','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('3','0','公司简介','http://www.baidu.com/11111111111111111111111111111111111111111111111111111111111111','0','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('4','2','发展历程','','1','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('5','0','产品中心','','2','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('6','0','新闻动态','','3','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('7','0','加入我们','','4','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('8','0','联系我们','','5','0','main','1466650847');
 INSERT INTO `bool_menu` VALUES ('11','0','官方网站','','0','0','top','1466650847');
 INSERT INTO `bool_menu` VALUES ('12','0','反馈建议','','1','0','top','1466650918');
 INSERT INTO `bool_menu` VALUES ('13','0','技术交流','','2','0','top','1466650950');
 INSERT INTO `bool_menu` VALUES ('14','0','帮助','','3','0','top','1466650962');
 INSERT INTO `bool_menu` VALUES ('15','0','公司简介','','0','0','bottom','1466651549');
 INSERT INTO `bool_menu` VALUES ('16','0','人才招聘','','1','0','bottom','1466651582');
 INSERT INTO `bool_menu` VALUES ('17','0','联系我们','','2','0','bottom','1466651594');
 INSERT INTO `bool_menu` VALUES ('18','0','官网','','50','0','main','1467170942');
-- ---------------------------------
-- insert of `bool_category` --
-- ---------------------------------
 INSERT INTO `bool_category` VALUES ('2','0','关于我们','1法的规定风格的歌事实上是事实是事实是事实是事实上事实上是事实是事实是事实是事实上是事实是事实是事实事实上身上淡淡的淡淡的淡','2','0','1466650847');
 INSERT INTO `bool_category` VALUES ('3','0','公司简介','1','0','0','1466650847');
 INSERT INTO `bool_category` VALUES ('4','2','发展历程','dfesc','10','0','1466650847');
 INSERT INTO `bool_category` VALUES ('18','3','测试','这只是一个测试页面','1','0','1467023602');
-- ---------------------------------
-- insert of `bool_show` --
-- ---------------------------------
 INSERT INTO `bool_show` VALUES ('45','测试1','Uploads/20160629/577351d586557.jpg','','10','0','0');
 INSERT INTO `bool_show` VALUES ('46','测试2','Uploads/20160629/5773520f4f516.jpg','','1','0','0');
 INSERT INTO `bool_show` VALUES ('47','测试3','Uploads/20160629/5773520155f57.jpg','','2','0','0');
 INSERT INTO `bool_show` VALUES ('48','测试4','Uploads/20160629/5773521ddbe71.jpg','','10','0','0');
-- ---------------------------------
-- insert of `bool_page` --
-- ---------------------------------
 INSERT INTO `bool_page` VALUES ('1','关于我们','about','4','111111111111','11','111');
 INSERT INTO `bool_page` VALUES ('2','公司简介','info','3','这里是公司简介','这里是公司简介','这里是公司简介');
 INSERT INTO `bool_page` VALUES ('3','发展历程','fazhan','4','&lt;p&gt;
	333333333333333333333333333333
&lt;/p&gt;
&lt;p&gt;
	啦啦啦啦
&lt;/p&gt;','123','123');
-- ---------------------------------
-- insert of `bool_content_desc` --
-- ---------------------------------
 INSERT INTO `bool_content_desc` VALUES ('20','<strong>111111111111111ddddddddddddddddddddddddd</strong>');
 INSERT INTO `bool_content_desc` VALUES ('21','1111111111111111');
-- ---------------------------------
-- insert of `bool_admin` --
-- ---------------------------------
 INSERT INTO `bool_admin` VALUES ('1','admin','c3284d0f94606de1fd2af172aba15bf3','0','127.0.0.1','1467113954','81001985@qq.com','1467113954');
 INSERT INTO `bool_admin` VALUES ('2','bool','c506ff134babdd6e68ab3e6350e95305','0','127.0.0.1','1467113954','81001985@qq.com','1467113954');
-- ---------------------------------
-- insert of `bool_content` --
-- ---------------------------------
 INSERT INTO `bool_content` VALUES ('20','1111111111','','Uploads/20160628/577240afedf6d.png','11111','11111eee','0','1467102676','1','0','0','1','3');
 INSERT INTO `bool_content` VALUES ('21','111','','','11','11','0','1467105649','10','1','0','0','0');
