-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:8889
-- Generation Time: Oct 13, 2008 at 09:49 PM
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
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `email` varchar(70) NOT NULL,
  `comments` blob NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Customer Info.' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `phppos_customers`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_items`
-- 

CREATE TABLE `phppos_items` (
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `upc` varchar(50) NOT NULL default '',
  `description` blob NOT NULL,
  `buy_price` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `tax_percent` decimal(15,2) NOT NULL,
  `sale_markdown_percent` int(2) NOT NULL default '0',
  `employee_markdown_percent` int(2) NOT NULL default '0',
  `quantity` int(10) NOT NULL default '0',
  `reorder_level` int(10) NOT NULL default '0',
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Item Info.' AUTO_INCREMENT=1 ;

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
  `id` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_modules`
-- 

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `id`) VALUES ('module_customers', 'module_customers_desc', 1, 'customers'),
('module_users', 'module_users_desc', 4, 'users'),
('module_sales', 'module_sales_desc', 5, 'sales'),
('module_reports', 'module_reports_desc', 3, 'reports'),
('module_items', 'module_items_desc', 2, 'items'),
('module_config', 'module_config_desc', 6, 'config');

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_permissions`
-- 

CREATE TABLE `phppos_permissions` (
  `module_id` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY  (`module_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_permissions`
-- 

INSERT INTO `phppos_permissions` (`module_id`, `user_id`) VALUES ('config', 1),
('customers', 1),
('items', 1),
('reports', 1),
('sales', 1),
('users', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales`
-- 

CREATE TABLE `phppos_sales` (
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `customer_id` int(10) NOT NULL default '0',
  `user_id` int(10) NOT NULL default '0',
  `comment` varchar(255) NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Contains overall sale details' AUTO_INCREMENT=1 ;

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
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table that holds item information for sales' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `phppos_sales_items`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sessions`
-- 

CREATE TABLE `phppos_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phppos_sessions`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_users`
-- 

CREATE TABLE `phppos_users` (
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='User info. that the program needs' AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `phppos_users`
-- 

INSERT INTO `phppos_users` (`first_name`, `last_name`, `username`, `password`, `id`) VALUES ('John', 'Doe', 'admin', '439a6de57d475c1a0ba9bcb1c39f0af6', 1);
