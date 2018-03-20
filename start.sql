# Host: localhost  (Version 5.5.53)
# Date: 2017-12-21 09:36:32
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "zf_action"
#

DROP TABLE IF EXISTS `zf_action`;
CREATE TABLE `zf_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

#
# Data for table "zf_action"
#

/*!40000 ALTER TABLE `zf_action` DISABLE KEYS */;
INSERT INTO `zf_action` VALUES (1,'user_login','用户登录','积分+10，每天一次','table:member|field:score|condition:uid={$self} AND status>-1|rule:score+10|cycle:24|max:1;','[user|get_nickname]在[time|time_format]登录了后台',1,1,1387181220),(2,'add_article','发布文章','积分+5，每天上限5次','table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:5','',2,0,1380173180),(3,'review','评论','评论积分+1，无限制','table:member|field:score|condition:uid={$self}|rule:score+1','',2,1,1383285646),(4,'add_document','发表文档','积分+10，每天上限5次','table:member|field:score|condition:uid={$self}|rule:score+10|cycle:24|max:5','[user|get_nickname]在[time|time_format]发表了一篇文章。\r\n表[model]，记录编号[record]。',2,0,1386139726),(5,'add_document_topic','发表讨论','积分+5，每天上限10次','table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:10','',2,0,1383285551),(6,'update_config','更新配置','新增或修改或删除配置','','',1,1,1383294988),(7,'update_model','更新模型','新增或修改模型','','',1,1,1383295057),(8,'update_attribute','更新属性','新增或更新或删除属性','','',1,1,1383295963),(9,'update_channel','更新导航','新增或修改或删除导航','','',1,1,1383296301),(10,'update_menu','更新菜单','新增或修改或删除菜单','','',1,1,1383296392),(11,'update_category','更新分类','新增或修改或删除分类','','',1,1,1383296765);
/*!40000 ALTER TABLE `zf_action` ENABLE KEYS */;

#
# Structure for table "zf_action_log"
#

DROP TABLE IF EXISTS `zf_action_log`;
CREATE TABLE `zf_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1075 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

#
# Data for table "zf_action_log"
#

