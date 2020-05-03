-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `pic` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `store` (`id`, `name`, `type`, `color`, `cost`, `quantity`, `pic`) VALUES
(1,	'Black T-Shirt', 'shirt', 'black', 15.00, 10, 'images/black-tshirt.jpg'),
(2,	'Black Hat', 'hat', 'black', 10.00,	10, 'images/black-hat.jpg'),
(3,	'Blue Jeans', 'pants', 'blue', 20.00, 5, 'images/blue-jeans.jpg');

-- 2020-04-30 16:11:30