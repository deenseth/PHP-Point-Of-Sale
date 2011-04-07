ALTER TABLE  `phppos_sessions` CHANGE  `user_data`  `user_data` TEXT NULL;
ALTER TABLE  `phppos_items` ADD  `location` VARCHAR( 255 ) NOT NULL AFTER  `reorder_level`;