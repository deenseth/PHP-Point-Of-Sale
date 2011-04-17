INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) 
VALUES ('module_mailchimp', 'module_mailchimp_desc', 91, 'mailchimpdash');
INSERT INTO `phppos_permissions` (`module_id`, `person_id`) VALUES ('mailchimpdash', '1');

CREATE TABLE `phppos_campaignbuilds` (
    `campaign_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `report_type` VARCHAR(255) NOT NULL,
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
);