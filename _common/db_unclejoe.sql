-- phpMyAdmin SQL Dump
-- version 4.4.14.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 19, 2016 at 10:38 AM
-- Server version: 5.6.26-log
-- PHP Version: 5.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_unclejoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `cat1`
--

CREATE TABLE IF NOT EXISTS `cat1` (
  `id` int(10) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_tc` varchar(255) DEFAULT NULL,
  `img_en` varchar(255) DEFAULT NULL,
  `img_tc` varchar(255) DEFAULT NULL,
  `seq` int(11) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cat1`
--

INSERT INTO `cat1` (`id`, `title_en`, `title_tc`, `img_en`, `img_tc`, `seq`, `status`) VALUES
(1, 'Supermarket', '超級市場', NULL, NULL, 1, 1),
(2, 'Wine', '美酒佳餚', NULL, NULL, 2, 1),
(3, 'Beauty', '美容護膚', NULL, NULL, 3, 1),
(4, 'Gift', '節日禮籃', NULL, NULL, 4, 1),
(5, 'Must Buy', '全城優惠', NULL, NULL, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cat2`
--

CREATE TABLE IF NOT EXISTS `cat2` (
  `id` int(10) NOT NULL,
  `cat1` int(10) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_tc` varchar(255) DEFAULT NULL,
  `img_en` varchar(255) DEFAULT NULL,
  `img_tc` varchar(255) DEFAULT NULL,
  `seq` int(11) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cat2`
--

INSERT INTO `cat2` (`id`, `cat1`, `title_en`, `title_tc`, `img_en`, `img_tc`, `seq`, `status`) VALUES
(1, 1, 'Health', '保健產品', NULL, NULL, 1, 1),
(2, 1, 'Food', '食品', NULL, NULL, 2, 1),
(3, 2, 'Wine', '酒', NULL, NULL, 0, 1),
(4, 2, 'Food', '佳餚', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cat3`
--

CREATE TABLE IF NOT EXISTS `cat3` (
  `id` int(10) NOT NULL,
  `cat1` int(10) NOT NULL,
  `cat2` int(10) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_tc` varchar(255) DEFAULT NULL,
  `img_en` varchar(255) DEFAULT NULL,
  `img_tc` varchar(255) DEFAULT NULL,
  `seq` int(11) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cat3`
--

INSERT INTO `cat3` (`id`, `cat1`, `cat2`, `title_en`, `title_tc`, `img_en`, `img_tc`, `seq`, `status`) VALUES
(1, 1, 1, 'Hin Sang', '衍生成人保健系列', NULL, NULL, 1, 1),
(2, 1, 1, 'Hin Sang Childcare Supplement Series', '衍生小兒食品系列 ', NULL, NULL, 2, 1),
(3, 1, 2, 'Fruit', '水果', NULL, NULL, 1, 1),
(4, 1, 2, 'Vegetable', '蔬菜', NULL, NULL, 2, 1),
(5, 2, 3, 'Asia', '亞洲', NULL, NULL, 0, 1),
(6, 2, 3, 'Euro', '歐洲', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cat_product`
--

CREATE TABLE IF NOT EXISTS `cat_product` (
  `id` int(11) NOT NULL,
  `cat1` int(10) DEFAULT NULL,
  `cat2` int(10) DEFAULT NULL,
  `cat3` int(10) DEFAULT NULL,
  `plu` varchar(15) DEFAULT NULL,
  `seq` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cat_product`
--

INSERT INTO `cat_product` (`id`, `cat1`, `cat2`, `cat3`, `plu`, `seq`) VALUES
(2, 1, 1, 1, 'GIT-9002', 0),
(3, 1, 1, 1, '2028104', 0),
(4, 1, 1, 1, '2030520', 0),
(5, 1, 1, 1, '2025625', 2),
(6, 1, 1, 2, '02014742', 0),
(7, 1, 1, 2, '02014743', 0),
(8, 1, 1, 2, '12345', 0),
(9, 1, 2, 5, '010JPU596070002', 0),
(13, 1, 2, 2, '010JPT104320002', 0),
(14, 1, 2, 2, '010JPT104320003', 0),
(15, 1, 2, 2, '010JPT104320004', 0),
(16, 1, 2, 2, '010JPT104320005', 0),
(17, 1, 2, 2, '010KRU409860001', 0),
(22, 1, 2, 2, '010HKU466060008', 0),
(23, 1, 2, 2, '010HKU336060002', 0),
(24, 1, 2, 2, '010HKU466060009', 0),
(25, 1, 2, 2, '010HKU466060001', 0),
(27, 1, 2, 4, '2025622', 0),
(29, 1, 1, 2, '2028', 0),
(30, 1, 1, 1, '2025626', 0),
(32, 1, 2, 3, 'GIT-9001', 0),
(43, 1, 1, 1, 'GIT-9001', 0),
(44, 1, 1, 1, '201444', 0),
(45, 1, 1, 2, 'GIT-9002', 0),
(46, 1, 1, 1, '20289', 0),
(47, 1, 1, 1, 'HKC-16759', 0),
(48, 1, 1, 2, 'HKC-16700', 0),
(49, 1, 1, 1, 'HKC-16760', 0),
(50, 1, 1, 1, 'HKNT-16486', 0),
(51, 1, 1, 2, 'HKNT-16486', 0),
(52, 1, 1, 1, 'GIT-0001', 0),
(53, 1, 1, 1, 'GIT-0002', 0),
(54, 1, 1, 1, 'GIT-0003', 0),
(55, 2, 3, 5, '010JPU596070003', 0),
(56, 2, 3, 6, '010JPU596070004', 0),
(57, 1, 2, 4, '010JPT104320001', 0),
(58, 2, 3, 5, '010KRU409860002', 0),
(59, 1, 2, 4, '010KRU409850001', 0),
(60, 1, 2, 4, '010HKU466060002', 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(10) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_tc` varchar(255) NOT NULL,
  `detail_en` text,
  `detail_tc` text
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title_en`, `title_tc`, `detail_en`, `detail_tc`) VALUES
(1, 'About Us', '關於我們', '&lt;p&gt;\r\n	&lt;b&gt;About Us&lt;/b&gt;&lt;/p&gt;\r\n', '&lt;p&gt;\r\n	大昌優品是香港大昌行集團有限公司（港股代號01828）旗下的B2C電子商務平台。憑藉大昌行集團66年信譽，發揮傳統洋行的進口商管道優勢，打造合規合法、正品保障、優惠便捷、時尚優質的購物平台，向香港消費者提供優質的母嬰用品、化妝品，保健品，食品、電器、汽車相關產品及其他時尚流行高端產品。&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;\r\n	使命：&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;bull; 安全保證- 承諾商品安全，可放心的使用&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;bull; 精品正品- 精選優質高端正貨產品&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;bull; 66年信譽- 香港品牌，安全信心保證，值得信賴&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;bull; 憑藉大昌行於消費者業務的優勢，並與大昌行現有的業務產生協同效應&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;bull; 與世界知名品牌合作，迎合不同客戶的產品需求&lt;/p&gt;\r\n&lt;p&gt;\r\n	&amp;bull; 特色商品包括國際知名嬰幼兒奶粉/輔食品、化妝品，保健品、優質食品、電子消費品等&lt;/p&gt;'),
(2, 'Contact Us', '聯絡我們', '&lt;p&gt;\r\n	Contact US&lt;/p&gt;\r\n', '&lt;table border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot; class=&quot;basetext&quot; width=&quot;100%&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td colspan=&quot;2&quot; valign=&quot;top&quot;&gt;\r\n				顧客如有任何查詢或意見，歡迎聯絡我們的顧客服務部。&lt;br /&gt;\r\n				&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td valign=&quot;top&quot; width=&quot;80&quot;&gt;\r\n				電話:&lt;/td&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				2216 8068&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				傳真:&lt;/td&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				2419 9226&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				電子郵箱:&lt;/td&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				(一般查詢) cs@dchnu.com.hk&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				辦公時間:&lt;/td&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				&lt;p&gt;\r\n					星期一至五上午9時至下午1時，下午2時至5時30分&lt;br /&gt;\r\n					星期六上午9時至下午1時&lt;br /&gt;\r\n					公眾假期休息&lt;/p&gt;\r\n			&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				地址:&lt;/td&gt;\r\n			&lt;td valign=&quot;top&quot;&gt;\r\n				&lt;p&gt;\r\n					大昌食品市場總部&lt;br /&gt;\r\n					九龍九龍灣啟祥道大昌行集團大廈20號7樓&lt;/p&gt;\r\n			&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;br /&gt;'),
(3, 'Genuine Product', '正品保障', '/', '專業為您，信心保證﹗'),
(4, 'ENG海外直購', '海外直購', '/', '方便快捷的跨境購物體驗'),
(5, 'New User', '新手上路', '/', '新手上路'),
(6, 'Shopping Guide', '訂購細則', '/ Shopping Guide', '訂購細則'),
(7, 'FAQ', '常見問題', '/ FAQ', '常見問題'),
(8, 'Privacy', '私隱政策', '/ If there is any discrepancy between the Chinese and English versions, the English version shall prevail.', '若中英文版本有任何歧義，則以英文版本為準');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(10) NOT NULL,
  `code` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_tc` varchar(255) NOT NULL,
  `type` int(4) NOT NULL DEFAULT '1' COMMENT 'Total Amount/Item',
  `value` double DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `code`, `title_en`, `title_tc`, `type`, `value`, `date_start`, `date_end`, `status`) VALUES
(1, 'UNCLE-JOE_MEMBER', 'Member Discount', '會員優惠', 1, 0.9, '2016-08-01', '2016-08-31', 1),
(2, 'BIG_SALE', 'Big Sale', 'Big Sale', 1, 0.7, '2016-08-01', '2016-08-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `area_id` int(10) NOT NULL COMMENT 'id of system_vars',
  `charge` double NOT NULL,
  `special` int(4) NOT NULL DEFAULT '0',
  `seq` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `name`, `area`, `area_id`, `charge`, `special`, `seq`) VALUES
(1, '中西區', '香港島', 1, 300, 0, 1),
(2, '灣仔區', '香港島', 1, 300, 0, 2),
(3, '東區', '香港島', 1, 300, 0, 3),
(4, '南區', '香港島', 1, 300, 0, 4),
(5, '油尖旺區', '九龍', 2, 160, 0, 5),
(6, '深水埗區', '九龍', 2, 160, 0, 6),
(7, '九龍城區', '九龍', 2, 180, 0, 7),
(8, '黃大仙區', '九龍', 2, 170, 0, 8),
(9, '觀塘區', '九龍', 2, 180, 0, 9),
(10, '葵青區', '新界', 3, 150, 0, 10),
(11, '荃灣區', '新界', 3, 150, 0, 11),
(12, '屯門區', '新界', 3, 100, 0, 12),
(13, '元朗區', '新界', 3, 120, 0, 13),
(14, '北區', '新界', 3, 170, 0, 14),
(15, '大埔區', '新界', 3, 200, 0, 15),
(16, '沙田區', '新界', 3, 200, 0, 16),
(17, '西貢區', '新界', 3, 250, 0, 17),
(18, '離島區', '新界', 3, 230, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(10) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_tc` varchar(255) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `birthYear` int(11) DEFAULT NULL,
  `birthMonth` int(11) DEFAULT NULL,
  `accept_promotion` int(8) NOT NULL DEFAULT '0',
  `memberType` varchar(255) DEFAULT 'member',
  `date_join` date DEFAULT NULL,
  `webDollar` int(11) NOT NULL DEFAULT '0',
  `date_dollarExpire` date DEFAULT NULL,
  `date_lastOrder` date DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '1',
  `area` varchar(50) DEFAULT NULL COMMENT 'HK/KL/NT',
  `district` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL COMMENT 'Street/Estate',
  `building` varchar(255) DEFAULT NULL,
  `flat` varchar(255) DEFAULT NULL COMMENT 'Flat/Floor/Block'
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `name_en`, `name_tc`, `gender`, `tel`, `email`, `password_hash`, `birthYear`, `birthMonth`, `accept_promotion`, `memberType`, `date_join`, `webDollar`, `date_dollarExpire`, `date_lastOrder`, `status`, `area`, `district`, `street`, `building`, `flat`) VALUES
(1, 'Edwin EN', 'Edwin TC', 'M', '22222222', 'samex168@hotmail.com', 'f15116852c3a151f044a6198653428a7', 1990, 9, 1, 'admin', '2016-07-29', 400, '2016-08-31', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(2, 'UNCLE JOE EN', 'Uncle Joe TC', 'M', '22223333', 'test@test.com', 'd9b1d7db4cd6e70935368a1efb10e377', 1980, 2, 1, 'company', '2016-08-01', 500, '2017-08-31', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(30, 'Chan Tai Man', '陳大文', 'M', '21212121', 'chantaiman@test.com', 'e10adc3949ba59abbe56e057f20f883e', 1982, 4, 1, 'personal', '2016-08-01', 100, '2017-07-20', NULL, 1, 'HK', 'Wan Chai', 'EFG Street', 'ABC Building', 'Flat11, 13/F, Block A'),
(31, 'Chan Siu Ming', '陳小明', 'F', '30000000', 'chansiuming@test.com', 'c33367701511b4f6020ec61ded352059', 1980, 2, 1, 'company', '2016-01-22', 0, '2017-08-01', NULL, 0, 'KL', 'MongKok', 'HL Estate.', 'EFG Building', 'Flat12, 11/F'),
(32, 'Chan Siu Siu', '陳小小', 'F', '40000000', 'chansiusiu@test.com', '5418555ba6e409ded798d76fe7389594', 1990, 3, 0, 'staff', '2016-02-23', 0, '2017-08-01', NULL, 0, 'NT', 'Tai Po', 'AE Street.', 'LEE Building', 'Flat1213'),
(35, 'men', 'men', 'M', NULL, 'men@hotmail.com', 'd2fc17cc2feffa1de5217a3fd29e91e8', NULL, NULL, 1, 'member', '2016-08-12', 0, NULL, NULL, 1, NULL, '', '', '', ''),
(36, 'Peter', 'Peter', 'M', '', 'peter@hotmail.com', '51dc30ddc473d43a6011e9ebba6ca770', NULL, NULL, 0, 'member', '2016-08-12', 0, NULL, NULL, 1, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `member_update_history`
--

CREATE TABLE IF NOT EXISTS `member_update_history` (
  `id` int(20) NOT NULL,
  `member_id` int(10) NOT NULL,
  `update_field` varchar(255) NOT NULL,
  `old_value` varchar(255) NOT NULL,
  `new_value` varchar(255) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateBy` int(4) NOT NULL DEFAULT '0' COMMENT '0=member,1=admin'
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_update_history`
--

INSERT INTO `member_update_history` (`id`, `member_id`, `update_field`, `old_value`, `new_value`, `update_time`, `updateBy`) VALUES
(6, 1, 'webDollar', '500', '400', '2016-08-01 09:19:25', 1),
(7, 1, 'memberType', 'staff', 'admin', '2016-08-02 05:57:27', 1),
(8, 1, 'status', '1', '0', '2016-08-02 05:57:27', 1),
(9, 1, 'birthYear', '1992', '1990', '2016-08-03 02:24:17', 1),
(10, 1, 'accept_promotion', '1', 'on', '2016-08-03 02:24:17', 1),
(11, 1, 'status', '0', '1', '2016-08-03 02:24:17', 1),
(12, 1, 'birthYear', '1992', '1990', '2016-08-03 02:25:09', 1),
(13, 1, 'status', '0', '1', '2016-08-03 02:25:09', 1),
(14, 1, 'accept_promotion', '1', '0', '2016-08-03 02:38:49', 1),
(15, 1, 'name_en', 'Edwin', 'Edwin EN', '2016-08-04 01:14:03', 1),
(16, 1, 'name_tc', 'Edwin', 'Edwin TC', '2016-08-04 01:14:03', 1),
(17, 1, 'birthMonth', '10', '9', '2016-08-04 01:14:03', 1),
(18, 1, 'accept_promotion', '0', '1', '2016-08-04 01:14:03', 1),
(19, 2, 'name_en', 'UNCLE JOE', 'UNCLE JOE EN', '2016-08-04 01:14:50', 1),
(20, 2, 'name_tc', 'Uncle Joe', 'Uncle Joe TC', '2016-08-04 01:14:50', 1),
(21, 2, 'gender', 'F', 'M', '2016-08-04 01:14:50', 1),
(22, 2, 'tel', '23232323', '22223333', '2016-08-04 01:14:50', 1),
(23, 2, 'birthMonth', '1', '2', '2016-08-04 01:14:50', 1),
(24, 2, 'accept_promotion', '1', '0', '2016-08-04 01:14:50', 1),
(25, 2, 'webDollar', '200', '500', '2016-08-04 01:14:50', 1),
(26, 2, 'accept_promotion', '1', '0', '2016-08-04 01:19:05', 1),
(27, 2, 'accept_promotion', '1', '0', '2016-08-04 01:22:46', 1),
(28, 2, 'accept_promotion', '0', '1', '2016-08-04 01:23:21', 1),
(29, 30, 'tel', '20000000', '21212121', '2016-08-04 01:24:07', 1),
(30, 30, 'birthYear', '1980', '1982', '2016-08-04 01:24:07', 1),
(31, 30, 'birthMonth', '1', '4', '2016-08-04 01:24:07', 1),
(32, 30, 'webDollar', '0', '100', '2016-08-04 01:24:42', 1),
(33, 30, 'date_dollarExpire', '2017-08-01', '2017-07-20', '2016-08-04 01:24:42', 1),
(34, 1, 'email', 'samex168@hotmail.com', 'samex168@hotmail.co', '2016-08-12 02:58:09', 1),
(35, 1, 'email', 'samex168@hotmail.co', 'samex168@hotmail.com', '2016-08-12 02:58:16', 1),
(36, 36, 'accept_promotion', '1', '0', '2016-08-12 06:35:21', 1),
(37, 36, 'accept_promotion', '1', '0', '2016-08-12 06:36:14', 1),
(38, 36, 'birthYear', '', '1980', '2016-08-12 06:36:22', 1),
(39, 36, 'accept_promotion', '1', '0', '2016-08-12 06:36:22', 1),
(40, 36, 'birthYear', '1980', '', '2016-08-12 06:36:28', 1),
(41, 36, 'accept_promotion', '1', '0', '2016-08-12 06:36:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL,
  `orderNo` varchar(32) DEFAULT NULL,
  `memberId` int(10) NOT NULL,
  `addressee` varchar(255) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `coupon` varchar(255) DEFAULT NULL,
  `date_order` date DEFAULT NULL,
  `cartTotal` double NOT NULL,
  `deliveryCharge` double NOT NULL,
  `paymentMethod` int(8) NOT NULL COMMENT 'PayPal/Credit Card/Bank Transfer/Cash',
  `paymentStatus` int(8) NOT NULL COMMENT 'Waiting/Received/Fail/Void',
  `paymentRemark` text,
  `date_delivery` date DEFAULT NULL,
  `orderStatus` int(4) NOT NULL COMMENT 'New/Confirmed/Completed/Void',
  `area` varchar(50) DEFAULT NULL COMMENT 'HK/KL/NT',
  `district` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL COMMENT 'Street/Estate/Building',
  `building` varchar(255) DEFAULT NULL,
  `flat` varchar(255) DEFAULT NULL COMMENT 'Flat/Floor/Block'
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `orderNo`, `memberId`, `addressee`, `tel`, `coupon`, `date_order`, `cartTotal`, `deliveryCharge`, `paymentMethod`, `paymentStatus`, `paymentRemark`, `date_delivery`, `orderStatus`, `area`, `district`, `street`, `building`, `flat`) VALUES
(1, '201608081', 1, 'Edwin', '21212121', NULL, '2016-08-08', 113.8, 200, 2, 3, 'cmd=_notify-validate&mc_gross=40.00&invoice=20160816000016&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=GIT-9002&payer_id=UE56QTW6WDNSE&tax=0.00&address_street=71566176+Sky+E137+S&payment_date=19%3A26%3A47+Aug+15%2C+2016+PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=3.71&address_country_code=HK&address_name=User+Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz%40gmail.com&address_country=Hong+Kong&num_cart_items=1&mc_handling1=0.00&address_city=Posta&verify_sign=AWHwKBMoVXhTmv6W8P6KccBSLnxQAYPNMxtBv6ZW1NTLgTSBHDlxFSDa&payer_email=buyer_1296180666_per%40gmail.com&mc_shipping1=0.00&tax1=0.00&txn_id=3UX52586JM018281L&payment_type=instant&last_name=User&address_state=Libisia&item_name1=DerekMask%2F%E8%86%9C%E6%AE%BF+%E8%87%BA%E7%81%A3%E9%80%B2%E5%8F%A3+%E6%A5%B5%E8%87%B4%E4%BF%AE%E8%AD%B7%E9%9D%A2%E8%86%9C+30ml&receiver_email=seller_1296180842_biz%40gmail.com&payment_fee=&quantity1=1&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&mc_gross_1=40.00&mc_currency=HKD&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=b211b3d1f9f3', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(2, '201608101', 1, 'Recca Lee', '23456789', '', '2016-08-10', 100, 200, 2, 1, 'VERIFIED', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(3, '201608111', 1, 'Recca Lee', '23456789', '', '2016-08-11', 7198, 0, 2, 1, '', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(4, '201608112', 1, 'Recca Lee', '23456789', '', '2016-08-11', 1619.5, 200, 2, 1, '', NULL, 1, 'HK', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(5, '201608113', 1, 'Recca Lee', '23456789', '', '2016-08-11', 1619.5, 200, 2, 1, '', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(6, '201608114', 1, 'Recca Lee', '23456789', '', '2016-08-11', 1619.5, 200, 2, 1, '', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(7, '201608115', 1, 'Recca Lee', '23456789', 'UNCLE-JOE_MEMBER', '2016-08-11', 1619.5, 200, 2, 1, '', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(8, '201608116', 1, 'Edwin', '23456789', 'UNCLE-JOE_MEMBER', '2016-08-11', 359.8, 200, 2, 1, '', NULL, 1, 'KL', '新蒲崗', '景福街', '新時代工貿商業中心', '2907-2909'),
(9, '20160815000001', 1, 'Edwin', '22223333', '', '2016-08-15', 152.1, 200, 2, 1, '', NULL, 1, 'KL', 'Kwun Tong', '123', '456 building', '2907-2909'),
(10, '20160815000002', 1, 'Edwin TC', '22222222', '', '2016-08-15', 40, 200, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(11, '20160815000003', 1, 'Edwin TC', '22222222', '', '2016-08-15', 40, 200, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(12, '20160815000004', 1, 'Edwin TC', '22222222', '', '2016-08-15', 179.9, 200, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(13, '20160815000005', 1, 'Edwin TC', '22222222', '', '2016-08-15', 539.7, 200, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(14, '20160815000006', 1, 'Edwin TC', '22222222', '', '2016-08-15', 539.7, 0, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(15, '20160815000007', 1, 'Edwin TC', '22222222', '', '2016-08-15', 1079.4, 0, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(16, '20160815000008', 1, 'Edwin TC', '22222222', '', '2016-08-15', 179.9, 0, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(17, '20160815000009', 1, 'Edwin TC', '22222222', '', '2016-08-15', 359.8, 0, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(18, '20160815000010', 1, 'Edwin TC', '22222222', '', '2016-08-15', 179.9, 0, 2, 1, NULL, NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(21, '20160815000011', 1, 'Edwin TC', '22222222', '', '2016-08-15', 40, 0, 1, 1, '', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(22, '20160815000012', 1, 'Edwin TC', '22222222', '', '2016-08-15', 191.9, 0, 1, 1, '', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(23, '20160815000013', 1, 'Edwin TC', '22222222', '', '2016-08-15', 133, 0, 1, 1, '', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(24, '20160815000014', 1, 'Edwin TC', '22222222', '', '2016-08-15', 12, 0, 1, 1, '', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(25, '20160815000015', 1, 'Edwin TC', '22222222', '', '2016-08-15', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(26, '20160815000016', 1, 'Edwin TC', '22222222', '', '2016-08-15', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(27, '20160815000017', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 96.8, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(28, '20160815000018', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 179.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(29, '20160815000019', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(30, '20160815000020', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 12, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(31, '20160815000021', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 16.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(32, '20160815000022', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(33, '20160815000023', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 12, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(34, '20160815000024', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(35, '20160815000025', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(36, '20160815000026', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(37, '20160815000027', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(38, '20160815000028', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(39, '20160815000029', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(40, '20160815000030', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 12, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(41, '20160815000031', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(42, '20160815000032', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 12, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(43, '20160815000033', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(44, '20160815000034', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 12, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(45, '20160815000035', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(46, '20160815000036', 2, 'Uncle Joe TC', '22223333', '', '2016-08-15', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(47, '20160816000001', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(48, '20160816000002', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(49, '20160816000003', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(50, '20160816000004', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(51, '20160816000005', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(52, '20160816000006', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(53, '20160816000007', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(54, '20160816000008', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(55, '20160816000009', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 112.1, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(56, '20160816000010', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(57, '20160816000011', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(58, '20160816000012', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 20.9, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(59, '20160816000013', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(60, '20160816000014', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(61, '20160816000015', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 1, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(62, '20160816000016', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 40, 0, 1, 2, '', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(63, '20160816000017', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 179.9, 0, 1, 2, 'Array', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(64, '20160816000018', 2, 'Uncle Joe TC', '22223333', '', '2016-08-16', 20.9, 0, 1, 2, 'mc_gross=20.90&invoice=20160816000018&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=2030520&payer_id=UE56QTW6WDNSE&tax=0.00&address_street=71566176 Sky E137 S&payment_date=19:40:58 Aug 15, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=3.06&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=1&mc_handling1=0.00&address_city=Posta&verify_sign=AIkKNboJiyuxWLOHUlzTd3lpqCSxAbXqDj7uAl6uJe4kguqTPl9xbst3&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&tax1=0.00&txn_id=64C20711LM049794T&payment_type=instant&last_name=User&address_state=Libisia&item_name1=法國Bouton 意大利香醋 500毫升&receiver_email=seller_1296180842_biz@gmail.com&payment_fee=&quantity1=1&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&mc_gross_1=20.90&mc_currency=HKD&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=e8bc5faba4e4c&', NULL, 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(65, '20160816000019', 2, 'Uncle John', '22223333', '', '2016-08-16', 109.9, 0, 1, 2, 'mc_gross=109.90&invoice=20160816000019&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=GIT-9001&tax=0.00&item_number2=GIT-0001&payer_id=UE56QTW6WDNSE&address_street=71566176 Sky E137 S&payment_date=03:04:21 Aug 16, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=6.09&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=2&mc_handling1=0.00&mc_handling2=0.00&address_city=Posta&verify_sign=AoIlwP.cbXyRSnpgjFfIYtfb677IAR7n.ApwT2EnBUdu-hHPwlUV6GeR&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&mc_shipping2=0.00&tax1=0.00&tax2=0.00&txn_id=8Y555443YE2655019&payment_type=instant&last_name=User&address_state=Libisia&item_name1=DerekMask/膜殿 臺灣進口 極致修護面膜 30ml&receiver_email=seller_1296180842_biz@gmail.com&item_name2=淨白補水面膜升級版 - 10片裝&payment_fee=&quantity1=1&quantity2=1&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&mc_gross_1=40.00&mc_currency=HKD&mc_gross_2=69.90&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=19f77b1ce358&', '2016-08-20', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(66, '20160817000001', 2, 'Uncle Joe TC', '22223333', '', '2016-08-17', 179.9, 0, 1, 2, 'mc_gross=179.90&invoice=20160817000001&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=HKC-16759&payer_id=UE56QTW6WDNSE&tax=0.00&address_street=71566176 Sky E137 S&payment_date=23:01:25 Aug 16, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=8.47&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=1&mc_handling1=0.00&address_city=Posta&verify_sign=AoS.E.01W2nV8a9ir19jmW2JxA6YA6g8ht1EAj.y72TvguQfPt-TxUT0&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&tax1=0.00&txn_id=9LW446977F103231W&payment_type=instant&last_name=User&address_state=Libisia&item_name1=衍生至尊感冒止咳顆粒沖劑 (8包裝)&receiver_email=seller_1296180842_biz@gmail.com&payment_fee=&quantity1=1&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&mc_gross_1=179.90&mc_currency=HKD&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=5cb6bb3611687&', '2016-08-20', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(67, '20160817000002', 2, 'Uncle Joe TC', '22223333', '', '2016-08-17', 789.5, 0, 1, 1, '', '2016-08-20', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(68, '20160817000003', 2, 'Uncle Joe TC', '22223333', '', '2016-08-17', 789.5, 0, 1, 1, '', '2016-08-20', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(69, '20160817000004', 2, 'Uncle Joe TC', '22223333', '', '2016-08-17', 789.5, 0, 1, 2, 'mc_gross=789.50&invoice=20160817000004&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=HKC-16759&tax=0.00&item_number2=GIT-0001&payer_id=UE56QTW6WDNSE&address_street=71566176 Sky E137 S&payment_date=01:45:19 Aug 17, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=29.19&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=2&mc_handling1=0.00&mc_handling2=0.00&address_city=Posta&verify_sign=AFFIASYBPB4TY3B2VIHX1thDFvcyAewqtJDTH3CVVW92RmRCSX4ROcs5&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&mc_shipping2=0.00&tax1=0.00&tax2=0.00&txn_id=1VG39331TG060011A&payment_type=instant&last_name=User&address_state=Libisia&item_name1=衍生至尊感冒止咳顆粒沖劑 (8包裝)&receiver_email=seller_1296180842_biz@gmail.com&item_name2=淨白補水面膜升級版 - 10片裝&payment_fee=&quantity1=4&quantity2=1&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&mc_gross_1=719.60&mc_currency=HKD&mc_gross_2=69.90&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=edf7db8862866&', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(70, '20160817000005', 2, 'Uncle Joe TC', '22223333', '', '2016-08-17', 179.9, 0, 1, 1, '', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(71, '20160817000006', 2, 'Uncle Joe TC', '22223333', '', '2016-08-17', 459.5, 0, 1, 1, '', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(72, '20160817000007', 2, 'Uncle Joe TC', '22223333', 'UNCLE-JOE_MEMBER', '2016-08-17', 459.5, 0, 1, 1, '', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(73, '20160817000008', 2, 'Uncle Joe TC', '22223333', 'UNCLE-JOE_MEMBER', '2016-08-17', 319.7, 0, 1, 1, '', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(74, '20160817000009', 2, 'Uncle Joe TC', '22223333', 'UNCLE-JOE_MEMBER', '2016-08-17', 389.6, 0, 1, 1, '', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(75, '20160817000010', 2, 'Uncle Joe TC', '22223333', 'UNCLE-JOE_MEMBER', '2016-08-17', 319.7, 0, 1, 2, 'mc_gross=319.70&invoice=20160817000010&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=GIT-0001&tax=0.00&item_number2=GIT-0002&payer_id=UE56QTW6WDNSE&item_number3=HKC-16759&address_street=71566176 Sky E137 S&payment_date=02:40:11 Aug 17, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=13.22&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=3&mc_handling1=0.00&mc_handling2=0.00&mc_handling3=0.00&address_city=Posta&verify_sign=AtOpAqPwTlzzgNjrdPV86gzslEOGAuY3J9p4Pcxe7Av8hS0520VPbc43&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&mc_shipping2=0.00&mc_shipping3=0.00&tax1=0.00&tax2=0.00&tax3=0.00&txn_id=6S9189043W531042J&payment_type=instant&last_name=User&address_state=Libisia&item_name1=淨白補水面膜升級版 - 10片裝&receiver_email=seller_1296180842_biz@gmail.com&item_name2=膠原蛋白極致保濕面膜升級版 - 10片裝&payment_fee=&item_name3=衍生至尊感冒止咳顆粒沖劑 (8包裝)&quantity1=1&quantity2=1&receiver_id=ZDRR7Z44LM8J6&quantity3=1&txn_type=cart&mc_gross_1=69.90&mc_currency=HKD&mc_gross_2=69.90&mc_gross_3=179.90&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=9ca9d74b6bd31&', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(76, '20160817000011', 2, 'Uncle Joe TC', '22223333', 'UNCLE-JOE_MEMBER', '2016-08-17', 319.7, 0, 1, 2, 'invoice=20160817000011&first_name=Test&discount=31.97&mc_shipping=0.00&mc_currency=HKD&payer_status=verified&shipping_discount=0.00&payment_fee=&address_status=unconfirmed&payment_gross=&address_zip=W185744&txn_type=cart&num_cart_items=3&address_country_code=HK&mc_handling=0.00&verify_sign=AGu.hbwMxRXoqDiyy-IJNOnULnvNA8cjMD39.mDK6Cev4Qx-ginxgVX.&payer_id=UE56QTW6WDNSE&charset=UTF-8&tax1=0.00&receiver_id=ZDRR7Z44LM8J6&tax2=0.00&tax3=0.00&mc_handling1=0.00&mc_handling2=0.00&mc_handling3=0.00&item_name1=淨白補水面膜升級版 - 10片裝&tax=0.00&item_name2=膠原蛋白極致保濕面膜升級版 - 10片裝&item_name3=衍生至尊感冒止咳顆粒沖劑 (8包裝)&payment_type=instant&mc_shipping1=0.00&address_street=71566176 Sky E137 S&mc_shipping2=0.00&mc_shipping3=0.00&txn_id=01Y38413TB1895221&mc_gross_1=69.90&quantity1=1&mc_gross_2=69.90&quantity2=1&item_number1=GIT-0001&protection_eligibility=Eligible&mc_gross_3=179.90&quantity3=1&item_number2=GIT-0002&item_number3=HKC-16759&custom=&business=seller_1296180842_biz@gmail.com&residence_country=HK&last_name=User&address_state=Libisia&payer_email=buyer_1296180666_per@gmail.com&address_city=Posta&payment_status=Completed&payment_date=02:55:22 Aug 17, 2016 PDT&transaction_subject=&receiver_email=seller_1296180842_biz@gmail.com&mc_fee=12.13&notify_version=3.8&shipping_method=Default&address_country=Hong Kong&mc_gross=287.73&test_ipn=1&insurance_amount=0.00&address_name=User Test&ipn_track_id=d0164ab670c55&', '2016-08-21', 2, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(77, '20160817000012', 2, 'Uncle Joe TC', '22223333', 'UNCLE-JOE_MEMBER', '2016-08-17', 69.9, 0, 1, 2, 'mc_gross=62.91&invoice=20160817000012&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=GIT-0001&payer_id=UE56QTW6WDNSE&tax=0.00&address_street=71566176 Sky E137 S&payment_date=02:57:40 Aug 17, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=4.49&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=1&mc_handling1=0.00&address_city=Posta&verify_sign=AYh-XTRUJrmmCvvrw0pwKeXAiMWPAAkM2Mbdk71VLciHJRt5kNvmeWot&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&tax1=0.00&txn_id=70T01092BB9367323&payment_type=instant&last_name=User&address_state=Libisia&item_name1=淨白補水面膜升級版 - 10片裝&receiver_email=seller_1296180842_biz@gmail.com&payment_fee=&shipping_discount=0.00&quantity1=1&insurance_amount=0.00&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&discount=6.99&mc_gross_1=69.90&mc_currency=HKD&residence_country=HK&test_ipn=1&shipping_method=Default&transaction_subject=&payment_gross=&ipn_track_id=a5b29d186d1a5&', '2016-08-21', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(78, '20160818000001', 2, 'Uncle Joe TC', '22223333', '', '2016-08-18', 120, 0, 1, 2, 'mc_gross=120.00&invoice=20160818000001&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=010JPU596070003&tax=0.00&item_number2=010KRU409860002&payer_id=UE56QTW6WDNSE&address_street=71566176 Sky E137 S&payment_date=00:08:23 Aug 18, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=0.00&first_name=Test&mc_fee=6.43&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=2&mc_handling1=0.00&mc_handling2=0.00&address_city=Posta&verify_sign=AcjEjeWvy1L5n4RMecCTA0YBvJT7AmOwp5ygbqnEWkgCNyKmetkUzbYJ&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&mc_shipping2=0.00&tax1=0.00&tax2=0.00&txn_id=1K5531806U051605K&payment_type=instant&last_name=User&address_state=Libisia&item_name1=亞洲 美酒&receiver_email=seller_1296180842_biz@gmail.com&item_name2=DerekMask/膜殿 臺灣進口 極致修護面膜 30ml&payment_fee=&quantity1=2&quantity2=1&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&mc_gross_1=80.00&mc_currency=HKD&mc_gross_2=40.00&residence_country=HK&test_ipn=1&transaction_subject=&payment_gross=&ipn_track_id=586c0698c49a7&', '2016-08-22', 1, 'KL', 'Kwun Tong', '16-18 Hing Yip St', 'Mai Hing Industrial Building', 'Flat 08, 11/F, Block A'),
(79, '20160819000001', 1, 'Edwin TC', '22222222', 'UNCLE-JOE_MEMBER', '2016-08-19', 139.8, 100, 1, 2, 'mc_gross=225.82&invoice=20160819000001&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=GIT-0002&payer_id=UE56QTW6WDNSE&tax=0.00&address_street=71566176 Sky E137 S&payment_date=18:24:16 Aug 18, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=100.00&first_name=Test&mc_fee=10.03&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=1&mc_handling1=0.00&address_city=Posta&verify_sign=AKz814L5uZdMu1qbf3JZ5YDtX1ikAK6nCYV7X7dpXfqEGSOcul7lyzji&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&tax1=0.00&txn_id=1PP84449HE257774H&payment_type=instant&last_name=User&address_state=Libisia&item_name1=膠原蛋白極致保濕面膜升級版 - 10片裝&receiver_email=seller_1296180842_biz@gmail.com&payment_fee=&shipping_discount=0.00&quantity1=2&insurance_amount=0.00&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&discount=13.98&mc_gross_1=139.80&mc_currency=HKD&residence_country=HK&test_ipn=1&shipping_method=Default&transaction_subject=&payment_gross=&ipn_track_id=cd0f6b6ec2e57&', '2016-08-22', 1, 'KL', 'San Po Kong', '704 Prince Edward Road East', 'New Trend Centre', 'Flat 2907-2909, 29/F'),
(80, '20160819000002', 37, 'edwin', '22223333', 'uncle-joe_member', '2016-08-19', 176, 100, 1, 2, 'mc_gross=258.40&invoice=20160819000002&protection_eligibility=Eligible&address_status=unconfirmed&item_number1=HKC-16760&payer_id=UE56QTW6WDNSE&tax=0.00&address_street=71566176 Sky E137 S&payment_date=18:49:04 Aug 18, 2016 PDT&payment_status=Completed&charset=UTF-8&address_zip=W185744&mc_shipping=0.00&mc_handling=100.00&first_name=Test&mc_fee=11.14&address_country_code=HK&address_name=User Test&notify_version=3.8&custom=&payer_status=verified&business=seller_1296180842_biz@gmail.com&address_country=Hong Kong&num_cart_items=1&mc_handling1=0.00&address_city=Posta&verify_sign=Ay2Kg75sHj4jZ3j7sKo.WsyFVg.aApAXoMlwYSyjw4MCFrEqzI4gcSw2&payer_email=buyer_1296180666_per@gmail.com&mc_shipping1=0.00&tax1=0.00&txn_id=1LM46018BC111870T&payment_type=instant&last_name=User&address_state=Libisia&item_name1=衍生熱必清涼茶顆粒沖劑 (20包裝)&receiver_email=seller_1296180842_biz@gmail.com&payment_fee=&shipping_discount=0.00&quantity1=2&insurance_amount=0.00&receiver_id=ZDRR7Z44LM8J6&txn_type=cart&discount=17.60&mc_gross_1=176.00&mc_currency=HKD&residence_country=HK&test_ipn=1&shipping_method=Default&transaction_subject=&payment_gross=&ipn_track_id=1fddb34d28c7e&', '2016-08-22', 4, 'KL', 'hk', 'street', 'building', 'flat');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(11) NOT NULL,
  `orderNo` varchar(32) DEFAULT NULL,
  `plu` varchar(15) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `orderNo`, `plu`, `qty`) VALUES
(1, '201608081', 'GIT-9001', 2),
(2, '201608081', '201444', 2),
(12, '201608101', 'GIT-9001', 2),
(13, '201608101', '201444', 3),
(14, '201608111', 'HKC-16759', 20),
(15, '201608111', 'HKC-16700', 30),
(16, '201608112', 'HKC-16759', 5),
(17, '201608112', 'HKC-16700', 6),
(18, '201608113', 'HKC-16759', 5),
(19, '201608113', 'HKC-16700', 6),
(20, '201608114', 'HKC-16759', 5),
(21, '201608114', 'HKC-16700', 6),
(22, '201608115', 'HKC-16759', 5),
(23, '201608115', 'HKC-16700', 6),
(25, '201608116', 'HKC-16759', 2),
(26, '201608151', 'GIT-9002', 1),
(27, '201608151', '2028104', 1),
(28, '201608152', 'GIT-9002', 1),
(29, '201608153', 'GIT-9002', 1),
(30, '201608154', 'HKC-16759', 1),
(31, '201608155', 'HKC-16759', 3),
(32, '201608156', 'HKC-16759', 3),
(33, '201608157', 'HKC-16759', 6),
(34, '201608158', 'HKC-16759', 1),
(35, '201608159', 'HKC-16759', 2),
(36, '2016081510', 'HKC-16759', 1),
(37, '2016081510', 'HKC-16759', 1),
(38, '2016081510', 'GIT-9002', 1),
(39, '20160815000011', 'GIT-9002', 1),
(40, '20160815000012', 'HKC-16759', 1),
(41, '20160815000012', '2025626', 1),
(42, '20160815000013', '2028104', 1),
(43, '20160815000013', '2030520', 1),
(44, '20160815000014', '2025626', 1),
(45, '20160815000015', '2028104', 1),
(46, '20160815000016', '2025625', 1),
(47, '20160815000017', '12345', 1),
(48, '20160815000017', '02014743', 1),
(49, '20160815000017', '2030520', 1),
(50, '20160815000018', 'HKC-16759', 1),
(51, '20160815000019', '2030520', 1),
(52, '20160815000020', '2025626', 1),
(53, '20160815000021', '201444', 1),
(54, '20160815000022', '2025625', 1),
(55, '20160815000023', '2025626', 1),
(56, '20160815000024', 'GIT-9001', 1),
(57, '20160815000025', '2030520', 1),
(58, '20160815000026', '2028104', 1),
(59, '20160815000027', 'GIT-9001', 1),
(60, '20160815000028', 'GIT-9001', 1),
(61, '20160815000029', 'GIT-9001', 1),
(62, '20160815000030', '2025626', 1),
(63, '20160815000031', '2030520', 1),
(64, '20160815000032', '2025626', 1),
(65, '20160815000033', '2028104', 1),
(66, '20160815000034', '2025626', 1),
(67, '20160815000035', '2028104', 1),
(68, '20160815000036', '2028104', 1),
(69, '20160816000001', 'GIT-9002', 1),
(70, '20160816000002', 'GIT-9001', 1),
(71, '20160816000003', '2030520', 1),
(72, '20160816000004', '2028104', 1),
(73, '20160816000005', '2030520', 1),
(74, '20160816000006', 'GIT-9001', 1),
(75, '20160816000007', '2028104', 1),
(76, '20160816000008', 'GIT-9001', 1),
(77, '20160816000009', '2028104', 1),
(78, '20160816000010', '2030520', 1),
(79, '20160816000011', '2030520', 1),
(80, '20160816000012', '2030520', 1),
(81, '20160816000013', 'GIT-9002', 1),
(82, '20160816000014', 'GIT-9002', 1),
(83, '20160816000015', 'GIT-9002', 1),
(84, '20160816000016', 'GIT-9002', 1),
(85, '20160816000017', 'HKC-16759', 1),
(86, '20160816000018', '2030520', 1),
(87, '20160816000019', 'GIT-9001', 1),
(88, '20160816000019', 'GIT-0001', 1),
(89, '20160817000001', 'HKC-16759', 1),
(90, '20160817000002', 'HKC-16759', 4),
(91, '20160817000002', 'GIT-0001', 1),
(92, '20160817000003', 'HKC-16759', 4),
(93, '20160817000003', 'GIT-0001', 1),
(94, '20160817000004', 'HKC-16759', 4),
(95, '20160817000004', 'GIT-0001', 1),
(96, '20160817000005', 'HKC-16759', 1),
(97, '20160817000006', 'GIT-0001', 2),
(98, '20160817000006', 'GIT-0002', 2),
(99, '20160817000006', 'HKC-16759', 1),
(100, '20160817000007', 'GIT-0001', 2),
(101, '20160817000007', 'GIT-0002', 2),
(102, '20160817000007', 'HKC-16759', 1),
(103, '20160817000008', 'GIT-0001', 1),
(104, '20160817000008', 'GIT-0002', 1),
(105, '20160817000008', 'HKC-16759', 1),
(106, '20160817000009', 'GIT-0001', 2),
(107, '20160817000009', 'GIT-0002', 1),
(108, '20160817000009', 'HKC-16759', 1),
(109, '20160817000010', 'GIT-0001', 1),
(110, '20160817000010', 'GIT-0002', 1),
(111, '20160817000010', 'HKC-16759', 1),
(112, '20160817000011', 'GIT-0001', 1),
(113, '20160817000011', 'GIT-0002', 1),
(114, '20160817000011', 'HKC-16759', 1),
(115, '20160817000012', 'GIT-0001', 1),
(116, '20160818000001', '010JPU596070003', 2),
(117, '20160818000001', '010KRU409860002', 1),
(118, '20160819000001', 'GIT-0002', 2),
(119, '20160819000002', 'HKC-16760', 2);

-- --------------------------------------------------------

--
-- Table structure for table `page_banner`
--

CREATE TABLE IF NOT EXISTS `page_banner` (
  `id` int(10) NOT NULL,
  `cat1ID` int(10) NOT NULL,
  `img_en` varchar(255) DEFAULT NULL,
  `img_tc` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page_banner`
--

INSERT INTO `page_banner` (`id`, `cat1ID`, `img_en`, `img_tc`, `status`) VALUES
(1, 1, 'banner_supermarket.jpg', 'banner_supermarket.jpg', 1),
(2, 2, 'banner_wine.jpg', 'banner_wine.jpg', 1),
(3, 3, 'banner_beauty.jpg', 'banner_beauty.jpg', 1),
(4, 4, 'banner_gift.jpg', 'banner_gift.jpg', 1),
(5, 5, 'banner_mustbuy.jpg', 'banner_mustbuy.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) NOT NULL,
  `plu` varchar(15) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_tc` varchar(255) DEFAULT NULL,
  `country_en` varchar(255) DEFAULT NULL,
  `country_tc` varchar(255) DEFAULT NULL,
  `brand_en` varchar(255) DEFAULT NULL,
  `brand_tc` varchar(255) DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `des_en` text,
  `des_tc` text,
  `price` double DEFAULT NULL,
  `unit_en` varchar(10) DEFAULT NULL,
  `unit_tc` varchar(10) DEFAULT NULL,
  `remark_en` text,
  `remark_tc` text,
  `webDollarBase` int(11) NOT NULL DEFAULT '0',
  `webDollarMulti` int(11) NOT NULL DEFAULT '0',
  `webDollarAmt` int(11) NOT NULL DEFAULT '0',
  `date_wdValidFrom` date DEFAULT NULL,
  `date_wdValidTo` date DEFAULT NULL,
  `hit_product` int(4) NOT NULL DEFAULT '0',
  `new_product` int(4) NOT NULL DEFAULT '0',
  `img_s` varchar(255) DEFAULT NULL,
  `img_m` varchar(255) DEFAULT NULL,
  `img_l` varchar(255) DEFAULT NULL,
  `weightproduct` int(11) NOT NULL DEFAULT '0',
  `cost` double DEFAULT '0',
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `plu`, `name_en`, `name_tc`, `country_en`, `country_tc`, `brand_en`, `brand_tc`, `vendor`, `des_en`, `des_tc`, `price`, `unit_en`, `unit_tc`, `remark_en`, `remark_tc`, `webDollarBase`, `webDollarMulti`, `webDollarAmt`, `date_wdValidFrom`, `date_wdValidTo`, `hit_product`, `new_product`, `img_s`, `img_m`, `img_l`, `weightproduct`, `cost`, `status`) VALUES
(1, 'GIT-9001', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'TAIWAN', '臺灣', 'DerekMask', '膜殿', 'GIT-DEREK', '&lt;p&gt;ENGLISH 品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效&lt;/p&gt;\r\n', '&lt;p&gt;品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。 保質期 3年 儲存方法 常溫 包裝 16.00cm(長) X 3.00cm(寬) X 19.00cm(高) 面膜功效 修護 面膜系列 都會儷影系列&lt;/p&gt;\r\n', 40, 'pc', '件', '', '', 15, 1, 10, '2015-01-05', '2015-01-06', 1, 0, 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 0, 0, 1),
(2, 'GIT-9002', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'TAIWAN', '臺灣', 'DerekMask', '膜殿', 'GIT-DEREK', '&lt;p&gt;ENGLISH 品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。 保質期 3年 儲存方法 常溫 包裝 16.00cm(長) X 3.00cm(寬) X 19.00cm(高) 面膜功效 修護 面膜系列 都會儷影系列&lt;/p&gt;\r\n', '&lt;p&gt;&amp;nbsp;品牌 膜殿/Maskingdom 規格 30ml&lt;br /&gt;\r\n原產地 臺灣&lt;br /&gt;\r\n成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。&lt;br /&gt;\r\n保質期 3年&lt;br /&gt;\r\n儲存方法 常溫&lt;/p&gt;\r\n\r\n&lt;p&gt;儲存方法 常溫&lt;/p&gt;\r\n\r\n&lt;p&gt;儲存方法 常溫儲存方法 常溫&lt;/p&gt;\r\n\r\n&lt;p&gt;儲存方法 常溫&lt;/p&gt;\r\n', 40, 'pc', '件', '', '', 0, 1, 0, '2015-01-05', '2015-01-06', 0, 0, 'TW_H02_730_0079.jpg', 'TW_H02_730_0080.jpg', 'TW_H02_730_0080.jpg', 0, 0, 1),
(3, '2028104', 'MYANMAR WILD CAUGHT SEA TIGER SHRIMP 12PC (500G)', '緬甸野生海虎蝦12隻(500克)', 'MYANMAR', '緬甸', 'DCH', 'DCH', 'FM', '&lt;p&gt;very good&lt;/p&gt;\r\n', '&lt;p&gt;新鮮捕撈後急凍處理，蝦肉鮮嫩彈牙，野生捕捉，爽口多膏。&lt;/p&gt;\r\n', 112.1, 'BOX', '盒', '', '', 0, 1, 0, '2016-07-24', '2016-07-24', 0, 0, 's_848826046031.jpg', 's_848826046031.jpg', 's_848826046031.jpg', 0, 0, 1),
(4, '2030520', 'Bouton d&amp;#039;Or Balsamic vinegar of Modena 500ml', '法國Bouton 意大利香醋 500毫升', 'FRANCE', '法國', 'Bouton d&amp;#039;Or', 'Bouton d&amp;#039;Or', 'FM', '&lt;p&gt;des en&lt;/p&gt;', '&lt;p&gt;意大利香醋的口感酸甜，不僅可做沙律汁，還可用來做醋飲、雪糕。&lt;/p&gt;', 20.9, 'BTL', '樽', '', '', 0, 1, 0, '2016-07-25', '2016-07-25', 0, 0, 's_848826046031.jpg', 's_848826046031.jpg', 's_848826046031.jpg', 0, 0, 1),
(7, '2025625', 'IVORIA HAZELNUT CHOCOLATE PASTE 400G', '法國IVORIA 朱古力榛子醬 400克', 'FRANCE', '法國', 'IVORIA', 'IVORIA', 'FM', '&lt;p&gt;des&amp;nbsp;en&lt;/p&gt;\r\n', '&lt;p&gt;法國原裝入口, 塗抹在麵包上即可食用!&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n', 20.9, 'BTL', '樽', '', '', 0, 1, 0, '2016-07-25', '2016-07-25', 0, 0, '010FRH019780001.jpg', '010FRH029790001.jpg', '010FRH039700001.jpg', 0, 0, 0),
(19, '02014742', 'SUNRAYSIA PRUNE JUICE 250ML', '光之果西梅汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '&lt;p&gt;- Made from 1% prune juice - Naturally ull of antioxidants that fight free radicals - Naturally high in dietary fibre which may assist with digestive health&lt;/p&gt;\r\n', '&lt;p&gt;- 100%西梅汁&lt;/p&gt;\r\n', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-01', '2015-01-01', 0, 0, 's_02014742.jpg', '02014742.jpg', '02014742.jpg', 0, 0, 1),
(20, '02014743', 'SUNRAYSIA CRANBERRY DRINK 250ML', '光之果紅苺汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '- Around 83 cranberries juice into every 25ml bottle\n- Contains 37kJ per 1ml\n- No bitter aftertaste\n- Naturally rich in antioxidants and may help to prevent bladder and urinary tract infections\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;&lt;img src=&quot;/files/product/02014743d.jpg&quot; /&gt;&lt;/p&gt;', '- 每一瓶250毫升便含有約83顆紅莓\n- 每100毫升只有37kJ\n- 沒有苦澀味\n- 含有豐富抗氧化物\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;&lt;img src=&quot;/files/product/02014743d.jpg&quot; /&gt;&lt;/p&gt;', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-01', '2015-01-01', 0, 0, '02014743.jpg', '02014743.jpg', '02014743.jpg', 0, 0, 1),
(21, '12345', '美國頂級肉眼牛扒(PRIME GRADE)', '美國頂級肉眼牛扒(PRIME GRADE)', 'US', 'US', 'US', 'US', 'US', '&lt;p&gt;US&lt;/p&gt;\r\n', '&lt;p&gt;US&lt;/p&gt;\r\n', 60, 'pc', '件', '', '', 20, 1, 10, '2015-06-30', '2015-01-06', 0, 0, 's_010FRH069910001.jpg', 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 0, 0, 1),
(22, '010JPU596070002', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'TAIWAN', '臺灣', 'DerekMask', '膜殿', 'GIT-DEREK', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://demo.freecomm.com/dch_nu/php/files/brand_promotion/3.jpg&quot; style=&quot;width: 295px; height: 445px;&quot; /&gt;ENGLISH 品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效&lt;/p&gt;', '&lt;p&gt;品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。 保質期 3年 儲存方法 常溫 包裝 16.00cm(長) X 3.00cm(寬) X 19.00cm(高) 面膜功效 修護 面膜系列 都會儷影系列&lt;/p&gt;', 40, 'pc', '件', '', '', 20, 1, 10, '2015-01-05', '2015-01-06', 1, 0, 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 0, 0, 1),
(23, '010JPU596070003', '亞洲 美酒', '亞洲 美酒', 'TAIWAN', '臺灣', 'DerekMask', '膜殿', 'GIT-DEREK', '&lt;p&gt;ENGLISH 品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。 保質期 3年 儲存方法 常溫 包裝 16.00cm(長) X 3.00cm(寬) X 19.00cm(高) 面膜功效 修護 面膜系列 都會儷影系列&amp;lt;&lt;/p&gt;\r\n', '&lt;p&gt;&amp;nbsp;&lt;br /&gt;\r\n品牌 膜殿/Maskingdom 規格 30ml&lt;br /&gt;\r\n原產地 臺灣&lt;br /&gt;\r\n成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。&lt;br /&gt;\r\n保質期 3年&lt;br /&gt;\r\n儲存方法 常溫&lt;/p&gt;\r\n', 40, 'pc', '件', '', '', 0, 1, 0, '2015-01-05', '2015-01-06', 0, 0, 's_02010430.jpg', 'm_02029999.JPG', 'l_02029999.JPG', 0, 0, 1),
(24, '010JPU596070004', '歐洲 酒-', '歐洲 酒-', 'MYANMAR', '緬甸', 'DCH', 'DCH', 'FM', '&lt;p&gt;very good&lt;/p&gt;\r\n', '&lt;p&gt;新鮮捕撈後急凍處理，蝦肉鮮嫩彈牙，野生捕捉，爽口多膏。&lt;/p&gt;\r\n', 112.1, 'BOX', '盒', '', '', 0, 1, 0, '2016-07-24', '2016-07-24', 0, 0, 's_02010598.jpg', 'm_02010598.jpg', 'l_02010598.jpg', 0, 0, 1),
(25, '010JPT104320001', 'Bouton d&amp;#039;Or Balsamic vinegar of Modena 500ml', '法國Bouton d&amp;#039;Or 意大利香醋 500毫升', 'FRANCE', '法國', 'Bouton d&amp;#039;Or', 'Bouton d&amp;#039;Or', 'FM', '&lt;p&gt;des en&lt;/p&gt;\r\n', '&lt;p&gt;意大利香醋的口感酸甜，不僅可做沙律汁，還可用來做醋飲、雪糕。&lt;/p&gt;\r\n', 20.9, 'BTL', '樽', '', '', 0, 1, 0, '2016-07-25', '2016-07-25', 0, 0, 's_02011143.jpg', 'm_02001226.jpg', 'l_02020077.jpg', 0, 0, 1),
(26, '010JPT104320002', 'IVORIA HAZELNUT CHOCOLATE PASTE 400G', '法國IVORIA 朱古力榛子醬 400克', 'FRANCE', '法國', 'IVORIA', 'IVORIA', 'FM', '&lt;p&gt;des&amp;nbsp;en&lt;/p&gt;', '&lt;p&gt;法國原裝入口, 塗抹在麵包上即可食用!&lt;/p&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 20.9, 'BTL', '樽', '', '', 0, 1, 0, '2016-07-25', '2016-07-25', 0, 0, '010FRH019780001.jpg', '010FRH029790001.jpg', '010FRH039700001.jpg', 0, 0, 0),
(27, '010JPT104320003', 'SUNRAYSIA PRUNE JUICE 250ML', '光之果西梅汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '&lt;p&gt;- Made from 1% prune juice - Naturally ull of antioxidants that fight free radicals - Naturally high in dietary fibre which may assist with digestive health&lt;/p&gt;\r\n', '&lt;p&gt;- 100%西梅汁&lt;/p&gt;\r\n', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-01', '2015-01-01', 0, 0, 's_02014742.jpg', 'm_02014742.jpg', 'l_02028321.jpg', 0, 0, 1),
(28, '010JPT104320004', 'SUNRAYSIA CRANBERRY DRINK 250ML', '光之果紅苺汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '- Around 83 cranberries juice into every 25ml bottle\n- Contains 37kJ per 1ml\n- No bitter aftertaste\n- Naturally rich in antioxidants and may help to prevent bladder and urinary tract infections\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;&lt;img src=&quot;/files/product/02014743d.jpg&quot; /&gt;&lt;/p&gt;', '- 每一瓶250毫升便含有約83顆紅莓\n- 每100毫升只有37kJ\n- 沒有苦澀味\n- 含有豐富抗氧化物\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;&lt;img src=&quot;/files/product/02014743d.jpg&quot; /&gt;&lt;/p&gt;', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-01', '2015-01-01', 0, 0, '02014743.jpg', '02014743.jpg', '02014743.jpg', 0, 0, 1),
(29, '010JPT104320005', '美國頂級肉眼牛扒(PRIME GRADE)', '美國頂級肉眼牛扒(PRIME GRADE)', 'US', 'US', 'US', 'US', 'US', 'US', 'US', 60, 'pc', '件', '', '', 20, 1, 10, '2015-06-30', '2015-01-06', 0, 0, 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 0, 0, 1),
(30, '010KRU409860001', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'TAIWAN', '臺灣', 'DerekMask', '膜殿', 'GIT-DEREK', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://demo.freecomm.com/dch_nu/php/files/brand_promotion/3.jpg&quot; style=&quot;width: 295px; height: 445px;&quot; /&gt;ENGLISH 品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效&lt;/p&gt;', '&lt;p&gt;品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。 保質期 3年 儲存方法 常溫 包裝 16.00cm(長) X 3.00cm(寬) X 19.00cm(高) 面膜功效 修護 面膜系列 都會儷影系列&lt;/p&gt;', 40, 'pc', '件', '', '', 20, 1, 10, '2015-01-05', '2015-01-06', 0, 0, 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 0, 0, 1),
(31, '010KRU409860002', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'DerekMask/膜殿 臺灣進口 極致修護面膜 30ml', 'TAIWAN', '臺灣', 'DerekMask', '膜殿', 'GIT-DEREK', '&lt;p&gt;ENGLISH 品牌 膜殿/Maskingdom 規格 30ml 原產地 臺灣 成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。 保質期 3年 儲存方法 常溫 包裝 16.00cm(長) X 3.00cm(寬) X 19.00cm(高) 面膜功效 修護 面膜系列 都會儷影系列&amp;lt;&lt;/p&gt;\r\n', '&lt;p&gt;&amp;nbsp;&lt;br /&gt;\r\n品牌 膜殿/Maskingdom 規格 30ml&lt;br /&gt;\r\n原產地 臺灣&lt;br /&gt;\r\n成份 極致修護面膜-添加蝸牛修護萃取液，含豐富複合活性物可協助肌膚表面修護、調節溫度及維持水份功效，同步添加由穀類所提煉水性神經醯胺及水性甘草精，能防止水分蒸發，使肌膚維持柔軟平滑，更具彈性及張力，同時強化肌膚防禦環境污染防護力，減少肌膚過敏與乾燥的狀況。&lt;br /&gt;\r\n保質期 3年&lt;br /&gt;\r\n儲存方法 常溫&lt;/p&gt;\r\n', 40, 'pc', '件', '', '', 0, 1, 0, '2015-01-05', '2015-01-06', 0, 0, 's_02024277.jpg', 'm_02024277.jpg', 'l_02024277.jpg', 0, 0, 1),
(32, '010KRU409850001', 'MYANMAR WILD CAUGHT SEA TIGER SHRIMP 12PC (500G)', '緬甸野生海虎蝦12隻(500克)', 'MYANMAR', '緬甸', 'DCH', 'DCH', 'FM', '&lt;p&gt;very good&lt;/p&gt;\r\n', '&lt;p&gt;新鮮捕撈後急凍處理，蝦肉鮮嫩彈牙，野生捕捉，爽口多膏。&lt;/p&gt;\r\n', 112.1, 'BOX', '盒', '', '', 0, 1, 0, '2016-07-24', '2016-07-24', 0, 0, 's_02025915.jpg', 'm_02025915.jpg', 'l_02025915.jpg', 0, 0, 1),
(33, '010HKU466060002', 'Bouton d&amp;#039;Or Balsamic vinegar of Modena 500ml', '法國Bouton d&amp;#039;Or 意大利香醋 500毫升', 'FRANCE', '法國', 'Bouton d&amp;#039;Or', 'Bouton d&amp;#039;Or', 'FM', '&lt;p&gt;des en&lt;/p&gt;\r\n', '&lt;p&gt;意大利香醋的口感酸甜，不僅可做沙律汁，還可用來做醋飲、雪糕。&lt;/p&gt;\r\n', 20.9, 'BTL', '樽', '', '', 0, 1, 0, '2016-07-25', '2016-07-25', 0, 0, 's_010DKU466050001.jpg', 'm_010DKU466050001.jpg', 'l_010DKU466050001.jpg', 0, 0, 1),
(34, '010HKU466060008', 'IVORIA HAZELNUT CHOCOLATE PASTE 400G', '法國IVORIA 朱古力榛子醬 400克', 'FRANCE', '法國', 'IVORIA', 'IVORIA', 'FM', '&lt;p&gt;des&amp;nbsp;en&lt;/p&gt;', '&lt;p&gt;法國原裝入口, 塗抹在麵包上即可食用!&lt;/p&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 20.9, 'BTL', '樽', '', '', 0, 1, 0, '2016-07-25', '2016-07-25', 1, 0, '010FRH019780001.jpg', '010FRH029790001.jpg', '010FRH039700001.jpg', 0, 0, 0),
(35, '010HKU336060002', 'SUNRAYSIA PRUNE JUICE 250ML', '光之果西梅汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '&lt;p&gt;- Made from 1% prune juice - Naturally ull of antioxidants that fight free radicals - Naturally high in dietary fibre which may assist with digestive health&lt;/p&gt;\r\n', '&lt;p&gt;- 100%西梅汁&lt;/p&gt;\r\n', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-01', '2015-01-01', 0, 0, 's_02006398.jpg', 'm_02025174.jpg', 'l_02006398.jpg', 0, 0, 1),
(36, '010HKU466060009', 'SUNRAYSIA CRANBERRY DRINK 250ML', '光之果紅苺汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '- Around 83 cranberries juice into every 25ml bottle\n- Contains 37kJ per 1ml\n- No bitter aftertaste\n- Naturally rich in antioxidants and may help to prevent bladder and urinary tract infections\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;&lt;img src=&quot;/files/product/02014743d.jpg&quot; /&gt;&lt;/p&gt;', '- 每一瓶250毫升便含有約83顆紅莓\n- 每100毫升只有37kJ\n- 沒有苦澀味\n- 含有豐富抗氧化物\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;&lt;img src=&quot;/files/product/02014743d.jpg&quot; /&gt;&lt;/p&gt;', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-01', '2015-01-01', 0, 0, '02014743.jpg', '02014743.jpg', '02014743.jpg', 0, 0, 1),
(37, '010HKU466060001', '美國頂級肉眼牛扒(PRIME GRADE)', '美國頂級肉眼牛扒(PRIME GRADE)', 'US', 'US', 'US', 'US', 'US', 'US', 'US', 60, 'pc', '件', '', '', 20, 1, 10, '2015-06-30', '2015-01-06', 1, 0, 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 'TW_H02_730_0079.jpg', 0, 0, 1),
(39, '2025626', 'name_en', 'name_tc', 'FRANCE', '法國', 'test', 'test', 'test', '&lt;p&gt;test&lt;/p&gt;\r\n', '&lt;p&gt;test&lt;/p&gt;\r\n', 12, 'BTL', '樽', '', '', 0, 1, 0, '2016-08-01', NULL, 0, 0, '010FRH069910001.jpg', '010FRH069910001.jpg', '010FRH069910001.jpg', 0, 0, 1),
(40, '2025622', 'test2', 'test2', 'FRANCE', '法國', 'test', 'test', 'test', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test&lt;/p&gt;', 12, 'BTL', '樽', '', '', 0, 1, 0, '2016-08-01', '2016-01-31', 0, 0, '010FRH069910001.jpg', '010FRH069910001.jpg', '010FRH069910001.jpg', 0, 0, 1),
(41, '2028', 'test', 'test', '', '', '', '', '', '', '', 12, '', '', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_02014742.jpg', NULL, NULL, 0, 0, 1),
(42, '201466', 'SUNRAYSIA PRUNE JUICE 250ML', '光之果西梅汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '&lt;p&gt;- Made from 1% prune juice - Naturally ull of antioxidants that fight free radicals - Naturally high in dietary fibre which may assist with digestive health&lt;/p&gt;\r\n', '&lt;p&gt;- 100%西梅汁&lt;/p&gt;\r\n', 15.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-01-30', '2015-01-31', 0, 0, 's_010FRH089780001.jpg', 'm_010FRH089780001.jpg', 'l_010FRH089780001.jpg', 0, 0, 1),
(43, '201444', 'SUNRAYSIA CRANBERRY DRINK 250ML', '光之果紅苺汁250毫升', 'AUSTRALIA', 'AUSTRALIA', 'SUNRAYSIA', '光之果', 'FM', '&lt;p&gt;- Around 83 cranberries juice into every 25ml bottle - Contains 37kJ per 1ml - No bitter aftertaste - Naturally rich in antioxidants and may help to prevent bladder and urinary tract infections&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;\r\n', '&lt;p&gt;- 每一瓶250毫升便含有約83顆紅莓 - 每100毫升只有37kJ - 沒有苦澀味 - 含有豐富抗氧化物&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;\r\n', 16.9, 'BTL', '樽', '', '', 0, 1, 0, '2015-02-13', '2015-02-28', 0, 0, '02014743.jpg', '02014743.jpg', '02014743.jpg', 0, 0, 1),
(45, '20289', 'test123', 'test123', '', '', '', '', '', '', '', 13, 'BTL', '樽', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_848826046031.jpg', 's_848826046031.jpg', 's_848826046031.jpg', 0, 0, 1),
(46, 'HKC-16759', 'Hin Sang Supreme Cough &amp; Cold Remedy Granules (8 packs)', '衍生至尊感冒止咳顆粒沖劑 (8包裝)', '', '', 'Hin Sang', '衍生', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Contains Forsythiae Fructus, Scutellariae Radix, Armeniacae Semen Amarum, Platycodonis Radix, Menthol. Applicable for cold due to exogenous wind-heat, with symptoms such as fever with aversion to wind, headache and nasal congestion, sore and swollen throat, cough and body discomfort. Clears heat and resolves the exterior, reduces and stop cough. This product is convenient, easy to carry and store.&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Direction and dosage:&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Dissolves with water. 1 pack each time, 3 times a day.&lt;/span&gt;&lt;/p&gt;\r\n', '&lt;p style=&quot;font-family: arial, simsun; font-size: 12.8px; line-height: 21.76px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;strong&gt;產品特點：&lt;/strong&gt;&lt;br /&gt;\r\n清熱解表，化痰止咳，由連翹、黃芩、苦杏仁、桔梗、薄荷腦等成份精製而成，用於外感風熱所致的感冒，症見發熱惡風、頭痛鼻塞、咽喉腫痛、咳嗽、周身不適。清熱解表，化痰止咳。產品獨立包裝即沖即飲，方便攜帶及儲存。&lt;/p&gt;\r\n\r\n&lt;p style=&quot;font-family: arial, simsun; font-size: 12.8px; line-height: 21.76px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;strong&gt;用法及份量：&lt;/strong&gt;&lt;br /&gt;\r\n用適量溫開水開調飲用。一日3次，每次1包。&lt;/p&gt;\r\n', 179.9, 'BOX', '盒', '500g', '500克', 0, 1, 0, NULL, NULL, 1, 0, 'temp_001.jpg', 'temp_001b.jpg', 'temp_001b.jpg', 0, 0, 1),
(47, 'HKC-16700', 'Hin Sang Health Star Granules (20 packs)', '衍生精裝七星茶顆粒沖劑 (20包裝)', '', '', 'Hin Sang', '衍生', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Functions:&amp;nbsp;&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Relieves inner gas, purifies and intoxicates the body&amp;nbsp;&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Direction and dosage:&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Newborn to 1 year old:Once daily, one pack each time.&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;2 to 5 years old:Twice daily, two packs each time.&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;5 years old or above :One to two daily, three packs each time.&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Dissolve each pack with a glass of warm water.&lt;/span&gt;&lt;/p&gt;\r\n', '', 120, 'BOX', '盒', '', '', 0, 1, 0, NULL, NULL, 1, 0, 's_848826046031.jpg', 'l_848826046031.jpg', 'l_848826046031.jpg', 0, 0, 1),
(48, 'HKC-16760', 'Hin Sang Multi-Herbs Tea Granules (20 packs)', '衍生熱必清涼茶顆粒沖劑 (20包裝)', '', '', '', '', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Contains Radix Et Caulis Ilicis Asprellae, Radix Rosae Laevigatae, Herba Lyhodii, Herba Viticis Negundo. Applicable to common cold, fever, sore throat, dampness and heat, dry throat, and dark urine. Clears heat and protects against summer heat, quenches thirst. This product is convenient, easy to carry and store.&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Direction and dosage:&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Dissolves with water. 1 bag each time, 1-2 times a day.&lt;/span&gt;&lt;/p&gt;\r\n', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;&amp;lt;清熱解暑 去濕生津&amp;gt;&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;由崗梅、金櫻根、金沙藤、五指柑等成份精製而成，用於小兒四時感冒，發燒喉痛，濕熱積滯等。清熱解暑，去濕生津。產品獨立包裝即沖即飲，方便攜帶及儲存。&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;用法及份量 :&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;用適量溫開水沖調飲用。一日1-2次，每次1包。&lt;/span&gt;&lt;/p&gt;\r\n', 88, 'BOX', '盒', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_976088256207.jpg', 'm_976088256207.jpg', 'l_976088256207.jpg', 0, 0, 1),
(49, 'HKNT-16486', 'Hin Sang Healthy Joints Strain Relief Medicated Oil (50ml)', '衍生骨骼健活絡油 (50ml)', '', '', '', '', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Contains Mentholum, Camphor, Oleum Caryophylli, soothes tendons and joints, expels wing and relieves bruises; applicable to rheumatic pains, pains of tendons and bones, stinging pains in spine, previous trauma, swollen sores, skin itchiness, mosquito and insect bites, motion sickness, dizziness and stomachache.&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;div&gt;&amp;nbsp;&lt;/div&gt;\r\n', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;&amp;lt;舒筋活絡 袪風散瘀&amp;gt;&lt;/span&gt;&lt;br style=&quot;background-color: rgb(241, 233, 214);&quot; /&gt;\r\n&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;以薄荷腦、樟腦、丁香油等成份精製而成，用於筋骨疼痛，腰骨刺痛，趺打舊患，小瘡腫痛，皮膚癢痕，蚊叮蟲咬，舟車暈浪，頭暈肚痛等。&lt;/span&gt;&lt;/p&gt;\r\n', 29.9, 'BOX', '盒', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_634052025627.jpg', 'm_634052025627.jpg', 'l_634052025627.jpg', 0, 0, 1),
(50, 'GIT-0001', 'Purifying And Hydrating Mask Level Up - 10pcs', '淨白補水面膜升級版 - 10片裝', '', '', '', '', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Hydrolyzed Pearl contains marine micro-elements and can help to cool off and calm the skin, reduce wrinkles and pump up the moisture level. It nourishes skin cells from deep within to greatly improve skin conditions.&lt;/span&gt;&lt;/p&gt;\r\n', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;配合水解珍珠的多種海洋微量元素，不但能緊膚去皺、淨白肌膚、加強皮膚細胞的水分，其海洋成分更深入滲透皮膚，使活性成分充分發揮功效，讓肌膚得以深層護理。&lt;/span&gt;&lt;/p&gt;\r\n', 69.9, 'BOX', '盒', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_8797542318110.jpg', 'm_8797542318110.jpg', 'l_8797542318110.jpg', 0, 0, 1),
(51, 'GIT-0002', 'Hydro Power Collagen Mask Level Up - 10pcs', '膠原蛋白極致保濕面膜升級版 - 10片裝', '', '', '', '', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Double Hyaluronic Acid in upgraded verison can form a layer of moisturizing film on the skin surface, the strong water retention from outside to inside, which can enhance skin elasticity more and moisturizing the skin deeply. The added 2 times more than the soluble Collagen can also provide long lasting moisture effect and keep the skin elastic.&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;div&gt;&amp;nbsp;&lt;/div&gt;\r\n', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;能深入滲透肌膚底層，迅速回復彈性及滋潤，是肌膚最佳的營養補充劑；而蘆薈及藍藻等均含有保濕成分，令肌膚最短時間內補充足夠水分；洋甘菊具有嫩白肌膚、緊緻毛孔之功效，使肌膚更晶瑩亮麗。&lt;/span&gt;&lt;/p&gt;\r\n', 69.9, 'BOX', '盒', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_8798119821342.jpg', 'm_8798119821342.jpg', 'l_8798119821342.jpg', 0, 0, 1),
(52, 'GIT-0003', 'Anti-Blemish Repairing Mask Level Up 10pcs', '控豆修護面膜升級版 10片裝', '', '', '', '', '', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;Aloe provides natural moisture-locking factor to keep the skin supple and delicate in all environments, and is ideal for acne-prone skin. Cucumis Sativus (Cucumber) Fruit Extract helps to regulate the water and oil level of the skin to prevent appearance of blemishes.&lt;/span&gt;&lt;/p&gt;\r\n', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(241, 233, 214);&quot;&gt;蘆薈含天然鎖水因子，讓肌膚在任何乾燥缺水的時候都能滋潤亮澤，並具修護功效，特別適合荳荳膚質。並加入小黃瓜萃取，同時調節皮膚的水分與油分，令肌膚保持在平衡狀態，預防荳荳產生。&lt;/span&gt;&lt;/p&gt;\r\n', 69.9, 'BOX', '盒', '', '', 0, 1, 0, NULL, NULL, 0, 0, 's_8799432441886.jpg', 'm_8799432441886.jpg', 'l_8799432441886.jpg', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(10) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_tc` varchar(255) DEFAULT NULL,
  `img_en` varchar(255) DEFAULT NULL,
  `img_tc` varchar(255) DEFAULT NULL,
  `link_en` varchar(255) DEFAULT NULL,
  `link_tc` varchar(255) DEFAULT NULL,
  `target` varchar(15) NOT NULL DEFAULT '_blank',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `seq` int(8) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slide`
--

INSERT INTO `slide` (`id`, `title_en`, `title_tc`, `img_en`, `img_tc`, `link_en`, `link_tc`, `target`, `date_start`, `date_end`, `seq`, `status`) VALUES
(1, 'banner1', 'banner1', 'banner_001.jpg', 'banner_001.jpg', 'www.google.com', 'www.google.com', '_blank', '2016-07-01', '2017-06-30', 1, 1),
(2, 'banner2', 'banner2', 'banner_002.jpg', 'banner_002.jpg', '', '', '_blank', '2016-08-01', '2017-03-31', 2, 1),
(3, 'banner3', 'banner3', 'banner_003.jpg', 'banner_003.jpg', '', '', '_blank', '2016-08-01', '2017-05-31', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_vars`
--

CREATE TABLE IF NOT EXISTS `system_vars` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_vars`
--

INSERT INTO `system_vars` (`id`, `name`, `type`, `value`, `description`) VALUES
(1, 'HK', 'no_delivery_charge', '99999999', 'No delivery charge for HK Islands'),
(2, 'KL', 'no_delivery_charge', '99999999', 'No delivery charge for Kowloon'),
(3, 'NT', 'no_delivery_charge', '99999999', 'No delivery charge for NT'),
(4, 'HK', 'delivery_charge', '0', 'Delivery Charge for HK Island'),
(5, 'KL', 'delivery_charge', '0', 'Delivery Charge for Kowloon'),
(6, 'NT', 'delivery_charge', '0', 'Delivery Charge for NT'),
(7, 'Paypal', 'payment_type', '1', 'Paypal'),
(8, 'Credit_Card', 'payment_type', '2', 'Credit Card'),
(9, 'Bank_Transfer', 'payment_type', '3', 'Bank Transfer'),
(10, 'Cash', 'payment_type', '4', 'Cash'),
(11, 'Waiting', 'payment_status', '1', 'Waiting Payment'),
(12, 'Received', 'payment_status', '2', 'Payment Received'),
(13, 'Fail', 'payment_status', '3', 'Payment Fail'),
(14, 'Void', 'payment_status', '4', 'Payment Void'),
(15, 'New', 'order_status', '1', 'New Order'),
(16, 'Confirmed', 'order_status', '2', 'Order Confirmed'),
(17, 'Completed', 'order_status', '3', 'Order Completed'),
(18, 'Void', 'order_status', '4', 'Void');

-- --------------------------------------------------------

--
-- Table structure for table `top10`
--

CREATE TABLE IF NOT EXISTS `top10` (
  `id` int(11) NOT NULL,
  `plu` varchar(15) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `seq` int(8) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `top10`
--

INSERT INTO `top10` (`id`, `plu`, `date_start`, `date_end`, `seq`, `status`) VALUES
(1, '2025625', '2016-08-01', '2016-08-31', 5, 1),
(2, 'GIT-9001', '2016-08-01', '2016-11-30', 2, 1),
(5, '2028104', '2016-08-01', '2016-08-31', 4, 1),
(6, '201444', '2016-08-01', '2016-08-31', 3, 1),
(7, 'HKC-16759', '2016-08-01', '2016-12-31', 1, 1),
(8, 'HKC-16759', '2016-08-01', '2016-12-31', 6, 1),
(9, 'HKC-16759', '2016-08-01', '2016-12-31', 7, 1),
(10, 'HKC-16759', '2016-08-01', '2016-12-31', 8, 1),
(11, 'HKC-16700', '2016-08-01', '2016-12-31', 9, 1),
(12, 'HKC-16700', '2016-08-01', '2016-12-31', 10, 1),
(13, '20289', '2016-08-01', '2016-08-15', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `status`) VALUES
(1, 'admin', 'Ao_IbmSKd5LpdisAO7zVVEEcDuHAfoVm', 'f15116852c3a151f044a6198653428a7', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat1`
--
ALTER TABLE `cat1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat2`
--
ALTER TABLE `cat2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat3`
--
ALTER TABLE `cat3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat_product`
--
ALTER TABLE `cat_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_update_history`
--
ALTER TABLE `member_update_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_banner`
--
ALTER TABLE `page_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plu` (`plu`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_vars`
--
ALTER TABLE `system_vars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top10`
--
ALTER TABLE `top10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat1`
--
ALTER TABLE `cat1`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cat2`
--
ALTER TABLE `cat2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cat3`
--
ALTER TABLE `cat3`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cat_product`
--
ALTER TABLE `cat_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `member_update_history`
--
ALTER TABLE `member_update_history`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT for table `page_banner`
--
ALTER TABLE `page_banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `system_vars`
--
ALTER TABLE `system_vars`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `top10`
--
ALTER TABLE `top10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
