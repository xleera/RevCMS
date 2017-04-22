<?php
/**
 * RevolutionCMS
 * 
 * @author	Kryptos
 * @author	GarettM
 * @version 0.8.1
 */
 
return array(
	"DROP TABLE IF EXISTS `cms_settings`",
	
	"CREATE TABLE `cms_settings` (`id` INT(12) NOT NULL AUTO_INCREMENT, `setting_key` VARCHAR(64) NOT NULL, `setting_value` VARCHAR(64) NOT NULL, `setting_default` VARCHAR(64) NOT NULL DEFAULT '', PRIMARY KEY(`id`) ) COLLATE='utf8_general_ci';",
	
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_name', 'Hybrid Hotel', 'Hybrid Hotel');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_desc', 'The Greatest Hotel Ever', 'The Greatest Hotel Ever');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_url', 'http://localhost/', 'http://habbo.hotel/');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_theme', 'Simple', 'Simple');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('swf_build', 'PRODUCTION-201701242205-837386173', 'PRODUCTION-201701242205-837386173');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('swf_path', '', 'http://image.hybridhotel.pw');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_maintenance', 'false', 'false');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_motto', 'I <3 Hybrid', 'I <3 Hybrid');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_credits', '5000', '5000');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_pixels', '10000', '10000');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_looks', '-', '-');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('emu_address', '127.0.0.1', '127.0.0.1');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('emu_port', '30000', '30000');",
	
	"DROP TABLE IF EXISTS `cms_news`;",
	
	"CREATE TABLE `cms_news` (`id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(100) NOT NULL, `image` varchar(100) NOT NULL DEFAULT '0', `shortstory` text NOT NULL, `longstory` text NOT NULL, `author` varchar(100) NOT NULL DEFAULT 'Hobba Staff', `date` int(11) NOT NULL DEFAULT '0', `type` varchar(100) NOT NULL DEFAULT '1', `roomid` varchar(100) NOT NULL DEFAULT '1', `updated` enum('0','1') NOT NULL DEFAULT '0', `published` int(11) NOT NULL, `campaign` varchar(999) DEFAULT NULL, `campaignimg` varchar(999) DEFAULT NULL, `status` int(1) NOT NULL DEFAULT '1', PRIMARY KEY (`id`)) COLLATE='utf8_general_ci';",
	
	"DROP TABLE IF EXISTS `cms_ranks`;",
	
	"CREATE TABLE `cms_ranks` (`id` INT(12) NOT NULL AUTO_INCREMENT, `rank` INT(12) NOT NULL, `name` VARCHAR(64) NOT NULL, `permission` TEXT, PRIMARY KEY(`id`)) COLLATE='utf8_general_ci';",
	
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('1', 'Member', '[]');",
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('2', 'VIP Member', '[]');",
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('3', '{hotelName} Helper', '[]');",
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('4', 'Trail Moderator', '[]');",
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('5', 'Moderator', '[]');",
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('6', 'Administrator', '[]');",
	"INSERT INTO `cms_ranks` (`rank`, `name`, `permission`) VALUES ('7', 'Owner', '[]');"
);


