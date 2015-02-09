ALTER TABLE `lessons` CHANGE COLUMN `objectives_plenary` `objectives_plenary` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL AFTER `objectives`;
ALTER TABLE `modules` ADD COLUMN `objectives_plenary` TEXT NULL AFTER `objectives`;
# REVERT #
ALTER TABLE `lessons` DROP COLUMN `objectives_plenary`;
ALTER TABLE `modules` DROP COLUMN `objectives_plenary`;

CREATE TABLE `key_words_objectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `key_words_lessons` (
  `key_word` int(11) NOT NULL,
  `lesson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `key_words_modules` (
  `key_word` int(11) NOT NULL,
  `module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
