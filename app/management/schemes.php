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
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_theme', 'Priv', 'Priv');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_build', '-', '-');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_external_vars', 'hotel_swf_folder}/variables.txt', '{hotel_swf_folder}/variables.txt');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_external_texts', '{hotel_swf_folder}/texts.txt', '{hotel_swf_folder}/texts.txt');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_swf_folder', 'gordon/', 'gordon/{hotel_build}/');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_maitence', 'false', 'false');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_swf_folder', 'gordon/', 'gordon/{hotel_build}/');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('hotel_maitence', 'false', 'false');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_motto', 'I <3 Hybrid', 'I <3 Hybrid');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_credits', '5000', '5000');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_pixels', '10000', '10000');",
	"INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES ('default_looks', '-', '-');",
	
	"DROP TABLE IF EXISTS `cms_news`;",
	
	"CREATE TABLE `cms_news` (`id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(100) NOT NULL, `image` varchar(100) NOT NULL DEFAULT '0', `shortstory` text NOT NULL, `longstory` text NOT NULL, `author` varchar(100) NOT NULL DEFAULT 'Hobba Staff', `date` int(11) NOT NULL DEFAULT '0', `type` varchar(100) NOT NULL DEFAULT '1', `roomid` varchar(100) NOT NULL DEFAULT '1', `updated` enum('0','1') NOT NULL DEFAULT '0', `published` int(11) NOT NULL, `campaign` varchar(999) DEFAULT NULL, `campaignimg` varchar(999) DEFAULT NULL, `status` int(1) NOT NULL DEFAULT '1', PRIMARY KEY (`id`)) COLLATE='utf8_general_ci';"
);


