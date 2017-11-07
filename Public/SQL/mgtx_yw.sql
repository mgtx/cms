/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : mgtx_yw

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-09-28 13:29:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mgtx_admin
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_admin`;
CREATE TABLE `mgtx_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='管理者账号';

-- ----------------------------
-- Records of mgtx_admin
-- ----------------------------
INSERT INTO `mgtx_admin` VALUES ('1', 'superAdmin', 'e10adc3949ba59abbe56e057f20f883e', '2017-09-14 10:59:18');

-- ----------------------------
-- Table structure for mgtx_business
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_business`;
CREATE TABLE `mgtx_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `units_name` text COMMENT '单位名称',
  `userid` varchar(25) NOT NULL COMMENT '用户ID',
  `process_id` varchar(50) NOT NULL COMMENT '审批唯一标识',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `status` varchar(20) NOT NULL COMMENT '审批状态，分为NEW（刚创建）|RUNNING（运行中）|TERMINATED（被终止）|COMPLETED（完成）|CANCELED（取消）',
  `process_result` varchar(10) DEFAULT NULL COMMENT '审批结果，分为agree和refuse',
  `payment` varchar(50) DEFAULT NULL COMMENT '支付方式',
  `cause` varchar(30) DEFAULT NULL COMMENT '收款原因',
  `version` varchar(20) DEFAULT NULL COMMENT '产品版本',
  `type` varchar(10) DEFAULT NULL COMMENT '类型',
  `user_num` int(11) DEFAULT NULL COMMENT '用户数',
  `age_limit` varchar(25) DEFAULT NULL COMMENT '年限',
  `discount` varchar(25) DEFAULT NULL COMMENT '折扣',
  `money` int(11) DEFAULT NULL,
  `customer_name` varchar(40) DEFAULT NULL COMMENT '客户姓名',
  `customer_phone` varchar(20) DEFAULT NULL COMMENT '客户联系电话',
  `remarks` text COMMENT '备注',
  `create_time` varchar(20) NOT NULL COMMENT '开始时间',
  `finish_time` varchar(20) DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`,`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='业务存储表';

-- ----------------------------
-- Records of mgtx_business
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_business_target_month
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_business_target_month`;
CREATE TABLE `mgtx_business_target_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(7) NOT NULL COMMENT '年-月（2017-01）',
  `target` int(11) NOT NULL DEFAULT '0' COMMENT '目标值',
  `complete` int(11) NOT NULL DEFAULT '0' COMMENT '已完成金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='月总目标';

-- ----------------------------
-- Records of mgtx_business_target_month
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_business_target_personage
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_business_target_personage`;
CREATE TABLE `mgtx_business_target_personage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(25) NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '个人名称',
  `month` varchar(7) NOT NULL COMMENT '年月',
  `target` int(11) NOT NULL DEFAULT '0' COMMENT '目标值',
  `complete` int(11) NOT NULL DEFAULT '0' COMMENT '已完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='个人目标';

-- ----------------------------
-- Records of mgtx_business_target_personage
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_business_target_team
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_business_target_team`;
CREATE TABLE `mgtx_business_target_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_id` varchar(20) NOT NULL COMMENT '团队ID',
  `dep_name` varchar(30) NOT NULL COMMENT '团队名称',
  `leader` varchar(40) DEFAULT NULL,
  `month` varchar(10) NOT NULL,
  `target` int(11) NOT NULL DEFAULT '0',
  `complete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='团队目标';

-- ----------------------------
-- Records of mgtx_business_target_team
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_business_target_year
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_business_target_year`;
CREATE TABLE `mgtx_business_target_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` smallint(6) NOT NULL COMMENT '年份',
  `target` int(11) NOT NULL DEFAULT '0' COMMENT '年目标值',
  `complete` int(11) NOT NULL DEFAULT '0' COMMENT '已完成金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='年目标';

-- ----------------------------
-- Records of mgtx_business_target_year
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_department
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_department`;
CREATE TABLE `mgtx_department` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `dep_id` varchar(20) NOT NULL DEFAULT '0' COMMENT '部门id',
  `dep_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL COMMENT '部门名称',
  `parentid` int(11) NOT NULL DEFAULT '1' COMMENT '父部门id，根部门为1',
  `order` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '在父部门中的次序值',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否设置为团队目标对象 0否，1是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_dep_key` (`dep_id`,`dep_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='部门表';

-- ----------------------------
-- Records of mgtx_department
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_last_update
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_last_update`;
CREATE TABLE `mgtx_last_update` (
  `userid` varchar(30) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL COMMENT '员工姓名',
  `avatar` text COMMENT '头像',
  `dep_now` varchar(30) DEFAULT NULL,
  `dep_name` varchar(50) DEFAULT NULL,
  `leader` varchar(200) DEFAULT NULL,
  `cause` varchar(30) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `user_num` int(11) DEFAULT NULL,
  `age_limit` varchar(25) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='需要展示的数据';

-- ----------------------------
-- Records of mgtx_last_update
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_mployee
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_mployee`;
CREATE TABLE `mgtx_mployee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(25) NOT NULL COMMENT '钉钉用户ID',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `avatar` text COMMENT '头像URL',
  `depts` text NOT NULL COMMENT '所在部门，是否是主管',
  `mobile` varchar(20) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL COMMENT '职位',
  `dep_now` text COMMENT '当前所在部门',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='员工信息表';

-- ----------------------------
-- Records of mgtx_mployee
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_select_time
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_select_time`;
CREATE TABLE `mgtx_select_time` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `last_time` varchar(20) NOT NULL COMMENT '上次查询时间--微秒',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mgtx_select_time
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_syn_log
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_syn_log`;
CREATE TABLE `mgtx_syn_log` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `last_ip` varchar(20) NOT NULL,
  `last_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mgtx_syn_log
-- ----------------------------

-- ----------------------------
-- Table structure for mgtx_token
-- ----------------------------
DROP TABLE IF EXISTS `mgtx_token`;
CREATE TABLE `mgtx_token` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'token的名称',
  `token_value` text NOT NULL COMMENT 'token',
  `addtime` int(11) NOT NULL COMMENT ' 获取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of mgtx_token
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;
