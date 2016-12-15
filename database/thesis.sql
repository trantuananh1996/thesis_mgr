/*
Navicat MySQL Data Transfer

Source Server         : homestead
Source Server Version : 50713
Source Host           : localhost:33060
Source Database       : thesis

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2016-12-15 17:50:06
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `cohort_program`
-- ----------------------------
DROP TABLE IF EXISTS `cohort_program`;
CREATE TABLE `cohort_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cohort_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cohort_program
-- ----------------------------
INSERT INTO `cohort_program` VALUES ('1', '1', '1', '2016-12-10 23:11:51', '2016-12-10 23:11:51');
INSERT INTO `cohort_program` VALUES ('2', '1', '5', '2016-12-10 23:34:40', '2016-12-10 23:34:40');
INSERT INTO `cohort_program` VALUES ('3', '1', '6', '2016-12-10 23:34:40', '2016-12-10 23:34:40');
INSERT INTO `cohort_program` VALUES ('4', '1', '3', '2016-12-10 23:34:40', '2016-12-10 23:34:40');
INSERT INTO `cohort_program` VALUES ('5', '2', '1', '2016-12-10 23:34:52', '2016-12-10 23:34:52');
INSERT INTO `cohort_program` VALUES ('6', '2', '5', '2016-12-10 23:34:52', '2016-12-10 23:34:52');
INSERT INTO `cohort_program` VALUES ('7', '2', '6', '2016-12-10 23:34:52', '2016-12-10 23:34:52');
INSERT INTO `cohort_program` VALUES ('8', '2', '3', '2016-12-10 23:34:52', '2016-12-10 23:34:52');
INSERT INTO `cohort_program` VALUES ('9', '3', '1', '2016-12-10 23:35:04', '2016-12-10 23:35:04');
INSERT INTO `cohort_program` VALUES ('10', '3', '5', '2016-12-10 23:35:04', '2016-12-10 23:35:04');
INSERT INTO `cohort_program` VALUES ('11', '3', '6', '2016-12-10 23:35:04', '2016-12-10 23:35:04');
INSERT INTO `cohort_program` VALUES ('12', '3', '3', '2016-12-10 23:35:04', '2016-12-10 23:35:04');
INSERT INTO `cohort_program` VALUES ('13', '4', '5', '2016-12-10 23:35:14', '2016-12-10 23:35:14');
INSERT INTO `cohort_program` VALUES ('14', '4', '1', '2016-12-10 23:35:14', '2016-12-10 23:35:14');
INSERT INTO `cohort_program` VALUES ('15', '4', '6', '2016-12-10 23:35:14', '2016-12-10 23:35:14');
INSERT INTO `cohort_program` VALUES ('16', '4', '3', '2016-12-10 23:35:14', '2016-12-10 23:35:14');
INSERT INTO `cohort_program` VALUES ('17', '5', '1', '2016-12-11 03:50:24', '2016-12-11 03:50:24');
INSERT INTO `cohort_program` VALUES ('18', '5', '5', '2016-12-11 03:50:24', '2016-12-11 03:50:24');
INSERT INTO `cohort_program` VALUES ('19', '5', '6', '2016-12-11 03:50:24', '2016-12-11 03:50:24');
INSERT INTO `cohort_program` VALUES ('20', '5', '3', '2016-12-11 03:50:24', '2016-12-11 03:50:24');

-- ----------------------------
-- Table structure for `cohorts`
-- ----------------------------
DROP TABLE IF EXISTS `cohorts`;
CREATE TABLE `cohorts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cohorts
-- ----------------------------
INSERT INTO `cohorts` VALUES ('1', 'K58', 'Khóa 58', '', '1', '1', '2016-12-10 11:09:33', '2016-12-10 22:52:36');
INSERT INTO `cohorts` VALUES ('2', 'K59', 'Khóa 59', '', '1', '1', '2016-12-10 23:25:30', '2016-12-10 23:25:30');
INSERT INTO `cohorts` VALUES ('3', 'K60', 'Khóa 60', '', '1', '1', '2016-12-10 23:26:38', '2016-12-10 23:26:38');
INSERT INTO `cohorts` VALUES ('4', 'K61', 'Khóa 61', '', '1', '1', '2016-12-10 23:32:50', '2016-12-10 23:32:50');
INSERT INTO `cohorts` VALUES ('5', 'K62', 'Khóa 62', '', '1', '1', '2016-12-11 03:48:40', '2016-12-11 03:48:40');

-- ----------------------------
-- Table structure for `education_programs`
-- ----------------------------
DROP TABLE IF EXISTS `education_programs`;
CREATE TABLE `education_programs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `education_programs_unit_id_index` (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of education_programs
-- ----------------------------
INSERT INTO `education_programs` VALUES ('1', 'CNTT', 'Công nghệ thông tin', '', '1', '1', '2016-12-10 11:10:12', '2016-12-14 07:26:50', '1');
INSERT INTO `education_programs` VALUES ('3', 'DTVT', 'Điện tử viễn thông', '', '1', '1', '2016-12-10 23:27:56', '2016-12-14 07:27:15', '2');
INSERT INTO `education_programs` VALUES ('5', 'CDT', 'Cơ điện tử', '', '1', '1', '2016-12-10 23:31:49', '2016-12-14 07:27:01', '4');
INSERT INTO `education_programs` VALUES ('6', 'VLKT', 'Vật lý kỹ thuật', '', '1', '1', '2016-12-10 23:34:21', '2016-12-14 07:27:07', '3');
INSERT INTO `education_programs` VALUES ('7', 'QT', 'Đào tạo Quốc Tế', '', '1', '1', '2016-12-14 07:29:50', '2016-12-14 07:29:50', '5');

-- ----------------------------
-- Table structure for `fields`
-- ----------------------------
DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fields_unit_id_index` (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of fields
-- ----------------------------
INSERT INTO `fields` VALUES ('1', 'AI', 'Trí tuệ nhân tạo', '1', '', '1', null, '2016-12-12 10:21:06', '2016-12-12 10:21:06', 'tri-tue-nhan-tao');
INSERT INTO `fields` VALUES ('2', 'MMT', 'Mạng máy tính và truyền thông', '1', '', '1', null, '2016-12-12 10:21:31', '2016-12-12 10:21:31', 'mang-may-tinh-va-truyen-thong');
INSERT INTO `fields` VALUES ('3', 'BIGDATA', 'Big Data', '1', '', '10', null, '2016-12-13 02:46:30', '2016-12-13 02:46:30', 'big-data');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2016_11_30_102859_create_roles_table', '1');
INSERT INTO `migrations` VALUES ('4', '2016_11_30_102934_create_role_user_table', '1');
INSERT INTO `migrations` VALUES ('5', '2016_11_30_103028_create_permissions_table', '1');
INSERT INTO `migrations` VALUES ('6', '2016_11_30_103133_create_units_table', '1');
INSERT INTO `migrations` VALUES ('7', '2016_11_30_103223_create_fields_table', '1');
INSERT INTO `migrations` VALUES ('8', '2016_11_30_103516_create_teacher_profile_table', '1');
INSERT INTO `migrations` VALUES ('9', '2016_11_30_104104_create_cohorts_table', '1');
INSERT INTO `migrations` VALUES ('10', '2016_11_30_104207_create_education_programs_table', '1');
INSERT INTO `migrations` VALUES ('11', '2016_11_30_104342_create_topics_table', '1');
INSERT INTO `migrations` VALUES ('12', '2016_11_30_105941_create_student_cohort_program', '1');
INSERT INTO `migrations` VALUES ('13', '2016_11_30_110143_create_teacher_unit_table', '1');
INSERT INTO `migrations` VALUES ('14', '2016_11_30_110224_create_teacher_topic_table', '1');
INSERT INTO `migrations` VALUES ('15', '2016_11_30_110331_create_teacher_field_table', '1');
INSERT INTO `migrations` VALUES ('16', '2016_11_30_110442_create_cohort_program', '1');
INSERT INTO `migrations` VALUES ('17', '2016_12_01_173450_add_username_on_users_table', '1');
INSERT INTO `migrations` VALUES ('18', '2016_12_06_171020_add_role_permission_table', '2');
INSERT INTO `migrations` VALUES ('19', '2016_12_08_163410_add_slug_column_to_tables', '3');
INSERT INTO `migrations` VALUES ('20', '2016_12_08_092145_create_notifications_table', '4');
INSERT INTO `migrations` VALUES ('21', '2016_12_12_035733_create_terms_table', '4');
INSERT INTO `migrations` VALUES ('23', '2016_12_12_150904_creaete_student_topic_table', '5');
INSERT INTO `migrations` VALUES ('24', '2016_12_13_020913_change_type_description_on_topics_table', '6');
INSERT INTO `migrations` VALUES ('25', '2016_12_13_032853_remove_id_on_teacher_field_table', '6');
INSERT INTO `migrations` VALUES ('26', '2016_12_13_064600_drop_some_columns_on_teacher_topic_table', '7');
INSERT INTO `migrations` VALUES ('27', '2016_12_13_094643_add_is_locked_on_topics_table', '8');
INSERT INTO `migrations` VALUES ('28', '2016_12_13_080706_create_send_password_to_users', '9');
INSERT INTO `migrations` VALUES ('29', '2016_12_14_065259_add_unit_id_on_program', '9');

-- ----------------------------
-- Table structure for `notifications`
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` int(10) unsigned NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('2', 'SA_roles_permissions', 'Phân quyền - chức năng', '', '1', '1', '2016-12-06 08:59:56', '2016-12-06 08:59:56');
INSERT INTO `permissions` VALUES ('3', 'users_manage', 'Quản lý người dùng', '', '1', '1', '2016-12-08 08:01:19', '2016-12-10 09:17:39');
INSERT INTO `permissions` VALUES ('4', 'users_act', 'Thao tác với người dùng', '', '1', '1', '2016-12-10 09:18:06', '2016-12-10 09:18:06');
INSERT INTO `permissions` VALUES ('5', 'cohorts_programs', 'Quản lý khóa học - chương trình đào tạo', '', '1', '1', '2016-12-11 09:27:28', '2016-12-11 09:27:28');
INSERT INTO `permissions` VALUES ('6', 'term_manage', 'Thiết lập đợt đăng ký', '', '1', '1', '2016-12-12 07:56:05', '2016-12-12 07:56:05');
INSERT INTO `permissions` VALUES ('7', 'topics_teacher', 'Đề tài khóa luận của giáo viên', '', '1', '1', '2016-12-13 08:30:25', '2016-12-13 08:30:25');
INSERT INTO `permissions` VALUES ('8', 'topics_student', 'Đề tài khóa luận của sinh viên', '', '1', '1', '2016-12-14 04:54:35', '2016-12-14 04:54:48');
INSERT INTO `permissions` VALUES ('9', 'topic_denies', 'Đình chỉ làm khóa luận', '', '1', '1', '2016-12-15 07:21:38', '2016-12-15 07:21:38');
INSERT INTO `permissions` VALUES ('10', 'topics_manage', 'Quản lý khóa luận', '', '1', '1', '2016-12-15 07:24:16', '2016-12-15 07:51:07');
INSERT INTO `permissions` VALUES ('11', 'general_manage', 'Quản lý chung', '', '1', '1', '2016-12-15 10:47:40', '2016-12-15 10:47:40');

-- ----------------------------
-- Table structure for `role_permission`
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_permission_role_id_index` (`role_id`),
  KEY `role_permission_permission_id_index` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES ('6', '1', '2', '2016-12-06 11:33:51', '2016-12-06 11:33:51');
INSERT INTO `role_permission` VALUES ('7', '1', '3', '2016-12-08 08:01:26', '2016-12-08 08:01:26');
INSERT INTO `role_permission` VALUES ('8', '1', '4', '2016-12-10 09:18:17', '2016-12-10 09:18:17');
INSERT INTO `role_permission` VALUES ('10', '5', '5', '2016-12-11 09:27:55', '2016-12-11 09:27:55');
INSERT INTO `role_permission` VALUES ('11', '5', '4', '2016-12-11 09:27:55', '2016-12-11 09:27:55');
INSERT INTO `role_permission` VALUES ('12', '5', '3', '2016-12-11 09:27:55', '2016-12-11 09:27:55');
INSERT INTO `role_permission` VALUES ('13', '1', '5', '2016-12-11 09:33:56', '2016-12-11 09:33:56');
INSERT INTO `role_permission` VALUES ('14', '5', '6', '2016-12-12 07:56:16', '2016-12-12 07:56:16');
INSERT INTO `role_permission` VALUES ('15', '1', '6', '2016-12-12 07:56:20', '2016-12-12 07:56:20');
INSERT INTO `role_permission` VALUES ('16', '3', '7', '2016-12-13 08:30:33', '2016-12-13 08:30:33');
INSERT INTO `role_permission` VALUES ('17', '4', '8', '2016-12-14 04:55:07', '2016-12-14 04:55:07');
INSERT INTO `role_permission` VALUES ('20', '1', '9', '2016-12-15 07:22:57', '2016-12-15 07:22:57');
INSERT INTO `role_permission` VALUES ('21', '5', '9', '2016-12-15 07:22:57', '2016-12-15 07:22:57');
INSERT INTO `role_permission` VALUES ('22', '5', '10', '2016-12-15 07:51:16', '2016-12-15 07:51:16');
INSERT INTO `role_permission` VALUES ('23', '1', '10', '2016-12-15 07:51:31', '2016-12-15 07:51:31');
INSERT INTO `role_permission` VALUES ('24', '1', '11', '2016-12-15 10:47:46', '2016-12-15 10:47:46');
INSERT INTO `role_permission` VALUES ('25', '5', '11', '2016-12-15 10:47:52', '2016-12-15 10:47:52');

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1', '2016-12-07 14:26:57', '2016-12-07 14:27:00');
INSERT INTO `role_user` VALUES ('3', '3', '2016-12-08 10:51:33', '2016-12-08 10:51:33');
INSERT INTO `role_user` VALUES ('4', '3', '2016-12-09 10:17:27', '2016-12-09 10:17:27');
INSERT INTO `role_user` VALUES ('5', '3', '2016-12-09 11:10:38', '2016-12-09 11:10:38');
INSERT INTO `role_user` VALUES ('10', '4', '2016-12-11 07:43:43', '2016-12-11 07:43:43');
INSERT INTO `role_user` VALUES ('11', '4', '2016-12-11 07:44:01', '2016-12-11 07:44:01');
INSERT INTO `role_user` VALUES ('12', '4', '2016-12-11 07:44:17', '2016-12-11 07:44:17');
INSERT INTO `role_user` VALUES ('13', '4', '2016-12-11 07:44:38', '2016-12-11 07:44:38');
INSERT INTO `role_user` VALUES ('14', '4', '2016-12-11 07:44:52', '2016-12-11 07:44:52');
INSERT INTO `role_user` VALUES ('15', '4', '2016-12-11 07:45:05', '2016-12-11 07:45:05');
INSERT INTO `role_user` VALUES ('16', '4', '2016-12-12 10:56:45', '2016-12-12 10:56:45');
INSERT INTO `role_user` VALUES ('17', '4', '2016-12-12 10:58:37', '2016-12-12 10:58:37');
INSERT INTO `role_user` VALUES ('18', '4', '2016-12-12 10:59:28', '2016-12-12 10:59:28');
INSERT INTO `role_user` VALUES ('19', '3', '2016-12-13 02:49:21', '2016-12-13 02:49:21');
INSERT INTO `role_user` VALUES ('20', '3', '2016-12-13 02:49:36', '2016-12-13 02:49:36');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'SA', 'Super Admin', '', '1', '1', '2016-12-06 08:36:37', '2016-12-06 08:36:37');
INSERT INTO `roles` VALUES ('3', 'GV', 'Giảng viên', '', '1', '1', '2016-12-06 09:29:40', '2016-12-06 09:29:40');
INSERT INTO `roles` VALUES ('4', 'SV', 'Sinh viên', '', '1', '1', '2016-12-06 09:29:58', '2016-12-14 04:54:57');
INSERT INTO `roles` VALUES ('5', 'AD', 'Quản lý', '', '1', '1', '2016-12-10 09:18:39', '2016-12-10 09:18:39');

-- ----------------------------
-- Table structure for `student_cohort_program`
-- ----------------------------
DROP TABLE IF EXISTS `student_cohort_program`;
CREATE TABLE `student_cohort_program` (
  `user_id` int(10) unsigned NOT NULL,
  `cohort_id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`cohort_id`,`program_id`),
  KEY `student_cohort_program_user_id_index` (`user_id`),
  KEY `student_cohort_program_cohort_id_index` (`cohort_id`),
  KEY `student_cohort_program_program_id_index` (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of student_cohort_program
-- ----------------------------
INSERT INTO `student_cohort_program` VALUES ('10', '1', '1', '2016-12-12 10:34:42', '2016-12-12 10:34:42');
INSERT INTO `student_cohort_program` VALUES ('11', '1', '1', '2016-12-12 10:34:42', '2016-12-12 10:34:42');
INSERT INTO `student_cohort_program` VALUES ('12', '2', '3', '2016-12-11 09:14:31', '2016-12-11 09:14:31');
INSERT INTO `student_cohort_program` VALUES ('13', '2', '3', '2016-12-11 09:14:31', '2016-12-11 09:14:31');
INSERT INTO `student_cohort_program` VALUES ('14', '1', '1', '2016-12-12 10:34:42', '2016-12-12 10:34:42');
INSERT INTO `student_cohort_program` VALUES ('15', '1', '1', '2016-12-12 10:34:42', '2016-12-12 10:34:42');
INSERT INTO `student_cohort_program` VALUES ('17', '1', '3', '2016-12-12 10:58:37', '2016-12-12 10:58:37');
INSERT INTO `student_cohort_program` VALUES ('18', '1', '5', '2016-12-12 10:59:28', '2016-12-12 10:59:28');

-- ----------------------------
-- Table structure for `student_topic`
-- ----------------------------
DROP TABLE IF EXISTS `student_topic`;
CREATE TABLE `student_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `current_topic_id` int(11) NOT NULL DEFAULT '0',
  `register_topic_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: chưa đăng ký; 1: đăng ký, đợi phản hồi; 2: được bảo vệ; 3: Bảo vệ thành công',
  `can_register` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: được đăng ký; 0: không được đăng ký',
  `point` double NOT NULL DEFAULT '0',
  `teacher_id` int(11) NOT NULL DEFAULT '0',
  `teacher_accepted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: giảng viên chưa xác nhận,1: Giảng viên cho phép',
  `reviewer_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_topic_student_id_index` (`student_id`),
  KEY `student_topic_current_topic_id_index` (`current_topic_id`),
  KEY `student_topic_register_topic_id_index` (`register_topic_id`),
  KEY `student_topic_teacher_id_index` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of student_topic
-- ----------------------------
INSERT INTO `student_topic` VALUES ('1', '10', '1', '0', '3', '1', '0', '19', '1', '0', '2016-12-14 08:50:58', '2016-12-15 10:36:03');
INSERT INTO `student_topic` VALUES ('2', '11', '0', '2', '1', '1', '0', '0', '0', '0', '2016-12-15 07:31:15', '2016-12-15 07:32:14');

-- ----------------------------
-- Table structure for `teacher_field`
-- ----------------------------
DROP TABLE IF EXISTS `teacher_field`;
CREATE TABLE `teacher_field` (
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teacher_field
-- ----------------------------
INSERT INTO `teacher_field` VALUES ('19', '1', '1', null, null);
INSERT INTO `teacher_field` VALUES ('20', '1', '1', null, null);
INSERT INTO `teacher_field` VALUES ('19', '2', '1', null, null);
INSERT INTO `teacher_field` VALUES ('20', '2', '1', null, null);
INSERT INTO `teacher_field` VALUES ('19', '3', '1', null, null);
INSERT INTO `teacher_field` VALUES ('20', '3', '1', null, null);

-- ----------------------------
-- Table structure for `teacher_profile`
-- ----------------------------
DROP TABLE IF EXISTS `teacher_profile`;
CREATE TABLE `teacher_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teacher_profile
-- ----------------------------

-- ----------------------------
-- Table structure for `teacher_topic`
-- ----------------------------
DROP TABLE IF EXISTS `teacher_topic`;
CREATE TABLE `teacher_topic` (
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teacher_topic
-- ----------------------------
INSERT INTO `teacher_topic` VALUES ('19', '7', '2016-12-13 06:53:13', '2016-12-13 06:53:13');
INSERT INTO `teacher_topic` VALUES ('19', '1', '2016-12-14 03:40:34', '2016-12-14 03:40:34');
INSERT INTO `teacher_topic` VALUES ('19', '2', '2016-12-14 03:41:35', '2016-12-14 03:41:35');
INSERT INTO `teacher_topic` VALUES ('20', '2', null, null);
INSERT INTO `teacher_topic` VALUES ('20', '1', null, null);
INSERT INTO `teacher_topic` VALUES ('20', '3', '2016-12-14 03:45:47', '2016-12-14 03:45:47');
INSERT INTO `teacher_topic` VALUES ('19', '3', null, null);
INSERT INTO `teacher_topic` VALUES ('20', '4', '2016-12-15 09:05:00', '2016-12-15 09:05:00');
INSERT INTO `teacher_topic` VALUES ('20', '5', '2016-12-15 09:10:08', '2016-12-15 09:10:08');
INSERT INTO `teacher_topic` VALUES ('20', '6', '2016-12-15 09:11:53', '2016-12-15 09:11:53');

-- ----------------------------
-- Table structure for `teacher_unit`
-- ----------------------------
DROP TABLE IF EXISTS `teacher_unit`;
CREATE TABLE `teacher_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teacher_unit
-- ----------------------------
INSERT INTO `teacher_unit` VALUES ('1', '19', '1', '1', null, null);
INSERT INTO `teacher_unit` VALUES ('2', '20', '1', '1', null, null);

-- ----------------------------
-- Table structure for `terms`
-- ----------------------------
DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `log` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of terms
-- ----------------------------
INSERT INTO `terms` VALUES ('1', 'Tháng 12/2016', '2016-12-12 00:00:00', '2016-12-17 00:00:00', '[]', '2016-12-12 07:56:53', '2016-12-12 07:56:53');
INSERT INTO `terms` VALUES ('2', 'Tháng 03/2017', '2017-03-01 00:00:00', '2017-03-11 00:00:00', '[]', '2016-12-12 07:57:25', '2016-12-12 07:57:25');

-- ----------------------------
-- Table structure for `topics`
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_locked` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: cho phép đăng ký, 1: Khóa đăng ký',
  PRIMARY KEY (`id`),
  KEY `topics_field_id_index` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of topics
-- ----------------------------
INSERT INTO `topics` VALUES ('1', 'AI_001', 'Ứng dụng trí tuệ nhân tạo trong Cờ toán Việt Nam', '1', '<p>Ứng dụng trí tuệ nhân tạo trong Cờ toán Việt Nam 2017<br></p>', '19', '19', '2016-12-14 03:40:34', '2016-12-15 08:52:40', '0');
INSERT INTO `topics` VALUES ('2', 'MMT_002', 'Giám sát GPS bằng 3G', '2', '<p>Giám sát GPS bằng 3G 2017<br></p>', '19', '19', '2016-12-14 03:41:35', '2016-12-15 08:52:37', '0');

-- ----------------------------
-- Table structure for `units`
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `modified_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of units
-- ----------------------------
INSERT INTO `units` VALUES ('1', 'CNTT', 'Khoa Công nghệ thông tin', '', '1', null, '2016-12-12 10:18:40', '2016-12-13 02:46:30', 'khoa-cong-nghe-thong-tin');
INSERT INTO `units` VALUES ('2', 'DTVT', 'Khoa Điện tử viễn thông', '', '1', null, '2016-12-12 10:18:58', '2016-12-12 10:18:58', 'khoa-dien-tu-vien-thong');
INSERT INTO `units` VALUES ('3', 'VLKT', 'Khoa Vật lý Kỹ Thuật và Công nghệ Nano', '', '1', null, '2016-12-12 10:19:25', '2016-12-12 10:19:25', 'khoa-vat-ly-ky-thuat-va-cong-nghe-nano');
INSERT INTO `units` VALUES ('4', 'CHKT', 'Khoa Cơ học kỹ thụât và Tự động hoá', '', '1', null, '2016-12-12 10:19:36', '2016-12-12 10:19:36', 'khoa-co-hoc-ky-thuat-va-tu-dong-hoa');
INSERT INTO `units` VALUES ('5', 'DTQT', 'Chương trình liên kết đào tạo Quốc tế', '', '1', null, '2016-12-12 10:19:47', '2016-12-12 10:19:47', 'chuong-trinh-lien-ket-dao-tao-quoc-te');

-- ----------------------------
-- Table structure for `user_email_password`
-- ----------------------------
DROP TABLE IF EXISTS `user_email_password`;
CREATE TABLE `user_email_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_email_password
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(4) NOT NULL COMMENT '0:chưa active; 1: đã active; 2: bị khóa',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '0: male,1: female',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Trị', 'Quản', 'Siêu', '1980-01-01', '01667313134', '', 'thedc@omt.vn', '$2y$10$eE0yCJVBarT8OXK3rw6q1urT1TPzF786c17wvp1GVRTuv7fVh04kO', null, '1', 'PU2eBivURghUxfO47zAxFRdGt5jXQWRgGRjngKaBy6ROEPT4Nqct6Yne99pT', '2016-12-06 07:23:47', '2016-12-15 07:30:41', 'admin', 'avatar/admin-1481302368.jpg', '0');
INSERT INTO `users` VALUES ('10', '1', '', 'Student', '1980-01-01', '', '', 'tke.constructor@gmail.com', '$2y$10$N4hc62/UZrIdxTg31QMdCO5KyZN09kBPHYurv5zBjBv/aDCQXg0bG', null, '1', 'BoTRiAYYSJgYd2WFByy3wYqglhRRF15W55NZfyo7WX7bD8dp7oCUYdOvWynR', '2016-12-11 07:43:43', '2016-12-15 10:34:26', 'student001', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('11', '2', '', 'Student', '1980-01-01', '', '', 'student002@gmail.com', '$2y$10$AyeHdZUUMNreEA7E.hGHz.MBGjb81j0gdVpGwSTd4aCTPCM0/FvxC', null, '1', 'WhKKNCbvcSq0sR5YNk7vk1RrDz3DAj3kDWC58rpQNijkFcvsvOYGLb6kSCiv', '2016-12-11 07:44:01', '2016-12-15 08:53:00', 'student002', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('12', '3', '', 'Student', '1980-01-01', '', '', 'student003@gmail.com', '$2y$10$pSHmacFAih/bW6mIS2F8NumUelNVmoqEa6bY.ikLflFw4p5ZA5ZrS', null, '1', null, '2016-12-11 07:44:17', '2016-12-11 09:09:02', 'student003', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('13', '4', '', 'Student', '1980-01-01', '', '', 'student004@gmail.com', '$2y$10$8ZpFQgiDfrFAKB.I4Q5/E.n1gHjOJJ2TCPWR8A1tjsQVYY7oUPikG', null, '1', null, '2016-12-11 07:44:38', '2016-12-11 07:44:38', 'student004', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('14', '5', '', 'Student', '1980-01-01', '', '', 'student005@gmail.com', '$2y$10$HklvyvzFieGXDfKq65ftwu8hiA7OMVBqVckvA8Z5JMYct2xUqSg.i', null, '1', null, '2016-12-11 07:44:52', '2016-12-11 07:44:52', 'student005', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('15', '6', '', 'Student', '1980-01-01', '', '', 'student006@gmail.com', '$2y$10$MPS66JoPxsC3ZGsNjFuSr.cDxLNKlNDRX.iFA8p.96XhABzf.BMbq', null, '1', null, '2016-12-11 07:45:05', '2016-12-11 07:45:05', 'student006', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('17', '7', '', 'Student', '1980-01-01', '', '', 'student007@gmail.com', '$2y$10$LTFNDILDKHh9jVpNSGsk0O9/z8gsNUswHws3ttdH0d0Ka3NsgK64i', null, '1', null, '2016-12-12 10:58:37', '2016-12-12 10:58:37', 'student007', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('18', '8', '', 'Student', '1980-01-01', '', '', 'student008@gmail.com', '$2y$10$ZvVNbpOkagYp.YsVvo27eOzjL7qTPqgMezlccQN.1W7iU21Hv95BC', null, '1', null, '2016-12-12 10:59:27', '2016-12-12 10:59:27', 'student008', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('19', '1', 'viên', 'Giảng', '1980-01-01', '', '', 'giangvien1@gmail.com', '$2y$10$GsKrDNoNYLJA4MqZRnnJLuRiTcUhT7CVB0wn6II4bN/YDOIWwuLt6', null, '1', '7kFXXy5AzECtskiWLx5DNcpk2cMOxYRZUtgC9R5v9hU93aNwlOshT5PW5HD6', '2016-12-13 02:49:21', '2016-12-15 10:34:06', 'giangvien1', 'avatar/NOIMAGE.jpg', '0');
INSERT INTO `users` VALUES ('20', '2', 'viên', 'Giảng', '1980-01-01', '', '', 'giangvien2@gmail.com', '$2y$10$A6duj0/0FNjqD0X2ejCr5ejbVpTV2epgnxe80d/TJRERcRuUTKk6q', null, '1', 'D7lNpM5mzpiTPyOWBkN51yVYdl158rpnLsAZrBpXuobPSJlAtz7wU0ZcM4Dt', '2016-12-13 02:49:36', '2016-12-15 09:50:34', 'giangvien2', 'avatar/NOIMAGE.jpg', '0');
