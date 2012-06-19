RENAME TABLE  `brands` TO  `s_brands`;
RENAME TABLE  `categories` TO  `s_categories` ;
RENAME TABLE  `currencies` TO  `s_currencies` ;
RENAME TABLE  `delivery_methods` TO  `s_delivery` ;
RENAME TABLE  `delivery_payment` TO  `s_delivery_payment` ;
RENAME TABLE  `feedback` TO  `s_feedbacks` ;
RENAME TABLE  `groups` TO  `s_groups` ;
RENAME TABLE  `menu` TO  `s_menu` ;
DROP TABLE  `modules`;
RENAME TABLE  `news` TO  `s_blog` ;
RENAME TABLE  `orders` TO  `s_orders` ;
RENAME TABLE  `orders_products` TO  `s_purchases` ;
RENAME TABLE  `payment_methods` TO  `s_payment_methods` ;
RENAME TABLE  `products` TO  `s_products` ;
RENAME TABLE  `products_categories` TO  `s_products_categories` ;
RENAME TABLE  `products_comments` TO  `s_comments` ;
RENAME TABLE  `products_fotos` TO  `s_images` ;
RENAME TABLE  `products_variants` TO  `s_variants` ;
RENAME TABLE  `properties` TO  `s_features` ;
RENAME TABLE  `properties_categories` TO  `s_categories_features` ;
RENAME TABLE  `properties_values` TO  `s_options` ;
RENAME TABLE  `related_products` TO  `s_related_products` ;
RENAME TABLE  `sections` TO  `s_pages` ;
RENAME TABLE  `settings` TO  `s_settings` ;
RENAME TABLE  `users` TO  `s_users` ;

ALTER TABLE  `s_blog` CHANGE  `news_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_brands` CHANGE  `brand_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_categories` CHANGE  `category_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_categories_features` CHANGE  `property_id`  `feature_id` INT( 11 ) NOT NULL;
ALTER TABLE  `s_comments` CHANGE  `comment_id`  `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_currencies` CHANGE  `currency_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_delivery` CHANGE  `delivery_method_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_delivery_payment` CHANGE  `delivery_method_id`  `delivery_id` INT( 11 ) NOT NULL;
ALTER TABLE  `s_features` CHANGE  `property_id`  `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_feedbacks` CHANGE  `feedback_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_groups` CHANGE  `group_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_menu` CHANGE  `menu_id`  `id` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_orders` CHANGE  `order_id`  `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_pages` CHANGE  `section_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_payment_methods` CHANGE  `payment_method_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_products` CHANGE  `product_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `s_purchases` DROP PRIMARY KEY;
ALTER TABLE  `s_purchases` ADD  `id` INT NOT NULL FIRST ;
SET @pants := 0;
UPDATE `s_purchases` SET id = (SELECT @pants := @pants + 1);
ALTER TABLE  `s_purchases` ADD PRIMARY KEY (  `id` );
ALTER TABLE  `s_purchases` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;


ALTER TABLE  `s_users` CHANGE  `user_id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_variants` CHANGE  `variant_id`  `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `s_blog` CHANGE  `header`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `s_blog` CHANGE  `body`  `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `s_blog` DROP  `created`;
ALTER TABLE  `s_blog` DROP  `modified`;
ALTER TABLE  `s_blog` CHANGE  `enabled`  `visible` TINYINT( 1 ) NOT NULL DEFAULT  '0';
INSERT INTO s_blog (name, url, meta_title, meta_keywords, meta_description, annotation, text, visible, date) SELECT header, url, meta_title, meta_keywords, meta_description, annotation, body, enabled, modified FROM articles;
DROP TABLE  `articles`;
ALTER TABLE  `s_blog` CHANGE  `date`  `date` TIMESTAMP NOT NULL DEFAULT  '0000-00-00';

UPDATE s_products p, s_brands b, s_categories c SET p.model=CONCAT(c.single_name, ' ', b.name, ' ', p.model) WHERE p.category_id=c.id AND p.brand_id=b.id;

ALTER TABLE  `s_brands` ADD  `image` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE  `s_categories` CHANGE  `parent`  `parent_id` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_categories` DROP  `single_name`;
ALTER TABLE  `s_categories` ADD  `external_id` VARCHAR( 36 ) NOT NULL ;
ALTER TABLE  `s_categories` CHANGE  `order_num`  `position` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_categories` CHANGE  `enabled`  `visible` TINYINT( 1 ) NOT NULL DEFAULT  '1';

