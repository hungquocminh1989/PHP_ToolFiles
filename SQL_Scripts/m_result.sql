/*
Navicat MySQL Data Transfer

Source Server         : mintyhouse
Source Server Version : 50505
Source Host           : 31.220.110.218:3306
Source Database       : u440311185_house

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-05 17:03:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_result
-- ----------------------------
DROP TABLE IF EXISTS `m_result`;
CREATE TABLE `m_result` (
  `m_result_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `m_active_id` bigint(20) DEFAULT NULL,
  `username` text COLLATE utf8_unicode_ci,
  `password` text COLLATE utf8_unicode_ci,
  `cookie` longtext COLLATE utf8_unicode_ci,
  `access_token` longtext COLLATE utf8_unicode_ci,
  `reg_status` int(2) DEFAULT NULL,
  `del_flg` int(1) DEFAULT '0',
  `add_datetime` datetime DEFAULT NULL,
  `upd_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`m_result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
