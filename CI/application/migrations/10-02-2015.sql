CREATE TABLE `plenaries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `plenary_type` ENUM('module','lesson') NOT NULL,
  `fk_id` INT NOT NULL COMMENT 'Foreign key to either \'modules\' or \'lessons\'.',
  PRIMARY KEY (`id`));

CREATE TABLE `plenary_grade_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(45) NOT NULL,
  `label_rank` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `plenary_grade_labels` (`label`, `label_rank`) VALUES ('Strongly Disagree', '1');
INSERT INTO `plenary_grade_labels` (`label`, `label_rank`) VALUES ('Disagree', '2');
INSERT INTO `plenary_grade_labels` (`label`, `label_rank`) VALUES ('Neutral', '3');
INSERT INTO `plenary_grade_labels` (`label`, `label_rank`) VALUES ('Agree', '4');
INSERT INTO `plenary_grade_labels` (`label`, `label_rank`) VALUES ('Strongly Agree', '5');

CREATE TABLE `plenary_grid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plenary_id` int(11) NOT NULL,
  `objective_id` int(11) NOT NULL,
  `label_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_label_id_idx` (`label_id`),
  KEY `fk_objective_id_idx` (`objective_id`),
  KEY `fk_plenary_id_idx` (`plenary_id`),
  CONSTRAINT `fk_plenary_id` FOREIGN KEY (`plenary_id`) REFERENCES `plenaries` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_label_id` FOREIGN KEY (`label_id`) REFERENCES `plenary_grade_labels` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_objective_id` FOREIGN KEY (`objective_id`) REFERENCES `key_words_objectives` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `content_page_slides` ADD COLUMN `slide_type` ENUM('slide','plenary') NOT NULL DEFAULT 'slide' AFTER `order`;

CREATE TABLE `content_page_plenaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plenary_id` int(11) NOT NULL,
  `cont_page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cont_page_id` (`cont_page_id`),
  KEY `plenary_id` (`plenary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
