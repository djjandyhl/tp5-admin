-- --------------------------------------------------------
-- 主机:                           192.168.1.12
-- 服务器版本:                        5.7.12-0ubuntu1.1 - (Ubuntu)
-- 服务器操作系统:                      Linux
-- HeidiSQL 版本:                  9.3.0.5107
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 snake 的数据库结构
CREATE DATABASE IF NOT EXISTS `snake` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `snake`;

-- 导出  表 snake.node 结构
CREATE TABLE IF NOT EXISTS `node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `module_name` varchar(155) NOT NULL DEFAULT '' COMMENT '模块名',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `parent_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- 正在导出表  snake.node 的数据：13 rows
DELETE FROM `node`;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;
INSERT INTO `node` (`id`, `node_name`, `module_name`, `control_name`, `action_name`, `is_menu`, `parent_id`, `style`) VALUES
	(1, '用户管理', '#', '#', '#', 2, 0, 'fa fa-users'),
	(2, '用户列表', 'admin', 'user', 'index', 2, 1, ''),
	(3, '添加用户', 'admin', 'user', 'useradd', 1, 2, ''),
	(4, '编辑用户', 'admin', 'user', 'useredit', 1, 2, ''),
	(5, '删除用户', 'admin', 'user', 'delete', 1, 2, ''),
	(6, '角色列表', 'admin', 'role', 'index', 2, 1, ''),
	(7, '添加角色', 'admin', 'role', 'roleadd', 1, 6, ''),
	(8, '编辑角色', 'admin', 'role', 'roleedit', 1, 6, ''),
	(9, '删除角色', 'admin', 'role', 'roledel', 1, 6, ''),
	(11, '系统管理', '#', '#', '#', 2, 0, 'fa fa-desktop'),
	(12, '数据备份/还原', 'admin', 'data', 'index', 2, 11, ''),
	(13, '备份数据', 'admin', 'data', 'importdata', 1, 12, ''),
	(14, '还原数据', 'admin', 'data', 'backdata', 1, 12, '');
/*!40000 ALTER TABLE `node` ENABLE KEYS */;

-- 导出  表 snake.role 结构
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rolename` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- 正在导出表  snake.role 的数据：~5 rows (大约)
DELETE FROM `role`;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `rolename`, `rule`) VALUES
	(1, '超级管理员', '1,2,3,4,5,6,7,8,9,10,11,12,13,14'),
	(2, 'ddd', '1,2,3,4,5,6,7,8,9,10,11,12,13,14'),
	(6, 'test1', '1,2,3,4,5,6,7,8,9');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- 导出  表 snake.user 结构
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `loginnum` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '最后登录IP',
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `role_id` int(11) NOT NULL COMMENT '用户角色id',
  `jwt_token` char(13) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_role` (`role_id`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- 正在导出表  snake.user 的数据：~3 rows (大约)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `loginnum`, `last_login_ip`, `last_login_time`, `real_name`, `status`, `role_id`, `jwt_token`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 202, '127.0.0.1', 1479438073, 'admin', 1, 1, '582e6ef9e565e'),
	(2, 'test1', '7fa8282ad93047a4d6fe6111c93b308a', 2, '0.0.0.0', 1479197107, 'test1', 1, 2, '582ac1b3d988d'),
	(3, 'test2', 'ad0234829205b9033196ba818f7a872b', 0, NULL, 0, 'test2', 1, 2, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
