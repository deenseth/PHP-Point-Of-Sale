ALTER TABLE  `phppos_sessions` CHANGE  `user_data`  `user_data` TEXT NULL;
ALTER TABLE  `phppos_items` ADD  `location` VARCHAR( 255 ) NOT NULL AFTER  `reorder_level`;
UPDATE `phppos_modules` SET `sort` = '10' WHERE `phppos_modules`.`module_id` = 'customers'; 
UPDATE `phppos_modules` SET `sort` = '20' WHERE `phppos_modules`.`module_id` = 'items'; 
UPDATE `phppos_modules` SET `sort` = '40' WHERE `phppos_modules`.`module_id` = 'suppliers';
UPDATE `phppos_modules` SET `sort` = '50' WHERE `phppos_modules`.`module_id` = 'reports'; 
UPDATE `phppos_modules` SET `sort` = '60' WHERE `phppos_modules`.`module_id` = 'receivings'; 
UPDATE `phppos_modules` SET `sort` = '70' WHERE `phppos_modules`.`module_id` = 'sales'; 
UPDATE `phppos_modules` SET `sort` = '80' WHERE `phppos_modules`.`module_id` = 'employees'; 
UPDATE `phppos_modules` SET `sort` = '90' WHERE `phppos_modules`.`module_id` = 'giftcards';
UPDATE `phppos_modules` SET `sort` = '100' WHERE `phppos_modules`.`module_id` = 'config'; 
INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES ('module_item_kits', 'module_item_kits_desc', '30', 'item_kits');
INSERT INTO `phppos_permissions` (`module_id`, `person_id`) VALUES ('item_kits', '1');
CREATE TABLE  `phppos_item_kits` (
`item_kit_id` INT NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`description` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY (  `item_kit_id` )
) ENGINE = INNODB;
CREATE TABLE `phppos_item_kit_items` (
`item_kit_id` INT NOT NULL, 
`item_id` INT NOT NULL, 
`quantity` double(15,2) NOT NULL, 
PRIMARY KEY (`item_kit_id`, `item_id`, `quantity`)
) ENGINE = INNODB;
ALTER TABLE `phppos_item_kit_items`
ADD CONSTRAINT `phppos_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`) ON DELETE CASCADE,
ADD CONSTRAINT `phppos_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE;