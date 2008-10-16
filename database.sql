-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:8889
-- Generation Time: Oct 16, 2008 at 04:50 PM
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
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB AUTO_INCREMENT=1605 COMMENT='Customer Info.';

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
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB COMMENT='Item Info.';

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
) TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_permissions`
-- 

CREATE TABLE `phppos_permissions` (
  `module_id` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY  (`module_id`,`user_id`)
) TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_sales`
-- 

CREATE TABLE `phppos_sales` (
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `customer_id` int(10) NOT NULL default '0',
  `user_id` int(10) NOT NULL default '0',
  `comment` text NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB COMMENT='Contains overall sale details';

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
) TYPE=InnoDB COMMENT='Table that holds item information for sales';

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
) TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `phppos_users`
-- 

CREATE TABLE `phppos_users` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) TYPE=InnoDB AUTO_INCREMENT=2 COMMENT='User info. that the program needs';

-- 
-- Dumping data for table `phppos_users`
-- 

INSERT INTO `phppos_users` (`first_name`, `last_name`, `username`, `password`, `id`) VALUES ('John', 'Doe', 'admin', '439a6de57d475c1a0ba9bcb1c39f0af6', 1);
