DROP TRIGGER appmetadata_BEFORE_INSERT;
DELIMITER $$
CREATE
TRIGGER `appmetadata_BEFORE_INSERT`
BEFORE INSERT ON `appmetadata`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appmdgroup_tenant_trigger`
BEFORE INSERT ON `appmdgroup`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appmdlan_tenant_trigger`
BEFORE INSERT ON `appmdlan`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appform_tenant_trigger`
BEFORE INSERT ON `appform`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appinspectionform_tenant_trigger`
BEFORE INSERT ON `appinspectionform`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appinspectiondtl_tenant_trigger`
BEFORE INSERT ON `appinspectiondtl`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appformmenu_tenant_trigger`
BEFORE INSERT ON `appformmenu`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appmilestone_tenant_trigger`
BEFORE INSERT ON `appmilestone`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$

DELIMITER $$
CREATE
TRIGGER `appattachment_tenant_trigger`
BEFORE INSERT ON `appattachment`
FOR EACH ROW
set new.tenant = SUBSTRING_INDEX(USER(),'@',1);

$$
