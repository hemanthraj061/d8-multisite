DROP TABLE IF EXISTS appattachment;
DROP TABLE IF EXISTS appmilestone;

CREATE TABLE `appattachment` (
  `appattachmentpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'appattachmentpk',
  `fid` int(11) NOT NULL COMMENT 'fid',
  `uid` int(11) NOT NULL COMMENT 'slno',
  `filename` varchar(255) NOT NULL COMMENT 'filename',
  `uri` varchar(255) COMMENT 'uri',
  `filemime` varchar(255) COMMENT 'filemime',
  `module` varchar(64) COMMENT 'module',
  `type` varchar(64) COMMENT 'type',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude`    double,
  `longitude`   double,  
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appattachmentpk`),
  UNIQUE KEY `fid` (`fid`, `appattachmentpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `appmilestone` (
  `appmilestonepk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'appmilestonepk',
  `datetime` datetime,
  `milestonedesc` varchar(255) NOT NULL COMMENT 'milestonedesc',
  `file` varchar(255) COMMENT 'file',
  `url` varchar(255) COMMENT 'url',
  `filemime` varchar(255) COMMENT 'filemime',
  `bopk` varchar(40) COMMENT 'bopk',
  `botype` varchar(64) COMMENT 'botype',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude`    double,
  `longitude`   double,  
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appmilestonepk`),
  UNIQUE KEY `milestonedesc` (`milestonedesc`, `appmilestonepk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE appmdlan CHANGE aplandesc aplandesc TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
ALTER TABLE `appmdgroup` ADD COLUMN `floorplan` VARCHAR(10) NULL  AFTER `apkeyfields` ;
ALTER TABLE `appmdgroup` DROP COLUMN `singleline`;
