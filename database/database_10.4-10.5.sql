ALTER TABLE `phppos_items` ADD `allow_alt_description` BOOL NOT NULL; 
ALTER TABLE `phppos_items` ADD `is_serialized` BOOL NOT NULL;

ALTER TABLE `phppos_sales_items` ADD `line` INT( 3 ) NULL AFTER `item_id`;
UPDATE `phppos_sales_items` SET line =1;

ALTER TABLE `phppos_sales_items` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `sale_id` , `item_id` , `line` );

ALTER TABLE `phppos_sales_items_taxes` ADD `line` INT( 3 ) NULL AFTER `item_id`; 
UPDATE  `phppos_sales_items_taxes` SET line=1;

ALTER TABLE `phppos_sales_items_taxes` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `sale_id` , `item_id` , `line` , `name` , `percent` ); 

ALTER TABLE `phppos_sales_items` ADD `description` VARCHAR( 30 ) NULL AFTER `item_id` ,
ADD `serialnumber` VARCHAR( 30 ) NULL AFTER `description` ;

ALTER TABLE `phppos_items` CHANGE `quantity` `quantity` DOUBLE( 15, 2 ) NOT NULL DEFAULT '0',
CHANGE `reorder_level` `reorder_level` DOUBLE( 15, 2 ) NOT NULL DEFAULT '0';

ALTER TABLE `phppos_sales_items` CHANGE `quantity_purchased` `quantity_purchased` DOUBLE( 15, 2 ) NOT NULL DEFAULT '0';