ALTER TABLE  `s_currencies` DROP  `main`;
ALTER TABLE  `s_currencies` DROP  `def`;
ALTER TABLE  `s_currencies` ADD  `cents` INT( 1 ) NOT NULL ,
ADD  `position` INT( 11 ) NOT NULL ,
ADD  `enabled` INT( 1 ) NOT NULL ;
UPDATE `s_currencies` SET position=id;
ALTER TABLE  `s_currencies` CHANGE  `rate_from`  `rate_from` FLOAT( 10, 2 ) NOT NULL DEFAULT  '1.000';
ALTER TABLE  `s_currencies` CHANGE  `rate_to`  `rate_to` FLOAT( 10, 2 ) NOT NULL DEFAULT  '1.000';
UPDATE `s_currencies` SET enabled=1, cents=2;
ALTER TABLE  `s_delivery` ADD  `position` INT NOT NULL ,
ADD  `separate_payment` INT( 1 ) NOT NULL ;

ALTER TABLE `s_features`
  DROP `in_product`,
  DROP `in_compare`,
  DROP `enabled`,
  DROP `options`;
ALTER TABLE  `s_features` CHANGE  `order_num`  `position` INT( 11 ) NOT NULL;

ALTER TABLE  `s_comments` CHANGE  `comment` `text` VARCHAR( 1024 ) NOT NULL;
ALTER TABLE  `s_comments` CHANGE  `product_id` `object_id` INT(11) NOT NULL;
ALTER TABLE  `s_comments` ADD `type` ENUM(  'product',  'blog' ) NOT NULL ,
ADD  `approved` INT( 1 ) NOT NULL ;
UPDATE `s_comments` SET approved=1, type='product';

ALTER TABLE  `s_images` DROP PRIMARY KEY;
ALTER TABLE  `s_images` ADD `id` INT NOT NULL FIRST ;
SET @pants := 0;
UPDATE `s_images` SET id = (SELECT @pants := @pants + 1);
ALTER TABLE  `s_images` ADD PRIMARY KEY (  `id` );
ALTER TABLE  `s_images` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `s_images` ADD  `name` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE  `s_images` DROP  `foto_id`;
ALTER TABLE  `s_images` ADD  `position` INT NOT NULL ;
UPDATE s_images set position=1;
INSERT INTO s_images (product_id, filename, position) SELECT id, large_image, 0 FROM s_products;

ALTER TABLE  `s_menu` CHANGE  `fixed`  `position` INT( 11 ) NULL DEFAULT  '0';
DELETE FROM `s_menu` WHERE `s_menu`.`id` = 3 LIMIT 1;
UPDATE  `s_menu` SET  `name` =  'Другие страницы', position=2 WHERE  `s_menu`.`id` =2 LIMIT 1 ;
UPDATE  `s_menu` SET  `name` =  'Основное меню', position=1 WHERE  `s_menu`.`id` =1 LIMIT 1 ;

UPDATE  `s_pages` SET  `url` =  '' WHERE  `s_pages`.`module_id` = 4 LIMIT 1 ;
UPDATE  `s_pages` SET  `url` =  'oplata' WHERE  `s_pages`.`url` = 'payment' LIMIT 1 ;
ALTER TABLE `s_pages`
  DROP `parent`,
  DROP `header`,
  DROP `module_id`,
  DROP `created`,
  DROP `modified`;
ALTER TABLE  `s_pages` CHANGE  `order_num`  `position` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_pages` CHANGE  `enabled`  `visible` TINYINT( 1 ) NOT NULL DEFAULT  '0';
UPDATE `s_pages` SET menu_id=999 WHERE menu_id=1;
UPDATE `s_pages` SET menu_id=1 WHERE menu_id=2;
UPDATE `s_pages` SET menu_id=2 WHERE menu_id=999;
DELETE FROM `s_pages` WHERE `menu_id` = 3;

ALTER TABLE  `s_options` CHANGE  `property_id`  `feature_id` INT( 11 ) NOT NULL;

ALTER TABLE  `s_orders` CHANGE  `delivery_method_id`  `delivery_id` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE  `s_orders` CHANGE  `payment_status`  `paid` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_orders` CHANGE  `written_off`  `closed` TINYINT( 1 ) NOT NULL;
ALTER TABLE  `s_orders` CHANGE  `code`  `url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE  `s_orders` ADD  `total_price` FLOAT( 10, 2 ) NOT NULL ,
ADD  `note` VARCHAR( 1024 ) NOT NULL ,
ADD  `discount` FLOAT( 5, 2 ) NOT NULL ,
ADD  `separate_delivery` TINYINT( 1 ) NOT NULL ,
ADD  `modified` TIMESTAMP NOT NULL ;

ALTER TABLE  `s_payment_methods` CHANGE  `params`  `settings` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `s_payment_methods` ADD  `position` INT NOT NULL ;
UPDATE `s_payment_methods` SET position=id;

ALTER TABLE  `s_products_categories` ADD  `position` INT NOT NULL ;
UPDATE `s_products_categories` SET position=1;

INSERT IGNORE INTO s_products_categories (product_id, category_id, position) SELECT id, category_id, 0 FROM s_products;
ALTER TABLE `s_products`
  DROP `category_id`,
  DROP `small_image`,
  DROP `large_image`,
  DROP `modified`;
ALTER TABLE  `s_products` CHANGE  `model`  `name` VARCHAR( 500 ) NOT NULL;
ALTER TABLE  `s_products` CHANGE  `description`  `annotation` TEXT NOT NULL;
ALTER TABLE  `s_products` CHANGE  `order_num`  `position` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_products` CHANGE  `enabled`  `visible` TINYINT( 1 ) NOT NULL DEFAULT  '1';

