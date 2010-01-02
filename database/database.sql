-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:8889
-- Generation Time: Jan 02, 2010 at 02:15 PM
-- Server version: 5.1.39
-- PHP Version: 5.3.0
-- 
-- Database: `pos`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_customers`
-- 

CREATE TABLE `phppos_customers` (
  `person_id` int(10) NOT NULL,
  `store_id` int(10) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `unique_account_number` (`store_id`,`account_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_customers`
-- 

INSERT INTO `phppos_customers` (`person_id`, `store_id`, `account_number`) VALUES (7, 2, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_employees`
-- 

CREATE TABLE `phppos_employees` (
  `person_id` int(10) NOT NULL,
  `store_id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `unique_username` (`store_id`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_employees`
-- 

INSERT INTO `phppos_employees` (`person_id`, `store_id`, `username`, `password`) VALUES (1, 1, 'admin', '439a6de57d475c1a0ba9bcb1c39f0af6'),
(2, 2, 'admin', '439a6de57d475c1a0ba9bcb1c39f0af6');

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_items`
-- 

CREATE TABLE `phppos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` double(15,2) NOT NULL,
  `unit_price` double(15,2) NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '0',
  `reorder_level` int(10) NOT NULL DEFAULT '0',
  `store_id` int(11) NOT NULL,
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`,`store_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_items_taxes`
-- 

CREATE TABLE `phppos_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`item_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_items_taxes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_modules`
-- 

CREATE TABLE `phppos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_modules`
-- 

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES ('module_config', 'module_config_desc', 6, 'config'),
('module_customers', 'module_customers_desc', 1, 'customers'),
('module_employees', 'module_employees_desc', 5, 'employees'),
('module_items', 'module_items_desc', 2, 'items'),
('module_reports', 'module_reports_desc', 3, 'reports'),
('module_sales', 'module_sales_desc', 4, 'sales');

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_people`
-- 

CREATE TABLE `phppos_people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_people`
-- 

INSERT INTO `phppos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES ('Super', 'Admin', '', '', '', '', '', '', '', '', '', 1),
('Super', 'Admin 2', '', '', '', '', '', '', '', '', '', 2),
('Chris', 'Muench', '585-880-6599', 'cmuench@me.com', '19 Slate Creek Drive Apt. 9', '', 'Cheektowaga', 'NY', '14227', '', '', 7);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_permissions`
-- 

CREATE TABLE `phppos_permissions` (
  `module_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_permissions`
-- 

INSERT INTO `phppos_permissions` (`module_id`, `person_id`) VALUES ('config', 1),
('customers', 1),
('employees', 1),
('items', 1),
('reports', 1),
('sales', 1),
('config', 2),
('customers', 2),
('employees', 2),
('items', 2),
('reports', 2),
('sales', 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales`
-- 

CREATE TABLE `phppos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `store_id` int(11) NOT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sales`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales_items`
-- 

CREATE TABLE `phppos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `quantity_purchased` int(10) NOT NULL DEFAULT '0',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sales_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales_items_taxes`
-- 

CREATE TABLE `phppos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sales_items_taxes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sessions`
-- 

CREATE TABLE `phppos_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sessions`
-- 

INSERT INTO `phppos_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('cc62d026707a459adb9bc96173a248cf', '192.168.1.120', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_1; ', 1262459604, 'a:1:{s:9:"person_id";s:1:"2";}'),
('dd7fc5d93596d5aa7200098342e878da', '0.0.0.0', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_1; ', 1262459560, 'a:1:{s:9:"person_id";s:1:"1";}');

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_store_lookup`
-- 

CREATE TABLE `phppos_store_lookup` (
  `host` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`host`,`store_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_store_lookup`
-- 

INSERT INTO `phppos_store_lookup` (`host`, `store_id`) VALUES ('http://localhost', 1),
('http://192.168.1.120', 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_stores`
-- 

CREATE TABLE `phppos_stores` (
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `default_tax_rate` double(15,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `return_policy` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_stores`
-- 

INSERT INTO `phppos_stores` (`name`, `address`, `default_tax_rate`, `email`, `phone`, `fax`, `return_policy`, `website`, `store_id`) VALUES ('PHP Point Of Sale Inc.', '123 Nowhere street', 8.00, 'admin@phppointofsale.com', '585-880-6599', '', 'Return''s are accepted after 14 days', 'http://www.phppointofsale.com', 1),
('Chris Muench Inc.', '30 Foxboro Lane', 10.00, 'me@chrismuench.com', '585-880-6599', '585-880-6599', '', 'http://chrismuench.com', 2);

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `phppos_customers`
-- 
ALTER TABLE `phppos_customers`
  ADD CONSTRAINT `phppos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`),
  ADD CONSTRAINT `phppos_customers_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `phppos_stores` (`store_id`);

-- 
-- Constraints for table `phppos_employees`
-- 
ALTER TABLE `phppos_employees`
  ADD CONSTRAINT `phppos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`),
  ADD CONSTRAINT `phppos_employees_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `phppos_stores` (`store_id`);

-- 
-- Constraints for table `phppos_items`
-- 
ALTER TABLE `phppos_items`
  ADD CONSTRAINT `phppos_items_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `phppos_stores` (`store_id`);

-- 
-- Constraints for table `phppos_items_taxes`
-- 
ALTER TABLE `phppos_items_taxes`
  ADD CONSTRAINT `phppos_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE;

-- 
-- Constraints for table `phppos_permissions`
-- 
ALTER TABLE `phppos_permissions`
  ADD CONSTRAINT `phppos_permissions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_permissions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `phppos_modules` (`module_id`);

-- 
-- Constraints for table `phppos_sales`
-- 
ALTER TABLE `phppos_sales`
  ADD CONSTRAINT `phppos_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  ADD CONSTRAINT `phppos_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`),
  ADD CONSTRAINT `phppos_sales_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `phppos_stores` (`store_id`);

-- 
-- Constraints for table `phppos_sales_items`
-- 
ALTER TABLE `phppos_sales_items`
  ADD CONSTRAINT `phppos_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`);

-- 
-- Constraints for table `phppos_sales_items_taxes`
-- 
ALTER TABLE `phppos_sales_items_taxes`
  ADD CONSTRAINT `phppos_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_items` (`sale_id`),
  ADD CONSTRAINT `phppos_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_sales_items` (`item_id`);

-- 
-- Constraints for table `phppos_store_lookup`
-- 
ALTER TABLE `phppos_store_lookup`
  ADD CONSTRAINT `phppos_store_lookup_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `phppos_stores` (`store_id`);
