CREATE TABLE `site_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `setting_id` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `setting_id_UNIQUE` (`setting_id` ASC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `site_settings` (`setting_id`, `setting_value`) VALUES ('default_identity_data_provider', 'ediface');
INSERT INTO `site_settings` (`setting_id`, `setting_value`) VALUES ('fall_back_to_default_identity_data_provider', 'true');
INSERT INTO `site_settings` (`id`, `setting_id`, `setting_value`) VALUES (NULL, 'website_head_title', 'School');
INSERT INTO `site_settings` (`id`, `setting_id`, `setting_value`) VALUES (NULL, 'logout_url', 'default');
INSERT INTO `site_settings` (`id`, `setting_id`, `setting_value`) VALUES (NULL, 'logout_url_custom', 'https://dragonschool.onelogin.com/client/apps');
INSERT INTO `site_settings` (`id`, `setting_id`, `setting_value`) 
VALUES 
    (NULL, 'tvlesson_creating_resources', ''), 
    (NULL, 'tvlesson_interactive_lessons', ''), 
    (NULL, 'tvlesson_setting_homework', ''), 
    (NULL, 'tvlesson_submitting_homework', ''), 
    (NULL, 'tvlesson_marking_homework', ''),
    (NULL, 'svlesson_creating_resources', ''), 
    (NULL, 'svlesson_interactive_lessons', ''), 
    (NULL, 'svlesson_setting_homework', ''), 
    (NULL, 'svlesson_submitting_homework', ''), 
    (NULL, 'svlesson_marking_homework', '');


ALTER TABLE `users` ADD COLUMN `password_recovery_token` VARCHAR(255) NULL AFTER `last_seen`;
ALTER TABLE `users` ADD COLUMN `is_onlihe` TINYINT(1) NULL ;
