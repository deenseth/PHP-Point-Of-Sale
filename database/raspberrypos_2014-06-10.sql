# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.34)
# Database: raspberrypos
# Generation Time: 2014-06-11 02:26:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table phppos_app_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_app_config`;

CREATE TABLE `phppos_app_config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_app_config` WRITE;
/*!40000 ALTER TABLE `phppos_app_config` DISABLE KEYS */;

INSERT INTO `phppos_app_config` (`key`, `value`)
VALUES
	('address','123 Nowhere street'),
	('company','RaspberryPOS'),
	('default_tax_rate','8'),
	('email','admin@phppointofsale.com'),
	('fax',''),
	('phone','555-555-5555'),
	('return_policy','Test'),
	('timezone','America/New_York'),
	('website','');

/*!40000 ALTER TABLE `phppos_app_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_customers`;

CREATE TABLE `phppos_customers` (
  `person_id` int(10) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `phppos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_employees`;

CREATE TABLE `phppos_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `phppos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_employees` WRITE;
/*!40000 ALTER TABLE `phppos_employees` DISABLE KEYS */;

INSERT INTO `phppos_employees` (`username`, `password`, `person_id`, `deleted`)
VALUES
	('admin','439a6de57d475c1a0ba9bcb1c39f0af6',1,0);

/*!40000 ALTER TABLE `phppos_employees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_giftcards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_giftcards`;

CREATE TABLE `phppos_giftcards` (
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `value` double(15,2) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `phppos_giftcards` WRITE;
/*!40000 ALTER TABLE `phppos_giftcards` DISABLE KEYS */;

INSERT INTO `phppos_giftcards` (`giftcard_id`, `giftcard_number`, `value`, `deleted`)
VALUES
	(48,'00001',5.00,0);

/*!40000 ALTER TABLE `phppos_giftcards` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_inventory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_inventory`;

CREATE TABLE `phppos_inventory` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_inventory` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`),
  KEY `phppos_inventory_ibfk_1` (`trans_items`),
  KEY `phppos_inventory_ibfk_2` (`trans_user`),
  CONSTRAINT `phppos_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `phppos_items` (`item_id`),
  CONSTRAINT `phppos_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `phppos_employees` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_inventory` WRITE;
/*!40000 ALTER TABLE `phppos_inventory` DISABLE KEYS */;

INSERT INTO `phppos_inventory` (`trans_id`, `trans_items`, `trans_user`, `trans_date`, `trans_comment`, `trans_inventory`)
VALUES
	(1,1,1,'2014-06-10 18:22:46','Manual Edit of Quantity',50),
	(2,1,1,'2014-06-10 18:24:17','POS 1',-1);

/*!40000 ALTER TABLE `phppos_inventory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_item_kit_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_item_kit_items`;

CREATE TABLE `phppos_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double(15,2) NOT NULL,
  PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  KEY `phppos_item_kit_items_ibfk_2` (`item_id`),
  CONSTRAINT `phppos_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `phppos_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  CONSTRAINT `phppos_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_item_kits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_item_kits`;

CREATE TABLE `phppos_item_kits` (
  `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_items`;

CREATE TABLE `phppos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` double(15,2) NOT NULL,
  `unit_price` double(15,2) NOT NULL,
  `quantity` double(15,2) NOT NULL DEFAULT '0.00',
  `reorder_level` double(15,2) NOT NULL DEFAULT '0.00',
  `location` varchar(255) NOT NULL,
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`),
  KEY `phppos_items_ibfk_1` (`supplier_id`),
  CONSTRAINT `phppos_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `phppos_suppliers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_items` WRITE;
/*!40000 ALTER TABLE `phppos_items` DISABLE KEYS */;

INSERT INTO `phppos_items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `unit_price`, `quantity`, `reorder_level`, `location`, `item_id`, `allow_alt_description`, `is_serialized`, `deleted`)
VALUES
	('Test','Test',NULL,'F00035','',1.00,2.00,49.00,5.00,'',1,0,0,0);

/*!40000 ALTER TABLE `phppos_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_items_taxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_items_taxes`;

CREATE TABLE `phppos_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`item_id`,`name`,`percent`),
  CONSTRAINT `phppos_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_items_taxes` WRITE;
/*!40000 ALTER TABLE `phppos_items_taxes` DISABLE KEYS */;

INSERT INTO `phppos_items_taxes` (`item_id`, `name`, `percent`)
VALUES
	(1,'',10.00);

/*!40000 ALTER TABLE `phppos_items_taxes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_modules`;

CREATE TABLE `phppos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_modules` WRITE;
/*!40000 ALTER TABLE `phppos_modules` DISABLE KEYS */;

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`)
VALUES
	('module_config','module_config_desc',100,'config'),
	('module_customers','module_customers_desc',10,'customers'),
	('module_employees','module_employees_desc',80,'employees'),
	('module_giftcards','module_giftcards_desc',90,'giftcards'),
	('module_items','module_items_desc',20,'items'),
	('module_item_kits','module_item_kits_desc',30,'item_kits'),
	('module_mailchimp','module_mailchimp_desc',91,'mailchimpdash'),
	('module_receivings','module_receivings_desc',60,'receivings'),
	('module_reports','module_reports_desc',50,'reports'),
	('module_sales','module_sales_desc',70,'sales'),
	('module_suppliers','module_suppliers_desc',40,'suppliers');

/*!40000 ALTER TABLE `phppos_modules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_people
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_people`;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_people` WRITE;
/*!40000 ALTER TABLE `phppos_people` DISABLE KEYS */;

INSERT INTO `phppos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`)
VALUES
	('John','Doe','555-555-5555','admin@phppointofsale.com','Address 1','','','','','','',1);

