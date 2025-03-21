CREATE DATABASE `facqukyl` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE facqukyl;

CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `deadline` date DEFAULT NULL,
  `status` enum('To do','In progress','Finished') DEFAULT NULL,
  `owner` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE `user` (
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

