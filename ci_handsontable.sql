/*
 Navicat Premium Data Transfer

 Source Server         : Maria DB
 Source Server Type    : MariaDB
 Source Server Version : 100310
 Source Host           : 127.0.0.1:3309
 Source Schema         : ci_handsontable

 Target Server Type    : MariaDB
 Target Server Version : 100310
 File Encoding         : 65001

 Date: 19/03/2021 15:33:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cars
-- ----------------------------
DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars`  (
  `id` int(11) NOT NULL,
  `manufacturer` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `year` int(11) NULL DEFAULT NULL,
  `price` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cars
-- ----------------------------
INSERT INTO `cars` VALUES (1, 'Honda', 2010, 200000);
INSERT INTO `cars` VALUES (2, 'Jaguar', 2012, 400000);
INSERT INTO `cars` VALUES (3, 'BMW', 2000, 75000);
INSERT INTO `cars` VALUES (4, 'Mercedes', 1980, 1000);
INSERT INTO `cars` VALUES (5, 'fgdfgdfg', 5646, 546456);
INSERT INTO `cars` VALUES (6, 'dfgdfgdfg', 5366, 456546);
INSERT INTO `cars` VALUES (7, 'fgdfgg', 546546, 3566456);
INSERT INTO `cars` VALUES (8, 'dd', NULL, NULL);
INSERT INTO `cars` VALUES (9, '', NULL, NULL);
INSERT INTO `cars` VALUES (10, '', NULL, NULL);
INSERT INTO `cars` VALUES (11, '', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
