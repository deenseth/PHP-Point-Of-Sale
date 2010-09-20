CREATE TABLE IF NOT EXISTS `phppos_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `phppos_sales_payments`
  ADD CONSTRAINT `phppos_sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`);
  
ALTER TABLE `phppos_sales` CHANGE `payment_type` `payment_type` VARCHAR( 512 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `phppos_sales_payments` ADD CONSTRAINT `phppos_sales_payments_ibfk_1` FOREIGN KEY ( `sale_id` ) REFERENCES `phppos_sales` ( `sale_id` ) ;