-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:8889
-- Generation Time: Nov 08, 2008 at 10:41 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.5
-- 
-- Database: `pos`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_app_config`
-- 

CREATE TABLE `phppos_app_config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_app_config`
-- 

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('company', 'Chris Muench Inc'),
('address', '30 Foxboro Lane\nFairport, NY 14450'),
('phone', '585-223-1188'),
('email', 'me@chrismuench.com'),
('fax', ''),
('default_tax_rate', '8'),
('website', ''),
('version', '10.0');

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_customers`
-- 

CREATE TABLE `phppos_customers` (
  `person_id` int(10) NOT NULL,
  `account_number` varchar(255) default NULL,
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_customers`
-- 

INSERT INTO `phppos_customers` (`person_id`, `account_number`) VALUES (145, NULL),
(146, NULL),
(147, NULL),
(148, NULL),
(150, NULL),
(151, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_employees`
-- 

CREATE TABLE `phppos_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_employees`
-- 

INSERT INTO `phppos_employees` (`username`, `password`, `person_id`) VALUES ('admin', '439a6de57d475c1a0ba9bcb1c39f0af6', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_items`
-- 

CREATE TABLE `phppos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item_number` varchar(255) default NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `tax_percent` int(2) NOT NULL,
  `quantity` int(10) NOT NULL default '0',
  `reorder_level` int(10) NOT NULL default '0',
  `item_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`item_id`),
  UNIQUE KEY `item_number` (`item_number`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- 
-- Dumping data for table `phppos_items`
-- 

INSERT INTO `phppos_items` (`name`, `category`, `item_number`, `description`, `unit_price`, `tax_percent`, `quantity`, `reorder_level`, `item_id`) VALUES ('Duracell AA Alkaline batteries - 4 pack', 'Electronics', '041333015330', 'Duracell AA Alkaline batteries - 4 pack', 4.95, 8, 10, 1, 43),
('POLAND SPRING WATER PET', 'Grocery', '075720008513', 'POLAND SPRING WATER PET', 14.32, 8, 10, 1, 44),
('Simpsons Series 6 Kitchen Playset Muumuu Homer Figure', 'Toy', '029000070370', 'Simpsons Series 6 Kitchen Playset Muumuu Homer Figure', 22.00, 8, 11, 1, 45),
('Hersheys Whoppers Mini Carton Peanut Butter Malted Milk Balls Candy - 3.5 Oz, 15 / Pack', 'Grocery', '0010700022929', 'Hersheys Whoppers Mini Carton Peanut Butter Malted Milk Balls Candy - 3.5 Oz, 15 / Pack', 18.26, 8, 11, 1, 46);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_modules`
-- 

CREATE TABLE `phppos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  PRIMARY KEY  (`module_id`),
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
  `person_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

-- 
-- Dumping data for table `phppos_people`
-- 

INSERT INTO `phppos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES ('John', 'Doe', '585-880-6599', 'me@chrismuench.com', 'Address 1', '', '', '', '', '', '', 1),
('Chris', 'Muench', '', '', '', '', '', '', '', '', '', 135),
('Chris', 'Muench', '585-880-6599', 'me@chrismuench.com', '30 Foxboro Lane', '', 'Fairport', 'NY', '14450', '', '', 145),
('John', 'Smith', '', '', '', '', '', '', '', '', '', 146),
('Bob', 'Barr', '', 'test@test.com', '', '', '', '', '', '', '', 147),
('Barrack', 'Obama', '', '', '', '', '', '', '', '', '', 148),
('Greg', 'Kholberger', '', '', '', '', '', '', '', '', '', 150),
('Joe', 'The plumber', '', 'joe@theplumber.com', '', '', '', '', '', '', '', 151);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_permissions`
-- 

CREATE TABLE `phppos_permissions` (
  `module_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY  (`module_id`,`person_id`),
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
('sales', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales`
-- 

CREATE TABLE `phppos_sales` (
  `sale_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `customer_id` int(10) default NULL,
  `employee_id` int(10) NOT NULL default '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `phppos_sales`
-- 

INSERT INTO `phppos_sales` (`sale_time`, `customer_id`, `employee_id`, `comment`, `sale_id`) VALUES ('2008-11-08 22:35:03', NULL, 1, 'Awesome', 1),
('2008-11-08 22:35:37', NULL, 1, '', 2),
('2008-11-08 22:37:29', 145, 1, '', 3),
('2008-11-08 22:39:12', 145, 1, '', 4),
('2008-11-08 22:39:41', NULL, 1, '', 5),
('2008-11-08 22:39:59', NULL, 1, '', 6);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales_items`
-- 

CREATE TABLE `phppos_sales_items` (
  `sale_id` int(10) NOT NULL default '0',
  `item_id` int(10) NOT NULL default '0',
  `quantity_purchased` int(10) NOT NULL default '0',
  `item_unit_price` decimal(15,2) NOT NULL,
  `item_tax_percent` decimal(4,2) NOT NULL,
  `sale_item_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`sale_item_id`),
  KEY `sale_id` (`sale_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `phppos_sales_items`
-- 

INSERT INTO `phppos_sales_items` (`sale_id`, `item_id`, `quantity_purchased`, `item_unit_price`, `item_tax_percent`, `sale_item_id`) VALUES (1, 43, 3, 4.95, 8.00, 1),
(2, 45, 2, 22.00, 8.00, 2),
(2, 43, 4, 4.95, 8.00, 3),
(2, 46, 1, 18.26, 8.00, 4),
(2, 44, 3, 14.32, 8.00, 5),
(3, 43, 1, 4.95, 8.00, 6),
(3, 44, 1, 14.32, 8.00, 7),
(4, 43, 1, 4.95, 8.00, 8),
(5, 43, 1, 4.95, 8.00, 9),
(6, 43, 1, 4.95, 8.00, 10),
(6, 46, 1, 18.26, 8.00, 11),
(6, 45, 1, 22.00, 8.00, 12);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sessions`
-- 

CREATE TABLE `phppos_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sessions`
-- 

INSERT INTO `phppos_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('e61294346c5863089c5cc707221121ce', '10.37.129.2', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; ', 1226201947, 'a:3:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:8:"customer";s:2:"-1";}'),
('4b0ea036feaf9c2b187901f407c17ee4', '0.0.0.0', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; ', 1226201294, '');

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `phppos_customers`
-- 
ALTER TABLE `phppos_customers`
  ADD CONSTRAINT `phppos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`);

-- 
-- Constraints for table `phppos_employees`
-- 
ALTER TABLE `phppos_employees`
  ADD CONSTRAINT `phppos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`);

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
  ADD CONSTRAINT `phppos_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`);

-- 
-- Constraints for table `phppos_sales_items`
-- 
ALTER TABLE `phppos_sales_items`
  ADD CONSTRAINT `phppos_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  ADD CONSTRAINT `phppos_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`);
