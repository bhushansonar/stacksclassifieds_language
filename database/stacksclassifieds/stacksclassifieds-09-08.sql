-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2014 at 06:26 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stacksclassifieds`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `display_order` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `parent_id`, `path`, `display_order`, `status`) VALUES
(1, 'automotive ', 0, 'automotive ', '1', 'Active'),
(2, 'buy, sell, trade ', 0, 'buy, sell, trade ', '1', 'Active'),
(3, 'community', 0, 'community', '1', 'Active'),
(4, 'dating', 0, 'dating', '1', 'Active'),
(5, 'jobs ', 0, 'jobs ', '1', 'Active'),
(6, 'local places', 0, 'local places', '1', 'Active'),
(7, 'musician', 0, 'musician', '1', 'Active'),
(8, 'property for sale', 0, 'property for sale', '1', 'Active'),
(9, 'rentals', 0, 'rentals', '1', 'Active'),
(10, 'services ', 0, 'services ', '1', 'Active'),
(11, 'adult entertainment ', 0, 'adult entertainment ', '1', 'Active'),
(76, 'car parts', 1, 'automotive  > car parts', '1', 'Active'),
(77, 'computer/technical', 5, 'jobs  > computer/technical', '1', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_name`, `state_id`, `country_id`, `status`) VALUES
(1, 'Ahmedabad', 11, 2, 'Active'),
(2, 'Baroda', 11, 2, 'Active'),
(3, 'jaipur', 12, 2, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `ci_cookies`
--

CREATE TABLE IF NOT EXISTS `ci_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie_id` varchar(255) DEFAULT NULL,
  `netid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `orig_page_requested` varchar(120) DEFAULT NULL,
  `php_session_id` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ci_cookies`
--


-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('35a8ffe5ff670d49426bde1072aaeedb', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0', 1407561307, 'a:9:{s:9:"user_data";s:0:"";s:14:"posts_selected";N;s:22:"search_string_selected";N;s:5:"order";N;s:10:"order_type";N;s:12:"redirect_url";s:48:"http://localhost/stacksclassifieds/listing/index";s:8:"username";s:5:"admin";s:7:"user_id";s:1:"1";s:12:"is_logged_in";b:1;}'),
('380bd337c849c8ef25c9ad59d1a9b634', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0', 1407565459, 'a:8:{s:14:"posts_selected";N;s:22:"search_string_selected";N;s:5:"order";N;s:10:"order_type";N;s:12:"redirect_url";s:48:"http://localhost/stacksclassifieds/listing/index";s:8:"username";s:5:"admin";s:7:"user_id";s:1:"1";s:12:"is_logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `status`) VALUES
(2, 'India', 'Active'),
(3, 'srilanka', 'Active'),
(4, 'U.S.A', 'Active'),
(6, 'pakistan', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `multiple_city`
--

CREATE TABLE IF NOT EXISTS `multiple_city` (
  `multiple_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`multiple_city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `multiple_city`
--

INSERT INTO `multiple_city` (`multiple_city_id`, `week`, `total`, `city`) VALUES
(1, 3, 45, '5');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postcode` int(11) NOT NULL,
  `card_type` varchar(255) NOT NULL,
  `card_number` int(20) NOT NULL,
  `expiration_month` int(11) NOT NULL,
  `expiration_year` int(11) NOT NULL,
  `cvv_code` int(11) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `name`, `address`, `city`, `state`, `postcode`, `card_type`, `card_number`, `expiration_month`, `expiration_year`, `cvv_code`) VALUES
(1, 'ABC', 'ads', 'abc', 'abc', 444555, 'visa', 1234567890, 4, 2018, 5212);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `posts_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `subcategory` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `date` datetime NOT NULL,
  `selling_price` float NOT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` int(11) NOT NULL,
  `inquery` varchar(255) NOT NULL,
  `show_ad_links` varchar(255) NOT NULL,
  `show_joined_date` varchar(255) NOT NULL,
  `auto_repost_ad` varchar(255) NOT NULL,
  `day` int(11) NOT NULL,
  `time` varchar(255) NOT NULL,
  `auto_repost` varchar(255) NOT NULL,
  `sponsor_ad` varchar(255) NOT NULL,
  `week` varchar(255) NOT NULL,
  `promotions_sponsor_ad` varchar(255) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `work_status` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `bedrooms` varchar(255) NOT NULL,
  `ad_placed_by` varchar(255) NOT NULL,
  `fees_paid_by` varchar(255) NOT NULL,
  `pets` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `education` varchar(255) NOT NULL,
  PRIMARY KEY (`posts_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`posts_id`, `uid`, `country`, `state`, `city`, `category`, `subcategory`, `title`, `images`, `description`, `email`, `status`, `date`, `selling_price`, `location`, `address`, `postcode`, `inquery`, `show_ad_links`, `show_joined_date`, `auto_repost_ad`, `day`, `time`, `auto_repost`, `sponsor_ad`, `week`, `promotions_sponsor_ad`, `contact_number`, `work_status`, `shift`, `price`, `bedrooms`, `ad_placed_by`, `fees_paid_by`, `pets`, `age`, `salary`, `education`) VALUES
(2, 0, '2', '11', '1', 1, 76, 'Repair', 'Penguins49.jpg', '<p>my car is the best car. my car is the best car. my car is the best car.</p>\r\n', 'abc@abc.com', 'Active', '2014-08-02 12:09:21', 0, 'mayank', 'my car is the best car.', 654321, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '4', 0, '', '', 0, '', '', '', '', 0, 0, ''),
(22, 0, '2', '11', '1', 5, 77, 'Mehul', 'Lighthouse39.jpg', '<p>$parent$parent$parent$parent$parent$parent</p>\r\n', 'mnp@gmail.com', 'Active', '2014-08-04 09:42:29', 0, 'kadi', '$parent$parent', 382715, 'no', 'no', 'yes', 'yes', 12, '12', '12', 'Yes', '12', '12', 987456123, 'Full-time', 'Days', 0, '', '', '', '', 0, 5000, 'MScIT'),
(23, 0, '2', '11', '1', 5, 77, 'MSCIT', 'Penguins66.jpg', '<p><a href="http://localhost/phpmyadmin/sql.php?db=stacksclassifieds&amp;table=posts&amp;sql_query=SELECT+%2A+FROM+%60posts%60+ORDER+BY+%60posts%60.%60bedrooms%60+ASC&amp;token=b2d071ab08e9572b1ae990ce40a13f7c" title="Sort">bedroomsbedroomsbedroomsbedroomsbedroomsbedrooms</a></p>\r\n', 'abc@abc.com', 'Active', '2014-08-04 09:47:46', 0, 'Ahmedabad', 'bedrooms', 654321, 'no', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 987456123, 'Full-time', 'Days', 0, '', '', '', '', 0, 10000, 'All DATA'),
(24, 0, '2', '11', '1', 5, 77, 'I want job In IT company', 'Penguins67.jpg', '<p>$parent_id = $this-&gt;uri-&gt;segment(5);$parent_id = $this-&gt;uri-&gt;segment(5);$parent_id = $this-&gt;uri-&gt;segment(5);$parent_id = $this-&gt;uri-&gt;segment(5);</p>\r\n', 'abc@abc.com', 'Active', '2014-08-04 09:51:21', 0, 'mayanksalary', '$parent_id = $this->uri->segment(5);', 654321, 'no', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 987456123, 'Full-time', 'Days', 0, '', '', '', '', 0, 100, 'I want house ,'),
(25, 0, '2', '11', '1', 1, 76, 'MMMMMM', 'Desert16.jpg', '<p><a href="http://localhost/phpmyadmin/sql.php?db=stacksclassifieds&amp;table=posts&amp;sql_query=SELECT+%2A+FROM+%60posts%60+ORDER+BY+%60posts%60.%60shift%60+ASC&amp;token=b2d071ab08e9572b1ae990ce40a13f7c" title="Sort">shiftshiftshiftshiftshiftshift</a></p>\r\n', 'abc@abc.com', 'Active', '2014-08-04 10:00:14', 1000, 'kadi', 'shift', 382715, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 987456123, '', '', 0, '', '', '', '', 0, 0, ''),
(26, 0, '2', '11', '1', 5, 77, 'Multi images', 'Chrysanthemum16.jpg,Desert17.jpg,Hydrangeas33.jpg,Lighthouse40.jpg', '<h1>my car is the best car. my car is the best car. my car is the best car. my car is the best car. vmy car is the best car. my car is the best car. my car is the best car.my car is the best car. my car is the best car. my car is the best car. my car is the best car. vmy car is the best car. my car is the best car. my car is the best car.my car is the best car. my car is the best car. my car is the best car. my car is the best car. vmy car is the best car. my car is the best car. my car is the best car.</h1>\r\n', 'mnp@gmail.com', 'Active', '2014-08-04 11:45:00', 0, 'Ahmedabad', 'my car is the best car. my car is the best car. my car is the best car. my car is the best car. vmy car is the best car. my car is the best car. my car is the best car.', 654321, 'no', 'yes', 'yes', 'yes', 26, '13', '26', 'Yes', '26', '26', 987456123, 'Full-time,Part-time,Temp/Contract', 'Days,Nights,Weekends', 0, '', '', '', '', 0, 10000, 'CHECK ALL DATA'),
(27, 0, '2', '11', '76', 1, 76, 'ABC', 'Hydrangeas34.jpg', '<p>mehul@amutechnologies.commehul@amutechnologies.commehul@amutechnologies.com</p>\r\n', 'mehul@amutechnologies.com', 'Active', '2014-08-06 11:13:09', 0, '', 'mehul@amutechnologies.com', 444555, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 45525225, '', '', 0, '', '', '', '', 0, 0, ''),
(28, 0, '2', '11', '1', 1, 76, 'ABC', 'Hydrangeas35.jpg', '<p>vcsdvcsd</p>\r\n', 'mehul@amutechnologies.com', 'Active', '2014-08-06 11:39:27', 100, 'ccsc', 'vccvds', 444555, 'hide_email', 'yes', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 45525225, '', '', 0, '', '', '', '', 0, 0, ''),
(29, 0, '2', '11', '1', 1, 76, 'KKKKK', 'Koala29.jpg', '<p>sdfggrbvnnyn</p>\r\n', 'mehul@amutechnologies.com', 'Active', '2014-08-06 13:52:56', 11111, 'qqqqq', 'ergregr', 444555, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '26', 45525225, '', '', 0, '', '', '', '', 0, 0, ''),
(30, 0, '2', '11', '1', 1, 76, 'HKJKJKJK', 'Chrysanthemum18.jpg', '<p>HHHHHHHHHHHHHHH</p>\r\n', 'mehul@amutechnologies.com', 'Active', '2014-08-07 07:38:00', 0, '', 'HHHHHHHH', 444555, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 45525225, '', '', 0, '', '', '', '', 0, 0, ''),
(31, 0, '2', '11', '1', 1, 76, 'Sign In', 'Jellyfish15.jpg', '<p>choice_statechoice_statechoice_state</p>\r\n', 'mehul@amutechnologies.com', 'Active', '2014-08-07 15:03:02', 111111, 'asd', 'choice_state', 444555, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 45525225, '', '', 0, '', '', '', '', 0, 0, ''),
(32, 0, '2', '11', '1', 1, 76, 'ADMIN123', 'Penguins68.jpg', '<p>$data[&#39;recaptcha_html&#39;] = $this-&gt;recaptcha-&gt;recaptcha_get_html();$data[&#39;recaptcha_html&#39;] = $this-&gt;recaptcha-&gt;recaptcha_get_html();</p>\r\n', 'mehul@amutechnologies.com', 'Active', '0000-00-00 00:00:00', 0, '', '', 0, '', '', '', '', 0, '', '', '', '', '', 0, '', '', 0, '', '', '', '', 0, 0, ''),
(33, 1, '2', '11', '1', 1, 76, 'user id', 'Chrysanthemum19.jpg', '<p>$insertArr[&#39;category&#39;] = $_POST[&#39;category&#39;];$insertArr[&#39;category&#39;] = $_POST[&#39;category&#39;];</p>\r\n', 'mehulpatel8662@gmail.com', 'Active', '2014-08-08 11:59:32', 20, 'user', '$insertArr[''category''] = $_POST[''category''];', 555544, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 2147483647, '', '', 0, '', '', '', '', 0, 0, ''),
(34, 1, '2', '11', '1', 1, 76, 'Check Now', 'Penguins69.jpg', '<p>Check NowCheck NowCheck NowCheck Now</p>\r\n', 'mehulpatel8662@gmail.com', 'Active', '2014-08-08 12:42:35', 45554, 'user', 'Check NowCheck Now', 555544, 'hide_email', 'no', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '12', 2147483647, '', '', 0, '', '', '', '', 0, 0, ''),
(35, 2, '2', '11', '1', 1, 76, 'MAYANK DATa', 'Hydrangeas36.jpg', '<p>0192023a7bbd73250516f069df18b5000192023a7bbd73250516f069df18b500</p>\r\n', 'mehulpatel8662@gmail.com', 'Active', '2014-08-08 12:46:05', 20, '0192023a7bbd73250516f069df18b500', '0192023a7bbd73250516f069df18b500', 555544, 'hide_email', 'yes', 'yes', 'yes', 1, '0', '4', 'Yes', '1', '4', 2147483647, '', '', 0, '', '', '', '', 0, 0, ''),
(36, 1, '2', '11', '1', 1, 76, 'Select value', 'Jellyfish16.jpg', '<p>mehul@gmail.commehul@gmail.commehul@gmail.commehul@gmail.com</p>\r\n', 'mehul@gmail.com', 'Active', '2014-08-09 06:14:59', 1200, 'Abcd', 'mehul@gmail.com', 795854, 'hide_email', 'no', 'yes', 'yes', 12, '12', '12', 'Yes', '12', '12', 2147483647, '', '', 0, '', '', '', '', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `state_name`, `country_id`, `status`) VALUES
(2, 'Colombo', 3, 'Active'),
(5, 'America', 4, 'Active'),
(6, 'California', 4, 'Active'),
(7, 'Illinois', 4, 'Active'),
(8, 'Texas', 4, 'Active'),
(11, 'Gujarat', 2, 'Active'),
(12, 'rajstan', 2, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_membership` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `primary_email` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `type_of_membership`, `username`, `password`, `firstname`, `lastname`, `primary_email`, `status`) VALUES
(1, 'power_admin', 'admin', '0192023a7bbd73250516f069df18b500', 'Admin', 'Lastname', 'mail@mail.com', 'Active'),
(2, 'Admin', 'mayank', '0192023a7bbd73250516f069df18b500', 'mayank', 'mayank', 'mayank@gmail.com', 'Active');
