ALTER TABLE  `s_users` ADD  `last_ip` VARCHAR( 15 ) NULL ,
ADD  `created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE  `s_products` ADD INDEX (  `name` )