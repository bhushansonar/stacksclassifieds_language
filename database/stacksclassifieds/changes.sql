ALTER TABLE `posts` CHANGE `day` `auto_repost_day` INT(11) NOT NULL;
ALTER TABLE `posts` CHANGE `time` `auto_repost_no_of_time` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `posts` CHANGE `auto_repost` `auto_repost_price` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `posts` ADD `auto_repost_time` TIME NOT NULL AFTER `auto_repost_day`;
ALTER TABLE `posts` CHANGE `sponsor_ad` `featured_ad` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `posts` CHANGE `week` `featured_ad_week` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `posts` ADD `featured_ad_week_price` INT(11) NOT NULL AFTER `featured_ad_week`;
ALTER TABLE `posts` CHANGE `featured_ad_week_price` `featured_ad_week_price` VARCHAR(50) NOT NULL;

--20-3-2015--
ALTER TABLE `featured_price` CHANGE `price` `price` TEXT NOT NULL;
ALTER TABLE `featured_price` CHANGE `price` `featured_week_price` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;