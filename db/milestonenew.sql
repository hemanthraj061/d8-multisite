DROP TABLE `appmilestone`;

delimiter $$

CREATE TABLE `appmilestone` (
  `appmilestonepk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'appmilestonepk',
  `datetime` datetime DEFAULT NULL,
  `milestonedesc` varchar(255) NOT NULL COMMENT 'milestonedesc',
  `file` varchar(255) DEFAULT NULL COMMENT 'filename',
  `url` varchar(255) DEFAULT NULL COMMENT 'uri',
  `filemime` varchar(255) DEFAULT NULL COMMENT 'filemime',
  `bopk` varchar(45) DEFAULT NULL COMMENT 'bopk',
  `botype` varchar(64) DEFAULT NULL COMMENT 'botype',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appmilestonepk`),
  UNIQUE KEY `milestonedesc` (`milestonedesc`,`appmilestonepk`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1$$

