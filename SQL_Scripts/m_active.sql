/*
Navicat MySQL Data Transfer

Source Server         : mintyhouse
Source Server Version : 50505
Source Host           : 31.220.110.218:3306
Source Database       : u440311185_house

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-06 11:01:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_active
-- ----------------------------
DROP TABLE IF EXISTS `m_active`;
CREATE TABLE `m_active` (
  `m_active_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `server_key` longtext COLLATE utf8_unicode_ci,
  `client_key` longtext COLLATE utf8_unicode_ci,
  `client_info` longtext COLLATE utf8_unicode_ci,
  `license_date` datetime DEFAULT NULL,
  `active_flg` int(1) DEFAULT NULL,
  `del_flg` int(1) DEFAULT '0',
  `add_datetime` datetime DEFAULT NULL,
  `upd_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`m_active_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
