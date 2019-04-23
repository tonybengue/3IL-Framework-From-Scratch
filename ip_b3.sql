-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `ip_b3`;
CREATE DATABASE `ip_b3` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ip_b3`;

DROP TABLE IF EXISTS `formulaire`;
CREATE TABLE `formulaire` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Les machines enregistrées';

INSERT INTO `formulaire` (`description`,`ip` ) VALUES
('PC-Patron', '192.168.1.15'),
('PC-Secretaire', '192.168.1.45'),
('PC-Stagiaire', '192.168.1.23'),
('iPhone Patrick', '192.168.1.62');
COMMIT;

-- 2019-03-03 15:11:14
