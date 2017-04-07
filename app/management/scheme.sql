CREATE TABLE `cms_settings` (
	`id` INT(12) NOT NULL AUTO_INCREMENT,
	`setting_key` VARCHAR(64) NOT NULL,
	`setting_value` VARCHAR(64) NOT NULL,
	`setting_default` VARCHAR(64) NOT NULL DEFAULT '',
	
	PRIMARY KEY(`id`)
) COLLATE='utf8_general_ci';

INSERT INTO `cms_settings` (`setting_key`, `setting_value`, `setting_default`) VALUES
('hotel_name', '%s', 'Hybrid Hotel'),
('hotel_desc', '%s', 'The Greatest Hotel Ever'),
('hotel_url', '%s', 'http://127.0.0.1'),
('hotel_theme', '%s', 'Priv'),
('hotel_build', '%s', '-'),
('hotel_external_vars', '%s', '{hotel_swf_folder}/variables.txt'),
('hotel_external_texts', '%s', '{hotel_swf_folder}/texts.txt'),
('hotel_swf_folder', '%s', 'gordon/{hotel_build}/'),
('hotel_maitence', '%s', 'false'),
('default_motto', '%s', 'I <3 Hybrid'),
('default_credits', '%d', '5000'),
('default_pixels', '%d', '10000'),
('default_looks', '%s', '-');

DROP TABLE IF EXISTS `cms_news`;
CREATE TABLE `cms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT '0',
  `shortstory` text NOT NULL,
  `longstory` text NOT NULL,
  `author` varchar(100) NOT NULL DEFAULT 'Hobba Staff',
  `date` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '1',
  `roomid` varchar(100) NOT NULL DEFAULT '1',
  `updated` enum('0','1') NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL,
  `campaign` varchar(999) DEFAULT NULL,
  `campaignimg` varchar(999) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;