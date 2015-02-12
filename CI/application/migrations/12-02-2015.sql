CREATE TABLE `plenary_results` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `subject_id` INT(11) NOT NULL,
  `module_id` INT(11) NOT NULL,
  `lesson_id(11)` INT(11) NOT NULL,
  `objective_id` INT(11) NOT NULL,
  `value_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `plenary_results` CHANGE COLUMN `lesson_id(11)` `lesson_id` INT(11) NOT NULL ;

ALTER TABLE `plenary_results` ADD COLUMN `content_page_id` INT(11) NOT NULL AFTER `lesson_id`;
