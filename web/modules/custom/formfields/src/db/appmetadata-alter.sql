ALTER TABLE appmetadata ADD COLUMN rangelow VARCHAR(40) NULL DEFAULT NULL AFTER apmdoptions, ADD COLUMN rangehigh VARCHAR(40) NULL DEFAULT NULL AFTER rangelow;
