CREATE TABLE `site_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `setting_id` VARCHAR(100) NOT NULL,
  `setting_value` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `setting_id_UNIQUE` (`setting_id` ASC));

INSERT INTO `site_settings` (`setting_id`, `setting_value`) VALUES ('default_identity_data_provider', 'ediface');
INSERT INTO `site_settings` (`setting_id`, `setting_value`) VALUES ('fall_back_to_default_identity_data_provider', 'true');

ALTER TABLE `users` ADD COLUMN `password_recovery_token` VARCHAR(255) NULL AFTER `last_seen`;
