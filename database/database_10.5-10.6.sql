CREATE TABLE `phppos_inventory` (
  `trans_id` int(11) NOT NULL auto_increment,
  `trans_items` int(11) NOT NULL default '0',
  `trans_user` int(11) NOT NULL default '0',
  `trans_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_inventory` int(11) NOT NULL default '0',
  PRIMARY KEY  (`trans_id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `phppos_inventory`
 ADD CONSTRAINT `phppos_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `phppos_items` (`item_id`),
 ADD CONSTRAINT `phppos_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `phppos_employees` (`person_id`);

CREATE TABLE IF NOT EXISTS `phppos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `phppos_receivings`
  ADD CONSTRAINT `phppos_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `phppos_suppliers` (`person_id`);

CREATE TABLE IF NOT EXISTS `phppos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` int(10) NOT NULL DEFAULT '0',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receiving_id`,`item_id`, `line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `phppos_receivings_items`
  ADD CONSTRAINT `phppos_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `phppos_receivings` (`receiving_id`);


INSERT INTO `phppos_modules` (
`name_lang_key` ,
`desc_lang_key` ,
`sort` ,
`module_id` 
)
VALUES (
'module_receivings', 'module_receivings_desc', '4', 'receivings'
);

INSERT INTO `phppos_permissions` (
`module_id` ,
`person_id` 
)
VALUES (
'receivings', '1'
);

ALTER TABLE `phppos_items` ADD `deleted` INT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `phppos_customers` ADD `deleted` INT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `phppos_suppliers` ADD `deleted` INT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `phppos_employees` ADD `deleted` INT( 1 ) NOT NULL DEFAULT '0';