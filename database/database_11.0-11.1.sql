ALTER TABLE phppos_sales_items_taxes DROP FOREIGN KEY phppos_sales_items_taxes_ibfk_2;
ALTER TABLE `phppos_sales_items_taxes` ADD CONSTRAINT `phppos_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `phppos_items` (`item_id`);
