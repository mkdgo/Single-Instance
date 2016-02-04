-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: 10.169.0.4
-- Generation Time: Feb 02, 2016 at 02:12 PM
-- Server version: 5.6.21
-- PHP Version: 5.3.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ediface_krystal`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`demoedif_student`@`%` PROCEDURE `filterAssignments`()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;
    TRUNCATE TABLE `assignments_filter`;
    INSERT INTO assignments_filter
    SELECT *
    FROM (SELECT a1.*, subjects.name AS subject_name,
            (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active != -1) AS total,
            (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1 AND a2.publish >= 1) AS submitted,
            (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1 AND a2.publish >= 1 AND a2.grade != 0 AND a2.grade != "") AS marked
         FROM assignments a1
         LEFT JOIN classes ON classes.id IN (a1.class_id)
         LEFT JOIN subjects ON subjects.id = classes.subject_id
         LEFT JOIN assignments_marks ON assignments_marks.assignment_id = a1.id
         WHERE active = 1) ss;
    SET FOREIGN_KEY_CHECKS=1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_true` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int(11) NOT NULL,
  `base_assignment_id` int(11) NOT NULL DEFAULT '0',
  `teacher_id` int(11) NOT NULL DEFAULT '0',
  `student_id` int(11) NOT NULL DEFAULT '0',
  `class_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `grade_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deadline_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `submitted_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0',
  `exempt` tinyint(3) unsigned DEFAULT '0',
  `publish_marks` tinyint(1) DEFAULT '0',
  `created_date` datetime NOT NULL,
  `publish_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_copy`
--

CREATE TABLE IF NOT EXISTS `assignments_copy` (
  `id` int(11) NOT NULL,
  `base_assignment_id` int(11) NOT NULL DEFAULT '0',
  `teacher_id` int(11) NOT NULL DEFAULT '0',
  `student_id` int(11) NOT NULL DEFAULT '0',
  `class_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `grade_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deadline_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `submitted_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0',
  `publish_marks` tinyint(1) DEFAULT '0',
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_details`
--

CREATE TABLE IF NOT EXISTS `assignments_details` (
  `id` int(11) NOT NULL,
  `assignment_detail_value` text COLLATE utf8_unicode_ci NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `assignment_detail_type` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_filter`
--

