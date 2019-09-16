
CREATE VIEW `xappmdgroup` AS SELECT * FROM `appmdgroup` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappmetadata` AS SELECT * FROM `appmetadata` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappmdlan` AS SELECT * FROM `appmdlan` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappform` AS SELECT * FROM `appform` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappinspectionform` AS SELECT * FROM `appinspectionform` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappinspectiondtl` AS SELECT * FROM `appinspectiondtl` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappformmenu` AS SELECT * FROM `appformmenu` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappmilestone` AS SELECT * FROM `appmilestone` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));

CREATE VIEW `xappattachment` AS SELECT * FROM `appattachment` WHERE (`tenant` = CONVERT(SUBSTRING_INDEX(USER(),'@',1) using latin1));