/*!40000 ALTER TABLE `phppos_people` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_permissions`;

CREATE TABLE `phppos_permissions` (
  `module_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `phppos_permissions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_employees` (`person_id`),
  CONSTRAINT `phppos_permissions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `phppos_modules` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_permissions` WRITE;
/*!40000 ALTER TABLE `phppos_permissions` DISABLE KEYS */;

INSERT INTO `phppos_permissions` (`module_id`, `person_id`)
VALUES
	('config',1),
	('customers',1),
	('employees',1),
	('giftcards',1),
	('items',1),
	('reports',1),
	('sales',1);

/*!40000 ALTER TABLE `phppos_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_receivings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_receivings`;

CREATE TABLE `phppos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `phppos_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  CONSTRAINT `phppos_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `phppos_suppliers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_receivings_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_receivings_items`;

CREATE TABLE `phppos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` int(10) NOT NULL DEFAULT '0',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `phppos_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  CONSTRAINT `phppos_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `phppos_receivings` (`receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_sales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales`;

CREATE TABLE `phppos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `phppos_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  CONSTRAINT `phppos_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_sales` WRITE;
/*!40000 ALTER TABLE `phppos_sales` DISABLE KEYS */;

INSERT INTO `phppos_sales` (`sale_time`, `customer_id`, `employee_id`, `comment`, `sale_id`, `payment_type`)
VALUES
	('2014-06-10 18:24:17',NULL,1,'',1,'Cash: $1.00<br />Credit Card: $1.20<br />');

/*!40000 ALTER TABLE `phppos_sales` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_sales_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_items`;

CREATE TABLE `phppos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `phppos_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  CONSTRAINT `phppos_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_sales_items` WRITE;
/*!40000 ALTER TABLE `phppos_sales_items` DISABLE KEYS */;

INSERT INTO `phppos_sales_items` (`sale_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`)
VALUES
	(1,1,'','',1,1.00,1.00,2.00,0);

/*!40000 ALTER TABLE `phppos_sales_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_sales_items_taxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_items_taxes`;

CREATE TABLE `phppos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `phppos_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_items` (`sale_id`),
  CONSTRAINT `phppos_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_sales_items_taxes` WRITE;
/*!40000 ALTER TABLE `phppos_sales_items_taxes` DISABLE KEYS */;

INSERT INTO `phppos_sales_items_taxes` (`sale_id`, `item_id`, `line`, `name`, `percent`)
VALUES
	(1,1,1,'',10.00);

/*!40000 ALTER TABLE `phppos_sales_items_taxes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_sales_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_payments`;

CREATE TABLE `phppos_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`),
  CONSTRAINT `phppos_sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_sales_payments` WRITE;
/*!40000 ALTER TABLE `phppos_sales_payments` DISABLE KEYS */;

INSERT INTO `phppos_sales_payments` (`sale_id`, `payment_type`, `payment_amount`)
VALUES
	(1,'Cash',1.00),
	(1,'Credit Card',1.20);

/*!40000 ALTER TABLE `phppos_sales_payments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_sales_suspended
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_suspended`;

CREATE TABLE `phppos_sales_suspended` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `phppos_sales_suspended_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
  CONSTRAINT `phppos_sales_suspended_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `phppos_customers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_sales_suspended_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_suspended_items`;

CREATE TABLE `phppos_sales_suspended_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `phppos_sales_suspended_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`),
  CONSTRAINT `phppos_sales_suspended_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_suspended` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_sales_suspended_items_taxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_suspended_items_taxes`;

CREATE TABLE `phppos_sales_suspended_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `phppos_sales_suspended_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_suspended_items` (`sale_id`),
  CONSTRAINT `phppos_sales_suspended_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_sales_suspended_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sales_suspended_payments`;

CREATE TABLE `phppos_sales_suspended_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`),
  CONSTRAINT `phppos_sales_suspended_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales_suspended` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table phppos_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_sessions`;

CREATE TABLE `phppos_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `phppos_sessions` WRITE;
/*!40000 ALTER TABLE `phppos_sessions` DISABLE KEYS */;

INSERT INTO `phppos_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`)
VALUES
	('5486180e8cdea167fbdc815f988dc6eb','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) App',1402437182,'a:8:{s:9:\"person_id\";s:1:\"1\";s:8:\"cartRecv\";a:1:{i:1;a:10:{s:7:\"item_id\";s:1:\"1\";s:4:\"line\";i:1;s:4:\"name\";s:4:\"Test\";s:11:\"description\";s:0:\"\";s:12:\"serialnumber\";s:0:\"\";s:21:\"allow_alt_description\";s:1:\"0\";s:13:\"is_serialized\";s:1:\"0\";s:8:\"quantity\";i:1;s:8:\"discount\";i:0;s:5:\"price\";s:4:\"1.00\";}}s:9:\"recv_mode\";s:7:\"receive\";s:8:\"supplier\";s:2:\"-1\";s:4:\"cart\";a:1:{i:1;a:11:{s:7:\"item_id\";s:1:\"1\";s:4:\"line\";i:1;s:4:\"name\";s:4:\"Test\";s:11:\"item_number\";s:6:\"F00035\";s:11:\"description\";s:0:\"\";s:12:\"serialnumber\";s:0:\"\";s:21:\"allow_alt_description\";s:1:\"0\";s:13:\"is_serialized\";s:1:\"0\";s:8:\"quantity\";i:1;s:8:\"discount\";i:0;s:5:\"price\";s:4:\"2.00\";}}s:9:\"sale_mode\";s:4:\"sale\";s:8:\"customer\";s:2:\"-1\";s:8:\"payments\";a:0:{}}');

/*!40000 ALTER TABLE `phppos_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phppos_suppliers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phppos_suppliers`;

CREATE TABLE `phppos_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `phppos_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `phppos_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