CREATE TABLE IF NOT EXISTS `assignments_filter` (
  `id` int(11) unsigned NOT NULL,
  `base_assignment_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `publish_date` datetime DEFAULT NULL,
  `class_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `grade_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deadline_date` datetime NOT NULL,
  `submitted_date` datetime NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `publish_marks` tinyint(1) NOT NULL,
  `subject_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` bigint(21) NOT NULL,
  `submitted` bigint(21) NOT NULL,
  `marked` bigint(21) NOT NULL,
  `subject_id` int(10) unsigned DEFAULT NULL,
  `year` int(10) unsigned DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_weight` tinyint(2) NOT NULL,
  `teacher_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_grade_attributes`
--

CREATE TABLE IF NOT EXISTS `assignments_grade_attributes` (
  `id` int(11) NOT NULL,
  `attribute_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `attribute_marks` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_grade_categories`
--

CREATE TABLE IF NOT EXISTS `assignments_grade_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `category_marks` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_marks`
--

CREATE TABLE IF NOT EXISTS `assignments_marks` (
  `id` int(11) NOT NULL,
  `pagesnum` int(11) DEFAULT NULL,
  `screens_data` text COLLATE utf8_unicode_ci,
  `total_evaluation` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_resources`
--

CREATE TABLE IF NOT EXISTS `assignments_resources` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `is_late` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `group_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_page_slides`
--

CREATE TABLE IF NOT EXISTS `content_page_slides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT '0',
  `lesson_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '10000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cont_page_resources`
--

CREATE TABLE IF NOT EXISTS `cont_page_resources` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `cont_page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE IF NOT EXISTS `curriculum` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL DEFAULT '0',
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `objectives` longtext COLLATE utf8_unicode_ci NOT NULL,
  `teaching_activities` longtext COLLATE utf8_unicode_ci NOT NULL,
  `assessment_opportunities` longtext COLLATE utf8_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interactive_assessments_slides`
--

CREATE TABLE IF NOT EXISTS `interactive_assessments_slides` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `temp_data` text COLLATE utf8_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '10000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `key_words`
--

CREATE TABLE IF NOT EXISTS `key_words` (
  `id` int(11) NOT NULL,
  `word` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `key_words_resources`
--

CREATE TABLE IF NOT EXISTS `key_words_resources` (
  `key_word` int(11) NOT NULL,
  `resource` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `objectives` text COLLATE utf8_unicode_ci NOT NULL,
  `teaching_activities` text COLLATE utf8_unicode_ci NOT NULL,
  `assessment_opportunities` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `module_id` int(11) NOT NULL DEFAULT '0',
  `published_lesson_plan` tinyint(1) NOT NULL DEFAULT '0',
  `published_interactive_lesson` tinyint(1) NOT NULL DEFAULT '0',
  `interactive_lesson_exists` tinyint(1) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `teacher_led` tinyint(1) NOT NULL DEFAULT '0',
  `running_page` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '10000',
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_classes`
--

CREATE TABLE IF NOT EXISTS `lessons_classes` (
  `lesson_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons_resources`
--

CREATE TABLE IF NOT EXISTS `lessons_resources` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `objectives` text COLLATE utf8_unicode_ci NOT NULL,
  `teaching_activities` text COLLATE utf8_unicode_ci NOT NULL,
  `assessment_opportunities` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `subject_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '10000',
  `year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules_resources`
--

CREATE TABLE IF NOT EXISTS `modules_resources` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `hot` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL,
  `int_assessment_id` int(11) NOT NULL,
  `question_text` text COLLATE utf8_unicode_ci NOT NULL,
  `resource_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL DEFAULT '0',
  `resource_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `restriction_year` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_remote` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL,
  `setting_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_classes`
--

CREATE TABLE IF NOT EXISTS `student_classes` (
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_years`
--

CREATE TABLE IF NOT EXISTS `subject_years` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `publish` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE IF NOT EXISTS `teacher_classes` (
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` enum('teacher','student') COLLATE utf8_unicode_ci NOT NULL,
  `student_year` int(11) NOT NULL DEFAULT '0',
  `last_seen` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password_recovery_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_online` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_onelogins`
--

CREATE TABLE IF NOT EXISTS `user_onelogins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `oneloginid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `system_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_openids`
--

CREATE TABLE IF NOT EXISTS `user_openids` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `openid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `system_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subject` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_assignments`
--

CREATE TABLE IF NOT EXISTS `work_assignments` (
  `id` int(11) NOT NULL,
  `work` int(11) NOT NULL,
  `assignment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_items`
--

CREATE TABLE IF NOT EXISTS `work_items` (
  `id` int(11) NOT NULL,
  `work` int(11) NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `item_hash_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remote` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `resource_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_items_temp`
--

CREATE TABLE IF NOT EXISTS `work_items_temp` (
  `id` int(11) NOT NULL,
  `uuid` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_hash_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote` tinyint(1) DEFAULT '1',
  `link` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_taggees`
--

CREATE TABLE IF NOT EXISTS `work_taggees` (
  `id` int(11) NOT NULL,
  `work` int(11) NOT NULL,
  `tagged_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments_copy`
--
ALTER TABLE `assignments_copy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments_details`
--
ALTER TABLE `assignments_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments_filter`
--
ALTER TABLE `assignments_filter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `base_assignment_id` (`base_assignment_id`),
  ADD KEY `publish` (`publish`),
  ADD KEY `publish_marks` (`publish_marks`);

--
-- Indexes for table `assignments_grade_attributes`
--
ALTER TABLE `assignments_grade_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments_grade_categories`
--
ALTER TABLE `assignments_grade_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments_marks`
--
ALTER TABLE `assignments_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `assignments_resources`
--
ALTER TABLE `assignments_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_page_slides`
--
ALTER TABLE `content_page_slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interactive_lesson_id` (`lesson_id`);

--
-- Indexes for table `cont_page_resources`
--
ALTER TABLE `cont_page_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cont_page_id` (`cont_page_id`),
  ADD KEY `resource_id` (`resource_id`);

--
-- Indexes for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interactive_assessments_slides`
--
ALTER TABLE `interactive_assessments_slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interactive_lesson_id` (`lesson_id`);

--
-- Indexes for table `key_words`
--
ALTER TABLE `key_words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `lessons_classes`
--
ALTER TABLE `lessons_classes`
  ADD PRIMARY KEY (`lesson_id`,`class_id`);

--
-- Indexes for table `lessons_resources`
--
ALTER TABLE `lessons_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `modules_resources`
--
ALTER TABLE `modules_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `int_assessment_id` (`int_assessment_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_id_UNIQUE` (`setting_id`);

--
-- Indexes for table `student_classes`
--
ALTER TABLE `student_classes`
  ADD PRIMARY KEY (`student_id`,`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_years`
--
ALTER TABLE `subject_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD PRIMARY KEY (`teacher_id`,`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_onelogins`
--
ALTER TABLE `user_onelogins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_openids`
--
ALTER TABLE `user_openids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_assignments`
--
ALTER TABLE `work_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_items`
--
ALTER TABLE `work_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_items_temp`
--
ALTER TABLE `work_items_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_taggees`
--
ALTER TABLE `work_taggees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments_copy`
--
ALTER TABLE `assignments_copy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments_details`
--
ALTER TABLE `assignments_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments_grade_attributes`
--
ALTER TABLE `assignments_grade_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments_grade_categories`
--
ALTER TABLE `assignments_grade_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments_marks`
--
ALTER TABLE `assignments_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assignments_resources`
--
ALTER TABLE `assignments_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `content_page_slides`
--
ALTER TABLE `content_page_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cont_page_resources`
--
ALTER TABLE `cont_page_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `interactive_assessments_slides`
--
ALTER TABLE `interactive_assessments_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `key_words`
--
ALTER TABLE `key_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons_resources`
--
ALTER TABLE `lessons_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules_resources`
--
ALTER TABLE `modules_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject_years`
--
ALTER TABLE `subject_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_onelogins`
--
ALTER TABLE `user_onelogins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_openids`
--
ALTER TABLE `user_openids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_assignments`
--
ALTER TABLE `work_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_items`
--
ALTER TABLE `work_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_items_temp`
--
ALTER TABLE `work_items_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_taggees`
--
ALTER TABLE `work_taggees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`int_assessment_id`) REFERENCES `interactive_assessments_slides` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
