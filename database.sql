-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:8889
-- Generation Time: Oct 18, 2008 at 07:34 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.5
-- 
-- Database: `pos`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_customers`
-- 

CREATE TABLE `phppos_customers` (
  `person_id` int(10) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_customers`
-- 


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

INSERT INTO `phppos_employees` (`username`, `password`, `person_id`) VALUES ('admin', 'ac6fccd789003ba8e9f83c1c7063d85a', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_items`
-- 

CREATE TABLE `phppos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `upc` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `buy_price` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `tax_percent` decimal(15,2) NOT NULL,
  `sale_markdown_percent` int(2) NOT NULL default '0',
  `employee_markdown_percent` int(2) NOT NULL default '0',
  `quantity` int(10) NOT NULL default '0',
  `reorder_level` int(10) NOT NULL default '0',
  `item_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_items`
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
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_people`
-- 

INSERT INTO `phppos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES ('Chris', 'Muench', '585-880-6599', 'me@chrismuench.com', 'Address 1', '', '', '', '', '', '', 1);

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
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `customer_id` int(10) NOT NULL default '0',
  `employee_id` int(10) NOT NULL default '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sales`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales_items`
-- 

CREATE TABLE `phppos_sales_items` (
  `sale_id` int(10) NOT NULL default '0',
  `item_id` int(10) NOT NULL default '0',
  `quantity_purchased` int(10) NOT NULL default '0',
  `item_unit_price` decimal(15,2) NOT NULL,
  `item_buy_price` decimal(15,2) NOT NULL,
  `item_tax_percent` decimal(4,2) NOT NULL,
  `sale_item_id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`sale_item_id`),
  KEY `sale_id` (`sale_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sales_items`
-- 


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
