DROP TABLE IF EXISTS `yxt_ad`;
CREATE TABLE `yxt_ad` (
  `ad_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `ad_name` varchar(255) NOT NULL,
  `ad_content` text,
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`ad_id`),
  KEY `ad_name` (`ad_name`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_application`;
CREATE TABLE `yxt_application` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) DEFAULT NULL,
  `t_name` varchar(20) DEFAULT NULL,
  `zigezheng` varchar(200) DEFAULT NULL,
  `zichengzheng` varchar(200) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_application ( `id`, `user_id`, `t_name`, `zigezheng`, `zichengzheng`, `addtime`, `state` ) VALUES  ('1','2','王建明','/data/upload/20161127/583a7c272e189.jpg','','2016-11-27 14:24:45','1');
INSERT INTO yxt_application ( `id`, `user_id`, `t_name`, `zigezheng`, `zichengzheng`, `addtime`, `state` ) VALUES  ('2','4','云隐','/data/upload/20161207/58481254227f0.png','','2016-12-07 21:44:54','1');
INSERT INTO yxt_application ( `id`, `user_id`, `t_name`, `zigezheng`, `zichengzheng`, `addtime`, `state` ) VALUES  ('3','5','理科生福','/data/upload/20161207/5848142f2bfbf.png','','2016-12-07 21:52:50','1');
DROP TABLE IF EXISTS `yxt_asset`;
CREATE TABLE `yxt_asset` (
  `aid` bigint(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `filepath` varchar(200) NOT NULL,
  `uploadtime` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `meta` text,
  `suffix` varchar(50) DEFAULT NULL,
  `download_times` int(6) NOT NULL,
  PRIMARY KEY (`aid`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_auth_access`;
CREATE TABLE `yxt_auth_access` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(255) NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','course/adminsection/index','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','course/admincourse/index','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','course/admincoursetype/index','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/course/index','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/clearcache','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/mailer/active_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/mailer/active','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/mailer/index_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/mailer/index','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/mailer/default','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/listorders','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/open','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/ban','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/delete','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/edit_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/edit','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/add_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/add','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/route/index','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/site_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/site','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/password_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/password','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/user/userinfo_post','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/user/userinfo','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/userdefault','admin_url');
INSERT INTO yxt_auth_access ( `role_id`, `rule_name`, `type` ) VALUES  ('2','admin/setting/default','admin_url');
DROP TABLE IF EXISTS `yxt_auth_rule`;
CREATE TABLE `yxt_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '1' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(255) DEFAULT NULL COMMENT '额外url参数',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('1','Admin','admin_url','admin/content/default','','文章系统','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('2','Api','admin_url','api/guestbookadmin/index','','所有留言','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('3','Api','admin_url','api/guestbookadmin/delete','','删除网站留言','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('4','Comment','admin_url','comment/commentadmin/index','','评论管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('5','Comment','admin_url','comment/commentadmin/delete','','删除评论','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('6','Comment','admin_url','comment/commentadmin/check','','评论审核','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('7','Portal','admin_url','portal/adminpost/index','','文章管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('8','Portal','admin_url','portal/adminpost/listorders','','文章排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('9','Portal','admin_url','portal/adminpost/top','','文章置顶','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('10','Portal','admin_url','portal/adminpost/recommend','','文章推荐','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('11','Portal','admin_url','portal/adminpost/move','','批量移动','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('12','Portal','admin_url','portal/adminpost/check','','文章审核','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('13','Portal','admin_url','portal/adminpost/delete','','删除文章','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('14','Portal','admin_url','portal/adminpost/edit','','编辑文章','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('15','Portal','admin_url','portal/adminpost/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('16','Portal','admin_url','portal/adminpost/add','','添加文章','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('17','Portal','admin_url','portal/adminpost/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('18','Portal','admin_url','portal/adminterm/index','','分类管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('19','Portal','admin_url','portal/adminterm/listorders','','文章分类排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('20','Portal','admin_url','portal/adminterm/delete','','删除分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('21','Portal','admin_url','portal/adminterm/edit','','编辑分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('22','Portal','admin_url','portal/adminterm/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('23','Portal','admin_url','portal/adminterm/add','','添加分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('24','Portal','admin_url','portal/adminterm/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('25','Portal','admin_url','portal/adminpage/index','','页面管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('26','Portal','admin_url','portal/adminpage/listorders','','页面排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('27','Portal','admin_url','portal/adminpage/delete','','删除页面','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('28','Portal','admin_url','portal/adminpage/edit','','编辑页面','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('29','Portal','admin_url','portal/adminpage/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('30','Portal','admin_url','portal/adminpage/add','','添加页面','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('31','Portal','admin_url','portal/adminpage/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('32','Admin','admin_url','admin/recycle/default','','回收站','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('33','Portal','admin_url','portal/adminpost/recyclebin','','文章回收','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('34','Portal','admin_url','portal/adminpost/restore','','文章还原','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('35','Portal','admin_url','portal/adminpost/clean','','彻底删除','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('36','Portal','admin_url','portal/adminpage/recyclebin','','页面回收','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('37','Portal','admin_url','portal/adminpage/clean','','彻底删除','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('38','Portal','admin_url','portal/adminpage/restore','','页面还原','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('39','Admin','admin_url','admin/extension/default','','扩展工具','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('40','Admin','admin_url','admin/backup/default','','备份管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('41','Admin','admin_url','admin/backup/restore','','数据还原','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('42','Admin','admin_url','admin/backup/index','','数据备份','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('43','Admin','admin_url','admin/backup/index_post','','提交数据备份','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('44','Admin','admin_url','admin/backup/download','','下载备份','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('45','Admin','admin_url','admin/backup/del_backup','','删除备份','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('46','Admin','admin_url','admin/backup/import','','数据备份导入','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('47','Admin','admin_url','admin/plugin/index','','插件管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('48','Admin','admin_url','admin/plugin/toggle','','插件启用切换','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('49','Admin','admin_url','admin/plugin/setting','','插件设置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('50','Admin','admin_url','admin/plugin/setting_post','','插件设置提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('51','Admin','admin_url','admin/plugin/install','','插件安装','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('52','Admin','admin_url','admin/plugin/uninstall','','插件卸载','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('53','Admin','admin_url','admin/slide/default','','幻灯片','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('54','Admin','admin_url','admin/slide/index','','幻灯片管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('55','Admin','admin_url','admin/slide/listorders','','幻灯片排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('56','Admin','admin_url','admin/slide/toggle','','幻灯片显示切换','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('57','Admin','admin_url','admin/slide/delete','','删除幻灯片','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('58','Admin','admin_url','admin/slide/edit','','编辑幻灯片','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('59','Admin','admin_url','admin/slide/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('60','Admin','admin_url','admin/slide/add','','添加幻灯片','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('61','Admin','admin_url','admin/slide/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('62','Admin','admin_url','admin/slidecat/index','','幻灯片分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('63','Admin','admin_url','admin/slidecat/delete','','删除分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('64','Admin','admin_url','admin/slidecat/edit','','编辑分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('65','Admin','admin_url','admin/slidecat/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('66','Admin','admin_url','admin/slidecat/add','','添加分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('67','Admin','admin_url','admin/slidecat/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('68','Admin','admin_url','admin/ad/index','','网站广告','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('69','Admin','admin_url','admin/ad/toggle','','广告显示切换','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('70','Admin','admin_url','admin/ad/delete','','删除广告','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('71','Admin','admin_url','admin/ad/edit','','编辑广告','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('72','Admin','admin_url','admin/ad/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('73','Admin','admin_url','admin/ad/add','','添加广告','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('74','Admin','admin_url','admin/ad/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('75','Admin','admin_url','admin/link/index','','友情链接','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('76','Admin','admin_url','admin/link/listorders','','友情链接排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('77','Admin','admin_url','admin/link/toggle','','友链显示切换','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('78','Admin','admin_url','admin/link/delete','','删除友情链接','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('79','Admin','admin_url','admin/link/edit','','编辑友情链接','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('80','Admin','admin_url','admin/link/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('81','Admin','admin_url','admin/link/add','','添加友情链接','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('82','Admin','admin_url','admin/link/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('83','Api','admin_url','api/oauthadmin/setting','','第三方登陆','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('84','Api','admin_url','api/oauthadmin/setting_post','','提交设置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('85','Admin','admin_url','admin/menu/default','','菜单管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('86','Admin','admin_url','admin/navcat/default1','','前台菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('87','Admin','admin_url','admin/nav/index','','菜单管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('88','Admin','admin_url','admin/nav/listorders','','前台导航排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('89','Admin','admin_url','admin/nav/delete','','删除菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('90','Admin','admin_url','admin/nav/edit','','编辑菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('91','Admin','admin_url','admin/nav/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('92','Admin','admin_url','admin/nav/add','','添加菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('93','Admin','admin_url','admin/nav/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('94','Admin','admin_url','admin/navcat/index','','菜单分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('95','Admin','admin_url','admin/navcat/delete','','删除分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('96','Admin','admin_url','admin/navcat/edit','','编辑分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('97','Admin','admin_url','admin/navcat/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('98','Admin','admin_url','admin/navcat/add','','添加分类','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('99','Admin','admin_url','admin/navcat/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('100','Admin','admin_url','admin/menu/index','','后台菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('101','Admin','admin_url','admin/menu/add','','添加菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('102','Admin','admin_url','admin/menu/add_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('103','Admin','admin_url','admin/menu/listorders','','后台菜单排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('104','Admin','admin_url','admin/menu/export_menu','','菜单备份','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('105','Admin','admin_url','admin/menu/edit','','编辑菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('106','Admin','admin_url','admin/menu/edit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('107','Admin','admin_url','admin/menu/delete','','删除菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('108','Admin','admin_url','admin/menu/lists','','所有菜单','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('109','Admin','admin_url','admin/setting/default','','系统设置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('110','Admin','admin_url','admin/setting/userdefault','','个人信息','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('111','Admin','admin_url','admin/user/userinfo','','修改信息','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('112','Admin','admin_url','admin/user/userinfo_post','','修改信息提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('113','Admin','admin_url','admin/setting/password','','修改密码','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('114','Admin','admin_url','admin/setting/password_post','','提交修改','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('115','Admin','admin_url','admin/setting/site','','网站信息','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('116','Admin','admin_url','admin/setting/site_post','','提交修改','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('117','Admin','admin_url','admin/route/index','','路由列表','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('118','Admin','admin_url','admin/route/add','','路由添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('119','Admin','admin_url','admin/route/add_post','','路由添加提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('120','Admin','admin_url','admin/route/edit','','路由编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('121','Admin','admin_url','admin/route/edit_post','','路由编辑提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('122','Admin','admin_url','admin/route/delete','','路由删除','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('123','Admin','admin_url','admin/route/ban','','路由禁止','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('124','Admin','admin_url','admin/route/open','','路由启用','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('125','Admin','admin_url','admin/route/listorders','','路由排序','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('126','Admin','admin_url','admin/mailer/default','','邮箱配置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('127','Admin','admin_url','admin/mailer/index','','SMTP配置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('128','Admin','admin_url','admin/mailer/index_post','','提交配置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('129','Admin','admin_url','admin/mailer/active','','邮件模板','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('130','Admin','admin_url','admin/mailer/active_post','','提交模板','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('131','Admin','admin_url','admin/setting/clearcache','','清除缓存','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('132','User','admin_url','user/indexadmin/default','','会员系统','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('133','User','admin_url','user/indexadmin/default1','','用户组','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('134','User','admin_url','user/indexadmin/index','','学员管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('135','User','admin_url','user/indexadmin/ban','','拉黑会员','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('136','User','admin_url','user/indexadmin/cancelban','','启用会员','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('137','User','admin_url','user/oauthadmin/index','','第三方用户','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('138','User','admin_url','user/oauthadmin/delete','','第三方用户解绑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('139','User','admin_url','user/indexadmin/default3','','管理组','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('140','Admin','admin_url','admin/rbac/index','','角色管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('141','Admin','admin_url','admin/rbac/member','','成员管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('142','Admin','admin_url','admin/rbac/authorize','','权限设置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('143','Admin','admin_url','admin/rbac/authorize_post','','提交设置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('144','Admin','admin_url','admin/rbac/roleedit','','编辑角色','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('145','Admin','admin_url','admin/rbac/roleedit_post','','提交编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('146','Admin','admin_url','admin/rbac/roledelete','','删除角色','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('147','Admin','admin_url','admin/rbac/roleadd','','添加角色','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('148','Admin','admin_url','admin/rbac/roleadd_post','','提交添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('149','Admin','admin_url','admin/user/index','','管理员','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('150','Admin','admin_url','admin/user/delete','','删除管理员','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('151','Admin','admin_url','admin/user/edit','','管理员编辑','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('152','Admin','admin_url','admin/user/edit_post','','编辑提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('153','Admin','admin_url','admin/user/add','','管理员添加','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('154','Admin','admin_url','admin/user/add_post','','添加提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('155','Admin','admin_url','admin/plugin/update','','插件更新','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('156','Course','admin_url','course/admincoursetype/label','','标签管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('157','Course','admin_url','course/adminlabel/index','','标签管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('158','Admin','admin_url','admin/setting/alipay','','支付宝配置','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('159','Admin','admin_url','admin/adminorder/index','','订单管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('160','Course','admin_url','course/adminorder/index','','订单列表','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('161','Teacher','admin_url','teacher/center/index','','教师管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('162','Teacher','admin_url','teacher/admincenter/index','','教师管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('163','Admin','admin_url','admin/course/index','','课程系统','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('164','Course','admin_url','course/admincoursetype/index','','分类管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('165','Course','admin_url','course/admincourse/index','','课程管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('166','Course','admin_url','course/adminsection/index','','课时管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('167','Card','admin_url','card/admincard/index','','点卡系统','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('168','Admin','admin_url','admin/storage/index','','文件存储','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('169','Admin','admin_url','admin/storage/setting_post','','文件存储设置提交','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('170','User','admin_url','user/center/index','','学员管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('171','User','admin_url','user/center/indexadmin','','学员管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('172','Exam','admin_url','exam/index/default','','考试系统','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('173','Exam','admin_url','exam/exam_shiti/index','','试题管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('174','Exam','admin_url','exam/exam_kaoshi/index','','考试管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('175','Exam','admin_url','exam/shiti/index','','试题管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('176','Exam','admin_url','exam/kaoshi/index','','考试管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('178','Exam','admin_url','exam/shiti/default','','考试系统','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('179','Exam','admin_url','exam/shiti/shitilist','','试题管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('180','Exam','admin_url','exam/shiti/shijuan','','试卷管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('181','Exam','admin_url','exam/adminshiti/shitilist','','试题管理','1','');
INSERT INTO yxt_auth_rule ( `id`, `module`, `type`, `name`, `param`, `title`, `status`, `condition` ) VALUES  ('182','Exam','admin_url','exam/adminshiti/shijuan','','试卷管理','1','');
DROP TABLE IF EXISTS `yxt_card`;
CREATE TABLE `yxt_card` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `card_state` int(2) NOT NULL DEFAULT '0',
  `type_id` int(2) DEFAULT NULL,
  `card_price` int(5) DEFAULT NULL,
  `card_name` varchar(20) DEFAULT NULL,
  `card_pass` varchar(10) DEFAULT NULL,
  `cs_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `use_state` int(2) NOT NULL DEFAULT '0',
  `sale_state` int(2) NOT NULL DEFAULT '0',
  `viptime` int(5) NOT NULL DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('1','0','1','20','PYJY6S4J24M4NK7','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('2','0','1','20','BEJWRF9VCWS72B9','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('3','0','1','20','KXFY6TPQ4DJSU28','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('4','0','1','20','E4VWXQXYYKEP5DN','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('5','0','1','20','HQRYKEGZBNU9ZHV','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('6','0','1','20','ERR37CTVPWRT2EE','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('7','0','1','20','6592W2YHXEZRPRU','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('8','0','1','20','JAC2QVHE7JURB6F','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('9','0','1','20','5BYAS8M3EMHJVWA','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('10','0','1','20','W5F2UR65X7UBQQV','','0','0','0','0','0','2016-11-27 14:02:42');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('11','0','2','10','5DXJFAHEVMVHX25','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('12','0','2','10','KDUJYG3YMQEFK4X','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('13','0','2','10','6QDAUH54WYE8DKN','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('14','0','2','10','94NNB78UDRCS4S7','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('15','0','2','10','WWJBJGSKK4RMRQV','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('16','0','2','10','PMVDVC5ZY9ZY9PU','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('17','0','2','10','PD863VBU3B5PD7F','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('18','0','2','10','TP5F7WED997M4UV','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('19','0','2','10','99Y75B9VQ2JZXVB','','1','0','0','0','0','2016-11-27 14:03:02');
INSERT INTO yxt_card ( `id`, `card_state`, `type_id`, `card_price`, `card_name`, `card_pass`, `cs_id`, `user_id`, `use_state`, `sale_state`, `viptime`, `addtime` ) VALUES  ('20','0','2','10','JPDK6YAT6KUPQ3B','','1','2','1','0','0','2016-11-27 14:03:02');
DROP TABLE IF EXISTS `yxt_cardtype`;
CREATE TABLE `yxt_cardtype` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `typename` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_chatmsg`;
CREATE TABLE `yxt_chatmsg` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `time` int(15) DEFAULT NULL,
  `sender` varchar(20) DEFAULT NULL,
  `pic` varchar(225) DEFAULT NULL,
  `timee` datetime DEFAULT NULL,
  `cs_id` int(6) DEFAULT NULL,
  `channel_id` varchar(40) DEFAULT NULL,
  `uid` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_comments`;
CREATE TABLE `yxt_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_table` varchar(100) NOT NULL COMMENT '评论内容所在表，不带表前缀',
  `post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL COMMENT '原文地址',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_uid` int(11) NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `full_name` varchar(50) DEFAULT NULL COMMENT '评论者昵称',
  `email` varchar(255) DEFAULT NULL COMMENT '评论者邮箱',
  `createtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text NOT NULL COMMENT '评论内容',
  `type` smallint(1) NOT NULL DEFAULT '1' COMMENT '评论类型；1实名评论',
  `parentid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `path` varchar(500) DEFAULT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '状态，1已审核，0未审核',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`post_id`),
  KEY `comment_approved_date_gmt` (`status`),
  KEY `comment_parent` (`parentid`),
  KEY `table_id_status` (`post_table`,`post_id`,`status`),
  KEY `createtime` (`createtime`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_common_action_log`;
CREATE TABLE `yxt_common_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) DEFAULT '0' COMMENT '用户id',
  `object` varchar(100) DEFAULT NULL COMMENT '访问对象的id,格式：不带前缀的表名+id;如posts1表示xx_posts表里id为1的记录',
  `action` varchar(50) DEFAULT NULL COMMENT '操作名称；格式规定为：应用名+控制器+操作名；也可自己定义格式只要不发生冲突且惟一；',
  `count` int(11) DEFAULT '0' COMMENT '访问次数',
  `last_time` int(11) DEFAULT '0' COMMENT '最后访问的时间戳',
  `ip` varchar(15) DEFAULT NULL COMMENT '访问者最后访问ip',
  PRIMARY KEY (`id`),
  KEY `user_object_action` (`user`,`object`,`action`),
  KEY `user_object_action_ip` (`user`,`object`,`action`,`ip`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_config`;
CREATE TABLE `yxt_config` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` int(2) DEFAULT NULL,
  `alipaycount` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `pid` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `key` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `AppId` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `SecretId` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `SecretKey` varchar(30) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_course`;
CREATE TABLE `yxt_course` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(50) DEFAULT NULL,
  `ty_id` int(5) DEFAULT NULL,
  `cs_teacher` int(5) DEFAULT NULL,
  `cs_addtime` datetime DEFAULT NULL,
  `cs_state` int(2) DEFAULT NULL,
  `is_tuijian` int(2) DEFAULT NULL,
  `cs_price` int(5) DEFAULT NULL,
  `cs_picture` varchar(200) DEFAULT NULL,
  `listorder` int(10) DEFAULT NULL,
  `sec_numbers` int(5) DEFAULT NULL,
  `cs_xuni` int(5) DEFAULT NULL,
  `cs_brief` text,
  `top_id` int(5) DEFAULT NULL,
  `mubiao` text,
  `shihe` varchar(200) DEFAULT NULL,
  `labelid` int(2) DEFAULT NULL,
  `stu_numbers` int(5) DEFAULT NULL,
  `course_type` varchar(10) DEFAULT NULL,
  `isover` int(2) DEFAULT '0',
  `youxiaoqi` int(5) DEFAULT '90',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_course ( `id`, `cs_name`, `ty_id`, `cs_teacher`, `cs_addtime`, `cs_state`, `is_tuijian`, `cs_price`, `cs_picture`, `listorder`, `sec_numbers`, `cs_xuni`, `cs_brief`, `top_id`, `mubiao`, `shihe`, `labelid`, `stu_numbers`, `course_type`, `isover`, `youxiaoqi` ) VALUES  ('1','管理员使用教程','2','2','2016-11-09 19:30:52','1','1','0','/data/upload/20161109/582308bb353af.png','0','5','0','<p>通过本课程的学习，网站管理员可以快速的了解此系统，快速的建立自己的网校！</p>','1',' 使用易学堂CMF，快速建立自己的在线培训系统！','初次使用易学堂CMF的站长，对易学堂CMF不是很熟悉的站长。','0','0','doc','0','90');
INSERT INTO yxt_course ( `id`, `cs_name`, `ty_id`, `cs_teacher`, `cs_addtime`, `cs_state`, `is_tuijian`, `cs_price`, `cs_picture`, `listorder`, `sec_numbers`, `cs_xuni`, `cs_brief`, `top_id`, `mubiao`, `shihe`, `labelid`, `stu_numbers`, `course_type`, `isover`, `youxiaoqi` ) VALUES  ('2','教师使用教程','3','2','2016-11-09 19:32:00','1','1','9','/data/upload/20161109/5823092dbd958.jpg','0','5','10','','1','学习如何使用CMF系统发布课程，发布考试等！','初次只用系统的教师或是对系统不熟悉的教师！','0','0','doc','0','90');
INSERT INTO yxt_course ( `id`, `cs_name`, `ty_id`, `cs_teacher`, `cs_addtime`, `cs_state`, `is_tuijian`, `cs_price`, `cs_picture`, `listorder`, `sec_numbers`, `cs_xuni`, `cs_brief`, `top_id`, `mubiao`, `shihe`, `labelid`, `stu_numbers`, `course_type`, `isover`, `youxiaoqi` ) VALUES  ('3','视频课程测试','3','2','2016-11-09 19:41:16','1','1','9','/data/upload/20161118/582f09934a214.jpg','0','3','10','','1','测试视频课程','测试视频课程','0','0','normal','0','30');
INSERT INTO yxt_course ( `id`, `cs_name`, `ty_id`, `cs_teacher`, `cs_addtime`, `cs_state`, `is_tuijian`, `cs_price`, `cs_picture`, `listorder`, `sec_numbers`, `cs_xuni`, `cs_brief`, `top_id`, `mubiao`, `shihe`, `labelid`, `stu_numbers`, `course_type`, `isover`, `youxiaoqi` ) VALUES  ('6','直播课程','2','2','2016-11-27 14:35:57','1','','0','','','1','','','1','学习直播课程','站长','','','live','0','90');
DROP TABLE IF EXISTS `yxt_coursetype`;
CREATE TABLE `yxt_coursetype` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `slug` varchar(200) DEFAULT '',
  `description` longtext COMMENT '分类描述',
  `parent` bigint(20) unsigned DEFAULT '0' COMMENT '分类父id',
  `count` bigint(20) DEFAULT '0' COMMENT '分类文章数',
  `path` varchar(500) DEFAULT NULL COMMENT '分类层级关系路径',
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `listorder` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`term_id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_coursetype ( `term_id`, `name`, `slug`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `status` ) VALUES  ('1','使用帮助','','','0','0','0-1','','','','0','1');
INSERT INTO yxt_coursetype ( `term_id`, `name`, `slug`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `status` ) VALUES  ('2','我是管理员','','','1','0','0-1-2','','','','0','1');
INSERT INTO yxt_coursetype ( `term_id`, `name`, `slug`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `status` ) VALUES  ('3','我是教师','','','1','0','0-1-3','','','','0','1');
INSERT INTO yxt_coursetype ( `term_id`, `name`, `slug`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `status` ) VALUES  ('4','我是学生','','','1','0','0-1-4','','','','0','1');
DROP TABLE IF EXISTS `yxt_exam_baoming`;
CREATE TABLE `yxt_exam_baoming` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL COMMENT '用户姓名',
  `userid` int(7) DEFAULT NULL,
  `top_id` int(6) DEFAULT '0' COMMENT '一级目录',
  `type_id` int(6) DEFAULT '0' COMMENT '二级目录',
  `sex` int(2) DEFAULT '0' COMMENT '1男，2女',
  `idnumber` varchar(20) DEFAULT '0' COMMENT '身份证',
  `mobilephone` varchar(13) DEFAULT '0' COMMENT '手机号',
  `fixedphone` varchar(13) DEFAULT '0' COMMENT '固定电话',
  `qq` varchar(13) DEFAULT '0' COMMENT 'qq号',
  `patriarchal` varchar(10) DEFAULT '0' COMMENT '家长姓名',
  `patriarchalphone` varchar(13) DEFAULT '0' COMMENT '家长电话',
  `addtime` datetime DEFAULT NULL,
  `chinese` int(11) DEFAULT NULL COMMENT '语文成绩',
  `maths` int(11) DEFAULT NULL COMMENT '数学成绩',
  `english` int(11) DEFAULT NULL COMMENT '外语成绩',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_exam_kemu`;
CREATE TABLE `yxt_exam_kemu` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `kemu` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_exam_myerrors`;
CREATE TABLE `yxt_exam_myerrors` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(8) DEFAULT NULL,
  `shitiid` longtext,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_exam_papers`;
CREATE TABLE `yxt_exam_papers` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cs_id` int(6) DEFAULT NULL,
  `teacherid` int(2) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `limitedTime` int(4) DEFAULT '0',
  `single_choice_id` longtext,
  `single_choice_score` int(3) DEFAULT NULL,
  `fill_id` longtext,
  `fill_score` int(3) DEFAULT NULL,
  `determine_id` longtext,
  `determine_score` int(3) DEFAULT NULL,
  `essay_id` longtext,
  `essay_score` int(3) DEFAULT NULL,
  `material_id` longtext,
  `material_score` int(3) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_exam_papers ( `id`, `cs_id`, `teacherid`, `title`, `limitedtime`, `single_choice_id`, `single_choice_score`, `fill_id`, `fill_score`, `determine_id`, `determine_score`, `essay_id`, `essay_score`, `material_id`, `material_score`, `addtime`, `state` ) VALUES  ('2','1','2','管理员使用教程','15','1,2,3','5','4,5,6','5','7,8,9','5','10,11,12','5','','0','2016-11-09 21:42:46','0');
DROP TABLE IF EXISTS `yxt_exam_shiti`;
CREATE TABLE `yxt_exam_shiti` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `cs_id` int(4) DEFAULT '0',
  `typeid` int(4) DEFAULT '0',
  `teacherid` int(5) DEFAULT '0',
  `uncertain` int(1) DEFAULT '0',
  `stem` varchar(800) DEFAULT '0',
  `xa` varchar(800) DEFAULT '0',
  `xb` varchar(800) DEFAULT '0',
  `xc` varchar(800) DEFAULT '0',
  `xd` varchar(800) DEFAULT '0',
  `daan` text,
  `analysis` text,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('1','1','1','2','0','<p>易学堂CMF的官方网站是什么？</p>','<p>www.yxtcmf.com</p>','<p>www.ruisi365.com</p>','<p>demo.yxtcmf.com</p>','<p>teach.yxtcmf.com</p>','a,','<p>易学堂的官方网站是www.yxtcmf.com</p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('2','1','1','2','0','<p>易学堂CMF的demo网址是什么？</p>','<p>www.yxtcmf.com &nbsp; &nbsp;</p>','<p>demo.yxtcmf.com</p>','<p>www.ruisi365.com</p>','<p>teach.yxtcmf.com</p>','b,','<p>易学堂的demo网址是demo.yxtcmf.com</p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('3','1','1','2','0','<p>易学堂CMF的教学网址是什么？</p>','<p>www.yxtcmf.com</p>','<p>www.ruisi365.com</p>','<p>demo.yxtcmf.com</p>','<p>teach.yxtcmf.com</p>','d,','<p>易学堂CMF的教学网址是teach.yxtcmf.com</p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('4','1','2','2','0','<p>易学堂CMF是一个yxt____系统</p>','0','0','0','0','<p><strong><p>在线教学</p></strong></p>','<p><strong><p>在线教学</p></strong></p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('5','1','2','2','0','<p>易学堂CMF是用yxt__语言编写的</p>','0','0','0','0','<p><strong><p>php+mysql</p></strong></p>','<p><strong><p>php+mysql</p></strong></p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('6','1','2','2','0','<p>易学堂CMF使用的是yxt___短信验证码平台。</p>','0','0','0','0','<p><strong><p>阿里大于</p></strong></p>','<p><strong><p>阿里大于</p></strong></p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('7','1','3','2','0','<p>易学堂CMF是属于企业开发的</p>','0','0','0','0','1','<p>易学堂CMF是属于个人开发。</p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('8','1','3','2','0','<p>易学堂CMF是用thinkphp 框架编写的一个在线学习平台</p>','0','0','0','0','1','<p>易学堂CMF是用thinkphp 框架编写的一个在线学习平台</p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('9','1','3','2','0','<p>易学堂CMF没有直播功能</p>','0','0','0','0','2','<p>易学堂CMF集成了腾讯直播和万视无忧直播</p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('10','1','4','2','0','<p>易学堂CMF是做什么的？</p>','0','0','0','0','<p><strong><p>帮助培训机构和个人以最低成本、最快速度建立自己的在线教学网站，无需担心技术问题。</p></strong></p>','<p><strong><p>帮助培训机构和个人以最低成本、最快速度建立自己的在线教学网站，无需担心技术问题。</p></strong></p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('11','1','4','2','0','<p>想搭建网校，需要哪些资源？</p>','0','0','0','0','<p><strong><p></p></strong><p>想搭建网校，1、域名，2、主机空间（可以是虚拟主机，可以是vps，也可以是独立服务器，这IDC厂商出购买，建议用云主机，腾讯云云主机，阿里云主机等都是不错的选择），3、系统平台，也就是YxtCMF源码。还有就是腾讯云的云存储cos（可以到腾讯云获取，一个月免费50G,网站流量不大的话，绰绰有余），若是用直播功能的话，还需要腾讯云的直播服务</p><strong><p></p></strong></p>','<p><strong><p></p></strong><p>想搭建网校，1、域名，2、主机空间（可以是虚拟主机，可以是vps，也可以是独立服务器，这IDC厂商出购买，建议用云主机，腾讯云云主机，阿里云主机等都是不错的选择），3、系统平台，也就是YxtCMF源码。还有就是腾讯云的云存储cos（可以到腾讯云获取，一个月免费50G,网站流量不大的话，绰绰有余），若是用直播功能的话，还需要腾讯云的直播服务</p></p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('12','1','4','2','0','<p>易学堂CMF集成了哪些第三方云存储？</p>','0','0','0','0','<p><strong><p></p></strong><p>腾讯云COS和万视无忧云视频</p><strong><p></p></strong></p>','<p><strong><p></p></strong><p>腾讯云COS和万视无忧云视频</p><strong><p></p></strong></p>');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('14','3','1','2','0','测试导入选择','a','b','c','d','a','试题分析');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('15','3','2','2','0','测试导入填空','','','','','测试导入填空答案','试题分析');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('16','3','3','2','0','测试导入判断','','','','','测试导入判断答案','试题分析');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('17','3','4','2','0','测试导入解答','','','','','测试导入解答答案','试题分析');
INSERT INTO yxt_exam_shiti ( `id`, `cs_id`, `typeid`, `teacherid`, `uncertain`, `stem`, `xa`, `xb`, `xc`, `xd`, `daan`, `analysis` ) VALUES  ('18','3','5','2','0','测试导入材料','','','','','测试导入材料答案','试题分析');
DROP TABLE IF EXISTS `yxt_exam_shitidone`;
CREATE TABLE `yxt_exam_shitidone` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `userid` int(8) DEFAULT NULL,
  `shitiid` longtext,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_exam_shitidone ( `id`, `userid`, `shitiid` ) VALUES  ('1','2','[\"2\",\"14\"]');
DROP TABLE IF EXISTS `yxt_exam_tixing`;
CREATE TABLE `yxt_exam_tixing` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `tixing` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_exam_userpapers`;
CREATE TABLE `yxt_exam_userpapers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `userid` int(8) DEFAULT NULL,
  `teacherid` int(6) DEFAULT NULL,
  `papersid` int(8) DEFAULT NULL,
  `choice` longtext,
  `fill` longtext,
  `determine` longtext,
  `essay` longtext,
  `material` longtext,
  `choicescore` int(3) DEFAULT '0',
  `fillscore` longtext,
  `determinescore` int(3) DEFAULT '0',
  `essayscore` longtext,
  `materialscore` longtext,
  `score` int(3) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `readover` int(2) DEFAULT '0',
  `chacktime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_forum_plate`;
CREATE TABLE `yxt_forum_plate` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `pic` varchar(100) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  `brief` varchar(200) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_forum_plate ( `id`, `name`, `pic`, `brief` ) VALUES  ('1','管理员专区','/data/upload/20161129/583d2d11d94f3.png','<p>管理员专区，各网站负责人，管理员可以来这里交流。</p>');
INSERT INTO yxt_forum_plate ( `id`, `name`, `pic`, `brief` ) VALUES  ('2','教师专区','/data/upload/20161129/583d2d47420ff.png','<p>教师在发布课程，课件，考试中遇到的问题，可以来这里交流！</p>');
INSERT INTO yxt_forum_plate ( `id`, `name`, `pic`, `brief` ) VALUES  ('3','学员专区','/data/upload/20161129/583d2d3093671.png','<p>学员交流聚集地，广交天下朋友！</p>');
DROP TABLE IF EXISTS `yxt_forum_praisal`;
CREATE TABLE `yxt_forum_praisal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `replyid` int(11) DEFAULT NULL,
  `topicid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_forum_reply`;
CREATE TABLE `yxt_forum_reply` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `topicid` int(5) DEFAULT NULL,
  `userid` int(8) DEFAULT NULL,
  `content` longtext,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_forum_reply ( `id`, `topicid`, `userid`, `content`, `addtime` ) VALUES  ('1','3','2','<p>http://teach.yxtcmf.com/index.php?g=course&amp;m=course&amp;a=study&amp;id=3</p>','2016-10-16 22:21:17');
INSERT INTO yxt_forum_reply ( `id`, `topicid`, `userid`, `content`, `addtime` ) VALUES  ('2','1','2','<p>开源，分为免费版和域名授权版，这两者的区别请参看官网说明http://www.yxtcmf.com/index.php/portal/list/baojia.shtml</p>','2016-10-17 17:06:31');
DROP TABLE IF EXISTS `yxt_forum_topic`;
CREATE TABLE `yxt_forum_topic` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `plateid` int(3) DEFAULT NULL,
  `userid` int(8) DEFAULT NULL,
  `topictltle` varchar(50) DEFAULT NULL,
  `topiccontent` longtext,
  `addtime` datetime DEFAULT NULL,
  `replytime` datetime DEFAULT NULL,
  `hits` int(7) DEFAULT '0',
  `istop` int(2) DEFAULT '0',
  `iscream` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_forum_topic ( `id`, `plateid`, `userid`, `topictltle`, `topiccontent`, `addtime`, `replytime`, `hits`, `istop`, `iscream` ) VALUES  ('1','1','4','系统是开源的吗，免费使用吗？','<p>系统是开源的吗，免费使用吗？做的不错，很想用！<br/></p>','2016-10-16 09:28:46','2016-11-09 17:26:39','82','1','1');
INSERT INTO yxt_forum_topic ( `id`, `plateid`, `userid`, `topictltle`, `topiccontent`, `addtime`, `replytime`, `hits`, `istop`, `iscream` ) VALUES  ('3','1','4','如何开通云视频功能','<p>如何开通云视频功能？</p>','2016-10-16 09:30:28','2016-10-16 22:21:17','45','1','1');
DROP TABLE IF EXISTS `yxt_guestbook`;
CREATE TABLE `yxt_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL COMMENT '留言者姓名',
  `email` varchar(100) NOT NULL COMMENT '留言者邮箱',
  `title` varchar(255) DEFAULT NULL COMMENT '留言标题',
  `msg` text NOT NULL COMMENT '留言内容',
  `createtime` datetime NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_label`;
CREATE TABLE `yxt_label` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `c_id` int(2) DEFAULT NULL,
  `labelname` varchar(50) DEFAULT NULL,
  `listorder` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_links`;
CREATE TABLE `yxt_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL COMMENT '友情链接地址',
  `link_name` varchar(255) NOT NULL COMMENT '友情链接名称',
  `link_image` varchar(255) DEFAULT NULL COMMENT '友情链接图标',
  `link_target` varchar(25) NOT NULL DEFAULT '_blank' COMMENT '友情链接打开方式',
  `link_description` text NOT NULL COMMENT '友情链接描述',
  `link_status` int(2) NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接评级',
  `link_rel` varchar(255) DEFAULT '',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_status`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_links ( `link_id`, `link_url`, `link_name`, `link_image`, `link_target`, `link_description`, `link_status`, `link_rating`, `link_rel`, `listorder` ) VALUES  ('1','http://www.yxtcmf.com','易学堂官网','','_blank','易学堂官网','1','0','','0');
DROP TABLE IF EXISTS `yxt_live`;
CREATE TABLE `yxt_live` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `channelname` varchar(100) DEFAULT NULL,
  `outputsourcetype` int(2) DEFAULT NULL,
  `playerpassword` varchar(20) DEFAULT NULL,
  `upstream_address` varchar(200) DEFAULT NULL,
  `channelid` varchar(25) DEFAULT NULL,
  `appid` varchar(15) DEFAULT NULL,
  `sectionid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_live ( `id`, `channelname`, `outputsourcetype`, `playerpassword`, `upstream_address`, `channelid`, `appid`, `sectionid` ) VALUES  ('1','直播课程测试','3','','rtmp://3978.livepush.myqcloud.com/live/3978_988ce9d0b05a11e69776e435c87f075e?bizid=3978','9896587163623775892','','8');
INSERT INTO yxt_live ( `id`, `channelname`, `outputsourcetype`, `playerpassword`, `upstream_address`, `channelid`, `appid`, `sectionid` ) VALUES  ('2','直播课程测试','3','','rtmp://3978.livepush.myqcloud.com/live/3978_dc9c9e8cb46b11e69776e435c87f075e?bizid=3978','9896587163625708852','','20');
DROP TABLE IF EXISTS `yxt_material`;
CREATE TABLE `yxt_material` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cs_id` int(10) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `url` varchar(600) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `sc_id` int(10) DEFAULT NULL,
  `downname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_menu`;
CREATE TABLE `yxt_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `app` char(20) NOT NULL COMMENT '应用名称app',
  `model` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '操作名称',
  `data` char(50) NOT NULL COMMENT '额外参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`),
  KEY `model` (`model`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('1','0','Admin','Content','default','','0','1','文章系统','th','','20');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('7','1','Portal','AdminPost','index','','1','1','文章管理','','','1');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('8','7','Portal','AdminPost','listorders','','1','0','文章排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('9','7','Portal','AdminPost','top','','1','0','文章置顶','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('10','7','Portal','AdminPost','recommend','','1','0','文章推荐','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('11','7','Portal','AdminPost','move','','1','0','批量移动','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('12','7','Portal','AdminPost','check','','1','0','文章审核','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('13','7','Portal','AdminPost','delete','','1','0','删除文章','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('14','7','Portal','AdminPost','edit','','1','0','编辑文章','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('15','14','Portal','AdminPost','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('16','7','Portal','AdminPost','add','','1','0','添加文章','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('17','16','Portal','AdminPost','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('18','1','Portal','AdminTerm','index','','0','1','分类管理','','','2');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('19','18','Portal','AdminTerm','listorders','','1','0','文章分类排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('20','18','Portal','AdminTerm','delete','','1','0','删除分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('21','18','Portal','AdminTerm','edit','','1','0','编辑分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('22','21','Portal','AdminTerm','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('23','18','Portal','AdminTerm','add','','1','0','添加分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('24','23','Portal','AdminTerm','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('25','1','Portal','AdminPage','index','','1','1','页面管理','','','3');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('26','25','Portal','AdminPage','listorders','','1','0','页面排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('27','25','Portal','AdminPage','delete','','1','0','删除页面','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('28','25','Portal','AdminPage','edit','','1','0','编辑页面','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('29','28','Portal','AdminPage','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('30','25','Portal','AdminPage','add','','1','0','添加页面','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('31','30','Portal','AdminPage','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('32','1','Admin','Recycle','default','','1','1','回收站','','','4');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('33','32','Portal','AdminPost','recyclebin','','1','1','文章回收','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('34','33','Portal','AdminPost','restore','','1','0','文章还原','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('35','33','Portal','AdminPost','clean','','1','0','彻底删除','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('36','32','Portal','AdminPage','recyclebin','','1','1','页面回收','','','1');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('37','36','Portal','AdminPage','clean','','1','0','彻底删除','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('38','36','Portal','AdminPage','restore','','1','0','页面还原','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('39','0','Admin','Extension','default','','0','1','扩展工具','cloud','','40');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('40','39','Admin','Backup','default','','1','1','备份管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('41','40','Admin','Backup','restore','','1','1','数据还原','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('42','40','Admin','Backup','index','','1','1','数据备份','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('43','42','Admin','Backup','index_post','','1','0','提交数据备份','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('44','40','Admin','Backup','download','','1','0','下载备份','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('45','40','Admin','Backup','del_backup','','1','0','删除备份','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('46','40','Admin','Backup','import','','1','0','数据备份导入','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('47','39','Admin','Plugin','index','','1','0','插件管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('48','47','Admin','Plugin','toggle','','1','0','插件启用切换','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('49','47','Admin','Plugin','setting','','1','0','插件设置','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('50','49','Admin','Plugin','setting_post','','1','0','插件设置提交','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('51','47','Admin','Plugin','install','','1','0','插件安装','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('52','47','Admin','Plugin','uninstall','','1','0','插件卸载','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('53','39','Admin','Slide','default','','1','1','幻灯片','','','1');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('54','53','Admin','Slide','index','','1','1','幻灯片管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('55','54','Admin','Slide','listorders','','1','0','幻灯片排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('56','54','Admin','Slide','toggle','','1','0','幻灯片显示切换','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('57','54','Admin','Slide','delete','','1','0','删除幻灯片','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('58','54','Admin','Slide','edit','','1','0','编辑幻灯片','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('59','58','Admin','Slide','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('60','54','Admin','Slide','add','','1','0','添加幻灯片','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('61','60','Admin','Slide','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('62','53','Admin','Slidecat','index','','1','1','幻灯片分类','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('63','62','Admin','Slidecat','delete','','1','0','删除分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('64','62','Admin','Slidecat','edit','','1','0','编辑分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('65','64','Admin','Slidecat','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('66','62','Admin','Slidecat','add','','1','0','添加分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('67','66','Admin','Slidecat','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('85','0','Admin','Menu','default','','1','1','菜单管理','list','','30');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('86','85','Admin','Navcat','default1','','1','1','前台菜单','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('87','86','Admin','Nav','index','','1','1','菜单管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('88','87','Admin','Nav','listorders','','1','0','前台导航排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('89','87','Admin','Nav','delete','','1','0','删除菜单','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('90','87','Admin','Nav','edit','','1','0','编辑菜单','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('91','90','Admin','Nav','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('92','87','Admin','Nav','add','','1','0','添加菜单','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('93','92','Admin','Nav','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('94','86','Admin','Navcat','index','','1','1','菜单分类','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('95','94','Admin','Navcat','delete','','1','0','删除分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('96','94','Admin','Navcat','edit','','1','0','编辑分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('97','96','Admin','Navcat','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('98','94','Admin','Navcat','add','','1','0','添加分类','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('99','98','Admin','Navcat','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('100','85','Admin','Menu','index','','1','1','后台菜单','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('101','100','Admin','Menu','add','','1','0','添加菜单','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('102','101','Admin','Menu','add_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('103','100','Admin','Menu','listorders','','1','0','后台菜单排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('104','100','Admin','Menu','export_menu','','1','0','菜单备份','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('105','100','Admin','Menu','edit','','1','0','编辑菜单','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('106','105','Admin','Menu','edit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('107','100','Admin','Menu','delete','','1','0','删除菜单','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('108','100','Admin','Menu','lists','','1','0','所有菜单','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('109','0','Admin','Setting','default','','0','1','系统设置','cogs','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('110','109','Admin','Setting','userdefault','','0','1','个人信息','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('111','110','Admin','User','userinfo','','1','1','修改信息','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('112','111','Admin','User','userinfo_post','','1','0','修改信息提交','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('113','110','Admin','Setting','password','','1','1','修改密码','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('114','113','Admin','Setting','password_post','','1','0','提交修改','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('115','109','Admin','Setting','site','','1','1','网站信息','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('116','115','Admin','Setting','site_post','','1','0','提交修改','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('117','115','Admin','Route','index','','1','0','路由列表','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('118','115','Admin','Route','add','','1','0','路由添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('119','118','Admin','Route','add_post','','1','0','路由添加提交','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('120','115','Admin','Route','edit','','1','0','路由编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('121','120','Admin','Route','edit_post','','1','0','路由编辑提交','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('122','115','Admin','Route','delete','','1','0','路由删除','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('123','115','Admin','Route','ban','','1','0','路由禁止','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('124','115','Admin','Route','open','','1','0','路由启用','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('125','115','Admin','Route','listorders','','1','0','路由排序','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('221','132','User','Indexadmin','index','','1','1','学员管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('131','109','Admin','Setting','clearcache','','1','1','清除缓存','','','1');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('132','0','User','Indexadmin','default','','1','1','会员系统','group','','10');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('139','132','User','Indexadmin','default3','','1','1','管理组','','','1');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('140','139','Admin','Rbac','index','','1','1','角色管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('141','140','Admin','Rbac','member','','1','0','成员管理','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('142','140','Admin','Rbac','authorize','','1','0','权限设置','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('143','142','Admin','Rbac','authorize_post','','1','0','提交设置','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('144','140','Admin','Rbac','roleedit','','1','0','编辑角色','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('145','144','Admin','Rbac','roleedit_post','','1','0','提交编辑','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('146','140','Admin','Rbac','roledelete','','1','1','删除角色','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('147','140','Admin','Rbac','roleadd','','1','1','添加角色','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('148','147','Admin','Rbac','roleadd_post','','1','0','提交添加','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('149','139','Admin','User','index','','1','1','管理员','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('150','149','Admin','User','delete','','1','0','删除管理员','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('151','149','Admin','User','edit','','1','0','管理员编辑','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('152','151','Admin','User','edit_post','','1','0','编辑提交','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('153','149','Admin','User','add','','1','0','管理员添加','','','1000');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('154','153','Admin','User','add_post','','1','0','添加提交','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('155','47','Admin','Plugin','update','','1','0','插件更新','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('158','0','Admin','Course','index','','0','1','课程系统','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('159','158','Course','AdminCoursetype','index','','1','1','分类管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('160','158','Course','AdminCourse','index','','1','1','课程管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('161','158','Course','AdminSection','index','','1','1','课时管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('165','158','Card','AdminCard','index','','1','1','点卡系统','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('166','158','Course','AdminLabel','index','','1','1','标签管理','','','1');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('167','0','Admin','AdminOrder','index','','1','1','订单管理','money','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('168','167','Course','AdminOrder','index','','1','1','订单列表','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('169','132','Teacher','AdminCenter','index','','1','1','教师管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('225','109','Admin','Setting','updata','','1','1','系统升级','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('226','0','Exam','shiti','default','','1','1','考试系统','clipboard','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('227','226','Exam','AdminShiti','shitilist','','1','1','试题管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('228','226','Exam','AdminShiti','shijuan','','1','1','试卷管理','','','0');
INSERT INTO yxt_menu ( `id`, `parentid`, `app`, `model`, `action`, `data`, `type`, `status`, `name`, `icon`, `remark`, `listorder` ) VALUES  ('229','39','Admin','Link','index','','1','1','友情链接','','','0');
DROP TABLE IF EXISTS `yxt_nav`;
CREATE TABLE `yxt_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `target` varchar(50) DEFAULT NULL,
  `href` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(6) DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('5','2','0','我是教师','','on','','1','1','0-5');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('4','1','0','关于我们','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"1\";}}','','1','2','0-4');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('8','2','5','成为教师','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:2:\"15\";}}','','1','0','0-5-8');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('7','2','5','发布课程','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:2:\"21\";}}','','1','0','0-5-7');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('9','2','5','收益提成','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-5-9');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('10','2','0','我是学生','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-10');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('11','2','10','如何注册','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:2:\"21\";}}','','1','0','0-10-11');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('12','2','10','购买课程','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-10-12');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('13','2','10','如何学习','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-10-13');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('14','2','0','账户管理','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','2','0-14');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('15','2','14','系统设置','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-14-15');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('16','2','14','课程设置','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-14-16');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('17','2','14','用户管理','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-14-17');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('18','2','0','加盟网上学院','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','3','0-18');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('19','2','18','招商加盟','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-18-19');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('20','2','18','学习卡代理','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-18-20');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('21','2','18','入驻专家团队','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-18-21');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('22','2','0','关于我们','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','4','0-22');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('23','2','22','关于我们','','a:2:{s:6:\"action\";s:17:\"Portal/Page/index\";s:5:\"param\";a:1:{s:2:\"id\";s:1:\"2\";}}','','1','0','0-22-23');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('24','2','22','官方微博','','home','','1','0','0-22-24');
INSERT INTO yxt_nav ( `id`, `cid`, `parentid`, `label`, `target`, `href`, `icon`, `status`, `listorder`, `path` ) VALUES  ('25','2','22','加入我们','','home','','1','0','0-22-25');
DROP TABLE IF EXISTS `yxt_nav_cat`;
CREATE TABLE `yxt_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `remark` text,
  PRIMARY KEY (`navcid`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_nav_cat ( `navcid`, `name`, `active`, `remark` ) VALUES  ('1','主导航','1','主导航');
INSERT INTO yxt_nav_cat ( `navcid`, `name`, `active`, `remark` ) VALUES  ('2','底部导航','0','底部导航');
DROP TABLE IF EXISTS `yxt_oauth_user`;
CREATE TABLE `yxt_oauth_user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `from` varchar(20) NOT NULL COMMENT '用户来源key',
  `name` varchar(30) NOT NULL COMMENT '第三方昵称',
  `head_img` varchar(200) NOT NULL COMMENT '头像',
  `uid` int(20) NOT NULL COMMENT '关联的本站用户id',
  `create_time` datetime NOT NULL COMMENT '绑定时间',
  `last_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(16) NOT NULL COMMENT '最后登录ip',
  `login_times` int(6) NOT NULL COMMENT '登录次数',
  `status` tinyint(2) NOT NULL,
  `access_token` varchar(60) NOT NULL,
  `expires_date` int(12) NOT NULL COMMENT 'access_token过期时间',
  `openid` varchar(40) NOT NULL COMMENT '第三方用户id',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_options`;
CREATE TABLE `yxt_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_order`;
CREATE TABLE `yxt_order` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) DEFAULT NULL,
  `course_id` int(8) DEFAULT NULL,
  `order` varchar(20) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `total` int(5) DEFAULT NULL,
  `alipayorder` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_plugins`;
CREATE TABLE `yxt_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(50) NOT NULL COMMENT '插件名，英文',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '插件名称',
  `description` text COMMENT '插件描述',
  `type` tinyint(2) DEFAULT '0' COMMENT '插件类型, 1:网站；8;微信',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1开启；',
  `config` text COMMENT '插件配置',
  `hooks` varchar(255) DEFAULT NULL COMMENT '实现的钩子;以“，”分隔',
  `has_admin` tinyint(2) DEFAULT '0' COMMENT '插件是否有后台管理界面',
  `author` varchar(50) DEFAULT '' COMMENT '插件作者',
  `version` varchar(20) DEFAULT '' COMMENT '插件版本号',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `listorder` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_posts`;
CREATE TABLE `yxt_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned DEFAULT '0' COMMENT '发表者id',
  `post_keywords` varchar(150) NOT NULL COMMENT 'seo keywords',
  `post_date` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'post创建日期，永久不变，一般不显示给用户',
  `post_content` longtext COMMENT 'post内容',
  `post_title` text COMMENT 'post标题',
  `post_excerpt` text COMMENT 'post摘要',
  `post_status` int(2) DEFAULT '1' COMMENT 'post状态，1已审核，0未审核',
  `comment_status` int(2) DEFAULT '1' COMMENT '评论状态，1允许，0不允许',
  `post_modified` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'post更新时间，可在前台修改，显示给用户',
  `post_content_filtered` longtext,
  `post_parent` bigint(20) DEFAULT '0' COMMENT 'post的父级post id,表示post层级关系',
  `post_type` int(2) DEFAULT NULL,
  `post_mime_type` varchar(100) DEFAULT '',
  `comment_count` bigint(20) DEFAULT '0',
  `smeta` text COMMENT 'post的扩展字段，保存相关扩展属性，如缩略图；格式为json',
  `post_hits` int(11) DEFAULT '0' COMMENT 'post点击数，查看数',
  `post_like` int(11) DEFAULT '0' COMMENT 'post赞数',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
  `recommended` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐 1推荐 0不推荐',
  PRIMARY KEY (`id`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`id`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `post_date` (`post_date`) USING BTREE
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('1','1','关于我们','2016-11-09 16:40:52','<p><img src=\"/ueditor/php/upload/image/20161109/1478680849134424.jpg\" title=\"1478680849134424.jpg\" alt=\"1473949785109042.jpg\"/></p><p>这里是关于我们的内容</p>','关于我们','关于我们','1','1','2016-11-09 16:37:18','','0','2','','0','{\"template\":\"pagecontent\",\"thumb\":\"\"}','10','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('2','1','题集','2016-12-07 21:25:49','<p>以下推荐的题集未必是适合你的，不过有需要的话，可以去书店看看，对比选择。最适合自己的才是最好的哟。</p><p><strong>1.《高考必刷题》</strong><br/>它有合订本和专题本，都是高考题和各省模拟题。适合一轮复习，不过高三党现在基本快进入二轮了，看个人选择了。<br/>推荐科目：历史、地理。</p><p><strong>2.《十年高考》</strong></p><p><strong>3.《高考复习讲义》</strong><br/>据说很全能，由上百位名师编写的，搭配《十年高考》很适合基础差的童鞋。<br/>推荐科目：数学。<br/><br/><strong>4.《天利38套》or《龙门专题》</strong><br/>基础比较好的，这套也不错。<br/><br/>5.星火英语的语法书、新东方的《24天突破高考大纲词汇3500》。</p><p><br/><strong>6.《小甘》+《题霸》</strong><br/>推荐科目：文科，理科用这个貌似不怎么好用。</p><p><br/>7.薛金星《语文基础知识手册》基本人手一本。<br/><br/>8.《百题过大关》<br/>推荐科目：语文</p><p>9.王后雄系列</p><p>10.教材帮。特点是条理清晰，有题型分类，方便你集中吃透一种题型。</p><p>（本文内容仅做参考）</p><p><br/></p>','课外刷题一锅炖，哪些题集更适合你？','以下推荐的题集未必是适合你的，不过有需要的话，可以去书店看看，对比选择。最适合自己的才是最好的哟。','1','1','2016-12-07 21:25:10','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('3','1','','2016-12-07 21:26:42','<p><strong>生物一点都不难哟~~</strong></p><p><strong>看完这个你就明白，搞定课本上的知识，就基本搞定了生物。</strong></p><p><strong><img src=\"/ueditor/php/upload/image/20161207/1481117178603054.jpg\" alt=\"\"/></strong></p><p>1、能量在2个营养级上传递效率在10%—20%。</p><p>2、真菌PH5.0—6.0细菌PH6.5—7.5放线菌PH7.5—8.5。</p><p>3、物质可以循环，能量不可以循环。</p><p>4、生态系统的结构：生态系统的成分+食物链食物网。</p><p>5、淋巴因子的成分是糖蛋白，病毒衣壳的成分是1—6个多肽分子。</p><p>6、过敏：抗体吸附在皮肤、黏膜、血液中的某些细胞表面，再次进入人体后使</p><p>细胞释放组织胺等物质。</p><p>7、生产者所固定的太阳能总量为流入该食物链的总能量。</p><p>8、效应B细胞没有识别功能。</p><p>9、水肿：组织液浓度高于血液。</p><p>10、尿素是有机物，</p><p>11、蓝藻：原核生物，无质粒;酵母菌：真核生物，有质粒。</p><p>12、原肠胚的形成与囊胚的分裂和分化有关。</p><p>13、高度分化的细胞一般不增殖，如肾细胞;有分裂能力并不断增加的：干细</p><p>胞、形成层细胞、生发层;无分裂能力的：红细胞、筛管细胞(无细胞核)、神经细胞、骨细胞。</p><p>14、能进行光合作用的细胞不一定有叶绿体。</p><p>15、除基因突变外其他基因型的改变一般最可能发生在减数分裂时(象交叉互</p><p>换在减数第一次分裂时，染色体自由组合)。</p><p>16、凝集原：红细胞表面的抗原;凝集素：在血清中的抗体。</p><p>17、基因自由组合时间：简数一次分裂、受精作用。</p><p>18、人工获得胚胎干细胞的方法是将核移到去核的卵细胞中经过一定的处理使其发育到某一时期从而获得胚胎干细胞，此处“某一时期”最可能是囊胚。</p><p>19、原核细胞较真核细胞简单细胞内仅具有一种细胞器——核糖体，细胞内具有两种核酸——脱氧核酸和核糖核酸。</p><p>20、病毒仅具有一种遗传物质——DNA或RNA;</p><p>21、光反应阶段电子的最终受体是辅酶二。</p><p>22、蔗糖不能出入半透膜。</p><p>23、水的光解不需要酶，光反应需要酶，暗反应也需要酶。</p><p>24、大病初愈后适宜进食蛋白质丰富的食物，但蛋白质不是最主要的供能物质。</p><p>25、尿素既能做氮源也能做碳源。</p><p>26、稳定期出现芽胞，可以产生大量的次级代谢产物。</p><p>27、青霉菌产生青霉素青霉素能杀死细菌、放线菌杀不死真菌。</p><p>28、一切感觉产生于大脑皮层。</p><p>29、分裂间期与蛋白质合成有关的细胞器有核糖体，线粒体，没有高尔基体和</p><p>内质网。</p><p>30、叶绿体囊状结构上的能量转化途径是光能→电能→活跃的化学能→稳定的</p><p>化学能。</p><p>31、高尔基体是蛋白质加工的场所。</p><p>32、流感、烟草花叶病毒是RNA病毒。</p><p>33、水平衡的调节中枢使大脑皮层，感受器是下丘脑。</p><p>34、皮肤烧伤后第一道防线受损。</p><p>35、神经调节：迅速精确比较局限时间短暂;体液调节：比较缓慢比较广泛时间较长。</p><p>36、生长激素：垂体分泌→促进生长，主要促进蛋白质的合成和骨的生长;促激素：垂体分泌→促进腺体的生长发育调节腺体分泌激素;胰岛：胰岛分泌→降糖;甲状腺激素：促进新陈代谢和生长发育，尤其对中枢神经系统的发育和功能有重要影响;孕激素：卵巢→促进子宫内膜的发育为精子着床和泌乳做准备;催乳素：性腺→促进性器官的发育;</p><p>性激素：促进性器官的发育，激发维持第二性征，维持性周期。</p><p>37、生态系统的成分包括非生物的物质和能量、生产者和分解者。</p><p>38、有丝分裂后期有4个染色体组。</p><p>39、所有生殖细胞不都是通过减数分裂产生的。</p><p>40、受精卵不仅是个体发育的起点，同时是性别决定的时期。</p><p><br/></p>','这一百条知识点你都不知道，理科生的尊严呢（生物）','生物一点都不难哟~~
看完这个你就明白，搞定课本上的知识，就基本搞定了生物。','1','1','2016-12-07 21:25:50','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('4','1','','2016-12-07 21:27:15','<p><strong>今天先放物理部分~化学和生物的以后约哟~</strong></p><p><strong>物理部分</strong></p><p>　　1、大的物体不一定不能看成质点，小的物体不一定能看成质点。</p><p>　　2、参考系不一定是不动的，只是假定为不动的物体。</p><p>　　3、在时间轴上n秒时指的是n秒末。第n秒指的是一段时间，是第n个1秒。第n秒末和第n+1秒初是同一时刻。</p><p>　　4、物体做直线运动时，位移的大小不一定等于路程。</p><p>　　5、打点计时器在纸带上应打出轻重合适的小圆点，如遇到打出的是短横线，应调整一下振针距复写纸的高度，使之增大一点。</p><p>　　6、使用计时器打点时，应先接通电源，待打点计时器稳定后，再释放纸带。</p><p>　　7、物体的速度大，其加速度不一定大。物体的速度为零时，其加速度不一定为零。物体的速度变化大，其加速度不一定大。</p><p>　　8、物体的加速度减小时，速度可能增大;加速度增大时，速度可能减小。9、物体的速度大小不变时，加速度不一定为零。</p><p>　　10、物体的加速度方向不一定与速度方向相同，也不一定在同一直线上。&nbsp;</p><p>　　11、位移图象不是物体的运动轨迹。</p><p>　　12、图上两图线相交的点，不是相遇点，只是在这一时刻相等。</p><p>　　13、位移图象不是物体的运动轨迹。解题前先搞清两坐标轴各代表什么物理量，不要把位移图象与速度图象混淆。</p><p>　　14、找准追及问题的临界条件，如位移关系、速度相等等。</p><p>　　15、用速度图象解题时要注意图线相交的点是速度相等的点而不是相遇处。</p><p>　　16、杆的弹力方向不一定沿杆。</p><p>　　17、摩擦力的作用效果既可充当阻力，也可充当动力。</p><p>　　18、滑动摩擦力只以μ和N有关，与接触面的大小和物体的运动状态无关。</p><p>　　19、静摩擦力具有大小和方向的可变性，在分析有关静摩擦力的问题时容易出错。</p><p>　　20、使用弹簧测力计拉细绳套时，要使弹簧测力计的弹簧与细绳套在同一直线上，弹簧与木板面平行，避免弹簧与弹簧测力计外壳、弹簧测力计限位卡之间有摩擦。&nbsp;</p><p>　　21、合力不一定大于分力，分力不一定小于合力。</p><p>　　22、三个力的合力最大值是三个力的数值之和，最小值不一定是三个力的数值之差，要先判断能否为零。</p><p>　　23、两个力合成一个力的结果是惟一的，一个力分解为两个力的情况不惟一，可以有多种分解方式。</p><p>　　24、物体在粗糙斜面上向前运动，并不一定受到向前的力，认为物体向前运动会存在一种向前的“冲力”的说法是错误的。</p><p>　　25、所有认为惯性与运动状态有关的想法都是错误的，因为惯性只与物体质量有关。惯性是物体的一种基本属性，不是一种力，物体所受的外力不能克服惯性。</p><p>　　26、牛顿第二定律在力学中的应用广泛，也有局限性，对于微观的高速运动的物体不适用，只适用于低速运动的宏观物体。</p><p>　　27、用牛顿第二定律解决动力学的两类基本问题，关键在于正确地求出加速度，计算合外力时要进行正确的受力分析，不要漏力或添力。</p><p>　　28、超重并不是重力增加了，失重也不是失去了重力，超重、失重只是视重的变化，物体的实重没有改变。</p><p>　　29、判断超重、失重时不是看速度方向如何，而是看加速度方向向上还是向下。</p><p>　　30、两个相关联的物体，其中一个处于超(失)重状态，整体对支持面的压力也会比重力大(小)。</p><p><br/></p>','这一百条知识点你不知道，理科生的尊严呢？（物理）','1、大的物体不一定不能看成质点，小的物体不一定能看成质点。
　　2、参考系不一定是不动的，只是假定为不动的物体。
　　3、在时间轴上n秒时指的是n秒末。第n秒指的是一段时间，是第n个1秒。第n秒末和第n+1秒初是同一时刻。','1','1','2016-12-07 21:26:43','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('5','1','','2016-12-07 21:27:57','<p>选择题的十不选</p><p>　　1、题肢本身表述错误者不选(逆向选择题除外)</p><p>　　(先看答案，先排除错误的选项，再看题目和材料)</p><p>　　2、题肢与题干要求不相符者不选</p><p>　　(抓住题目的关键词，抓住中心意思排除干扰项)</p><p>　　3、因果相悖者不选</p><p>　　(一看是否存在因果关系，二要主意因果关系是否颠倒)</p><p>　　4、题肢和题干间接联系者也就是通常所说的二级延伸不选</p><p>　　(抓住题干的本质)</p><p>　　5、题肢与题干外延不相符者不选</p><p>　　(看懂内涵的同时，掌握外延的规定性)</p><p>　　6、题肢和题干矛盾者不选</p><p>　　(筛选正确的题肢)</p><p>　　7、题肢与题干相重复者不选</p><p>　　(读透题干问的方向及侧重点)</p><p>　　8、正误相混者，即题肢中既有正确的部分也有不正确的部分，不选</p><p>　　(仔细读完题肢，小心陷井)</p><p>　　9、反向选择题中正确者不选</p><p>　　(认真审题)</p><p>　　10、题干要求单一者(如带有核心、根本、关键、最主要、中心为字眼)，有些题肢即使能在题干中得到体现，但如果不符合题干单一性的要求，也不能选。</p><p><br/></p>','政治选择题，参考下这个办法吧~','1、题肢本身表述错误者不选(逆向选择题除外)
　　(先看答案，先排除错误的选项，再看题目和材料)
　　2、题肢与题干要求不相符者不选
　　(抓住题目的关键词，抓住中心意思排除干扰项)','1','1','2016-12-07 21:27:16','','0','','','0','{\"thumb\":\"\"}','1','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('6','1','','2016-12-07 21:28:53','<p>高三的同学才最有发言权，联考模拟考，周考月考期中考，每天都在主内考试和考试的路上狂奔——</p><p>怎么把考试利用最大化?</p><p>怎么通过考试提升成绩?</p><p>听听小编的意见吧~</p><p><strong>分析试卷：将存在问题分类</strong></p><p>每次考试结束试卷发下来，要认真分析得失，总结经验教训。</p><p>特别是将试卷中出现的错误进行分类，可如下分类：</p><p>第一类问题———遗憾之错。就是分明会做，反而做错了的题;</p><p>比如说，“审题之错”是由于审题出现失误，看错数字等造成的;“计算之错”是由于计算出现差错造成的;“抄写之错”是在草稿纸上做对了，往试卷上一抄就写错了、漏掉了;“表达之错”是自己答案正确但与题目要求的表达不一致，如角的单位混用等。出现这类问题是考试后最后悔的事情。</p><p>第二类问题———似非之错。记忆的不准确，理解的不够透彻，应用得不够自如;回答不严密、不完整;第一遍做对了，一改反而改错了，或第一遍做错了，后来又改对了;一道题做到一半做不下去了等等。</p><p>第三类问题———无为之错。由于不会，因而答错了或猜的，或者根本没有答。这是无思路、不理解，更谈不上应用的问题。</p><p><strong>制订策略：将问题各个击破</strong></p><p><strong>建议策略是：分步打好三个战役，即：消除遗憾;弄懂似非;力争有为。</strong></p><p><strong>第一战役：消除遗憾。</strong>要消除遗憾，必须弄清遗憾的原因，然后找出解决问题的办法，如“审题之错”，是否出在急于求成?可采取“一慢一快”战术，即审题要慢、答题要快。“计算错误”，是否由于草稿纸用得太乱，计算器用得不熟等。</p><p>建议将草稿纸对折分块，每一块上演算一道题，有序排列便于回头查找。练习计算器使用技巧以提高使用的准确率。“抄写之错”，可以用检查程序予以解决。“表达之错”，注意表达的规范性，平时作业就严格按照规范书写表达，学习高考评分标准写出必要的步骤，并严格按着题目要求规范回答问题。</p><p><strong>第二战役：弄懂似非“似是而非”是自己记忆不牢、理解不深、思路不清、运用不活的内容。</strong></p><p>这表明你的数学基础不牢固，一定要突出重点，夯实基础。你要建立各部分内容的知识网络;全面、准确地把握概念，在理解的基础上加强记忆;加强对易错、易混知识的梳理;要多角度、多方位地去理解问题的实质;体会数学思想和解题的方法;当然数学的学习要有一定题量的积累，才能达到举一反三、运用自如的水平。</p><p><strong>第三战役：力争有为在高三复习的第一轮中，不要做太难的题和综合性很强的题目，因为综合题大多是由几道基础题组成的，只有夯实了基础，做熟了基础题目，掌握了基本思想和方法，综合题才能迎刃而解。</strong>在高三复习时间较紧的情况下，第一阶段要有所为，有所不为，但平时考试和老师留的经过筛选的题目要会做，要做好。</p><p><strong>巩固成果：不断调整目标</strong></p><p>每次测试都要确立自己本次改错的目标，考后要检查目标实现情况，随着自己的不断进步，问题会越来越少，成绩会越来越好，这时离你的理想也越来越近。</p><p><br/></p>','怎么在考试中提升数学成绩？','怎么把考试利用最大化?
怎么通过考试提升成绩?
听听小编的意见吧~','1','1','2016-12-07 21:27:58','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('7','1','','2016-12-07 21:29:18','<p>物理？</p><p>如果你只想到课本上那些冷冰冰的公式和试题，那就怪不得你不觉得他有多少可爱了！</p><p>仔细观察生活，有多少有趣的生活现象等你来发现，挖掘学习物理的乐趣~</p><p>▽</p><p><strong>热学</strong><br/>1.磨刀刀变热,即摩擦生热.<br/>2.相同火力,压力锅可以将水加热到一百摄氏度以上普通锅却不能,即,水的沸点随压强增大而增大.（通常我们所说的水的沸点是指一标准大气压下的沸点）.<br/>3.用蜡烛不能加热水,用煤气却可以,即加热功率大于散热功率时方可加热.<br/>4.冬季煮汤窗户会出现白色的雾气,即热空气遇冷玻璃液化为小水滴.<br/>5.煮汤时水不断变少油却留了下来,即油的沸点高于水.<br/>6.微波炉加热鸡蛋蛋黄先熟,即微波使内部分子碰撞.<br/>▽<br/><strong>电学&nbsp;</strong><br/>1.电磁炉可以加热食物,动磁场产生电场.<br/>2.电饭锅可以设定各种程序,即功率不同单位时间产生热量不同.<br/>3.老式电磁炉多必须采用铝锅,即电磁的良导体.<br/>4.煤气泄漏后不要点灯,防止开关闭合产生电火花引起火灾.<br/>5.不要用湿手拔插插销,水（纯水除外）是电的良导体.</p><p><br/></p>','物理在身边，这些现象是为什么呀（热学&amp;电学）','如果你只想到课本上那些冷冰冰的公式和试题，那就怪不得你不觉得他有多少可爱了！
仔细观察生活，有多少有趣的生活现象等你来发现，挖掘学习物理的乐趣~','1','1','2016-12-07 21:28:54','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('8','1','','2016-12-07 21:29:50','<p><strong>第一点，要自信。</strong>很多的科学研究都证明，人的潜力是很大的，但大多数人并没有有效地开发这种潜力，这其中，人的自信力是很重要的一个方面。无论何时何地，你做任何事情，有了这种自信力，你就有了一种必胜的信念，而且能使你很快就摆脱失败的阴影。相反，一个人如果失掉了自信，那他就会一事无成，而且很容易陷入永远的自卑之中。</p><p>　　提高学习效率的另一个重要的手段是学会用心。学习的过程，应当是用脑思考的过程，无论是用眼睛看，用口读，或者用手抄写，都是作为辅助用脑的手段，真正的关键还在于用脑子去想。举一个很浅显的例子，比如说记单词，如果你只是随意的浏览或漫无目的地抄写，也许要很多遍才能记住，而且不容易记牢，而如果你能充分发挥自己的想象力，运用联想的方法去记忆，往往可以记得很快，而且不容易遗忘。现在很多书上介绍的英语单词快速记忆的方法，也都是强调用脑筋联想的作用。可见，如果能做7到集中精力，发挥脑的潜力，一定可以大大提高学习的效果。</p><p>　　另一个影响到学习效率的重要因素是人的情绪。我想，每个人都曾经有过这样的体会，如果某一天，自己的精神饱满而且情绪高涨，那样在学习一样东西时就会感到很轻松，学的也很快，其实这正是我们的学习效率高的时候。因此，保持自我情绪的良好是十分重要的。我们在日常生活中，应当有较为开朗的心境，不要过多地去想那些不顺心的事，而且我们要以一种热情向上的乐观生活态度去对待周围的人和事，因为这样无论对别人还是对自己都是很有好处的。这样，我们就能在自己的周围营造一个十分轻松的氛围，学习起来也就感到格外的有精神。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;第二点，</strong><strong>不要在学习的同时干其他事或想其他事。</strong>一心不能二用的道理谁都明白，可还是有许多同学在边学习边听音乐。或许你会说听音乐是放松神经的好办法，那么你尽可以专心的学习一小时后全身放松地听一刻钟音乐，</p><p>　<strong>　第三点、</strong><strong>不要整个晚上都复习同一门功课。就算经常</strong>用一个晚上来看数学或物理，实践证明，这样做非但容易疲劳，而且效果也很差。后来在每晚安排复习两三门功课，情况要好多了。</p><p><br/></p>','学习效率百分之二百！','很多的科学研究都证明，人的潜力是很大的，但大多数人并没有有效地开发这种潜力，这其中，人的自信力是很重要的一个方面。','1','1','2016-12-07 21:29:19','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('9','1','','2016-12-07 21:30:15','<p>古代汉语和现代汉语的代沟，可以横跨一个银河系！而通假字就是横跨银河的桥梁哟~~~</p><p>案：同“按”;审察，察看。动词。“召有司案图，指从此以往十五都予赵。”</p><p>罢：通“疲”;疲劳。形容词。“罢夫赢老易于而咬其骨。”</p><p>颁：通“班”;“斑”;头发花白。形容词。“颁白者不负戴于道路矣。”</p><p>板：同“版”;字版。名词。“板印书籍，唐人尚未盛为之。”</p><p>暴：“同曝”晒。动词。“虽有槁暴，不复挺者，輮使之然也。”</p><p>暴：同“曝”暴露，显露。动词。“思厥先祖父，暴霜露，”</p><p>暴：同“曝”;暴露，显露。动词。“忠义暴于朝廷。”</p><p>杯：同“杯”;酒器。名词。“沛公不胜杯杓，不能辞。”</p><p>倍：通“背”，背叛，忘记。动词。“愿伯具言臣之不敢倍德也。”</p><p>倍：同“背”背叛，违背。动词。“倍道而妄行，则天不能使之吉。”</p><p>被：通“被”;顶。动词。“被明月兮佩宝璐。”</p><p>被：同“披”;穿着。动词“闻妻言，如被冰雪。”</p><p>被：同“披”;覆盖在肩背上，动词。“廉颇为之一饭斗米，肉十斤，被甲上马。”</p><p>被：同披;覆盖在肩背上。动词。“屈原至于江滨，被发行吟泽畔，”</p><p>俾倪：同“睥睨”;斜着眼看。形容词。“见其客朱亥，俾倪.”</p><p>辟：通“避”;躲避。动词。“其北陵，文王所辟风雨也。”</p><p>辟：通“僻”;行为不正。形容词。“放辟邪侈，无不为已。”</p><p>弊：通“敝”;困顿，失败。形容词。“秦有余力而制其弊，”</p><p>弊：通“敝”;疲惫，衰败。“率疲弊之卒，将数百之众，转而攻秦;”</p><p>弊：通“敝”;疲惫，衰败。形容词。“今天下三分，益州疲弊。”</p><p>徧：同“遍”遍及，普遍。动词。“小惠末徧，民弗从也。”</p><p>宾：同“傧”;迎接客人的人。名词“设九宾于廷，臣乃敢上璧。”</p><p><br/></p>','高三通假字必备','古代汉语和现代汉语的代沟，可以横跨一个银河系！而通假字就是横跨银河的桥梁哟','1','1','2016-12-07 21:29:51','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('10','1','','2016-12-07 21:31:32','<p>这篇文章只说明两件事：</p><p>　　第一，为什么你学习效率低。</p><p>　　第二，怎么办?</p><p><strong>　　原因：</strong></p><p>　　1。学习时间很长，得不到有效的休息。多数人都认为，只要刻苦就会有收获，即使在疲劳的时候依然要坚持，可是当学生疲劳的时候，思路变得不清晰，面对大量的知识，觉得很乏味，甚至失去兴趣。</p><p>　　2。重复着大量同样的内容，没有做到精简。高三结束之后，如果有心把自己曾经做过的试卷、作业、资料等拿过来看看，一定会发现重复了大量同样的内容，甚至是原题，还有一些学生将自己有限的精力和时间放到无限大的题海中，吃力不讨好说的就是这一类学生。</p><p>　　3。学东西仅靠死记硬背，不理解其中的含义，同时也没有将自己学到的内容与实际运用结合起来。现在的高考，很少考查哪些需要学生死记硬背的知识点，而是大部分集中在理解和运用上，特别是一些文科的考生，在这点上摔得务必凄惨。</p><p>　　4。没有根据的自己的实际情况去安排学习规划。很多学生被动的跟着学校复习的节奏走，自己遇到的问题没有得到重视，更没有得到解决，问题摆在那，没有得到解决，你怎么会能做到不断的完善和进步呢?高考竞争强度可想而知，谁能把自己遇到的问题最大限度的解决，谁就能脱颖而出。(这个强调过很多遍了，还是把学校复习和自己的复习结合起来)</p><p>　　5。资源没有合理的运用。作为高三的学生，要合理的运用资源，可供选择的资源有老师、资料、同学等等。害羞是没有用的!</p><p>　　6。心态因素的影响。很多学生由于自己学习效率不高，害怕看到高考倒计时牌，因为在很大程度上，被时间追着跑，而不是自己合理的应用时间，还有的学生由于对学习认识方面的存在不足，觉得难题、瘸腿科目就很难补上了，随着时间离高考越来越近，变得很纠结，纠结这个词以前解释过--用一半的时间怀疑自己，用一半的时间来宽容自己，结果整天把自己弄得不快乐，什么问题都没有解决。当然影响备考效率的心态因素很多，需要及时调整。</p><p><strong>　　怎么做??</strong></p><p>　　大致说明一下。</p><p>　　1。写下那些让你感到焦虑和担忧的事情。举一个例子：</p><p>　　某某同学在全面审视自己以及认清形势后写下这样的一些问题，这些问题有的是一直以来困扰他的问题，还有在分析的基础上，可能将会出现的问题：</p><p>　　长期困扰自己的问题：</p><p>　　性格因素：拖延、偏激、浮躁……</p><p>　　学习中遇到的问题：语文现代文阅读存在问题，数学解析几何、最后一道压轴题不容易把握……</p><p>　　考试中遇到的问题：时间分配不合理、笔误……</p><p>　　最担心的事情：……</p><p>　　在分析的基础上，未来有可能出现的问题：……</p><p>　　在现实中，为什么说自己最大的对手是自己?主要因为，自己很难看清楚自己遇到的问题。特别对备考的中的学生来说，在一定的程度上看清楚自己还是有必要的。</p><p>　　2。需要适当的反思，进一步思考学习状态和学习习惯之间的关系。</p><p>　　反思也是为了更全面的审视自己遇到的问题，例如说上面列举的导致学生学习效率不高的原因，看看有哪些是与自己实际情况很相近?我们找到了自己遇到的问题，反思一下以前遇到这样的问题，你是如何做的，为什么没有效率甚至没有效果?这样对于很多问题你就不难找到答案了。</p><p>　　3。有效的利用时间。时间是水，如何化零为整是一门学问，效率高的学生都是非常善于讲别的同学嬉戏打闹的时间充分利用。</p><p>　　4。集中利用资源优势解决你遇到的问题。三人行必有我师，其实这也是对资源的一种阐述，有时候，最好的资源就在身边，这个世界，方法总比困难多，可是很多人只迷恋有一个万能的方法，能解决自己棘手的问题，可是一直到最后也没有找到这个方法，原因是想法错误了。我们是不是应该审视一下自己，你的老师、同学、资料、同学手上的资料，有哪些值得你利用的呢?</p><p>　　5。在理解的基础上，将知识点运用在做题上。有时候，学生问我，整天背诵英语单词，可是英语成绩就是不见提高，这是为什么?其实答案很简单，就是你背诵的东西没有在现实中运用，导致你背的单词，是独立的，随着时间的流逝，渐渐的忘掉了。(作文是同样的道理，积累了很多素材，但你写作不用，慢慢的也忘记了。)</p><p><br/></p>','效率低，情有可原？？？','学习时间很长，得不到有效的休息。多数人都认为，只要刻苦就会有收获，即使在疲劳的时候依然要坚持，','1','1','2016-12-07 21:30:20','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('11','1','','2016-12-07 21:31:56','<p>说短不短，说长不长的一段时间，从哪个时间节点开始，才算是恰如其分呢？</p><p>　　有教育研究学者针对100位刚刚结束高考的高中学生进行了一项特殊调查，调查结果发现，学生进入备考的时期与高考成绩呈现一定的正相关关系。选 择在高二时期开始进入备考阶段的学生，高考成绩相对优于高三才开始备考的学生。 这一调查结果与教育学者之前预想的理论一致，即：越早进入高考备考阶段的学生，高考成绩相对更为理想。</p><p>　　提前备战高考具有什么样的优势?</p><p>　　及时发现问题补漏</p><p>　　提前在一轮复习前进入备考状态，有助于学生在一轮复习前及时发现学习缺漏和重要问题，在一轮复习时能够有针对性的进行查缺补漏，提高一轮复习效果。</p><p>　　提早进入应考状态</p><p>　　学生在进入备考状态后有一段相对长的适应缓冲期，提前备战高考能够将适应期提前，避免影响后续正常的一轮及二轮复习，顺利过渡到应考状态。</p><p>　　做好全面复习规划</p><p>　　高考复习分秒必争，提前备战高考能够给自己预留更加充分的复习时间，同时便于对整个高三期间的复习进行全面规划，并为及时调整修正学习安排预留了充裕的空间，学习更加有备无患。</p><p>　　把握高考最不容错失的</p><p>　　备战黄金期——高二暑假</p><p>　　如何在暑假制定高三一轮复习计划?</p><p>　　1.全面了解你自己</p><p>　　制定一轮复习计划前，首先要对自己过去至少一个学期(最好是全高中阶段)的学习成绩和学习问题进行一个全面分析和评估，确定自己所处的成绩水平，明确自己的薄弱环节，才能够有的放矢，安排好复习计划的轻重点。</p><p>　　2.为数学预留刷题时间</p><p>　　刷题作为数学最重要的复习方法，除了有利于学生拓展练习量和提高应试技巧积累，同时还能帮助学生尽快进入学习状态，尤其在进入备战高考的初期阶段，安排较大量的刷题对于缩短缓冲适应期、快速进入复习状态有明显成效。</p><p>　　3.把最开始的时间留给单词</p><p>　　为了巩固英语单词的记忆成效，我们建议在开始背诵英语单词之前，先对所有单词进行一轮熟悉和梳理，可以按照学生的不同记忆方法，对单词进行归类整理，提高单词背诵效率。</p><p>　　4.现在救作文还来得及</p><p>　　在时间充裕的情况下，在复习规划中定期预留语文作文的素材积累时间，阅读了解一些精品美文或新闻时事，作为紧张学习中的放松手段，同时有利于写作能力的提高。</p><p><br/></p>','什么时候开始备考最好？！','说短不短，说长不长的一段时间，从哪个时间节点开始，才算是恰如其分呢？','1','1','2016-12-07 21:31:33','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('12','1','','2016-12-07 21:32:26','<p>记住该记住的</p><p>　　“该记的只好记住，可是，能够不记的就不要去记忆”。为了减轻记忆的负担，能够偷懒的地方犯不着去玩命——本来 该背的就够多啦!根据知识的特点，在记 忆和理解之间，可把知识分为四种类型：只需理解无须记忆的;只需记忆无须理解的(背下来就是了);只有记忆才能理解的。只有记忆才能记住的。我们这里取得 是“出力最小原则滚动式复习法。先复习第一章，然后复习第二章，然后把第一二章一起复习一遍;然后复习第三章，然后一二三章一起复习一遍……以此类推，犹 如“滚动”。这种复习法需要一定的时间，但复习比较牢固，由于符合记忆规律，效果好。</p><p>　　过度复习法</p><p>　　“过度复习法”记 忆有一个“报酬递减规律”，即随着记忆次数的增加，复习所记住的材料的效率在下降。为了与这种“递减”现象相抗衡，有的同学就采取了 “过度复习法”，即本来用10分钟记住的材料，再用3分钟的时间去强记——形成一种“过度”，以期在“递减时不受影响”。</p><p>　　“一题不二错”</p><p>　　复习时做错了题，一旦搞明白，绝不放过。失败是成功之母，从失败中得到的多，从成功中得到的少，都是这个意思。失败了的东西要成为我们的座右铭。</p><p>　　要掌握考试技能</p><p>　 　“基础题，全做对;一般题，一分不浪费;尽力冲击较难题，即使做错不后悔”。这是应该面对考卷时答题的策略。考试试题总是有难有易，一般可分为基础 题，一般题和较难题。以上策略是十分明智可取的“容易题不丢分，难题不得零分。“保住应该保住的，往往也不容易;因为遇到容易题容易大意。所以明确容易题 不丢分也是十分重要的。难题不得零分，就是一种决不轻弃的的进取精神的写照，要顽强拼搏到最后一分和最后一分钟。</p><p>　　“绕过拦路虎，再杀回马枪”</p><p>　　考试时难免会遇到难题，费了一番劲仍然突不破时就要主动放弃，不要跟它没完没了的耗时间。在做别的题之后，很有可能思路打开活跃起来再反过来做它就做出来了。考试时间是有限的，在有限的时间里要多拿分也要讲策略。</p><p>　　“对试题抱一种研究的态度”</p><p>　　淡化分数意识，可能是缓解紧张心理的妙方。因此，对试题抱一种研究态度反而会使我们在考场上更好的发挥出最佳水平。有一颗平常心比有一颗非常心有时更有利。</p><p>　　“多出妙手不如减少失误”</p><p>　　这是韩国著名棋手李昌镐的一句经验之谈。他谈的是下棋，但对我们考试也不无借鉴意义，特别是对那些学习比较好成绩比较好的学生，要取得出色的成绩，创造高分，减少失误是为至要。</p><p>　　最关键是培养兴趣</p><p>　 　美国教育学者布鲁纳说：“学生的最好的刺激是对学习材料的兴趣”。还有一句名言说“兴趣是最好的老师”。没有兴趣但是不得已的事情也得做，却何如有兴 趣而乐此不疲?比如政治，因为它的理论性比较强，很枯燥，所以就多培养些对政治的兴趣。平时多关注些国家的大政方针政策，在遇到问题时，也会把自己想象成 一个公务员[微博]，想象公务员是怎样解决问题的，这样政治就生动起来了，其实政治就在我们身边。</p><p>　　提高听课效率是最重要的学习方法</p><p>　 　在我们的学习过程中，除了读书，还有一件大家几乎每天都要做，花的时间一样、内容也都一样的事情，那就是听课。它看起来十分平常，但当我们中的很多人 花费时间和精力去探求各种“学习技巧”的时候，却往往忘记了：我们一天中的大部分时间都是用来听课的，提高听课的效率，比任何学习方法都重要。</p><p>　　不把作业带回家做</p><p>　　上课时间非常认真，课堂效率很高。学习上的事情要求自己在学校的时间全部解决，作业什么的争取不带回家做，这样回到家的时间就是属于自己的了，就可以做自己想做的事。</p><p>　　喜欢做笔记</p><p>　　把笔记整理得工整、全面、知识体系的把握、知识脉络的梳理和回顾非常重要，有了笔记就可以经常做有重点的复习，温故而知新。</p><p>　　“别把高考想像得可怕”</p><p>　　高三要有好感觉，不痛苦，很充实。不要紧张，只要从现在开始都不得及，努力做出，一定是有回报的。</p><p>　　善于总结，不断探索</p><p>　　平时做题时，关于分析和思考问题，并积极支总结，探索新方法;并还是为了做题而做题，而是要主动积极地追寻在题目和解答之间的必然联系，把题目做活。</p><p>　　发挥和幸运才是关键</p><p>　　要注意考试策略，实力只是一部份。认真对待平时考试。在平时考试中积累经验、总结教训。</p><p>　　班里的学习氛围很重要</p><p>　　班级就像家庭，好朋友臭味相投，压力之下都很快乐地学习。同伴相处得很融洽，平时也经常开开玩笑，有说有笑，复习时想到提问，气氛很好。</p><p>　　合理安排时间</p><p>　　早做准备，后期就不会觉得紧张。阶段性的时间分配，要注重各科要平衡用力，仅略有侧重，不要抓了这科，丢了那科，杜绝弱科的产生。</p><p>　　保持好心情</p><p>　　不管生活有多复杂，重要的是，要有一份平和的心态，要处理好与老师同学的关系，与老师相互欣赏，不要把同学看成对手，与同学良性竞争。</p><p><br/></p>','100位学霸总结的高三第一轮复习经验B','“该记的只好记住，可是，能够不记的就不要去记忆”。为了减轻记忆的负担，能够偷懒的地方犯不着去玩命','1','1','2016-12-07 21:31:57','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('13','1','','2016-12-07 21:32:49','<p>随着高三开学，第一轮复习正式拉开帷幕，第一轮复习一直到年底，复习时间最长，又是第二轮复习与第三轮复习的基础及先行者，一轮复习显得尤为重要。不少学生说第一轮复习心里完全没有底不知道要怎么做。急诸位之所急，以下奉上100位 学霸亲身经验，希望对大家有所帮助。</p><p>　　地毯式扫荡</p><p>　　先把该复习的基础知识全面过一遍。追求的是尽可能全面不要有遗漏，哪怕是阅读材料或者文字注释。要有蝗虫精神，所向披靡一处不留。</p><p>　　融会贯通</p><p>　　找到知识之间的联系。把一章章一节节的知识之间的联系找到。追求的是从局部到全局，从全局中把握局部。要多思考，多尝试。</p><p>　　知识的运用</p><p>　　做题，做各种各样的题。力求通过多种形式的解题去练习运用知识。掌握各种解题思路，通过解题锻炼分析问题解决问题的能力。</p><p>　　捡“渣子”</p><p>　　即查漏补缺。通过复习的反复，一方面强化知识，强化记忆，一方面寻找差错，弥补遗漏。求得更全面更深入的把握知识提高能力。</p><p>　　“翻饼烙饼”</p><p>　　复习犹如“烙饼”，需要翻几个个儿才能熟透，不翻几个个儿就要夹生。记忆也需要强化，不反复强化也难以记牢。因此，复习总得两三遍才能完成。</p><p>　　基础，还是基础</p><p>　　复习时所做的事很多。有一大堆复习资料等着我们去做。千头万绪抓根本。什么是根本?就是基础。基础知识和基本技能技巧，是教学大[微博]纲也是考试的 主要要求。在“双基”的基础上，再去把握基本的解题思路。解题思路是建立在扎实的基础知识条件上的一种分析问题解决问题的着眼点和入手点。再难的题目也无 非是基础东西的综合或变式。在有限的复习时间内我们要做出明智的选择，那就是要抓基础。要记住：基础，还是基础。</p><p>　　学文科，要“死”去“活”来</p><p>　　历史学科，有很多需要背诵的东西，人物、事件、年代、一些历史史料的要点等等。有些材料，只能“死”记。要多次反复强化记忆。历史课是一门机械死记量 比较大的学科。但是在考试时，却要把记往的材料灵活运用，这就不仅要记得牢，记得死，还要理解，理解得活。是谓“死”去“活”来，不单学历史，学地理，学 政治，以至学理化生物，都需要“死”去“活”来。</p><p>　　“试试就能行，争争就能赢”</p><p>　　这是电视连续剧《十七岁不哭》里的一句台词。考试要有一个良好的心态，要有勇气。“试试争争”是一种积骰的参与心态，是敢于拼搏，敢于胜利的精神状 态，是一种挑战的气势。无论是复习还是在考场上，都需要情绪饱满和精神张扬，而不是情绪不振和精神萎靡，需要兴奋而不是沉闷，需要勇敢而不是怯懦。“光想 赢的没能赢，不想输的反倒赢了”。“想赢”是我们追求的“上限”，不想输是我们的“下限”。“想赢”是需要努因而比较紧张的被动的，“不想输”则是一种守 势从而比较从容和主动。显然，后者心态较为放松。在放松的心态下，往往会发挥正常而取得好的效果。</p><p>　　具备健康心理</p><p>　　“一个具有健康心理素质的人应该做到两点：在萎靡不振的时候要振作起来，在承受压力过大时又能为自己开脱，使自己不失常”。人的主观能动性使人能够控 制和把握自己，从而使自己的精神状态处于最往。因势应变是人的主观能动性的作用所在。相反相成是一切书物的辩证法。心理素质脆弱是主观能动性的放弃，健康 的心理素质则使我们比较“皮实”——能够调整自己的情绪和心态去克服面临的困难。</p><p>　　实力+心理</p><p>　　“高考[微博]从根本上说是对一个人的实力和心理素质的综合考察”。实力是基础，是本钱，心理素质是发挥我们的实力和本钱的条件。有“本钱”还得会用“本钱”。无本钱生意无法做，有本钱生意做赔了的事也是有的。</p><p>　　考试发挥</p><p>　　复习是积蓄实力积蓄本钱，考试则要求发挥得淋漓尽至，赚得最大的效益。一位考生说“我平时考试总是稀里糊涂，但大考从来都是名列前茅，大概是心理调节得好吧?”诚如是，最可怕的是大考大糊涂，小考小糊涂，不考不糊涂。</p><p>　　强科更强，弱科不弱;强科有弱项，弱科有强项</p><p>　　在考试的几个科目上，一个人有强有弱，是太正常了。复习的策略，就是扬强扶弱。有的同学是只补弱的，忽视了强的;有的同学是放弃弱的专攻强的。从整体看，都未见明智。强的里面不要有“水分”，弱的里面还要有突破。大概是十分高明的策略了。</p><p>　　打团体赛</p><p>　　“差的学科要拼命补上来，达到中等偏上水平;好的要突出，使之成为真正的优势。”这里的道理与上述相仿，也是对待自己的强弱项中的一种策略。中考[微博]高考都是“团体赛”，要的是全局的胜利而不能是顾此失彼。</p><p><br/></p>','100位学霸总结的高三第一轮复习经验A','随着高三开学，第一轮复习正式拉开帷幕，第一轮复习一直到年底，复习时间最长，又是第二轮复习与第三轮复习的基础及先行者','1','1','2016-12-07 21:32:27','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('14','1','','2016-12-07 21:33:13','<p><strong>笔记本，要巧记重点</strong></p><p>　　在课上，做笔记是必要的。往年，有些学生认为，课堂上只要认真听讲，就没必要记笔记了。其实，这是个误区。俗话说，“好记性不如烂笔头”，课堂上记笔记有助于增强考生对知识框架的总体把握。</p><p>　　高三这一年要记的知识点很多。一般来说，老师在课堂上会讲解很多知识内容，有些在课堂上消化不了的，需要先记录下来，课下再慢慢消化、理解。有时老师在课堂上的一句话，可能就是关键问题。学生在课上记住了，但很可能到了课下就忘记了老师说过的重点。因此，记课堂笔记非常重要。</p><p>　　做笔记要讲究方法。老师在课上讲的内容很多，如果只顾做笔记，也会影响听课效率。所以，上课做笔记的前提是不能影响听讲和思考，这就要求考生把握好时机。一般情 况下，老师在黑板上写东西时，高三生可以抓紧时间记笔记;老师讲到重点内容时，高三生要认真听讲，课后再补记笔记。提醒考生注意的是，记笔记不是一字不落 地全记上，而要<strong>简明扼要，利用短语、数字、图案等适合自己的方式把重点、难点、疑点等内容记下</strong>，课后再认真整理。</p><p><strong>　　错题本，要善于归纳</strong></p><p>　　月考、期中考、期末考、“一模”、“二模”……高三一年，学生要经历大大小小的考试。总结好每次考试中遇到的问题，对高三生提高成绩非常重要。建立错题本，进行归纳分析，是一种非常好的做法。</p><p>　　在学习中，高三生要善于把自己做过的作业、习题、试卷中的错题抄在错题本上，便于日后随时翻阅，查找知识漏洞。只有有效地使用错题本，才能使学 习更有针对性，同时提高学习效率。以往，有的高三生对错题的认识不深刻，即使重新再做一遍，也还是答不出或者答错，原因可能就在于这些人没有建立错题本， 不善于对错题进行归纳总结。</p><p>　　建立了错题本，还要用好错题本。高三生可将自己发现的错题或不会做的题收集起来，分析一下做错或不会做的原因，并把正确解题答案和思路注在旁边。高考前，高三生可着重针对错题本上的题目查缺补漏，也可把在学习中的体会记录下来，经常翻看，能够使自己对知识的理解更深刻，对知识掌握得更牢固。</p><p>　　<strong>口袋词汇本，课余时间常翻看</strong></p><p>　　在备战高考的过程中，英语作为一大学科，对高考总成绩有举足轻重的作用。若想提高英语成绩，词汇量是必不可缺的。</p><p>&nbsp; 首先，将单词分为原型和派生词。例如happiness为高兴、幸福的名词，那么我们可以将它的形容词、副词一并记住，有些特殊单词还会有动词形式，这样在记一个单词的同时，可完善 对这个单词整体运用的理解，对写作也会有所帮助。考生可以在写作时翻阅词汇笔记，查看应正确使用的词性，力求每个单词都用得恰如其分。</p><p>&nbsp; 其次，高三生还可以将字母拼写相似的词进行总结，就像语文的形近字一样，例如similar和familiar，认准单词便于考生在阅读中理解文章大意。最后，对常见的词组 做整理，尤其是出现在单选和完形当中的、那些仅仅依靠字面翻译不出来的“肉眼无法识别”的词组。</p><p>　 如果条件允许，高三生可用一个便于携带的小本子记录词汇笔记，在回家的路上、上课的间隙等课余时间勤于翻看。此外，还可将背单词当作娱乐休闲，几个同学比赛谁找出的好词组好句子多，在讨论中对高频词汇的印象会更加深刻。听力近几年增加了听写单词的题型，对于常考的月份、数字、天 气、星期等词汇，高考生可加以归类，在考试前抽出几分钟进行复习。</p><p><br/></p>','高三上学期，备好三个本子','　在课上，做笔记是必要的。往年，有些学生认为，课堂上只要认真听讲，就没必要记笔记了。其实，这是个误区','1','1','2016-12-07 21:32:51','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('15','1','','2016-12-07 21:33:37','<p>很多学生问我高三如何规划才合理，这个问题我纳闷了好久。应该是每个人都有自己的规划周期，应当是结合自己的实际情况进行规划。尤其是现在同学们刚进入高三，体会还不是很深刻，但还是希望同学们为自己量身定好规划。</p><p>　　先谈一下如何利用好大多数学校制定的一二三轮复习。(其实前面的博文提到过)我就结合大家各自不同的情况，说一下当前同学们即将进入的第一阶段。</p><p>　　高三首轮复习按时间大致为：9月—3月初，这个时期为<strong>基础能力过关时期</strong></p><p>　　1、认真回顾课本知识</p><p>　　这个阶段过程主要是用于高中三年全部课程的回顾。这时候我希望大家<strong>在回顾的过程中能够找到自己知识遗漏的部分</strong>。这个阶段相当的冗长，最主要的是 要会学回归课本。无论如何，高考绝大部分内容都贴近课本的。高考试题的80%是基础知识，20%是稍难点的综合题，掌握好基础，几乎能上一个比较不错的大学。</p><p>&nbsp;&nbsp; 因此高三前期，我希望同学们老老实实把课本弄懂。弄懂课本不是光记住结论，而是要通读。即<strong>理科全部的原理要弄清、语文课文内标注的字词句摘抄、英语课 文至少要达到念的通顺、文史类知识主线及同类型知识要素要学会整理等。</strong>注意，第一轮复习十分重要，大家千万不要埋头做题，而是先看课本，再“精”做题目。 在复习过程中一定先将课本看明白了，然后再做题，做题过程中不许看课本，不许对答案。</p><p>&nbsp;&nbsp; 会就会做，不会做一定要先想哪些内容遗忘了，哪里想错了，先做后面 的，等隔一定时间再看不会做的，马上看的话效果打折扣的。</p><p>　　2、把握好自己的节奏</p><p>　　很多学生因为在复习过程中跟不上老师的节奏，导致前面部分没弄懂，后面部分更是拉下，学校在教学节奏控制上又不能根据学生本身制定。因此我建议学生一定要提高自学能力，<strong>如果实在跟不上节奏，就先关注最基础最简单的题目，将遗漏的课本部分做好画线标记，或将页面折起做标记，以利于及时的回顾。</strong></p><p><strong>&nbsp;&nbsp;</strong>在学的过程中不要因为面子问题不敢发问，建议学生在弄不懂的问题上多问同学，多问老师。最好能够找到水平相当的同学，互相约定好给对方做考察，给对方讲解双方对知识点的认识，互相研究题目。同学之间相互沟通时所掌握的内容比问老师的效果更好，因为在互相沟通的时候可以带者任何疑问，可以很容易的将思维的漏洞补齐。</p><p>　　3、正确处理作业练习</p><p>　　在处理作业上，千万不要死磕题目，记住两个原则：</p><p>&nbsp; 一、不要和自己过不去。第一遍做不出来或做错就直接先放弃，但是要保留这道题，每天抽1~2分 钟看下这类不会做的题，无论是看课本也好，听老师讲解也好，做到一眼看出这题怎么做时，再动手做，并将这类题型留好。</p><p>&nbsp; 二、要加强互动性。不仅是和同学之间 的互动，还要和课本进行互动。做完作业不要看对答案，留到第二天把有困难的和同学交流，或第二天看别人怎么做，然后问他怎么想的。如果不善于问同学，至少 等到第二天再看课本或是答案。无论对错，看答案或对答案的过程中尽量回顾当时我是怎么想的，与别人差别点在哪里。这样，尽管你当时没有“获取”答案，但是 留下了疑问，又多一些时间来探讨自己做题时的思维。</p><p>　　当基本弄懂一个章节后，一定要定期回顾，如一周的时间后，翻一下课本，这周学了什么，然后给自己限制时间做几道题，用以验证自己哪些内容真正是明白了。通过这么练习，远远比大量做题效果好的多。</p><p>　　4、如何利用每一次考试</p><p>　　处理考试上，要认同自己。分数很重要，重要的是你得到的那些分数和你得不到的分数，毕竟不是高考，当前阶段分数的高低没有任何意义。你只需做三 件事<strong>：一、根据你所获取分数的部分，整理你当前会的知识，会做的题型。二、根据你所丢的分数，立即回归课本，看完课本后再做一遍。</strong>三、拿着卷子问自己，当时做对的题自己是怎么想的，不会的题当时是怎么想的，现在会的题和当时不会做时差距在哪里。</p><p><br/></p>','第一轮复习重点，先看课本再“精”做题目','很多学生问我高三如何规划才合理，这个问题我纳闷了好久。应该是每个人都有自己的规划周期，应当是结合自己的实际情况进行规划','1','1','2016-12-07 21:33:14','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('16','1','','2016-12-07 21:34:40','<p>&nbsp;1、查缺补漏整体把握每日一练必有好处现阶段的复习，要从整体上把握，考生可以浏览一下近几年高考试题，分析一下频繁出现的热点题型，梳理各学科的知识系 统，进行提纲挈领的高考复习，从例题上找点做题技巧。把需要记忆的东西背一下。关键是要稳住自己已有的水平的同时，查漏补缺。<br/>&nbsp; &nbsp;在高考最后十天这段时间里，不能钻难题，而应做点难度适中的基础题，甚至课本中的例题，高考最后十天理科想要逆袭600分就要掌握一定的基础知识。<br/><br/>　　2分析以前做错的试题下很近扭转错误思维平时复习所作的中考题或模拟题，基本上能覆盖高考的知识点。复习这些试题可算是一种便捷手段。着重分析自己做错 的题，找出错在哪里，出错的原因，加以克服。做错的题不注意，不下狠劲扭转自己的思维，考场上一旦遇到类似的题目还是会做错的。<br/>　　高考最后十天提分，要注重量的积累，这样才能有质的飞跃。<br/>　　3、高考战术重视考前心太切莫松懈有的同学认为临考该轻松轻松了。不过这好比狂奔的野马，一旦放开缰绳，就难以收回。正确的策略应该是一如既往、有条不紊，有计划，有安排的进行复习。<br/>　　高考压力肯定存在，关键如何对待。适当的压力可以增加战斗欲望，促使你兴奋起来，更好的迎接考试，但过大压力则影响正常的发挥。要把高考当作平时的训练。所谓重视即在做题过程中，要认真审题，会做的题一定要做对，难题不轻易放弃，能做一两步，多得一两分也是好的。<br/>　　以上是小编为考生提出的几种最后十天提分方法，无论在任何时，掌握一定的技巧是必要的，因为它会在你迷茫时帮助你找到出路，在此小编预祝广大考生高考一切顺利。</p>','高考最后十天：提分方法有哪些~','查缺补漏整体把握每日一练必有好处现阶段的复习，要从整体上把握，考生可以浏览一下近几年高考试题','1','1','2016-12-07 21:33:38','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('17','1','','2016-12-07 21:36:49','<p>今天看到的一篇有关就业的文章，就业是每年家长和考生最关心的话题。长久的工作不光只是薪酬还需要获得工作的成就感、价值感，愿意并快乐的去做，这也许更符合当下孩子对于工作的认知。</p><p>　　以下是转自中国报告大厅的文章：</p><p>　　好的专业包括四个原则：第一是兴趣原则，选感兴趣的专业;第二是优势原则，选最能体现自己的优势的专业;第三是创造原则，这个专业毕业以后从事的工作 应该是具有创造性的，而不是做简单重复的劳动;第四是利益原则，这个专业最好还是能挣钱的。“因兴趣而有动力，因优势而有能力，因创造而有潜力，因利益创 造收益”。下面为大家介绍以下一些前景不错的专业：</p><p>　　1.建筑类专业就业前景依然乐观</p><p>　　虽然近期房地产业面临系列压力，但在人才市场上，与房地产相关的专业，包括建筑、设计、策划、销售等人才需求仍然较旺。</p><p>　　随着国家和各地对基础设施投资力度的加大，建筑类和房地产专业毕业生就业前景依然乐观。</p><p>　　尤其是近两年来，路桥建设等相关专业开始升温，这使路桥规划人员变得畅销起来。用人单位表示，这主要与制造业升级换代及目前城市基础设施建设力度加大有关。制造业升级换代急需补充新鲜血液，基础设施建设力度加大则急需专业人才。</p><p>　　2.医学类专业特殊领域潜力无限</p><p>　　随着医疗体制改革的不断深化，将会有更多的私立医院，这使医学类专业的学生更为抢手。而且，由于人们工作、生活的压力不断增大，患病率也在增加，现有 的医疗系统不能完全满足社会的需要，这就形成了医疗行业的卖方市场。所以，医学类专业人才将会越来越吃香。据有关部门分析，将来从事老人医学的人才将走 俏，保健医师、家庭护士也将成为热门人才。另外，专门为个人服务的护理人员的需求量也将增大。</p><p>　　3.艺术类专业需求层次不断提升</p><p>　　传统的美术、音乐、表演等专业已经渐渐显露出就业面狭窄等问题。</p><p>　　传统艺术正与计算机技术、工业、建筑、管理等学科不断交叉，衍生出许多新的专业，这些专业也相应地成了近年来的热门。目前，广告设计、工业设计、建筑设计、环境艺术设计、公关策划、动漫制作、游戏策划、游戏设计等专业人才紧缺。</p><p>　　艺术专业正朝多学科综合的方向发展，实用艺术的应用范围越来越广。不懂物理和建筑，就无法搞建筑、装潢设计;不懂计算机就做不出数字化影音作品。文化课严重缺失的“跛脚”毕业生就业压力必然不小。</p><p>　　4.纯文、理专业掌握技能助就业</p><p>　　文科类毕业生(如文、史、哲专业)就业困难，由于社会对这类人才的需求有限，而且此类学科专业技能不强、替代性比较大，所以这些专业的学生就业受到限制。同样的问题也出现在着重基础研究的纯理科专业毕业生身上。</p><p>　　因此，文科类专业的学生不能只是简单掌握文案写作技能，还应掌握其他一些技术，如计算机知识、经济学知识、外语等，方能胜任未来相对要求较高的工作岗 位。在择业过程中，除了关注传统的求职项目，如企业行政助理、文秘等工作岗位之外，也应注意到媒体、出版、广告、市场营销等工作岗位的人才需求量比较大， 文科生比较占优势。而对做基础学科研究的纯理科专业的学生来说，如果平时善于积累，在热门行业也有后天优势：基本功扎实，入手快。这些专业的毕业生也可向 相关热门转向，比如转向IT、金融、教育等行业。</p><p>　　5.师范类专业区域供求不均衡</p><p>　　调查显示，工作的稳定性和自主性、待遇节节拔高等促使教师成为最受欢迎的职业之一。从大城市的就业状况来看，师范类学生的供求量趋近平衡，其中民办教 育机构(包括培训机构)对师范类人才的需求量占了很大比例。而在师范类各专业中，需求较大的专业有教育学、特殊教育、教育技术、数学、汉语言文学、英语、 日语、物理、计算机等专业。</p><p>　　由于我国教育政策的调整，近几年民办学校、职业学校大量兴起，这使得师范生就业机会增多，又在教育系统内为毕业生拓宽了就业市场。但不容忽视的是，我 国中西部面临优质师资匮乏、基层教育系统缺少编制的现实情况，而大城市教师职位日渐饱和，不可能再接收大量毕业生。因此，在普教系统就业面临较大的竞争和 压力。近两三年来，中西部省会城市及一些经济发达地区的二线甚至三线城市成为师范类毕业生求职的热点地区。</p><p>　　6.外语类专业就业去向多元化</p><p>　　随着中国与世界的交流逐渐深入，特别是上海世博会之后，我国对外语类人才的需求旺盛，应该说其就业前景是乐观的。从近几年需求情况看，需求量最大的是英语、日语。</p><p>　　此外，俄语、德语、法语、西班牙语、意大利语的需求也较大。这些语种的毕业生就业较为容易，高层次的外语人才供不应求。有专家预测，小语种将走向热门。</p><p>　　近年来，外语类毕业生去向已完全呈现多元化态势，除了传统的外交外事领域，越来越多的毕业生到金融、通信、传媒、咨询、体育、物流等领域就业。就业领 域的扩大无疑意味着就业机会的增加。那些具有扎实的语言功底，同时具备金融、法律、经贸、外交、新闻、中文等知识背景的外语类毕业生，契合社会对于复合型 人才的需求，直接推动着外语类人才培养模式的变革。</p><p>　　7.法学专业持证上岗是必然</p><p>　　从近几年的国家公务员录用可得知，政府部门对法学专业毕业生的需求依然旺盛。</p><p>　　从绝对数量上来说，我国对该专业的人才需求较大，特别是涉外专业的人才。立法机关、行政机关、司法机关、仲裁机构每年都要从应届毕业生中招聘法学专业 的学生，而企业对法学专业的人才也越来越重视，中国的律师行业更急需补充大量高素质的律师人才。但近年来法学专业毕业生在就业方面有相当的压力：一是社会 上对法学专业毕业生的学历要求越来越高;二是该专业毕业生人数激增。</p><p>　　因此，近年来法学专业毕业的本科生就业状况并不乐观，这一状况将持续一段时间。法学专业的研究生也将开始面临一定的就业压力，参加司法考试取得资格证书成为共识。</p><p>　　8.农林类专业创业实现自我</p><p>　　近几年来，国家对农业十分重视，不断加大投入。另外，政策方面也不断传来“利好”消息，产业结构的战略性调整和人们对生存环境的重视给农林类专业发展带来了曙光。因此，虽然农林类毕业生目前总体就业形势不如其他专业，但可以看到，今后几年该专业毕业生将会日益走俏。</p><p>　　在农林类各专业中，社会需求量大小不一。选准有发展前景的专业十分重要。未来需求较多的将有农业经济、畜牧、兽医、动物营养与饲料加工、木材加工、家具设计与制造、森林道路与桥梁、园林、林产化工等专业。</p><p>　　另外，农林类专业毕业生还有另一条广阔的就业之路，那就是到农村基层创业。到基层自办实业，积极创业，同样可以实现自我价值，而且更富有挑战性和创造性。</p><p>　　9.机械类专业前沿人才供不应求</p><p>　　机械类大部分专业毕业生在人才市场上仍然“热销”。国家近几年加大力度强化装备制造业，鉴于机械行业的重要性和庞大规模需要一支庞大的专业人才队伍， 今后一段时间内，社会对机械类人才仍会有较大需求。具有开发能力的数控人才将成为各企业争夺的目标，机械设计制造与加工专业人才近年也供不应求。</p><p>　　从当前机械行业的发展来看，印刷机械、数控机床、发电设备、工程机械等重头产品前景仍然看好。除了这些传统工业领域，该行业将进一步向机光电一体化发展，向光加工、环保这样的新兴领域拓展。</p><p>　　10.经济类专业需求热度不减</p><p>　　市场营销类职位是人才市场需求榜上不落的冠军，从有关统计数据推测，销售类人才未来几年需求量仍然热度不减。</p><p>　　在收入调查中，金融业整体薪金水平总是在众多行业中排名靠前，金融业高薪引才。这与金融业的人才需求和其不断调整及推出的增值服务有关系，一些新兴的金融服务机构也逐渐成为吸纳金融人才的大户。</p><p>　　经济类专业，尤其是金融、财会类毕业生，要与时俱进，熟悉国际会计、商务惯例，具有必要的国际社会文化背景知识，不断拓宽视野，立足现代市场经济新领 域，掌握现代管理学新知识，逐步把自己锻炼成为既懂经营又善管理的复合型人才。学生除了要具备熟练的常规业务能力之外，还要认真学习与专业相关的财政、金 融、税务、审计、统计等方面的知识，努力提高自身预测、决策、控制、抗风险的能力，提高投资、融资等财务决策的质量，完善经营管理。总之，这些专业的学生 在未来有较多的选择，除了人们所熟知的会计、审计、税务等工作外，从业领域还有很多。</p><p><br/></p>','2016年，我国十大行业就业前景分析','今天看到的一篇有关就业的文章，就业是每年家长和考生最关心的话题','1','1','2016-12-07 21:36:30','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('18','1','','2016-12-07 21:37:21','<h2>一、专业解析</h2><h3>什么是天文学</h3><p>天文学和物理、数学、生物等一样，是一门基础学科。它的主要内容是研究宇宙空间天体、宇宙的结构和发展，包括天体的 构造、性质和运行规律等，以各种现代尖端技术作为探测手段观测天体发射到地球的辐射，发现并测量它们的位置、探索它们的运动规律，研究它们的物理性质、化 学组成、内部结构、能量来源及其演化规律等。天文学大致可分为天体测量学、天体动力学、天体物理学三大研究领域。</p><p>学习天文学专业的同学在本科阶段大都会打下坚实的数学、物理基础，并掌握丰富的天文学理论知识。他们同时具备海量数据处理、天文学仪器使用、实验设计、整理分析实验结果并撰写实验论文等基础科研能力。另外，他们还会掌握熟练的计算机操作及优秀的英文写作、交流能力。</p><h3>本科阶段课程设置</h3><p>天文学专业在本科阶段的主要课程大体包括基础天文、天体物理（理论、实测）、量子力学、天文技术与方法、电动力学、理论力学、原子物理、恒星物理、计算天文学以及大学英语、线性代数、微积分、高等数学等公共课程。</p><p>以南京大学为例，天文学专业的必修课包括：普通天文学、普通天文学实习、原子物理、天体力学基础、球面天文、实测天 体物理、实测天体物理实习、理论天体物理、量子力学、电动力学、统计物理、理论力学、大学物理等。另外，还包括C语言程序设计、高等数学、微积分、线性代 数、大学英语等公共课程。</p><p>在系内选修课方面，天文学专业的学生选择也很丰富：宇宙学导论、初等数理天文、星系物理、X射线双星、航天器轨道力学、中子星物理、轨道设计基础、射电天体物理、高能宇宙探索、光学与红外实测天文、大学计算机应用等都可以自由选择。</p><h3>实操能力要求高</h3><p>天文学专业本科毕业生的就业方向大都集中在航天、国防、测地等天文学专业的应用型交叉学科或互联网、出版社、科技馆 和一些金融类企业，而这些地方的工作内容大都要求学生具备优秀的实操能力。所以天文学专业在本科阶段对学生的实际操作能力要求很高，在本科阶段，学生要掌 握应用仪器、天文实测、海量数据处理等实际操作能力以及过硬的英文交流、写作能力和扎实的计算机操作能力。</p><p>现在国内高校基本实现了专业大类培养模式，天文学专业也不例外。以南京大学为例，本科生在进入学校的前两年，学院会 按照大理科的培养模式对他们进行培养，打下坚实的理论基础；三年级时会根据学院的评估及学生自身的兴趣选择专业方向，分流培养，并前往南京大学天文系中心 实验室、中科院国家天文台、南京紫金山天文台、上海天文台、中科院南京天文光学技术研究所等科研单位从事天文观测、数据运算等科研实习，同时经常组织学生 参与国际间学术交流；实行导师制，由导师指导参加科研训练直至完成毕业论文。</p><p>顾秋生教授介绍，目前国内几所在本科阶段开设天文学专业的高校已经实现了优质教学资源共享，相互间合作紧密。天文学专业的学生可以自由吸纳国内一流高校的天文学相关知识。</p><table align=\"right\"><tbody><tr><td align=\"center\"><p><a href=\"http://gaokao.chsi.com.cn/gkxx/zybk/zt/201512/20151223/1515251283.html#top\">回顶部</a></p></td></tr></tbody></table><h2><a></a>二、专业与就业</h2><p><img title=\"\" src=\"http://gaokao.chsi.com.cn/news/file.do?method=downFile&id=1515251288\" alt=\"\"/></p><h3><strong>2/3的学生选择继续读研</strong></h3><p>在谈到天文学专业本科毕业生就业问题时，顾教授说：“最近两年我院天文学系本科毕业生人数总计约为100人，其中大约2/3的同学选择了继续读研深造。</p><p>另外，对于少部分没有在本专业继续深造的同学，顾教授表示：“由于天文学专业学生具备全面的综合能力，且天文学专业本科毕业生多出自名牌高校，社会认可度较高，所以就业的选择面十分广泛，连续多年就业率接近100%，超过了许多热门专业。”</p><h3><strong>毕业生选择十分宽广</strong></h3><p>在谈到天文学专业本科毕业生具体去向选择时，顾教授认为天文学专业的毕业生去向选择是十分宽广的。他给出了如下建议：</p><p><strong>1</strong><strong>、继续读研深造。</strong>对于那些有志于长期从事 天文学研究、教学工作的同学来说，继续读研深造，提升知识储备和研究能力无疑是最好的也是必须的选择。目前，南京大学、清华大学、北京大学、厦门大学、上 海交通大学等多所国内知名高校和麻省理工学院、斯坦福大学、加州大学伯克利分校等多所外国知名高校以及中科院国家天文台、紫金山天文台、德国马克思普朗克 天文与宇宙物理研究所等多个国际国内知名科研院所都在招收相关专业的研究生。</p><p><strong>2</strong><strong>、进入交叉学科相关部门、企业工作。</strong>天文学专业与航空航天、测地、国防等应用型学科属于交叉学科，而这些学科的相关企业单位（例如中国电子科技集团公司第十四研究所，上海宇航系统工程研究所，北京市遥感信息研究所等）每年对于优秀的天文学专业毕业生也有较大的需求。学生毕业后可以选择到这些地方工作。</p><p><strong>3</strong><strong>、进入科技类杂志社、出版社、网站等从事编辑类工作。</strong>天 文学专业在本科阶段非常注重培养学生的资料收集、海量数据处理以及过硬的计算机操作能力。而一些科技类的杂志社、出版社、网站（例如中国科学技术大学出版 社、上海世纪出版股份有限公司科技教育出版社以及各大商业网站的科技频道）都对具备专业知识的人才有大量需求。所以，这也是天文学本科毕业生的一个就业方 向。</p><p><strong>4、进入IT行业工作。</strong>天文学专业在本科阶段很注意培养学生的计算机操作、应用能力，毕业生也可以选择进入心仪的IT企业就业。</p><p><strong>5、进入金融行业就业。</strong>天文学专业的毕业生大都拥有坚实的数理基础和逻辑运算、分析能力。而许多金融类企业（例如普华永道中天会计师事务所、上海浦东发展银行、中国银行股份有限公司、国联证券等）都对具有这些优势的优秀毕业生求贤若渴。这也不失为一个选择方向。</p><p><strong>6</strong><strong>、考取公务员。</strong>现在许多公务员单位（例如地震局、气象局、海关等）都对在专业领域能力较强的优秀高校毕业生有一定需求。本专业学生毕业后也可选择考取公务员。</p><p><strong>7</strong><strong>、进入中等学校从事自然科学教学或进入科技馆、博物馆从事社会教学工作等。</strong>这些单位现在对于在专业领域有较强能力的人才也有大量需求。</p><h2><a></a>三、报考指南</h2><h3>6所高校开设天文学专业</h3><p>目前国内在本科阶段开设天文学专业的高校并不多，主要有南京大学、北京大学、北京师范大学、中国科学技术大学、厦门大学、云南大学6所高校。</p><p>在以上6所高校中，南京大学设有独立的天文与空间科学学院并内设天文学系；北京师范大学设有与学院同级的独立的天文学系；其余4所高校因专业设置的原因都将天文学系及天文学专业设置在物理学院中。</p><p>其中，南京大学天文与空间科学学院成立于2011年3月，其前身天文学系始建于1952年，是目前全国高校中历史最悠久、培养人才最多的天文学 专业院系。学院目前拥有塔式太阳望远镜、X-光衍射仪、高光谱分辨仪、米德望远镜、2米射电望远镜、从紫外到红外的室内/野外光谱仪、光学和近红外太阳爆 发探测望远镜等先进的科研、教学设备，并与法国巴黎天文台等多个国际知名科研机构建立了广泛合作关系。学院现在每年按照天文学类（天文学、空间科学和技 术）大类招生，招生计划约50人。有意的考生和家长可关注学校每年发布的招生简章及招生计划。</p><h3>招生方式略有不同</h3><p>对于想要报考天文学专业的考生，一定要注意各院校招生方式的不同。北京大学天文学系虽然设置在物理学院中，但在招生时则是单独招生（即招生计划 由天文学系单独制定，不占用物理学院招生计划）；北京师范大学则采取自主招生方式招收天文学专业本科生（考生需先参加由学校自行组织的自主招生考试，待考 试合格，获得入选资格后，方可在高考填报志愿时填报该专业）。报考时，需仔细阅读各学校的招生章程。</p><h3>注意各高校大类招生名称</h3><p>还要提醒考生注意的是，部分学校虽然招收天文学专业学生，但在招生计划上却并不全是按照“天文学”这一专业招生，有些学校是按照大类专业招生， 例如南京大学每年按照天文学类（天文学、空间科学和技术）大类招收本科生,厦门大学每年在物理学大类下招收天文学专业本科生。考生要认真阅读各学校当年的 招生简章及招生计划，以免影响志愿填报。</p><h3>什么样的考生适合报考天文学专业?</h3><p>到底什么样的学生适合报考天文学专业呢？顾教授建议：</p><p><strong>首先，对天文学有浓厚的兴趣。</strong>“兴趣是最好的老师”，对于一门学科有浓厚的兴趣，是学好它的基本前提。如果考生本身对于天文学并无多大兴趣，那么建议谨慎选择该专业。</p><p><strong>其次，良好的数学、物理基础和英文交流、写作能力。</strong>虽然天文学专业对于考生的数学、物理两门课的成绩没有特 殊要求。但数学、物理是天文学两门最为重要的基础学科。如果考生在这两方面基础薄弱或对这两门课程不感兴趣的话，建议谨慎报考天文学专业。另外天文学专业 在本科培养过程中非常重视国际交流，许多天文学核心期刊都以英文出版，因此良好的英文交流、写作能力也是必不可少的。</p><p><strong>最后，要具备较强的计算机操作能力。</strong>计算机是天文学数据处理和理论计算的主要工具，学习天文学的学生必须对于计算机操作感兴趣并有良好的计算机操作能力。</p><p><br/></p>','天文学：探索浩瀚星空','天文学和物理、数学、生物等一样，是一门基础学科。它的主要内容是研究宇宙空间天体、宇宙的结构和发展，包括天体的 构造、性质和运行规律等','1','1','2016-12-07 21:36:50','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('19','1','','2016-12-07 21:37:52','<h2>一、专业解析</h2><h3>什么是智能科学与技术专业？</h3><p>智能科学与技术是工学门类中计算机专业类下的特设专业。2003年，该专业由北京大学智能科学系提请建立，并在2004年开始招收首批本科生。在随后的十多年中，北京邮电大学、北京信息科技大学、北京科技大学等高校先后开设了智能科学与技术专业。</p><p>智能科学与技术本科专业是一门融合了电气、计算机、传感、通讯、控制等众多学科领域，多学科相互合作、相互研究的跨学科专业。它涉及机器人技术、微电子机械系统、以新一代网络计算为基础的智能系统，以及与国民经济、工业生产及日常生活密切相关的各类智能技术与系统等。</p><p>北京信息科技大学自动化学院院长刘小河说，智能科学与技术专业的内涵基本包含两部分内容，一部分是智能科学，另一部分是智能技术。</p><p>智能科学是探索人的自然智能的工作机理，主要以如何认知和学习为研究对象，探索智能机器的实现机理和方法。智能技术则是将这种方法应用于人造系统，研制各类人工智能系统，让它具有一定的智能，能够根据环境及条件的变化自主进行逻辑判断并决定工作的模式，或者具备一定的学习能力，通过训练学习的方式解决较复杂的问题，从而将人类从很多复杂的活动中解脱出来，让机器系统为人类工作。</p><h3>该专业不是教如何制造机器人的</h3><p>有些考生认为智能科学与技术专业有“智能”两个字，就一定是学习如何制造机器人的专业，其实并非如此。智能科学与技术专业并不教学生如何制造机器人。制造机器人相当于制造人的四肢，需要考虑硬件标准是否合乎工作要求。而智能科学与技术专业要做的是在硬件基础上，给机器人赋予一个类似人的大脑、神经传导及信息处理系统，让这个机器大脑通过一定的方式判断、决策并控制机器人如何行动，使得机器人最有效地发挥作用。</p><h3>智能科学与技术学什么？</h3><p>目前，国内招收智能科学与技术专业的各学校还没有完全统一的专业培养模式。</p><p>一般而言，学生要学习三大类课程。第一类是工科通识类课程，包括自然科学基础、高等数学、普通物理、计算机基础，等等。第二类是信息技术类专业基础课，如电路分析、数字电子技术、模拟电子技术、计算机软件基础、微机原理及接口技术等。</p><p>第三类是核心专业课程，这类课程各学校根据自身的专业特色及教师背景有所区别。北信科大主要偏重三方面：一是信息处理方面的课程，包括数字信号处理、智能传感与检测技术、模式识别、图像处理、智能信息处理等课程，既与信息处理相关又照顾了机器人这个背景。二是智能与控制方面的课程，如控制理论基础、人工神经网络、模糊控制、智能机器人等课程，偏重于智能控制；三是基于计算机科学的人工智能方面的课程，如计算机网络、人工智能、机器人学、数据挖掘与处理、机器学习、专家系统等。<a></a></p><h2><a></a>二、专业与就业</h2><p>教育部最新公布的统计数据显示，智能科学与技术专业的全国毕业生规模在800人左右，近三年就业率在95%左右。根据某第三方调查机构公布的中国大学专业就业数据显示，智能科学与技术专业学生毕业5年后的平均月薪为7756元。</p><p>智能科学与技术专业毕业生就业前景光明，以北京大学为例，该校智能科学与技术专业毕业生有些进入百度、摩根IT、IBM等知名IT公司工作，有些在毕马威、中石化等公司的管理岗位任职，还有部分毕业生进入国家部委科技部门。</p><p>大连东软信息学院校长温涛说，该专业主要面向的就业领域包括电子信息、自动控制、计算机、智能科学与技术等相关领域毕业生主要从事产品开发、系统测试、技术支持与咨询、产品销售等工作，以及各类学校及科研院所从事相应的教学、科研等工作。</p><h2><a></a>三、报考指南</h2><p>目前，全国仅有20多所高校招收智能科学与技术专业，其中，开设该专业较早的高校有北京大学、北京邮电大学、南开大学、西安电子科技大学、华南理工大学、中南大学、中山大学、北京科技大学、厦门大学、东北电力大学、首都师范大学、北京信息科技大学、西安邮电大学等。近几年，华南理工大学、大连东软信息学院等院校也新开设了该专业。</p><p>智能科学与技术专业的录取平均分一般略低于计算机科学与技术等专业。从2015年北京邮电大学在山东省的专业录取分数来看，智能科学与技术专业的录取平均分为664分，排在通信工程、信息工程、计算机科学与技术、自动化等专业之后，位列该校在山东理科招生专业的第7（北邮2015年理科在山东共有24个专业招生）。再以华南理工大学在广东省的录取分数统计为例，该校智能科学与技术专业的录取平均分为641分，排在信息工程、计算机科学与技术等专业之后，位列该校在广东理科招生专业的第27（华南理工2015年理科在广东共有91个专业招生）。</p><h3>部分高校的智能科学与技术专业按大类招生</h3><p>在报考智能科学与技术专业时，考生要特别注意部分高校是按大类招生，而且，不同的高校将该专业划分在不同的大类中，如北京大学将其划分在电子信息类，中山大学和南开大学划分在自动化大类，重庆邮电大学和厦门大学划分在计算机大类。因此，考生在报考前要详细了解高校对智能科学与技术专业的大类划分，以免报错专业。</p><h3>专业推荐</h3><p>推荐专业源自高校学生实名推荐数据。当前累计投票数量超过<strong>317万</strong>人次。通过实名注册的高年级学生或毕业生，根据本校各专业办学情况进行投票，推荐优势专业或特色专业。下图仅展示了部分高校<strong>智能科学与技术</strong>专业推荐情况，星号为推荐指数。</p><p><img title=\"推荐指数\" src=\"/ueditor/php/upload/image/20161207/1481117862979438.png\" alt=\"推荐指数\" width=\"640\" height=\"215\"/></p><p><br/></p>','智能科学与技术专业：给机器人赋予“大脑”','智能科学与技术是工学门类中计算机专业类下的特设专业。2003年，该专业由北京大学智能科学系提请建立，','1','1','2016-12-07 21:37:22','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('20','1','','2016-12-07 21:38:25','<p><strong>第一类：望文生义</strong></p><p>　　<strong>生物医学工程不是医学类专业</strong></p><p>　　实际上，生物医学工程不归医学类专业管辖，而是不折不扣的工科专业。毕业生既可以在现代医疗仪器、电子技术、计算机及信息技术等高新技术产业从 事研究、设计、制造与应用工作，也可以在各类医院从事临床工程技术服务方面的工作，或从事通用医疗器械设备的操作使用、维护维修和采购管理等工作。查询专 业名单及开设院校</p><p>　　至于工商管理类，毕业以后拿的学位是管理学学士，并不是经济学学士。</p><p>　　<strong>精算数学不属于数学类</strong></p><p>　　事实上，精算数学是金融保险学科旗下的专业，精算师的前程无可限量，可以在商业银行、金融中介、投资、社会福利、政府咨询和监管等机构，从事评估承保风险、厘定保险费率、安排分保额、进行偿付测试等工作。</p><p>　　<strong>数学与应用数学不仅仅是算数</strong></p><p>　　数学与应用数学专业是联系数学与自然科学、工程技术及信息、管理、经济、金融、社会和人文科学的一个重要桥梁。所以从这个专业毕业后，可以胜任 科研机构、政府机关、企业的相关技术工作和管理工作，或在生产、经营及管理部门从事实际应用、开发研究工作。更有很多毕业生在大型软件公司从事编程工作， 不止“数学老师”一条路可走。</p><p>　　<strong>信息资源管理与图书馆有关</strong></p><p>　　信息资源管理可绝不是计算机类专业，而是一个正宗的管理学类专业。由于信息资源管理学是与社会需求较为接近的新兴学科，因此，毕业生适应性较强，就业前景看好，大多在高校、企事业单位、信息服务机构等从事知识管理、信息分析、信息利用和知识服务等工作。</p><p>　　<strong>第二类：旧瓶装新酒</strong></p><p>　　<strong>信息与计算科学离计算机很远</strong></p><p>　　信息与计算科学专业实际上市属于数学学科，离计算机学科差着十万八千里。信息与计算科学是以信息领域为背景，将数学与信息、管理相结合的交叉学科。着眼于培养不仅数学功底扎实，而且掌握信息科学和计算科学的理论与方法的数学人才。</p><p>　　<strong>考古学不仅仅是找古迹</strong></p><p>　　其实，考古学专业的毕业生可以到高等院校、博物馆及文物保护等单位从事考古发掘与研究、文物鉴定保护及历史类教学等工作。所以这么说起来，挖地的苦力活可不是咱们考古学专业毕业生的唯一出路。</p><p>　　<strong>哲学不仅仅是“老学究”</strong></p><p>　　认为哲学专业是找不到工作的专业，那大家可就错了。哲学号称是一门“可以让人变得聪明的学问”，毕业生不仅可以去研究所或国家机关从事研究工作 或考取公务员（课程），学校、研究机构和宣传、出版、新闻、文化部门等有关单位也是不错的选择。而且现在很多国家机关和国家职能部门也“看”上了哲学专业 毕业生缜密的逻辑思维能力，这在工作中非常重要。可以说，哲学专业的就业口径非常宽。</p><p>　　<strong>地质学不仅仅是挖矿</strong></p><p>　　如今地质学在解决能源、资源、生态环境、防止自然灾害和开发新型材料的工作中都起到重要作用，而不仅仅只是挖地找矿了。地质学专业的同学毕业后 可以在能源、交通、矿业、冶金、建材等企事业单位寻找到合适的就业机会。选专业之前，家长、考生要参考往年考生去向报志愿，更易规避高分低就，高分落榜的 分险。</p><p>　　<strong>地理信息系统不仅是地理学科</strong></p><p>　　地理信息系统可不是地理类的基础学科，它是一门“地理”加“计算机技术”的交叉学科。毕业后，可在国土管理、城市管理、规划管理、交通、农业、电力、电信、环保、国防、军事、公安等部门及有关科研单位从事信息系统的设计、开发建立、维护管理和信息处理分析工作。</p><p>　　<strong>第三类：专业非职业</strong></p><p>　　<strong>环境科学≠治理污水</strong></p><p>　　环境科学专业，要学习的可不止打扫卫生和净化污水那么简单，它调节的是整个人类生存环境的平衡，做的可是大事业！毕业后，可从事环境科学研究及 环境监测、评价、管理和规划等工作；从事环保产品的开发，从事环境工程和给水排水工程的规划、设计和管理；或者担任大中专院校相应课程的教师。这些都是不 错的就业选择。</p><p>　　<strong>财政学≠财务工作者</strong></p><p>　　财政学本身是一个宏观含义很浓重的专业，大学本科阶段学的是宏观财政学，所以早期的财政学专业毕业生大部分进了国家税务机关。</p><p>　　其实，该专业毕业生就业真正方向应该是税收，譬如从事税收规划、资产管理、审计等工作，就业前景还是相当不错的。</p><p>　　<strong>园林≠园丁</strong></p><p>　　这个专业可不光是种植物，还要在城市建设、森林公园经营、房地产建设中进行风景园林规划与设计。毕业生可到城市规划、城市建设、园林、风景名胜 区、旅游、林业、环境保护等部门以及厂矿企业、花木企业从事风景与园林的应用研究、科技开发、生产技术及管理工作。最近的人才市场上，园林设计类人才可是 “抢手货”。</p><p>　　<strong>心理学≠心理医生</strong></p><p>　　没错，心理学士培养心理医生的摇篮，但实际上，心理学专业涉及的方面还多着呢，包括个科研部门、高等和中等学校、企事业单位，还有公安局、劳教所、监狱、边检站等都是可能的去处。个人性格和能力是专业选择职业规划的重要因素，了解自身才能更好选择匹配的专业。</p><p>　　<strong>护理学≠当护士</strong></p><p>　　除了当护士外，改专业毕业还可以从事临床各科专业护理师、社区健康教育者、保健产品经理或顾问，甚至是教师或健康报刊记者。</p><p><br/></p>','以实物为准：你被这些专业名骗了吗？','生物医学工程不是医学类专业，精算数学不属于数学类','1','1','2016-12-07 21:37:53','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('21','1','','2016-12-07 21:38:55','<p>热门专业年年都吸引大批考生填报，但是热门专业一定能找到好工作吗？哪些行业就业前景广阔？小编特为大家总结找工作走俏职场的高考专业，指导考生依据职业定位选择专业，填报志愿，当然此处仅供参考~小伙伴们仍需多方面参考，做出抉择哟~</p><p>　　▼<strong>电气工程</strong></p><p>　　电力行业无疑是最有实力的行业之一，目前电力行业最好找工作的是电气工程及其自动化专业。</p><p>　　与电气工程有关的系统运行、自动控制、电力电子技术、信息处理、研制开发、经济管理以及电子与计算机技术应用等领域工作的宽口径“应用型”高级工程技术人才在人才市场上供不应求。专业介绍：</p><p>　　业务培养目标：本专业培养能够从事与电气工程有关的系统运行、自动控制、电力电子技术、信息处理、试验分析、研制开发、经济管理以及电子与计算机技术应用等领域工作的宽口径“复合型”高级工程技术人才。</p><p>　　业务培养要求：本专业学生主要学习电工技术、电子技术、信息控制、计算机技术等方面较宽广的工程技术基础和一定的专业知识。本专业 主要特点是强弱电结合、电工技术与电子技术相结合、软件与硬件结合、元件与系统结合，学生受到电工电子、信息控制及计算机技术方面的基本训练，具有解决电 气工程技术分析与控制技术问题的基本能力。</p><p>　　毕业生应获得以下几方面的知识和能力：</p><p>　　1.掌握较扎实的数学、物理、化学等自然科学的基础知识，具有较好的人文社会科学和管理科学基础和外语综合能力；</p><p>　　2.系统地掌握本专业领域必需的较宽的技术基础理论知识，主要包括电工理论、电子技术、信息处理、控制理论、计算机软硬件基本原理与应用等；</p><p>　　3.获得较好的工程实践训练，具有较熟练的计算机应用能力；</p><p>　　4.具有本专业领域内1--2个专业方向的专业知识与技能，了解本专业学科前沿的发展趋势；</p><p>　　5.具有较强的工作适应能力，具备一定的科学研究、科技开发和组织管理的实际工作能力。</p><p>　　主干学科：电气工程、计算机科学与技术、控制科学与工程。</p><p>　　主要课程：电路原理、电子技术基础、电机学、电力电子技术、电力拖动与控制、计算机技术、信号与系统、控制理论等。</p><p>　　主要实践性教学环节：包括电路与电子技术实验、电子工艺实习、金工实习、计算机软件实践及硬件实践、课程设计、生产实习、毕业设计。</p><p>　　▼&nbsp;<strong>物业管理</strong></p><p>　　近几年，物业管理专业毕业生开始紧俏起来，主要是大型物业公司对人才的需求量较大，比如宾馆、饭店、住宅小区的物业公司等。</p><p>　　专业介绍：</p><p>　　专业培养目标：培养掌握现代物业管理基本理论基础知识，具有一定物业管理能力和熟练服务技能的高级管理专门人才。</p><p>　　专业核心能力：现代物业管理与服务。</p><p>　　专业核心课程与主要实践环节：物业管理法规、物业设备维护与管理、房屋维修与预算，、物业统计、物业会计与财务管理、物业管理实 务、客户心理学、房地产市场营销、职能建筑管理、合同管理以及各校的主要特色课程和实践环节。物业设备维护管理实训、物业智能化管理毕业论文、毕业实习 等，以及各校的主要特色课程和实践环节。</p><p>　　可设置的专业方向：</p><p>　　就业面向：住宅小区、商业大厦、写字楼等物业管理部门。</p><p>　　其他：本专业可获取劳动部物业管理员(师)中级职业技术证书。</p><p>　　▼&nbsp;<strong>烹饪专业</strong></p><p>　　一名烹饪专业优秀毕业生，特别是高档餐厅主厨月薪可达到8000元以上。</p><p>　　社会对这一专业人才的需求量却居高不下。文化基础、专业理论和技术性较强，尤其具备营养学与食品科学方面知识，烹饪专业的学生供不应求。</p><p>　　专业介绍：</p><p>　　专业培养目标：培养掌握现代烹饪、营养、餐饮管理的基本知识，具有较强烹饪技术，能从事烹饪操作、营养分析与营养配餐，以及餐饮业管理的高级技术应用性专门人才。</p><p>　　专业核心能力：烹饪操作技能、营养分析与营养配餐能力。</p><p>　　专业主干课程与主要实践环节：烹饪学概论、烹饪原料知识、烹饪原料加工技术、食品雕刻、烹饪工艺、面点工艺、冷菜工艺、西餐工艺、 宴席设计、烹饪营养与卫生、药膳学概论、食疗概论与养生、餐饮市场营销、餐饮管理、中西餐烹饪技术实训、创新菜研发、烹饪技术与饭店餐饮管理综合实习、毕 业论文等，以及各校的主要特色课程和实践环节。</p><p>　　可设置的专业方向：</p><p>　　就业面向：旅游饭店餐饮部、社会中高档餐馆业的烹饪技术岗位、营养分析与营养配餐岗位与餐饮管理岗位。</p><p>　　其他：本专业可获取劳动部中式烹调师、西式烹调师、中式面点师、西式面点师、调酒师中级职业技术证书。</p><p>　　▼&nbsp;<strong>建筑设计</strong></p><p>　　只要有一定的方案设计能力，熟练使用设计软件，这类人才不难找到工作。最受青睐的是正规院校本专业本科或以上学历，有大中型公共建筑设计经验者，或者有一年以上甲级设计院工作经历或优秀应届毕业生。</p><p>　　专业介绍：</p><p>　　业务培养目标：本专业培养具备建筑设计、城市设计、室内设计等方面的知识，能在设计部门从事设计工作，并具有多种职业适应能力的通用型、复合型高级工程技术人才。</p><p>　　业务培养要求：本专业学生主要学习建筑设计、城市规划原理、建筑工程技术等方面的基本理论与基本知识，受到建筑设计等方面的基本训练，具有项目策划、建筑设计方案和建筑施工图绘制等方面的基本能力。</p><p>　　毕业生应获得以下几方面的知识和能力：</p><p>　　l.具有较扎实的自然科学基础、较好的人文社会科学基础和外语语言综合能力；</p><p>　　2.掌握建筑设计的基本原理和方法，具有独立进行建筑设计和用多种方式表达设计意图的能力以及具有初步的计算机文字、图形、数据的处理能力；</p><p>　　3.了解中外建筑历史的发展规律，掌握人的生理、心理、行为与建筑环境的关系，与建筑有关的经济知识、社会文化习俗、法律与法规的基本知识，以及建筑边缘学科与交叉学科的相关知识；</p><p>　　4.初步掌握建筑结构及建筑设备体系与建筑的安全、经济、适用、美观的关系的基本知识，建筑构造的原理与方法，常用建筑材料及新材料的性能。具有合理选用和一定的综合应用能力，并具有一定的多工种间组织协调能力；</p><p>　　5.具有项目前期策划、建筑设计方案和建筑施工图绘制的能力，具有建筑美学的修养。</p><p>　　主干学科：建筑学</p><p>　　主要课程：建筑设计基础、建筑设计及原理、中外建筑历史、建筑结构与建筑力学、建筑构造。</p><p>　　主要实践性教学环节：包括美术实习、工地实习、建筑测绘实习、建筑认识实习、设计院生产实习，一般安排40周。</p><p>　　▼&nbsp;<strong>游戏开发</strong></p><p>　　游戏开发专业人才供不应求的直接反映就是薪酬普遍较高：游戏策划平均月薪5000元，美术设计月薪5000元-8000元，程序开发月薪5000元-1.5万元。</p><p>　　▼&nbsp;<strong>人力资源管理</strong></p><p>　　人力资源管理等近年新开设的专业一直是就业的亮点。一位人事经理的待遇高达每月7000元左右，而一位人事总监的年薪高者可达50多万元，甚至更多。</p><p>　　从目前的竞争热度看，虽然竞争最为激烈的是人力资源职位，但它又是最好就业的专业之一，这主要来源于企业的巨大需求。</p><p>　　专业介绍：</p><p>　　业务培养目标：本专业培养具备管理、经济、法律及人力资源管理等方面的知识和能力，能在事业单位及政府部门从事人力资源管理以及教学、科研方面工作的工商管理学科高级专门人才。</p><p>　　业务培养要求：本专业学生上要学习管理学、经济学及人力资源管理方面的基本理论和基本知识，受到人力资源管理方法与技巧方面的基本训练，具有分析和解决人力资源管理问题的基本能力。</p><p>　　毕业生应获得以下几方面的知识和能力：</p><p>　　1.掌握管理学、经济学及人力资源管理的基本理论、基本知识；</p><p>　　2.掌握人力资源管理的定性、定量分析方法；</p><p>　　3.具有较强的语言与文字表达、人际沟通、组织协调及领导的基本能力；</p><p>　　4.熟悉与人力资源管理有关的方针、政策及法规；</p><p>　　5.了解本学科理论前沿与发展动态；</p><p>　　6.掌握文献检索、资料查询的基本方法，具有一定科学研究和实际工作能力。</p><p>　　主干学科：经济学、工商管理</p><p>　　主要课程：管理学、微观经济学、宏观经济学、管理信息系统，统计学、会计学、财务管理、市场营销、经济法、人力资源管理、组织行为学、劳动经济学。</p><p>　　主要实践性教学环节：包括课程实习与毕业实习，一般安排10-12周。</p><p>　　▼&nbsp;<strong>机械设计</strong></p><p>　　机械专业的毕业生就业率一直居高不下，目前一名中高级技术人员年薪至少在2.5万元，工程师能拿到20万元年薪，而且上不封顶。</p><p>　　目前很多机械类企业都急需人才，如果具有机械专业硕士学历，熟练的英语运用能力及一定的实践经验，往往成为企业重点保护的人才，也是猎头的目标。</p><p>　　专业介绍：</p><p>　　业务培养目标：本专业培养具备机械设计制造基础知识与应用能力，能在工业生产第一线从事机械制造领域内的设计制造、科技开发、应用研究、运行管理和经营销售等方面工作的高级工程技术人才。</p><p>　　业务培养要求：本专业学生主要学习机械设计与制造的基础理论，学习微电子技术、计算机技术和信息处理技术的基本知识，受到现代机械工程师的基本训练，具有进行机械产品设计、制造及设备控制、生产组织管理的基本能力。</p><p>　　毕业生应获得以下几方面的知识和能力：</p><p>　　1.具有较扎实的自然科学基础、较好的人文、艺术和社会科学基础及正确运用本国语言、文字的表达能力；</p><p>　　2.较系统地掌握本专业领域宽广的技术理论基础知识，主要包括力学、机械学、电工与电子技术、机械工程材料、机械设计工程学、机械制造基础、自动化基础、市场经济及企业管理等基础知识；</p><p>　　3.具有本专业必需的制图、计算、实验、测试、文献检索和基本工艺操作等基本技能；</p><p>　　4.具有本专业领域内某个专业方向所必要的专业知识，了解其科学前沿及发展趋势；</p><p>　　5.具有初步的科学研究、科技开发及组织管理能力；</p><p>　　6.具有较强的自学能力和创新意识。</p><p>　　主干学科：力学、机械工程。</p><p>　　主要课程：工程力学、机械设计基础、电工与电子技术、微型计算机原理及应用、机械工程材料、制造技术基础。</p><p>　　主要实践性教学环节：包括军训，金工、电工、电子实习，认识实习，生产实习，社会实践，课程设计，毕业设计(论文)等，一般应安排40周以上。</p><p><br/></p>','如果没有选择这些专业，你将错失一票就业良机！','热门专业年年都吸引大批考生填报，但是热门专业一定能找到好工作吗？哪些行业就业前景广阔？小编特为大家总结找工作走俏职场的高考专业','1','1','2016-12-07 21:38:26','','0','','','0','{\"thumb\":\"\"}','0','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('22','1','','2016-12-07 21:39:30','<h1><span>——</span><span>有人已经考完知道部分科目成绩了，而有人却还在准备考试。话说，期末考试时流的汗就是选专业时脑子进的水啊！</span></h1><h1><strong>Top 1 医学</strong></h1><p><strong>&nbsp;羡慕那些只需要背书或者只需要理解就可以度过期末考试的专业，因为每一个医学生想要通过及格线，就必须要会背且理解。</strong></p><p>　　一本非常厚的专业书里全都是“分开来认识、拼一起却不认识”的专业词句，看一遍就很辛苦了，看完还要归纳重点，结果发现每一句都是重点！少了任何一句都不能充分理解概念，简直就是不离不弃！</p><p>　　而且医学英语（精品课）还那么那么那么长，却不得不咬牙背下来——期末考试还有不少题是英文的。</p><p><strong><strong>Top 2 法学</strong></strong></p><p>&nbsp;&nbsp;看多了《何以笙箫默》，就以为法学轻松得整天小清新逛校园了？事实上，当板砖一样厚的专业书一摞一摞堆在书桌上，纠结复杂的案例一波又一波地向你袭来的时候，你根本没时间去管自己今天要用什么颜色的发卡、涂什么颜色的口红！</p><p>　　一到期末，你整个人就像是吃了炫迈一样，根本停不下来，背书背得做梦都在被法理学追着打。</p><p><strong>Top 3 数学</strong></p><p>&nbsp; 当别的专业的孩子风花雪月聊星星月亮的时候，数学的孩子在刷题；当别的专业的孩子在吃着零食看韩剧日剧的时候，数学的孩子在刷题；当别的专业的孩子考前再准备努力的时候，数学的孩子在刷题！</p><p>　　从数学分析、高等代数、解析几何概率论等一系列的题刷过去，刷掉了多少脑细胞和头发。一结束考试就忍不住照照镜子，生怕自己因为用脑过度而进入了早秃的行列。</p><p><strong>Top 4 经济学</strong></p><p>&nbsp;&nbsp;课程听上去都挺高大上的，比如国际贸易实务，比如企业管理，但是考试难度也和其高大上的定位一样，让人感觉遥不可及的高端。除了要背书之外，还动不动就要写点论文。别人在自习教室里吃着薯片刷日剧，自己只能捧着专业书念念有词。人和人之间的差别咋这么大呢？！</p><p><strong>Top 5 会计</strong></p><p>&nbsp; 财务会计、成本会计、中级财务会计、高级财务会计、审计学、会计理论、战略成本管理、高级财务管理、税务筹划、内部审计、并购财务学……会计专业一个学期的书可以垒起一座墙。你以为会计都是数学吧，结果要背的东西一堆；你以为会计是文科吧，数学能够折腾死你。</p><p><strong>Top 6 软件工程</strong></p><p>&nbsp; 一到学期末，同样是打印PPT和复习资料，自己的打印成果不但又厚又重，还根本就看不懂。各种概念折腾到死，有人脉的还能去找学长学姐讨要资料和考 试重 点，没人脉的只能跪求老师一定要手下留情。每天背书复习到晚上两点都不敢去睡，生怕睡过去就忘记了，对着游戏都能在脑内自动生成其代码。</p><p>　　除了累得像狗、黑眼圈像国宝、体重像降落伞下降、精神像保险丝……以外，也没什么不好嘛。</p><p><strong>Top 7 建筑学</strong></p><p>&nbsp; 做得了模型、画得来正图，还要会用各种专业软件，熬得过无尽的通宵；上要提笔说大师理论，与老师、考卷题互相扯淡；下要下得了农村基层做市场调研。问题是每到期末人家只要苦四年，可你得苦五年。幸好还有医学生们陪着你。</p><p><strong>Top 8 通信工程</strong></p><p>&nbsp;&nbsp;仅大一阶段每周就塞满了课。基本上一个礼拜有三个晚上都有课要上，哪怕是其它专业都很清闲的大四阶段，依旧是排课不断。</p><p>　　如此多的课程，到了期末考试根本忙不过来，人家电视剧播着《朝五晚九》谈情说爱好不快活，自己却是朝六晚十一哭着背泰勒拉普拉斯傅里叶。</p><p><strong>Top 9 小语种</strong></p><p>&nbsp;&nbsp; 每一天都要六点多起来，早自习、晨读，晚上还要赶作业。抄写啊，感觉回到了小学时代有没有？到了期末考更是惨烈。</p><p>　　“周末出去玩吗？”“玩你妹，我还要背单词背句型背课文。”</p><p>　　“这一科考完之后一起去逛街吗？”“去你妹，接下来还要做/听精读和泛读，还要练翻译写作和对话。”</p><p>　　结果你都这么努力复习了，拿到考卷的时候还是忍不住有一种“卧槽这句话说得好有道理我听着就觉得好耳熟可是为什么我就是翻不出来？！”的无力感。</p><p><strong>Top 10 护理专业</strong></p><p>&nbsp; 别人上课，选修的是天文艺术音乐电影赏析，护理专业上课，选修的是社区护理、老年护理、心理学等。别人周末约会看电影，护理专业周末解剖实验课药学实验课，整天看到的不是白老鼠就是小兔子，要么就是人的肌肉和骨头，复习到后来，看到大骨汤都忍不住想要解析一下再动筷。</p><p><br/></p>','回回期末胜高考的几大专业！','有人已经考完知道部分科目成绩了，而有人却还在准备考试。话说，期末考试时流的汗就是选专业时脑子进的水啊！','1','1','2016-12-07 21:38:56','','0','','','0','{\"thumb\":\"\"}','0','0','0','0');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('23','1','','2016-12-07 21:39:53','<p><strong>国际经济与贸易</strong></p><p>　　中国加入WTO后，对于国际经济与贸易专业人才的需求量大增，这使得国际经济与贸易专业就业形势一片大好。从国际经济与贸易专业就业现状看，随着中国与其他国家经贸往来的日益频繁，未来国际经济与贸易专业学生将会有更大的发展空间。</p><p>　　中国加入WTO后，对于国际经济与贸易专业人才的需求量大增，这使得国际经济与贸易专业就业形势一片大好。北京外国语大学网络教育学院(简称北外网院)的老师表示，从国际经济与贸易专业就业现状看，随着中国与其他国家经贸往来的日益频繁，未来国际经济与贸易专业学生将会有更大的发展空间。</p><p>　　<strong>中药学</strong></p><p>　　中药学专业主要培养具备中药学基础理论和知识，能在中药生产、检验、流通、使用及研究开发领域，从事中药鉴定、科研、制剂及临床合理用药、药品监督检验等方面工作的中药学技术人才，主干学科包括中药学、药学、中医学等。中药学专业对学生的数学、物理等学科成绩要求不高，为文科生的报考降低了“门槛”。</p><p>　　中药学专业是很有发展前景的。西药疗效迅速，但化学制剂副作用大，天然的中药却无毒无副作用，这使人们开始重新认识中药。目前除了日本、朝鲜以及马来西亚等东</p><p>　　<strong>金融学</strong></p><p>　　金融学专业对学生的数学水平要求较高，因此适合数学成绩不错的文科生选择。</p><p>　　金融学专业近年来一直是考生报考的热门专业，该专业毕业生职业发展前景好、收入高，是吸引众多考生报考的重要原因。也被人们戏称为最有“钱”途的专业。</p><p>　　在薪酬最高的专业排名中，金融毫无疑问位居榜首。不管是在哪个口径统计出来的薪酬数据中，金融行业都位居前列。随着中国经济的逐步转型，资本的力量会在今后越来越凸现出来。而长袖善舞的金融业人士，无疑会成为人人羡慕的高薪阶层。</p><p>　　<strong>新闻学</strong></p><p>　　未来几年我国的新闻传播业将快速发展，对专业人才的需求量较大。但随着国内新闻传播业的迅速整合，对新闻人才的需求也会逐步提高“门槛”。有志于报道天下大事的学生，无论你是学文还是学理，都可以报考这个专业。</p><p><br/></p>','文理皆收”的四大热门专业！！','中国加入WTO后，对于国际经济与贸易专业人才的需求量大增，这使得国际经济与贸易专业就业形势一片大好。从国际经济与贸易专业就业现状看，随着中国与其他国家经贸往来的日益频繁，未来国际经济与贸易专业学生将会有更大的发展空间。','1','1','2016-12-07 21:39:31','','0','','','0','{\"thumb\":\"\"}','3','0','0','1');
INSERT INTO yxt_posts ( `id`, `post_author`, `post_keywords`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_content_filtered`, `post_parent`, `post_type`, `post_mime_type`, `comment_count`, `smeta`, `post_hits`, `post_like`, `istop`, `recommended` ) VALUES  ('24','1','','2016-12-07 21:40:18','<p>判断一个专业的好坏，除了查阅各种资料、就业情况，从已毕业的大学生或正在就读中的大学生了解专业的口碑也是一种方法，毕竟他们正在被“专业”着，很多事情，他们深有体会，但是每个人的情况不同，期望不同，最后的评价可能也不同。如人饮水冷暖自知，还是要自己甄别，勿一味听取他人之言，这些仅供参考。</p><p>1、生物工程，国内甚至名校念到博士都没出路，除非是海龟，还能教书。但目前是录取分数第一高。每年有众多高分考生满怀希望进去，但实在是浪费啊。国内没有像样的生物公司，所以工作非常非常难找。该专业在该校连续三年夺得本科就业倒数第一名。</p><p>2、法学，全国范围的滥招生已经把这个专业彻底摧毁。包括重点和名牌大学在内的本科基本难找工作。除非一口气念到研究生加司法考试和公务员考试通过。通不过的人就只有被淘汰。</p><p>3、环境类专业本科基本无法就业。只有去考环保局。</p><p>4、国际政治和外交学。名字非常好听，但本科没出路，运气好能去搞研究。</p><p>5、新闻系。国内有名的骗人专业。专业内容莫名其妙。胡诌一些理论骗人，连中文都不如。本科就业非常差，大多学生只能去挤公务员的独木桥。印象中只有北外新闻系好一点，用英语授课，找工作也不错。</p><p>6、经济学。大家以为这个专业是赚钱的，其实这个专业是搞理论的。现在有的大学把国贸、金融、财经合为一体，开设了经济学类，总算又好一点。</p><p>7、数学与应用数学(计算数学)号称计算机与数学合一，还能去搞经济。但实际情况是：就是学数学的。。个人认为数学非常消耗脑力，没有实力就不要报考这个专业。</p><p>8、信息管理原身是图书馆学，去图书馆当管理员吗？</p><p><br/></p>','急报！这八个专业太不实用！！','判断一个专业的好坏，除了查阅各种资料、就业情况，从已毕业的大学生或正在就读中的大学生了解专业的口碑也是一种方法，','1','1','2016-12-07 21:39:54','','0','','','0','{\"thumb\":\"\"}','1','0','0','1');
DROP TABLE IF EXISTS `yxt_role`;
CREATE TABLE `yxt_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '角色名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父角色ID',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_role ( `id`, `name`, `pid`, `status`, `remark`, `create_time`, `update_time`, `listorder` ) VALUES  ('1','超级管理员','0','1','拥有网站最高管理员权限！','1329633709','1329633709','0');
INSERT INTO yxt_role ( `id`, `name`, `pid`, `status`, `remark`, `create_time`, `update_time`, `listorder` ) VALUES  ('2','课程管理员','0','1','','1425135402','1456298242','0');
DROP TABLE IF EXISTS `yxt_role_user`;
CREATE TABLE `yxt_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_route`;
CREATE TABLE `yxt_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `full_url` varchar(255) DEFAULT NULL COMMENT '完整url， 如：portal/list/index?id=1',
  `url` varchar(255) DEFAULT NULL COMMENT '实际显示的url',
  `listorder` int(5) DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1：启用 ;0：不启用',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('1','user/login/index','login$','0','1');
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('2','user/register/index','register$','0','1');
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('3','course/course/coursecenter','course$','0','1');
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('4','portal/page/index?id=1','about$','0','1');
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('5','forum/plate/index','forum$','0','1');
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('21','portal/index/article','article','0','1');
INSERT INTO yxt_route ( `id`, `full_url`, `url`, `listorder`, `status` ) VALUES  ('24','course/course/courseinfo','courseinfo/:id\\d','0','1');
DROP TABLE IF EXISTS `yxt_section`;
CREATE TABLE `yxt_section` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cs_id` int(6) DEFAULT NULL,
  `sc_name` varchar(50) DEFAULT NULL,
  `is_free` int(2) NOT NULL DEFAULT '0',
  `sc_time` varchar(16) DEFAULT NULL,
  `playtimes` int(2) DEFAULT NULL,
  `yun_url` varchar(600) DEFAULT NULL,
  `videoid` int(15) NOT NULL,
  `doccontent` longtext,
  `addtime` datetime DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `listorder` int(10) DEFAULT NULL,
  `type_id` int(2) NOT NULL COMMENT '"1"为章，"0"为节',
  `zhang_id` int(2) NOT NULL DEFAULT '0',
  `video_type` int(2) DEFAULT NULL COMMENT '"1"为云存储，"2"为优酷视频地址',
  `section_type` int(2) DEFAULT NULL COMMENT '"1"为视频课程，"2"为doc课程',
  `playpass` varchar(10) DEFAULT NULL COMMENT '优酷的播放密码',
  `live_starttime` datetime DEFAULT NULL COMMENT '直播开始时间',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('1','1','如何使用云存储','0','','0','','0','<p>云存储是用来储存视频课程文件和文档（比如课件ppt等）文件的。易学堂集成了腾讯云COS以及万视无忧，在后台可以自由切换。</p><p>下面就来说说如何使用<br/></p><p>一、腾讯云COS</p><p>1、打开腾讯云官网：<a href=\"https://www.qcloud.com/\">https://www.qcloud.com/</a></p><p>2、注册账号，登录。（用QQ号登录，没有QQ号的去注册一个），初次登录要进行邮箱验证。</p><p>3、登录后，点击管理中心--&gt;云产品</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476523013797771.png\" title=\"1476523013797771.png\" alt=\"QQ截图20161015172542.png\" width=\"1001\" height=\"377\"/></p><p>找到“对象存储服务”</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476523136655600.png\" title=\"1476523136655600.png\" alt=\"QQ截图20161015172745.png\" width=\"1006\" height=\"534\"/></p><p>初次只用要进行实名认证，根据提示请自行完成认证。</p><p>4、认证完成后，登录账号，创建Bucket。（可以理解为文件夹）</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476523388954105.png\" title=\"1476523388954105.png\" alt=\"QQ截图20161015173107.png\" width=\"1008\" height=\"331\"/></p><p>5、获取API秘钥</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476523647132332.png\" title=\"1476523647132332.png\" alt=\"QQ截图20161015173650.png\" width=\"1004\" height=\"460\"/></p><p>6，把秘钥和上面建好的Bucket填写到网站后台配置中。</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476523797103883.png\" title=\"1476523797103883.png\" alt=\"QQ截图20161015173903.png\" width=\"1002\" height=\"445\"/></p><p>二、万视无忧</p><p>1、打开万视无忧的网站：<a href=\"http://www.wsview.com/\">http://www.wsview.com/</a></p><p>2、注册登录账号</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476524012605918.png\" title=\"1476524012605918.png\" alt=\"QQ截图20161015174240.png\" width=\"1001\" height=\"426\"/></p><p>3、把注册的账号和密码填写到网站配置中</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476524188426214.png\" title=\"1476524188426214.png\" alt=\"QQ截图20161015174545.png\" width=\"997\" height=\"343\"/></p><p>三、两者比较</p><p>1、从注册，配置上看，万视无忧比腾讯云简单，万视无忧只需要账号和密码即可。</p><p>2、从价格上看,万视无忧比腾讯云更实惠一些。好在两者都有免费额度。</p><p>3、从品牌上看，腾讯大于万视无忧。</p><p>4、关于易学堂CMF,因为腾讯COS的API需要集成到源代码中，上传时会消耗本地服务器资源，而且上传文件大小限制需要配置服务器，新手不易操作，设置不好会限制上传文件大小。</p><p>而万视无忧直接使用万视无忧服务器的API，无需配置，上传文件大小基本无限制。</p><p>4、建议用万视无忧，因为简单方便，</p><p><br/></p>','2016-11-09 19:33:21','1','0','0','0','0','2','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('2','1','如何配置云直播功能','0','','0','','0','<p>易学堂集成了腾讯云直播和万视无忧云直播，下面就来说说这两者的配置</p><p>一、腾讯云直播</p><p>1、登录腾讯云，<a href=\"https://www.qcloud.com/\">https://www.qcloud.com</a>（没有账号的自行注册，激活，认证）</p><p>2、主页--云产品--是睥睨服务--直播</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476526777328096.png\" title=\"1476526777328096.png\" alt=\"QQ截图20161015181313.png\" width=\"987\" height=\"465\"/></p><p>3、点击立即选购</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476526899131636.png\" title=\"1476526899131636.png\" alt=\"QQ截图20161015181433.png\" width=\"988\" height=\"390\"/></p><p>4、初次使用需要申请开通，申请免费，申请后最好写个工单，这样审核会快一点。</p><p>5、审核通过后的界面是这样的：</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476527012743697.png\" title=\"1476527012743697.png\" alt=\"QQ截图20161015181556.png\" width=\"990\" height=\"377\"/></p><p>6、上图箭头指向的appid请记住，后台配置时会用到。</p><p>7、获取云API秘钥，云产品--监控与管理---云API---立即使用</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476527336817608.png\" title=\"1476527336817608.png\" alt=\"QQ截图20161015181920.png\" width=\"996\" height=\"436\"/></p><p>8、获取秘钥，要是没有，点击新建秘钥</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476527400879416.png\" title=\"1476527400879416.png\" alt=\"QQ截图20161015182117.png\" width=\"998\" height=\"312\"/></p><p>9、打开网站后台，填写上面得到的appid和秘钥（secretid secretkey）</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476527552102967.png\" title=\"1476527552102967.png\" alt=\"QQ截图20161015184152.png\" width=\"999\" height=\"370\"/></p><p>二、万视无忧云直播</p><p>1、打开万视无忧网站：<a href=\"http://www.wsview.com/\">http://www.wsview.com</a></p><p>2、注册登录账号。</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476527772110380.png\" title=\"1476527772110380.png\" alt=\"QQ截图20161015184525.png\" width=\"1002\" height=\"486\"/></p><p>3、把注册的账号和密码填写到网站后台配置中。</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476527858138945.png\" title=\"1476527858138945.png\" alt=\"QQ截图20161015184652.png\" width=\"998\" height=\"353\"/></p><p>4、注：点击上面的按钮可以腾讯直播和万视无忧直播间切换，前台自动识别。</p><p><br/></p>','2016-11-09 19:33:55','1','0','0','0','0','2','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('3','1','如何配置短信验证码','0','','0','','0','<p>易学堂CMF使用的是阿里大于的短信平台，下面说说如何配置使用<br/></p><p>1、登录阿里大于的网站：<a href=\"http://www.alidayu.com/\">http://www.alidayu.com/</a></p><p>2，注册，登录（账号用淘宝账号就行，一家的），初次使用送20元。</p><p>3、登录后进入管理中心</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476528236859964.png\" title=\"1476528236859964.png\" alt=\"QQ截图20161015185301.png\" width=\"957\" height=\"405\"/></p><p>4、应用管理--创建应用。</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476528381913275.png\" title=\"1476528381913275.png\" alt=\"QQ截图20161015185501.png\" width=\"958\" height=\"381\"/></p><p>5、创建后记住appkey,后台配置中需要。</p><p>6、创建签名：配置管理--验证码---配置短信签名--添加签名（需审核，不过很快，半小时差不多）<br/></p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476528505121095.png\" title=\"1476528505121095.png\" alt=\"QQ截图20161015185721.png\" width=\"969\" height=\"403\"/></p><p>7、配置短信模板：：配置管理--验证码--配置短信模板--添加模板</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476528808878650.png\" title=\"1476528808878650.png\" alt=\"QQ截图20161015190242.png\" width=\"993\" height=\"459\"/></p><p>模板内容中的验证码变量一定是${number},不然会影响短信的发送。</p><p>8、将信息添加到后台配置中：</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161015/1476528988574189.png\" title=\"1476528988574189.png\" alt=\"QQ截图20161015190550.png\" width=\"998\" height=\"498\"/></p><p><br/></p>','2016-11-09 19:34:26','1','0','0','0','0','2','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('4','2','如何申请成为教师','0','','0','','0','<p>1、注册，登陆账户。</p><p>2、首页右侧，点击姓名--成为教师</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161017/1476694608111963.png\" title=\"1476694608111963.png\" alt=\"QQ截图20161017165610.png\" width=\"984\" height=\"391\"/></p><p>3、填写姓名<img id=\"loading_iudu044f\" src=\"http://teach.yxtcmf.com/public/js/ueditor/themes/default/images/spacer.gif\" title=\"正在上传...\"/>和上传教师资格证。两者姓名要一致。</p><p><br/></p>','2016-11-09 19:36:44','1','0','0','0','0','2','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('5','2','如何发布视频课程','0','','0','','0','<p>1、用教师账号登陆系统。</p><p>2、我 的教室，创建课程</p><p><img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161018/1476776941706575.png\" alt=\"1476776941706575.png\"/></p><p>3、<img src=\"http://teach.yxtcmf.com/ueditor/php/upload/image/20161018/1476777270666503.png\" title=\"1476777270666503.png\" alt=\"QQ截图20161018155501.png\"/></p><p>4、点击创建，填写课程信息即可。</p><p><br/></p>','2016-11-09 19:37:09','1','0','0','0','0','2','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('8','4','直播课程测试','0','10','0','','0','','2016-11-09 20:31:31','1','0','0','0','1','1','','2016-11-09 20:40:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('19','5','1111','0','','0','http://teach-10045993.file.myqcloud.com/2016/11/11111111111.flv','0','','2016-11-22 18:29:34','1','0','0','0','1','1','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('17','3','圆锥曲线 第3讲 圆锥曲线定义在解题中的','0','00:16:55','0','http://cdn.simope.net/mp4/1475192297251446/c4b34e0368692066b3b5837a6947b287/1_720_25_H264_1001_4_3_1_0_2_1_3_0_1_0_2_0_0_0_N/659593e03d31fc762e865eff2781e9bd.mp4','157046','','2016-11-15 22:28:09','1','0','0','0','1','1','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('18','3',' 第9讲 函数的图象腾讯','0','2016-11-16 20:22','0','http://teach-10045993.file.myqcloud.com/15853789278/video/%E9%9B%86%E5%90%88%E4%B8%8E%E5%9F%BA%E6%9C%AC%E5%88%9D%E7%AD%89%E5%87%BD%E6%95%B0%20%E7%AC%AC9%E8%AE%B2%20%E5%87%BD%E6%95%B0%E7%9A%84%E5%9B%BE%E8%B1%A1.mp4','0','','2016-11-16 20:29:17','1','0','0','0','1','1','','0000-00-00 00:00:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('20','6','直播课程测试','1','20:18','','','0','','2016-11-27 14:36:36','1','','0','0','1','1','','2016-11-27 14:45:00');
INSERT INTO yxt_section ( `id`, `cs_id`, `sc_name`, `is_free`, `sc_time`, `playtimes`, `yun_url`, `videoid`, `doccontent`, `addtime`, `state`, `listorder`, `type_id`, `zhang_id`, `video_type`, `section_type`, `playpass`, `live_starttime` ) VALUES  ('21','3','第一节 充分条件与必要条件轻松过关','1','2016-09-13 15:44','','http://ruisi365-10045993.file.myqcloud.com/15853789278/video/%E7%AC%AC%E4%B8%80%E8%8A%82%20%E5%85%85%E5%88%86%E6%9D%A1%E4%BB%B6%E4%B8%8E%E5%BF%85%E8%A6%81%E6%9D%A1%E4%BB%B6%E8%BD%BB%E6%9D%BE%E8%BF%87%E5%85%B3.mp4','0','','2016-11-27 14:50:52','1','','0','0','1','1','','');
DROP TABLE IF EXISTS `yxt_slide`;
CREATE TABLE `yxt_slide` (
  `slide_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slide_cid` bigint(20) NOT NULL,
  `slide_name` varchar(255) NOT NULL,
  `slide_pic` varchar(255) DEFAULT NULL,
  `slide_url` varchar(255) DEFAULT NULL,
  `slide_des` varchar(255) DEFAULT NULL,
  `slide_content` text,
  `slide_status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(10) DEFAULT '0',
  PRIMARY KEY (`slide_id`),
  KEY `slide_cid` (`slide_cid`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_slide ( `slide_id`, `slide_cid`, `slide_name`, `slide_pic`, `slide_url`, `slide_des`, `slide_content`, `slide_status`, `listorder` ) VALUES  ('2','1','在线教育','/data/upload/20161109/5822d235eeba2.jpg','http://www.yxtcmf.com','在线教育','在线教育','1','0');
INSERT INTO yxt_slide ( `slide_id`, `slide_cid`, `slide_name`, `slide_pic`, `slide_url`, `slide_des`, `slide_content`, `slide_status`, `listorder` ) VALUES  ('3','1','首页','/data/upload/20161109/5822d2504109d.jpg','http://www.ruisi365.com','首页','','1','0');
DROP TABLE IF EXISTS `yxt_slide_cat`;
CREATE TABLE `yxt_slide_cat` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_idname` varchar(255) NOT NULL,
  `cat_remark` text,
  `cat_status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`),
  KEY `cat_idname` (`cat_idname`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_slide_cat ( `cid`, `cat_name`, `cat_idname`, `cat_remark`, `cat_status` ) VALUES  ('1','首页nav幻灯片(1600*430)','nav1_','首页nav幻灯片','1');
INSERT INTO yxt_slide_cat ( `cid`, `cat_name`, `cat_idname`, `cat_remark`, `cat_status` ) VALUES  ('2','首页中部幻灯片(1920*250)','nav2_','首页中部幻灯片','1');
DROP TABLE IF EXISTS `yxt_teacher_order`;
CREATE TABLE `yxt_teacher_order` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `u_id` int(4) DEFAULT NULL,
  `c_id` int(4) DEFAULT NULL,
  `money` float DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_teacher_order ( `id`, `u_id`, `c_id`, `money`, `addtime` ) VALUES  ('1','2','3','0.5','2016-11-27 21:39:57');
INSERT INTO yxt_teacher_order ( `id`, `u_id`, `c_id`, `money`, `addtime` ) VALUES  ('2','2','2','4.5','2016-11-27 22:40:04');
DROP TABLE IF EXISTS `yxt_term_relationships`;
CREATE TABLE `yxt_term_relationships` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'posts表里文章id',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `listorder` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`tid`),
  KEY `term_taxonomy_id` (`term_id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('1','2','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('2','3','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('3','4','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('4','5','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('5','6','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('6','7','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('7','8','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('8','9','1','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('9','10','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('10','11','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('11','12','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('12','13','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('13','14','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('14','15','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('15','16','2','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('16','17','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('17','18','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('18','19','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('19','20','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('20','21','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('21','22','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('22','23','4','0','1');
INSERT INTO yxt_term_relationships ( `tid`, `object_id`, `term_id`, `listorder`, `status` ) VALUES  ('23','24','4','0','1');
DROP TABLE IF EXISTS `yxt_terms`;
CREATE TABLE `yxt_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `slug` varchar(200) DEFAULT '',
  `taxonomy` varchar(32) DEFAULT NULL COMMENT '分类类型',
  `description` longtext COMMENT '分类描述',
  `parent` bigint(20) unsigned DEFAULT '0' COMMENT '分类父id',
  `count` bigint(20) DEFAULT '0' COMMENT '分类文章数',
  `path` varchar(500) DEFAULT NULL COMMENT '分类层级关系路径',
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `list_tpl` varchar(50) DEFAULT NULL COMMENT '分类列表模板',
  `one_tpl` varchar(50) DEFAULT NULL COMMENT '分类文章页模板',
  `listorder` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`term_id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_terms ( `term_id`, `name`, `slug`, `taxonomy`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `listorder`, `status` ) VALUES  ('1','学习经验','','','学习经验','0','0','0-1','','','','list','article','0','1');
INSERT INTO yxt_terms ( `term_id`, `name`, `slug`, `taxonomy`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `listorder`, `status` ) VALUES  ('2','复习技巧','','','复习技巧','0','0','0-2','','','','list','article','0','1');
INSERT INTO yxt_terms ( `term_id`, `name`, `slug`, `taxonomy`, `description`, `parent`, `count`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `listorder`, `status` ) VALUES  ('4','专业分析','','','专业分析','0','0','0-4','','','','list','article','0','1');
DROP TABLE IF EXISTS `yxt_tixian`;
CREATE TABLE `yxt_tixian` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `u_id` int(4) DEFAULT NULL,
  `money` int(6) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `turename` varchar(10) DEFAULT NULL,
  `count` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
DROP TABLE IF EXISTS `yxt_user_favorites`;
CREATE TABLE `yxt_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '收藏内容的标题',
  `url` varchar(255) DEFAULT NULL COMMENT '收藏内容的原文地址，不带域名',
  `description` varchar(500) DEFAULT NULL COMMENT '收藏内容的描述',
  `table` varchar(50) DEFAULT NULL COMMENT '收藏实体以前所在表，不带前缀',
  `object_id` int(11) DEFAULT NULL COMMENT '收藏内容原来的主键id',
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_user_favorites ( `id`, `uid`, `title`, `url`, `description`, `table`, `object_id`, `createtime` ) VALUES  ('4','2','','','','','3','');
INSERT INTO yxt_user_favorites ( `id`, `uid`, `title`, `url`, `description`, `table`, `object_id`, `createtime` ) VALUES  ('3','2','','','','','1','');
DROP TABLE IF EXISTS `yxt_usercourse`;
CREATE TABLE `yxt_usercourse` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) DEFAULT NULL,
  `course_id` int(8) DEFAULT NULL,
  `teacher_id` int(6) DEFAULT NULL,
  `course_price` int(6) DEFAULT NULL,
  `state` int(2) DEFAULT NULL,
  `studied` varchar(1000) DEFAULT NULL,
  `pinglun` text,
  `pingluntime` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `youxiaoqi` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_usercourse ( `id`, `user_id`, `course_id`, `teacher_id`, `course_price`, `state`, `studied`, `pinglun`, `pingluntime`, `addtime`, `youxiaoqi` ) VALUES  ('4','2','1','','','1','1|2|3|','','','2016-11-27 22:29:03','');
INSERT INTO yxt_usercourse ( `id`, `user_id`, `course_id`, `teacher_id`, `course_price`, `state`, `studied`, `pinglun`, `pingluntime`, `addtime`, `youxiaoqi` ) VALUES  ('3','2','6','','','1','20|','','','2016-11-27 22:28:37','');
INSERT INTO yxt_usercourse ( `id`, `user_id`, `course_id`, `teacher_id`, `course_price`, `state`, `studied`, `pinglun`, `pingluntime`, `addtime`, `youxiaoqi` ) VALUES  ('5','2','2','2','9','1','','','','2016-11-27 22:40:04','');
DROP TABLE IF EXISTS `yxt_users`;
CREATE TABLE `yxt_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；sp_password加密',
  `user_nicename` varchar(50) NOT NULL DEFAULT '' COMMENT '用户美名',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网站',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` varchar(7) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '最后登录时间',
  `create_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '注册时间',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `user_type` smallint(1) DEFAULT '1' COMMENT '用户类型，1:admin ;2:会员;3教师',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `prov` varchar(20) DEFAULT '' COMMENT '省',
  `city` varchar(20) DEFAULT '' COMMENT '市',
  `dist` varchar(20) DEFAULT '' COMMENT '县',
  `weiixn` varchar(40) DEFAULT '' COMMENT '微信',
  `qq` int(15) DEFAULT NULL COMMENT 'QQ',
  `teacstate` int(2) DEFAULT '0' COMMENT '申请教师的状态',
  `chatstate` int(2) DEFAULT '0' COMMENT '直播聊天室的状态0不在线，1在线',
  `zhicheng` varchar(60) DEFAULT NULL COMMENT '教师职称',
  `tcProfile` varchar(600) DEFAULT NULL COMMENT '教师简介',
  `adminplate` int(2) DEFAULT NULL,
  `folderid` int(10) DEFAULT NULL,
  `coins` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) COLLATE='utf8_general_ci' ENGINE=MyISAM;
INSERT INTO yxt_users ( `id`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `avatar`, `sex`, `birthday`, `signature`, `last_login_ip`, `last_login_time`, `create_time`, `user_activation_key`, `user_status`, `score`, `user_type`, `coin`, `mobile`, `prov`, `city`, `dist`, `weiixn`, `qq`, `teacstate`, `chatstate`, `zhicheng`, `tcprofile`, `adminplate`, `folderid`, `coins` ) VALUES  ('2','','###932480be6b2bad8c56fb6555c55e2e17','禅心如月','','','583ee9cfc53cf.jpg','1','0000-00-00','我就是我，不一样的烟火！','222.132.80.29','2016-12-02 07:40:19','2016-11-27 14:22:29','','1','0','3','0','15853789278','山东','','','378146005','378146005','0','0','中学高级教师','中学高级教师','1','','0');
INSERT INTO yxt_users ( `id`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `avatar`, `sex`, `birthday`, `signature`, `last_login_ip`, `last_login_time`, `create_time`, `user_activation_key`, `user_status`, `score`, `user_type`, `coin`, `mobile`, `prov`, `city`, `dist`, `weiixn`, `qq`, `teacstate`, `chatstate`, `zhicheng`, `tcprofile`, `adminplate`, `folderid`, `coins` ) VALUES  ('3','','###932480be6b2bad8c56fb6555c55e2e17','学习哥','','','','0','','','222.132.80.29','2016-12-01 20:47:29','2016-11-30 07:48:32','','1','0','2','0','15562315180','','','','','','0','0','','','','','0');
INSERT INTO yxt_users ( `id`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `avatar`, `sex`, `birthday`, `signature`, `last_login_ip`, `last_login_time`, `create_time`, `user_activation_key`, `user_status`, `score`, `user_type`, `coin`, `mobile`, `prov`, `city`, `dist`, `weiixn`, `qq`, `teacstate`, `chatstate`, `zhicheng`, `tcprofile`, `adminplate`, `folderid`, `coins` ) VALUES  ('4','','###932480be6b2bad8c56fb6555c55e2e17','云隐','','','','0','','','111.14.134.33','2016-12-07 21:43:35','2016-12-07 21:43:35','','1','0','3','0','1585378000','','','','','','0','0','','','','','0');
INSERT INTO yxt_users ( `id`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `avatar`, `sex`, `birthday`, `signature`, `last_login_ip`, `last_login_time`, `create_time`, `user_activation_key`, `user_status`, `score`, `user_type`, `coin`, `mobile`, `prov`, `city`, `dist`, `weiixn`, `qq`, `teacstate`, `chatstate`, `zhicheng`, `tcprofile`, `adminplate`, `folderid`, `coins` ) VALUES  ('5','','###932480be6b2bad8c56fb6555c55e2e17','理科生福','','','','0','','','111.14.134.33','2016-12-07 21:52:17','2016-12-07 21:52:17','','1','0','3','0','15562124356','','','','','','0','0','','','','','0');
