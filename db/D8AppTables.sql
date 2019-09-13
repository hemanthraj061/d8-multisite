delimiter $$

CREATE TABLE `appmetadata` (
  `apmdpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'app meta data pk',
  `apmdname` varchar(40) NOT NULL COMMENT 'Metadata Name',
  `apmdtype` varchar(10) DEFAULT NULL COMMENT 'Metadata Type',
  `apmdlength` varchar(10) NOT NULL COMMENT 'Metadata Length',
  `apmddesc` varchar(100) NOT NULL COMMENT 'Metadata Desc',
  `apmdoptions` varchar(1000) DEFAULT NULL,
  `module` varchar(40) DEFAULT NULL,
  `form` varchar(40) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL COMMENT 'System User name',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) DEFAULT NULL COMMENT 'System User name',
  `updatedtime` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`apmdpk`),
  UNIQUE KEY `apmdname` (`apmdname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

CREATE
TRIGGER `appmetadata_BEFORE_INSERT`
BEFORE INSERT ON `appmetadata`
FOR EACH ROW
BEGIN
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);
END
$$

delimiter $$

CREATE TABLE `appmdgroup` (
  `apmdgpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'app meta data group pk',
  `apmdgroupid` varchar(40) NOT NULL COMMENT 'Metadata Group ID',
  `apmdgroupname` varchar(100) NOT NULL COMMENT 'Metadata Group Name',
  `apmdfields` json DEFAULT NULL COMMENT 'Metadata Fields',
  `aptablefields` json DEFAULT NULL COMMENT 'Data table Fields',
  `apkeyfields` json DEFAULT NULL COMMENT 'Form Key Fields',
  `singleline` varchar(10) DEFAULT NULL,
  `grouptype` varchar(40) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL COMMENT 'System User name',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) DEFAULT NULL COMMENT 'System User name',
  `updatedtime` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`apmdgpk`),
  UNIQUE KEY `apmdgroupid` (`apmdgroupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$


delimiter $$

CREATE TABLE `appmdlan` (
  `applanpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'app meta data pk',
  `appmdpk` int(11) NOT NULL COMMENT 'app meta data pk',
  `lang` varchar(40) NOT NULL COMMENT 'Metadata Name',
  `type` varchar(10) DEFAULT NULL COMMENT 'Label-tip-error	',
  `aplandesc` varchar(100) NOT NULL COMMENT 'Desc in native language',
  `createdby` int(11) DEFAULT NULL COMMENT 'System User name',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) DEFAULT NULL COMMENT 'System User name',
  `updatedtime` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`applanpk`),
  UNIQUE KEY `applanpk` (`applanpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `appform` (
  `appformpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Formpk',
  `appformid` int(11) NOT NULL COMMENT 'Form id',
  `appgroupname` varchar(40) DEFAULT NULL COMMENT 'Group Name',
  `appgroupfields` json DEFAULT NULL COMMENT 'Group Field values',
  `appformstatus` varchar(40) DEFAULT NULL COMMENT 'Form Status',
  `appformcomments` varchar(255) DEFAULT NULL COMMENT 'Form Comments',
  `createdby` int(11) DEFAULT NULL COMMENT 'System User name',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) DEFAULT NULL COMMENT 'System User name',
  `updatedtime` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appformpk`),
  UNIQUE KEY `appformpk` (`appformpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$


delimiter $$

CREATE TABLE `appformfeedback` (
  `appformfeedbkpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Form Feedback pk',
  `appformid` varchar(40) NOT NULL COMMENT 'Form id',
  `feedbacktype` varchar(10) NOT NULL COMMENT 'Audit-Inspection',
  `feedbackdate` datetime NOT NULL COMMENT 'Date and time of feedback',
  `appgroupname` varchar(40) DEFAULT NULL COMMENT 'Group Name',
  `appfeedback` json DEFAULT NULL COMMENT 'Feedback for each field',
  `appformcomments` varchar(255) DEFAULT NULL COMMENT 'Form Comments',
  `createdby` int(11) DEFAULT NULL COMMENT 'System User name',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) DEFAULT NULL COMMENT 'System User name',
  `updatedtime` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appformfeedbkpk`),
  UNIQUE KEY `appformfeedbkpk` (`appformfeedbkpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `appinspectionform` (
  `appinspformpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Inspection Formpk',
  `appinspformid` varchar(40) NOT NULL COMMENT 'Inspection Form id',
  `appinspformname` varchar(100) DEFAULT NULL COMMENT 'Form Name',
  `appinspauditor` varchar(40) DEFAULT NULL COMMENT 'Auditee User',
  `appinspauditee` varchar(40) DEFAULT NULL COMMENT 'Audited User',
  `appauditdate` datetime NOT NULL COMMENT 'Audit Date',
  `appinspstatus` varchar(40) DEFAULT NULL COMMENT 'Inspection Status',
  `appinspcomments` varchar(255) DEFAULT NULL COMMENT 'Auditee Comments',
  `appinspfeedback` varchar(255) DEFAULT NULL COMMENT 'Auditor Feedback',
  `batch` varchar(40) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL COMMENT 'System User name',
  `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) DEFAULT NULL COMMENT 'System User name',
  `updatedtime` datetime DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appinspformpk`),
  UNIQUE KEY `appinspformid` (`appinspformid`,`appinspformpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `appinspectiondtl` (
  `appinspdtlpk` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Inspection Formpk',
  `appinspformpk` int(11) NOT NULL COMMENT 'Inspection Formpk',
  `slno` int(11) NOT NULL COMMENT 'slno',
  `chapter` varchar(1000) NOT NULL COMMENT 'Chapterno',
  `requirements` varchar(1000) DEFAULT NULL COMMENT 'Requirements',
  `checklist` varchar(6000) DEFAULT NULL COMMENT 'Checklists',
  `evidence` varchar(1000) DEFAULT NULL COMMENT 'Evidence',
  `comments` varchar(1000) DEFAULT NULL COMMENT 'Comments',
  `docstatus` int(11) DEFAULT NULL COMMENT 'Document Status',
  `compstatus` int(11) DEFAULT NULL COMMENT 'Completion Status',
  `feedback` varchar(1000) DEFAULT NULL COMMENT 'Feedback from Auditor',
  `status` varchar(10) DEFAULT NULL COMMENT 'Closed-Open',
  `tenant` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appinspdtlpk`),
  UNIQUE KEY `appinspformpk` (`appinspformpk`,`appinspdtlpk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

