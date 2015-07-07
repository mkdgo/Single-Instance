CREATE TABLE `work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subject` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `work_assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work` int(11) NOT NULL,
  `assignment` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `work_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work` int(11) NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `item_hash_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remote` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `work_items_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_hash_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote` tinyint(1) DEFAULT '1',
  `link` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `work_taggees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work` int(11) NOT NULL,
  `tagged_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
