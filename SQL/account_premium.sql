/*
Navicat MySQL Data Transfer

Source Server         : wowh2h
Source Server Version : 50562
Source Host           : 127.0.0.1:3306
Source Database       : auth

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001

Date: 2020-02-21 18:27:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account_premium`
-- ----------------------------
DROP TABLE IF EXISTS `account_premium`;
CREATE TABLE `account_premium` (
  `id` int(11) NOT NULL DEFAULT '0' COMMENT 'Account id',
  `setdate` int(4) NOT NULL DEFAULT '0',
  `unsetdate` int(4) NOT NULL DEFAULT '0',
  `premium_type` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `setdate` (`setdate`),
  KEY `unsetdate` (`unsetdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_premium
-- ----------------------------
INSERT INTO `account_premium` VALUES ('14', '1570356851', '1572948851', '1', '1', '0');
INSERT INTO `account_premium` VALUES ('92', '1580669923', '1598435923', '3', '1', '210');
INSERT INTO `account_premium` VALUES ('94', '1574519050', '1577226250', '1', '1', '32');
INSERT INTO `account_premium` VALUES ('105', '1580671537', '1611127537', '1', '1', '360');
