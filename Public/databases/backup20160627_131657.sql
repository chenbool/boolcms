-- -----------------------------
--BoolCMS MySQL Data Transfer--
-- 日期：2016-06-27 13:17:04 --
-- -----------------------------

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


-- ---------------------------------
-- insert of `bool_page` --
-- ---------------------------------
 INSERT INTO `bool_page` VALUES ('1','关于我们','about','4','111111111111','11','111');
 INSERT INTO `bool_page` VALUES ('2','公司简介','info','3','111111','11111','11111');
 INSERT INTO `bool_page` VALUES ('3','发展历程','fazhan','4','&lt;p&gt;
	333333333333333333333333333333
&lt;/p&gt;
&lt;p&gt;
	啦啦啦啦
&lt;/p&gt;','123','123');
