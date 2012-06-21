CREATE TABLE IF NOT EXISTS `s_coupons` (
  `id` bigint(20) NOT NULL auto_increment,
  `code` varchar(256) NOT NULL,
  `expire` timestamp NULL default NULL,
  `type` enum('absolute','percentage') NOT NULL default 'absolute',
  `value` float(10,2) NOT NULL,
  `min_order_price` float(10,2) default NULL,
  `single` int(1) NOT NULL default '0',
  `usages` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

ALTER TABLE  `s_orders` ADD  `coupon_discount` FLOAT( 10, 2 ) NOT NULL AFTER  `discount` ;
ALTER TABLE  `s_orders` ADD  `coupon_code` VARCHAR( 255 ) NOT NULL AFTER  `coupon_discount` ;