SELECT @email:=value FROM `s_settings` WHERE name='admin_email' LIMIT 1;
INSERT INTO  `s_settings` (
`name` ,
`value`
)
VALUES (
'units',  'шт.'),(
'date_format',  'd.m.Y'),(
'decimals_point',  ','),(
'thousands_separator',  ' '),(
'last_1c_orders_export_date',  '2011-07-30 21:31:56'),(
'max_order_amount',  '50'),(
'watermark_offset_x',  '50'),(
'watermark_offset_y',  '50'),(
'watermark_transparency',  '50'),(
'images_sharpen',  '0'),(
'order_email',  @email),(
'comment_email',  @email),(
'notify_from_email',  @email
);
ALTER TABLE  `s_variants` ADD  `compare_price` FLOAT( 14, 2 ) NOT NULL ,
ADD  `attachment` VARCHAR( 255 ) NOT NULL ,
ADD  `external_id` VARCHAR( 36 ) NOT NULL ;

ALTER TABLE  `s_related_products` ADD  `related_id` INT NOT NULL ;
UPDATE IGNORE s_related_products r, s_variants v1, s_variants v2 SET r.related_id=v2.product_id WHERE v1.product_id=r.product_id AND v2.sku=r.related_sku;
ALTER TABLE  `s_related_products` DROP PRIMARY KEY;
ALTER TABLE  `s_related_products` DROP  `related_sku`;
ALTER IGNORE TABLE `s_related_products` ADD PRIMARY KEY(`product_id`, `related_id`);
ALTER TABLE  `s_related_products` ADD  `position` INT NOT NULL ;

ALTER TABLE  `s_purchases` CHANGE  `quantity`  `amount` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `s_purchases` ADD  `sku` VARCHAR( 255 ) NOT NULL ;


ALTER TABLE  `s_brands` ADD INDEX (  `url` );
ALTER TABLE  `s_categories` ADD INDEX (  `external_id` );
ALTER TABLE  `s_features` ADD INDEX (  `position` );
ALTER TABLE  `s_features` ADD INDEX (  `in_filter` );
ALTER TABLE  `s_images` ADD INDEX (  `product_id` );
ALTER TABLE  `s_images` ADD INDEX (  `position` );
ALTER TABLE  `s_products_categories` ADD INDEX (  `position` );
ALTER TABLE  `s_products_categories` ADD INDEX (  `product_id` );
ALTER TABLE  `s_products_categories` ADD INDEX (  `category_id` );
ALTER TABLE  `s_purchases` ADD INDEX (  `order_id` );
ALTER TABLE  `s_purchases` ADD INDEX (  `product_id` );
ALTER TABLE  `s_purchases` ADD INDEX (  `variant_id` );
ALTER TABLE  `s_variants` ADD INDEX (  `product_id` );
ALTER TABLE  `s_variants` ADD INDEX (  `sku` );
ALTER TABLE  `s_variants` ADD INDEX (  `price` );
ALTER TABLE  `s_variants` ADD INDEX (  `stock` );
ALTER TABLE  `s_variants` ADD INDEX (  `position` );
ALTER TABLE  `s_variants` ADD INDEX (  `external_id` );
ALTER TABLE  `s_products` DROP  `download`;
ALTER TABLE  `s_products` ADD  `external_id` VARCHAR( 36 ) NOT NULL ;

UPDATE s_orders o SET o.total_price=IFNULL((SELECT SUM(p.price*p.amount)*(100-o.discount)/100 FROM s_purchases p WHERE p.order_id=o.id), 0)+o.delivery_price*(1-o.separate_delivery);
ALTER TABLE  `s_products` CHANGE  `hit`  `hit` TINYINT( 1 ) NULL DEFAULT  '0'