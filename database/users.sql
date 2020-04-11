-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1,	'JaneDoe',	'$2y$10$/4d4IIvNPg76dL1ybJs86.98ebvghtbiBQXBY5xfXr7htnWjXwTvO',	'0000-00-00 00:00:00'),
(2,	'admin',	'$2y$10$0l0.u/HGwHPrcrPqvwmXruNLlDLgP0mTF0P20K4wf6EgeBWS5b5da',	'0000-00-00 00:00:00');

-- 2020-04-11 18:08:11
