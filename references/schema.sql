/*
 Navicat MySQL Data Transfer

 Source Server         : digiocean
 Source Server Type    : MySQL
 Source Server Version : 50541
 Source Host           : localhost
 Source Database       : survivor

 Target Server Type    : MySQL
 Target Server Version : 50541
 File Encoding         : utf-8

 Date: 11/30/2015 20:27:14 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_value` varchar(255) DEFAULT NULL,
  `site_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `teams`
-- ----------------------------
DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `short_name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `user_picks`
-- ----------------------------
DROP TABLE IF EXISTS `user_picks`;
CREATE TABLE `user_picks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `week_number` int(11) DEFAULT NULL,
  `team_picked` varchar(5) DEFAULT NULL,
  `does_move_on` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `is_certified` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `weekly_games`
-- ----------------------------
DROP TABLE IF EXISTS `weekly_games`;
CREATE TABLE `weekly_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `away_team` varchar(255) DEFAULT NULL,
  `home_team` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `away_team_score` int(11) DEFAULT NULL,
  `home_team_score` int(11) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `quarter_time_left` varchar(255) DEFAULT NULL,
  `winner` varchar(255) DEFAULT NULL,
  `loser` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

SET FOREIGN_KEY_CHECKS = 1;
