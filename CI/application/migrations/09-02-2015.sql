ALTER TABLE `lessons` CHANGE COLUMN `objectives_plenary` `objectives_plenary` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL AFTER `objectives`;
ALTER TABLE `modules` ADD COLUMN `objectives_plenary` TEXT NULL AFTER `objectives`;