/*!40000 ALTER TABLE `zf_action_log` DISABLE KEYS */;
INSERT INTO `zf_action_log` VALUES (1,1,1,-1930421299,'member',1,'zhang在2017-07-20 12:40登录了后台',1,1500525638),(2,6,1,-1930421299,'config',25,'操作url：/index.php?s=/Admin/Config/edit.html',1,1500531113),(3,8,1,-1930421299,'attribute',33,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531487),(4,8,1,-1930421299,'attribute',34,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531499),(5,8,1,-1930421299,'attribute',35,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531516),(6,8,1,-1930421299,'attribute',36,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531553),(7,8,1,-1930421299,'attribute',37,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531582),(8,8,1,-1930421299,'attribute',38,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531619),(9,8,1,-1930421299,'attribute',39,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531672),(10,8,1,-1930421299,'attribute',40,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531723),(11,8,1,-1930421299,'attribute',41,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531749),(12,8,1,-1930421299,'attribute',42,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500531783),(13,7,1,-1930421299,'model',4,'操作url：/index.php?s=/Admin/Model/update.html',1,1500531885),(14,8,1,-1930421299,'attribute',43,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500532184),(15,8,1,-1930421299,'attribute',44,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500532721),(16,8,1,-1930421299,'attribute',45,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500532732),(17,7,1,-1930421299,'model',5,'操作url：/index.php?s=/Admin/Model/update.html',1,1500533057),(18,1,2,-1930421299,'member',2,'chen在2017-07-20 14:51登录了后台',1,1500533482),(19,1,2,-1930421299,'member',2,'chen在2017-07-20 14:54登录了后台',1,1500533655),(20,1,1,-1930421299,'member',1,'zhang在2017-07-20 14:54登录了后台',1,1500533672),(21,1,1,-1930421299,'member',1,'zhang在2017-07-20 14:55登录了后台',1,1500533754),(22,1,2,-1930421299,'member',2,'chen在2017-07-20 15:11登录了后台',1,1500534670),(23,1,1,-1930421299,'member',1,'zhang在2017-07-20 15:18登录了后台',1,1500535102),(24,8,1,-1930421299,'attribute',46,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500537486),(25,8,1,-1930421299,'attribute',47,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500537555),(26,8,1,-1930421299,'attribute',48,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500537704),(27,8,1,-1930421299,'attribute',49,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500537818),(28,8,1,-1930421299,'attribute',50,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500537971),(29,8,1,-1930421299,'attribute',51,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500537985),(30,8,1,-1930421299,'attribute',52,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500538023),(31,8,1,-1930421299,'attribute',53,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500540002),(32,8,1,-1930421299,'attribute',54,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500540026),(33,8,1,-1930421299,'attribute',55,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500540052),(34,8,1,-1930421299,'attribute',56,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500540085),(35,8,1,-1930421299,'attribute',57,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500540098),(36,8,1,-1930421299,'attribute',58,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500540118),(37,8,1,-1930421299,'attribute',58,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500542544),(38,8,1,-1930421299,'attribute',49,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500543042),(39,8,1,-1930421299,'attribute',49,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500543058),(40,8,1,-1930421299,'attribute',59,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544283),(41,8,1,-1930421299,'attribute',60,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544450),(42,8,1,-1930421299,'attribute',61,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544466),(43,8,1,-1930421299,'attribute',62,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544536),(44,8,1,-1930421299,'attribute',63,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544548),(45,8,1,-1930421299,'attribute',64,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544563),(46,8,1,-1930421299,'attribute',65,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544606),(47,8,1,-1930421299,'attribute',66,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544625),(48,8,1,-1930421299,'attribute',67,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544633),(49,8,1,-1930421299,'attribute',68,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544673),(50,8,1,-1930421299,'attribute',69,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544686),(51,8,1,-1930421299,'attribute',70,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544694),(52,8,1,-1930421299,'attribute',71,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544707),(53,8,1,-1930421299,'attribute',72,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544778),(54,8,1,-1930421299,'attribute',73,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544789),(55,8,1,-1930421299,'attribute',74,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544799),(56,8,1,-1930421299,'attribute',75,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544818),(57,8,1,-1930421299,'attribute',76,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544841),(58,8,1,-1930421299,'attribute',77,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544851),(59,8,1,-1930421299,'attribute',78,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544919),(60,8,1,-1930421299,'attribute',79,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544940),(61,8,1,-1930421299,'attribute',80,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544952),(62,8,1,-1930421299,'attribute',81,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544961),(63,8,1,-1930421299,'attribute',82,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500544973),(64,8,1,-1930421299,'attribute',83,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545016),(65,8,1,-1930421299,'attribute',84,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545028),(66,8,1,-1930421299,'attribute',85,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545064),(67,8,1,-1930421299,'attribute',86,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545080),(68,8,1,-1930421299,'attribute',87,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545106),(69,8,1,-1930421299,'attribute',88,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545148),(70,8,1,-1930421299,'attribute',89,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500545157),(71,1,1,-1930421299,'member',1,'zhang在2017-07-21 09:04登录了后台',1,1500599042),(72,8,1,-1930421299,'attribute',89,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500599793),(73,8,1,-1930421299,'attribute',89,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500599917),(74,1,1,-1930421299,'member',1,'zhang在2017-07-21 10:39登录了后台',1,1500604780),(75,7,1,-1930421299,'model',17,'操作url：/index.php?s=/Admin/Model/update.html',1,1500604941),(76,7,1,-1930421299,'model',18,'操作url：/index.php?s=/Admin/Model/update.html',1,1500604972),(77,1,1,-1930421299,'member',1,'zhang在2017-07-21 10:43登录了后台',1,1500605034),(78,7,1,-1930421299,'model',19,'操作url：/index.php?s=/Admin/Model/update.html',1,1500605048),(79,7,1,-1930421299,'model',20,'操作url：/index.php?s=/Admin/Model/update.html',1,1500605084),(80,7,1,-1930421299,'model',21,'操作url：/index.php?s=/Admin/Model/update.html',1,1500605102),(81,8,1,-1930421299,'attribute',90,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605230),(82,8,1,-1930421299,'attribute',91,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605268),(83,8,1,-1930421299,'attribute',92,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605292),(84,8,1,-1930421299,'attribute',93,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605316),(85,8,1,-1930421299,'attribute',94,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605371),(86,8,1,-1930421299,'attribute',95,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605413),(87,8,1,-1930421299,'attribute',96,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605477),(88,8,1,-1930421299,'attribute',97,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605518),(89,8,1,-1930421299,'attribute',98,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605551),(90,8,1,-1930421299,'attribute',99,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605568),(91,8,1,-1930421299,'attribute',100,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605918),(92,8,1,-1930421299,'attribute',101,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500605939),(93,8,1,-1930421299,'attribute',102,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500606126),(94,1,1,-1930421299,'member',1,'zhang在2017-07-21 11:58登录了后台',1,1500609525),(95,8,1,-1930421299,'attribute',103,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609570),(96,8,1,-1930421299,'attribute',104,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609588),(97,8,1,-1930421299,'attribute',105,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609607),(98,8,1,-1930421299,'attribute',106,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609622),(99,8,1,-1930421299,'attribute',107,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609642),(100,8,1,-1930421299,'attribute',108,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609657),(101,8,1,-1930421299,'attribute',109,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609674),(102,8,1,-1930421299,'attribute',110,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609695),(103,8,1,-1930421299,'attribute',111,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609713),(104,8,1,-1930421299,'attribute',112,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609751),(105,8,1,-1930421299,'attribute',113,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609774),(106,8,1,-1930421299,'attribute',114,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500609800),(107,8,1,-1930421299,'attribute',115,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610074),(108,8,1,-1930421299,'attribute',116,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610103),(109,8,1,-1930421299,'attribute',117,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610122),(110,8,1,-1930421299,'attribute',118,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610179),(111,8,1,-1930421299,'attribute',119,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610221),(112,8,1,-1930421299,'attribute',120,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610245),(113,8,1,-1930421299,'attribute',121,'操作url：/index.php?s=/Admin/Attribute/update.html',1,1500610264),(114,1,1,-1930421299,'member',1,'zhang在2017-07-21 14:42登录了后台',1,1500619357),(115,10,1,0,'Menu',122,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500622697),(116,10,1,0,'Menu',123,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500623133),(117,10,1,0,'Menu',123,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500623155),(118,8,1,0,'attribute',122,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500623397),(119,7,1,0,'model',7,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500623440),(120,8,1,0,'attribute',122,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500623474),(121,7,1,0,'model',7,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500623505),(122,7,1,0,'model',7,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500623632),(123,10,1,0,'Menu',124,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500624874),(124,10,1,0,'Menu',123,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500625145),(125,7,1,0,'model',7,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500625178),(126,10,1,0,'Menu',122,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500625409),(127,10,1,0,'Menu',122,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500626963),(128,10,1,0,'Menu',122,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500626969),(129,10,1,0,'Menu',123,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500626982),(130,10,1,0,'Menu',123,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500629170),(131,10,1,0,'Menu',124,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500629178),(132,10,1,0,'Menu',122,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500629188),(133,10,1,0,'Menu',125,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500629240),(134,10,1,0,'Menu',125,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500629254),(135,10,1,0,'Menu',126,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500629361),(136,10,1,0,'Menu',126,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500629377),(137,1,1,0,'member',1,'zhang在2017-07-22 17:02登录了后台',1,1500714125),(138,1,1,0,'member',1,'zhang在2017-07-22 18:07登录了后台',1,1500718065),(139,8,1,0,'attribute',123,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500720350),(140,7,1,0,'model',8,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500720600),(141,10,1,0,'Menu',127,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500727329),(142,10,1,0,'Menu',127,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1500727402),(143,1,1,0,'member',1,'zhang在2017-07-23 11:51登录了后台',1,1500781909),(144,1,1,0,'member',1,'zhang在2017-07-23 17:14登录了后台',1,1500801274),(145,10,1,0,'Menu',128,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1500806051),(146,1,1,0,'member',1,'zhang在2017-07-24 09:24登录了后台',1,1500859487),(147,8,1,0,'attribute',52,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500859826),(148,1,1,0,'member',1,'zhang在2017-07-24 15:11登录了后台',1,1500880291),(149,7,1,0,'model',5,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500888492),(150,7,1,0,'model',5,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500889184),(151,1,1,0,'member',1,'zhang在2017-07-25 09:57登录了后台',1,1500947827),(152,8,1,0,'attribute',124,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500947877),(153,7,1,0,'model',5,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500948459),(154,7,1,0,'model',5,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500948500),(155,7,1,0,'model',5,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1500948596),(156,8,1,0,'attribute',94,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500974782),(157,8,1,0,'attribute',125,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1500975612),(158,1,1,0,'member',1,'zhang在2017-07-26 09:53登录了后台',1,1501033995),(159,8,1,0,'attribute',126,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501037964),(160,8,1,0,'attribute',94,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501038221),(161,1,1,0,'member',1,'zhang在2017-07-27 09:51登录了后台',1,1501120264),(162,8,1,0,'attribute',127,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501120421),(163,8,1,0,'attribute',128,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501120441),(164,1,1,0,'member',1,'zhang在2017-07-27 09:59登录了后台',1,1501120790),(165,1,1,0,'member',1,'zhang在2017-07-27 16:52登录了后台',1,1501145573),(166,7,1,0,'model',15,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1501146702),(167,1,1,0,'member',1,'zhang在2017-07-28 10:08登录了后台',1,1501207706),(168,8,1,0,'attribute',103,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501207761),(169,8,1,0,'attribute',104,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501207771),(170,8,1,0,'attribute',113,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501207802),(171,8,1,0,'attribute',112,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501207823),(172,7,1,0,'model',15,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1501210451),(173,8,1,0,'attribute',105,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501233838),(174,7,1,0,'model',22,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1501234146),(175,8,1,0,'attribute',129,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501234164),(176,8,1,0,'attribute',130,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501234180),(177,1,1,0,'member',1,'zhang在2017-07-28 17:50登录了后台',1,1501235443),(178,8,1,0,'attribute',118,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501236023),(179,8,1,0,'attribute',117,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501236033),(180,1,1,0,'member',1,'zhang在2017-07-31 10:07登录了后台',1,1501466820),(181,7,1,0,'model',23,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1501467137),(182,8,1,0,'attribute',131,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501467163),(183,8,1,0,'attribute',132,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501467183),(184,7,1,0,'model',23,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1501467460),(185,7,1,0,'model',17,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1501467478),(186,1,1,0,'member',1,'zhang在2017-07-31 17:03登录了后台',1,1501491780),(187,1,1,0,'member',1,'zhang在2017-08-01 10:24登录了后台',1,1501554297),(188,8,1,0,'attribute',115,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501554326),(189,1,1,0,'member',1,'zhang在2017-08-01 14:47登录了后台',1,1501570059),(190,1,1,0,'member',1,'zhang在2017-08-01 15:00登录了后台',1,1501570855),(191,6,1,0,'config',39,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501571495),(192,6,1,0,'config',39,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501571548),(193,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501581120),(194,8,1,0,'attribute',52,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501581173),(195,1,1,0,'member',1,'zhang在2017-08-02 11:41登录了后台',1,1501645270),(196,8,1,0,'attribute',114,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1501656593),(197,1,1,0,'member',1,'zhang在2017-08-03 10:00登录了后台',1,1501725647),(198,1,1,0,'member',1,'zhang在2017-08-03 10:01登录了后台',1,1501725673),(199,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501725764),(200,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501725772),(201,1,1,0,'member',1,'zhang在2017-08-03 14:49登录了后台',1,1501742973),(202,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501742989),(203,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501745457),(204,6,1,0,'config',39,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501745466),(205,6,1,0,'config',39,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501746030),(206,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501746380),(207,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501746441),(208,1,1,0,'member',1,'zhang在2017-08-04 10:05登录了后台',1,1501812301),(209,1,1,0,'member',1,'zhang在2017-08-04 10:23登录了后台',1,1501813420),(210,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1501813492),(211,1,1,0,'member',1,'zhang在2017-08-07 09:57登录了后台',1,1502071052),(212,8,1,0,'attribute',67,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/67.html',1,1502071069),(213,7,1,0,'model',24,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502089679),(214,7,1,0,'model',9,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502089732),(215,8,1,0,'attribute',133,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502089758),(216,8,1,0,'attribute',134,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502089782),(217,8,1,0,'attribute',135,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502089811),(218,8,1,0,'attribute',136,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502089872),(219,8,1,0,'attribute',58,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/58.html',1,1502089888),(220,8,1,0,'attribute',137,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502097533),(221,8,1,0,'attribute',138,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502097551),(222,1,1,0,'member',1,'zhang在2017-08-08 10:13登录了后台',1,1502158390),(223,1,1,0,'member',1,'zhang在2017-08-08 15:18登录了后台',1,1502176728),(224,1,1,0,'member',1,'zhang在2017-08-08 15:19登录了后台',1,1502176750),(225,1,1,0,'member',1,'zhang在2017-08-08 17:41登录了后台',1,1502185287),(226,1,1,0,'member',1,'zhang在2017-08-09 14:35登录了后台',1,1502260539),(227,8,1,0,'attribute',125,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/125.html',1,1502260781),(228,1,1,0,'member',1,'zhang在2017-08-09 15:41登录了后台',1,1502264505),(229,8,1,0,'attribute',115,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502271904),(230,8,1,0,'attribute',101,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/101.html',1,1502272185),(231,1,1,0,'member',1,'zhang在2017-08-10 09:53登录了后台',1,1502329992),(232,8,1,0,'attribute',139,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502330036),(233,8,1,0,'attribute',140,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502330056),(234,8,1,0,'attribute',141,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502330084),(235,8,1,0,'attribute',141,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502335190),(236,8,1,0,'attribute',114,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/114.html',1,1502335864),(237,1,1,0,'member',1,'zhang在2017-08-11 11:44登录了后台',1,1502423088),(238,7,1,0,'model',25,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502423115),(239,8,1,0,'attribute',142,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502423143),(240,8,1,0,'attribute',143,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502423158),(241,8,1,0,'attribute',144,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502423177),(242,8,1,0,'attribute',145,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502423192),(243,7,1,0,'model',25,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502423301),(244,1,1,0,'member',1,'zhang在2017-08-11 15:04登录了后台',1,1502435060),(245,1,1,0,'member',1,'zhang在2017-08-11 15:04登录了后台',1,1502435096),(246,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1502435389),(247,7,1,0,'model',26,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502436658),(248,8,1,0,'attribute',146,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502436688),(249,8,1,0,'attribute',147,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502436702),(250,8,1,0,'attribute',148,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502436826),(251,8,1,0,'attribute',149,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502436876),(252,8,1,0,'attribute',150,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502436916),(253,8,1,0,'attribute',151,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502436939),(254,7,1,0,'model',26,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502437028),(255,7,1,0,'model',27,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502437091),(256,8,1,0,'attribute',152,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502437105),(257,8,1,0,'attribute',152,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502437136),(258,8,1,0,'attribute',153,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502437154),(259,8,1,0,'attribute',154,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502437168),(260,8,1,0,'attribute',152,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502437550),(261,8,1,0,'attribute',155,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502438022),(262,8,1,0,'attribute',156,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502440446),(263,8,1,0,'attribute',157,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502442569),(264,1,1,0,'member',1,'zhang在2017-08-11 17:57登录了后台',1,1502445474),(265,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1502445489),(266,1,1,0,'member',1,'zhang在2017-08-14 09:19登录了后台',1,1502673579),(267,1,1,0,'member',1,'zhang在2017-08-14 12:25登录了后台',1,1502684726),(268,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1502684789),(269,7,1,0,'model',28,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502694611),(270,7,1,0,'model',28,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502694629),(271,8,1,0,'attribute',158,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502695130),(272,8,1,0,'attribute',159,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502695154),(273,8,1,0,'attribute',160,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502695207),(274,8,1,0,'attribute',161,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502695231),(275,1,1,0,'member',1,'zhang在2017-08-15 09:13登录了后台',1,1502759639),(276,8,1,0,'attribute',162,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502759662),(277,1,1,0,'member',1,'zhang在2017-08-16 09:42登录了后台',1,1502847778),(278,1,1,0,'member',1,'zhang在2017-08-16 10:08登录了后台',1,1502849338),(279,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1502852028),(280,8,1,0,'attribute',163,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502865038),(281,8,1,0,'attribute',164,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502872297),(282,1,1,0,'member',1,'zhang在2017-08-17 14:53登录了后台',1,1502952794),(283,7,1,0,'model',29,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502952826),(284,7,1,0,'model',30,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1502952839),(285,8,1,0,'attribute',165,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502952870),(286,8,1,0,'attribute',166,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502952928),(287,8,1,0,'attribute',167,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502952948),(288,8,1,0,'attribute',168,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502952963),(289,8,1,0,'attribute',169,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502952986),(290,8,1,0,'attribute',170,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953134),(291,8,1,0,'attribute',171,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953167),(292,8,1,0,'attribute',172,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953183),(293,8,1,0,'attribute',173,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953199),(294,8,1,0,'attribute',174,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953233),(295,8,1,0,'attribute',175,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953282),(296,8,1,0,'attribute',176,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1502953316),(297,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1502959781),(298,1,1,0,'member',1,'zhang在2017-08-18 10:22登录了后台',1,1503022938),(299,1,1,0,'member',1,'zhang在2017-08-21 09:56登录了后台',1,1503280589),(300,1,1,0,'member',1,'zhang在2017-08-21 09:57登录了后台',1,1503280621),(301,1,1,0,'member',1,'zhang在2017-08-22 09:36登录了后台',1,1503365818),(302,8,1,0,'attribute',121,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503365998),(303,8,1,0,'attribute',121,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503366026),(304,8,1,0,'attribute',177,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503366142),(305,1,1,0,'member',1,'zhang在2017-08-23 12:00登录了后台',1,1503460856),(306,10,1,0,'Menu',129,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1503460909),(307,10,1,0,'Menu',43,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503471485),(308,10,1,0,'Menu',68,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503471510),(309,7,1,0,'model',29,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1503471806),(310,8,1,0,'attribute',165,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/165.html',1,1503471882),(311,8,1,0,'attribute',170,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/170.html',1,1503471978),(312,7,1,0,'model',30,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1503472077),(313,7,1,0,'model',31,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1503473168),(314,8,1,0,'attribute',178,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503473616),(315,8,1,0,'attribute',179,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503473647),(316,8,1,0,'attribute',180,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503473672),(317,8,1,0,'attribute',181,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503473690),(318,8,1,0,'attribute',182,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503473760),(319,8,1,0,'attribute',183,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503473788),(320,10,1,0,'Menu',130,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1503475037),(321,10,1,0,'Menu',131,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1503475110),(322,10,1,0,'Menu',131,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503475127),(323,10,1,0,'Menu',131,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503475140),(324,10,1,0,'Menu',130,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503475152),(325,10,1,0,'Menu',132,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1503475222),(326,10,1,0,'Menu',132,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503475228),(327,10,1,0,'Menu',131,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503475258),(328,8,1,0,'attribute',180,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503479628),(329,10,1,0,'Menu',132,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1503479824),(330,1,1,0,'member',1,'zhang在2017-08-24 09:19登录了后台',1,1503537543),(331,1,1,0,'member',1,'zhang在2017-08-24 15:00登录了后台',1,1503558048),(332,8,1,0,'attribute',167,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503559029),(333,8,1,0,'attribute',167,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503559420),(334,6,1,0,'config',41,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1503559498),(335,8,1,0,'attribute',167,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503559572),(336,1,1,0,'member',1,'zhang在2017-08-25 10:21登录了后台',1,1503627685),(337,1,1,0,'member',1,'zhang在2017-08-25 11:03登录了后台',1,1503630239),(338,1,1,0,'member',1,'zhang在2017-08-25 15:07登录了后台',1,1503644854),(339,1,1,0,'member',1,'zhang在2017-08-28 11:35登录了后台',1,1503891311),(340,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1503892889),(341,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1503893063),(342,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1503902397),(343,1,1,0,'member',1,'zhang在2017-08-28 17:54登录了后台',1,1503914089),(344,1,1,0,'member',1,'zhang在2017-08-29 15:01登录了后台',1,1503990105),(345,8,1,0,'attribute',184,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1503990144),(346,1,1,0,'member',1,'zhang在2017-08-30 10:11登录了后台',1,1504059075),(347,8,1,0,'attribute',185,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504060586),(348,8,1,0,'attribute',186,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504060618),(349,1,1,0,'member',1,'zhang在2017-09-01 09:06登录了后台',1,1504228008),(350,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1504231943),(351,1,1,0,'member',1,'zhang在2017-09-01 14:26登录了后台',1,1504247169),(352,1,1,0,'member',1,'zhang在2017-09-05 08:37登录了后台',1,1504571857),(353,1,1,0,'member',1,'zhang在2017-09-05 08:38登录了后台',1,1504571929),(354,8,1,0,'attribute',187,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504584728),(355,1,1,0,'member',1,'zhang在2017-09-06 11:46登录了后台',1,1504669570),(356,8,1,0,'attribute',96,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504669596),(357,1,1,0,'member',1,'zhang在2017-09-07 10:44登录了后台',1,1504752263),(358,7,1,0,'model',32,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1504753232),(359,1,1,0,'member',1,'zhang在2017-09-07 11:04登录了后台',1,1504753481),(360,8,1,0,'attribute',188,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504753540),(361,8,1,0,'attribute',189,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504753583),(362,8,1,0,'attribute',190,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504753600),(363,8,1,0,'attribute',191,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504753656),(364,8,1,0,'attribute',167,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504755165),(365,8,1,0,'attribute',191,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1504755223),(366,1,1,0,'member',1,'zhang在2017-09-08 12:10登录了后台',1,1504843839),(367,1,1,0,'member',1,'zhang在2017-09-08 16:55登录了后台',1,1504860932),(368,1,1,0,'member',1,'zhang在2017-09-11 10:10登录了后台',1,1505095832),(369,1,1,0,'member',1,'zhang在2017-09-12 09:32登录了后台',1,1505179928),(370,8,1,0,'attribute',151,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505184160),(371,8,1,0,'attribute',192,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505199159),(372,1,1,0,'member',1,'zhang在2017-09-12 14:53登录了后台',1,1505199191),(373,7,1,0,'model',32,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1505199287),(374,8,1,0,'attribute',192,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/192.html',1,1505199474),(375,1,1,0,'member',1,'zhang在2017-09-13 09:48登录了后台',1,1505267319),(376,8,1,0,'attribute',193,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505268705),(377,7,1,0,'model',15,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1505270589),(378,7,1,0,'model',15,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1505270665),(379,1,1,0,'member',1,'zhang在2017-09-14 16:24登录了后台',1,1505377461),(380,8,1,0,'attribute',119,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378263),(381,8,1,0,'attribute',120,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378296),(382,8,1,0,'attribute',121,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378324),(383,8,1,0,'attribute',201,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378350),(384,8,1,0,'attribute',202,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378380),(385,8,1,0,'attribute',203,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378416),(386,8,1,0,'attribute',204,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378432),(387,8,1,0,'attribute',120,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505378439),(388,8,1,0,'attribute',205,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505379295),(389,8,1,0,'attribute',206,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505381329),(390,8,1,0,'attribute',207,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505381368),(391,1,1,0,'member',1,'zhang在2017-09-15 09:56登录了后台',1,1505440603),(392,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1505462628),(393,1,1,0,'member',1,'zhang在2017-09-18 11:36登录了后台',1,1505705761),(394,1,1,0,'member',1,'zhang在2017-09-18 11:36登录了后台',1,1505705786),(395,7,1,0,'model',33,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1505706877),(396,8,1,0,'attribute',208,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505706907),(397,8,1,0,'attribute',209,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505706966),(398,8,1,0,'attribute',210,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505706985),(399,8,1,0,'attribute',211,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505707003),(400,8,1,0,'attribute',211,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505716886),(401,8,1,0,'attribute',212,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505716913),(402,1,1,0,'member',1,'zhang在2017-09-20 16:15登录了后台',1,1505895322),(403,1,1,0,'member',1,'zhang在2017-09-21 15:07登录了后台',1,1505977655),(404,10,1,0,'Menu',129,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1505978499),(405,10,1,0,'Menu',129,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1505978512),(406,10,1,0,'Menu',132,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1505978525),(407,7,1,0,'model',31,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1505978593),(408,8,1,0,'attribute',178,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1505978608),(409,1,1,0,'member',1,'zhang在2017-09-22 10:08登录了后台',1,1506046111),(410,1,1,0,'member',1,'zhang在2017-09-25 09:35登录了后台',1,1506303314),(411,7,1,0,'model',34,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1506303346),(412,8,1,0,'attribute',213,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506303386),(413,8,1,0,'attribute',214,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506303408),(414,1,1,0,'member',1,'zhang在2017-09-25 09:45登录了后台',1,1506303915),(415,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1506304046),(416,8,1,0,'attribute',213,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506306736),(417,7,1,0,'model',35,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1506322076),(418,8,1,0,'attribute',215,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506322174),(419,8,1,0,'attribute',216,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506322195),(420,8,1,0,'attribute',216,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506322242),(421,8,1,0,'attribute',217,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506322269),(422,8,1,0,'attribute',218,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506322295),(423,8,1,0,'attribute',219,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506322320),(424,7,1,0,'model',35,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1506327169),(425,1,1,0,'member',1,'zhang在2017-09-26 11:38登录了后台',1,1506397115),(426,8,1,0,'attribute',125,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506417644),(427,1,1,0,'member',1,'zhang在2017-09-27 15:22登录了后台',1,1506496978),(428,7,1,0,'model',36,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1506497000),(429,8,1,0,'attribute',220,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497022),(430,8,1,0,'attribute',220,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497064),(431,8,1,0,'attribute',221,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497133),(432,8,1,0,'attribute',222,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497145),(433,8,1,0,'attribute',223,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497226),(434,8,1,0,'attribute',224,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497242),(435,8,1,0,'attribute',225,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497619),(436,8,1,0,'attribute',226,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497648),(437,8,1,0,'attribute',227,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506497823),(438,8,1,0,'attribute',228,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506498087),(439,1,1,0,'member',1,'zhang在2017-09-27 17:15登录了后台',1,1506503753),(440,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1506504991),(441,8,1,0,'attribute',221,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506506317),(442,8,1,0,'attribute',225,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506506325),(443,1,1,0,'member',1,'zhang在2017-09-28 10:44登录了后台',1,1506566662),(444,1,1,0,'member',1,'zhang在2017-09-29 09:44登录了后台',1,1506649490),(445,7,1,0,'model',37,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1506649959),(446,8,1,0,'attribute',229,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506650002),(447,8,1,0,'attribute',230,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506650123),(448,8,1,0,'attribute',231,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1506650332),(449,1,1,0,'member',1,'zhang在2017-09-30 11:48登录了后台',1,1506743286),(450,1,1,0,'member',1,'zhang在2017-10-09 11:39登录了后台',1,1507520398),(451,7,1,0,'model',38,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1507520435),(452,8,1,0,'attribute',232,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507520485),(453,8,1,0,'attribute',233,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507520508),(454,8,1,0,'attribute',234,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507520534),(455,8,1,0,'attribute',234,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507520543),(456,1,1,0,'member',1,'zhang在2017-10-09 14:42登录了后台',1,1507531374),(457,1,1,0,'member',1,'zhang在2017-10-10 10:50登录了后台',1,1507603857),(458,7,1,0,'model',39,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1507619192),(459,8,1,0,'attribute',235,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619321),(460,8,1,0,'attribute',236,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619337),(461,8,1,0,'attribute',237,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619348),(462,8,1,0,'attribute',238,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619361),(463,8,1,0,'attribute',239,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619391),(464,8,1,0,'attribute',240,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619583),(465,8,1,0,'attribute',241,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619602),(466,8,1,0,'attribute',242,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507619740),(467,10,1,0,'Menu',133,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1507627021),(468,10,1,0,'Menu',134,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1507627072),(469,10,1,0,'Menu',135,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1507627103),(470,10,1,0,'Menu',136,'操作url：/marke/index.php?s=/Admin/Menu/add.html',1,1507627711),(471,1,1,0,'member',1,'zhang在2017-10-11 16:02登录了后台',1,1507708973),(472,8,1,0,'attribute',243,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507713485),(473,10,1,0,'Menu',134,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1507716261),(474,1,1,0,'member',1,'zhang在2017-10-12 10:27登录了后台',1,1507775261),(475,8,1,0,'attribute',87,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/87.html',1,1507790211),(476,7,1,0,'model',12,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1507790248),(477,8,1,0,'attribute',88,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/88.html',1,1507790260),(478,8,1,0,'attribute',244,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507790381),(479,8,1,0,'attribute',245,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507790816),(480,8,1,0,'attribute',246,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791597),(481,8,1,0,'attribute',247,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791712),(482,8,1,0,'attribute',247,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791727),(483,8,1,0,'attribute',248,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791751),(484,8,1,0,'attribute',249,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791786),(485,8,1,0,'attribute',250,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791796),(486,8,1,0,'attribute',251,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791820),(487,8,1,0,'attribute',252,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791832),(488,8,1,0,'attribute',253,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791853),(489,8,1,0,'attribute',254,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791866),(490,8,1,0,'attribute',255,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791874),(491,8,1,0,'attribute',256,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791884),(492,8,1,0,'attribute',257,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507791892),(493,10,1,0,'Menu',129,'操作url：/marke/index.php?s=/Admin/Menu/edit.html',1,1507794631),(494,1,1,0,'member',1,'zhang在2017-10-12 15:51登录了后台',1,1507794695),(495,7,1,0,'model',12,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1507796394),(496,1,1,0,'member',1,'zhang在2017-10-13 09:00登录了后台',1,1507856438),(497,8,1,0,'attribute',242,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507878933),(498,8,1,0,'attribute',242,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507878995),(499,8,1,0,'attribute',258,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507879013),(500,8,1,0,'attribute',242,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1507879020),(501,1,1,0,'member',1,'zhang在2017-10-16 15:46登录了后台',1,1508140007),(502,1,1,0,'member',1,'zhang在2017-10-17 17:17登录了后台',1,1508231871),(503,8,1,0,'attribute',89,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/89.html',1,1508231938),(504,8,1,0,'attribute',93,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/93.html',1,1508231946),(505,8,1,0,'attribute',100,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/100.html',1,1508231952),(506,8,1,0,'attribute',114,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/114.html',1,1508231964),(507,8,1,0,'attribute',142,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/142.html',1,1508231995),(508,8,1,0,'attribute',156,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/156.html',1,1508232001),(509,8,1,0,'attribute',162,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/162.html',1,1508232012),(510,8,1,0,'attribute',180,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/180.html',1,1508232027),(511,8,1,0,'attribute',208,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/208.html',1,1508232036),(512,8,1,0,'attribute',213,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/213.html',1,1508232078),(513,8,1,0,'attribute',215,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/215.html',1,1508232085),(514,8,1,0,'attribute',220,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/220.html',1,1508232091),(515,8,1,0,'attribute',229,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/229.html',1,1508232097),(516,8,1,0,'attribute',232,'操作url：/marke/index.php?s=/Admin/Attribute/remove/id/232.html',1,1508232103),(517,1,1,0,'member',1,'zhang在2017-10-18 11:49登录了后台',1,1508298552),(518,10,1,0,'Menu',0,'操作url：/marke/index.php?s=/Admin/Menu/del/id/133.html',1,1508298589),(519,10,1,0,'Menu',0,'操作url：/marke/index.php?s=/Admin/Menu/del/id/129.html',1,1508298595),(520,1,1,0,'member',1,'zhang在2017-10-20 11:48登录了后台',1,1508471288),(521,8,1,0,'attribute',259,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508471631),(522,8,1,0,'attribute',260,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508471677),(523,7,1,0,'model',40,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508472773),(524,8,1,0,'attribute',261,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508472788),(525,8,1,0,'attribute',262,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508472802),(526,1,1,0,'member',1,'zhang在2017-10-24 09:42登录了后台',1,1508809368),(527,8,1,0,'attribute',263,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508809928),(528,8,1,0,'attribute',264,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508809949),(529,8,1,0,'attribute',264,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508809957),(530,8,1,0,'attribute',265,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508810065),(531,8,1,0,'attribute',266,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508810100),(532,8,1,0,'attribute',264,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508810111),(533,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508817575),(534,8,1,0,'attribute',267,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817589),(535,8,1,0,'attribute',268,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817638),(536,8,1,0,'attribute',269,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817648),(537,8,1,0,'attribute',270,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817665),(538,8,1,0,'attribute',271,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817673),(539,8,1,0,'attribute',272,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817682),(540,8,1,0,'attribute',273,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817977),(541,8,1,0,'attribute',274,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508817991),(542,8,1,0,'attribute',275,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818001),(543,8,1,0,'attribute',276,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818014),(544,8,1,0,'attribute',277,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818027),(545,8,1,0,'attribute',278,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818038),(546,8,1,0,'attribute',279,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818049),(547,8,1,0,'attribute',280,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818063),(548,8,1,0,'attribute',281,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818077),(549,8,1,0,'attribute',282,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818088),(550,8,1,0,'attribute',283,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818098),(551,8,1,0,'attribute',284,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818151),(552,8,1,0,'attribute',285,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818164),(553,8,1,0,'attribute',285,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818298),(554,8,1,0,'attribute',286,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818314),(555,8,1,0,'attribute',287,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818505),(556,8,1,0,'attribute',288,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818515),(557,8,1,0,'attribute',289,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818525),(558,8,1,0,'attribute',290,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818555),(559,8,1,0,'attribute',291,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818571),(560,8,1,0,'attribute',292,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818592),(561,8,1,0,'attribute',293,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818605),(562,8,1,0,'attribute',294,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818619),(563,8,1,0,'attribute',295,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818633),(564,8,1,0,'attribute',296,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818647),(565,8,1,0,'attribute',297,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818659),(566,8,1,0,'attribute',298,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818675),(567,8,1,0,'attribute',299,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818686),(568,8,1,0,'attribute',300,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508818696),(569,8,1,0,'attribute',301,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828734),(570,8,1,0,'attribute',302,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828751),(571,8,1,0,'attribute',303,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828783),(572,8,1,0,'attribute',304,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828800),(573,8,1,0,'attribute',305,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828810),(574,8,1,0,'attribute',306,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828897),(575,8,1,0,'attribute',307,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828914),(576,8,1,0,'attribute',307,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828927),(577,8,1,0,'attribute',308,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828943),(578,8,1,0,'attribute',309,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828954),(579,8,1,0,'attribute',309,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828977),(580,8,1,0,'attribute',310,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508828995),(581,8,1,0,'attribute',311,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829055),(582,8,1,0,'attribute',312,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829089),(583,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829127),(584,8,1,0,'attribute',314,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829151),(585,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829175),(586,8,1,0,'attribute',316,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829201),(587,8,1,0,'attribute',317,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829213),(588,8,1,0,'attribute',318,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829225),(589,8,1,0,'attribute',319,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829245),(590,8,1,0,'attribute',320,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829259),(591,8,1,0,'attribute',321,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829278),(592,8,1,0,'attribute',322,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508829313),(593,8,1,0,'attribute',323,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830291),(594,8,1,0,'attribute',324,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830320),(595,8,1,0,'attribute',325,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830331),(596,8,1,0,'attribute',326,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830485),(597,8,1,0,'attribute',327,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830602),(598,8,1,0,'attribute',326,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830609),(599,8,1,0,'attribute',326,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830646),(600,8,1,0,'attribute',292,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830663),(601,8,1,0,'attribute',291,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830671),(602,8,1,0,'attribute',290,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830677),(603,8,1,0,'attribute',311,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830691),(604,8,1,0,'attribute',306,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830699),(605,8,1,0,'attribute',304,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830753),(606,8,1,0,'attribute',319,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830776),(607,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508830782),(608,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508830834),(609,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508832687),(610,8,1,0,'attribute',294,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508832740),(611,8,1,0,'attribute',295,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508832748),(612,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508833145),(613,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508833479),(614,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508833619),(615,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508833785),(616,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508833799),(617,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508833894),(618,1,1,0,'member',1,'zhang在2017-10-24 16:43登录了后台',1,1508834630),(619,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1508834719),(620,8,1,0,'attribute',273,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508838687),(621,8,1,0,'attribute',268,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508838759),(622,1,1,0,'member',1,'zhang在2017-10-25 09:40登录了后台',1,1508895651),(623,8,1,0,'attribute',270,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508900781),(624,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508917281),(625,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508917319),(626,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508917513),(627,8,1,0,'attribute',275,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508917679),(628,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508917788),(629,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508917837),(630,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918055),(631,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918100),(632,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918120),(633,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918133),(634,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918682),(635,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918706),(636,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918777),(637,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918794),(638,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918826),(639,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918862),(640,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918873),(641,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918890),(642,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918907),(643,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918921),(644,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918934),(645,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918958),(646,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918967),(647,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918984),(648,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508918991),(649,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508919001),(650,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508919019),(651,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508919029),(652,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508919040),(653,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508919074),(654,8,1,0,'attribute',310,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508919094),(655,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1508919531),(656,1,1,0,'member',1,'zhang在2017-10-26 09:45登录了后台',1,1508982307),(657,8,1,0,'attribute',311,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508982381),(658,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508982402),(659,8,1,0,'attribute',322,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508983179),(660,8,1,0,'attribute',324,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508983202),(661,8,1,0,'attribute',325,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508983212),(662,8,1,0,'attribute',323,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508983221),(663,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508987131),(664,8,1,0,'attribute',316,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508987142),(665,8,1,0,'attribute',314,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508987155),(666,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508987162),(667,8,1,0,'attribute',322,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1508987269),(668,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509000243),(669,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509000684),(670,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509001084),(671,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509001111),(672,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509001156),(673,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509001226),(674,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509001262),(675,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509001694),(676,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509002240),(677,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509003274),(678,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509003299),(679,8,1,0,'attribute',328,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509009451),(680,8,1,0,'attribute',329,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509009501),(681,8,1,0,'attribute',330,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509009595),(682,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509009698),(683,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509009841),(684,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509009906),(685,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509009930),(686,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509009950),(687,1,1,0,'member',1,'zhang在2017-10-27 15:52登录了后台',1,1509090774),(688,8,1,0,'attribute',306,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509090846),(689,1,1,0,'member',1,'zhang在2017-10-30 14:47登录了后台',1,1509346064),(690,1,1,0,'member',1,'zhang在2017-10-31 09:35登录了后台',1,1509413729),(691,8,1,0,'attribute',327,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413792),(692,8,1,0,'attribute',325,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413871),(693,8,1,0,'attribute',316,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413886),(694,8,1,0,'attribute',307,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413900),(695,8,1,0,'attribute',300,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413910),(696,8,1,0,'attribute',298,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413921),(697,8,1,0,'attribute',296,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413929),(698,8,1,0,'attribute',282,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509413939),(699,8,1,0,'attribute',280,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414274),(700,8,1,0,'attribute',276,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414282),(701,8,1,0,'attribute',281,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414432),(702,8,1,0,'attribute',303,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414559),(703,8,1,0,'attribute',312,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414598),(704,8,1,0,'attribute',314,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414624),(705,8,1,0,'attribute',327,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414665),(706,8,1,0,'attribute',322,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414678),(707,8,1,0,'attribute',323,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414748),(708,8,1,0,'attribute',322,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509414794),(709,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509416253),(710,8,1,0,'attribute',331,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509431998),(711,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509432040),(712,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509432487),(713,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509432570),(714,8,1,0,'attribute',324,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509432626),(715,8,1,0,'attribute',310,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509432769),(716,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509432830),(717,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509433927),(718,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509433944),(719,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509437576),(720,8,1,0,'attribute',304,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509437873),(721,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438101),(722,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438704),(723,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438760),(724,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438785),(725,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438824),(726,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438845),(727,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438901),(728,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438935),(729,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509438971),(730,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439005),(731,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439073),(732,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439096),(733,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439153),(734,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439171),(735,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439232),(736,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439259),(737,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439342),(738,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439391),(739,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439436),(740,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439463),(741,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509439481),(742,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509440123),(743,8,1,0,'attribute',326,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509440291),(744,8,1,0,'attribute',327,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509440305),(745,8,1,0,'attribute',324,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509440446),(746,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509440528),(747,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509440675),(748,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509441578),(749,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509441677),(750,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509442515),(751,1,1,0,'member',1,'zhang在2017-11-01 10:17登录了后台',1,1509502663),(752,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509504161),(753,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509504228),(754,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509505182),(755,1,1,0,'member',1,'zhang在2017-11-01 16:54登录了后台',1,1509526450),(756,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509526480),(757,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509526534),(758,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509526556),(759,1,1,0,'member',1,'zhang在2017-11-02 10:59登录了后台',1,1509591546),(760,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509591616),(761,8,1,0,'attribute',332,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591644),(762,8,1,0,'attribute',333,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591666),(763,8,1,0,'attribute',334,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591698),(764,8,1,0,'attribute',335,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591718),(765,8,1,0,'attribute',336,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591751),(766,8,1,0,'attribute',337,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591768),(767,8,1,0,'attribute',338,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591777),(768,8,1,0,'attribute',339,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591820),(769,8,1,0,'attribute',340,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591882),(770,8,1,0,'attribute',341,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591925),(771,8,1,0,'attribute',342,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509591998),(772,8,1,0,'attribute',339,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592568),(773,8,1,0,'attribute',343,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592580),(774,8,1,0,'attribute',344,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592606),(775,8,1,0,'attribute',345,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592656),(776,8,1,0,'attribute',346,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592696),(777,8,1,0,'attribute',347,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592726),(778,8,1,0,'attribute',348,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592758),(779,8,1,0,'attribute',349,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592875),(780,8,1,0,'attribute',350,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509592892),(781,7,1,0,'model',43,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509593201),(782,8,1,0,'attribute',351,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509593232),(783,8,1,0,'attribute',352,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509593260),(784,8,1,0,'attribute',353,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509593306),(785,8,1,0,'attribute',354,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509593333),(786,1,1,0,'member',1,'zhang在2017-11-02 11:52登录了后台',1,1509594763),(787,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1509595058),(788,8,1,0,'attribute',347,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509604123),(789,8,1,0,'attribute',335,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509604556),(790,8,1,0,'attribute',334,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509604562),(791,8,1,0,'attribute',353,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509615126),(792,1,1,0,'member',1,'zhang在2017-11-03 09:16登录了后台',1,1509671790),(793,8,1,0,'attribute',355,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509671884),(794,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509671909),(795,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509673499),(796,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509673555),(797,8,1,0,'attribute',356,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509674151),(798,8,1,0,'attribute',357,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509674176),(799,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509674271),(800,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509674538),(801,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509696283),(802,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509696638),(803,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509696653),(804,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509696689),(805,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509698525),(806,8,1,0,'attribute',358,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701609),(807,8,1,0,'attribute',358,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701632),(808,8,1,0,'attribute',359,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701675),(809,8,1,0,'attribute',360,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701732),(810,8,1,0,'attribute',361,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701784),(811,8,1,0,'attribute',362,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701868),(812,8,1,0,'attribute',363,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701943),(813,8,1,0,'attribute',364,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509701995),(814,8,1,0,'attribute',365,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702020),(815,8,1,0,'attribute',366,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702075),(816,8,1,0,'attribute',367,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702120),(817,8,1,0,'attribute',368,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702168),(818,8,1,0,'attribute',369,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702221),(819,8,1,0,'attribute',370,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702260),(820,8,1,0,'attribute',371,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702295),(821,8,1,0,'attribute',372,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702325),(822,8,1,0,'attribute',373,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702363),(823,8,1,0,'attribute',374,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702436),(824,8,1,0,'attribute',375,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702465),(825,8,1,0,'attribute',376,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702531),(826,8,1,0,'attribute',377,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509702563),(827,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509702644),(828,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509702903),(829,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509703272),(830,1,1,0,'member',1,'zhang在2017-11-06 09:50登录了后台',1,1509933059),(831,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509933102),(832,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509933122),(833,8,1,0,'attribute',377,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509941834),(834,8,1,0,'attribute',367,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509941847),(835,8,1,0,'attribute',327,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509941860),(836,8,1,0,'attribute',316,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509941871),(837,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509942136),(838,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509942308),(839,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509942415),(840,8,1,0,'attribute',331,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1509954065),(841,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1509954150),(842,1,1,0,'member',1,'zhang在2017-11-07 14:40登录了后台',1,1510036804),(843,8,1,0,'attribute',275,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510037752),(844,8,1,0,'attribute',285,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510037883),(845,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510038092),(846,8,1,0,'attribute',378,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510038295),(847,8,1,0,'attribute',379,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510038678),(848,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510038747),(849,8,1,0,'attribute',380,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039207),(850,8,1,0,'attribute',381,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039245),(851,8,1,0,'attribute',382,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039350),(852,8,1,0,'attribute',305,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039478),(853,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510039739),(854,8,1,0,'attribute',275,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039785),(855,8,1,0,'attribute',295,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039823),(856,8,1,0,'attribute',297,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039833),(857,8,1,0,'attribute',299,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510039842),(858,8,1,0,'attribute',306,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040000),(859,8,1,0,'attribute',305,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040010),(860,8,1,0,'attribute',326,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040039),(861,8,1,0,'attribute',324,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040047),(862,8,1,0,'attribute',322,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040053),(863,8,1,0,'attribute',321,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040067),(864,8,1,0,'attribute',315,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040075),(865,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040087),(866,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040099),(867,8,1,0,'attribute',313,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040125),(868,8,1,0,'attribute',360,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040265),(869,8,1,0,'attribute',361,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040271),(870,8,1,0,'attribute',362,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040280),(871,8,1,0,'attribute',364,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040287),(872,8,1,0,'attribute',366,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040296),(873,8,1,0,'attribute',370,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040304),(874,8,1,0,'attribute',371,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040310),(875,8,1,0,'attribute',372,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040318),(876,8,1,0,'attribute',374,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040324),(877,8,1,0,'attribute',376,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040331),(878,8,1,0,'attribute',378,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040338),(879,8,1,0,'attribute',380,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510040346),(880,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510042298),(881,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510042345),(882,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510044353),(883,1,1,0,'member',1,'zhang在2017-11-08 09:35登录了后台',1,1510104955),(884,1,1,0,'member',1,'zhang在2017-11-09 16:22登录了后台',1,1510215743),(885,8,1,0,'attribute',383,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510215765),(886,8,1,0,'attribute',383,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510215979),(887,8,1,0,'attribute',384,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510217058),(888,8,1,0,'attribute',384,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510217067),(889,1,1,0,'member',1,'zhang在2017-11-10 11:45登录了后台',1,1510285540),(890,1,1,0,'member',1,'zhang在2017-11-10 14:35登录了后台',1,1510295714),(891,8,1,0,'attribute',346,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510295742),(892,8,1,0,'attribute',385,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510303048),(893,8,1,0,'attribute',386,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510303289),(894,1,1,0,'member',1,'zhang在2017-11-13 09:33登录了后台',1,1510536814),(895,8,1,0,'attribute',387,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510538992),(896,8,1,0,'attribute',388,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510542812),(897,8,1,0,'attribute',388,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510542849),(898,7,1,0,'model',44,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510557555),(899,8,1,0,'attribute',389,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510557607),(900,8,1,0,'attribute',390,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558004),(901,8,1,0,'attribute',391,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558112),(902,8,1,0,'attribute',392,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558206),(903,8,1,0,'attribute',393,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558306),(904,8,1,0,'attribute',394,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558325),(905,8,1,0,'attribute',395,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558359),(906,8,1,0,'attribute',396,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558408),(907,8,1,0,'attribute',397,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510558486),(908,8,1,0,'attribute',394,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510561137),(909,8,1,0,'attribute',394,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510561632),(910,1,1,0,'member',1,'zhang在2017-11-14 10:20登录了后台',1,1510626025),(911,8,1,0,'attribute',285,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510626076),(912,8,1,0,'attribute',273,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510626996),(913,8,1,0,'attribute',273,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510627022),(914,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510630656),(915,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510630732),(916,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510630753),(917,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510630775),(918,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510631126),(919,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510631216),(920,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510632001),(921,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510644010),(922,1,1,0,'member',1,'zhang在2017-11-16 11:25登录了后台',1,1510802740),(923,8,1,0,'attribute',398,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510803287),(924,1,1,0,'member',1,'zhang在2017-11-16 11:43登录了后台',1,1510803806),(925,8,1,0,'attribute',398,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1510814261),(926,1,1,0,'member',1,'zhang在2017-11-17 11:11登录了后台',1,1510888275),(927,1,1,0,'member',1,'zhang在2017-11-17 17:22登录了后台',1,1510910539),(928,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1510910571),(929,1,1,0,'member',1,'zhang在2017-11-20 10:34登录了后台',1,1511145290),(930,8,1,0,'attribute',275,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511145716),(931,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511148058),(932,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511148075),(933,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511148101),(934,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511149328),(935,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511151736),(936,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511152673),(937,1,1,0,'member',1,'zhang在2017-11-21 14:31登录了后台',1,1511245909),(938,1,1,0,'member',1,'zhang在2017-11-22 10:03登录了后台',1,1511316210),(939,8,1,0,'attribute',400,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511316330),(940,8,1,0,'attribute',347,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511316468),(941,8,1,0,'attribute',348,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511316476),(942,8,1,0,'attribute',401,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511316561),(943,8,1,0,'attribute',402,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511324779),(944,8,1,0,'attribute',403,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511324827),(945,8,1,0,'attribute',404,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511324874),(946,8,1,0,'attribute',405,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511324897),(947,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511324949),(948,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511325042),(949,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511325094),(950,7,1,0,'model',41,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511325155),(951,1,1,0,'member',1,'zhang在2017-11-24 11:26登录了后台',1,1511493997),(952,8,1,0,'attribute',406,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511494034),(953,8,1,0,'attribute',407,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511496250),(954,8,1,0,'attribute',332,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511496274),(955,8,1,0,'attribute',333,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511496280),(956,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511496447),(957,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511496525),(958,8,1,0,'attribute',406,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511496539),(959,1,1,0,'member',1,'zhang在2017-11-24 12:10登录了后台',1,1511496657),(960,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511496810),(961,1,1,0,'member',1,'zhang在2017-11-24 15:31登录了后台',1,1511508665),(962,8,1,0,'attribute',407,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511509391),(963,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511509412),(964,7,1,0,'model',42,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511509461),(965,8,1,0,'attribute',407,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511509476),(966,1,1,0,'member',1,'zhang在2017-11-27 14:55登录了后台',1,1511765735),(967,7,1,0,'model',45,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511770425),(968,8,1,0,'attribute',408,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770459),(969,8,1,0,'attribute',408,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770468),(970,8,1,0,'attribute',409,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770480),(971,8,1,0,'attribute',410,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770494),(972,8,1,0,'attribute',411,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770512),(973,8,1,0,'attribute',412,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770521),(974,8,1,0,'attribute',413,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770542),(975,8,1,0,'attribute',414,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770561),(976,8,1,0,'attribute',415,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770584),(977,8,1,0,'attribute',416,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770594),(978,8,1,0,'attribute',417,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770607),(979,8,1,0,'attribute',418,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770617),(980,8,1,0,'attribute',415,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770625),(981,8,1,0,'attribute',416,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770631),(982,8,1,0,'attribute',417,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770638),(983,8,1,0,'attribute',418,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770646),(984,8,1,0,'attribute',419,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770661),(985,8,1,0,'attribute',420,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770683),(986,8,1,0,'attribute',420,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770689),(987,8,1,0,'attribute',421,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770722),(988,8,1,0,'attribute',422,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770746),(989,7,1,0,'model',46,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511770874),(990,8,1,0,'attribute',423,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770904),(991,8,1,0,'attribute',424,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770919),(992,8,1,0,'attribute',425,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770938),(993,8,1,0,'attribute',426,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770952),(994,8,1,0,'attribute',427,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770964),(995,8,1,0,'attribute',428,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511770977),(996,8,1,0,'attribute',429,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511771036),(997,1,1,0,'member',1,'zhang在2017-11-27 16:34登录了后台',1,1511771642),(998,7,1,0,'model',46,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511772933),(999,8,1,0,'attribute',430,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511772972),(1000,6,1,0,'config',38,'操作url：/marke/index.php?s=/Admin/Config/edit.html',1,1511773591),(1001,1,1,0,'member',1,'zhang在2017-11-28 09:48登录了后台',1,1511833689),(1002,1,1,0,'member',1,'zhang在2017-11-28 09:55登录了后台',1,1511834152),(1003,8,1,0,'attribute',408,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511834214),(1004,8,1,0,'attribute',409,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511834238),(1005,8,1,0,'attribute',409,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511834248),(1006,8,1,0,'attribute',413,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511834309),(1007,8,1,0,'attribute',413,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835418),(1008,8,1,0,'attribute',414,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835474),(1009,8,1,0,'attribute',415,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835571),(1010,8,1,0,'attribute',416,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835584),(1011,8,1,0,'attribute',417,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835603),(1012,8,1,0,'attribute',418,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835621),(1013,8,1,0,'attribute',419,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835646),(1014,8,1,0,'attribute',420,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511835661),(1015,8,1,0,'attribute',421,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511836236),(1016,8,1,0,'attribute',422,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511836262),(1017,8,1,0,'attribute',423,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511836283),(1018,8,1,0,'attribute',424,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511836347),(1019,8,1,0,'attribute',425,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511836395),(1020,8,1,0,'attribute',426,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511836436),(1021,8,1,0,'attribute',427,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511837057),(1022,8,1,0,'attribute',428,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511837067),(1023,8,1,0,'attribute',429,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511837077),(1024,8,1,0,'attribute',430,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511837096),(1025,8,1,0,'attribute',431,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838473),(1026,8,1,0,'attribute',413,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838861),(1027,8,1,0,'attribute',413,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838868),(1028,8,1,0,'attribute',414,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838874),(1029,8,1,0,'attribute',408,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838882),(1030,8,1,0,'attribute',409,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838887),(1031,8,1,0,'attribute',431,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838916),(1032,8,1,0,'attribute',426,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511838924),(1033,8,1,0,'attribute',416,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511839077),(1034,7,1,0,'model',45,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1511839112),(1035,8,1,0,'attribute',409,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511839205),(1036,8,1,0,'attribute',409,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511839221),(1037,8,1,0,'attribute',432,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511839397),(1038,8,1,0,'attribute',416,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511839661),(1039,8,1,0,'attribute',433,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511840197),(1040,8,1,0,'attribute',433,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511840204),(1041,8,1,0,'attribute',434,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511840230),(1042,8,1,0,'attribute',434,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511840239),(1043,8,1,0,'attribute',435,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511840262),(1044,1,1,0,'member',1,'zhang在2017-11-29 09:22登录了后台',1,1511918579),(1045,8,1,0,'attribute',422,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511920013),(1046,8,1,0,'attribute',436,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511920709),(1047,8,1,0,'attribute',437,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1511921101),(1048,1,1,0,'member',1,'zhang在2017-11-30 09:47登录了后台',1,1512006429),(1049,1,1,0,'member',1,'zhang在2017-11-30 13:23登录了后台',1,1512019380),(1050,1,1,0,'member',1,'zhang在2017-12-01 17:55登录了后台',1,1512122108),(1051,1,1,0,'member',1,'zhang在2017-12-05 10:10登录了后台',1,1512439820),(1052,1,1,0,'member',1,'zhang在2017-12-05 11:33登录了后台',1,1512444803),(1053,1,1,0,'member',1,'zhang在2017-12-06 10:56登录了后台',1,1512528977),(1054,7,1,0,'model',37,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1512529908),(1055,7,1,0,'model',37,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1512530752),(1056,8,1,0,'attribute',438,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512532628),(1057,8,1,0,'attribute',438,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512533176),(1058,8,1,0,'attribute',435,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512533390),(1059,8,1,0,'attribute',432,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512533429),(1060,8,1,0,'attribute',418,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512533490),(1061,8,1,0,'attribute',418,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512533498),(1062,1,1,0,'member',1,'zhang在2017-12-07 09:16登录了后台',1,1512609407),(1063,7,1,0,'model',45,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1512610445),(1064,8,1,0,'attribute',422,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512610769),(1065,1,1,0,'member',1,'zhang在2017-12-08 09:29登录了后台',1,1512696595),(1066,7,1,0,'model',45,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1512696790),(1067,1,1,0,'member',1,'zhang在2017-12-08 11:41登录了后台',1,1512704495),(1068,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512715329),(1069,8,1,0,'attribute',399,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512715446),(1070,8,1,0,'attribute',138,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1512715718),(1071,7,1,0,'model',15,'操作url：/marke/index.php?s=/Admin/Model/update.html',1,1512715769),(1072,1,1,0,'member',1,'zhang在2017-12-11 15:51登录了后台',1,1512978707),(1073,1,1,0,'member',1,'zhang在2017-12-21 09:15登录了后台',1,1513818910),(1074,8,1,0,'attribute',439,'操作url：/marke/index.php?s=/Admin/Attribute/update.html',1,1513818946);
/*!40000 ALTER TABLE `zf_action_log` ENABLE KEYS */;

#
# Structure for table "zf_addons"
#

DROP TABLE IF EXISTS `zf_addons`;
CREATE TABLE `zf_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='插件表';

#
# Data for table "zf_addons"
#

/*!40000 ALTER TABLE `zf_addons` DISABLE KEYS */;
INSERT INTO `zf_addons` VALUES (2,'SiteStat','站点统计信息','统计站点的基础信息',1,'{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"1\",\"display\":\"1\",\"status\":\"0\"}','thinkphp','0.1',1379512015,0),(3,'DevTeam','开发团队信息','开发团队成员信息',1,'{\"title\":\"OneThink\\u5f00\\u53d1\\u56e2\\u961f\",\"width\":\"2\",\"display\":\"1\"}','thinkphp','0.1',1379512022,0),(4,'SystemInfo','系统环境信息','用于显示一些服务器的信息',1,'{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}','thinkphp','0.1',1379512036,0),(5,'Editor','前台编辑器','用于增强整站长文本的输入和显示',1,'{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"300px\",\"editor_resize_type\":\"1\"}','thinkphp','0.1',1379830910,0),(6,'Attachment','附件','用于文档模型上传附件',1,'null','thinkphp','0.1',1379842319,1),(9,'SocialComment','通用社交化评论','集成了各种社交化评论插件，轻松集成到系统中。',1,'{\"comment_type\":\"1\",\"comment_uid_youyan\":\"\",\"comment_short_name_duoshuo\":\"\",\"comment_data_list_duoshuo\":\"\"}','thinkphp','0.1',1380273962,0),(15,'EditorForAdmin','后台编辑器','用于增强整站长文本的输入和显示',1,'{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"500px\",\"editor_resize_type\":\"1\"}','thinkphp','0.1',1383126253,0),(16,'HousesDialog','楼盘弹出搜索页面','楼盘弹出搜索页面',1,'null','崔','0.1',1500526110,0);
/*!40000 ALTER TABLE `zf_addons` ENABLE KEYS */;

#
# Structure for table "zf_attachment"
#

DROP TABLE IF EXISTS `zf_attachment`;
CREATE TABLE `zf_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '附件显示名',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件类型',
  `source` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联记录ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `dir` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '上级目录ID',
  `sort` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_record_status` (`record_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';

#
# Data for table "zf_attachment"
#


#
# Structure for table "zf_attribute"
#

DROP TABLE IF EXISTS `zf_attribute`;
CREATE TABLE `zf_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `is_must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL,
  `validate_time` tinyint(1) unsigned NOT NULL,
  `error_info` varchar(100) NOT NULL,
  `validate_type` varchar(25) NOT NULL,
  `auto_rule` varchar(100) NOT NULL,
  `auto_time` tinyint(1) unsigned NOT NULL,
  `auto_type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=440 DEFAULT CHARSET=utf8 COMMENT='模型属性表';

#
# Data for table "zf_attribute"
#

/*!40000 ALTER TABLE `zf_attribute` DISABLE KEYS */;
INSERT INTO `zf_attribute` VALUES (33,'phone','手机号码','varchar(255) NOT NULL','string','','',1,'',4,0,1,1500531487,1500531487,'',3,'','regex','',3,'function'),(34,'password','\t密码','varchar(255) NOT NULL','string','','',1,'',4,0,1,1500531499,1500531499,'',3,'','regex','',3,'function'),(35,'nick_name','昵称','varchar(255) NOT NULL','string','','',1,'',4,0,1,1500531516,1500531516,'',3,'','regex','',3,'function'),(36,'head_img','头像','varchar(255) NOT NULL','string','','',1,'',4,0,1,1500531553,1500531553,'',3,'','regex','',3,'function'),(37,'is_super','是否是超级会员','char(50) NOT NULL','select','0','',1,'0:0\r\n1:1',4,0,1,1500531583,1500531583,'',3,'','regex','',3,'function'),(38,'created_time','创建时间','int(10) NOT NULL','datetime','','',1,'',4,0,1,1500531620,1500531620,'',3,'','regex','',3,'function'),(39,'updated_time','修改时间','int(10) NOT NULL','datetime','','',1,'',4,0,1,1500531672,1500531672,'',3,'','regex','',3,'function'),(40,'sex','性别','char(50) NOT NULL','select','0','',1,'0:0\r\n1:1\r\n2:2',4,0,1,1500531724,1500531724,'',3,'','regex','',3,'function'),(41,'is_activation','是否激活','char(50) NOT NULL','select','1','',1,'0:0\r\n1:1',4,0,1,1500531749,1500531749,'',3,'','regex','',3,'function'),(42,'status','状态','char(50) NOT NULL','select','1','',1,'0:0\r\n1:1',4,0,1,1500531783,1500531783,'',3,'','regex','',3,'function'),(46,'houses_id','楼盘ID','varchar(200) NOT NULL','houses_dialog','','',1,'',6,0,1,1500537486,1500537486,'',3,'','regex','',3,'function'),(47,'name','会员组名字','varchar(255) NOT NULL','string','','',1,'',6,0,1,1500537555,1500537555,'',3,'','regex','',3,'function'),(48,'bg_color','网站主颜色','varchar(255) NOT NULL','string','#FF6A6A','',1,'',6,0,1,1500537705,1500537705,'',3,'','regex','',3,'function'),(49,'remark','备注','text NOT NULL','textarea','','',1,'',6,0,1,1500543058,1500537818,'',3,'','regex','',3,'function'),(50,'title','标题','varchar(255) NOT NULL','string','','',1,'',7,0,1,1500537971,1500537971,'',3,'','regex','',3,'function'),(51,'path','路径','varchar(255) NOT NULL','string','','',1,'',7,0,1,1500537985,1500537985,'',3,'','regex','',3,'function'),(52,'icon','图标','int(10) UNSIGNED NOT NULL','picture','','上传50x50像素的图片',1,'',7,0,1,1501581173,1500538023,'',3,'','regex','',3,'function'),(53,'m_id','菜单ID','int(10) UNSIGNED NOT NULL','num','','',1,'',8,0,1,1500540002,1500540002,'',3,'','regex','',3,'function'),(54,'title','底部标题','varchar(255) NOT NULL','string','','',1,'',8,0,1,1500540026,1500540026,'',3,'','regex','',3,'function'),(55,'icon','图标','int(10) UNSIGNED NOT NULL','picture','','',1,'',8,0,1,1500540052,1500540052,'',3,'','regex','',3,'function'),(56,'m_id','菜单ID','int(10) UNSIGNED NOT NULL','num','','',1,'',9,0,1,1500540085,1500540085,'',3,'','regex','',3,'function'),(57,'title','权限名称','varchar(255) NOT NULL','string','','',1,'',9,0,1,1500540098,1500540098,'',3,'','regex','',3,'function'),(59,'g_id','会员组ID','int(10) UNSIGNED NOT NULL','num','','',1,'',10,0,1,1500544283,1500544283,'',3,'','regex','',3,'function'),(60,'m_id','菜单ID','int(10) UNSIGNED NOT NULL','num','','',1,'',10,0,1,1500544450,1500544450,'',3,'','regex','',3,'function'),(61,'is_bottom','是否是底部公共栏','int(10) UNSIGNED NOT NULL','num','','',1,'',10,0,1,1500544466,1500544466,'',3,'','regex','',3,'function'),(62,'order','排序','int(10) UNSIGNED NOT NULL','num','','',1,'',10,0,1,1500544536,1500544536,'',3,'','regex','',3,'function'),(63,'order_bottom','底部排序','int(10) UNSIGNED NOT NULL','num','','',1,'',10,0,1,1500544548,1500544548,'',3,'','regex','',3,'function'),(64,'m_auth','权限','varchar(255) NOT NULL','string','','',1,'',10,0,1,1500544563,1500544563,'',3,'','regex','',3,'function'),(65,'g_id','会员组ID','int(10) UNSIGNED NOT NULL','num','','',1,'',11,0,1,1500544606,1500544606,'',3,'','regex','',3,'function'),(66,'uid','会员ID','int(10) UNSIGNED NOT NULL','num','','',1,'',11,0,1,1500544625,1500544625,'',3,'','regex','',3,'function'),(68,'status','状态','char(50) NOT NULL','select','','',1,'-1:删除\r\n0:禁止\r\n1:启用',8,0,1,1500720351,1500720351,'',3,'','regex','',3,'function'),(90,'b_name','栋序号（名）','varchar(255) NOT NULL','string','','',1,'',13,0,1,1500605316,1500605316,'',3,'','regex','',3,'function'),(91,'unit_num','单元数','int(10) UNSIGNED NOT NULL','num','','',1,'',13,0,1,1501037964,1501037964,'',3,'','regex','',3,'function'),(92,'is_w','是否填写单元表','varchar(255) NOT NULL','string','','',1,'',13,0,1,1501038221,1500605371,'',3,'','regex','',3,'function'),(94,'b_id','栋号表ID','int(10) UNSIGNED NOT NULL','num','','',1,'',14,0,1,1500605414,1500605414,'',3,'','regex','',3,'function'),(95,'u_order','单元排序','int(10) UNSIGNED NOT NULL','num','','',1,'',14,0,1,1500605415,1500605415,'',3,'','regex','',3,'function'),(96,'u_name','单元序号（名称）','varchar(255) NOT NULL','string','','',1,'',14,0,1,1504669596,1500605477,'',3,'','regex','',3,'function'),(97,'room_num','每层房间数','int(10) UNSIGNED NOT NULL','num','','',1,'',14,0,1,1500605518,1500605518,'',3,'','regex','',3,'function'),(98,'floor_start','开始楼层','int(10) UNSIGNED NOT NULL','num','','',1,'',14,0,1,1500605551,1500605551,'',3,'','regex','',3,'function'),(99,'floor_over','结束楼层','int(10) UNSIGNED NOT NULL','num','','',1,'',14,0,1,1500605568,1500605568,'',3,'','regex','',3,'function'),(102,'r_name','房间序号（名称）','varchar(255) NOT NULL','string','','',1,'',15,0,1,1500606127,1500606127,'',3,'','regex','',3,'function'),(103,'unit_price','最低建筑单价','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1501207761,1500609570,'',3,'','regex','',3,'function'),(104,'usable_price','最低套内单价','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1501207771,1500609588,'',3,'','regex','',3,'function'),(105,'total_price','总价','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1501233838,1500609607,'',3,'','regex','',3,'function'),(106,'area','建筑面积','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1500609622,1500609622,'',3,'','regex','',3,'function'),(107,'usable_area','套内面积','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1500609642,1500609642,'',3,'','regex','',3,'function'),(108,'apartment','房','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1500609657,1500609657,'',3,'','regex','',3,'function'),(109,'hall','厅','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1500609674,1500609674,'',3,'','regex','',3,'function'),(110,'kitchen','厨','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1500609695,1500609695,'',3,'','regex','',3,'function'),(111,'toilet','卫','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1500609713,1500609713,'',3,'','regex','',3,'function'),(112,'usable_tw_price','套内单价差价','int(10) UNSIGNED NOT NULL','num','','从第一层开始',1,'',15,0,1,1501207823,1500609751,'',3,'','regex','',3,'function'),(113,'bt_price','建筑价格差价','int(10) UNSIGNED NOT NULL','num','','',1,'',15,0,1,1501207802,1500609774,'',3,'','regex','',3,'function'),(115,'u_id','单元ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1502271904,1500610074,'',3,'','regex','',3,'function'),(116,'room_number','房号','varchar(255) NOT NULL','string','','',1,'',16,0,1,1500610103,1500610103,'',3,'','regex','',3,'function'),(117,'s_id','同类型表ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1503990144,1503990144,'',3,'','regex','',3,'function'),(118,'status','状态','char(50) NOT NULL','select','0','',1,'-1:不可售\r\n0:待售\r\n1:锁定\r\n2:滞销\r\n9:已售\r\n',16,0,1,1501236023,1500610179,'',3,'','regex','',3,'function'),(119,'remark','备注','varchar(255) NOT NULL','string','','',1,'',16,0,1,1505378264,1500610221,'',3,'','regex','',3,'function'),(120,'market_uid','销控人ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1505378439,1500610245,'',3,'','regex','',3,'function'),(121,'market_time','销控时间','int(10) NOT NULL','datetime','','',1,'',16,0,1,1505378325,1500610265,'',3,'','regex','',3,'function'),(122,'is_check','是否审核','tinyint(2) NOT NULL','bool','0','',1,'0:未审核\r\n1:已审核',16,0,1,1502872297,1502872297,'',3,'','regex','',3,'function'),(123,'status','状态','char(50) NOT NULL','select','','0',1,'-1:删除\r\n0:禁用\r\n1:启用',7,0,1,1500623474,1500623397,'',3,'','regex','',3,'function'),(124,'orientation','朝向','varchar(255) NOT NULL','string','','',1,'',15,0,1,1505268705,1505268705,'',3,'','regex','',3,'function'),(125,'thumb','户型图','varchar(255)','string','','',1,'',15,0,1,1506417644,1503366142,'',3,'','regex','',3,'function'),(131,'menu_sort','菜单排序','varchar(255) NOT NULL','string','','',1,'',6,0,1,1502097533,1502097533,'',3,'','regex','',3,'function'),(132,'bottom_sort','底部排序','varchar(255) NOT NULL','string','','',1,'',6,0,1,1502097551,1502097551,'',3,'','regex','',3,'function'),(133,'floor','楼层','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1502330036,1502330036,'',3,'','regex','',3,'function'),(134,'unit_price','单价','varchar(255) NOT NULL','string','','',1,'',16,0,1,1502330056,1502330056,'',3,'','regex','',3,'function'),(135,'usable_price','套内单价','varchar(255) NOT NULL','string','','',1,'',16,0,1,1502335190,1502330084,'',3,'','regex','',3,'function'),(136,'view','浏览数','int(10) UNSIGNED NOT NULL','num','0','',1,'',16,0,1,1501236033,1500610122,'',3,'','regex','',3,'function'),(137,'status','状态','tinyint(2) NOT NULL','bool','1','',1,'-1:待售\r\n1:在售',13,0,1,1504060586,1504060586,'',3,'','regex','',3,'function'),(138,'status','状态','tinyint(2) NOT NULL','bool','1','',1,'-1:待售\r\n1:在售',14,0,1,1512715718,1504060618,'',3,'','regex','',3,'function'),(143,'path','路径','varchar(255) NOT NULL','string','','',1,'',25,0,1,1502423158,1502423158,'',3,'','regex','',3,'function'),(144,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',25,0,1,1502423177,1502423177,'',3,'','regex','',3,'function'),(145,'created_time','创建时间','int(10) NOT NULL','datetime','','',1,'',25,0,1,1502423192,1502423192,'',3,'','regex','',3,'function'),(146,'title','标题','varchar(255) NOT NULL','string','','',1,'',26,0,1,1502436688,1502436688,'',3,'','regex','',3,'function'),(147,'content','内容','text NOT NULL','textarea','','',1,'',26,0,1,1502436702,1502436702,'',3,'','regex','',3,'function'),(148,'type','类型','char(50) NOT NULL','select','1','',1,'1:普通\r\n2:紧急\r\n3:分销',26,0,1,1502436826,1502436826,'',3,'','regex','',3,'function'),(149,'created_time','发布时间','int(10) NOT NULL','datetime','','',1,'',26,0,1,1502436876,1502436876,'',3,'','regex','',3,'function'),(150,'is_delete','是否删除','tinyint(2) NOT NULL','bool','1','',1,'0:删除\r\n1:未删除',26,0,1,1502436916,1502436916,'',3,'','regex','',3,'function'),(151,'file','文件','varchar(255) NOT NULL','string','','',1,'',26,0,1,1505184160,1502436939,'',3,'','regex','',3,'function'),(152,'b_id','公告ID','int(10) UNSIGNED NOT NULL','num','','',1,'',27,0,1,1502437550,1502437105,'',3,'','regex','',3,'function'),(153,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',27,0,1,1502437154,1502437154,'',3,'','regex','',3,'function'),(154,'read_time','阅读时间','int(10) NOT NULL','datetime','','',1,'',27,0,1,1502437168,1502437168,'',3,'','regex','',3,'function'),(155,'pictures','图片','varchar(255) NOT NULL','string','','',1,'',26,0,1,1502438023,1502438023,'',3,'','regex','',3,'function'),(157,'view','观看人数','int(10) UNSIGNED NOT NULL','num','','',1,'',26,0,1,1502442569,1502442569,'',3,'','regex','',3,'function'),(158,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',28,0,1,1502695130,1502695130,'',3,'','regex','',3,'function'),(159,'content','发布内容','text NOT NULL','textarea','','',1,'',28,0,1,1502695154,1502695154,'',3,'','regex','',3,'function'),(160,'send_time','发送时间','int(10) NOT NULL','datetime','','',1,'',28,0,1,1502695207,1502695207,'',3,'','regex','',3,'function'),(161,'remark','备注','varchar(255) NOT NULL','string','','',1,'',28,0,1,1502695231,1502695231,'',3,'','regex','',3,'function'),(166,'r_id','房号表ID','int(10) UNSIGNED NOT NULL','num','','',1,'',29,0,1,1502952928,1502952928,'',3,'','regex','',3,'function'),(167,'type','操作类型','char(10) NOT NULL','radio','','',1,'1:锁定\r\n2:成交',29,0,1,1504755165,1502952948,'',3,'','regex','',3,'function'),(168,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',29,0,1,1502952963,1502952963,'',3,'','regex','',3,'function'),(169,'op_time','操作时间','int(10) NOT NULL','datetime','','',1,'',29,0,1,1502952986,1502952986,'',3,'','regex','',3,'function'),(170,'check_id','审核ID','int(10) UNSIGNED NOT NULL','num','','',1,'',29,0,1,1504584728,1504584728,'',3,'','regex','',3,'function'),(201,'lock_uid','锁定用于ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1505378350,1505378350,'',3,'','regex','',3,'function'),(202,'lock_time','锁定时间','int(10) NOT NULL','datetime','','',1,'',16,0,1,1505378380,1505378380,'',3,'','regex','',3,'function'),(203,'submit_uid','成交用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1505378416,1505378416,'',3,'','regex','',3,'function'),(204,'submit_time','成交时间','int(10) NOT NULL','datetime','','',1,'',16,0,1,1505378432,1505378432,'',3,'','regex','',3,'function'),(205,'lastop_uid','最后操作用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1505379295,1505379295,'',3,'','regex','',3,'function'),(206,'lock_check_uid','审核锁定的会员ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1505381329,1505381329,'',3,'','regex','',3,'function'),(207,'submit_check_uid','审核成交的会员ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1505381368,1505381368,'',3,'','regex','',3,'function'),(209,'bg_type','类型','tinyint(2) NOT NULL','bool','0','',1,'0:背景图片\r\n1:背景颜色',33,0,1,1505706967,1505706967,'',3,'','regex','',3,'function'),(210,'bg_img','背景图片ID','int(10) UNSIGNED NOT NULL','num','','',1,'',33,0,1,1505706985,1505706985,'',3,'','regex','',3,'function'),(211,'bg_color','背景颜色','varchar(255) NOT NULL','string','','',1,'',33,0,1,1505716887,1505707003,'',3,'','regex','',3,'function'),(212,'remark','备注','text NOT NULL','textarea','','',1,'',33,0,1,1505716913,1505716913,'',3,'','regex','',3,'function'),(214,'cover_id','图片ID','int(10) UNSIGNED NOT NULL','num','','',1,'',34,0,1,1506303408,1506303408,'',3,'','regex','',3,'function'),(216,'title','标题','varchar(255) NOT NULL','string','','',1,'',35,0,1,1506322242,1506322195,'',3,'','regex','',3,'function'),(217,'content','内容','text NOT NULL','textarea','','',1,'',35,0,1,1506322269,1506322269,'',3,'','regex','',3,'function'),(218,'view','浏览数目','int(10) UNSIGNED NOT NULL','num','','',1,'',35,0,1,1506322295,1506322295,'',3,'','regex','',3,'function'),(219,'created_time','创建时间','int(10) NOT NULL','datetime','','',1,'',35,0,1,1506322320,1506322320,'',3,'','regex','',3,'function'),(221,'cus_phone','客户手机','VARCHAR(255) NOT NULL','string','','',1,'',36,0,1,1506506317,1506497133,'',3,'','regex','',3,'function'),(222,'cus_name','客户姓名','varchar(255) NOT NULL','string','','',1,'',36,0,1,1506497145,1506497145,'',3,'','regex','',3,'function'),(223,'voucher_thumb','凭证图片','int(10) UNSIGNED NOT NULL','picture','','',1,'',36,0,1,1506497226,1506497226,'',3,'','regex','',3,'function'),(224,'voucher_number','凭证信息','varchar(255) NOT NULL','string','','',1,'',36,0,1,1506497242,1506497242,'',3,'','regex','',3,'function'),(225,'user_phone','置业顾问手机','VARCHAR(255) NOT NULL','string','','',1,'',36,0,1,1506506325,1506497619,'',3,'','regex','',3,'function'),(226,'user_name','置业顾问姓名','varchar(255) NOT NULL','string','','',1,'',36,0,1,1506497648,1506497648,'',3,'','regex','',3,'function'),(227,'created_time','创建时间','int(10) NOT NULL','datetime','','',1,'',36,0,1,1506497823,1506497823,'',3,'','regex','',3,'function'),(228,'status','是否审核','tinyint(2) NOT NULL','bool','0','',1,'0:未审核\r\n1:已审核',36,0,1,1506498087,1506498087,'',3,'','regex','',3,'function'),(230,'start_time','开盘时间','int(10) NOT NULL','datetime','','',1,'',37,0,1,1506650123,1506650123,'',3,'','regex','',3,'function'),(231,'remark','备注','text NOT NULL','textarea','','',1,'',37,0,1,1506650332,1506650332,'',3,'','regex','',3,'function'),(233,'r_id','房号ID','int(10) UNSIGNED NOT NULL','num','','',1,'',38,0,1,1507520508,1507520508,'',3,'','regex','',3,'function'),(234,'raise_id','认筹ID','int(10) UNSIGNED NOT NULL','num','','',1,'',38,0,1,1507520543,1507520534,'',3,'','regex','',3,'function'),(244,'title','标题','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507790381,1507790381,'',3,'','regex','',3,'function'),(245,'description','描述','text NOT NULL','textarea','','',1,'',12,0,1,1507790816,1507790816,'',3,'','regex','',3,'function'),(246,'address','地址','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791597,1507791597,'',3,'','regex','',3,'function'),(247,'openingtime','开盘时间','int(10) NOT NULL','datetime','','',1,'',12,0,1,1507791727,1507791712,'',3,'','regex','',3,'function'),(248,'openingtime_remark','开盘时间备注','text NOT NULL','textarea','','',1,'',12,0,1,1507791751,1507791751,'',3,'','regex','',3,'function'),(249,'launchtime','交房时间','int(10) NOT NULL','datetime','','',1,'',12,0,1,1507791786,1507791786,'',3,'','regex','',3,'function'),(250,'launchtime_remark','交房时间备注','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791797,1507791797,'',3,'','regex','',3,'function'),(251,'areacovered','占地面积','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791820,1507791820,'',3,'','regex','',3,'function'),(252,'plotratio','容积率','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791832,1507791832,'',3,'','regex','',3,'function'),(253,'greeningrate','绿化率','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791853,1507791853,'',3,'','regex','',3,'function'),(254,'mcompany','物业公司','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791866,1507791866,'',3,'','regex','',3,'function'),(255,'developer','开发商','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791874,1507791874,'',3,'','regex','',3,'function'),(256,'salepermit','预售许可证','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791884,1507791884,'',3,'','regex','',3,'function'),(257,'salesaddress','售楼地址','varchar(255) NOT NULL','string','','',1,'',12,0,1,1507791892,1507791892,'',3,'','regex','',3,'function'),(259,'raise_id','认筹购买ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1508471631,1508471631,'',3,'','regex','',3,'function'),(260,'raise_time','认筹购买时间','int(10) NOT NULL','datetime','','',1,'',16,0,1,1508471677,1508471677,'',3,'','regex','',3,'function'),(261,'r_id','房号ID','int(10) UNSIGNED NOT NULL','num','','',1,'',40,0,1,1508472788,1508472788,'',3,'','regex','',3,'function'),(262,'raise_id','认筹ID','int(10) UNSIGNED NOT NULL','num','','',1,'',40,0,1,1508472802,1508472802,'',3,'','regex','',3,'function'),(263,'r_id','购房房号','int(10) UNSIGNED NOT NULL','num','','',1,'',36,0,1,1508809928,1508809928,'',3,'','regex','',3,'function'),(264,'buy_time','购房时间','int(10) NOT NULL','datetime','','',1,'',36,0,1,1508810111,1508809949,'',3,'','regex','',3,'function'),(265,'check_out','是否退房','tinyint(2) NOT NULL','bool','0','',1,'0:0\r\n1:1',36,0,1,1508810065,1508810065,'',3,'','regex','',3,'function'),(266,'check_out_time','退房时间','int(10) NOT NULL','datetime','','',1,'',36,0,1,1508810100,1508810100,'',3,'','regex','',3,'function'),(267,'name','姓名','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508817589,1508817589,'',3,'','regex','',3,'function'),(268,'sex','性别','char(10) NOT NULL','radio','0','',1,'1:男\r\n2:女',41,0,1,1508838759,1508817638,'',3,'','regex','',3,'function'),(269,'phone','联系方式','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508817648,1508817648,'',3,'','regex','',3,'function'),(270,'id_number','身份证号码','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508900781,1508817665,'',3,'','regex','',3,'function'),(271,'age','年龄','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508817674,1508817674,'',3,'','regex','',3,'function'),(272,'address','地址','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508817683,1508817683,'',3,'','regex','',3,'function'),(273,'in_province','是否是本省','char(10) NOT NULL','radio','1','',1,'0:不是\r\n1:是',41,0,1,1508838687,1508817977,'',3,'','regex','',3,'function'),(274,'intention_money','意向登记金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508817991,1508817991,'',3,'','regex','',3,'function'),(275,'return_money','是否退意向金','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1511145723,1508818001,'',3,'','regex','',3,'function'),(276,'intention_time','意向登记时间','int(10)','datetime','','',1,'',41,0,1,1509414282,1508818014,'',3,'','regex','',3,'function'),(277,'intention_room_style','意向房型','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508818027,1508818027,'',3,'','regex','',3,'function'),(278,'serial_number','登记系列号','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508818038,1508818038,'',3,'','regex','',3,'function'),(279,'contract_no','合同编号','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508818049,1508818049,'',3,'','regex','',3,'function'),(280,'contract_time','合同签约时间','int(10)','datetime','','',1,'',41,0,1,1509414274,1508818063,'',3,'','regex','',3,'function'),(281,'contract_receipt_time','合同约定收款时间','int(10)','datetime','','',1,'',41,0,1,1509414432,1508818077,'',3,'','regex','',3,'function'),(282,'subscription_time','认购日期','int(10)','datetime','','',1,'',41,0,1,1509413939,1508818088,'',3,'','regex','',3,'function'),(283,'unit_price','单价','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508818099,1508818099,'',3,'','regex','',3,'function'),(284,'contract_money','合同金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508818151,1508818151,'',3,'','regex','',3,'function'),(285,'intention_money_return_time','退意向金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1510037903,1508818164,'',3,'','regex','',3,'function'),(286,'decoration_money','装修款','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508818314,1508818314,'',3,'','regex','',3,'function'),(287,'offer_policy','优惠政策','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508818505,1508818505,'',3,'','regex','',3,'function'),(288,'room_number','楼栋房号','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508818515,1508818515,'',3,'','regex','',3,'function'),(289,'area','面积','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508818525,1508818525,'',3,'','regex','',3,'function'),(290,'ot_payment','一次性付款','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1508830677,1508818555,'',3,'','regex','',3,'function'),(291,'bank_mortgage','银行按揭','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1508830671,1508818571,'',3,'','regex','',3,'function'),(292,'installment','分期付款','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1508830663,1508818592,'',3,'','regex','',3,'function'),(293,'deposit','定金（含意向金）','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508818605,1508818605,'',3,'','regex','',3,'function'),(294,'down_payment','首付（含定金）','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508832740,1508818619,'',3,'','regex','',3,'function'),(295,'progress_payment_1','已收进度款一','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510039879,1508818633,'',3,'','regex','',3,'function'),(296,'progress_payment_time_1','进度款一时间','int(10)','datetime','','',1,'',41,0,1,1509413929,1508818647,'',3,'','regex','',3,'function'),(297,'progress_payment_2','已收进度款二','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510039871,1508818659,'',3,'','regex','',3,'function'),(298,'progress_payment_time_2','进度款二时间','int(10)','datetime','','',1,'',41,0,1,1509413921,1508818675,'',3,'','regex','',3,'function'),(299,'progress_payment_3','已收进度款三','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510039861,1508818686,'',3,'','regex','',3,'function'),(300,'progress_payment_time_3','进度款三时间','int(10)','datetime','','',1,'',41,0,1,1509413910,1508818696,'',3,'','regex','',3,'function'),(301,'loan_amout','银行贷款金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508828734,1508828734,'',3,'','regex','',3,'function'),(302,'get_loan_amout','银行贷款到帐金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508828751,1508828751,'',3,'','regex','',3,'function'),(303,'cus_info_reported_time','客户信息备案领取时间','int(10)','datetime','','',1,'',41,0,1,1509414560,1508828783,'',3,'','regex','',3,'function'),(304,'check_out','是否退房','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1509437873,1508828800,'',3,'','regex','',3,'function'),(305,'check_out_money','退房款金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510039942,1508828810,'',3,'','regex','',3,'function'),(306,'get_check_out_money','已退退房款金额','int(10) UNSIGNED NOT NULL','num','0','',1,'',41,0,1,1510039970,1508828897,'',3,'','regex','',3,'function'),(307,'check_out_time','退款时间','int(10)','datetime','','',1,'',41,0,1,1509413900,1508828914,'',3,'','regex','',3,'function'),(308,'sales_point','置业顾问提成点数','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508828943,1508828943,'',3,'','regex','',3,'function'),(309,'sales_commission','置业顾问佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508828977,1508828954,'',3,'','regex','',3,'function'),(310,'sales_bonus','置业顾问奖金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1509432769,1508828995,'',3,'','regex','',3,'function'),(311,'sales_receive_commission','置业顾问已领取的佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510039905,1508829055,'',3,'','regex','',3,'function'),(312,'sales_commission_time','置业顾问领取佣金时间','int(10)','datetime','','',1,'',41,0,1,1509414598,1508829089,'',3,'','regex','',3,'function'),(313,'sales_receive_bonus','置业顾问已领取的奖金金额','int(10) UNSIGNED NOT NULL','num','0','',1,'',41,0,1,1510040145,1508829127,'',3,'','regex','',3,'function'),(314,'sales_bonus_time','置业顾问已领取奖金时间','int(10)','datetime','','',1,'',41,0,1,1509414624,1508829151,'',3,'','regex','',3,'function'),(315,'sales_return_commission','置业顾问退回的佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040157,1508829175,'',3,'','regex','',3,'function'),(316,'sales_return_com_time','置业顾问退回佣金时间','int(10)','datetime','','',1,'',41,0,1,1509942715,1508829201,'',3,'','regex','',3,'function'),(317,'distribution','分销商','varchar(255) NOT NULL','string','','',1,'',41,0,1,1508829213,1508829213,'',3,'','regex','',3,'function'),(318,'distribution_point','分销点数','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508829225,1508829225,'',3,'','regex','',3,'function'),(319,'is_dribution_invoice','分销发票是否收','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1508830776,1508829245,'',3,'','regex','',3,'function'),(320,'distribution_commission','分销商佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040166,1508829259,'',3,'','regex','',3,'function'),(321,'distribution_bonus','分销奖金、成交奖','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1508829278,1508829278,'',3,'','regex','',3,'function'),(322,'dis_receive_commission','分销商已领取的佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040174,1508829313,'',3,'','regex','',3,'function'),(323,'dis_commission_time','分销商领取佣金时间','int(10)','datetime','','',1,'',41,0,1,1509414748,1508830291,'',3,'','regex','',3,'function'),(324,'dis_receive_bonus','分销商已领取的奖金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040182,1508830320,'',3,'','regex','',3,'function'),(325,'dis_bonus_time','分销商领取奖金时间','int(10)','datetime','','',1,'',41,0,1,1509413871,1508830332,'',3,'','regex','',3,'function'),(326,'dis_return_commission','分销商退回的佣金金额','int(10) UNSIGNED NOT NULL','num','0','',1,'',41,0,1,1510040189,1508830485,'',3,'','regex','',3,'function'),(327,'dis_return_com_time','分销商退回佣金的时间','int(10)','datetime','','',1,'',41,0,1,1509942704,1508830602,'',3,'','regex','',3,'function'),(328,'is_over','是否完成','tinyint(2) NOT NULL','bool','0','合同是否完成',1,'0:否\r\n1:是',41,0,1,1509009451,1509009451,'',3,'','regex','',3,'function'),(329,'is_intention','意向登记','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',41,0,1,1509009501,1509009501,'',3,'','regex','',3,'function'),(330,'base_commission','佣金基数','int(10) UNSIGNED NOT NULL','num','','根据佣金基数和佣金点数计算佣金金额',1,'',41,0,1,1509009595,1509009595,'',3,'','regex','',3,'function'),(331,'sales','置业顾问','varchar(255) NOT NULL','string','','',1,'',41,0,1,1509954107,1509431998,'',3,'','regex','',3,'function'),(332,'name','客户姓名','varchar(255) NOT NULL','string','','',1,'',42,1,1,1511497038,1509591644,'',3,'','regex','',3,'function'),(333,'phone','联系方式','varchar(255) NOT NULL','string','','',1,'',42,1,1,1511497045,1509591666,'',3,'','regex','',3,'function'),(334,'first_time','首次登录时间','int(10)','datetime','','',1,'',42,0,1,1509604586,1509591698,'',3,'','regex','',3,'function'),(335,'last_time','上次更新时间','int(10)','datetime','','',1,'',42,0,1,1509604579,1509591718,'',3,'','regex','',3,'function'),(336,'in_province','是否本省','tinyint(2) NOT NULL','bool','1','',1,'0:是\r\n1:否',42,0,1,1509591751,1509591751,'',3,'','regex','',3,'function'),(337,'position','要求位置','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509591768,1509591768,'',3,'','regex','',3,'function'),(338,'area','面积','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509591777,1509591777,'',3,'','regex','',3,'function'),(339,'installation','主要抗性','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509592568,1509591820,'',3,'','regex','',3,'function'),(340,'like_price','心理价位','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509591882,1509591882,'',3,'','regex','',3,'function'),(341,'job','职位','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509591925,1509591925,'',3,'','regex','',3,'function'),(342,'come_num','置业次数','int(10) UNSIGNED NOT NULL','num','','',1,'',42,0,1,1509591999,1509591999,'',3,'','regex','',3,'function'),(343,'require','要求','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509592580,1509592580,'',3,'','regex','',3,'function'),(344,'use','用途','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509592606,1509592606,'',3,'','regex','',3,'function'),(345,'is_deal','是否成交','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',42,0,1,1509592656,1509592656,'',3,'','regex','',3,'function'),(346,'intention','意向判断','int(10) NOT NULL','num','','',1,'',42,0,1,1510295806,1509592696,'',3,'','regex','',3,'function'),(347,'over','是否完成','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',42,0,1,1511316546,1509592726,'',3,'','regex','',3,'function'),(348,'check_out','是否退房','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',42,0,1,1511316554,1509592759,'',3,'','regex','',3,'function'),(349,'sales_name','置业顾问','varchar(255) NOT NULL','string','','',1,'',42,0,1,1509592875,1509592875,'',3,'','regex','',3,'function'),(350,'remark','备注','text NOT NULL','textarea','','',1,'',42,0,1,1509592892,1509592892,'',3,'','regex','',3,'function'),(351,'ct_id','客户跟踪表ID','int(10) UNSIGNED NOT NULL','num','','',1,'',43,0,1,1509593232,1509593232,'',3,'','regex','',3,'function'),(352,'time','时间','int(10) NOT NULL','datetime','','',1,'',43,0,1,1509593260,1509593260,'',3,'','regex','',3,'function'),(353,'type','类型','varchar(255) NOT NULL','string','','',1,'',43,0,1,1509615169,1509593306,'',3,'','regex','',3,'function'),(354,'remark','备注','varchar(255) NOT NULL','string','','',1,'',43,0,1,1509593333,1509593333,'',3,'','regex','',3,'function'),(355,'loan_amout_time','银行贷款到账时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509672796,1509672796,'',3,'','regex','',3,'function'),(356,'down_payment_time','首付时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509674338,1509674338,'',3,'','regex','',3,'function'),(357,'deposit_time','定金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509674356,1509674356,'',3,'','regex','',3,'function'),(358,'manager','渠道经理','varchar(255) NOT NULL','string','','',1,'',41,0,1,1509701646,1509701619,'',3,'','regex','',3,'function'),(359,'manager_point','渠道经理提成点数','varchar(255) NOT NULL','string','','',1,'',41,0,1,1509701694,1509701694,'',3,'','regex','',3,'function'),(360,'manager_commission','渠道经理佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040216,1509701740,'',3,'','regex','',3,'function'),(361,'manager_bonus','渠道经理奖金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040223,1509701789,'',3,'','regex','',3,'function'),(362,'manager_receive_commission','渠道经理已领取佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040232,1509701894,'',3,'','regex','',3,'function'),(363,'manager_commission_time','渠道经理领取佣金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509701952,1509701952,'',3,'','regex','',3,'function'),(364,'manager_receive_bonus','渠道经理已领取的奖金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040242,1509702000,'',3,'','regex','',3,'function'),(365,'manager_bonus_time','渠道经理领取奖金时间','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1509702025,1509702025,'',3,'','regex','',3,'function'),(366,'manager_return_commission','渠道经理退回的佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040254,1509702079,'',3,'','regex','',3,'function'),(367,'manager_return_com_time','渠道经理退回佣金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509942693,1509702128,'',3,'','regex','',3,'function'),(368,'supervisor','案场主管','varchar(255) NOT NULL','string','','',1,'',41,0,1,1509702176,1509702176,'',3,'','regex','',3,'function'),(369,'supervisor_point','案场主管提成点数','varchar(255) NOT NULL','string','','',1,'',41,0,1,1509702230,1509702230,'',3,'','regex','',3,'function'),(370,'supervisor_commission','案场主管佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040356,1509702268,'',3,'','regex','',3,'function'),(371,'supervisor_bonus','案场主管奖金金额','varchar(255) NOT NULL','string','','',1,'',41,0,1,1510040362,1509702299,'',3,'','regex','',3,'function'),(372,'supervisor_receive_commission','案场主管已领取佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040368,1509702334,'',3,'','regex','',3,'function'),(373,'supervisor_commission_time','案场主管领取佣金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509702368,1509702368,'',3,'','regex','',3,'function'),(374,'supervisor_receive_bonus','案场主管已领取奖金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040376,1509702441,'',3,'','regex','',3,'function'),(375,'supervisor_bonus_time','案场主管领取奖金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509702501,1509702501,'',3,'','regex','',3,'function'),(376,'supervisor_return_commission','案场主管退回的佣金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040384,1509702539,'',3,'','regex','',3,'function'),(377,'supervisor_return_com_time','案场主管退回佣金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1509942683,1509702568,'',3,'','regex','',3,'function'),(378,'decoration_receive_money','已收装修款金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040391,1510038298,'',3,'','regex','',3,'function'),(379,'decoration_receive_money_time','收到装修款时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1510038658,1510038658,'',3,'','regex','',3,'function'),(380,'deposit_return','已退定金金额','int(10) UNSIGNED NOT NULL','num','','',1,'',41,0,1,1510040400,1510039180,'',3,'','regex','',3,'function'),(381,'deposit_return_time','退定金时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1510039232,1510039232,'',3,'','regex','',3,'function'),(382,'get_contract_money','完成合同收款','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',41,0,1,1510039372,1510039372,'',3,'','regex','',3,'function'),(383,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',0,'',42,0,1,1510216246,1510215735,'',3,'','regex','',3,'function'),(384,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',0,'',41,0,1,1510217205,1510217099,'',3,'','regex','',3,'function'),(385,'uid','用户ID','int(10) UNSIGNED NOT NULL','num','','',1,'',36,0,1,1510303116,1510303116,'',3,'','regex','',3,'function'),(386,'check_id','审核ID','int(10) UNSIGNED NOT NULL','num','','',1,'',36,0,1,1510303281,1510303281,'',3,'','regex','',3,'function'),(387,'raise_check_uid','认筹审核ID','int(10) UNSIGNED NOT NULL','num','','',1,'',16,0,1,1510539046,1510539046,'',3,'','regex','',3,'function'),(388,'raise_over','是否认购完成','tinyint(2) NOT NULL','bool','0','',1,'0:否\r\n1:是',36,0,1,1510543005,1510543005,'',3,'','regex','',3,'function'),(389,'title','标题','varchar(255) NOT NULL','string','','',1,'',44,0,1,1510557985,1510557985,'',3,'','regex','',3,'function'),(390,'content','内容','text NOT NULL','textarea','','',1,'',44,0,1,1510558021,1510558021,'',3,'','regex','',3,'function'),(391,'type','类型','tinyint(2) NOT NULL','bool','0','',1,'0:信息\r\n1:公告',44,0,1,1510558188,1510558188,'',3,'','regex','',3,'function'),(392,'created_time','发布时间','int(10) NOT NULL','datetime','','',1,'',44,0,1,1510558218,1510558218,'',3,'','regex','',3,'function'),(393,'pictures','图片','varchar(255) NOT NULL','string','','',1,'',44,0,1,1510558293,1510558293,'',3,'','regex','',3,'function'),(394,'file','文件','varchar(255) NOT NULL','string','','',1,'',44,0,1,1510561638,1510558316,'',3,'','regex','',3,'function'),(395,'view','浏览数','int(10) UNSIGNED NOT NULL','num','','',1,'',44,0,1,1510558351,1510558351,'',3,'','regex','',3,'function'),(396,'is_del','是否删除','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',44,0,1,1510558386,1510558386,'',3,'','regex','',3,'function'),(397,'agreement','协议','text NOT NULL','textarea','','',1,'',37,0,1,1510558468,1510558468,'',3,'','regex','',3,'function'),(398,'created_time','创建时间','int(10) NOT NULL','datetime','','',0,'',41,0,1,1511149101,1511148021,'',3,'','regex','',3,'function'),(399,'type','类型','tinyint(2) NOT NULL','bool','','',1,'0:商品房\r\n1:别墅',13,0,1,1512715446,1511246085,'',3,'','regex','',3,'function'),(400,'record','网上备案','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',42,0,1,1511316345,1511316345,'',3,'','regex','',3,'function'),(401,'get_house','是否交房','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',42,0,1,1511316575,1511316575,'',3,'','regex','',3,'function'),(402,'record','是否网上备案','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',41,0,1,1511324793,1511324793,'',3,'','regex','',3,'function'),(403,'record_time','备案时间','tinyint(2) NOT NULL','bool','','',1,'',41,0,1,1511324841,1511324841,'',3,'','regex','',3,'function'),(404,'get_house','是否交房','tinyint(2) NOT NULL','bool','','',1,'0:否\r\n1:是',41,0,1,1511324881,1511324881,'',3,'','regex','',3,'function'),(405,'get_house_time','交房时间','int(10) NOT NULL','datetime','','',1,'',41,0,1,1511324902,1511324902,'',3,'','regex','',3,'function'),(406,'status','状态','tinyint(2) NOT NULL','bool','1','',0,'-1:删除\r\n1:正常',42,0,1,1511497477,1511497007,'',3,'','regex','',3,'function'),(407,'cus_from','客户来源','varchar(255) NOT NULL','string','','',2,'',42,1,1,1511497090,1511497029,'',3,'','regex','',3,'function'),(408,'name','客户姓名','varchar(255) NOT NULL','string','','',1,'',45,1,1,1511838882,1511834214,'',3,'','regex','',3,'function'),(409,'phone','联系方式','varchar(255) NOT NULL','string','','',1,'',45,1,1,1511839221,1511834238,'',3,'','regex','',3,'function'),(413,'first_time','首次登录时间','int(10) NOT NULL','datetime','','',0,'',45,0,1,1511838868,1511834310,'',3,'','regex','',3,'function'),(414,'last_time','上次更新时间','int(10) NOT NULL','datetime','','',0,'',45,0,1,1511838874,1511835474,'',3,'','regex','',3,'function'),(415,'in_province','是否本省','tinyint(2) NOT NULL','bool','1','',1,'0:是\r\n1:否',45,0,1,1511835571,1511835571,'',3,'','regex','',3,'function'),(416,'position','要求位置','varchar(255) NOT NULL','string','','',1,'',45,0,1,1511839661,1511835584,'',3,'','regex','',3,'function'),(417,'area','面积','varchar(255) NOT NULL','string','','',1,'',45,0,1,1511835604,1511835604,'',3,'','regex','',3,'function'),(418,'room','房号','varchar(255) NOT NULL','string','','',1,'',45,0,1,1512533498,1511835621,'',3,'','regex','',3,'function'),(419,'like_price','心理价位','varchar(255) NOT NULL','string','','',1,'',45,0,1,1511835646,1511835646,'',3,'','regex','',3,'function'),(420,'job','职位','varchar(255) NOT NULL','string','','',1,'',45,0,1,1511835661,1511835661,'',3,'','regex','',3,'function'),(421,'require','要求','varchar(255) NOT NULL','string','','',1,'',45,0,1,1511836236,1511836236,'',3,'','regex','',3,'function'),(422,'car','车辆信息','varchar(255) NOT NULL','string','','',1,'',45,0,1,1512610769,1511836262,'',3,'','regex','',3,'function'),(423,'people_num','同行人数','int(10) UNSIGNED NOT NULL','num','','',1,'',45,0,1,1511836283,1511836283,'',3,'','regex','',3,'function'),(424,'meet_address','接车地点','varchar(255) NOT NULL','string','','',1,'',45,0,1,1511836348,1511836348,'',3,'','regex','',3,'function'),(425,'order_time','预约时间','int(10) NOT NULL','datetime','','',1,'',45,0,1,1511836395,1511836395,'',3,'','regex','',3,'function'),(426,'is_over','完成','tinyint(2) NOT NULL','bool','','',0,'0:否\r\n1:是',45,0,1,1511838924,1511836436,'',3,'','regex','',3,'function'),(427,'bb_id','订单ID','int(10) UNSIGNED NOT NULL','num','','',1,'',46,0,1,1511837057,1511837057,'',3,'','regex','',3,'function'),(428,'time','时间','int(10) NOT NULL','datetime','','',1,'',46,0,1,1511837067,1511837067,'',3,'','regex','',3,'function'),(429,'type','类型','varchar(255) NOT NULL','string','','',1,'',46,0,1,1511837077,1511837077,'',3,'','regex','',3,'function'),(430,'remark','类型','varchar(255) NOT NULL','string','','',1,'',46,0,1,1511837096,1511837096,'',3,'','regex','',3,'function'),(431,'uid','添加人ID','int(10) UNSIGNED NOT NULL','num','','',0,'',45,0,1,1511838916,1511838473,'',3,'','regex','',3,'function'),(432,'status','状态','tinyint(2) NOT NULL','bool','1','',0,'-1:删除\r\n1:正常',45,0,1,1512533429,1511839397,'',3,'','regex','',3,'function'),(433,'dis_uid','调度人ID','int(10) UNSIGNED NOT NULL','num','','',0,'',45,0,1,1511840204,1511840197,'',3,'','regex','',3,'function'),(434,'dispatch_time','调度时间','int(10) NOT NULL','datetime','','',0,'',45,0,1,1511840239,1511840230,'',3,'','regex','',3,'function'),(435,'rec_uid','接待人ID','int(10) UNSIGNED NOT NULL','num','','',0,'',45,0,1,1512533390,1511840262,'',3,'','regex','',3,'function'),(436,'uid','操作人ID','int(10) UNSIGNED NOT NULL','num','','',1,'',46,0,1,1511920709,1511920709,'',3,'','regex','',3,'function'),(437,'uid','操作人ID','int(10) UNSIGNED NOT NULL','num','','',1,'',43,0,1,1511921101,1511921101,'',3,'','regex','',3,'function'),(438,'bborder_time_over','报备客户保护时间（天数）','int(10) NOT NULL','num','','',1,'',37,0,1,1512533176,1512532628,'',3,'','regex','',3,'function'),(439,'total_price','总价','varchar(255) NOT NULL','string','','',1,'',16,0,1,1513818946,1513818946,'',3,'','regex','',3,'function');
/*!40000 ALTER TABLE `zf_attribute` ENABLE KEYS */;

#
# Structure for table "zf_auth_extend"
#

DROP TABLE IF EXISTS `zf_auth_extend`;
CREATE TABLE `zf_auth_extend` (
  `group_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` mediumint(8) unsigned NOT NULL COMMENT '扩展表中数据的id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`group_id`,`extend_id`,`type`),
  KEY `uid` (`group_id`),
  KEY `group_id` (`extend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

#
# Data for table "zf_auth_extend"
#

/*!40000 ALTER TABLE `zf_auth_extend` DISABLE KEYS */;
INSERT INTO `zf_auth_extend` VALUES (1,1,1),(1,1,2),(1,2,1),(1,2,2),(1,3,1),(1,3,2),(1,4,1),(1,37,1),(3,1,1),(3,2,1);
/*!40000 ALTER TABLE `zf_auth_extend` ENABLE KEYS */;

#
# Structure for table "zf_auth_group"
#

DROP TABLE IF EXISTS `zf_auth_group`;
CREATE TABLE `zf_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "zf_auth_group"
#

/*!40000 ALTER TABLE `zf_auth_group` DISABLE KEYS */;
INSERT INTO `zf_auth_group` VALUES (1,'admin',1,'默认用户组','',1,'1,2,3,4,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,81,82,83,84,86,87,88,89,90,91,92,93,94,95,100,102,103,107,108,109,110,195,209,210,217,218,219,220,221,222,223'),(2,'admin',1,'测试用户','测试用户',1,'1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,82,83,84,88,89,90,91,92,93,94,95,100,102,103,107,108,109,110,195,209,210,217,218,219,220,221,222,223'),(3,'admin',1,'研发组','',1,'1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,81,82,83,84,86,87,88,89,90,91,92,93,94,95,100,102,103,107,108,109,110,195,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223');
/*!40000 ALTER TABLE `zf_auth_group` ENABLE KEYS */;

#
# Structure for table "zf_auth_group_access"
#

DROP TABLE IF EXISTS `zf_auth_group_access`;
CREATE TABLE `zf_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "zf_auth_group_access"
#

/*!40000 ALTER TABLE `zf_auth_group_access` DISABLE KEYS */;
INSERT INTO `zf_auth_group_access` VALUES (2,1),(3,3);
/*!40000 ALTER TABLE `zf_auth_group_access` ENABLE KEYS */;

#
# Structure for table "zf_auth_rule"
#

DROP TABLE IF EXISTS `zf_auth_rule`;
CREATE TABLE `zf_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;

#
# Data for table "zf_auth_rule"
#

/*!40000 ALTER TABLE `zf_auth_rule` DISABLE KEYS */;
INSERT INTO `zf_auth_rule` VALUES (1,'admin',2,'Admin/Index/index','首页',1,''),(2,'admin',2,'Admin/Article/mydocument','内容',1,''),(3,'admin',2,'Admin/User/index','用户',1,''),(4,'admin',2,'Admin/Addons/index','扩展',1,''),(5,'admin',2,'Admin/Config/group','系统',1,''),(7,'admin',1,'Admin/article/add','新增',1,''),(8,'admin',1,'Admin/article/edit','编辑',1,''),(9,'admin',1,'Admin/article/setStatus','改变状态',1,''),(10,'admin',1,'Admin/article/update','保存',1,''),(11,'admin',1,'Admin/article/autoSave','保存草稿',1,''),(12,'admin',1,'Admin/article/move','移动',1,''),(13,'admin',1,'Admin/article/copy','复制',1,''),(14,'admin',1,'Admin/article/paste','粘贴',1,''),(15,'admin',1,'Admin/article/permit','还原',1,''),(16,'admin',1,'Admin/article/clear','清空',1,''),(17,'admin',1,'Admin/article/index','文档列表',1,''),(18,'admin',1,'Admin/article/recycle','回收站',1,''),(19,'admin',1,'Admin/User/addaction','新增用户行为',1,''),(20,'admin',1,'Admin/User/editaction','编辑用户行为',1,''),(21,'admin',1,'Admin/User/saveAction','保存用户行为',1,''),(22,'admin',1,'Admin/User/setStatus','变更行为状态',1,''),(23,'admin',1,'Admin/User/changeStatus?method=forbidUser','禁用会员',1,''),(24,'admin',1,'Admin/User/changeStatus?method=resumeUser','启用会员',1,''),(25,'admin',1,'Admin/User/changeStatus?method=deleteUser','删除会员',1,''),(26,'admin',1,'Admin/User/index','用户信息',1,''),(27,'admin',1,'Admin/User/action','用户行为',1,''),(28,'admin',1,'Admin/AuthManager/changeStatus?method=deleteGroup','删除',1,''),(29,'admin',1,'Admin/AuthManager/changeStatus?method=forbidGroup','禁用',1,''),(30,'admin',1,'Admin/AuthManager/changeStatus?method=resumeGroup','恢复',1,''),(31,'admin',1,'Admin/AuthManager/createGroup','新增',1,''),(32,'admin',1,'Admin/AuthManager/editGroup','编辑',1,''),(33,'admin',1,'Admin/AuthManager/writeGroup','保存用户组',1,''),(34,'admin',1,'Admin/AuthManager/group','授权',1,''),(35,'admin',1,'Admin/AuthManager/access','访问授权',1,''),(36,'admin',1,'Admin/AuthManager/user','成员授权',1,''),(37,'admin',1,'Admin/AuthManager/removeFromGroup','解除授权',1,''),(38,'admin',1,'Admin/AuthManager/addToGroup','保存成员授权',1,''),(39,'admin',1,'Admin/AuthManager/category','分类授权',1,''),(40,'admin',1,'Admin/AuthManager/addToCategory','保存分类授权',1,''),(41,'admin',1,'Admin/AuthManager/index','权限管理',1,''),(42,'admin',1,'Admin/Addons/create','创建',1,''),(43,'admin',1,'Admin/Addons/checkForm','检测创建',1,''),(44,'admin',1,'Admin/Addons/preview','预览',1,''),(45,'admin',1,'Admin/Addons/build','快速生成插件',1,''),(46,'admin',1,'Admin/Addons/config','设置',1,''),(47,'admin',1,'Admin/Addons/disable','禁用',1,''),(48,'admin',1,'Admin/Addons/enable','启用',1,''),(49,'admin',1,'Admin/Addons/install','安装',1,''),(50,'admin',1,'Admin/Addons/uninstall','卸载',1,''),(51,'admin',1,'Admin/Addons/saveconfig','更新配置',1,''),(52,'admin',1,'Admin/Addons/adminList','插件后台列表',1,''),(53,'admin',1,'Admin/Addons/execute','URL方式访问插件',1,''),(54,'admin',1,'Admin/Addons/index','插件管理',1,''),(55,'admin',1,'Admin/Addons/hooks','钩子管理',1,''),(56,'admin',1,'Admin/model/add','新增',1,''),(57,'admin',1,'Admin/model/edit','编辑',1,''),(58,'admin',1,'Admin/model/setStatus','改变状态',1,''),(59,'admin',1,'Admin/model/update','保存数据',1,''),(60,'admin',1,'Admin/Model/index','模型管理',1,''),(61,'admin',1,'Admin/Config/edit','编辑',1,''),(62,'admin',1,'Admin/Config/del','删除',1,''),(63,'admin',1,'Admin/Config/add','新增',1,''),(64,'admin',1,'Admin/Config/save','保存',1,''),(65,'admin',1,'Admin/Config/group','网站设置',1,''),(66,'admin',1,'Admin/Config/index','配置管理',1,''),(67,'admin',1,'Admin/Channel/add','新增',1,''),(68,'admin',1,'Admin/Channel/edit','编辑',1,''),(69,'admin',1,'Admin/Channel/del','删除',1,''),(70,'admin',1,'Admin/Channel/index','导航管理',1,''),(71,'admin',1,'Admin/Category/edit','编辑',1,''),(72,'admin',1,'Admin/Category/add','新增',1,''),(73,'admin',1,'Admin/Category/remove','删除',1,''),(74,'admin',1,'Admin/Category/index','分类管理',1,''),(75,'admin',1,'Admin/file/upload','上传控件',-1,''),(76,'admin',1,'Admin/file/uploadPicture','上传图片',-1,''),(77,'admin',1,'Admin/file/download','下载',-1,''),(79,'admin',1,'Admin/article/batchOperate','导入',1,''),(80,'admin',1,'Admin/Database/index?type=export','备份数据库',1,''),(81,'admin',1,'Admin/Database/index?type=import','还原数据库',1,''),(82,'admin',1,'Admin/Database/export','备份',1,''),(83,'admin',1,'Admin/Database/optimize','优化表',1,''),(84,'admin',1,'Admin/Database/repair','修复表',1,''),(86,'admin',1,'Admin/Database/import','恢复',1,''),(87,'admin',1,'Admin/Database/del','删除',1,''),(88,'admin',1,'Admin/User/add','新增用户',1,''),(89,'admin',1,'Admin/Attribute/index','属性管理',1,''),(90,'admin',1,'Admin/Attribute/add','新增',1,''),(91,'admin',1,'Admin/Attribute/edit','编辑',1,''),(92,'admin',1,'Admin/Attribute/setStatus','改变状态',1,''),(93,'admin',1,'Admin/Attribute/update','保存数据',1,''),(94,'admin',1,'Admin/AuthManager/modelauth','模型授权',1,''),(95,'admin',1,'Admin/AuthManager/addToModel','保存模型授权',1,''),(96,'admin',1,'Admin/Category/move','移动',-1,''),(97,'admin',1,'Admin/Category/merge','合并',-1,''),(98,'admin',1,'Admin/Config/menu','后台菜单管理',-1,''),(99,'admin',1,'Admin/Article/mydocument','内容',-1,''),(100,'admin',1,'Admin/Menu/index','菜单管理',1,''),(101,'admin',1,'Admin/other','其他',-1,''),(102,'admin',1,'Admin/Menu/add','新增',1,''),(103,'admin',1,'Admin/Menu/edit','编辑',1,''),(104,'admin',1,'Admin/Think/lists?model=article','文章管理',-1,''),(105,'admin',1,'Admin/Think/lists?model=download','下载管理',1,''),(106,'admin',1,'Admin/Think/lists?model=config','配置管理',1,''),(107,'admin',1,'Admin/Action/actionlog','行为日志',1,''),(108,'admin',1,'Admin/User/updatePassword','修改密码',1,''),(109,'admin',1,'Admin/User/updateNickname','修改昵称',1,''),(110,'admin',1,'Admin/action/edit','查看行为日志',1,''),(111,'admin',2,'Admin/article/index','文档列表',-1,''),(112,'admin',2,'Admin/article/add','新增',-1,''),(113,'admin',2,'Admin/article/edit','编辑',-1,''),(114,'admin',2,'Admin/article/setStatus','改变状态',-1,''),(115,'admin',2,'Admin/article/update','保存',-1,''),(116,'admin',2,'Admin/article/autoSave','保存草稿',-1,''),(117,'admin',2,'Admin/article/move','移动',-1,''),(118,'admin',2,'Admin/article/copy','复制',-1,''),(119,'admin',2,'Admin/article/paste','粘贴',-1,''),(120,'admin',2,'Admin/article/batchOperate','导入',-1,''),(121,'admin',2,'Admin/article/recycle','回收站',-1,''),(122,'admin',2,'Admin/article/permit','还原',-1,''),(123,'admin',2,'Admin/article/clear','清空',-1,''),(124,'admin',2,'Admin/User/add','新增用户',-1,''),(125,'admin',2,'Admin/User/action','用户行为',-1,''),(126,'admin',2,'Admin/User/addAction','新增用户行为',-1,''),(127,'admin',2,'Admin/User/editAction','编辑用户行为',-1,''),(128,'admin',2,'Admin/User/saveAction','保存用户行为',-1,''),(129,'admin',2,'Admin/User/setStatus','变更行为状态',-1,''),(130,'admin',2,'Admin/User/changeStatus?method=forbidUser','禁用会员',-1,''),(131,'admin',2,'Admin/User/changeStatus?method=resumeUser','启用会员',-1,''),(132,'admin',2,'Admin/User/changeStatus?method=deleteUser','删除会员',-1,''),(133,'admin',2,'Admin/AuthManager/index','权限管理',-1,''),(134,'admin',2,'Admin/AuthManager/changeStatus?method=deleteGroup','删除',-1,''),(135,'admin',2,'Admin/AuthManager/changeStatus?method=forbidGroup','禁用',-1,''),(136,'admin',2,'Admin/AuthManager/changeStatus?method=resumeGroup','恢复',-1,''),(137,'admin',2,'Admin/AuthManager/createGroup','新增',-1,''),(138,'admin',2,'Admin/AuthManager/editGroup','编辑',-1,''),(139,'admin',2,'Admin/AuthManager/writeGroup','保存用户组',-1,''),(140,'admin',2,'Admin/AuthManager/group','授权',-1,''),(141,'admin',2,'Admin/AuthManager/access','访问授权',-1,''),(142,'admin',2,'Admin/AuthManager/user','成员授权',-1,''),(143,'admin',2,'Admin/AuthManager/removeFromGroup','解除授权',-1,''),(144,'admin',2,'Admin/AuthManager/addToGroup','保存成员授权',-1,''),(145,'admin',2,'Admin/AuthManager/category','分类授权',-1,''),(146,'admin',2,'Admin/AuthManager/addToCategory','保存分类授权',-1,''),(147,'admin',2,'Admin/AuthManager/modelauth','模型授权',-1,''),(148,'admin',2,'Admin/AuthManager/addToModel','保存模型授权',-1,''),(149,'admin',2,'Admin/Addons/create','创建',-1,''),(150,'admin',2,'Admin/Addons/checkForm','检测创建',-1,''),(151,'admin',2,'Admin/Addons/preview','预览',-1,''),(152,'admin',2,'Admin/Addons/build','快速生成插件',-1,''),(153,'admin',2,'Admin/Addons/config','设置',-1,''),(154,'admin',2,'Admin/Addons/disable','禁用',-1,''),(155,'admin',2,'Admin/Addons/enable','启用',-1,''),(156,'admin',2,'Admin/Addons/install','安装',-1,''),(157,'admin',2,'Admin/Addons/uninstall','卸载',-1,''),(158,'admin',2,'Admin/Addons/saveconfig','更新配置',-1,''),(159,'admin',2,'Admin/Addons/adminList','插件后台列表',-1,''),(160,'admin',2,'Admin/Addons/execute','URL方式访问插件',-1,''),(161,'admin',2,'Admin/Addons/hooks','钩子管理',-1,''),(162,'admin',2,'Admin/Model/index','模型管理',-1,''),(163,'admin',2,'Admin/model/add','新增',-1,''),(164,'admin',2,'Admin/model/edit','编辑',-1,''),(165,'admin',2,'Admin/model/setStatus','改变状态',-1,''),(166,'admin',2,'Admin/model/update','保存数据',-1,''),(167,'admin',2,'Admin/Attribute/index','属性管理',-1,''),(168,'admin',2,'Admin/Attribute/add','新增',-1,''),(169,'admin',2,'Admin/Attribute/edit','编辑',-1,''),(170,'admin',2,'Admin/Attribute/setStatus','改变状态',-1,''),(171,'admin',2,'Admin/Attribute/update','保存数据',-1,''),(172,'admin',2,'Admin/Config/index','配置管理',-1,''),(173,'admin',2,'Admin/Config/edit','编辑',-1,''),(174,'admin',2,'Admin/Config/del','删除',-1,''),(175,'admin',2,'Admin/Config/add','新增',-1,''),(176,'admin',2,'Admin/Config/save','保存',-1,''),(177,'admin',2,'Admin/Menu/index','菜单管理',-1,''),(178,'admin',2,'Admin/Channel/index','导航管理',-1,''),(179,'admin',2,'Admin/Channel/add','新增',-1,''),(180,'admin',2,'Admin/Channel/edit','编辑',-1,''),(181,'admin',2,'Admin/Channel/del','删除',-1,''),(182,'admin',2,'Admin/Category/index','分类管理',-1,''),(183,'admin',2,'Admin/Category/edit','编辑',-1,''),(184,'admin',2,'Admin/Category/add','新增',-1,''),(185,'admin',2,'Admin/Category/remove','删除',-1,''),(186,'admin',2,'Admin/Category/move','移动',-1,''),(187,'admin',2,'Admin/Category/merge','合并',-1,''),(188,'admin',2,'Admin/Database/index?type=export','备份数据库',-1,''),(189,'admin',2,'Admin/Database/export','备份',-1,''),(190,'admin',2,'Admin/Database/optimize','优化表',-1,''),(191,'admin',2,'Admin/Database/repair','修复表',-1,''),(192,'admin',2,'Admin/Database/index?type=import','还原数据库',-1,''),(193,'admin',2,'Admin/Database/import','恢复',-1,''),(194,'admin',2,'Admin/Database/del','删除',-1,''),(195,'admin',2,'Admin/other','其他',1,''),(196,'admin',2,'Admin/Menu/add','新增',-1,''),(197,'admin',2,'Admin/Menu/edit','编辑',-1,''),(198,'admin',2,'Admin/Think/lists?model=article','应用',-1,''),(199,'admin',2,'Admin/Think/lists?model=download','下载管理',-1,''),(200,'admin',2,'Admin/Think/lists?model=config','应用',-1,''),(201,'admin',2,'Admin/Action/actionlog','行为日志',-1,''),(202,'admin',2,'Admin/User/updatePassword','修改密码',-1,''),(203,'admin',2,'Admin/User/updateNickname','修改昵称',-1,''),(204,'admin',2,'Admin/action/edit','查看行为日志',-1,''),(205,'admin',1,'Admin/think/add','新增数据',1,''),(206,'admin',1,'Admin/think/edit','编辑数据',1,''),(207,'admin',1,'Admin/Menu/import','导入',1,''),(208,'admin',1,'Admin/Model/generate','生成',1,''),(209,'admin',1,'Admin/Addons/addHook','新增钩子',1,''),(210,'admin',1,'Admin/Addons/edithook','编辑钩子',1,''),(211,'admin',1,'Admin/Article/sort','文档排序',1,''),(212,'admin',1,'Admin/Config/sort','排序',1,''),(213,'admin',1,'Admin/Menu/sort','排序',1,''),(214,'admin',1,'Admin/Channel/sort','排序',1,''),(215,'admin',1,'Admin/Category/operate/type/move','移动',1,''),(216,'admin',1,'Admin/Category/operate/type/merge','合并',1,''),(217,'admin',1,'Admin/MenuList/index','列表',1,''),(218,'admin',1,'Admin/MenuList/add','添加',1,''),(219,'admin',1,'Admin/MenuList/edit','编辑',1,''),(220,'admin',1,'Admin/BottomNav/index','列表',1,''),(221,'admin',1,'Admin/MenuList/recycle','回收站',1,''),(222,'admin',2,'Admin/MenuList/index','菜单',1,''),(223,'admin',1,'Admin/MenuList/menu_auth','权限',1,'');
/*!40000 ALTER TABLE `zf_auth_rule` ENABLE KEYS */;

#
# Structure for table "zf_bborder"
#

DROP TABLE IF EXISTS `zf_bborder`;
CREATE TABLE `zf_bborder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '客户姓名',
  `phone` varchar(255) NOT NULL COMMENT '联系方式',
  `first_time` int(10) NOT NULL COMMENT '首次登录时间',
  `last_time` int(10) NOT NULL COMMENT '上次更新时间',
  `in_province` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否本省',
  `position` varchar(255) NOT NULL COMMENT '要求位置',
  `area` varchar(255) NOT NULL COMMENT '面积',
  `room` varchar(255) NOT NULL COMMENT '房号',
  `like_price` varchar(255) NOT NULL COMMENT '心理价位',
  `job` varchar(255) NOT NULL COMMENT '职位',
  `require` varchar(255) NOT NULL COMMENT '要求',
  `car` varchar(255) NOT NULL COMMENT '车辆信息',
  `people_num` int(10) unsigned NOT NULL COMMENT '同行人数',
  `meet_address` varchar(255) NOT NULL COMMENT '接车地点',
  `order_time` int(10) NOT NULL COMMENT '预约时间',
  `is_over` tinyint(2) NOT NULL COMMENT '完成',
  `uid` int(10) unsigned NOT NULL COMMENT '添加人ID',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `dis_uid` int(10) unsigned NOT NULL COMMENT '调度人ID',
  `dispatch_time` int(10) NOT NULL COMMENT '调度时间',
  `rec_uid` int(10) unsigned NOT NULL COMMENT '接待人ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_bborder"
#


#
# Structure for table "zf_bborder_log"
#

DROP TABLE IF EXISTS `zf_bborder_log`;
CREATE TABLE `zf_bborder_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `bb_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `time` int(10) NOT NULL COMMENT '时间',
  `type` varchar(255) NOT NULL COMMENT '类型',
  `remark` varchar(255) NOT NULL COMMENT '类型',
  `uid` int(10) unsigned NOT NULL COMMENT '操作人ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_bborder_log"
#


#
# Structure for table "zf_bottom_nav"
#

DROP TABLE IF EXISTS `zf_bottom_nav`;
CREATE TABLE `zf_bottom_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `m_id` int(10) unsigned NOT NULL COMMENT '菜单ID',
  `title` varchar(255) NOT NULL COMMENT '底部标题',
  `icon` int(10) unsigned NOT NULL COMMENT '图标',
  `status` char(50) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `m_id` (`m_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_bottom_nav"
#

/*!40000 ALTER TABLE `zf_bottom_nav` DISABLE KEYS */;
INSERT INTO `zf_bottom_nav` VALUES (1,3,'房源',14,'1'),(2,2,'分组',15,'1'),(3,8,'公告',16,'1'),(4,10,'业务',17,'1'),(5,11,'统计',0,'1'),(6,12,'个人',0,'0');
/*!40000 ALTER TABLE `zf_bottom_nav` ENABLE KEYS */;

#
# Structure for table "zf_building"
#

DROP TABLE IF EXISTS `zf_building`;
CREATE TABLE `zf_building` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `b_name` varchar(255) NOT NULL COMMENT '栋序号（名）',
  `unit_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '单元数',
  `is_w` varchar(255) NOT NULL COMMENT '是否填写单元表',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `type` tinyint(2) NOT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_building"
#


#
# Structure for table "zf_bulletin"
#

DROP TABLE IF EXISTS `zf_bulletin`;
CREATE TABLE `zf_bulletin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `type` char(50) NOT NULL DEFAULT '1' COMMENT '类型',
  `created_time` int(10) NOT NULL COMMENT '发布时间',
  `pictures` varchar(255) DEFAULT NULL COMMENT '图片',
  `file` varchar(255) NOT NULL COMMENT '文件',
  `view` int(10) unsigned NOT NULL COMMENT '观看人数',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_bulletin"
#


#
# Structure for table "zf_bulletin_user"
#

DROP TABLE IF EXISTS `zf_bulletin_user`;
CREATE TABLE `zf_bulletin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `b_id` int(10) unsigned NOT NULL COMMENT '公告ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `read_time` int(10) NOT NULL COMMENT '阅读时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_bulletin_user"
#


#
# Structure for table "zf_category"
#

DROP TABLE IF EXISTS `zf_category`;
CREATE TABLE `zf_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL COMMENT '编辑页模板',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '关联模型',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许发布内容',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `reply` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许回复',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发布的文章是否需要审核',
  `reply_model` varchar(100) NOT NULL DEFAULT '',
  `extend` text NOT NULL COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类图标',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='分类表';

#
# Data for table "zf_category"
#

/*!40000 ALTER TABLE `zf_category` DISABLE KEYS */;
INSERT INTO `zf_category` VALUES (1,'blog','博客',0,0,10,'','','','','','','','2','2,1',0,0,1,0,0,'1','',1379474947,1382701539,1,0),(2,'default_blog','默认分类',1,1,10,'','','','','','','','2','2,1,3',0,1,1,0,1,'1','',1379475028,1386839751,1,31);
/*!40000 ALTER TABLE `zf_category` ENABLE KEYS */;

#
# Structure for table "zf_channel"
#

DROP TABLE IF EXISTS `zf_channel`;
CREATE TABLE `zf_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级频道ID',
  `title` char(30) NOT NULL COMMENT '频道标题',
  `url` char(100) NOT NULL COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "zf_channel"
#

/*!40000 ALTER TABLE `zf_channel` DISABLE KEYS */;
INSERT INTO `zf_channel` VALUES (1,0,'首页','Index/index',1,1379475111,1379923177,1,0),(2,0,'博客','Article/index?category=blog',2,1379475131,1379483713,1,0),(3,0,'官网','http://www.onethink.cn',3,1379475154,1387163458,1,0);
/*!40000 ALTER TABLE `zf_channel` ENABLE KEYS */;

#
# Structure for table "zf_chat"
#

DROP TABLE IF EXISTS `zf_chat`;
CREATE TABLE `zf_chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `content` text NOT NULL COMMENT '发布内容',
  `send_time` bigint(14) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_chat"
#


#
# Structure for table "zf_config"
#

DROP TABLE IF EXISTS `zf_config`;
CREATE TABLE `zf_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

#
# Data for table "zf_config"
#

/*!40000 ALTER TABLE `zf_config` DISABLE KEYS */;
INSERT INTO `zf_config` VALUES (1,'WEB_SITE_TITLE',1,'网站标题',1,'','网站标题前台显示标题',1378898976,1379235274,1,'中房通',0),(2,'WEB_SITE_DESCRIPTION',2,'网站描述',1,'','网站搜索引擎描述',1378898976,1379235841,1,'中房通\r\n',1),(3,'WEB_SITE_KEYWORD',2,'网站关键字',1,'','网站搜索引擎关键字',1378898976,1381390100,1,'中房通，海南，楼盘，卖房',8),(4,'WEB_SITE_CLOSE',4,'关闭站点',1,'0:关闭,1:开启','站点关闭后其他用户不能访问，管理员可以正常访问',1378898976,1379235296,1,'1',1),(9,'CONFIG_TYPE_LIST',3,'配置类型列表',4,'','主要用于数据解析和页面表单的生成',1378898976,1379235348,1,'0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举',2),(10,'WEB_SITE_ICP',1,'网站备案号',1,'','设置在网站底部显示的备案号，如“沪ICP备12007941号-2',1378900335,1379235859,1,'',9),(11,'DOCUMENT_POSITION',3,'文档推荐位',2,'','文档推荐位，推荐到多个位置KEY值相加即可',1379053380,1379235329,1,'1:列表页推荐\r\n2:频道页推荐\r\n4:网站首页推荐',3),(12,'DOCUMENT_DISPLAY',3,'文档可见性',2,'','文章可见性仅影响前台显示，后台不收影响',1379056370,1379235322,1,'0:所有人可见\r\n1:仅注册会员可见\r\n2:仅管理员可见',4),(13,'COLOR_STYLE',4,'后台色系',1,'default_color:默认\r\nblue_color:紫罗兰','后台颜色风格',1379122533,1379235904,1,'default_color',10),(20,'CONFIG_GROUP_LIST',3,'配置分组',4,'','配置分组',1379228036,1384418383,1,'1:基本\r\n2:内容\r\n3:用户\r\n4:系统',4),(21,'HOOKS_TYPE',3,'钩子的类型',4,'','类型 1-用于扩展显示内容，2-用于扩展业务处理',1379313397,1379313407,1,'1:视图\r\n2:控制器',6),(22,'AUTH_CONFIG',3,'Auth配置',4,'','自定义Auth.class.php类配置',1379409310,1379409564,1,'AUTH_ON:1\r\nAUTH_TYPE:2',8),(23,'OPEN_DRAFTBOX',4,'是否开启草稿功能',2,'0:关闭草稿功能\r\n1:开启草稿功能\r\n','新增文章时的草稿功能配置',1379484332,1379484591,1,'1',1),(24,'DRAFT_AOTOSAVE_INTERVAL',0,'自动保存草稿时间',2,'','自动保存草稿的时间间隔，单位：秒',1379484574,1386143323,1,'60',2),(25,'LIST_ROWS',0,'后台每页记录数',2,'','后台数据每页显示记录数',1379503896,1500531113,1,'15',10),(26,'USER_ALLOW_REGISTER',4,'是否允许用户注册',3,'0:关闭注册\r\n1:允许注册','是否开放用户注册',1379504487,1379504580,1,'1',3),(27,'CODEMIRROR_THEME',4,'预览插件的CodeMirror主题',4,'3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight','详情见CodeMirror官网',1379814385,1384740813,1,'ambiance',3),(28,'DATA_BACKUP_PATH',1,'数据库备份根路径',4,'','路径必须以 / 结尾',1381482411,1381482411,1,'./Data/',5),(29,'DATA_BACKUP_PART_SIZE',0,'数据库备份卷大小',4,'','该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M',1381482488,1381729564,1,'20971520',7),(30,'DATA_BACKUP_COMPRESS',4,'数据库备份文件是否启用压缩',4,'0:不压缩\r\n1:启用压缩','压缩备份文件需要PHP环境支持gzopen,gzwrite函数',1381713345,1381729544,1,'1',9),(31,'DATA_BACKUP_COMPRESS_LEVEL',4,'数据库备份文件压缩级别',4,'1:普通\r\n4:一般\r\n9:最高','数据库备份文件的压缩级别，该配置在开启压缩时生效',1381713408,1381713408,1,'9',10),(32,'DEVELOP_MODE',4,'开启开发者模式',4,'0:关闭\r\n1:开启','是否开启开发者模式',1383105995,1383291877,1,'1',11),(33,'ALLOW_VISIT',3,'不受限控制器方法',0,'','',1386644047,1386644741,1,'0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture',0),(34,'DENY_VISIT',3,'超管专限控制器方法',0,'','仅超级管理员可访问的控制器方法',1386644141,1386644659,1,'0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree',0),(35,'REPLY_LIST_ROWS',0,'回复列表每页条数',2,'','',1386645376,1387178083,1,'10',0),(36,'ADMIN_ALLOW_IP',2,'后台允许访问IP',4,'','多个用逗号分隔，如果不配置表示不限制IP访问',1387165454,1387165553,1,'',12),(37,'SHOW_PAGE_TRACE',4,'是否显示页面Trace',4,'0:关闭\r\n1:开启','是否显示页面Trace信息',1387165685,1387165685,1,'0',1),(38,'SUPER_MENU',3,'超级会员菜单',0,'','',1501570332,1511773591,1,'3\r\n2\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9\r\n10\r\n11\r\n12\r\n14\r\n15\r\n16\r\n17\r\n18\r\n19\r\n20\r\n21',0),(39,'SUPER_BOTTOM',3,'超级会员底部',0,'','',1501571102,1501746030,1,'0:1\r\n1:2',0),(40,'ROOM_STATUS',3,'房间状态',0,'','',1503297525,1503297525,1,'0:待售\r\n1:锁定\r\n2:销控\r\n9:已售',0),(41,'ROOM_OP_TYPE',3,'房间操作类型',0,'','',1503558543,1503559498,1,'1:锁定\r\n2:解锁\r\n3:锁定审核\r\n4:成交\r\n5:取消成交\r\n6:成交审核\r\n7:销控\r\n8:取消销控',0),(42,'HOUSE_HOUSEFEATURE',3,'项目特色',5,'','项目特色设置，推荐到多个位置KEY值相加即可，格式（ID:文字）后一个ID为前一个ID*2',1435716257,1464169723,1,'1:小户型\r\n2:低密居所\r\n4:复合地产\r\n8:豪华居住区\r\n16:高档小区\r\n32:投资地产\r\n64:海景地产\r\n128:河景地产\r\n256:温泉地产\r\n512:山景地产\r\n1024:旅游地产\r\n2048:宜居生态\r\n4096:教育地产\r\n8192:花园洋房\r\n16384:品牌地产\r\n32768:LOFT',0),(43,'HOUSE_HOUSETYPE',3,'物业类型',5,'','物业类型设置，格式（ID:文字）后一个ID为前一个ID*2',1435716583,1435716597,1,'1:住宅\r\n2:别墅\r\n4:写字楼\r\n8:商铺\r\n16:商业街\r\n32:城市综合体\r\n64:酒店式公寓\r\n128:商住楼\r\n256:5A甲级纯写字楼\r\n512:酒店\r\n1024:公寓\r\n2048:产权式酒店\r\n4096:商住公寓\r\n8192:办公别墅\r\n16384:企业独栋\r\n32768:总部园区',1),(44,'HOUSE_HCATEGORY',3,'建筑类别',5,'','建筑类别设置，，格式（ID:文字）后一个ID为前一个ID*2',1435716703,1435716734,1,'1:板楼\r\n2:高层\r\n4:小高层\r\n8:塔楼\r\n16:板塔结合\r\n32:多层\r\n64:低层\r\n128:独栋别墅\r\n256:双拼\r\n512:联排\r\n1024:叠拼',2),(45,'HOUSE_RENOVATION',3,'装修状况',5,'','装修状况设置，格式（ID:文字）后一个ID为前一个ID*2',1435716906,1470708012,1,'1:毛坯\r\n2:精装修\r\n4:豪华装修\r\n8:菜单式装修\r\n16:公共部分精装\r\n32:简装修\r\n64:中装\r\n128:装修\r\n256:待定',4),(46,'HOUSE_SALEYES',3,'销售状态',5,'','销售状态设置',1435721940,1435721940,1,'1:待售\r\n2:在售\r\n4:尾盘\r\n8:售罄\r\n16:老盘加推\r\n32:准现房',5),(47,'HOUSE_FEATURES',3,'房产功能',2,'','',1461826545,1461826589,1,'1:教育地产\r\n2:养老地产\r\n4:宜居生态地产\r\n8:商业投资地产\r\n16:旅游度假地产\r\n32:创意地产\r\n64:刚需地产',0);
/*!40000 ALTER TABLE `zf_config` ENABLE KEYS */;

#
# Structure for table "zf_cus_track"
#

DROP TABLE IF EXISTS `zf_cus_track`;
CREATE TABLE `zf_cus_track` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '客户姓名',
  `phone` varchar(255) NOT NULL COMMENT '联系方式',
  `first_time` int(10) DEFAULT NULL COMMENT '首次登录时间',
  `last_time` int(10) DEFAULT NULL COMMENT '上次更新时间',
  `in_province` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否本省',
  `position` varchar(255) NOT NULL COMMENT '要求位置',
  `area` varchar(255) NOT NULL COMMENT '面积',
  `installation` varchar(255) NOT NULL COMMENT '主要抗性',
  `like_price` varchar(255) NOT NULL COMMENT '心理价位',
  `job` varchar(255) NOT NULL COMMENT '职位',
  `come_num` int(10) unsigned NOT NULL COMMENT '置业次数',
  `require` varchar(255) NOT NULL COMMENT '要求',
  `use` varchar(255) NOT NULL COMMENT '用途',
  `is_deal` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否成交',
  `intention` int(10) NOT NULL COMMENT '意向判断',
  `over` tinyint(2) NOT NULL COMMENT '是否完成',
  `check_out` tinyint(2) NOT NULL COMMENT '是否退房',
  `sales_name` varchar(255) NOT NULL COMMENT '置业顾问',
  `remark` text NOT NULL COMMENT '备注',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `record` tinyint(2) NOT NULL COMMENT '网上备案',
  `get_house` tinyint(2) NOT NULL COMMENT '是否交房',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `cus_from` varchar(255) NOT NULL COMMENT '客户来源',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_cus_track"
#


#
# Structure for table "zf_customer"
#

DROP TABLE IF EXISTS `zf_customer`;
CREATE TABLE `zf_customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `sex` char(10) NOT NULL DEFAULT '0' COMMENT '性别',
  `phone` varchar(255) NOT NULL COMMENT '联系方式',
  `id_number` varchar(255) NOT NULL COMMENT '身份证号码',
  `age` int(10) unsigned NOT NULL COMMENT '年龄',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `in_province` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否是本省',
  `intention_money` int(10) unsigned NOT NULL COMMENT '意向登记金额',
  `return_money` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否退意向金',
  `intention_time` int(10) DEFAULT NULL COMMENT '意向登记时间',
  `intention_room_style` varchar(255) NOT NULL COMMENT '意向房型',
  `serial_number` varchar(255) NOT NULL COMMENT '登记系列号',
  `contract_no` varchar(255) NOT NULL COMMENT '合同编号',
  `contract_time` int(10) DEFAULT NULL COMMENT '合同签约时间',
  `contract_receipt_time` int(10) DEFAULT NULL COMMENT '合同约定收款时间',
  `subscription_time` int(10) DEFAULT NULL COMMENT '认购日期',
  `unit_price` int(10) unsigned NOT NULL COMMENT '单价',
  `contract_money` int(10) unsigned NOT NULL COMMENT '合同金额',
  `intention_money_return_time` int(10) DEFAULT NULL COMMENT '退意向金时间',
  `decoration_money` int(10) unsigned NOT NULL COMMENT '装修款',
  `offer_policy` varchar(255) NOT NULL COMMENT '优惠政策',
  `room_number` varchar(255) NOT NULL COMMENT '楼栋房号',
  `area` varchar(255) NOT NULL COMMENT '面积',
  `ot_payment` tinyint(2) NOT NULL DEFAULT '0' COMMENT '一次性付款',
  `bank_mortgage` tinyint(2) NOT NULL DEFAULT '0' COMMENT '银行按揭',
  `installment` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分期付款',
  `deposit` int(10) unsigned NOT NULL COMMENT '定金（含意向金）',
  `down_payment` int(10) unsigned NOT NULL COMMENT '首付（含定金）',
  `progress_payment_1` int(10) unsigned NOT NULL COMMENT '已收进度款一',
  `progress_payment_time_1` int(10) DEFAULT NULL COMMENT '进度款一时间',
  `progress_payment_2` int(10) unsigned NOT NULL COMMENT '已收进度款二',
  `progress_payment_time_2` int(10) DEFAULT NULL COMMENT '进度款二时间',
  `progress_payment_3` int(10) unsigned NOT NULL COMMENT '已收进度款三',
  `progress_payment_time_3` int(10) DEFAULT NULL COMMENT '进度款三时间',
  `loan_amout` int(10) unsigned NOT NULL COMMENT '银行贷款金额',
  `get_loan_amout` int(10) unsigned NOT NULL COMMENT '银行贷款到帐金额',
  `cus_info_reported_time` int(10) DEFAULT NULL COMMENT '客户信息备案领取时间',
  `check_out` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否退房',
  `check_out_money` int(10) unsigned NOT NULL COMMENT '退房款金额',
  `get_check_out_money` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已退退房款金额',
  `check_out_time` int(10) DEFAULT NULL COMMENT '退款时间',
  `sales_point` int(10) unsigned NOT NULL COMMENT '置业顾问提成点数',
  `sales_commission` int(10) unsigned NOT NULL COMMENT '置业顾问佣金金额',
  `sales_bonus` int(10) unsigned NOT NULL COMMENT '置业顾问奖金金额',
  `sales_receive_commission` int(10) unsigned NOT NULL COMMENT '置业顾问已领取的佣金',
  `sales_commission_time` int(10) DEFAULT NULL COMMENT '置业顾问领取佣金时间',
  `sales_receive_bonus` int(10) unsigned NOT NULL COMMENT '置业顾问已领取的奖金金额',
  `sales_bonus_time` int(10) DEFAULT NULL COMMENT '置业顾问已领取奖金时间',
  `sales_return_commission` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '置业顾问退回的佣金金额',
  `sales_return_com_time` int(10) DEFAULT NULL COMMENT '置业顾问退回佣金时间',
  `distribution` varchar(255) NOT NULL COMMENT '分销商',
  `distribution_point` int(10) unsigned NOT NULL COMMENT '分销点数',
  `is_dribution_invoice` tinyint(2) NOT NULL DEFAULT '0' COMMENT '分销发票是否收',
  `distribution_commission` int(10) unsigned NOT NULL COMMENT '分销商佣金金额',
  `distribution_bonus` int(10) unsigned NOT NULL COMMENT '分销奖金、成交奖金额',
  `dis_receive_commission` int(10) unsigned NOT NULL COMMENT '分销商已领取的佣金金额',
  `dis_commission_time` int(10) DEFAULT NULL COMMENT '分销商领取佣金时间',
  `dis_receive_bonus` int(10) unsigned NOT NULL COMMENT '分销商已领取的奖金金额',
  `dis_bonus_time` int(10) DEFAULT NULL COMMENT '分销商领取奖金时间',
  `dis_return_commission` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分销商退回的佣金金额',
  `dis_return_com_time` int(10) DEFAULT NULL COMMENT '分销商退回佣金的时间',
  `is_over` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否完成',
  `is_intention` tinyint(2) NOT NULL DEFAULT '0' COMMENT '意向登记',
  `base_commission` int(10) unsigned NOT NULL COMMENT '佣金基数',
  `sales` varchar(255) NOT NULL COMMENT '置业顾问',
  `loan_amout_time` int(10) NOT NULL COMMENT '银行贷款到账时间',
  `down_payment_time` int(10) NOT NULL COMMENT '首付时间',
  `deposit_time` int(10) NOT NULL COMMENT '订金时间',
  `manager` varchar(255) NOT NULL COMMENT '渠道经理',
  `manager_point` varchar(255) NOT NULL COMMENT '渠道经理提成点数',
  `manager_commission` int(10) unsigned NOT NULL COMMENT '渠道经理佣金金额',
  `manager_bonus` int(10) unsigned NOT NULL COMMENT '渠道经理奖金金额',
  `manager_receive_commission` int(10) unsigned NOT NULL COMMENT '渠道经理已领取的佣金金额',
  `manager_commission_time` int(10) NOT NULL COMMENT '渠道经理领取佣金时间',
  `manager_receive_bonus` int(10) unsigned NOT NULL COMMENT '渠道经理已领取的奖金金额',
  `manager_bonus_time` int(10) NOT NULL COMMENT '渠道经理领取奖金时间',
  `manager_return_commission` int(10) unsigned NOT NULL COMMENT '渠道经理退回的佣金金额',
  `manager_return_com_time` int(10) NOT NULL COMMENT '渠道经理退回佣金时间',
  `supervisor` varchar(255) NOT NULL COMMENT '案场主管',
  `supervisor_point` varchar(255) NOT NULL COMMENT '案场主管提成点数',
  `supervisor_commission` int(10) unsigned NOT NULL COMMENT '案场主管佣金金额',
  `supervisor_bonus` int(10) unsigned NOT NULL COMMENT '案场主管奖金金额',
  `supervisor_receive_commission` int(10) unsigned NOT NULL COMMENT '案场主管已领取的佣金金额',
  `supervisor_commission_time` int(10) NOT NULL COMMENT '案场主管领取佣金时间',
  `supervisor_receive_bonus` int(10) unsigned NOT NULL COMMENT '案场主管已领取奖金金额',
  `supervisor_bonus_time` int(10) NOT NULL COMMENT '案场主管领取奖金时间',
  `supervisor_return_commission` int(10) unsigned NOT NULL COMMENT '案场主管退回的佣金金额',
  `supervisor_return_com_time` int(10) NOT NULL COMMENT '案场主管退回佣金时间',
  `decoration_receive_money` int(10) unsigned NOT NULL COMMENT '已收装修款金额',
  `decoration_receive_money_time` int(10) NOT NULL COMMENT '	收到装修款时间',
  `deposit_return` int(10) unsigned NOT NULL COMMENT '已退定金金额',
  `deposit_return_time` int(10) NOT NULL COMMENT '退定金时间',
  `get_contract_money` tinyint(2) NOT NULL COMMENT '完成合同收款',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  `record` tinyint(2) NOT NULL COMMENT '是否网上备案',
  `record_time` int(10) NOT NULL COMMENT '备案时间',
  `get_house` tinyint(2) NOT NULL COMMENT '是否交房',
  `get_house_time` int(10) NOT NULL COMMENT '交房时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_customer"
#


#
# Structure for table "zf_file"
#

DROP TABLE IF EXISTS `zf_file`;
CREATE TABLE `zf_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件表';

#
# Data for table "zf_file"
#


#
# Structure for table "zf_group"
#

DROP TABLE IF EXISTS `zf_group`;
CREATE TABLE `zf_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `houses_id` varchar(200) NOT NULL COMMENT '楼盘ID',
  `name` varchar(255) NOT NULL COMMENT '会员组名字',
  `bg_color` varchar(255) NOT NULL DEFAULT '#FF6A6A' COMMENT '网站主颜色',
  `remark` text NOT NULL COMMENT '备注',
  `menu_sort` varchar(255) NOT NULL COMMENT '菜单排序',
  `bottom_sort` varchar(255) NOT NULL COMMENT '底部排序',
  PRIMARY KEY (`id`),
  KEY `houses_id` (`houses_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_group"
#


#
# Structure for table "zf_group_menu"
#

DROP TABLE IF EXISTS `zf_group_menu`;
CREATE TABLE `zf_group_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `g_id` int(10) unsigned NOT NULL COMMENT '会员组ID',
  `m_id` int(10) unsigned NOT NULL COMMENT '菜单ID',
  `is_bottom` int(10) unsigned NOT NULL COMMENT '是否是底部公共栏',
  `order` int(10) unsigned NOT NULL COMMENT '排序',
  `order_bottom` int(10) unsigned NOT NULL COMMENT '底部排序',
  `m_auth` varchar(255) NOT NULL COMMENT '权限',
  PRIMARY KEY (`id`),
  KEY `g_id` (`g_id`,`m_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_group_menu"
#


#
# Structure for table "zf_group_user"
#

DROP TABLE IF EXISTS `zf_group_user`;
CREATE TABLE `zf_group_user` (
  `g_id` int(10) unsigned NOT NULL COMMENT '会员组ID',
  `uid` int(10) unsigned NOT NULL COMMENT '会员ID',
  PRIMARY KEY (`g_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_group_user"
#


#
# Structure for table "zf_hooks"
#

DROP TABLE IF EXISTS `zf_hooks`;
CREATE TABLE `zf_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

#
# Data for table "zf_hooks"
#

/*!40000 ALTER TABLE `zf_hooks` DISABLE KEYS */;
INSERT INTO `zf_hooks` VALUES (1,'pageHeader','页面header钩子，一般用于加载插件CSS文件和代码',1,0,''),(2,'pageFooter','页面footer钩子，一般用于加载插件JS文件和JS代码',1,0,'ReturnTop'),(3,'documentEditForm','添加编辑表单的 扩展内容钩子',1,0,'Attachment'),(4,'documentDetailAfter','文档末尾显示',1,0,'Attachment,SocialComment'),(5,'documentDetailBefore','页面内容前显示用钩子',1,0,''),(6,'documentSaveComplete','保存文档数据后的扩展钩子',2,0,'Attachment'),(7,'documentEditFormContent','添加编辑表单的内容显示钩子',1,0,'Editor'),(8,'adminArticleEdit','后台内容编辑页编辑器',1,1378982734,'EditorForAdmin'),(13,'AdminIndex','首页小格子个性化显示',1,1382596073,'SiteStat,SystemInfo,DevTeam'),(14,'topicComment','评论提交方式扩展钩子。',1,1380163518,'Editor'),(16,'app_begin','应用开始',2,1384481614,''),(17,'Houses_select','楼盘弹出搜索页面',1,1500526110,'HousesDialog');
/*!40000 ALTER TABLE `zf_hooks` ENABLE KEYS */;

#
# Structure for table "zf_houses"
#

DROP TABLE IF EXISTS `zf_houses`;
CREATE TABLE `zf_houses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `description` text NOT NULL COMMENT '描述',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `openingtime` int(10) NOT NULL COMMENT '开盘时间',
  `openingtime_remark` text NOT NULL COMMENT '开盘时间备注',
  `launchtime` int(10) NOT NULL COMMENT '交房时间',
  `launchtime_remark` varchar(255) NOT NULL COMMENT '交房时间备注',
  `areacovered` varchar(255) NOT NULL COMMENT '占地面积',
  `plotratio` varchar(255) NOT NULL COMMENT '容积率',
  `greeningrate` varchar(255) NOT NULL COMMENT '绿化率',
  `mcompany` varchar(255) NOT NULL COMMENT '物业公司',
  `developer` varchar(255) NOT NULL COMMENT '开发商',
  `salepermit` varchar(255) NOT NULL COMMENT '预售许可证',
  `salesaddress` varchar(255) NOT NULL COMMENT '售楼地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_houses"
#


#
# Structure for table "zf_houses_img"
#

DROP TABLE IF EXISTS `zf_houses_img`;
CREATE TABLE `zf_houses_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cover_id` int(10) unsigned NOT NULL COMMENT '图片ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_houses_img"
#


#
# Structure for table "zf_houses_info"
#

DROP TABLE IF EXISTS `zf_houses_info`;
CREATE TABLE `zf_houses_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `start_time` int(10) NOT NULL COMMENT '开盘时间',
  `remark` text NOT NULL COMMENT '备注',
  `agreement` varchar(255) NOT NULL COMMENT '协议',
  `bborder_time_over` int(10) NOT NULL COMMENT '报备客户保护时间（天数）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_houses_info"
#


#
# Structure for table "zf_houses_new"
#

DROP TABLE IF EXISTS `zf_houses_new`;
CREATE TABLE `zf_houses_new` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `view` int(10) unsigned NOT NULL COMMENT '浏览数目',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_houses_new"
#


#
# Structure for table "zf_member"
#

DROP TABLE IF EXISTS `zf_member`;
CREATE TABLE `zf_member` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `qq` char(10) NOT NULL DEFAULT '' COMMENT 'qq号',
  `score` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态',
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员表';

#
# Data for table "zf_member"
#

/*!40000 ALTER TABLE `zf_member` DISABLE KEYS */;
INSERT INTO `zf_member` VALUES (1,'zhang',0,'0000-00-00','',500,151,0,1500525401,0,1513818910,1),(2,'chen',0,'0000-00-00','',10,3,0,0,2364545997,1500534670,1),(3,'张继贤',0,'0000-00-00','',0,0,0,0,0,0,1);
/*!40000 ALTER TABLE `zf_member` ENABLE KEYS */;

#
# Structure for table "zf_menu"
#

DROP TABLE IF EXISTS `zf_menu`;
CREATE TABLE `zf_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

#
# Data for table "zf_menu"
#

/*!40000 ALTER TABLE `zf_menu` DISABLE KEYS */;
INSERT INTO `zf_menu` VALUES (1,'首页',0,1,'Index/index',0,'','',0),(2,'内容',0,2,'Article/mydocument',0,'','',0),(3,'文档列表',2,0,'article/index',1,'','内容',0),(4,'新增',3,0,'article/add',0,'','',0),(5,'编辑',3,0,'article/edit',0,'','',0),(6,'改变状态',3,0,'article/setStatus',0,'','',0),(7,'保存',3,0,'article/update',0,'','',0),(8,'保存草稿',3,0,'article/autoSave',0,'','',0),(9,'移动',3,0,'article/move',0,'','',0),(10,'复制',3,0,'article/copy',0,'','',0),(11,'粘贴',3,0,'article/paste',0,'','',0),(12,'导入',3,0,'article/batchOperate',0,'','',0),(13,'回收站',2,0,'article/recycle',1,'','内容',0),(14,'还原',13,0,'article/permit',0,'','',0),(15,'清空',13,0,'article/clear',0,'','',0),(16,'用户',0,3,'User/index',0,'','',0),(17,'用户信息',16,0,'User/index',0,'','用户管理',0),(18,'新增用户',17,0,'User/add',0,'添加新用户','',0),(19,'用户行为',16,0,'User/action',0,'','行为管理',0),(20,'新增用户行为',19,0,'User/addaction',0,'','',0),(21,'编辑用户行为',19,0,'User/editaction',0,'','',0),(22,'保存用户行为',19,0,'User/saveAction',0,'\"用户->用户行为\"保存编辑和新增的用户行为','',0),(23,'变更行为状态',19,0,'User/setStatus',0,'\"用户->用户行为\"中的启用,禁用和删除权限','',0),(24,'禁用会员',19,0,'User/changeStatus?method=forbidUser',0,'\"用户->用户信息\"中的禁用','',0),(25,'启用会员',19,0,'User/changeStatus?method=resumeUser',0,'\"用户->用户信息\"中的启用','',0),(26,'删除会员',19,0,'User/changeStatus?method=deleteUser',0,'\"用户->用户信息\"中的删除','',0),(27,'权限管理',16,0,'AuthManager/index',0,'','用户管理',0),(28,'删除',27,0,'AuthManager/changeStatus?method=deleteGroup',0,'删除用户组','',0),(29,'禁用',27,0,'AuthManager/changeStatus?method=forbidGroup',0,'禁用用户组','',0),(30,'恢复',27,0,'AuthManager/changeStatus?method=resumeGroup',0,'恢复已禁用的用户组','',0),(31,'新增',27,0,'AuthManager/createGroup',0,'创建新的用户组','',0),(32,'编辑',27,0,'AuthManager/editGroup',0,'编辑用户组名称和描述','',0),(33,'保存用户组',27,0,'AuthManager/writeGroup',0,'新增和编辑用户组的\"保存\"按钮','',0),(34,'授权',27,0,'AuthManager/group',0,'\"后台 \\ 用户 \\ 用户信息\"列表页的\"授权\"操作按钮,用于设置用户所属用户组','',0),(35,'访问授权',27,0,'AuthManager/access',0,'\"后台 \\ 用户 \\ 权限管理\"列表页的\"访问授权\"操作按钮','',0),(36,'成员授权',27,0,'AuthManager/user',0,'\"后台 \\ 用户 \\ 权限管理\"列表页的\"成员授权\"操作按钮','',0),(37,'解除授权',27,0,'AuthManager/removeFromGroup',0,'\"成员授权\"列表页内的解除授权操作按钮','',0),(38,'保存成员授权',27,0,'AuthManager/addToGroup',0,'\"用户信息\"列表页\"授权\"时的\"保存\"按钮和\"成员授权\"里右上角的\"添加\"按钮)','',0),(39,'分类授权',27,0,'AuthManager/category',0,'\"后台 \\ 用户 \\ 权限管理\"列表页的\"分类授权\"操作按钮','',0),(40,'保存分类授权',27,0,'AuthManager/addToCategory',0,'\"分类授权\"页面的\"保存\"按钮','',0),(41,'模型授权',27,0,'AuthManager/modelauth',0,'\"后台 \\ 用户 \\ 权限管理\"列表页的\"模型授权\"操作按钮','',0),(42,'保存模型授权',27,0,'AuthManager/addToModel',0,'\"分类授权\"页面的\"保存\"按钮','',0),(43,'扩展',0,8,'Addons/index',0,'','',0),(44,'插件管理',43,1,'Addons/index',0,'','扩展',0),(45,'创建',44,0,'Addons/create',0,'服务器上创建插件结构向导','',0),(46,'检测创建',44,0,'Addons/checkForm',0,'检测插件是否可以创建','',0),(47,'预览',44,0,'Addons/preview',0,'预览插件定义类文件','',0),(48,'快速生成插件',44,0,'Addons/build',0,'开始生成插件结构','',0),(49,'设置',44,0,'Addons/config',0,'设置插件配置','',0),(50,'禁用',44,0,'Addons/disable',0,'禁用插件','',0),(51,'启用',44,0,'Addons/enable',0,'启用插件','',0),(52,'安装',44,0,'Addons/install',0,'安装插件','',0),(53,'卸载',44,0,'Addons/uninstall',0,'卸载插件','',0),(54,'更新配置',44,0,'Addons/saveconfig',0,'更新插件配置处理','',0),(55,'插件后台列表',44,0,'Addons/adminList',0,'','',0),(56,'URL方式访问插件',44,0,'Addons/execute',0,'控制是否有权限通过url访问插件控制器方法','',0),(57,'钩子管理',43,2,'Addons/hooks',0,'','扩展',0),(58,'模型管理',68,3,'Model/index',0,'','系统设置',0),(59,'新增',58,0,'model/add',0,'','',0),(60,'编辑',58,0,'model/edit',0,'','',0),(61,'改变状态',58,0,'model/setStatus',0,'','',0),(62,'保存数据',58,0,'model/update',0,'','',0),(63,'属性管理',68,0,'Attribute/index',1,'网站属性配置。','',0),(64,'新增',63,0,'Attribute/add',0,'','',0),(65,'编辑',63,0,'Attribute/edit',0,'','',0),(66,'改变状态',63,0,'Attribute/setStatus',0,'','',0),(67,'保存数据',63,0,'Attribute/update',0,'','',0),(68,'系统',0,7,'Config/group',0,'','',0),(69,'网站设置',68,1,'Config/group',0,'','系统设置',0),(70,'配置管理',68,4,'Config/index',0,'','系统设置',0),(71,'编辑',70,0,'Config/edit',0,'新增编辑和保存配置','',0),(72,'删除',70,0,'Config/del',0,'删除配置','',0),(73,'新增',70,0,'Config/add',0,'新增配置','',0),(74,'保存',70,0,'Config/save',0,'保存配置','',0),(75,'菜单管理',68,5,'Menu/index',0,'','系统设置',0),(76,'导航管理',68,6,'Channel/index',0,'','系统设置',0),(77,'新增',76,0,'Channel/add',0,'','',0),(78,'编辑',76,0,'Channel/edit',0,'','',0),(79,'删除',76,0,'Channel/del',0,'','',0),(80,'分类管理',68,2,'Category/index',0,'','系统设置',0),(81,'编辑',80,0,'Category/edit',0,'编辑和保存栏目分类','',0),(82,'新增',80,0,'Category/add',0,'新增栏目分类','',0),(83,'删除',80,0,'Category/remove',0,'删除栏目分类','',0),(84,'移动',80,0,'Category/operate/type/move',0,'移动栏目分类','',0),(85,'合并',80,0,'Category/operate/type/merge',0,'合并栏目分类','',0),(86,'备份数据库',68,0,'Database/index?type=export',0,'','数据备份',0),(87,'备份',86,0,'Database/export',0,'备份数据库','',0),(88,'优化表',86,0,'Database/optimize',0,'优化数据表','',0),(89,'修复表',86,0,'Database/repair',0,'修复数据表','',0),(90,'还原数据库',68,0,'Database/index?type=import',0,'','数据备份',0),(91,'恢复',90,0,'Database/import',0,'数据库恢复','',0),(92,'删除',90,0,'Database/del',0,'删除备份文件','',0),(93,'其他',0,5,'other',1,'','',0),(96,'新增',75,0,'Menu/add',0,'','系统设置',0),(98,'编辑',75,0,'Menu/edit',0,'','',0),(104,'下载管理',102,0,'Think/lists?model=download',0,'','',0),(105,'配置管理',102,0,'Think/lists?model=config',0,'','',0),(106,'行为日志',16,0,'Action/actionlog',0,'','行为管理',0),(108,'修改密码',16,0,'User/updatePassword',1,'','',0),(109,'修改昵称',16,0,'User/updateNickname',1,'','',0),(110,'查看行为日志',106,0,'action/edit',1,'','',0),(112,'新增数据',58,0,'think/add',1,'','',0),(113,'编辑数据',58,0,'think/edit',1,'','',0),(114,'导入',75,0,'Menu/import',0,'','',0),(115,'生成',58,0,'Model/generate',0,'','',0),(116,'新增钩子',57,0,'Addons/addHook',0,'','',0),(117,'编辑钩子',57,0,'Addons/edithook',0,'','',0),(118,'文档排序',3,0,'Article/sort',1,'','',0),(119,'排序',70,0,'Config/sort',1,'','',0),(120,'排序',75,0,'Menu/sort',1,'','',0),(121,'排序',76,0,'Channel/sort',1,'','',0),(122,'菜单',0,6,'MenuList/index',0,'','',0),(123,'列表',122,0,'MenuList/index',0,'','基本信息',0),(124,'添加',122,1,'MenuList/add',1,'','基本信息',0),(125,'编辑',122,2,'MenuList/edit',1,'','基本信息',0),(126,'回收站',122,3,'MenuList/recycle',0,'','回收站',0),(127,'列表',122,2,'BottomNav/index',0,'','底部菜单',0),(128,'权限',122,6,'MenuList/menu_auth',0,'','基本内容',0),(130,'已注册',129,0,'SuperCode/index',0,'','列表页',0),(131,'已添加楼盘',129,0,'SuperCode/house',0,'','列表页',0),(132,'序列号生成',129,0,'SuperCode/newlist',0,'','列表页',0),(134,'尚未审核',133,0,'Register/index',0,'','',0),(135,'已经审核',133,0,'Register/newlist',0,'','',0),(136,'绑定',133,0,'Register/bind',1,'','',0);
/*!40000 ALTER TABLE `zf_menu` ENABLE KEYS */;

#
# Structure for table "zf_menu_auth"
#

DROP TABLE IF EXISTS `zf_menu_auth`;
CREATE TABLE `zf_menu_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `m_id` int(10) unsigned NOT NULL COMMENT '菜单ID',
  `title` varchar(255) NOT NULL COMMENT '权限名称',
  PRIMARY KEY (`id`),
  KEY `m_id` (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_menu_auth"
#

INSERT INTO `zf_menu_auth` VALUES (1,3,'锁定成交'),(3,3,'审核'),(4,3,'销控'),(5,8,'公告管理'),(6,3,'房源管理'),(7,2,'编辑'),(8,15,'管理'),(9,14,'公告管理'),(10,11,'查看'),(11,5,'信息管理'),(12,16,'上传'),(13,17,'动态管理'),(14,18,'添加'),(15,18,'管理审核'),(16,19,'合同添加'),(17,19,'合同管理'),(18,20,'添加'),(19,20,'管理'),(20,21,'添加'),(21,21,'调度'),(22,21,'接待');

#
# Structure for table "zf_menu_list"
#

DROP TABLE IF EXISTS `zf_menu_list`;
CREATE TABLE `zf_menu_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `path` varchar(255) NOT NULL COMMENT '路径',
  `icon` int(10) unsigned NOT NULL COMMENT '图标',
  `status` char(50) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_menu_list"
#

/*!40000 ALTER TABLE `zf_menu_list` DISABLE KEYS */;
INSERT INTO `zf_menu_list` VALUES (1,'房源管理','Room/index',1,'0'),(2,'分组管理','Group/index',2,'1'),(3,'房源列表','Room/index',1,'1'),(4,'置业计划','OwnerShip/index',3,'1'),(5,'楼盘信息','Houses/index',12,'1'),(6,'置业计划管理','OwnerShip/manager',5,'1'),(7,'公告管理','Bulletin/index',6,'0'),(8,'公告','Bulletin/index',7,'1'),(9,'内部群','Chat/index',8,'1'),(10,'我的业务','Business/index',9,'1'),(11,'统计报表','Report/index',10,'1'),(12,'个人中心','User/index',11,'1'),(13,'分销管理','Distribution/index',7,'1'),(14,'分销公告','#',7,'1'),(15,'会员管理','User/lists',2,'1'),(16,'楼盘相册','HousesImg/index',4,'1'),(17,'楼盘动态','HousesNew/index',12,'1'),(18,'商城管理','Raise/index',13,'1'),(19,'客户管理','Customer/index',11,'1'),(20,'客户跟踪','Track/index',20,'1'),(21,'客户报备','BBorder/fun',34,'1');
/*!40000 ALTER TABLE `zf_menu_list` ENABLE KEYS */;

#
# Structure for table "zf_model"
#

DROP TABLE IF EXISTS `zf_model`;
CREATE TABLE `zf_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `relation` varchar(30) NOT NULL DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '字段分组',
  `attribute_list` text NOT NULL COMMENT '属性列表（表的字段）',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑模板',
  `list_grid` text NOT NULL COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

#
# Data for table "zf_model"
#

/*!40000 ALTER TABLE `zf_model` DISABLE KEYS */;
INSERT INTO `zf_model` VALUES (4,'user','会员',0,'',1,'{\"1\":[\"42\",\"41\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\"]}','1:基础','','','','','id:ID\r\nnick_name:昵称\r\nphone:手机',10,'','',1499825190,1500531885,1,'MyISAM'),(6,'group','会员组',0,'',1,'{\"1\":[\"46\",\"47\",\"48\",\"49\"]}','1:基础','','','','','',10,'','',1499826778,1499826778,1,'MyISAM'),(7,'menu_list','菜单',0,'',1,'{\"1\":[\"122\",\"50\",\"51\",\"52\"]}','1:基础','','','','','id:ID\r\ntitle:标题\r\npath:路径\r\nicon:图标\r\nstatus:状态\r\nid:操作:[EDIT]|修改,Menu_list/setStatus?status=-1&ids=[id]|删除',10,'','',1499827746,1500625178,1,'MyISAM'),(8,'bottom_nav','底部公共栏',0,'',1,'{\"1\":[\"53\",\"54\",\"55\",\"68\"]}','1:基础','','','','','id:ID\r\nm_id:菜单ID\r\ntitle:标题\r\nicon:图标\r\nstatus:状态',10,'','',1499828721,1500720600,1,'MyISAM'),(9,'menu_auth','菜单权限',0,'',1,'{\"1\":[\"56\",\"57\"]}','1:基础','','','','','id:ID\r\ntitle:标题',10,'','',1500350626,1502089732,1,'InnoDB'),(10,'group_menu','会员组菜单',0,'',1,'','1:基础','','','','','',10,'','',1499828978,1499828978,1,'MyISAM'),(11,'group_user','会员和会员组',0,'',0,'','1:基础','','','','','id:ID',10,'','',1499830019,1499841813,1,'MyISAM'),(12,'houses','楼盘表',0,'',1,'{\"1\":[\"244\",\"245\",\"246\",\"247\",\"248\",\"249\",\"250\",\"251\",\"252\",\"253\",\"254\",\"255\",\"256\",\"257\"]}','1:基础','','','','','id:id',10,'','',1500604941,1507796394,1,'MyISAM'),(13,'building','栋号表',0,'',1,'','1:基础','','','','','',10,'','',1500604972,1500604972,1,'MyISAM'),(14,'unit','单元表',0,'',1,'','1:基础','','','','','',10,'','',1500605048,1500605048,1,'MyISAM'),(15,'sameroom','同类房间表',0,'',1,'{\"1\":[\"102\",\"103\",\"113\",\"104\",\"112\",\"106\",\"107\",\"105\",\"108\",\"109\",\"110\",\"111\",\"124\",\"125\"]}','1:基础','','','','','id:id',10,'','',1500605084,1512715769,1,'MyISAM'),(16,'room','房号表',0,'',1,'','1:基础','','','','','',10,'','',1500605102,1500605102,1,'MyISAM'),(25,'ownership_pic','置业计划图片',0,'',1,'{\"1\":[\"142\",\"144\",\"143\",\"145\"]}','1:基础','','','','','id:ID\r\npath:路径',10,'','',1502423115,1502423301,1,'MyISAM'),(26,'bulletin','公告',0,'',1,'{\"1\":[\"146\",\"147\",\"148\",\"149\",\"150\",\"151\"]}','1:基础','','','','','id:ID\r\ntitle:标题\r\ntype:类型\r\ncreated_time:删除时间\r\nis_delete:是否删除\r\ndelete_time:删除时间',10,'title','',1502436658,1502437028,1,'MyISAM'),(27,'bulletin_user','用户阅读公告',0,'',1,'','1:基础','','','','','',10,'','',1502437091,1502437091,1,'MyISAM'),(28,'chat','内部群聊天',0,'',1,'','1:基础','','','','','id:ID',10,'','',1502694611,1502694629,1,'MyISAM'),(29,'report','房号操作记录',0,'',0,'','1:基础','','','','','id:ID',10,'','',1502952826,1503471806,1,'MyISAM'),(33,'ownership_man','置业计划管理',0,'',1,'','1:基础','','','','','',10,'','',1505706877,1505706877,1,'MyISAM'),(34,'houses_img','楼盘相册',0,'',1,'','1:基础','','','','','',10,'','',1506303346,1506303346,1,'MyISAM'),(35,'houses_new','楼盘动态',0,'',1,'{\"1\":[\"215\",\"216\",\"217\",\"218\",\"219\"]}','1:基础','','','','','id:id',10,'','',1506322076,1506327169,1,'MyISAM'),(36,'raise','认筹',0,'',1,'','1:基础','','','','','',10,'','',1506497000,1506497000,1,'MyISAM'),(37,'houses_info','楼盘所有信息',0,'',1,'{\"1\":[\"230\",\"231\",\"397\"]}','1:基础','','','','','id:id',10,'','',1506649959,1512530752,1,'MyISAM'),(38,'raise_collect_room','认筹收藏房号',0,'',0,'','1:基础','','','','','',10,'','',1507520435,1507520435,1,'MyISAM'),(40,'raise_buy_room','认筹选购ID',0,'',0,'','1:基础','','','','','',10,'','',1508472773,1508472773,1,'MyISAM'),(41,'customer','客户购房记录',0,'',1,'{\"1\":[\"267\",\"268\",\"269\",\"271\",\"272\",\"270\",\"273\",\"303\",\"328\",\"402\",\"403\",\"404\",\"405\"],\"2\":[\"329\",\"274\",\"276\",\"275\",\"285\",\"277\",\"278\"],\"3\":[\"282\",\"279\",\"280\",\"281\",\"289\",\"283\",\"288\",\"286\",\"379\",\"378\",\"284\",\"330\",\"287\",\"382\"],\"4\":[\"290\",\"291\",\"292\",\"293\",\"357\",\"380\",\"381\",\"294\",\"356\",\"295\",\"296\",\"297\",\"298\",\"299\",\"300\",\"301\",\"302\",\"355\",\"304\",\"305\",\"306\",\"307\"],\"5\":[\"331\",\"308\",\"309\",\"310\",\"311\",\"312\",\"313\",\"314\",\"315\",\"316\"],\"6\":[\"317\",\"319\",\"318\",\"320\",\"321\",\"322\",\"323\",\"324\",\"325\",\"326\",\"327\"],\"7\":[\"358\",\"359\",\"360\",\"361\",\"362\",\"363\",\"364\",\"365\",\"366\",\"367\"],\"8\":[\"368\",\"369\",\"370\",\"371\",\"372\",\"373\",\"374\",\"375\",\"376\",\"377\"]}','1:基础;2:意向;3:合同;4:付款;5:置业顾问;6:分销商;7:渠道经理;8:案场主管','','','','','name:姓名\r\nis_over|getYN:是否完成\r\nsex|getSex:性别\r\nphone:联系方式\r\nage:年龄\r\naddress:地址\r\nid_number:身份证号码\r\nin_province|getYN:是本省\r\nis_intention|getYN:是否为意向登记\r\nintention_money:意向登记金额\r\nintention_time|time_format2:意向登记时间\r\nintention_room_style:意向户型\r\nreturn_money|getYN:是否退意向金\r\nintention_money_return_time|time_format2:退意向金时间\r\nserial_number:登记系列号\r\nsubscription_time|time_format2:认购时间\r\ncontract_no:合同编号\r\nunit_price:单价\r\ncontract_money:合同金额\r\nbase_commission:佣金基数\r\ndecoration_money:装修款\r\ndecoration_receive_money:已收装修款\r\ndecoration_receive_money_time:收到装修款时间\r\noffer_policy:优惠政策\r\nroom_number:房号\r\narea:面积\r\not_payment|getYN:一次性付款\r\nbank_mortgage|getYN:银行按揭\r\ninstallment|getYN:分期付款\r\ndeposit:定金(含意向金)\r\ndeposit_time|time_format2:定金时间\r\ndeposit_return:已退定金\r\ndeposit_return_time|time_format2:退定金时间\r\ndown_payment:首付(含定金)\r\ndown_payment_time|time_format2:首付时间\r\nprogress_payment_1:进度款一\r\nprogress_payment_2:进度款二\r\nprogress_payment_3:进度款三\r\nloan_amout:按揭金额\r\nget_loan_amout:按揭到账金额\r\nloan_amout_time:按揭到账时间\r\ncus_info_reported_time|time_format2:客户信息备案领取时间\r\nget_contract_money|getYN:是否完成合同收款\r\nrecord|getYN:网上备案\r\nrecord_time|time_format2:备案时间\r\nget_house|getYN:交房\r\nget_house_time|time_format2:交房时间\r\ncheck_out|getYN:是否退房\r\ncheck_out_money:退房退款金额\r\nget_check_out_money:退房已退款金额\r\ncheck_out_time|time_format2:退款时间\r\nsales:置业顾问\r\nsales_point:置业顾问提成点数\r\nsales_commission:置业顾问佣金\r\nsales_bonus:置业顾问奖金\r\nsales_receive_commission|getYN:置业顾问是否领取佣金\r\nsales_commission_time|time_format2:置业顾问领取佣金时间\r\nsales_receive_bonus|getYN:置业顾问已经领取的奖金\r\nsales_bonus_time|time_format2:置业顾问已领取奖金时间\r\nsales_return_commission|getYN:置业顾问是否退回佣金\r\nsales_return_com_time|time_format2:置业顾问退回佣金时间\r\ndistribution:分销商\r\ndistribution_point:分销点数\r\nis_dribution_invoice|getYN:分销发票是否收\r\ndistribution_commission:分销商佣金金额\r\ndistribution_bonus:分销奖金、成交奖\r\ndis_receive_commission:分销商已领取的佣金\r\ndis_commission_time|time_format2:分销商领取佣金时间\r\ndis_receive_bonus:分销商已领取的奖金\r\ndis_bonus_time|time_format2:分销商领取奖金的时间\r\ndis_return_commission:分销商退回的佣金，奖金\r\ndis_return_com_time|time_format2:分销商退回佣金，奖金时间\r\nmanager:渠道经理\r\nmanager_point:渠道经理提成点数\r\nmanager_commission:渠道经理佣金\r\nmanager_bonus:渠道经理奖金\r\nmanager_receive_commission:渠道经理已领取佣金\r\nmanager_commission_time|time_format2:渠道经理领取佣金时间\r\nmanager_receive_bonus:渠道经理已领取奖金\r\nmanager_bonus_time|time_format2:渠道经理领取奖金时间\r\nmanager_return_commission:渠道经理退回的佣金\r\nmanager_return_com_time|time_format2:渠道经理退回佣金时间\r\nsupervisor:案场主管\r\nsupervisor_point:案场主管提成点数\r\nsupervisor_commission:案场主管佣金\r\nsupervisor_bonus:案场主管奖金\r\nsupervisor_receive_commission:案场主管已领取佣金\r\nsupervisor_commission_time|time_format2:案场主管领取佣金时间\r\nsupervisor_receive_bonus:案场主管已领取奖金\r\nsupervisor_bonus_time|time_format2:案场主管领取奖金时间\r\nsupervisor_return_commission:案场主管退回的佣金\r\nsupervisor_return_com_time|time_format2:案场主管退回佣金时间\r\ncreated_time|time_format2:创建时间',10,'name','',1508817575,1511325155,1,'MyISAM'),(42,'cus_track','客户跟踪',0,'',1,'{\"1\":[\"332\",\"333\",\"407\",\"334\",\"335\",\"336\",\"337\",\"338\",\"339\",\"340\",\"341\",\"342\",\"343\",\"344\",\"346\",\"349\",\"345\",\"400\",\"401\",\"347\",\"348\",\"350\"]}','1:基础','','','','','intention|getStar:意向判断\r\nlast_time|time_format2:上次回访时间\r\nname:客户姓名\r\nphone:联系方式\r\nfirst_time|time_format2:登记时间\r\nin_province|getYN:是否本省\r\nposition:要求位置\r\narea:面积\r\ninstallation:主要抗性\r\nlike_price:心理价位\r\njob:职业\r\ncome_num:置业次数\r\nrequire:要求\r\nuse:用途\r\nis_deal|getYN:是否成交\r\nover|getYN:是否完成\r\ncheck_out|getYN:是否退房\r\nsales_name:置业顾问\r\ncus_from:客户来源',10,'','',1509591616,1511509461,1,'MyISAM'),(43,'track_log','跟踪记录表',0,'',0,'','1:基础','','','','','',10,'','',1509593201,1509593201,1,'MyISAM'),(44,'raise_bulletin','认筹公告信息',0,'',1,'','1:基础','','','','','',10,'','',1510557555,1510557555,1,'MyISAM'),(45,'bborder','报备系统',0,'',1,'{\"1\":[\"408\",\"409\",\"423\",\"425\",\"424\",\"422\",\"415\",\"416\",\"417\",\"418\",\"419\",\"420\",\"421\"]}','1:基础','','','','','name:客户姓名\r\nphone:联系方式\r\npeople_num:同行人数\r\norder_time|time_format2:预约时间\r\nmeet_address:接车地点\r\nin_province|getYN:本省\r\nposition:要求位置\r\narea:面积\r\nroom:房号\r\nlike_price:心里价位\r\njob:职位\r\ncar:车辆信息\r\nis_over|getYN:完成',10,'','',1511770425,1512696790,1,'MyISAM'),(46,'bborder_log','备案记录',0,'',1,'','1:基础','','','','','id:ID',10,'','',1511770874,1511772933,1,'MyISAM');
/*!40000 ALTER TABLE `zf_model` ENABLE KEYS */;

#
# Structure for table "zf_ownership_man"
#

DROP TABLE IF EXISTS `zf_ownership_man`;
CREATE TABLE `zf_ownership_man` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `bg_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '类型',
  `bg_img` int(10) unsigned NOT NULL COMMENT '背景图片ID',
  `bg_color` varchar(255) NOT NULL COMMENT '背景颜色',
  `remark` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_ownership_man"
#


#
# Structure for table "zf_ownership_pic"
#

DROP TABLE IF EXISTS `zf_ownership_pic`;
CREATE TABLE `zf_ownership_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `path` varchar(255) NOT NULL COMMENT '路径',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_ownership_pic"
#


#
# Structure for table "zf_picture"
#

DROP TABLE IF EXISTS `zf_picture`;
CREATE TABLE `zf_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

#
# Data for table "zf_picture"
#

/*!40000 ALTER TABLE `zf_picture` DISABLE KEYS */;
INSERT INTO `zf_picture` VALUES (1,'/Uploads/Picture/2017-10-12/59df1f2700f15.png','','87cb28dfda5772a21ec40b3afda1be75','786c84fa100d366eb96db999e5c02e334cf84b6d',1,1507794726),(2,'/Uploads/Picture/2017-10-12/59df1f339a327.png','','a878afc04d9d007611bdbffd8e261969','03f0c163cfc71241f2fafe048fd02467fe8d485e',1,1507794739),(3,'/Uploads/Picture/2017-10-12/59df1f59b5ce2.png','','fe1f86d70279747d815d17840331f038','0eead37a14ee7991c656cf20803c90ef1d63db12',1,1507794777),(4,'/Uploads/Picture/2017-10-12/59df1f6b75766.png','','a477643b6443253c97b6e24f8e399930','d7e8e7dbebbc3e62bc746a30216778908f125252',1,1507794795),(5,'/Uploads/Picture/2017-10-12/59df1f73a7781.png','','709433768ccc2591345d4b57154bda0b','59610e32549f06278609874bd97df246e8a5ea21',1,1507794803),(6,'/Uploads/Picture/2017-10-12/59df1f80f353c.png','','c1e3f4eaf428420d769b26ab9bd07b04','9f2f6081c433f347cdd53191370160827097a386',1,1507794816),(7,'/Uploads/Picture/2017-10-12/59df1f847db60.png','','cac84c308dc6268a4d55dfd3c8806034','f412077d2ec6d27057af09819be086ed8ee7aaf2',1,1507794820),(8,'/Uploads/Picture/2017-10-12/59df1fa406f34.png','','9802ca9cd2f213cb1fea01d94a7cbe9c','c1feba61356cc9774ce15eec59cd87bd53c60cea',1,1507794851),(9,'/Uploads/Picture/2017-10-12/59df1fad204b1.png','','07b6b6d162239e74a02721ffe4d5bd73','385c46dca94d4637a440591436a85a31012a03a8',1,1507794861),(10,'/Uploads/Picture/2017-10-12/59df1fc00a92f.png','','98de50f9c05f31b47fae57719ac7adf9','ce5b29a11298f921a7722f3f1d8ce40ca2485e55',1,1507794879),(11,'/Uploads/Picture/2017-10-12/59df1fc99f819.png','','d87e35c1d5678dbab1b001d4b7307e9b','eb34d3239106d7d403949acf5b01c402c7240d41',1,1507794889),(12,'/Uploads/Picture/2017-10-12/59df2013ee0ff.png','','7c7a8bf76000c90d65712caff249fb2d','f2c92e3ee73723ea8c6d53899f0a23f56f398740',1,1507794963),(13,'/Uploads/Picture/2017-10-12/59df20282624b.png','','6da917d169d38fd616f9a50f33f44772','6656780e2d66ced95de778c6bf4cecfcfc5be103',1,1507794984),(14,'/Uploads/Picture/2017-10-12/59df2088850e3.png','','c11eb5e605bd7cf81f58c70f24e374da','88c8f6456d2abc10637aee541257547744b7cac3',1,1507795080),(15,'/Uploads/Picture/2017-10-12/59df20941bcf6.png','','81b5e2cee8808fcd1ef749cbfb8e1645','79949d1d9178451588e4348b1ca5504e7dade66a',1,1507795092),(16,'/Uploads/Picture/2017-10-12/59df209c1a007.png','','561e65c12ded3461a2bc266ab01cc4bd','235bec58608e990d586c3c36a4fbd87b2a0a3ce5',1,1507795100),(17,'/Uploads/Picture/2017-10-12/59df20a54a706.png','','bcecbba618865db81bee9fac748bed08','27d078985dc891e0843e7be64eea1a0afa9d3539',1,1507795109),(18,'/Uploads/Picture/2017-10-19/59e874db935fd.jpg','','c228c547d249e7294d55c88db87af3d2','243c8712c3b646fc89047091d0541509a84a93ba',1,1508406491),(19,'/Uploads/Picture/2017-10-20/59e9651aa0f2a.jpg','','b9a450fad7f18d8bad8937d05d523591','1a1a9eab7d0062c6f0af445ebc6cb5649fa03ef2',1,1508467994),(20,'/Uploads/Picture/2017-11-02/59fa96b307bd9.png','','997a42df0d971b693833c19f467eb2c1','de1b626cb1aaa0e662518b6cebb4d843518c58b0',1,1509594802),(21,'/Uploads/Picture/2017-11-08/5a02b44d6238d.jpg','','0cbf7f56985586877995321799cfbc22','25a1180845c6e1fd8a93a9f890b730b4b59e97a3',1,1510126669),(22,'/Uploads/Picture/2017-11-13/5a094e751570c.jpg','','ab1e6cb68ce9227d04867dafa1664745','6c0e65b92a34a2f65962b5a0aed2cdcb52e7544b',1,1510559349),(23,'/Uploads/Picture/2017-11-15/5a0ba230da647.jpg','','6eb7df2a35284b2c6d440813d2c185a6','1112ea1669e307c1aa7dedd6464df02e2f96f42c',1,1510711856),(26,'/Uploads/Picture/2017-11-21/5a139c430c195.jpg','','54f85037aee7887d2680157d74dd6678','a69422e11bf52a82625d0471223c7c7b894ce971',1,1511234626),(27,'/Uploads/Picture/2017-11-21/5a139c537917b.jpg','','7d38a6dff8d81241a1c6336503fa83e7','25e0df3896dd78ef2521b76dcd430989ef24e518',1,1511234643),(28,'/Uploads/Picture/2017-11-21/5a139c92bf4f9.jpg','','6096cdcf7e2711041df7fc16f09c1b79','4d8a61839f648eb690d9a47872a1a3aaa1ca4e79',1,1511234706),(29,'/Uploads/Picture/2017-11-21/5a139d78da6ad.jpg','','7abf2c82f3200b323799a12d305694bc','17f259b6b895bc10b0bda5d66ee242dffd12ba0d',1,1511234936),(30,'/Uploads/Picture/2017-11-21/5a139e4ba9d65.jpg','','7b8a32f5d36c07e623240175a016944c','6b15309e3772839f7871b8e5183b60b3bde3c395',1,1511235147),(31,'/Uploads/Picture/2017-11-21/5a13a505e0783.jpg','','f8d15b329e411103171027ab2edefb34','76268564f2c34426f56700d8c2815e0b21262c12',1,1511236869),(32,'/Uploads/Picture/2017-11-21/5a13a8352c8fb.jpg','','bdd64820644ff26273c188862a565e05','cb62c7dfbba47e6e656cfd54573ef8b9da1c9438',1,1511237685),(33,'/Uploads/Picture/2017-11-21/5a13a90e5e0d6.jpg','','09dcc8e265ce4053cea7a2821749b97c','2dc9f5276eb28e4cd704171b52a4a1283aa2f05a',1,1511237902),(34,'/Uploads/Picture/2017-11-27/5a1bce38df286.png','','87723bda9cf59a2d6ce45693454a56e4','4830ff117ea6d66ac517e69032f5356977929c39',1,1511771704);
/*!40000 ALTER TABLE `zf_picture` ENABLE KEYS */;

#
# Structure for table "zf_raise"
#

DROP TABLE IF EXISTS `zf_raise`;
CREATE TABLE `zf_raise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cus_phone` varchar(255) NOT NULL COMMENT '客户手机',
  `cus_name` varchar(255) NOT NULL COMMENT '客户姓名',
  `voucher_thumb` int(10) unsigned NOT NULL COMMENT '凭证图片',
  `voucher_number` varchar(255) NOT NULL COMMENT '凭证信息',
  `user_phone` varchar(255) NOT NULL COMMENT '置业顾问手机',
  `user_name` varchar(255) NOT NULL COMMENT '置业顾问姓名',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `r_id` int(10) unsigned NOT NULL COMMENT '购房房号',
  `buy_time` int(10) NOT NULL COMMENT '购房时间',
  `check_out` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否退房',
  `check_out_time` int(10) NOT NULL COMMENT '退房时间',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `check_id` int(10) unsigned NOT NULL COMMENT '审核ID',
  `raise_over` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否认购完成',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_raise"
#


#
# Structure for table "zf_raise_bulletin"
#

DROP TABLE IF EXISTS `zf_raise_bulletin`;
CREATE TABLE `zf_raise_bulletin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '类型',
  `created_time` int(10) NOT NULL COMMENT '发布时间',
  `pictures` varchar(255) NOT NULL COMMENT '图片',
  `file` varchar(255) NOT NULL COMMENT '文件',
  `view` int(10) unsigned NOT NULL COMMENT '浏览数',
  `is_del` tinyint(2) NOT NULL COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_raise_bulletin"
#


#
# Structure for table "zf_raise_buy_room"
#

DROP TABLE IF EXISTS `zf_raise_buy_room`;
CREATE TABLE `zf_raise_buy_room` (
  `r_id` int(10) unsigned NOT NULL COMMENT '房号ID',
  `raise_id` int(10) unsigned NOT NULL COMMENT '认筹ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_raise_buy_room"
#


#
# Structure for table "zf_raise_collect_room"
#

DROP TABLE IF EXISTS `zf_raise_collect_room`;
CREATE TABLE `zf_raise_collect_room` (
  `r_id` int(10) unsigned NOT NULL COMMENT '房号ID',
  `raise_id` int(10) unsigned NOT NULL COMMENT '认筹ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_raise_collect_room"
#


#
# Structure for table "zf_report"
#

DROP TABLE IF EXISTS `zf_report`;
CREATE TABLE `zf_report` (
  `r_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '房号表ID',
  `type` char(10) NOT NULL COMMENT '操作类型',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `op_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `check_id` int(10) unsigned NOT NULL COMMENT '审核ID',
  PRIMARY KEY (`r_id`,`type`),
  KEY `r_id` (`r_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='房号操作记录表';

#
# Data for table "zf_report"
#


#
# Structure for table "zf_room"
#

DROP TABLE IF EXISTS `zf_room`;
CREATE TABLE `zf_room` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `u_id` int(10) unsigned NOT NULL COMMENT '单元ID',
  `s_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同类型表ID',
  `room_number` varchar(255) NOT NULL COMMENT '房号',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `market_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销控人ID',
  `market_time` int(10) NOT NULL COMMENT '销控时间',
  `floor` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '楼层',
  `unit_price` varchar(255) NOT NULL DEFAULT '' COMMENT '单价',
  `usable_price` varchar(255) NOT NULL DEFAULT '' COMMENT '套内单价',
  `status` char(50) NOT NULL DEFAULT '0' COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `is_check` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `lock_uid` int(10) unsigned NOT NULL COMMENT '锁定用于ID',
  `lock_time` int(10) NOT NULL COMMENT '锁定时间',
  `submit_uid` int(10) unsigned NOT NULL COMMENT '成交用户ID',
  `submit_time` int(10) NOT NULL COMMENT '成交时间',
  `lastop_uid` int(10) unsigned NOT NULL COMMENT '最后操作用户ID',
  `lock_check_uid` int(10) unsigned NOT NULL COMMENT '审核锁定的会员ID',
  `submit_check_uid` int(10) unsigned NOT NULL COMMENT '审核成交的会员ID',
  `raise_id` int(10) unsigned NOT NULL COMMENT '认筹购买ID',
  `raise_time` int(10) NOT NULL COMMENT '认筹购买时间',
  `raise_check_uid` int(10) unsigned NOT NULL COMMENT '认筹审核id',
  `total_price` varchar(255) NOT NULL COMMENT '总价',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_room"
#


#
# Structure for table "zf_sameroom"
#

DROP TABLE IF EXISTS `zf_sameroom`;
CREATE TABLE `zf_sameroom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `r_name` varchar(255) NOT NULL COMMENT '房间序号（名称）',
  `unit_price` int(10) unsigned NOT NULL COMMENT '最低建筑单价',
  `usable_price` int(10) unsigned NOT NULL COMMENT '最低套内单价',
  `total_price` int(10) unsigned NOT NULL COMMENT '总价',
  `area` int(10) unsigned NOT NULL COMMENT '建筑面积',
  `usable_area` int(10) unsigned NOT NULL COMMENT '套内面积',
  `apartment` int(10) unsigned NOT NULL COMMENT '房',
  `hall` int(10) unsigned NOT NULL COMMENT '厅',
  `kitchen` int(10) unsigned NOT NULL COMMENT '厨',
  `toilet` int(10) unsigned NOT NULL COMMENT '卫',
  `usable_tw_price` int(10) unsigned NOT NULL COMMENT '套内单价差价',
  `bt_price` int(10) unsigned NOT NULL COMMENT '建筑价格差价',
  `orientation` varchar(255) NOT NULL DEFAULT '' COMMENT '朝向',
  `thumb` varchar(255) DEFAULT NULL COMMENT '户型图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_sameroom"
#


#
# Structure for table "zf_track_log"
#

DROP TABLE IF EXISTS `zf_track_log`;
CREATE TABLE `zf_track_log` (
  `ct_id` int(10) unsigned NOT NULL COMMENT '客户跟踪表ID',
  `time` int(10) NOT NULL COMMENT '时间',
  `type` varchar(255) NOT NULL COMMENT '类型',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `uid` int(10) unsigned NOT NULL COMMENT '操作人ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_track_log"
#


#
# Structure for table "zf_ucenter_admin"
#

DROP TABLE IF EXISTS `zf_ucenter_admin`;
CREATE TABLE `zf_ucenter_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '管理员状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

#
# Data for table "zf_ucenter_admin"
#


#
# Structure for table "zf_ucenter_app"
#

DROP TABLE IF EXISTS `zf_ucenter_app`;
CREATE TABLE `zf_ucenter_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '应用ID',
  `title` varchar(30) NOT NULL COMMENT '应用名称',
  `url` varchar(100) NOT NULL COMMENT '应用URL',
  `ip` char(15) NOT NULL COMMENT '应用IP',
  `auth_key` varchar(100) NOT NULL COMMENT '加密KEY',
  `sys_login` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '同步登陆',
  `allow_ip` varchar(255) NOT NULL COMMENT '允许访问的IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '应用状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用表';

#
# Data for table "zf_ucenter_app"
#


#
# Structure for table "zf_ucenter_member"
#

DROP TABLE IF EXISTS `zf_ucenter_member`;
CREATE TABLE `zf_ucenter_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL COMMENT '用户手机',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "zf_ucenter_member"
#

/*!40000 ALTER TABLE `zf_ucenter_member` DISABLE KEYS */;
INSERT INTO `zf_ucenter_member` VALUES (1,'zhang','05c10d69b62db2b463a7e7321d9d190a','470299041@qq.com','',1500525401,2364545997,1508298552,0,1500525401,1),(2,'chen','05c10d69b62db2b463a7e7321d9d190a','5456464@qq.com','',1500533344,2364545997,1500534670,2364545997,1500533344,1);
/*!40000 ALTER TABLE `zf_ucenter_member` ENABLE KEYS */;

#
# Structure for table "zf_ucenter_setting"
#

DROP TABLE IF EXISTS `zf_ucenter_setting`;
CREATE TABLE `zf_ucenter_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '设置ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型（1-用户配置）',
  `value` text NOT NULL COMMENT '配置数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置表';

#
# Data for table "zf_ucenter_setting"
#


#
# Structure for table "zf_unit"
#

DROP TABLE IF EXISTS `zf_unit`;
CREATE TABLE `zf_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `b_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栋号表ID',
  `u_name` varchar(255) NOT NULL COMMENT '单元序号（名称）',
  `room_num` int(10) unsigned NOT NULL COMMENT '每层房间数',
  `floor_start` int(10) unsigned NOT NULL COMMENT '开始楼层',
  `floor_over` int(10) unsigned NOT NULL COMMENT '结束楼层',
  `u_order` int(10) unsigned NOT NULL COMMENT '单元排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_unit"
#


#
# Structure for table "zf_url"
#

DROP TABLE IF EXISTS `zf_url`;
CREATE TABLE `zf_url` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '链接唯一标识',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `short` char(100) NOT NULL DEFAULT '' COMMENT '短网址',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='链接表';

#
# Data for table "zf_url"
#


#
# Structure for table "zf_user"
#

DROP TABLE IF EXISTS `zf_user`;
CREATE TABLE `zf_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `phone` varchar(255) NOT NULL COMMENT '手机号码',
  `password` varchar(255) NOT NULL COMMENT '	密码',
  `nick_name` varchar(255) NOT NULL COMMENT '昵称',
  `head_img` varchar(255) NOT NULL COMMENT '头像',
  `is_super` char(50) NOT NULL DEFAULT '0' COMMENT '是否是超级会员',
  `created_time` int(10) NOT NULL COMMENT '创建时间',
  `updated_time` int(10) NOT NULL COMMENT '修改时间',
  `sex` char(50) NOT NULL DEFAULT '0' COMMENT '性别',
  `is_activation` char(50) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `status` char(50) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "zf_user"
#


#
# Structure for table "zf_userdata"
#

DROP TABLE IF EXISTS `zf_userdata`;
CREATE TABLE `zf_userdata` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `type` tinyint(3) unsigned NOT NULL COMMENT '类型标识',
  `target_id` int(10) unsigned NOT NULL COMMENT '目标id',
  UNIQUE KEY `uid` (`uid`,`type`,`target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "zf_userdata"
#

