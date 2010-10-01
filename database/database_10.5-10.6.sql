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
