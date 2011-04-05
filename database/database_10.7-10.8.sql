CREATE TABLE IF NOT EXISTS `phppos_giftcards` (
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `value` double(15,2) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_giftcards', 'module_giftcards_desc', 9, 'giftcards'),
('module_mailchimp', 'module_mailchimp_desc', 10, 'mailchimpdash');

INSERT INTO `phppos_permissions` (`module_id`, `person_id`) VALUES ('giftcards',1);

CREATE TABLE IF NOT EXISTS `phppos_campaignbuilds` (
    `campaign_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `report_model` VARCHAR(255) NOT NULL,
    `report_params` MEDIUMTEXT,
    `interval` ENUM('daily', 'weekly', 'monthly'),
    `list_id` VARCHAR(255) NOT NULL,
    `grouping_id` VARCHAR(255),
    `grouping_value` VARCHAR(255),
    `title` VARCHAR(255) NOT NULL,
    `blurb` VARCHAR(255),
    `from_email` VARCHAR(255) NOT NULL,
    `from_name` VARCHAR(255) NOT NULL,
    `to_name` VARCHAR(255) NOT NULL
)