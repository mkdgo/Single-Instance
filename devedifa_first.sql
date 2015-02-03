-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2015 at 06:46 PM
-- Server version: 5.5.40-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `devedifa_first`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@ediface.org', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer_text` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_true` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=264 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_text`, `answer_true`) VALUES
(260, 158, 'Pacific', 1),
(261, 158, 'Indian', 0),
(262, 158, 'Southern', 0),
(263, 158, 'Atlantic', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=768 ;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `base_assignment_id`, `teacher_id`, `student_id`, `class_id`, `title`, `intro`, `grade_type`, `grade`, `deadline_date`, `submitted_date`, `feedback`, `active`, `publish`, `publish_marks`) VALUES
(605, 0, 28, 0, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(606, 605, 28, 2, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(607, 605, 28, 4, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(608, 605, 28, 5, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(609, 605, 28, 6, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(610, 605, 28, 7, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(611, 605, 28, 8, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(612, 605, 28, 27, '1', 'What is a Chemical Reaction?', 'this is just the first test', 'percentage', '', '2014-11-20 15:30:00', '2014-11-09 20:43:49', '', 1, 1, 0),
(613, 0, 28, 0, '7', 'The Theory of Photosynthesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-11-20 12:12:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(614, 613, 28, 2, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(615, 613, 28, 4, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(616, 613, 28, 5, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(617, 613, 28, 6, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(618, 613, 28, 7, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(619, 613, 28, 8, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(620, 613, 28, 27, '1', 'The Theory of Photosythesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '', '2014-12-12 12:12:00', '2014-11-09 20:57:12', '', 0, 1, 0),
(621, 0, 28, 0, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(622, 621, 28, 2, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(623, 621, 28, 4, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(624, 621, 28, 5, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(625, 621, 28, 6, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(626, 621, 28, 7, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(627, 621, 28, 8, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '', '2014-12-12 12:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(628, 621, 28, 27, '1', 'Physical Erosion', 'Please write an essay of 500 works on Physical Erosion', 'percentage', '1', '2014-12-12 12:12:00', '2014-11-09 21:10:31', '', 1, 1, 0),
(629, 0, 28, 0, '6', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 1, 1, 1),
(630, 629, 28, 2, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(631, 629, 28, 4, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(632, 629, 28, 5, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(633, 629, 28, 6, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(634, 629, 28, 7, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(635, 629, 28, 8, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(636, 629, 28, 27, '1', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '1', '2014-11-10 12:00:00', '2014-11-10 11:31:09', '', 0, 1, 0),
(638, 0, 28, 0, '1,6', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(639, 638, 28, 2, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(640, 638, 28, 4, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(641, 638, 28, 5, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(642, 638, 28, 6, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(643, 638, 28, 7, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(644, 638, 28, 8, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '', '2014-11-10 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(645, 638, 28, 27, '1', 'Glacial Erosion', 'Write an essay of 500 works about Glacial Erosion', 'free_text', '1', '2014-11-10 17:00:00', '2014-11-10 17:12:37', '', 1, 1, 0),
(647, 0, 28, 0, '1,6', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(648, 647, 28, 2, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(649, 647, 28, 4, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(650, 647, 28, 5, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(651, 647, 28, 6, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(652, 647, 28, 7, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(653, 647, 28, 8, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '', '2014-11-11 17:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(654, 647, 28, 27, '1', 'Adding multiple resources', 'A view of how to add multiple resources', 'grade', '1', '2014-11-11 17:00:00', '2014-11-11 17:06:40', '', 1, 1, 0),
(656, 0, 28, 0, '1,6', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(657, 656, 28, 2, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(658, 656, 28, 4, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(659, 656, 28, 5, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(660, 656, 28, 6, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(661, 656, 28, 7, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(662, 656, 28, 8, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(663, 656, 28, 27, '1', 'HMS Warspite', 'HMS Warspite is the most decorated Battle Ship in the British Navy.  Please self-research this Battle Ship and provide me with a Chronological view of her life at Sea.  Extra points will be given to those who provide drawings, illustrations and maps of here voyages.', 'percentage', '', '2014-11-21 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(665, 0, 28, 0, '6', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(666, 665, 28, 2, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(667, 665, 28, 4, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(668, 665, 28, 5, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(669, 665, 28, 6, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(670, 665, 28, 7, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(671, 665, 28, 8, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(672, 665, 28, 27, '1', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(674, 0, 28, 0, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(675, 674, 28, 2, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(676, 674, 28, 4, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(677, 674, 28, 5, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(678, 674, 28, 6, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(679, 674, 28, 7, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(680, 674, 28, 8, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(681, 674, 28, 27, '1', 'Shakespeare and his Sonnets', 'Red Lion', 'percentage', '', '2014-12-12 15:12:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(682, 0, 28, 0, '1,6', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(683, 682, 28, 2, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(684, 682, 28, 4, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(685, 682, 28, 5, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(686, 682, 28, 6, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(687, 682, 28, 7, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(688, 682, 28, 8, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(689, 682, 28, 27, '1', 'Decimals and their Origins', 'I would like you to write an essay on Decimals and where they came from.', 'grade', '', '2014-11-18 16:40:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(691, 0, 28, 0, '7', 'Use of colour on Acrylic', 'Using your acrylic and canvas provided, I want each of you to paint a picture of an item in your kitchen (think Saucepan, Milk Jug).  I want you to use more than 6 colours.  Please upload a photo of your finished painting.', 'free_text', '', '2014-11-19 19:33:00', '0000-00-00 00:00:00', '', 1, 1, 1),
(692, 0, 28, 0, '7', 'Percy Hobart and the ''Desert Rats''', 'I want each of you to self-research Percy Hobart and provide me with a 500 work summary on what was special about this many.  Extra marks will be given if you can provide me with a view of other important contributions he made in WW2, most notably the creation of his ''Hobart Funnies''.', 'percentage', '', '2014-12-02 16:12:00', '0000-00-00 00:00:00', '', 1, 1, 1),
(693, 691, 28, 27, '7', 'Use of colour on Acrylic', 'Using your acrylic and canvas provided, I want each of you to paint a picture of an item in your kitchen (think Saucepan, Milk Jug).  I want you to use more than 6 colours.  Please upload a photo of your finished painting.', 'free_text', '1', '2014-11-19 19:33:00', '2014-11-19 19:18:45', '', 1, 1, 1),
(694, 692, 28, 27, '7', 'Percy Hobart and the ''Desert Rats''', 'I want each of you to self-research Percy Hobart and provide me with a 500 work summary on what was special about this many.  Extra marks will be given if you can provide me with a view of other important contributions he made in WW2, most notably the creation of his ''Hobart Funnies''.', 'percentage', '', '2014-12-02 16:12:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(695, 613, 28, 27, '7', 'The Theory of Photosynthesis', 'I want you to draw a leave and using labelling explain the theory of photosynthesis and what it is so important to our very existence.', 'percentage', '1', '2014-11-20 12:12:00', '2014-11-19 18:59:19', '', 1, 1, 0),
(696, 0, 28, 0, '1,6', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(697, 696, 28, 2, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(698, 696, 28, 4, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(699, 696, 28, 5, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(700, 696, 28, 6, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(701, 696, 28, 7, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(702, 696, 28, 8, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(703, 696, 28, 27, '1', 'Create a simple website', 'Your task will be to create a simple website using basic HTML and CSS commands. Your site must be at least 3 pages long and contain a simple navigation and links to all pages.', 'grade', '', '2014-11-20 03:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(705, 0, 28, 0, '1,6', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(706, 705, 28, 2, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(707, 705, 28, 4, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(708, 705, 28, 5, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(709, 705, 28, 6, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(710, 705, 28, 7, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(711, 705, 28, 8, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(712, 705, 28, 27, '1', 'Electricity in the modern worlds', 'Name three forms of electricity generation in the modern world and upload photographs of each.', 'percentage', '', '2014-11-20 03:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(714, 0, 28, 0, '1,6', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(715, 714, 28, 2, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(716, 714, 28, 4, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(717, 714, 28, 5, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(718, 714, 28, 6, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(719, 714, 28, 7, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(720, 714, 28, 8, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(721, 714, 28, 27, '1', 'Test Assignment', 'Test for uploads', 'percentage', '', '2014-11-22 00:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(723, 0, 28, 0, '6', 'Symmetry Photo ', 'Please submit one example of a symmetrical photograph', 'grade', '', '2014-11-20 12:01:00', '0000-00-00 00:00:00', '', 1, 1, 1),
(724, 723, 28, 27, '6', 'Symmetry Photo ', 'Please submit one example of a symmetrical photograph', 'grade', '1', '2014-11-20 12:01:00', '2014-11-20 12:02:06', '', 1, 1, 1),
(725, 0, 28, 0, '1,6', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 1, 1),
(726, 725, 28, 2, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(727, 725, 28, 4, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(728, 725, 28, 5, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(729, 725, 28, 6, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(730, 725, 28, 7, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(731, 725, 28, 8, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(732, 725, 28, 27, '1', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '1', '2014-11-20 19:41:00', '2014-11-20 19:42:15', '', 1, 1, 1),
(733, 725, 28, 27, '6', 'Symmetry Picture', 'Take a picture of something symmetrical', 'percentage', '', '2014-11-20 19:41:00', '0000-00-00 00:00:00', '', 1, 0, 1),
(734, 0, 28, 0, '6', 'Percy Hobart and the Desert Rats', 'Please provide a 600 work essay on Earthquakes.', 'percentage', '', '2015-01-25 16:49:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(735, 0, 28, 0, '0', '', '', 'percentage', '', '2014-11-28 18:28:12', '0000-00-00 00:00:00', '', 1, 0, 0),
(736, 0, 28, 0, '0', '', '', 'percentage', '', '2014-12-10 12:20:35', '0000-00-00 00:00:00', '', 1, 0, 0),
(737, 0, 28, 0, '0', '', '', 'percentage', '', '2014-12-10 12:29:11', '0000-00-00 00:00:00', '', 1, 0, 0),
(738, 629, 28, 27, '6', 'Pythagoras', 'Write a 500 word essay on the importance of Pythagoras in todays mathematics', 'grade', '', '2014-11-10 12:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(739, 0, 28, 0, '7', 'fggfdgfd', '11111', 'mark_out_of_10', '', '2015-02-02 21:52:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(740, 0, 28, 0, '6', 'dsasadsadsa', '<p>fdsfsdfsd fdsf dfdsfdsf dsfdsfdsfdsfdsfds dsfsdfdsf</p>', 'percentage', '', '2015-12-14 00:47:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(741, 0, 28, 0, '0', '', '', 'percentage', '', '2014-12-14 09:43:26', '0000-00-00 00:00:00', '', 1, 0, 0),
(742, 0, 28, 0, '6', 'efrewrfdsds', '<p>dsfsff dsfdsfsdfds fdsfdsfdsffd</p>', 'percentage', '', '2015-02-18 09:44:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(743, 0, 28, 0, '0', 'sadasdsa', 'dsfdsfd fdsfsdf dsfdsf dsfdsfdsfsdfdsf', 'percentage', '', '2013-11-30 23:57:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(744, 665, 28, 27, '6', 'Measuring your Pulse', 'I want you all to measure your pulse and write down how you have done it and how many pulses you have over the period of 60 seconds.  I want you to do this from a seating position and at rest and again after running on the spot for 1 minute.', 'grade', '', '2014-12-23 14:00:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(745, 0, 28, 0, '6', 'test1', '<p>summary</p>', 'mark_out_of_10', '', '2015-12-15 16:48:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(746, 0, 28, 0, '7', '996', '<p>&nbsp;22222</p>', 'free_text', '', '2015-02-28 21:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(747, 746, 28, 27, '7', '996', '<p>&nbsp;22222</p>', 'free_text', '', '2015-02-28 21:10:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(748, 0, 28, 0, '7', 'test11', '<p><br data-mce-bogus="1"></p>', 'mark_out_of_10', '', '2015-12-23 16:01:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(749, 0, 28, 0, '7', 'qwerty', '<p><br data-mce-bogus="1"></p>', 'percentage', '', '2015-10-29 20:54:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(750, 749, 28, 27, '6', 'qwerty', '', 'percentage', '', '2018-10-29 20:54:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(751, 734, 28, 27, '6', 'Percy Hobart and the Desert Rats', 'Please provide a 600 work essay on Earthquakes.', 'percentage', '', '2015-01-25 16:49:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(752, 749, 28, 27, '7', 'qwerty', '<p><br data-mce-bogus="1"></p>', 'percentage', '', '2015-10-29 20:54:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(753, 748, 28, 27, '7', 'test11', '<p><br data-mce-bogus="1"></p>', 'mark_out_of_10', '', '2015-12-23 16:01:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(754, 740, 28, 27, '6', 'dsasadsadsa', '<p>fdsfsdfsd fdsf dfdsfdsf dsfdsfdsfdsfdsfds dsfsdfdsf</p>', 'percentage', '', '2015-12-14 00:47:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(755, 745, 28, 27, '6', 'test1', '<p>summary</p>', 'mark_out_of_10', '', '2015-12-15 16:48:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(756, 0, 28, 0, '0', 'test', '', 'percentage', '', '2015-01-13 18:51:05', '0000-00-00 00:00:00', '', 1, 0, 0),
(757, 0, 28, 0, '0', 'jkkhhhj', '', 'percentage', '', '2015-01-13 18:59:18', '0000-00-00 00:00:00', '', 1, 0, 0),
(758, 0, 28, 0, '6', 'Percy Hobart and the Desert Rats', '<p>abc</p>', 'grade', '', '2015-01-17 19:10:00', '0000-00-00 00:00:00', '', 1, 1, 0),
(759, 758, 28, 27, '6', 'Percy Hobart and the Desert Rats', '<p>abc</p>', 'grade', '', '2015-01-17 19:10:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(760, 0, 28, 0, '0', 'kjnjnjnk', '', 'grade', '', '2015-01-13 19:12:10', '0000-00-00 00:00:00', '', 1, 0, 0),
(761, 0, 28, 0, '6', 'anton 13 jan', '', 'mark_out_of_10', '', '2015-02-13 19:16:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(762, 761, 28, 27, '6', 'anton 13 jan', '', 'mark_out_of_10', '', '2015-02-13 19:16:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(763, 0, 28, 0, '6', 'What causes Tsunamis?', '', 'mark_out_of_10', '', '2015-01-18 19:24:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(764, 763, 28, 27, '6', 'What causes Tsunamis?', '', 'mark_out_of_10', '', '2015-01-18 19:24:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(765, 739, 28, 27, '6', 'fggfdgfd', '', 'mark_out_of_10', '', '2015-02-02 21:52:00', '0000-00-00 00:00:00', '', 0, 0, 0),
(766, 739, 28, 27, '7', 'fggfdgfd', '11111', 'mark_out_of_10', '', '2015-02-02 21:52:00', '0000-00-00 00:00:00', '', 1, 0, 0),
(767, 742, 28, 27, '6', 'efrewrfdsds', '<p>dsfsff dsfdsfsdfds fdsfdsfdsffd</p>', 'percentage', '', '2015-02-18 09:44:00', '0000-00-00 00:00:00', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `assignments_details`
--

CREATE TABLE IF NOT EXISTS `assignments_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_detail_value` text COLLATE utf8_unicode_ci NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `assignment_detail_type` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `assignments_details`
--

INSERT INTO `assignments_details` (`id`, `assignment_detail_value`, `assignment_id`, `assignment_detail_type`) VALUES
(1, 'kuweit', 403, 1),
(2, 'The `Submission Notes` added by the student goes here.\nFree text with details about the homework.\nPictures? 0777', 214, 1),
(3, 'alabaleee yyyu77', 419, 1),
(4, 'tester is adding notes 8', 427, 1),
(5, 'bruce lee', 436, 1),
(6, '0', 461, 1),
(7, '', 459, 1),
(8, '', 487, 1),
(9, '', 469, 1),
(10, '', 452, 1),
(11, 'alavbala', 512, 1),
(12, 'alabala', 479, 1),
(13, '', 581, 1),
(14, '', 589, 1),
(15, 'notes here', 597, 1),
(16, '', 612, 1),
(17, '', 620, 1),
(18, '', 628, 1),
(19, 'Please find attached my submission for the Pythagoras essay.  I found this one quite difficult with research materials being hard to find in the library.', 636, 1),
(20, 'PLEASE FIND ATTACHED MY SUBMISSION', 646, 1),
(21, 'MY SUBMISSION', 645, 1),
(22, 'Please find attached my submission notes', 654, 1),
(23, 'My theory enlcosed. I hope you like it.', 695, 1),
(24, 'Sorry Sir.  I forgot to add my submissin notes.', 693, 1),
(25, 'This is my submission sir.', 690, 1),
(26, 'Please find attached', 724, 1),
(27, 'Thanks miss', 732, 1),
(28, 'hello', 744, 1),
(29, 'test', 752, 1),
(30, 'hello there', 755, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignments_grade_attributes`
--

CREATE TABLE IF NOT EXISTS `assignments_grade_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `attribute_marks` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3577 ;

--
-- Dumping data for table `assignments_grade_attributes`
--

INSERT INTO `assignments_grade_attributes` (`id`, `attribute_name`, `attribute_marks`, `assignment_id`) VALUES
(50, 'b', 3, 310),
(86, 'A', 100, 321),
(87, 'B', 80, 321),
(88, 'C', 60, 321),
(89, 'D', 40, 321),
(90, 'E', 20, 321),
(263, 'A', 12, 328),
(264, 'B', 34, 328),
(265, 'C', 40, 328),
(266, 'A', 45, 337),
(270, '2', 3, 303),
(271, '4', 3, 303),
(278, 'A', 45, 338),
(307, 'A', 100, 410),
(308, 'B', 80, 410),
(309, 'C', 60, 410),
(310, 'D', 40, 410),
(311, 'E', 20, 410),
(337, 'A', 100, 402),
(338, 'B', 80, 402),
(339, 'C', 60, 402),
(340, 'D', 40, 402),
(341, 'E', 34, 402),
(350, 'A', 100, 390),
(351, 'B', 80, 390),
(352, 'C', 60, 390),
(353, 'D', 40, 390),
(354, 'E', 20, 390),
(528, 'A', 100, 450),
(529, 'B', 80, 450),
(530, 'C', 60, 450),
(531, 'D', 40, 450),
(532, 'E', 20, 450),
(676, 'A', 100, 451),
(677, 'B', 80, 451),
(678, 'C', 60, 451),
(679, 'D', 40, 451),
(680, 'E', 20, 451),
(690, 'A', 100, 476),
(691, 'B', 80, 476),
(692, 'C', 60, 476),
(693, 'D', 40, 476),
(694, 'E', 20, 476),
(860, 'A', 100, 446),
(861, 'B', 80, 446),
(862, 'C', 60, 446),
(863, 'D', 40, 446),
(864, 'E', 20, 446),
(871, 'A', 60, 213),
(872, 'B', 45, 213),
(873, 'C', 12, 213),
(1057, 'A', 100, 435),
(1058, 'B', 80, 435),
(1059, 'C', 60, 435),
(1060, 'D', 40, 435),
(1061, 'E', 20, 435),
(1062, 'Perfect', 90, 418),
(1063, 'A', 12, 418),
(1429, 'A', 100, 520),
(1430, 'B', 80, 520),
(1431, 'C', 60, 520),
(1432, 'D', 40, 520),
(1433, 'E', 20, 520),
(1915, 't', 5, 511),
(1947, 'A', 100, 449),
(1948, 'B', 80, 449),
(1949, 'C', 60, 449),
(1950, 'D', 40, 449),
(1951, 'E', 20, 449),
(1968, 'A', 100, 448),
(1969, 'B', 80, 448),
(1970, 'C', 60, 448),
(1971, 'D', 40, 448),
(1972, 'E', 20, 448),
(1989, '4', 4, 444),
(2000, 'E', 20, 477),
(2001, '12', 22, 477),
(2196, 'A', 100, 426),
(2197, 'B', 80, 426),
(2198, 'C', 60, 426),
(2199, 'D', 40, 426),
(2200, 'E', 20, 426),
(2226, 'done', 44, 445),
(2228, 'A', 100, 565),
(2229, 'B', 80, 565),
(2230, 'C', 60, 565),
(2231, 'D', 40, 565),
(2232, 'E', 20, 565),
(2233, 'A', 100, 0),
(2234, 'B', 80, 0),
(2235, 'C', 60, 0),
(2236, 'D', 40, 0),
(2237, 'E', 20, 0),
(2408, 'A', 100, 596),
(2409, 'B', 80, 596),
(2410, 'C', 60, 596),
(2411, 'D', 40, 596),
(2412, 'E', 20, 596),
(2428, 'A', 100, 580),
(2429, 'B', 80, 580),
(2430, 'C', 60, 580),
(2431, 'D', 40, 580),
(2432, 'E', 20, 580),
(2438, 'A', 100, 588),
(2439, 'B', 80, 588),
(2440, 'C', 60, 588),
(2441, 'D', 40, 588),
(2442, 'E', 20, 588),
(2518, 'A', 100, 638),
(2519, 'B', 80, 638),
(2520, 'C', 60, 638),
(2521, 'D', 40, 638),
(2522, 'E', 20, 638),
(2591, 'A', 80, 682),
(2592, 'B', 65, 682),
(2593, 'C', 55, 682),
(2594, 'D', 45, 682),
(2595, 'E', 40, 682),
(2666, 'A', 100, 674),
(2667, 'B', 80, 674),
(2668, 'C', 60, 674),
(2669, 'D', 40, 674),
(2670, 'E', 20, 674),
(2675, 'A', 100, 647),
(2676, 'B', 80, 647),
(2677, 'C', 60, 647),
(2678, 'D', 40, 647),
(2679, 'E', 20, 647),
(2685, 'A', 100, 605),
(2686, 'B', 80, 605),
(2687, 'C', 60, 605),
(2688, 'D', 40, 605),
(2689, 'E', 20, 605),
(2725, 'A', 100, 613),
(2726, 'B', 80, 613),
(2727, 'C', 60, 613),
(2728, 'D', 40, 613),
(2729, 'E', 20, 613),
(2750, 'A', 85, 691),
(2751, 'B', 65, 691),
(2752, 'C', 55, 691),
(2753, 'D', 40, 691),
(2754, 'E', 20, 691),
(2755, 'A', 100, 621),
(2756, 'B', 80, 621),
(2757, 'C', 60, 621),
(2758, 'D', 40, 621),
(2759, 'E', 20, 621),
(2770, 'A', 100, 696),
(2771, 'B', 75, 696),
(2772, 'C', 50, 696),
(2773, 'D', 25, 696),
(2774, 'E', 10, 696),
(2790, 'A', 100, 705),
(2791, 'B', 80, 705),
(2792, 'C', 60, 705),
(2793, 'D', 40, 705),
(2794, 'E', 20, 705),
(2800, 'A', 100, 656),
(2801, 'B', 80, 656),
(2802, 'C', 60, 656),
(2803, 'D', 40, 656),
(2804, 'E', 20, 656),
(2805, 'A', 100, 714),
(2806, 'B', 80, 714),
(2807, 'C', 60, 714),
(2808, 'D', 40, 714),
(2809, 'E', 20, 714),
(2825, 'A', 70, 723),
(2826, 'B', 60, 723),
(2827, 'C', 50, 723),
(2828, 'D', 40, 723),
(2829, 'E', 20, 723),
(2835, 'A', 100, 725),
(2836, 'B', 80, 725),
(2837, 'C', 60, 725),
(2838, 'D', 40, 725),
(2839, 'E', 20, 725),
(2855, 'A', 100, 735),
(2856, 'B', 80, 735),
(2857, 'C', 60, 735),
(2858, 'D', 40, 735),
(2859, 'E', 20, 735),
(2860, 'A', 100, 736),
(2861, 'B', 80, 736),
(2862, 'C', 60, 736),
(2863, 'D', 40, 736),
(2864, 'E', 20, 736),
(2865, 'A', 100, 737),
(2866, 'B', 80, 737),
(2867, 'C', 60, 737),
(2868, 'D', 40, 737),
(2869, 'E', 20, 737),
(2870, 'A', 100, 629),
(2871, 'B', 80, 629),
(2872, 'C', 60, 629),
(2873, 'D', 40, 629),
(2874, 'E', 20, 629),
(2885, 'A', 100, 741),
(2886, 'B', 80, 741),
(2887, 'C', 60, 741),
(2888, 'D', 40, 741),
(2889, 'E', 20, 741),
(3108, 'A', 100, 743),
(3109, 'B', 80, 743),
(3110, 'C', 60, 743),
(3111, 'D', 40, 743),
(3112, 'E', 20, 743),
(3228, 'A', 100, 665),
(3229, 'B', 80, 665),
(3230, 'C', 60, 665),
(3231, 'D', 40, 665),
(3262, 'A', 100, 734),
(3263, 'B', 80, 734),
(3264, 'C', 60, 734),
(3265, 'D', 40, 734),
(3266, 'E', 20, 734),
(3272, 'A', 100, 749),
(3273, 'B', 80, 749),
(3274, 'C', 60, 749),
(3275, 'D', 40, 749),
(3276, 'E', 20, 749),
(3282, 'A', 100, 748),
(3283, 'B', 80, 748),
(3284, 'C', 60, 748),
(3285, 'D', 40, 748),
(3286, 'E', 20, 748),
(3297, 'A', 100, 740),
(3298, 'B', 80, 740),
(3299, 'C', 60, 740),
(3300, 'D', 40, 740),
(3301, 'E', 20, 740),
(3312, 'A', 100, 692),
(3313, 'B', 80, 692),
(3314, 'C', 60, 692),
(3315, 'D', 40, 692),
(3316, 'E', 20, 692),
(3317, 'A', 100, 756),
(3318, 'B', 80, 756),
(3319, 'C', 60, 756),
(3320, 'D', 40, 756),
(3321, 'E', 20, 756),
(3322, 'A', 100, 757),
(3323, 'B', 80, 757),
(3324, 'C', 60, 757),
(3325, 'D', 40, 757),
(3326, 'E', 20, 757),
(3337, 'A', 100, 760),
(3338, 'B', 80, 760),
(3339, 'C', 60, 760),
(3340, 'D', 40, 760),
(3341, 'E', 20, 760),
(3362, 'A', 100, 761),
(3363, 'B', 80, 761),
(3364, 'C', 60, 761),
(3365, 'D', 40, 761),
(3366, 'E', 20, 761),
(3447, 'A', 100, 763),
(3448, 'B', 80, 763),
(3449, 'C', 60, 763),
(3450, 'D', 40, 763),
(3451, 'E', 20, 763),
(3472, 'A', 100, 739),
(3473, 'B', 80, 739),
(3474, 'C', 60, 739),
(3475, 'D', 40, 739),
(3476, 'E', 20, 739),
(3537, 'A', 100, 746),
(3538, 'B', 80, 746),
(3539, 'C', 60, 746),
(3540, 'D', 40, 746),
(3541, 'E', 20, 746),
(3542, 'A', 100, 758),
(3543, 'B', 80, 758),
(3544, 'C', 60, 758),
(3545, 'D', 40, 758),
(3546, 'E', 20, 758),
(3562, 'A', 100, 742),
(3563, 'B', 80, 742),
(3564, 'C', 60, 742),
(3565, 'D', 40, 742),
(3566, 'E', 20, 742),
(3572, 'A', 100, 745),
(3573, 'B', 80, 745),
(3574, 'C', 60, 745),
(3575, 'D', 40, 745),
(3576, 'E', 20, 745);

-- --------------------------------------------------------

--
-- Table structure for table `assignments_grade_categories`
--

CREATE TABLE IF NOT EXISTS `assignments_grade_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `category_marks` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=435 ;

--
-- Dumping data for table `assignments_grade_categories`
--

INSERT INTO `assignments_grade_categories` (`id`, `category_name`, `category_marks`, `assignment_id`) VALUES
(55, 'q', 4, 310),
(234, 'cat', 23, 328),
(238, 'a', 1, 303),
(239, 'b', 2, 303),
(240, 'new cat', 55, 303),
(245, 'aaa', 45, 313),
(254, 'testercat', 23, 390),
(273, 'category', 34, 435),
(275, 'aaa', 12, 426),
(290, 'Default', 0, 213),
(292, 'cat', 2, 451),
(293, 'Default', 0, 462),
(294, 'Default', 0, 463),
(295, 'Default', 0, 464),
(296, 'Default', 0, 465),
(297, 'Default', 0, 466),
(299, 'Default', 0, 476),
(300, 'Default', 0, 477),
(302, 'Default', 0, 446),
(304, 'Default', 0, 448),
(305, 'Default', 0, 449),
(306, 'Default', 0, 418),
(307, 'c', 2, 511),
(313, 'Default', 0, 520),
(314, '4', 5, 511),
(315, 'Default', 0, 447),
(316, '5', 5, 444),
(325, 'category', 235, 565),
(326, 'category', 235, 0),
(327, 'category', 223, 580),
(328, 'new cat', 34, 588),
(329, 'new cat name', 26, 596),
(333, 'creative', 23, 605),
(334, 'Default', 25, 613),
(336, 'Default', 90, 621),
(340, 'Answering the question', 40, 629),
(341, 'Grammar', 20, 629),
(342, 'Style & Structure', 40, 629),
(346, 'Grammer', 20, 638),
(347, 'Style', 20, 638),
(348, 'Content', 60, 638),
(352, 'Grammar', 40, 647),
(353, 'Style', 40, 647),
(354, 'Content', 20, 647),
(355, 'Overall', 100, 656),
(360, 'Style', 20, 665),
(361, 'Technique', 15, 665),
(362, 'Programming Skills', 10, 665),
(363, 'Creativity', 10, 665),
(364, 'jungle', 36, 674),
(366, 'Grammar', 20, 682),
(367, 'Structure', 20, 682),
(368, 'Answering the Question', 60, 682),
(371, 'Colour', 40, 691),
(374, 'Overall Mark', 100, 692),
(377, 'Use of Shape', 40, 691),
(379, 'Spelling', 10, 613),
(380, 'Style', 20, 696),
(381, 'Structure', 30, 696),
(382, 'Content', 50, 696),
(383, 'Knowledge', 50, 705),
(384, 'Research', 20, 705),
(385, 'Spelling', 10, 705),
(386, 'Default', 0, 714),
(393, 'Quality of Photo', 20, 723),
(394, 'Timing', 10, 723),
(395, 'Symmetry', 50, 723),
(396, 'Gammar', 20, 725),
(397, 'Picture', 80, 725),
(398, 'Grammar', 40, 734),
(399, 'Default', 0, 735),
(400, 'Default', 0, 736),
(401, 'Default', 0, 737),
(402, 'Default', 100, 739),
(403, 'Default', 0, 740),
(404, 'Default', 0, 741),
(405, 'Default', 0, 742),
(406, 'Default', 0, 743),
(407, '666', 80, 745),
(409, 'Default', 20, 746),
(410, 'Default', 0, 748),
(412, 'Default', 10, 749),
(415, 'Structure', 40, 734),
(416, 'Answering the Question', 20, 734),
(417, 'one', 20, 749),
(418, 'Default', 0, 756),
(419, 'Default', 0, 757),
(420, 'Structure', 20, 758),
(424, 'Default', 0, 760),
(428, 'Style', 20, 758),
(429, 'Content', 50, 758),
(430, 'Hand in on time', 10, 758),
(432, 'Default', 0, 761),
(433, 'Quality of Slide', 20, 763),
(434, 'fun', 9, 745);

-- --------------------------------------------------------

--
-- Table structure for table `assignments_marks`
--

CREATE TABLE IF NOT EXISTS `assignments_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pagesnum` int(11) DEFAULT NULL,
  `screens_data` text,
  `total_evaluation` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=227 ;

--
-- Dumping data for table `assignments_marks`
--

INSERT INTO `assignments_marks` (`id`, `pagesnum`, `screens_data`, `total_evaluation`, `assignment_id`, `resource_id`) VALUES
(200, 3, '[{"items":[{"unique_n":1,"has_area":true,"comment":"1","width":100,"height":100,"left":200,"top":60,"cat":"328","evaluation":"12"},{"unique_n":2,"has_area":false,"comment":"2","width":100,"height":100,"left":0,"top":0,"cat":"328","evaluation":"1"},{"unique_n":3,"has_area":false,"comment":"koko","width":100,"height":100,"left":0,"top":0,"cat":"328","evaluation":"2"},{"unique_n":4,"has_area":false,"comment":"x","width":100,"height":100,"left":0,"top":0,"cat":"328","evaluation":"5"}],"picture":"589/160_1.jpg"},{"items":[],"picture":"589/160_2.jpg"},{"items":[],"picture":"589/160_3.jpg"}]', 20, 589, 160),
(201, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"ok","width":100,"height":100,"left":0,"top":0,"cat":"374","evaluation":"80"}],"picture":"gray_button_arrow.png"}]', 80, 0, 0),
(202, 0, '[{"items":[],"picture":"gray_button_arrow.png"}]', 0, 0, 0),
(209, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"","width":100,"height":100,"left":0,"top":0,"cat":"327","evaluation":"22"}],"picture":"gray_button_arrow.png"}]', 22, 581, 157),
(210, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"ww","width":100,"height":100,"left":0,"top":0,"cat":"329","evaluation":"4"}],"picture":"gray_button_arrow.png"}]', 4, 597, 158),
(211, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"late mark","width":100,"height":100,"left":0,"top":0,"cat":"328","evaluation":"12"}],"picture":"gray_button_arrow.png"}]', 12, 589, 161),
(212, 3, '[{"items":[{"unique_n":1,"has_area":false,"comment":"comment","width":100,"height":100,"left":0,"top":0,"cat":"336","evaluation":"80"},{"unique_n":3,"has_area":true,"comment":"more points about default category","width":100,"height":100,"left":278.5,"top":212,"cat":"336","evaluation":"2"}],"picture":"628/164_1.jpg"},{"items":[],"picture":"628/164_2.jpg"},{"items":[],"picture":"628/164_3.jpg"}]', 82, 628, 164),
(213, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Good response.  Got the main points across.","width":100,"height":100,"left":0,"top":0,"cat":"340","evaluation":"10"},{"unique_n":2,"has_area":false,"comment":"There and their still an issue we need to fix","width":100,"height":100,"left":0,"top":0,"cat":"341","evaluation":"15"},{"unique_n":3,"has_area":false,"comment":"Liking your answer","width":100,"height":100,"left":0,"top":0,"cat":"342","evaluation":"30"},{"unique_n":4,"has_area":false,"comment":"Very good","width":100,"height":100,"left":0,"top":0,"cat":"342","evaluation":"10"}],"picture":"gray_button_arrow.png"}]', 65, 636, 165),
(214, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Good work","width":100,"height":100,"left":0,"top":0,"cat":"352","evaluation":"40"},{"unique_n":2,"has_area":false,"comment":"Good work","width":100,"height":100,"left":0,"top":0,"cat":"353","evaluation":"40"},{"unique_n":3,"has_area":false,"comment":"Good work","width":100,"height":100,"left":0,"top":0,"cat":"354","evaluation":"20"}],"picture":"gray_button_arrow.png"}]', 100, 654, 168),
(215, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Just OK","width":100,"height":100,"left":0,"top":0,"cat":"353","evaluation":"35"},{"unique_n":2,"has_area":false,"comment":"OK","width":100,"height":100,"left":0,"top":0,"cat":"352","evaluation":"10"}],"picture":"gray_button_arrow.png"}]', 45, 654, 169),
(216, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Good","width":100,"height":100,"left":0,"top":0,"cat":"352","evaluation":"40"}],"picture":"gray_button_arrow.png"}]', 40, 654, 170),
(217, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"fff","width":100,"height":100,"left":0,"top":0,"cat":"347","evaluation":"10"},{"unique_n":2,"has_area":false,"comment":"fff","width":100,"height":100,"left":0,"top":0,"cat":"346","evaluation":"2"}],"picture":"gray_button_arrow.png"}]', 12, 645, 167),
(218, 0, '[{"items":[],"picture":"gray_button_arrow.png"}]', 0, 620, 162),
(219, 0, '[{"items":[],"picture":"gray_button_arrow.png"}]', 0, 214, 140),
(220, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"perfectly symmetrical","width":100,"height":100,"left":0,"top":0,"cat":"334","evaluation":"20"},{"unique_n":2,"has_area":false,"comment":"Poor spelling","width":100,"height":100,"left":0,"top":0,"cat":"379","evaluation":"3"}],"picture":"gray_button_arrow.png"}]', 23, 695, 171),
(221, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Marked","width":100,"height":100,"left":0,"top":0,"cat":"371","evaluation":"30"},{"unique_n":2,"has_area":false,"comment":"Marked","width":100,"height":100,"left":0,"top":0,"cat":"377","evaluation":"20"}],"picture":"gray_button_arrow.png"}]', 50, 693, 173),
(222, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Excellent photo - well done","width":100,"height":100,"left":0,"top":0,"cat":"393","evaluation":"15"},{"unique_n":2,"has_area":false,"comment":"10 minutes late","width":100,"height":100,"left":0,"top":0,"cat":"394","evaluation":"2"},{"unique_n":3,"has_area":false,"comment":"not very symmetrical","width":100,"height":100,"left":0,"top":0,"cat":"395","evaluation":"20"}],"picture":"gray_button_arrow.png"}]', 37, 724, 211),
(223, 0, '[{"items":[{"unique_n":1,"has_area":false,"comment":"Good","width":100,"height":100,"left":0,"top":0,"cat":"396","evaluation":"15"},{"unique_n":2,"has_area":false,"comment":"g","width":100,"height":100,"left":0,"top":0,"cat":"397","evaluation":"70"}],"picture":"gray_button_arrow.png"}]', 85, 732, 212),
(224, 0, '[{"items":[],"picture":"gray_button_arrow.png"}]', 0, 695, 172),
(225, 0, '[{"items":[],"picture":"gray_button_arrow.png"}]', 0, 752, 253),
(226, 0, '[{"items":[],"picture":"gray_button_arrow.png"}]', 0, 752, 254);

-- --------------------------------------------------------

--
-- Table structure for table `assignments_resources`
--

CREATE TABLE IF NOT EXISTS `assignments_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `is_late` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `assignment_id` (`assignment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `assignments_resources`
--

INSERT INTO `assignments_resources` (`id`, `resource_id`, `assignment_id`, `is_late`) VALUES
(2, 239, 744, 0),
(6, 253, 752, 0),
(7, 254, 752, 0),
(8, 255, 755, 0),
(9, 256, 755, 0),
(10, 257, 755, 0),
(11, 208, 756, 0),
(12, 208, 757, 0),
(13, 183, 758, 0),
(14, 208, 760, 0),
(15, 208, 761, 0),
(16, 178, 763, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `group_name` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=409 ;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `subject_id`, `year`, `group_name`) VALUES
(2, 1, 5, 'b'),
(3, 1, 6, 'c'),
(4, 1, 7, 'a'),
(6, 1, 4, 'aaa'),
(7, 2, 4, 'aaa'),
(8, 1, 5, 'a'),
(334, 8, 2, 'a'),
(335, 8, 2, 'b'),
(336, 8, 3, 'a'),
(337, 8, 3, 'b'),
(338, 8, 3, 'c'),
(339, 8, 3, 'd'),
(340, 8, 4, 'a'),
(341, 8, 4, 'b'),
(342, 8, 4, 'c'),
(343, 8, 4, 'd'),
(344, 8, 5, 'a'),
(345, 8, 5, 'b'),
(346, 8, 5, 'c'),
(347, 8, 5, 'd'),
(348, 8, 6, 'a'),
(349, 8, 6, 'b'),
(350, 8, 6, 'c'),
(351, 8, 6, 'd'),
(352, 1, 2, 'a'),
(353, 1, 2, 'b'),
(354, 1, 3, 'a'),
(355, 1, 3, 'b'),
(356, 1, 3, 'c'),
(357, 1, 3, 'd'),
(358, 1, 4, 'a'),
(359, 1, 4, 'b'),
(360, 1, 4, 'c'),
(361, 1, 4, 'd'),
(362, 1, 5, 'c'),
(363, 1, 5, 'd'),
(364, 1, 6, 'a'),
(365, 1, 6, 'b'),
(366, 1, 6, 'd'),
(367, 1, 2, 'c'),
(368, 1, 2, 'd'),
(369, 9, 2, 'a'),
(370, 9, 2, 'b'),
(371, 9, 3, 'a'),
(372, 9, 3, 'b'),
(373, 9, 3, 'c'),
(374, 9, 3, 'd'),
(375, 9, 4, 'a'),
(376, 9, 4, 'b'),
(377, 9, 4, 'c'),
(378, 9, 4, 'd'),
(379, 9, 5, 'a'),
(380, 9, 5, 'b'),
(381, 9, 5, 'c'),
(382, 9, 5, 'd'),
(383, 9, 6, 'a'),
(384, 9, 6, 'b'),
(385, 9, 6, 'c'),
(386, 9, 6, 'd'),
(387, 9, 2, 'c'),
(388, 9, 2, 'd'),
(389, 4, 2, 'a'),
(390, 4, 2, 'b'),
(391, 4, 3, 'a'),
(392, 4, 3, 'b'),
(393, 4, 3, 'c'),
(394, 4, 3, 'd'),
(395, 4, 4, 'a'),
(396, 4, 4, 'b'),
(397, 4, 4, 'c'),
(398, 4, 4, 'd'),
(399, 4, 5, 'a'),
(400, 4, 5, 'b'),
(401, 4, 5, 'c'),
(402, 4, 5, 'd'),
(403, 4, 6, 'a'),
(404, 4, 6, 'b'),
(405, 4, 6, 'c'),
(406, 4, 6, 'd'),
(407, 4, 2, 'c'),
(408, 4, 2, 'd');

-- --------------------------------------------------------

--
-- Table structure for table `content_page_slides`
--

CREATE TABLE IF NOT EXISTS `content_page_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT '0',
  `lesson_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '10000',
  PRIMARY KEY (`id`),
  KEY `interactive_lesson_id` (`lesson_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=127 ;

--
-- Dumping data for table `content_page_slides`
--

INSERT INTO `content_page_slides` (`id`, `title`, `text`, `template_id`, `lesson_id`, `active`, `order`) VALUES
(77, 'Symmetry', 'This is when a shape can be used with a mirror down the centre....', 0, 180, 1, 0),
(81, '', '', 0, 135, 1, 0),
(83, 'The Oceans of the World', 'The maps below shows the 4 major Oceans of the world.   How many of these did you know?', 0, 138, 1, 0),
(84, 'The Atlantic Ocean', 'The Atlantic Ocean is the world''s second largest ocean, behind the Pacific Ocean. With a total area of about 106,400,000 square kilometres, it covers approximately 20 percent of the Earth''s surface and about 29 percent of its water surface area. The first part of its name refers to Atlas of Greek mythology, making the Atlantic the "Sea of Atlas".', 0, 138, 1, 0),
(85, 'The Pacific Ocean', 'The Pacific Ocean is the largest of the Earth''s oceanic divisions. It extends from the Arctic in the north to theSouthern Ocean (or, depending on definition, to Antarctica) in the south, bounded by Asia and Australia in the west, and the Americas in the east.\nAt 165.25 million square kilometres (63.8 million square miles) in area, it covers about 46% of the Earth''s water surface and about one-third of its total surface area, making it larger than all of the Earth''s land area combined.  The Mariana Trench in the western North Pacific is the deepest point in the world, reaching a depth of 10,911 metres.', 0, 138, 1, 0),
(86, 'The Indian Ocean', 'The Indian Ocean is the third largest of the world''s oceanic divisions, covering approximately 20% of the water on the Earth''s surface.  It is bounded by Asia—including India, after which the ocean is named[ on the north, on the west by Africa, on the east by Australia, and on the south by the Southern Ocean.', 0, 138, 1, 0),
(87, 'The Southern Ocean', 'The Southern Ocean (also known as the Great Southern Ocean, Antarctic Ocean, South Polar Ocean and Austral Ocean) comprises the southernmost waters of the World Ocean, generally taken to be south of 60°S latitude and encircling Antarctica.[1] As such, it is regarded as the fourth-largest of the five principal oceanic divisions (after the Pacific,Atlantic, and Indian Oceans, but larger than the Arctic Ocean).  This ocean zone is where cold, northward flowing waters from the Antarctic mix with warmer subantarctic waters.\n\nIt also boasts some of the roughest seas in the world.', 0, 138, 1, 0),
(88, 'Video on the Worlds Oceans', 'Here''s a a video by Steven Fitzgerald who provides a good overview on the Worlds Oceans', 0, 138, 1, 0),
(99, 'first slide ', 'text here', 0, 207, 1, 10000),
(100, '', '', 0, 179, 1, 10000),
(109, 'What is Symmetry?', 'Symmetry is when one shape becomes exactly like another if you flip, slide or turn it.\n\nThe simplest type of Symmetry is "Reflection" (or "Mirror") Symmetry\n\nThere is also Rotational Symmetry and Point Symmetry.', 0, 259, 1, 2),
(110, 'Symmetry Examples', 'Let''s have a look at some examples of Symmetry.  The pictures below show the different types of Symmetry:', 0, 259, 1, 3),
(111, 'Question 1', 'Is this Symmetrical?', 0, 259, 1, 4),
(112, 'Question 2', 'Is this Symmetrical?', 0, 259, 1, 5),
(113, 'Question 4', 'Is this Symmetrical?', 0, 259, 1, 6),
(114, 'Questions 5', 'Lastly, is this one Symmetrical?', 0, 259, 1, 7),
(115, 'Group Activity', 'You all now need to break into groups of 4 and find something in the room that is Symmetrical?  Concentrate as you''ll need to do this later in your Homework Assignment.', 0, 259, 1, 8),
(116, 'Question 3', 'Is this Symmetrical?', 0, 259, 1, 1),
(117, 'My brand new slide', 'This slide is about symmetry', 0, 259, 1, 0),
(118, 'New slide for the demo', 'Lorem ipsum...', 0, 180, 1, 1),
(119, 'bytes', 'bytes server', 0, 180, 1, 2),
(120, 'Let''s look at how Facebook works?', 'Let''s have a look at how Facebook works', 0, 259, 1, 9),
(122, '', '', 0, 251, 1, 10000),
(123, 'dfgdfgdfgdfg', '', 0, 260, 1, 0),
(124, '', '', 0, 261, 1, 10000),
(125, 'ffффfdffgfggfddgggffdgfdg', '', 0, 261, 1, 10000),
(126, 'ffffffffff', 'fdsfdsfdsfds', 0, 260, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cont_page_resources`
--

CREATE TABLE IF NOT EXISTS `cont_page_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `cont_page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cont_page_id` (`cont_page_id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE IF NOT EXISTS `curriculum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL DEFAULT '0',
  `intro` text NOT NULL,
  `objectives` longtext NOT NULL,
  `teaching_activities` longtext NOT NULL,
  `assessment_opportunities` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`id`, `subject_id`, `year_id`, `intro`, `objectives`, `teaching_activities`, `assessment_opportunities`, `notes`, `publish`) VALUES
(1, 1, 5, 'wwwww', '<p>ewqeq</p>', '<p>qwewqe</p>', '<p>qwewqrwqer</p>', '<p>ewrwrew</p>', 1),
(2, 1, 6, 'math year 6', '<p>objectives</p>', '<p>activities</p>', '<p>opportunities</p>', '<p>notes</p>', 1),
(3, 1, 7, '', '', '', '', '', 0),
(4, 1, 8, '', '', '', '', '', 0),
(5, 1, 0, 'demo7890', '<p>hkj</p>', '<p>qwerty</p>', '<p>iuytre</p>', '<p>erwteyru</p>', 1),
(6, 2, 5, '', '', '', '', '', 0),
(7, 2, 6, '', '', '', '', '', 0),
(8, 2, 7, '', '', '', '', '', 0),
(9, 2, 8, '', '', '', '', '', 0),
(10, 2, 0, '', '', '', '', '', 0),
(11, 3, 5, '', '', '', '', '', 0),
(12, 3, 6, '', '', '', '', '', 0),
(13, 3, 7, '', '', '', '', '', 0),
(14, 3, 8, '', '', '', '', '', 0),
(15, 3, 0, '', '', '', '', '', 0),
(16, 20, 5, '', '', '', '', '', 0),
(17, 20, 6, '', '', '', '', '', 0),
(18, 20, 8, '', '', '', '', '', 0),
(19, 20, 0, '', '', '', '', '', 0),
(20, 5, 5, '', '', '', '', '', 0),
(21, 5, 6, '', '', '', '', '', 0),
(22, 5, 7, '', '', '', '', '', 0),
(23, 5, 8, '', '', '', '', '', 0),
(24, 5, 0, '', '', '', '', '', 0),
(25, 8, 5, '', '', '', '', '', 0),
(26, 8, 6, '', '', '', '', '', 0),
(27, 8, 7, '', '', '', '', '', 0),
(28, 8, 8, '', '', '', '', '', 0),
(29, 8, 0, '', '', '', '', '', 0),
(30, 21, 5, '', '', '', '', '', 0),
(31, 21, 6, '', '', '', '', '', 0),
(32, 21, 0, '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `interactive_assessments_slides`
--

CREATE TABLE IF NOT EXISTS `interactive_assessments_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `temp_data` text COLLATE utf8_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '10000',
  PRIMARY KEY (`id`),
  KEY `interactive_lesson_id` (`lesson_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=122 ;

--
-- Dumping data for table `interactive_assessments_slides`
--

INSERT INTO `interactive_assessments_slides` (`id`, `lesson_id`, `temp_data`, `order`) VALUES
(91, 138, 'a:1:{i:0;a:3:{s:20:"question_resource_id";s:0:"";s:13:"question_text";s:39:"What is the largest ocean in the World?";s:7:"answers";a:4:{i:0;a:2:{s:11:"answer_text";s:7:"Pacific";s:11:"answer_true";s:1:"0";}i:1;a:2:{s:11:"answer_text";s:6:"Indian";s:11:"answer_true";s:1:"0";}i:2;a:2:{s:11:"answer_text";s:8:"Southern";s:11:"answer_true";s:1:"0";}i:3;a:2:{s:11:"answer_text";s:8:"Atlantic";s:11:"answer_true";s:1:"0";}}}}', 0),
(92, 138, NULL, 0),
(93, 138, NULL, 0),
(94, 138, 'a:1:{i:0;a:2:{s:20:"question_resource_id";s:1:"2";s:13:"question_text";s:0:"";}}', 0),
(99, 165, NULL, 0),
(107, 0, NULL, 10000),
(108, 0, NULL, 10000),
(110, 0, NULL, 10000),
(111, 0, NULL, 10000),
(113, 0, NULL, 10000),
(114, 0, NULL, 10000),
(116, 0, NULL, 10000),
(117, 0, NULL, 10000),
(119, 0, NULL, 10000),
(120, 0, NULL, 10000),
(121, 0, NULL, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `key_words`
--

CREATE TABLE IF NOT EXISTS `key_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `key_words`
--

INSERT INTO `key_words` (`id`, `word`) VALUES
(1, 'pic'),
(2, ''),
(3, ''),
(4, 'audict'),
(5, 'adductor'),
(6, ''),
(7, 'facebook'),
(8, 'abv'),
(9, 'abv'),
(10, ''),
(11, ''),
(12, ''),
(13, ''),
(14, 'key'),
(15, ''),
(16, 'hike'),
(17, ''),
(18, ''),
(19, 'education'),
(20, ''),
(21, 'omg'),
(22, ''),
(23, ''),
(24, ''),
(25, ''),
(26, ''),
(27, ''),
(28, ''),
(29, ''),
(30, ''),
(31, ''),
(32, ''),
(33, ''),
(34, ''),
(35, ''),
(36, ''),
(37, ''),
(38, ''),
(39, 'sergio');

-- --------------------------------------------------------

--
-- Table structure for table `key_words_resources`
--

CREATE TABLE IF NOT EXISTS `key_words_resources` (
  `key_word` int(11) NOT NULL,
  `resource` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `key_words_resources`
--

INSERT INTO `key_words_resources` (`key_word`, `resource`) VALUES
(1, 238),
(2, 241),
(2, 242),
(4, 243),
(5, 244),
(3, 245),
(8, 247),
(6, 248),
(12, 246),
(13, 249),
(16, 250),
(15, 182),
(17, 216),
(19, 251),
(23, 219),
(37, 229),
(39, 252);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=281 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `teacher_id`, `title`, `intro`, `objectives`, `teaching_activities`, `assessment_opportunities`, `notes`, `module_id`, `published_lesson_plan`, `published_interactive_lesson`, `interactive_lesson_exists`, `active`, `teacher_led`, `running_page`, `order`) VALUES
(135, 1, 'Continents', 'Introduction to the 7 continents', 'Students will know how many continents there are, their location and be able to identify them on a map', 'Use of a world map to learn the 7 continents', 'Students will be assessed on identification of the 7 continents on a world map', '', 63, 1, 1, 1, 1, 0, 0, 10000),
(138, 0, 'Oceans', 'Identification of the world''s 5 oceans', 'By the end of this lesson students will be able to name and identify the 5 oceans', 'Use a world map to show the 5 continents', 'Use a blank world map to identify the oceans and then fill in the blanks', '', 63, 0, 0, 1, 1, 0, 7, 10000),
(139, 1, 'UK  and surrounding areas', '', 'name, locate and identify characteristics of the four countries and capital cities of the  United Kingdom and its surrounding seas', 'Map of the UK with capital cities identified and surrounding seas', 'Blank image of the UK to fill in blanks', '', 63, 0, 0, 1, 1, 0, 0, 10000),
(140, 10, 'United Kingdom', '', '', '', '', '', 66, 0, 0, 1, 1, 0, 0, 10000),
(141, 1, 'Weather Patterns', 'Identify seasonal and daily weather patterns in the United Kingdom and the location of  hot and cold areas of the world in relation to the Equator and the North and South  Poles', 'Students should understand the weather system in the UK and how this compares to the rest of the world', 'Review the UK weather systems and an overview of the worlds weather system', 'Students should be able to identify the impacts of a countries weather system', '', 73, 0, 1, 1, 1, 0, 0, 10000),
(144, 1, 'France', '', '', '', '', '', 66, 1, 0, 1, 1, 0, 0, 10000),
(145, 1, 'Society', '', '', '', '', '', 77, 0, 0, 0, 1, 0, 0, 10000),
(146, 1, 'Government and Military', '', '', '', '', '', 77, 0, 0, 0, 1, 0, 0, 10000),
(147, 1, 'The creation of Politics', '', '', '', '', '', 77, 0, 0, 0, 1, 0, 0, 10000),
(149, 1, 'Architecture and Engineering', '', '', '', '', '', 77, 0, 0, 0, 1, 0, 0, 10000),
(150, 1, 'Lead up to the war', '', '', '', '', '', 78, 0, 0, 0, 1, 0, 0, 10000),
(151, 1, 'Progress of WW1', '', '', '', '', '', 78, 0, 0, 0, 1, 0, 0, 10000),
(152, 1, 'Technology of WW1', '', '', '', '', '', 78, 0, 0, 0, 1, 0, 0, 10000),
(153, 1, 'Soldiers Experiences', '', '', '', '', '', 78, 0, 0, 0, 1, 0, 0, 10000),
(154, 1, 'Picasso', '', '', '', '', '', 79, 0, 0, 1, 1, 0, 0, 10000),
(155, 1, 'Monet', '', '', '', '', '', 79, 0, 0, 0, 1, 0, 0, 10000),
(157, 1, 'Common Animals', '', '', '', '', '', 81, 0, 0, 0, 1, 0, 0, 10000),
(158, 1, 'Types of Animals', '', '', '', '', '', 81, 0, 0, 0, 1, 0, 0, 10000),
(159, 1, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 10000),
(160, 1, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 10000),
(161, 1, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 10000),
(162, 1, 'France - Its Location and its History', 'Where is France and what is its History?', 'To provide a high-level overview of France and how it came to be the country it is today', 'We are going to review the world map and use this to explain its context in the world and some of the influences that have helped shaped what the country is today.', 'End of Class quiz', 'Trip to France to be discussed.', 83, 0, 0, 1, 1, 0, 0, 10000),
(163, 1, 'France - Its Location and its History', 'This is to provide a high-level view of France, its history and its place in the world today', 'To provide a high-level view of France, its history and its place in the world today', 'Use of Videos and Interactive maps to show the history', 'Interactive Assessment', 'Not at this stage', 85, 1, 0, 1, 1, 0, 0, 10000),
(164, 1, 'France - A look at it today', 'A look at France today, its cultures, importance, regional influences and its consistution', 'Learn and understand  France today, its cultures, importance, regional influences and its consistution', 'Use of Videos and Interactive maps to show the history', 'Interactive Assessment', 'Not at this stage', 85, 0, 0, 1, 1, 0, 0, 10000),
(165, 28, 'Vagner - The Clash of the Titans', 'This is an introduction to the Vagner.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 86, 0, 0, 1, 1, 0, 0, 10000),
(167, 28, 'Mozart - The Shakespeare Composer', 'This is an introduction to Mozart.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 86, 0, 0, 0, 1, 0, 0, 10000),
(171, 1, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 10000),
(172, 28, 'Numbers up to Thouands', 'It is important that children understand how our number system works: that the digit furthest to the right has the lowest value. They should be able to read and write numbers in words and numerals and should be comfortable converting between the two. They should understand and use the terms ''digit'' (e.g. ''what is the value of this digit?'') and ''numerals'' (e.g. ''write two hundred and five in numerals''). They should understand that digits differ by a power of 10 depending on their position in a number; at this stage, it is sufficient for children to know that ten units make a ten, ten tens make a hundred etc and no formal multiplication by powers of 10 need be discussed. Column names are vital at this stage and children should get used to talking about ''units'', ''tens'', ''hundreds'' and ''thousands''. Children should have a sense of the size of very large and very small numbers. They should be challenged to think about numbers in context, e.g. where is 10 a big number (number of children in a family) or small number (number of children in a school).  They should consider where very large and very small numbers might be used and should be given opportunities to estimate.  Children should be encouraged to talk about their Maths thereby reading their numbers aloud as well as writing them.', 'The aim of this session is to cover the folliwing:\n - Converting between numerals and words, written and spoken\n - Place value - units, tens, hundreds and thousands\n - Use of commas\n - Significance of the number 10 in place value\n - Number sense - thousands\n - Using large numbers in context\n - Estimating\n - Arranging numbers up to thousands in size order\n - Arranging digits to make largest/smallest possible number', 'Throughout this Unit where children have a large number as a solution to a problem they could be encouraged to write it in figures and words. We return to these ideas in Unit 3 and extend them to consider numbers up to millions.', '- Children will be able to read and write numbers up to thousands in numerals and words\n - Children will understand that numbers are written in groups of three separated by commas (counting from the lowest value digit)\n - Children will understand that the groups of three numbers are read ''x hundred and y-ty z'' and that the comma is read  ''thousand''\n - Children will understand the idea of ''columns'' and will be comfortable with the column names ''units'', ''tens'', ''hundreds'' and ''thousands''\n - Children will understand the terms ''digit'' and ''numerals''\n - Children will be able to identify the value of a digit by considering its position in a number\n - Children will be able to order numbers up to thousands\n - Children will be able to arrange digits in order to make the largest and smallest possible number up to thousands\n - Children will understand that digits differ by powers of 10 depending on their location in a number', 'JM2 P1 Ex1.1: Writing numbers\nJM2 P2 Ex1.2: Place value and larger numbers\nBonus: JM2 P3 Ex1.3: Writing larger numbers in words\nBonus: JM2 P5 Ex1.4: Writing larger numbers in figures\nJM2 P7 Ex1.5 Qa-h: Ordering numbers \n10ticks Level 3 pack 1 P3-8: counting on and back in 1s, 10s, 100s. Starts v basic.\n10ticks Level 3 pack 1 P17,18: reading and writing numbers 1-1000\n10ticks Level 3 pack 1 P19-38: assorted place value worksheets. P36-38 best\nBonus: Coded 100 square - nrich. Reinforces place value and patterns in 100 squares\nHow would we count? - nrich - nice estimate/counting in 10s starter\nEstimating by grouping into tens - nrich - whole class activity\nThe Deca tree - nrich - nice starter/prep - place value\nOrdering digits 2 player game', 70, 1, 1, 1, 1, 0, 0, 0),
(177, 28, 'Introduction to Maths at the Dragon', 'Introduction to Maths at the Dragon', 'In the first couple of Maths lessons at the Dragon, we want to introduce children to the way in which we are going to teach them Maths. The idea is that we teach the fundamentals but we also encourage them to use and apply their skills as we go. We want children to be independent thinkers, to work systematically, to form and solve their own questions, to reflect on their answers and relate their findings to real life. Whilst we are teaching in mixed ability classes we will be differentiating by outcome: whilst children will be asked to complete problems to demonstrate understanding of the techniques we are covering, we will also be setting them open ended problems that children can take as far as they can. In these first couple of lessons, we set an open ended task to introduce children to this way of learning.', 'Magic Vs - nrich', 'To test that:\n - Children will work systematically\n - Children will persevere with problems\n - Children will make and test hypotheses\n - Children will attempt to generalise', 'Not at this stage', 70, 1, 1, 1, 1, 0, 0, 2),
(178, 28, 'Numbers up to millions and rounding', 'These learning objectives are very similar to those in Unit 1; this is intentional! It is so vitally important that children understand our number system that we revisit them here to ensure they were grasped last term and to take the ideas further into millions.', '• Converting between numerals and words, written and spoken\n• Place value - units, tens, hundreds, thousands, ten thousands, hundred thousands, millions\n• Use of commas\n• Significance of the number 10 in place value\n• Number sense - millions\n• Using large numbers in context\n• Estimating\n• Arranging numbers up to millions in size order\n• Arranging digits to make largest/smallest possible number\n• Purpose of rounding\n• Rounding to the nearest 10, 100 and 1000', 'Children have practised reading and writing numbers up to thousands in words and numerals and by taking the ideas on to millions, the idea of the ''groups of three'' should start to make more sense (each group of three digits is read exactly the same and they are differentiated between by the comma; e.g. 234,234,234 ''two hundred and thirty four million, two hundred and thirty four thousand, two hundred and thirty four''). They have been introduced to the terms ''digit'' and ''numerals'' but it is important to remind the children formally what these words mean. We have discussed the fact digits differ by a power of 10 depending on their position in the number and this should be reinforced here, perhaps again using Dienes. Column names should be revisited and added to with ''ten thousands'', ''hundred thousands'' and ''millions'' (and beyond for higher groups if time). They have not yet used the < and > signs which are introduced here. Some children like the ''greedy crocodile'' analogy (eats the bigger number) whilst others like to think about a ''wonky equals'' sign where the widest gap is at the biggest number. The terms ''greater than'' and ''less than'' should be used appropriately. Numbers should still be contextualised and children should be challenged to think of sentences where their number could be used (e.g. 1,432,566: ''I won £1,432,566 on the National Lottery this weekend''). Children will be rounding on this Unit and rounding may want to be considered together with these learning objectives. Children should continue to be encouraged to talk about their Maths and reading their numbers aloud is important (i.e. plenty of pair/group work as well as questioning by the teacher). Throughout this Unit where children have a large number as a solution to a problem they could be encouraged to write it in figures and words. \n\nThe idea of rounding should be grasped, in particular the purpose of rounding (real life situations should be discussed) and looking critically at the approximation of a number to decide whether it is reasonable.  Number lines should be avoided at this stage; it would be better to contextualise problems and work on number sense. Discussions should be had about why we might round numbers (e.g. rough cost of a jumper - £19.99 actually basically £20).', 'Children will be able to read and write numbers up to millions in numerals and words\nChildren will understand that numbers are written in groups of three separated by commas counted from the lowest value digit\nChildren will understand the use of ''columns'' and will be comfortable with the column names units, tens, hundreds, thousands, ten thousands, hundred thousands and millions (+ beyond for higher groups)\nChildren will understand the terms ''digit'' and ''numerals''\nChildren will be able to identify the value of a digit by considering its position in a number\nChildren will be able to order numbers up to millions\nChildren will be able to arrange digits to make the largest/smallest possible number up to millions\nChildren will understand that digits differ by powers of 10 depending on their location in a number\nChildren will use the < and > notation\nChildren will understand that sometimes an exact number is not needed and it is sufficient to use an approximation for that number\nChildren will understand and use the term ''round'' to mean give an approximation to a number (to give the number ''roughly'')\nChildren will understand that a rounded number must be a good approximation of that number\nChildren will be able to round numbers to the nearest 10, 100 and 1000', 'JM2 P3 Ex1.3: Writing larger numbers in words\nJM2 P5 Ex1.4: Writing larger numbers in figures\nJM2 P7 Ex1.5 Q1i-2z: Ordering numbers \nJM2 P9 Ex1.6: Summary exercise\n10ticks Level 3 pack 6 P3: rounding to the nearest 10\n10ticks Level 3 pack 6 P4: rounding to the nearest 100"\n10ticks Level 4 pack 3 P3,4: Reading, writing and ordering numbers\n10ticks Level 4 pack 3 P7: Rounding to the nearest 10, 100, 1000\n10ticks Level 4 pack 3 P9: Zap to zero place value game using calculator\n10ticks Level 3 pack 1 P43: using <,> and = sign (basic)\nAdvanced: Which scripts? - nrich\nOrdering digits 2 player game', 71, 1, 0, 1, 1, 0, 0, 0),
(179, 28, 'Poetry - Its origins and its magic', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 87, 0, 0, 1, 1, 0, 0, 0),
(180, 0, '4, 8 times tables; Mental subtraction by counting up', 'So far the children have been asked to learn the 2, 5 and 10 times tables. In this Unit they add the 4 and 8 times tables to their repertoire.', '• Recall of 4 and 8 times tables\n• Recall of the associated division facts\n• Tables squares e.g.\n• Commutativity of multiplication (e.g. 5x8=8x5)\n• Commutativity of the = sign (e.g. 5x4=20 and 20=5x4)\n• x and ÷ as inverses\n• Strategies for calculating 4 and 8 times tables (5x-1x, 10x-2x)\n• Subtraction by counting up\n• Subtraction using the ''number line'' method', 'They should be encouraged to spot patterns, perhaps with the use of a hundred square and ideally the children will be able to recall their 4 and 8 times table by the end of this half term. However, some children find recalling times tables particularly difficult so they should also be taught how to ''calculate'' their 4 and 8 times tables using knowledge they already have i.e. 4x7 = 5x7-7 and 8x6=10x6-2x6. These techniques require deeper understanding and lower groups should not be expected to recall the techniques but they can be used by the teacher to help the child reach the result (which will also help to improve the child''s mental arithmetic skills and number bonds). Tables square should also be used. The ultimate goal is that children will be as proficient with the corresponding division facts as with the multiplication facts but this is a big ask at this stage At the least, children should be aware that these facts are equivalent and they should accept that they are true; these are all revisited next year. Higher groups should be aiming to recall the division facts as well but rote learning should not be laboured!\n\nAs with mental addition from Unit 1, the technique of subtraction by counting up should develop understanding of place value as children will have to count up in units and tens. It also reinforces the concept of subtraction as ''difference''. Children should count up to the nearest ten, then count in tens, then up to the required number. E.g. 92-58: 58+2=60, 60+30=90, 90+2=92; 2+30+2=34. It would be a good idea to start simply e.g. 15-9 and 23-16 (i.e. begin with unit answers before moving on to tens and units). This will rely heavily/reinforce number bonds which were covered on Unit 1 and can be revisited here where necessary. Plenty of time should be spent on this and as with mental addition, children should be encouraged to do mental subtraction calculations in their heads throughout E-Block. Number lines v useful here.', 'Children should be able to recall their 4 and 8 times tables up to 12x\nChildren will understand that if 4x6=24 then 6x4=24 (commutative law of multiplication)\nChildren should be aware of the corresponding division facts (e.g. 4x6=24 so 24÷6=4 and 24÷4=6)\nChildren will be able to perform subtractions mentally by counting up\nChildren will be able to perform subtractions using the ''number line'' method', '10ticks Level 3 pack 6 P12: mental subtraction game for 2 players\n10ticks Level 3 pack 6 P15 and 16: addition and subtraction cross-numbers\n10ticks Level 4 pack 1 P4: mental addition and subtraction word problems\n10ticks Level 4 pack 1 P9-12: Addon-agons - 2 digit mental addition and subtraction\n10ticks Level 4 pack 1 P23,24: mental addition and subtraction wordsearch\n10ticks Level 4 pack 1 P32,33,34: mental subtraction and addition games for 2\n10ticks Level 3 pack 2 P36: 4 times table maze\n"JM2 P38 Ex4.4: Problem solving (word problems)\nJM2 P39 Ex4.5: Summary exercise\n11+A P81 Q2 and 3 - should be done orally"', 71, 1, 1, 1, 1, 0, 1, 1),
(207, 28, 'The Planet and the Continents', 'This is an introduction to the Planet and the Continents.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 100, 1, 0, 1, 1, 0, 0, 10000),
(209, 28, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 10000),
(210, 28, 'Introduction to fractions; adding fractions with the same denominator', 'This is the first time children have met fractions at the Dragon. It is essential to have a solid conceptual understanding of fractions.', '• Proper fractions only\n• Conceptual understanding of fractions\n• Diagrammatic representation of fractions\n• Fractions as part of a whole\n• Denominator - how many pieces something is split into\n• Numerator - how many pieces we have\n• Reading and writing fractions\n• Ordering unit fractions\n• Ordering fractions with a common denominator\n• Ordering non-unit fractions with different denominators using diagrams\n• Adding fractions with common denominators', 'Terminology such as ''dividing'' into pieces is good but the fact that the line in a fraction means divide should be completely avoided at this stage. It is vital that children understand that the denominator represents how many pieces something is shared into and the numerator is how many of those pieces we have. Only proper fractions should be considered and diagrams should be used throughout. All of these ideas are covered again next year so it is absolutely fine if children rely on diagrammatic representations thoughout - the emphasis is on the understanding here and not on the manipulation of fractions.\n\nDo not formalise the process of addition of fractions or teach it in a rote way; the point here is the conceptual understanding of addition of fractions. It is fine to use pictoral representations of fractions throughout and plenty of oral work should be done e.g. ''1 quarter plus 2 quarters makes 3 quarters''.  Children could record their additions using fraction notation and higher groups are likely to notice that the numerators are added and the denominators are not. That said, the emphasis should be contextual - that fifths can only be added to fifths, handbags can only be added to handbags, dogs can only be added to dogs...', 'Children should understand that a fraction is part of a whole number\nChildren should understand that the denominator represents the number of pieces something has been cut into\nChildren should understand that the numerator represents how many pieces we have\nChildren will be able to read fractions properly (e.g. 2/3 ''two thirds'', 5/8 ''five eigths'', halves, quarters)\nChildren will be able to place unit fractions (different denominators) in size order\nChildren will be able to place fractions with the same denominator in size order\nChildren will be able to place fractions with different denominators in size order by considering diagrammatic representations of the fractions\nChildren will understand that only fractions with the same denominator can be added\nChildren will be able to add fractions with the same denominators (proper fractions giving proper fraction answers)', '10ticks Level 3 pack 4 P18-22: identifying fractions from diagrams and colouring diagrams\n10ticks Level 4 pack 4 P4: identifying fraction from diagram\n10ticks Level 3 pack 4 P26: ordering fractions using diagram of fraction tiles\n10ticks Level 3 pack 4 P37-40: ordering fractions using diagrams\n10ticks Level 4 pack 4 P3: comparing fractions using diagram of fraction tiles\n10ticks Level 3 pack 4 P31: identifying fraction of object circled; complementary fractions (pairs of fractions that make a whole)\n10ticks Level 4 pack 4 P9: complementary fractions (diagrams and written)\n10ticks Level 4 pack 4 P10: adding fractions with common denominator\nJM2 P130 Ex13.4 and P133 Ex13.6: Ordering fractions - using fractions tiles NOT by using equivalent fractions', 103, 0, 0, 0, 1, 0, 0, 2),
(211, 28, 'Angles and Time', 'There is no need to measure angles or use protractors here. This is the first time children have been introduced to the idea of angles at the Dragon and it is vital that they understand that angles are a measure of turn - a concept many children find tricky to grasp because they associate size with length or area.', '• Angles as a measure of turn\n• 360° in a full turn\n• Quarter, half and full turns\n• Right angles and notation\n• Quarter past and to times', 'Children need to be able to recognised a 90˚ angle and be able to label it using the correct notation. Some Historical background of why there are 360° in a circle is good - it helps children to remember why we use 360 and also ties in to ''Maths across the curriculum''. My take on this is that the Babylonians believed it took the sun 360 days to rotate around the Earth. Physical work like standing up and rotating 90° gives children a good sense of turn. Crocodiles are also good in helping children to understand what an angle is - particularly if you consider small and large crocodiles with their mouths open the same amount. Getting children to stand up and open their arms to 90˚ and 180˚ is good, particularly if they start with their arms together above their heads - this gives them a sense of angles being a measure of turn. It might be good to have the children identify 90˚ angles in the classroom or outside and you can certainly discuss whether an angle is smaller or larger than a right angle. ''Acute'' and ''obtuse'' need not be introduced here but can be with higher groups if you feel it is appropriate. Remember that the focus here is on the concecpt of angles and any extra information you give the children should not be in place of this. These ideas are covered again in D-Block but it is good to be able to introduce them here.\n\nWe continue to reinforce the telling of time on this Unit. Now we have discussed fractions, we start to talk about quarter past and quarter two times. This can be related to angles and quarter of a turn around the clock. Children should know that there are 60 minutes in an hour as we have covered this on Unit 1. They should also know that the long hand on the right hand side of the clock means ''past'' and on the left hand side means ''to''. Children are likely to find the telling of ''to'' times more challenging; once children have established whether it is quarter past or quarter to, the location of the little hand should be discussed and children should think carefully about the two numbers it lies between. Angles are the main focus this week and time should not be given too much lesson time.', 'Children will understand that an angle is a measure of turn\nChildren will understand that an angle is formed when two lines meet\nChildren will understand that the lengths of the rays do not affect the size of the angle\nChildren will recognise a quarter turn, half turn and full turn\nChildren will learn that there are 360° in a full turn\nChildren will learn that there are 180°in a half turn\nChildren will learn that there are 90° in a quarter turn\nChildren will learn that a quarter turn/90° angle is called a right angle\nChildren will use the right angle notation \nChildren will be able to tell the time on the quarter hour (quarter past and quarter to)\nChildren will understand that quarter of an hour is 15 minutes\nChildren will understand that quarter past two is the same as two fifteen (e.g.)\nChildren will be able to write quarter and half past and to and on the hour times in words and in digital form', '10ticks Level 3 pack 5 p3-6: Time\n10ticks Level 3 pack 6 P37: more than or less than a right angle? - use a set square or corner of sheet of paper, not protractor\n10ticks Level 3 pack 6 P38: marking right angles on diagrams and sorting shapes according to number of right angles', 103, 0, 0, 0, 1, 0, 0, 1),
(212, 28, 'Great Poets:  Philip Larkin', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 87, 0, 0, 1, 1, 0, 0, 1),
(213, 28, 'Great Poets: Shakespeare', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 87, 0, 0, 0, 1, 0, 0, 3),
(214, 28, 'Writing a Sonnet', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 87, 0, 0, 0, 1, 0, 0, 2),
(215, 28, 'Paragraphs & Structure', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 104, 0, 0, 0, 1, 0, 0, 0),
(216, 28, 'Use of Punctuation', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.\n\nThis field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 104, 0, 0, 0, 1, 0, 0, 1),
(217, 28, 'What is a work of Fiction?', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 105, 0, 0, 0, 1, 0, 0, 0),
(218, 28, 'What is Non-Fiction?', 'This is an introduction to the Lesson.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 105, 0, 0, 0, 1, 0, 0, 1),
(219, 28, 'Understanding your Voice', 'This is an introduction to your Voice and getting the most from it.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 106, 0, 0, 0, 1, 0, 0, 10000),
(220, 28, 'Singing Scales', 'This is an introduction to Vocal Scales.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 106, 0, 0, 0, 1, 0, 0, 10000),
(221, 28, 'Let''s Sing!', 'This lesson is all about actually Singing!  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 106, 0, 0, 0, 1, 0, 0, 10000),
(222, 28, 'The Orchestra', 'This is an introduction to a Musical Orchestra.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 107, 0, 0, 0, 1, 0, 0, 10000),
(223, 28, 'Woodwind', 'This is an introduction to the Woodwind part of an Orchestra.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 107, 0, 0, 0, 1, 0, 0, 10000),
(224, 28, 'Percussion', 'This is an introduction to the Percussion elements of an Orchestra.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 107, 0, 0, 0, 1, 0, 0, 10000),
(225, 28, 'Strings', 'This is an introduction to the Strings elements of an Orchestra.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 107, 0, 0, 0, 1, 0, 0, 10000),
(226, 28, 'Watercolour, Charcoal & Acrylics', 'This is an introduction different Drawing Techniques.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 108, 0, 0, 0, 1, 0, 0, 0);
INSERT INTO `lessons` (`id`, `teacher_id`, `title`, `intro`, `objectives`, `teaching_activities`, `assessment_opportunities`, `notes`, `module_id`, `published_lesson_plan`, `published_interactive_lesson`, `interactive_lesson_exists`, `active`, `teacher_led`, `running_page`, `order`) VALUES
(227, 28, 'What to Draw?', 'There are so many things to draw!  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 108, 0, 0, 0, 1, 0, 0, 1),
(228, 28, 'Famous Artists: The Renaissance Set', 'This is an introduction to the Renaissance painters.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 109, 0, 0, 0, 1, 0, 0, 0),
(229, 28, 'Famous Artists: Modern Art Genius', 'This is an introduction to Modern Art.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 109, 0, 0, 0, 1, 0, 0, 10000),
(230, 28, 'The Cheddar Man', 'This is an introduction to The Cheddar Man.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 110, 0, 0, 1, 1, 0, 0, 10000),
(231, 28, 'The Romans', 'This is an introduction to the Romans.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 110, 0, 0, 0, 1, 0, 0, 10000),
(232, 28, 'The Monarchs', 'This is an introduction to the UK Monarchy  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 110, 0, 0, 0, 1, 0, 0, 10000),
(233, 28, 'The British Empire', 'This is an introduction to the British Empire.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 111, 0, 0, 0, 1, 0, 0, 10000),
(234, 28, 'World War 1', 'This is an introduction to the World War 1.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 111, 0, 0, 0, 1, 0, 0, 10000),
(235, 28, 'World War 2', 'This is an introduction to World War 2.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 111, 0, 0, 0, 1, 0, 0, 10000),
(236, 28, 'Salutations and Numbers', 'This is an introduction to French Salutation and Counting.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 112, 0, 0, 0, 1, 0, 0, 10000),
(237, 28, 'Verbs', 'This is an introduction to the French Verbs.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 112, 0, 0, 0, 1, 0, 0, 10000),
(238, 28, 'Influences', 'Now we''re focusing on influences to the French language.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian..', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders', 112, 0, 0, 0, 1, 0, 0, 10000),
(239, 28, 'France', 'This is an introduction to France.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 113, 0, 0, 0, 1, 0, 0, 10000),
(240, 28, 'The People of France', 'This is an introduction to the People of France  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 113, 0, 0, 0, 1, 0, 0, 10000),
(241, 28, 'An introduction to Germany', 'This is an introduction to Germany.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 114, 0, 0, 0, 1, 0, 0, 10000),
(242, 28, 'Germany''s People & Traditions', 'This is an introduction to the People of Germany and their traditions.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 114, 0, 0, 0, 1, 0, 0, 10000),
(243, 28, 'Greetings and Numbers', 'This is an introduction to German greetings and numbers.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 115, 0, 0, 0, 1, 0, 0, 10000),
(244, 28, 'Tectonic Plates & Shifting Continents', 'This is an introduction to Tectonic plates.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 100, 0, 0, 0, 1, 0, 0, 10000),
(245, 28, 'Oceans of the World', 'This is an introduction to the worlds Oceans.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 100, 0, 0, 0, 1, 0, 0, 10000),
(246, 28, 'Volcanos', 'This is an introduction to Volcanos.  It will provide an overview of what Volcanos are, how they are formed, what different types of volcanos there are and what makes them erupt.  We''ll also be talking about some specific volcanos and where they are.', 'The Objective of this session is to cover the subject of Volcanos so that you can confidently talk about what they are and how they are formed.  You should be comfortable with explaining the different types of volcano that exist and where these are typically found.', 'We will be using videos and photos as well as class discussion to build our knowledge or Volcano''s.  I will also be asking small groups to come and draw their thoughts on the board.', 'A homework assignment will be given to the calls which will involved a drawing of a Volcano with self-researched labelling of key aspects of a Volcano.', 'Use the papier-mache volcano in Room 2.  See if we can link up with an Art project.', 116, 0, 0, 1, 1, 0, 0, 10000),
(247, 28, 'Earthquakes', 'This is an introduction to Earthquakes.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 116, 0, 0, 0, 1, 0, 0, 10000),
(248, 28, 'Coastal Erosion', 'This is an introduction to Coastal Erosion.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 116, 0, 0, 0, 1, 0, 0, 10000),
(249, 28, 'Glaciers', 'This is an introduction to Glaciers.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 116, 0, 0, 0, 1, 0, 0, 10000),
(250, 28, 'Hurricanes & Tornados', 'This is an introduction to Hurricanes and Tornados.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 116, 0, 0, 0, 1, 0, 0, 10000),
(251, 28, 'The Periodic Table', 'This is an introduction to the Periodic Table.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 117, 0, 0, 1, 1, 0, 0, 0),
(252, 28, 'Chemical Reactions', 'This is an introduction to Chemical Reactions.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 117, 0, 0, 0, 1, 0, 0, 1),
(253, 28, 'What are Experiments important?', 'This is an introduction to Experiments.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 118, 0, 0, 0, 1, 0, 0, 0),
(254, 28, 'How do you run an Experiment?', 'This is an introduction to running an experiment.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 118, 0, 0, 0, 1, 0, 0, 1),
(255, 28, 'Experiment 1 - Viewing PH Levels', 'In this lesson we will be experimenting with PH levels.  This should include the high-level details of the Lesson and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Lesson.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 118, 0, 0, 0, 1, 0, 0, 2),
(256, 28, 'Evens, odds and the two times table', 'Although children have undoubtedly been introduced to times tables in their previous schools, it should not be assumed that children know them and it is important to manage the learning of the tables in an organised way.', '- Recall of 2 times table\n - Recognition of even/odd numbers\n - Commutativity of multiplication (e.g. 2x3=3x2)\n - Counting up and back in 2s\n - Mental calculations involving doubling and halving\n - Forming and solving problems involving the 2 times table\n - Use of the term ''multiple''\n - Pattern spotting', 'Starting with the 2x table here should help to build confidence and to set the precedent for learning tables. It is important that children understand that 2x8=8x2 to pave the way for understanding of the commutativity of multiplication. This need not be discussed formally, but children should be happy to interchange 2x4 and 4x2 and realise that they are doing the same calculation. This is quite a tricky concept (that 2 fours is the same as 4 twos) and is introduced here to lay the foundations for later on and should not be overly-laboured here. Children may need to be convinced that 2 fours is the same as 4 twos and this can be done visually/practically. Orally, calculations should be rephrased by the teacher (e.g. ''what are 2 threes? Or what are 3 twos?''). Number squares will be particularly useful here with attention being drawn to the line of symmetry.\n\nMuch of Maths is about patterns and one of the most basic is even and odd numbers. It is alarming how many children don''t know whether a number is even or odd so it is important to cover it formally here. Number squares could be coloured to help illustrate the patterns (spotting patterns in the times tables helps to pave the way for formalising divisibility rules next year).', '- Making the largest 2 digit even number 2 player game - nrich (can also play solo online)\n - Making highest/lowest numbers including even/odd - nrich\n - 10ticks Level 3 pack 1 P9,11: odds and evens\n - 10ticks Level 3 pack 6 P5 section A and B: counting on and back in steps of 2\n - 10ticks Level 4 pack 2 p41,42: The odd pyramid - mental arithmetic all four operations depending on whether numbers are even/odd. Investigation.', 'None', 70, 0, 0, 0, 1, 0, 0, 4),
(257, 28, '''+ and -'' : Mental addition for separating tens and units', 'It shouldn''t be assumed that children are clear about  these basic operators. The focus here is not arithmetic but the concepts that underly it. Hands-on (or visual representation of) objects/counters can be useful for explaining the difference between + and - and plenty of different words should be used for both - children can brainstorm to develop their own list or could be asked to sort words on cards (sum and difference are two particularly important words that they may not have met before). They should also be asked to identify which calculation to perform in various word problems (but needn''t actually perform the calculation or could use calculators). Discussions should be had about whether the answer should be bigger or smaller depending on whether the calculation is + or -: it is important that we encourage children to look critically at their answers from the earliest age and by deciding whether an answer should be larger or smaller is a good first step. They could also use calculators to check answers: it is important that children understand early on that a calculator is a tool for checking and not a replacement for a brain!', '- Words for + and - including sum and difference\n - Conceptual understanding of + and -\n - Identifying the calculation to use in word problems\n - Appreciation of whether answer will be bigger/smaller number than the numbers in the calculation\n - Partitioning into tens and units\n - Understanding that only digits of the same magnitude can be added/subtracted (only tens can be added to tens, units to units)\n - Mental addition of 2 digit numbers\n - ''Number line'' method of addition', 'It is vital that children understand that 23=20+3 and that 23+46 means 2 tens plus four tens and 3 units plus 6 units. The emphasis here is on doing the addition mentally to reinforce the concepts we are trying to teach (i.e. place value). Formal written methods MUST NOT be brought in here; we must try to avoid any route that can turn to rote learning of algorithms in place of understanding - much better to get the understanding in place as well as developing mental arithmetic skills before introducing formal methods. There are quite a lot of ideas to be unpicked here and this topic should not be rushed. To begin with, start by adding units to tens and units e.g. 23+6; the unit+unit should not be greater than 9. Then try adding tens without units e.g. 23+40. Once these ideas have been grasped, then we move on to adding units so that the ten increases e.g. 23+9. Next tens and units such as 23+45 (unit+unit<10) before the most complicated e.g. 28+45. It may be best to do this work orally throughout e.g. ''what is 23+46? We have 2 tens and 4 tens, how many tens is that? We have 3 units and 6 units, how many units is that? What do we have altogether?'' Dienes blocks are excellent for ensuring understanding of place value and for these sort of calculations, particularly with lower ability children, but the ultimate goal is to be able to perform the calculations without the use of the blocks. Some recording may be useful and the ''number line'' method is good fo r this but children should record their work in whatever way is most useful to them - column arithmetic is certainly not appropriate here. Mental addition should be reinforced and encouraged throughout E-Block so that children are performing additions in their heads as second nature.', '- Children will understand the difference between  + and  -\n - Children will understand and use different language for + and - \n - Children will understand that tens can only be added to tens, units can only be added to units\n - Children will be able to add a pair of two digit numbers in their heads by separating the numbers into tens and units\n - Children will be able to add a pair of two digit numbers using the number line method', 'JM2 P14 Ex2.1: Counting in tens\nJM2 P15 Ex2.2: Counting in hundreds\nJM2 P16 Ex2.3: Counting in thousands\nJM2 P17 Ex2.4: Summary exercise\nBonus - JM2 P21 Ex3.1: Addition Q1-10 - partitioning into hundreds and thousands - should be done mentally\nAdvanced - JM2 P21 Ex3.1: Addition Q11-40 - mental addition by partitioning (should not be done formally)\nJM2 P25 Ex3.3: Addition word problems\nJM2 P44 Ex5.3: Addition and subtraction word problems - use a calculator (focus on identifying which operator to use and order of operations, not mental or formal arithmetic)\n10ticks Level 3 pack 6 P11: mental addition game for 2 players\n10ticks Level 4 pack 1 P3 - mental addition (middle section of sheet)\n10ticks Level 4 pack 1 P5,6 - mental addition pyramids\nbonus: Coded 100 square - nrich. Reinforces place value and patterns in 100 squares\nBrainstorm words for each of the operations and sort them into quadrants on the board/in their books', 70, 0, 0, 0, 1, 0, 0, 1),
(258, 28, 'Number Bonds and Months of the Year', 'It is important that children can work out what to add to a number in order to bring it up to the nearest ten; this will become particularly useful when doing mental subtraction calculations by counting up. Children should become proficient with spotting the ''bond'' (the complementary number that makes 10 e.g. 3 and 7, 4 and 6).', '• Recall of number bonds to 10\n• Recall of months in the year in order', 'Can all be done orally but some recording might be useful to help children learn their bonds.', 'Children will know their number bonds (pairs of numbers that sum to 10)\nChildren will know the sequence of months', 'Advanced - Alien counting - nrich. Number bonds which leads on to binary counting\nNumber bonds - individual computer based\n10ticks Level 3 pack 3 P3: assorted number bonds', 70, 1, 0, 0, 1, 0, 0, 3),
(259, 28, 'Symmetry', 'Because so much of Maths is about patterns, it is important to start to show children this early on. The emphasis here is on the understanding of symmetry and children being able to recognise whether a pattern is symmetrical rather than formally identifying lines of symmetry. Only patterns with one line of symmetry need be considered although you can go further with higher groups. It is important to try to develop children''s visualisation skills from early on so it is worth challenging children to work without folding/using a mirror at times as well.', '• Significance of patterns in Maths/real life\n• Reflective (line) symmetry\n• Visualisation skills\n• Real life examples', 'There are also other good visualisation activities that can be used here (unrelated to symmetry) which will help towards this goal. Real-life examples of symmetry are good to look at - in nature and in man-made objects such as buildings, art, street signs... Making snowflakes is always fun as are ''ink blot'' patterns. You could also tie this work back to the commutativity of multiplication (e.g. 2x6=6x2) so children can see the symmetry in this number work as well.', '• Children will understand that a line of symmetry is a line of reflection - that the shape is exactly the same but opposite on either side of the line, or that if folded down the line the shape fits over itself exactly\n• Children will be able to recognise whether a pattern is symmetrical or not\n• Children will be able to draw a line of symmetry on a pattern with one line of symmetry\n• Children will be able to complete a pattern to make it symmetrical either using a mirror, imagination or folding and tracing', 'JM2 P260 Ex23.3: Reflection\n10ticks Level 3 pack 6 P33,34: drawing lines of symmetry on diagrams', 70, 0, 0, 1, 1, 0, 0, 5);
INSERT INTO `lessons` (`id`, `teacher_id`, `title`, `intro`, `objectives`, `teaching_activities`, `assessment_opportunities`, `notes`, `module_id`, `published_lesson_plan`, `published_interactive_lesson`, `interactive_lesson_exists`, `active`, `teacher_led`, `running_page`, `order`) VALUES
(260, 28, 'd111244', 'In the last Unit, children considered + and - and in this they look at x and ÷. The emphasis here is that children understand the operations - they DO NOT need to learn written methods or even to be able to do x or ÷ calculations in their heads competently at this stage. The reason this is introduced here is to make sure that that children understand the vocabulary surrounding x and ÷ and to set them up for learning their times tables (and corresponding division facts). To begin with, it should be established that children fully understand what x and ÷ mean (x: groups of, ÷: sharing into a given number of groups). Hands-on (or visual representation of) objects/counters can be useful for explaining the difference between the operators and plenty of different words should be used for both - children can brainstorm to develop their own list or could be asked to sort words on cards (product is a particularly important word). They should also be asked to identify which calculation to perform in various word problems (but needn''t actually perform the calculation). Discussions should be had about whether the answer should be bigger or smaller depending on whether the calculation is x or ÷: it is important that we encourage children to look critically at their answers from the earliest age and by deciding whether an answer should be larger or smaller is a good first step. They could also use calculators to do some x and ÷ calculations: it is important that children understand early on that a calculator is a tool for checking and not a replacement for a brain, however, so they should be thinking about the size of the answer and looking critically at it if using calculators.', '<p>• Words for x and ÷ including product • Conceptual understanding of x and ÷ • Identifying the calculation to use in word problems • Appreciation of whether answer will be bigger/smaller number than the numbers in the calculation • Estimating the size of answers • Using a calculator • Meaning of the = sign (balance)</p>', '<p>It should not be assumed that children understand the = sign. Many children think that ''='' is an operator and think that it requires them to do something. Others think that it only applies to the number directly next to it (e.g. 12x3=30+6 childen would think that 12x3=30 and then 6 is being added as a separate calculation). Similarly children sometimes think that if you want to calculate 15+3-6 you can write 15+3=18-6=12. These problems persist right through the Upper School and should be addressed early on. Children should understand the = sign is like a balance that says whatever is on either side of it is the same as what is on the other. These ideas can be reinforced in the context of the 5, 10 times table (below) by getting children to write calculations such as 6x10=60, 60=6x10. All of these ideas are covered in more detail next year but it is very important not to perpetuate misconceptions and to ensure understanding of vital concepts early on. At the very least, the = sign should be discussed and any mistakes in the use of it should be picked up on and corrected.</p>', '<p>- Children will understand that ''multiply'' means replicate groups a certain number of times - Children will understand that ''divide'' means split into equal groups or ''share out'' equally - Children will understand the difference between x and ÷ - Children will understand and use different language for x and ÷ - Children will understand that the equals sign means ''the same as'' and not ''the answer is'' - Children will understand that what is on either side of an equals sign can be swapped (e.g. if axb=c then c=axb)</p>', '<p>JM2 P59 Ex6.9 and P73 Ex7.6- multiplication and division problems that can be done with a calculator. Emphasis should be on estimating the answer and reflecting on whether the answer given on the calculator looks reasonable JM2 P71 Ex7.5 - x and ÷ as inverses. Could be done using whiteboards (one number on each whiteboard, = on another and x and one with ÷ on the other side). Should be done mentally but calculators or table squares could be used with lower groups - remember the learning objective is the inverse functions, not the arithmetic 10ticks Level 3 pack 2 P24,25: single digit sums and products - good for learning difference between ''sum'' and ''product'' and practising tables</p>', 1, 1, 0, 1, 1, 0, 0, 0),
(261, 28, '5, 10 times tables and time', 'Whilst learning the 5 and 10 times tables continues to set the precedent for learning tables and also helps to build confidence with tables, the main reason for studying these tables is to introduce the ideas of inverse functions. Learning tables in the abstract is of little value - children need to learn them in a way that is useful to them. We use two of the easiest tables here  to begin to teach the children about inverse functions and what we have previous called ''tables families'' (e.g. if 2x5=10 then 5x2=10, 10÷2=5 and 10÷5=2). No formal language needs to be used at this stage (e.g. ''commutative'', ''inverse''); the emphasis should be on the ideas. Tables squares are good for pattern spotting and calculating inverse functions and, whilst learning of tables is preferable, for children who are struggling with this, they can be used throughout (the more valuable learning objectives are inverse operations and associating the multiplication and division facts). Some rote learning may be necessary but pattern spotting and use of tables squares should be prioritised to encourage understanding of the learning objectives. The 2x table can be brought back in here too as it was learnt on the last Unit. It is important that children can count on and back in 5s and 10s - this will help mental arithmetic and counting on and back in 10s will help with understanding of place value. Obviously this topic relates directly to the work on x and ÷  and the = sign that children did last week.', '• Recall of 5 and 10 times tables\n• Recall of the associated division facts\n• Recognising that numbers that end in 0 are in the 10 times table\n• Recognising that numbers that end in 5 or 0 are in the 5 times table\n• Commutativity of multiplication (e.g. 5x8=8x5)\n• Commutativity of the = sign (e.g. 5x4=20 and 20=5x4)\n• x and ÷ as inverses\n• Counting on and back in 5s and 10s\n• Counting on and back in 100s and 1000s - place value reinforcement\n• 60 seconds in a minute, 60 minutes in an hour, 12 hours in a day\n• Telling the time - half past and on the hour\n• Past and to\n• Time sense - length of a minute', 'This is the first time that we approach time telling with the children at the Dragon. It is alarming how few children can tell the time and it is important to take this in steady steps and not to try to tackle telling the time all at once. This is likely to be a tricky topic to teach as some children may be competent time tellers whilst it will be a completely new technique for others. Don''t be tempted to go beyond telling the time on the hour and half past as even in higher groups this will be completely new to some children. The ideas surrounding the telling of time are numerous and can be confusing if presented all at once. For example, the fact we say where the minute hand is before saying where the hour hand is (e.g. ten past two), the fact we don''t mention either ''hours'' or ''minutes'' in the time telling and that we work in base 12 and 60 counting systems are all non-intuitive. Time is revisisted throughout E-Block and children should be encouraged to look at the clock and tell the time as often as possible. It is important that children have a sense of time and it is good to let them know how long they have for given tasks and to show them a clock counting down/up on the board (digital) so that they get a sense of time. A great exercise is getting children to stand in front of their chairs with their eyes closed and get them to sit down when they think a minute has elapsed. This is great for developing a sense of time, ends lessons neatly (and is especially useful if you have a minute spare at the end of the lesson) - plus children really enjoy it! You can use this activity throughout the year, not just in this Unit. There is plenty of room for extension with time - for example, counting with different bases and binary - so please don''t pay lip-service to this topic if children are already competent with telling the time.', 'Children should be able to recall their 5 and 10 times tables up to 12x\nChildren will recognise that numbers in the 10x table end in 0\nChildren will recognise that numbers in the 5x table end in 0 or 5\nChildren will be able to count up and back in 5s and 10s (indefinitely!)\nChildren will understand that if 3x5=15 then 5x3=15 (commutative law of multiplication)\nChildren will understand that x and ÷ are inverse (opposite) functions\nChildren will understand that for every multiplication fact there are two corresponding division facts\nChildren should be able to recall the division facts for the 5 and 10 times tables (or else derive them from the corresponding multiplication fact)\nChildren will understand that there are 12 hours in a day\nChildren will understand that there are 60 minutes in an hour\nChildren will understand that the long hand points to the minutes and the short hand points to the hours\nChildren will understand that when reading the time we look at the minute hand first and then the hour hand\nChildren will be able to tell the time on the hour\nChildren will be able to tell the time on the half hour\nChildren will understand that any time between the hour and half past is a ''past'' time\nChildren will understand that any time between the half hour and the hour is a ''to'' time', 'JM2 P14 Ex2.1: Counting in tens\nJM2 P15 Ex2.2: Counting in hundreds\nJM2 P21 Ex3.1: Addition - do mentally/verbally\nJM2 P16 Ex2.3: Counting in thousands\nJM2 P17 Ex2.4: Summary exercise\n10ticks Level 4 pack 1 P39: 2 player game counting on and back in 10\n10ticks Level 3 pack 2 P37,38: 5 and 10 times table mazes\n10ticks Level 3 pack 2 P39: divisibility by 2 and 5 game for 2 players\nBonus: JM2 P243 End of chapter activity - Clock shapes\nAdvanced: JM2 P10 - End of chapter activity: Binary arithmetic; P18 End of chapter activity: More binary arithmetic', 1, 1, 0, 1, 1, 0, 0, 1),
(262, 28, 'Properties', 'Much of Maths is about pattern spotting and classifying according to properties and we want to introduce these ideas early on. The term ''property'' should be introduced here and children should be given the opportunity to sort according to a shared property (colour, size, favourite ice-cream flavour...).', '• Pattern spotting\n• Grouping according to common property\n• Venn and Carroll diagrams\n• Continuing sequences', 'There is plenty of opportunity for hands-on and kinesthetic work here (e.g. children can sort themselves into groups). Carroll diagrams and Venn diagrams are great for this as are coloured plastic shapes (sort according to number of sides and colour) or different size/colour counters. Throughout, the emphasis should be on using correct mathematical vocabulary and doing plenty of oral work. Some sequencing work could be introduced here (of the cognitive ability test type e.g. what is the next shape in this sequence:', 'Children will understand that a ''property'' is a feature/characteristic\nChildren will be able to group objects, numbers and shapes according to a shared property\nChildren will practise using correct vocabulary', '10ticks Level 3 pack 6 P45, 46: sorting into Venn diagrams', 1, 0, 0, 0, 1, 0, 0, 2),
(263, 28, 'Shapes', 'This is another opportunity for sorting using Carroll or Venn diagrams and can be incorporated into the work on properties described above. Children should know the names of shapes and know that to identify which shape it is they need to count the sides.', '• Properties of shapes - number of sides\n• Triangles, squares, rectangles, pentagons and hexagons\n• Properties of shapes - equal sides\n• Regular and irregular\n• Equilateral, isosceles and scalene triangles\n• Circles, semicircles and elipses', 'They should also know that any 5 sided shape is a pentagon (for example) and not just a regular pentagon. That said, they should begin to be able to recognise the regular shapes at a glance. They should think about different shapes in real life not just abstract drawings on a page. For higher groups (if time) the ideas about symmetry from the last Unit can be brought in and children can draw lines of symmetry onto their shapes. Types of triangles are included here and this is a good opportunity to discuss how to classify triangles depending on how many equal sides they have. This ties in nicely to the measuring work on this Unit.', 'Children will understand and use the term ''side'' correctly\nChildren will be able to identify and name a triangle, square, rectangle, pentagon, and hexagon by counting its sides\nChildren will understand that there are three types of triangle and these are classified depending on their side lengths\nChildren will understand that an equilateral triangle has all sides the same length\nChildren will understand that an isosceles triangle has two sides the same length\nChildren will understand that a scalene triangle has no sides the same length\nChildren will be able to identify a circle, semicircle and elipse\nChildren will use Venn and Carroll diagrams to sort shapes', '10ticks Level 3 pack 6 P27: classifying polygons and triangles\n10ticks Level 3 pack 6 P29: regular polygons\nBonus - using plastic shapes, get children to draw around them, name the shape and draw on any lines of symmetry\nAdvanced - as above but ask children to draw a table showing whether the shape is regular or irregular, how many sides and how many lines of symmetry - for regular polygons, the number of sides should be equal to the number of lines of symmetry', 1, 0, 0, 0, 1, 0, 0, 4),
(264, 28, 'Length', 'Emphasis should be on getting a feel for the size of different units and reading scales. Plenty of hands-on experience with trundle wheels, tape measures, metre rules and rulers should be encorporated.', '<p>&bull; Length: ''how far'' &bull; Size of mm, cm and m &bull; 10mm in a cm &bull; 100cm in a m &bull; Estimating length &bull; Using a ruler - measuring and drawing lines &bull; Converting mm to cm by x10 using 10 times table knowledge &bull; Measuring sides of polygons &bull; Using measuring equipment (rulers, tape measures, trundle wheels) &bull; Reading scales</p>', '<p>Activities should be contextualised and children should be given plenty of opportunities to get a sense of the size of a mm, cm and m. Children should be estimating and measuring to check. They should also be drawing lines as accurately as possible. Common mistakes with using a ruler include starting the measurement from the ''1'' rather than the ''0'' and ''parts'' of cm may become confusing (decimals should be avoided). This work relates to the 10x table and children should be able to apply their 10x table skills to convert mm to cm. Lower groups may find this more challenging. All multiplication by 10 should be done mentally and no discussion of ''moving up columns'' should be had here. Also the idea of ''adding a zero'' should be avoided - this technique fails with decimals and shows no understanding of place value. All multiplying by 10 should be contextualised within the 10x table that they have ''learnt'' on this Unit. This topic could be combined with the work on properties and the work on shape by asking children to sort shapes according to side length.</p>', '<p>Children will understand that distance/length means ''how far/long'' Children will have a sense of the size of 1mm, 1cm and 1m Children will understand that there are 10mm in 1cm Children will understand that there are 100cm in 1m Children will estimate length/distance Children will practise measuring length/distance using a range of measuring equipment (rulers, tape measures, trundle wheels) in a range of metric units (mm, cm and m) Children will be able to measure with a ruler accurately (to the nearest &frac12; cm) Children will be able to draw lines accurately with a rule (to the nearest &frac12; cm)</p>', '<p>10ticks Level 3 pack 6 P19, 20: measuring and drawing lines Bonus - 10ticks Level 4 pack 3 P31: measuring and drawing lines cm and mm 10ticks Level 3 pack 6 P21: converting m and cm 10ticks Level 3 pack 6 P22: converting km and m 10ticks Level 4 pack 3 P27: converting mm, cm and km Bonus: 10ticks Level 4 pack 3 P28: converting km/m, m/mm Advanced: 10ticks Level 4 pack 3 P33: adding and subtracting metric units; should be done mentally. Ties mental addition and metric measurements in nicely and is nice precursor to adding decimals</p>', 1, 1, 0, 0, 1, 0, 0, 5),
(265, 28, 'Perimeter', 'This builds on the measuring work from Unit 1 as well as mental addition, polygon names and multiplying by 5 and 10.', '• Definition of perimeter\n• Measuring side lengths of polygons\n• Triangles, squares, rectangles, pentagons, hexagons, heptagons, octagons, nonagons, decagons\n• Calculating perimeters of polygons by measuring one side and multiplying by the number of sides', 'Some confusion can arise between perimeter and area and this can be compounded if shapes are drawn on squared paper; children tend to count the squares that surround a shape rather than consider the side lengths. To avoid this, plain paper should be used and the focus should be on measuring the sides with a ruler. Getting children to write the length of each side of a shape on a diagram is important as is encouraging them to check their answers by making sure the number of lengths they have added is the same as the number of sides the shape has.', 'Children will understand that the perimeter of a shape is the distance around the outside of the shape.\nChildren will understand that the length of a side is a linear measurement (not counted in squares)\nChildren will develop their measuring skills by using a ruler to measure side lengths of shapes\nChildren will understand that the perimeter of a shape is the sum of the individual sides\nChildren will develop their mental addition skills by adding more than two numbers in their heads\nChildren will be able to calculate the perimeter of simple polygons\nChildren will recall the names of: triangle, square, rectangle, pentagon, hexagon\nChildren will learn the names of polygons with 7-10 sides: heptagon, octagon, nonagon, decagon\nChildren will calculate the perimeter of regular pentagons and decagons by measuring one side and multiplying by 5 and 10', 'Bonus: Compound shapes (straight sides only)\nFinding missing side lengths given perimeter\nJM2 P273 Ex25.2: Calculating length and width', 71, 1, 0, 0, 1, 0, 0, 2),
(266, 28, 'Pictograms; Months of the year and time', 'These last three topics are not connected but are shorter than the others so have been grouped together this week. \n\nPictograms should not be overly laboured. They are a precursor to bar charts which are covered in Unit 5 and are not used beyond Year 4. That said, they are often examined on standardised tests so children should be given the opportunity to work with them and interpret data/answer questions based on them.', '• Interpreting pictograms\n•  Collecting data and constructing pictograms\n• Number of days in each month\n• Time on the hour and half hour', 'The most important point to note is usually a shape represents more than one object (e.g. in a survey of favourite fruits, an orange may represent 4 people prefering oranges so a pictogram with 2½ oranges represents 10 people not 2½ people). This is the first time children have been given the opportunity to collect data. It should be arranged sensibly (probably using a table) and tallys could be introduced here if you like but this is not necessary. Conversations could be had about posing questions that could result in collection of data that can then be analysed (e.g. ''what is your favourite icecream flavour?'' or ''how tall are you?'' may result in 20 different answers whereas ''Do you like chocolate, strawberry, vanilla or mint icecream best?'' or ''how many pets do you have?'' would be more appropriate. You can take this topic as far as you like - even up to talking about discrete and continuous data if appropriate for your group.\n\nIt is really important that children know the number of days in each month. This could be learnt as a prep.\n \nTime on the hour and half-hour was taught on the last Unit and we take the ideas further on the next Unit. It is important to make sure that children keep telling the time at the front of their minds so although there is nothing new to teach here, it is important to check that children can still tell the time on the hour and half hour on this Unit. Again, this could be a prep exercise or something that is done verbally at the beginning of lessons.', 'Children will appreciate that a picture usually represents more than one unit\nChildren will be able to interpret data presented in the form of a pictogram\nChildren will be able to collect data and create their own pictograms\nChildren will know the rhyme ''30 days has September, April, June and November, all the rest have 31 except for February with 28 days clear and 29 in each leap year'' \nChildren will be able to tell the time on the hour\nChildren will be able to tell the time on the half hour', '10ticks Level 3 packs 6 P41, 42: pictograms', 71, 0, 0, 0, 1, 0, 0, 3),
(267, 28, 'New', 'New maths lesson', 'New maths lesson', 'New maths lesson', 'New maths lesson', 'New maths lesson', 70, 0, 0, 0, 1, 0, 0, 6),
(268, 28, '', '', '', '', '', '', 1, 0, 0, 1, 1, 0, 0, 3),
(269, 28, 'Exercises', '', 'The objective of this lesson is to carry out a series of exercises to help us understand fractions.', 'Exercises', 'Exercises', 'Not applicable at the moment', 103, 0, 0, 0, 1, 0, 0, 0),
(271, 28, 'lesson 1', 'intro', '', '<p>activities</p>', '<p>opportunities</p>', '<p>notes</p>', 121, 1, 0, 1, 1, 0, 0, 10000),
(272, 28, 'lesson', 'ewrwe', '<p>werew</p>', '<p>werew</p>', '<p>retret</p>', '<p>trewterwt</p>', 122, 1, 0, 0, 1, 0, 0, 0),
(273, 28, 'leson22', 'intro', '<p>eqweqweqw</p>', '<p>qwerqwrer</p>', '<p>qweqweqwewq</p>', '<p>qweqwrer</p>', 126, 1, 0, 0, 1, 0, 0, 0),
(274, 28, '33333', '432423432', '<p>ertrterte</p>', '<p>erterter</p>', '<p>retretretretrettret</p>', '<p>ertert</p>', 126, 1, 0, 0, 1, 0, 0, 1),
(275, 28, '33333', '432423432', '<p>ertrterte</p>', '<p>erterter</p>', '<p>retretretretrettret</p>', '<p>ertert</p>', 126, 1, 0, 0, 1, 0, 0, 2),
(276, 28, 'werwerew', 'rwtwet', '<p>werwetert</p>', '<p>ertertyreq</p>', '<p>weterterqw</p>', '<p>terttre</p>', 126, 1, 0, 0, 1, 0, 0, 3),
(277, 28, 'asdfgdsfgd', 'fdgdgdsgf', '<p>dfgdfgadg</p>', '<p>sdgsdgsdg</p>', '<p><em>sdgsdgsdsdgsg</em></p>', '<p>sdgsdagsdgs</p>', 126, 1, 0, 0, 1, 0, 0, 4),
(278, 28, 'd11155555', 'xvxzxvzxvzxzx', '<p>zxvxzczx</p>', '<p>zxvxzvxzvzx</p>', '<p>vzxvxczxv</p>', '', 124, 1, 0, 0, 1, 0, 0, 0),
(279, 28, '34567', 'dfgdfgfd', '<p>dfgfdgfd</p>', '<p>dsgdsgsd</p>', '<p>sdgsgsdg</p>', '<p>gsdsdgds</p>', 124, 1, 0, 0, 1, 0, 0, 1),
(280, 28, 'd11155555', '31231', '<p>123123</p>', '<p>123123</p>', '<p>12312313</p>', '<p>123123123</p>', 127, 1, 0, 0, 1, 0, 0, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `lessons_classes`
--

CREATE TABLE IF NOT EXISTS `lessons_classes` (
  `lesson_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`lesson_id`,`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lessons_classes`
--

INSERT INTO `lessons_classes` (`lesson_id`, `class_id`) VALUES
(116, 2),
(143, 1),
(143, 2),
(143, 3),
(166, 1),
(166, 6),
(170, 2),
(170, 3),
(170, 6),
(170, 8),
(177, 1),
(177, 6),
(180, 1),
(180, 6),
(181, 1),
(181, 6);

-- --------------------------------------------------------

--
-- Table structure for table `lessons_resources`
--

CREATE TABLE IF NOT EXISTS `lessons_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `lesson_id` (`lesson_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lessons_resources`
--

INSERT INTO `lessons_resources` (`id`, `resource_id`, `lesson_id`) VALUES
(3, 178, 260);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `objectives` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teaching_activities` text COLLATE utf8_unicode_ci NOT NULL,
  `assessment_opportunities` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `subject_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '10000',
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=127 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `intro`, `objectives`, `teaching_activities`, `assessment_opportunities`, `notes`, `publish`, `active`, `subject_id`, `order`, `year_id`) VALUES
(1, 'E2 - Properties, Length and Time', 'This Unit introduces children to the idea of ''properties''.  Much of Maths is about spotting patterns and in this Unit, children begin to classify shapes by considering the properties of a shape, in particular the number of sides it has.', 'We begin to formalise some of the basics including ensuring children understand exactly what x and ÷ actually mean as opposed to teaching them how to multiply and divide. We discuss the ''='' sign to avoid confusion; children often think ''='' means ‘and here', 'Here, they learn that ''='' means ''the same as'' and as such begin to understand the idea of commutativity (i.e. that if 2 + 3 = 5 then 5 = 2 + 3). Children practise using a ruler to measure and draw lines accurately and they learn about the basic metric measurements of length: mm, cm and m, practising estimating and measuring using a variety of measuring equipment. We begin to look at time, explaining the difference between ''past'' and ''to'', discussing the number of hours in a day, number of minutes in an hour and number of seconds in a minute.', 'Please see individual lessons', 'None', 1, 1, 1, 0, 1),
(63, 'Locational Knowledge', 'Pupils should develop knowledge about the world, the United Kingdom and their locality', 'name and locate the world’s seven continents and five oceans   name, locate and identify characteristics of the four countries and capital cities of the  United Kingdom and its surrounding seas', '', '', 'Location Knowledge Notes', 1, 1, 8, 10000, NULL),
(66, 'Place Knowledge', 'This module with cover the comparison of the UK with another European country and understand the differences.', 'understand geographical similarities and differences through studying the human and  physical geography of a small area of the United Kingdom, and of a small area in a  contrasting non-European country', 'Knowledge building of another country within Europe and discussion of how it compares with the UK', 'Compare and contrast another European country - Identify the major differences/similarities', '', 1, 1, 8, 10000, NULL),
(70, 'E1 - The Decimal Number System', 'We start simple this half-term, largely focussing on our number system, in particular understanding of ''columns'' or that where a digit is written determines its value (place value). We cover some absolute basics such as reading and writing numbers, number', 'It is essential that children start Maths at the Dragon feeling confident about their Maths and it is also vital that they have a solid understanding of how our number system works before we attempt to build on these foundations.  Cementing the basics als', 'We look at patterns in numbers, starting with considering even and odd numbers, before moving on to line symmetry and reflection, showing children that patterns are hugely important in mathematics. Children should know the sequence of the months of the year before the end of this half-term. Topics need not be followed in this order and you may wish to spend more/less time on different topics.', 'Plenty of focus should be put on problem solving and open-ended tasks, encouraging children to work systematically, persevere and think for themselves.', 'No calculators to be used until the 2nd Term', 1, 1, 1, 1, 1),
(71, 'E3: The decimal number system 2', 'This half-term’s work builds on the work from the beginning on the year, checking that our number system is understood, in particular place value (columns).', 'Children learn how to read and write larger numbers, focusing on digits being grouped in threes which can be read in the same way but are punctuated by ‘million’ and ‘thousand’ (e.g. 123,123,123: one hundred and twenty three million, one hundred and twent', 'We build on understanding and knowledge of shapes, looking at polygons with a larger number of sides and children learn about perimeter, calculating by measuring and adding mentally, and with regular polygons by measuring one side and multiplying by the number of sides. They look at pictograms, revisit time, ready to build on this next half-term, and learn the number of days in each month.', 'See individual Lessons', 'None', 1, 1, 1, 2, 1),
(73, 'Human and Physical Geography', 'Identify seasonal and daily weather patterns in the United Kingdom and the location of  hot and cold areas of the world in relation to the Equator and the North and South  Poles', ' use basic geographical vocabulary to refer to:   key physical features, including: beach, cliff, coast, forest, hill, mountain, sea,  ocean, river, soil, valley, vegetation, season and weather   key human features, including: city, town, village, fact', 'Use typical UK scenes to highlight the use of geographic terms', 'Use blank images to use these terms', '', 0, 1, 8, 10000, NULL),
(77, 'Roman Empire', '', '', '', '', '', 0, 1, 5, 10000, NULL),
(78, 'First World War', '', '', '', '', '', 0, 1, 5, 10000, NULL),
(79, 'Famous Artists', '', '', '', '', '', 0, 1, 4, 10000, NULL),
(81, 'Animals', '', 'Pupils should be taught to:  identify and name a variety of common animals including fish, amphibians, reptiles, birds and mammals identify and name a variety of common animals that are carnivores, herbivores and omnivores describe and compare the structu', 'Pupils will be taught through videos, practicals and images.', 'Practical Assessments, Quiz and experiment write ups will form the assessment for the module.', '', 0, 1, 9, 10000, NULL),
(84, 'Cubism', 'Cubism is the surrealist technique using large blocks and heavy colours to interpet form', '', '', '', '', 0, 1, 4, 10000, NULL),
(85, 'The History of France', 'An introduction to the History of France', 'An introduction to France, its history and its place in the world today', 'Discussion and use of text books, interactive globes and videos', 'Interactive Assessments & Presentations', 'Not at this stage', 0, 1, 6, 10000, NULL),
(86, 'Famous Composers', 'This is an introduction to a few Famous Composers. This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 3, 10000, 9),
(87, 'Poetry and famous Poets', 'This is an introduction to the Module.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian should a St', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Module Objectives.  This should be written in a way that should be viewable to a Parent or Guardian should', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 2, 0, 5),
(91, 'nmcli', '', '', '', '', '', 0, 1, 1, 10000, NULL),
(100, 'Global Geography', 'This is an introduction to Global Geography.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 1, 1, 8, 10000, 29),
(102, 'This is a new Module', 'This is a new Module', 'This is a new Module', 'This is a new Module', 'This is a new Module', 'This is a new Module', 0, 1, 6, 10000, 22),
(103, 'E4 - Fractions 1', 'Children meet fractions for this first time at the Dragon this half-term. The focus is on understanding what fractions mean, in particular that the denominator denotes how many equal pieces something is cut into and the numerator determines how many of th', 'To deepen this understanding, children will work with unit fractions (fractions where the numerator is 1), ordering them to understand that the larger the denominator, the smaller the fraction. They also order fractions with the same denominator to deepen', 'Diagrams are used throughout to support understanding. We consider angles on this Unit, explaining to children that angles are a measure of turn; not an immediately obvious concept to grasp when most experience of ‘size’ has been related to length or area. It is important that children understand that the length of the rays do not affect the size of the angle. They are introduced to full, half, and quarter turns and learn the correct vocabulary and notation for right-angles. We consider area as a measure of how much space something takes up and children count squares to help reinforce this idea and the idea that area is measured in square units. We continue to reinforce time-telling, this time by considering quarter past and quarter to times, relating this to right angles and degrees.', 'Please see individual lessons', 'None', 0, 1, 1, 3, 1),
(104, 'Writing Structures', 'This is an introduction to the Writing Structures module.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or G', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian should ', 'The Teaching Activities should include details of how the Lesson will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 2, 1, 5),
(105, 'Fiction v Non Fiction', 'This is an introduction to the Module.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 2, 2, 5),
(106, 'Singing', 'This is an introduction to Singing.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 3, 10000, 9),
(107, 'Musical Intruments', 'This is an introduction to different Musical Instruments.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or G', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 3, 10000, 9),
(108, 'Experimenting with Drawing', 'This is an introduction to Drawing and understanding the different tools and subjects you can used.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a wa', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 4, 0, 13),
(109, 'Famous Painters', 'This is an introduction to the worlds famous painters.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guar', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 4, 1, 13),
(110, 'A Brief History of Britain', 'This module will provide a very brief history of our Islands.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 5, 10000, 17),
(111, 'Modern History', 'This is an introduction to the British Empire.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 5, 10000, 17),
(112, 'The French Lanugage', 'This is an introduction to the French Language.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 6, 10000, 21),
(113, 'France and it''s People', 'This is an introduction to the France and its People.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guard', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 6, 10000, 21),
(114, 'Germany and it''s People', 'This is an introduction to Germany and it''s People.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardia', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 7, 10000, 25),
(115, 'German - Learning the basics', 'This is an introduction to the basics of the German language.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent ', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 7, 10000, 25),
(116, 'Physical Geography', 'This is an introduction to the Physical Geography.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 8, 10000, 29),
(117, 'The Elements', 'This is an introduction to the Chemical Elements.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 9, 0, 33),
(118, 'Experiments', 'This is an introduction to Experiments.  This should include the high-level details of the Module and the Subjects that will be covered.  This should excite the reader but also be written in a way that should be viewable to a Parent or Guardian.', 'The Objectives should state the key aims of the Module.  These would in effect be used in a Plenary session and the aim would be to satisfy these Learning Objectives.  This should be written in a way that should be viewable to a Parent or Guardian.', 'The Teaching Activities should include details of how the Module will be taught and what activities the students will be asked to do.  This should be written in a way that should be viewable to a Parent or Guardian should a Student wish to share this.', 'The Assessment Opportunities will not be shared with the Students.  It should provide a view of what Assessments can be set to determine understanding of the students.  This can be in-lesson Assessments or Homework activities to be set.', 'This field is available for notes.  This is only available to the teacher.  This can be used to add feedback or notes to support the actual teaching activity and lesson, like reminders.', 0, 1, 9, 1, 33),
(121, 'test 6 years', 'intro', 'objectives', 'activities', 'opportunities', 'notes', 1, 1, 1, 10000, 2),
(122, 'testing', 'intro', 'obj', 'activ', 'assessment', 'notes here', 1, 1, 1, 4, 1),
(124, 'tgry', 'rtyrt', 'tryrt', 'rtyrtyrt', 'yrty', 'rtyrty', 1, 1, 1, 5, 1),
(126, 'ytutyu', 'yutyu', 'tyryttr', 'utyuyt', 'rtyrty', 'trytrytr', 1, 1, 1, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules_resources`
--

CREATE TABLE IF NOT EXISTS `modules_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `modules_resources`
--

INSERT INTO `modules_resources` (`id`, `resource_id`, `module_id`) VALUES
(1, 203, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `hot` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `int_assessment_id` int(11) NOT NULL,
  `question_text` text COLLATE utf8_unicode_ci NOT NULL,
  `resource_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `int_assessment_id` (`int_assessment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=159 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `int_assessment_id`, `question_text`, `resource_id`) VALUES
(158, 91, 'What is the largest ocean in the World?', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL DEFAULT '0',
  `resource_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `restriction_year` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_remote` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=258 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `teacher_id`, `resource_name`, `type`, `name`, `keywords`, `description`, `restriction_year`, `active`, `is_remote`, `link`) VALUES
(39, 1, '89ad2ff9467293e33296151d6d7c171d.jpg', 'ediface', 'Penguins', 'Penguins', 'ifjewwnnkf\nJOFJNWipvjsjsvnvs\nvn\nvvd#nvsn\novs', 'a:1:{i:0;s:1:"8";}', 1, 0, ''),
(46, 1, 'df7f7ef3b50be51aeed078b560a1293c.png', 'ediface', 'Ocean Map', 'Map, Oceans, Seas', 'Map of the World''s Oceans', 'b:0;', 1, 0, ''),
(59, 0, '8c7de7c75f05d082f2da00c491571d07.docx', 'ediface', 'Volcano.docx', '', '', '', 0, 0, ''),
(60, 0, '2264974891e2bc9b1a6423680d04797b.jpg', 'ediface', 'image.jpg', '', '', '', 0, 0, ''),
(66, 24, '6888f39ded6c6868b9e3ceaed062fba7.png', 'ediface', 'Indian Ocean', '', 'Map of the Indian Ocean', 'b:0;', 1, 0, ''),
(68, 24, '25d72ea568dff2e1b991e8dbcd76e051.jpeg', 'ediface', 'Rough Sea Picture', '', 'A picture of the Southern Ocean in rough conditions', 'b:0;', 1, 0, ''),
(75, 24, '4d5d844c93d260408f8c0f812e9034e7.png', 'ediface', 'Long Multiplication - Homework 1', '', 'Long Multiplication Homework', 'b:0;', 1, 0, ''),
(76, 0, 'dfd26eea84a06012bb7dad183d0cdad1.jpg', 'ediface', 'image.jpg', '', '', '', 0, 1, 'http://images.nationalgeographic.com/wpf/media-live/photos/000/687/cache/bonobo-congo-ziegler_68751_990x742.jpg'),
(77, 0, 'fe8c4299c61250d84bd74ebc9560dd7b.jpg', 'ediface', 'image.jpg', '', '', '', 0, 1, 'http://images.nationalgeographic.com/wpf/media-live/photos/000/687/cache/bonobo-congo-ziegler_68751_990x742.jpg'),
(78, 0, 'c7c8158e3b1548b9ed4a1a9c6ac34742.jpg', 'ediface', 'image.jpg', '', '', '', 0, 1, 'http://images.nationalgeographic.com/wpf/media-live/photos/000/687/cache/bonobo-congo-ziegler_68751_990x742.jpg'),
(79, 0, '7d63eb14745f1e503607f99a43ad1cf2.jpg', 'ediface', 'image.jpg', '', '', '', 0, 1, 'http://images.nationalgeographic.com/wpf/media-live/photos/000/687/cache/bonobo-congo-ziegler_68751_990x742.jpg'),
(80, 0, 'b0a0660779f1435c9ce323e4d8b9e19b.jpg', 'ediface', 'image.jpg', '', '', '', 0, 1, 'http://images.nationalgeographic.com/wpf/media-live/photos/000/687/cache/bonobo-congo-ziegler_68751_990x742.jpg'),
(104, 0, '1776ff1eec0176ce62d50d938ee05df5.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(105, 0, '133c6b87292a951abb34c467b4429c38.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(106, 0, '2569caee659f4a7a1fd0342ca583277e.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(107, 0, 'ff8ba00b7c04fbfb6ce416a25aee51ef.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(108, 0, 'a11b3e3cf1971ddc5f3b566cff307efc.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(109, 0, 'c39022d16bbd10beb52756bfa4059e90.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(110, 0, '152af2c7f59513ac45e4505233c616c3.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(111, 0, 'b946b59bbfd394ab400f62cb1b75aa2b.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(112, 0, '4b4d1a71a190dcece4eda5050f98314e.doc', 'ediface', 'Rado_Invoice_00002-110714.doc', '', '', '', 0, 1, ''),
(113, 0, '684e629d7b137e702a2f9b980e3eff89.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(114, 0, '390dfd343eee178b945518a621ccd151.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(115, 0, 'df0089d2b8e9a0ce6b7bc30effc567c7.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(116, 0, '066d0cf80f0b935473ed7ca178acbc6c.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(117, 0, '85cdef2bd450eab152e8f77811b99add.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(118, 0, 'bd463484d69b57df2658aad1fdbc2dea.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(121, 0, 'c92a1d3d8f0623c25dfff43574972f6b.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(122, 0, '5a94001eeefc7f3ac7098e899153cc47.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(131, 0, '92eab297290e4fc5dd2bb234785e9f65.jpg', 'ediface', 'Bruce-Lee.jpg', '', '', '', 0, 1, ''),
(132, 0, 'e5bd463ddedc35a23c931983d20d1b46.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(140, 0, '5f08578fb9667a7ad86b4eda7a50b8c0.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(141, 0, '6e6a9e9d181648c3ceb9fdd687819186.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(142, 0, '0eada737a3055f142a66e78459be9764.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(143, 0, 'a4436912ca7ae00c06eda7a217f28a8f.png', 'ediface', 'Screenshot_-_05222014_-_11:38:59_AM.png', '', '', '', 0, 1, ''),
(144, 0, 'a698e46aca4fb2211811b8065abb44ce.jpg', 'ediface', 'CAM00145.jpg', '', '', '', 0, 1, ''),
(145, 0, '82ddf17606b744f0a953f3455669b4f4.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(146, 0, '56be85e083e37c1f48acf4ffbf13fad8.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 1, ''),
(156, 0, 'e89ff53ced333646928e00db33995a05.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 0, ''),
(157, 0, '9e1efe9352f9dfc88ae82c0b8da717c7.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 0, ''),
(158, 0, '3626c79838709be9497a67ee05bc62a9.png', 'ediface', 'pg1.png', '', '', '', 0, 0, ''),
(160, 0, '1ac82c2995bda7d1a9c6110187624253.jpg', 'ediface', 'photo.jpg', '', '', '', 0, 0, ''),
(161, 0, '3f607cabeb37cb05b84e2139183f2cba.png', 'ediface', 'pg1.png', '', '', '', 0, 0, ''),
(162, 0, '1faa2b09d3d10fa4d65d556dafdd363e.jpg', 'ediface', 'CAM00145.jpg', '', '', '', 0, 0, ''),
(164, 0, '77971ab483c3b43bf915e5fab127bc55.jpg', 'ediface', 'CAM00145.jpg', '', '', '', 0, 0, ''),
(165, 0, '9fa07d72331e6241c6e1aa22ac74fe57.doc', 'ediface', 'Competitor_Reviews_-_Nearpod.doc', '', '', '', 0, 0, ''),
(166, 0, '2bef04259a0880c25cb978348766291f.doc', 'ediface', 'Competitor_Reviews_-_FireFly.doc', '', '', '', 0, 0, ''),
(167, 0, '40b1916e5480a917fc4bc7105962244b.doc', 'ediface', 'Competitor_Reviews_-_Nearpod.doc', '', '', '', 0, 0, ''),
(168, 0, '1c468844845d8e55ad7584f7d80e7a1a.doc', 'ediface', 'Competitor_Reviews_-_FireFly.doc', '', '', '', 0, 0, ''),
(169, 0, '8ff39435f9be953492b89d750cc4d2f2.doc', 'ediface', 'Competitor_Reviews_-_Nearpod.doc', '', '', '', 0, 0, ''),
(170, 0, 'adcfb46f56c591e438a39b36d7c2eee5.pptx', 'ediface', 'Icons_Changes.pptx', '', '', '', 0, 0, ''),
(171, 0, 'ffec74ef688a51c7f2bdbc8b5c1b77df.jpeg', 'ediface', 'tglkCCgV_400x400.jpeg', '', '', '', 0, 0, ''),
(172, 0, '82a785ab1877dedb1abd9d3cc32be512.JPG', 'ediface', 'IMG_3231.JPG', '', '', '', 0, 0, ''),
(173, 0, '5f94a2b5b16d5dbbb12c39dbcc5392f6.jpg', 'ediface', 'image.jpg', '', '', '', 0, 0, ''),
(174, 28, '', 'ediface', 'Maths - Magic vs C', '', 'Maths - Magic  vs C for decimal number systems', 'b:0;', 1, 1, 'http://nrich.maths.org/content/id/6814/magic vs C.png'),
(175, 28, '', 'ediface', 'First World War Summary in 6 minutes', '', 'This is a six minute video summary of the First World War with illustrations', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.youtube.com/watch?v=-3UjJ5kxiLI'),
(178, 28, '', 'ediface', 'Cold War summary in 9 minutes', '', 'This is a video summary of the cold war using illustrations', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.youtube.com/watch?v=wVqziNV7dGY'),
(179, 28, '', 'ediface', 'Second World War Summary in 7 minutes', '', 'This is a video summary of the Second World War using illustrations', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.youtube.com/watch?v=wvDFsxjaPaE'),
(180, 28, '', 'ediface', 'Multiplication with single digit multipliers', '', 'This is a video that describes the method of multiplication of numbers with single digit multipliers', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.youtube.com/watch?v=FJ5qLWP3Fqo'),
(181, 28, '', 'ediface', 'The earth 100 million years from now', '', 'This is a video about why the earth looks the way it does today and how it might look in 100 million years', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.youtube.com/watch?v=uGcDed4xVD4'),
(182, 28, '', 'video', 'Causes of the Second World War', '', 'This is a video describing the events from the end of the first world war that led to the second', 'b:0;', 1, 1, 'http://https://www.youtube.com/watch?v=tEpb2KQDH3g'),
(183, 28, '', 'ediface', 'Causes of the First World War', '', 'This is a video describing the lead up to the First World War', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.youtube.com/watch?v=b4wZNs5I1wI'),
(194, 0, '66e954946a80894d56a08fd8458e3382.jpg', '', 'big_61_14.jpg', '', '', '', 0, 0, ''),
(195, 28, '02a1f88891437f12af0f7f6ff05e12ed1416469253.jpg', 'img', 'Symmetry Image 1', '', 'This is a picture of a sunflower - a good example of symmetry in nature', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(197, 28, '189716bab3acc22c9f16d0d56dee09101416469353.jpg', 'img', 'Symmetry Image 2', '', 'This is an example of man made symmetry - the Taj Mahal', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(198, 28, '', 'video', 'Lines of Symmetry Video', '', 'This is a video giving an introduction to lines of symmetry', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://www.youtube.com/watch?v=pu2dcm8BlAo'),
(199, 28, '89bac6cb9eacf5e08ace3f531c2424df1416469822.jpg', 'img', 'Symmetry Image 5', '', 'This is an example of a symmetrical object - in this case a building', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(200, 28, 'dd6608d0d5dca8d3083524338367c35a1416469872.jpg', 'img', 'Symmetry Image 4', '', 'This is an example of symmetry - in this case two babies back to back', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(201, 28, '16ad5d6d20a978fdccc10b5d5cfe024b1416469911.jpg', 'img', 'Symmetry Image 3', '', 'This is an example of symmetry - in this case a door and two lamps', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(202, 28, 'd93cadd3ee303bd5b2b2d31c7df74cf01416469952.jpg', 'img', 'Symmetry Image 6', '', 'This is an example of symmetry', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(203, 28, '1f3ea8d1a1470ce71f8a5ad62c4e2f021416470248.jpg', 'img', 'Symmetry Example 2', '', 'This is an example of symmetry in nature', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(204, 28, '6df9bbb7969619756ceba4045f463c7c1416470324.JPG', 'img', 'Symmetry Example 1', '', 'This is an example of symmetry in nature', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(206, 28, '11d2656ebc1aaaae6d4659c56bed9fbc1416470442.jpg', 'img', 'Group Working Image', '', 'This is an image of a group working together', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(207, 28, '3adb2c540221a4022cf803baeae9e6931416470718.jpg', 'img', 'Symmetry Example 3', '', 'This is an example of symmetry', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 0, ''),
(208, 28, '', 'url', 'Computer Science for Fun', '', 'A site with some great computer science activities to bring computing to life.', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://www.cs4fn.co.uk/teachers/activities/'),
(209, 28, '', 'url', 'Bytes server', '', ' ystem to create HTM code on site', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://bytes/code'),
(210, 28, '', 'url', 'Duolingo', '', 'Learning languages can be fun with duolingo!', 'a:3:{i:0;s:1:"9";i:1;s:1:"8";i:2;s:1:"7";}', 1, 1, 'http://https://www.duolingo.com/'),
(211, 0, '9645a04536117b7ee712809ce3cfde9d.jpg', '', 'image.jpg', '', '', '', 0, 0, ''),
(212, 0, 'e8d98405fad52ba3e1679315db85c243.jpg', '', 'image.jpg', '', '', '', 0, 0, ''),
(213, 28, '', 'url', 'Facebook', '', 'Facebook', 'b:0;', 1, 1, 'http://https://www.facebook.com'),
(214, 28, '', '', '', '', '', 'b:0;', 1, 1, 'http://'),
(215, 28, '', '', '', '', '', 'b:0;', 1, 1, 'http://'),
(218, 28, '', '', '22222', '0', 'description dddeewww wwwwww wwwwwweeee eeeeee eeeee eeeeeeee', 'b:0;', 1, 1, 'http://1111'),
(220, 28, '', '', '', '0', '', 'b:0;', 1, 1, 'http://'),
(221, 28, '', '', '', '0', '', 'b:0;', 1, 1, 'http://'),
(228, 28, '', '', '123', '', 'dfsfdsfdsf dfdsfsd gfdgfdg fdgfdgfdgfdgfdgfgdfgfdgfd', 'b:0;', 1, 1, 'http://second.p1.stoysolutions.com/c2/index/resource/238'),
(230, 28, '', '', 'tplink', '', 'router dualband broadcast router router', 'b:0;', 1, 1, 'http://second.p1.stoysolutions.com/c2/index/resource/238'),
(239, 0, '4a580365078c57c6f3920d2fe3a98856.jpg', '', '91QFB2UZtuL._SL1500__.jpg', '', '', '', 0, 0, ''),
(241, 28, '', '', 'https test', '', 'testing https url posting', 'a:1:{i:0;s:1:"9";}', 1, 1, 'http://https://www.facebook.com/'),
(242, 28, '', '', 'https test', '', 'testing https url posting', 'a:1:{i:0;s:1:"9";}', 1, 1, 'http://https://www.facebook.com/'),
(244, 28, '38295bd90d9aecf0c49d2c5397e794281418983595.jpg', 'img', 'adductor', '', 'sdfdsf fdsf fdf dfsdfdsfds fddsfsdfdsf', 'b:0;', 1, 0, ''),
(253, 0, 'c33e83af5a4aaabd181b03e4b8bcd069.png', '', 'logo_login.png', '', '', '', 0, 0, ''),
(254, 0, 'ee48e0902ef38b0e40850af5d3c479a7.pptx', '', 'DEFECT_-_F2B_Line_Spacing.pptx', '', '', '', 0, 0, ''),
(255, 0, '3b963ce5e48c9e458202e68504f225f4.pptx', '', 'DEFECT_-_F2B_Line_Spacing.pptx', '', '', '', 0, 0, ''),
(256, 0, 'fe79b96527e1f7873d826018c9d9500c.pptx', '', 'DEFECT_-_F2B_Line_Spacing.pptx', '', '', '', 0, 0, ''),
(257, 0, 'c787eaf8dc4f2d95934290408213363b.png', '', 'logo_login_copy.png', '', '', '', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `student_classes`
--

CREATE TABLE IF NOT EXISTS `student_classes` (
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_classes`
--

INSERT INTO `student_classes` (`student_id`, `class_id`) VALUES
(2, 1),
(2, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(10, 8),
(22, 4),
(27, 1),
(27, 2),
(27, 3),
(27, 6),
(27, 7),
(344, 334),
(344, 352),
(344, 369),
(344, 389),
(345, 334),
(345, 352),
(345, 369),
(345, 389),
(346, 334),
(346, 352),
(346, 369),
(346, 389),
(347, 334),
(347, 352),
(347, 369),
(347, 389),
(348, 334),
(348, 352),
(348, 369),
(348, 389),
(349, 335),
(349, 353),
(349, 370),
(349, 390),
(350, 335),
(350, 353),
(350, 370),
(350, 390),
(351, 335),
(351, 353),
(351, 370),
(351, 390),
(352, 335),
(352, 353),
(352, 370),
(352, 390),
(353, 335),
(353, 353),
(353, 370),
(353, 390),
(354, 335),
(354, 367),
(354, 387),
(354, 407),
(355, 335),
(355, 367),
(355, 387),
(355, 407),
(356, 335),
(356, 367),
(356, 387),
(356, 407),
(357, 335),
(357, 367),
(357, 387),
(357, 407),
(358, 335),
(358, 367),
(358, 387),
(358, 407),
(359, 335),
(359, 368),
(359, 388),
(359, 408),
(360, 335),
(360, 368),
(360, 388),
(360, 408),
(361, 335),
(361, 368),
(361, 388),
(361, 408),
(362, 335),
(362, 368),
(362, 388),
(362, 408),
(363, 335),
(363, 368),
(363, 388),
(363, 408),
(364, 336),
(364, 354),
(364, 371),
(364, 391),
(365, 336),
(365, 354),
(365, 371),
(365, 391),
(366, 336),
(366, 354),
(366, 371),
(366, 391),
(367, 336),
(367, 354),
(367, 371),
(367, 391),
(368, 336),
(368, 354),
(368, 371),
(368, 391),
(369, 337),
(369, 355),
(369, 372),
(369, 392),
(370, 337),
(370, 355),
(370, 372),
(370, 392),
(371, 337),
(371, 355),
(371, 372),
(371, 392),
(372, 337),
(372, 355),
(372, 372),
(372, 392),
(373, 337),
(373, 355),
(373, 372),
(373, 392),
(374, 338),
(374, 356),
(374, 373),
(374, 393),
(375, 338),
(375, 356),
(375, 373),
(375, 393),
(376, 338),
(376, 356),
(376, 373),
(376, 393),
(377, 338),
(377, 356),
(377, 373),
(377, 393),
(378, 338),
(378, 356),
(378, 373),
(378, 393),
(379, 339),
(379, 357),
(379, 374),
(379, 394),
(380, 339),
(380, 357),
(380, 374),
(380, 394),
(381, 339),
(381, 357),
(381, 374),
(381, 394),
(382, 339),
(382, 357),
(382, 374),
(382, 394),
(383, 339),
(383, 357),
(383, 374),
(383, 394),
(384, 340),
(384, 358),
(384, 375),
(384, 395),
(385, 340),
(385, 358),
(385, 375),
(385, 395),
(386, 340),
(386, 358),
(386, 375),
(386, 395),
(387, 340),
(387, 358),
(387, 375),
(387, 395),
(388, 340),
(388, 358),
(388, 375),
(388, 395),
(389, 341),
(389, 359),
(389, 376),
(389, 396),
(390, 341),
(390, 359),
(390, 376),
(390, 396),
(391, 341),
(391, 359),
(391, 376),
(391, 396),
(392, 341),
(392, 359),
(392, 376),
(392, 396),
(393, 341),
(393, 359),
(393, 376),
(393, 396),
(394, 342),
(394, 360),
(394, 377),
(394, 397),
(395, 342),
(395, 360),
(395, 377),
(395, 397),
(396, 342),
(396, 360),
(396, 377),
(396, 397),
(397, 342),
(397, 360),
(397, 377),
(397, 397),
(398, 342),
(398, 360),
(398, 377),
(398, 397),
(399, 343),
(399, 361),
(399, 378),
(399, 398),
(400, 343),
(400, 361),
(400, 378),
(400, 398),
(401, 343),
(401, 361),
(401, 378),
(401, 398),
(402, 343),
(402, 361),
(402, 378),
(402, 398),
(403, 343),
(403, 361),
(403, 378),
(403, 398),
(404, 8),
(404, 344),
(404, 379),
(404, 399),
(405, 8),
(405, 344),
(405, 379),
(405, 399),
(406, 8),
(406, 344),
(406, 379),
(406, 399),
(407, 8),
(407, 344),
(407, 379),
(407, 399),
(408, 8),
(408, 344),
(408, 379),
(408, 399),
(409, 2),
(409, 345),
(409, 380),
(409, 400),
(410, 2),
(410, 345),
(410, 380),
(410, 400),
(411, 2),
(411, 345),
(411, 380),
(411, 400),
(412, 2),
(412, 345),
(412, 380),
(412, 400),
(413, 2),
(413, 345),
(413, 380),
(413, 400),
(414, 346),
(414, 362),
(414, 381),
(414, 401),
(415, 346),
(415, 362),
(415, 381),
(415, 401),
(416, 346),
(416, 362),
(416, 381),
(416, 401),
(417, 346),
(417, 362),
(417, 381),
(417, 401),
(418, 346),
(418, 362),
(418, 381),
(418, 401),
(419, 347),
(419, 363),
(419, 382),
(419, 402),
(420, 347),
(420, 363),
(420, 382),
(420, 402),
(421, 347),
(421, 363),
(421, 382),
(421, 402),
(422, 347),
(422, 363),
(422, 382),
(422, 402),
(423, 347),
(423, 363),
(423, 382),
(423, 402),
(424, 348),
(424, 364),
(424, 383),
(424, 403),
(425, 348),
(425, 364),
(425, 383),
(425, 403),
(426, 348),
(426, 364),
(426, 383),
(426, 403),
(427, 348),
(427, 364),
(427, 383),
(427, 403),
(428, 348),
(428, 364),
(428, 383),
(428, 403),
(429, 349),
(429, 365),
(429, 384),
(429, 404),
(430, 349),
(430, 365),
(430, 384),
(430, 404),
(431, 349),
(431, 365),
(431, 384),
(431, 404),
(432, 349),
(432, 365),
(432, 384),
(432, 404),
(433, 349),
(433, 365),
(433, 384),
(433, 404),
(434, 3),
(434, 350),
(434, 385),
(434, 405),
(435, 3),
(435, 350),
(435, 385),
(435, 405),
(436, 3),
(436, 350),
(436, 385),
(436, 405),
(437, 3),
(437, 350),
(437, 385),
(437, 405),
(438, 3),
(438, 350),
(438, 385),
(438, 405),
(439, 351),
(439, 366),
(439, 386),
(439, 406),
(440, 351),
(440, 366),
(440, 386),
(440, 406),
(441, 351),
(441, 366),
(441, 386),
(441, 406),
(442, 351),
(442, 366),
(442, 386),
(442, 406),
(443, 351),
(443, 366),
(443, 386),
(443, 406);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `logo_pic`, `publish`) VALUES
(1, 'Math', 'math.png', 1),
(2, 'English', 'english.png', 1),
(3, 'Music', 'music.png', 1),
(4, 'Art', '0', 0),
(5, 'History', 'french.png', 1),
(6, 'French', '0', 0),
(7, 'German', '0', 0),
(8, 'Geography', 'drama.png', 1),
(9, 'Chemistry', '0', 0),
(10, '', '0', 0),
(11, '', '0', 0),
(12, '', '0', 0),
(13, '', '0', 0),
(14, '', '0', 0),
(15, '', '0', 0),
(16, '', '0', 0),
(17, '', '0', 0),
(18, '', '0', 0),
(19, 'EdifaceTest', '0', 0),
(20, 'Test', 'french.png', 1),
(21, '123', 'art.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_years`
--

CREATE TABLE IF NOT EXISTS `subject_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `subject_years`
--

INSERT INTO `subject_years` (`id`, `subject_id`, `year`, `publish`) VALUES
(1, 1, 5, 1),
(2, 1, 6, 1),
(3, 1, 7, 1),
(4, 1, 8, 1),
(5, 2, 5, 1),
(6, 2, 6, 1),
(7, 2, 7, 1),
(8, 2, 8, 1),
(9, 3, 5, 0),
(10, 3, 6, 0),
(11, 3, 7, 0),
(12, 3, 8, 0),
(13, 4, 5, 0),
(14, 4, 6, 0),
(15, 4, 7, 0),
(16, 4, 8, 0),
(17, 5, 5, 0),
(18, 5, 6, 0),
(19, 5, 7, 0),
(20, 5, 8, 0),
(21, 6, 5, 0),
(22, 6, 6, 0),
(23, 6, 7, 0),
(24, 6, 8, 0),
(25, 7, 5, 0),
(26, 7, 6, 0),
(27, 7, 7, 0),
(28, 7, 8, 0),
(29, 8, 5, 0),
(30, 8, 6, 0),
(31, 8, 7, 0),
(32, 8, 8, 0),
(33, 9, 5, 0),
(34, 9, 6, 0),
(35, 9, 7, 0),
(36, 9, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE IF NOT EXISTS `teacher_classes` (
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`teacher_id`,`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher_classes`
--

INSERT INTO `teacher_classes` (`teacher_id`, `class_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 6),
(1, 7),
(1, 8),
(28, 1),
(28, 6),
(28, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=448 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `birthdate`, `timestamp`, `ip`, `user_type`, `student_year`, `last_seen`) VALUES
(1, 'teacher@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Test', 'Teacher', '2013-10-24', '2013-10-24 15:13:32', '95.111.90.14', 'teacher', 0, '0000-00-00 00:00:00'),
(2, 'student@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Test', 'Student', '2013-10-24', '2013-10-24 15:13:32', '95.111.90.14', 'student', 5, '2014-11-09 18:03:59'),
(4, 'jonstudent@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Jon', 'Parr (Student)', '1995-05-16', '2013-11-07 13:24:18', '', 'student', 5, '2014-02-22 18:29:00'),
(5, 'petestudent@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Peter', 'Phillips (Student)', '2012-11-03', '2013-11-07 13:24:18', '', 'student', 5, '0000-00-00 00:00:00'),
(6, 'ibestudent@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Ibe', 'Akoh (Student)', '2012-06-13', '2013-11-07 13:24:18', '', 'student', 6, '2014-05-16 16:26:55'),
(7, 'antonstudent@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Anton', 'Stoyanov (Student)', '2001-06-29', '2013-11-07 13:24:18', '', 'student', 6, '0000-00-00 00:00:00'),
(8, 'peteteacher@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Peter', 'Phillips', '2005-12-18', '2013-11-07 13:24:18', '', 'teacher', 0, '0000-00-00 00:00:00'),
(9, 'jonteacher@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Jon', 'Parr', NULL, '2014-02-22 12:03:30', '', 'teacher', 0, '0000-00-00 00:00:00'),
(10, 'ibeteacher@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Ibe', 'Akoh', NULL, '2014-02-22 12:03:46', '', 'teacher', 0, '0000-00-00 00:00:00'),
(11, 'antonteacher@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Anton', 'Stoyanov', NULL, '2014-02-22 12:04:16', '', 'teacher', 0, '0000-00-00 00:00:00'),
(22, 'system_user_1400587758@ediface.com', 'd31a9ea26c759edf0575f35f1adc8235', 'a', 'b', '0000-00-00', '2014-05-20 12:09:18', '', 'student', 7, '2014-05-21 10:58:01'),
(23, 'system_user_1401034662@ediface.com', 'd36ec5701f39dadbfd1e9990b337edae', '', '', '0000-00-00', '2014-05-25 16:17:42', '', 'student', 0, '2014-05-25 19:30:38'),
(24, 'liz@latymer.org', 'c4ca4238a0b923820dcc509a6f75849b', 'Ediface', 'Demo Teacher', NULL, '2014-06-02 18:27:51', '', 'teacher', 0, '0000-00-00 00:00:00'),
(25, 'student@latymer.org', 'c4ca4238a0b923820dcc509a6f75849b', 'Ediface', 'Demo Student', NULL, '2014-06-02 18:27:51', '', 'student', 5, '2014-06-09 16:24:42'),
(26, 'ibe@ediface.org', '45c7aabc92e9c46da224676f52e305aa', 'Ibe', '', '0000-00-00', '2014-09-16 14:09:16', '', 'teacher', 0, '0000-00-00 00:00:00'),
(27, 'student@ediface.org', 'e0d59fb6fa3ae695da5c9c3412ff760b', 'Student', '', '0000-00-00', '2014-09-17 08:04:47', '', 'student', 5, '2015-02-02 18:46:17'),
(28, 'teacher@ediface.org', '7d3f3f5edc71d40e270a57f32012e46f', 'Teacher', '', '0000-00-00', '2014-09-17 09:56:30', '', 'teacher', 0, '0000-00-00 00:00:00'),
(29, 'Email@ediface.org', '84add5b2952787581cb9a8851eef63d1', 'Password', 'First', NULL, '2014-12-08 22:47:52', '', 'student', 0, '0000-00-00 00:00:00'),
(344, 'Pupil001@ediface.org', '7d0c8b92e4738d93d3937970a019f845', 'Aletha', 'Hickle ', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(345, 'Pupil002@ediface.org', '7b37cb1603076edc92bd2a88cebc8ddc', 'Althea', 'Kucera', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(346, 'Pupil003@ediface.org', '6ad5391071ab1a729772b93f5ac35212', 'Andreas', 'Wesner', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(347, 'Pupil004@ediface.org', '2a08b76989f758b93ecf8968583d8f1b', 'Arica', 'Karpinski', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(348, 'Pupil005@ediface.org', 'f2b999c3f155de008e40dd6c93c2e073', 'Arielle', 'Pedro', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(349, 'Pupil006@ediface.org', 'c9c247df0a085f2d46e1432aca06a9d4', 'Barrett', 'Infante', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(350, 'Pupil007@ediface.org', '1d056595288965e0a3bf5cd0b6d5702d', 'Bong', 'Livermore', NULL, '2014-12-09 11:58:21', '', 'student', 2, '0000-00-00 00:00:00'),
(351, 'Pupil008@ediface.org', 'd48ccf44727e96db17ea84640b6e05d1', 'Buffy', 'Boggs', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(352, 'Pupil009@ediface.org', '9ccff79376264a357c2e88b43f02a587', 'Cami', 'Degregorio', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(353, 'Pupil010@ediface.org', '2cb18ad8bbc6de160ba50f768ff39daf', 'Carlota', 'Bassler', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(354, 'Pupil011@ediface.org', '08da5e0cd6d4e6e822ecfe3949ca6075', 'Cassi', 'Dills', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(355, 'Pupil012@ediface.org', 'f989944320b0797ebe4dd118880d13c4', 'Celestine', 'Apolinar', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(356, 'Pupil013@ediface.org', '40b2e4f7b506dd2db3b0223163c9e71f', 'Chara', 'Blauser', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(357, 'Pupil014@ediface.org', '29859e3164d267b43cf8f6ac9b5ac7a3', 'Charla', 'Batson', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(358, 'Pupil015@ediface.org', '3f55bdf3aefc33e57d89b40bab1774d0', 'Cinderella', 'Capetillo', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(359, 'Pupil016@ediface.org', 'bacc4d88b690c054bcf620afcb2d7931', 'Danna', 'Banas', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(360, 'Pupil017@ediface.org', '9a6767eac014118a5766f456bec2e3ac', 'Darci', 'Fernando', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(361, 'Pupil018@ediface.org', 'f92893ac16f28117c873d8ce81b5612d', 'Denisse', 'Furst', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(362, 'Pupil019@ediface.org', '5c7ed5cb4cc57b9a548ed61a93a132ab', 'Domenic', 'Self', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(363, 'Pupil020@ediface.org', '49ea12486e4364efd04c34d00a0ed075', 'Dorsey', 'Momon', NULL, '2014-12-09 11:58:22', '', 'student', 2, '0000-00-00 00:00:00'),
(364, 'Pupil021@ediface.org', '40ab49545e477a9e966699c8d0c2608f', 'Dwana', 'Sollars', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(365, 'Pupil022@ediface.org', '9862bb91c5e6c637187b93010df6da56', 'Eboni', 'Garth', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(366, 'Pupil023@ediface.org', 'ffad1bc2fb0c336bcabb2aa491f52e99', 'Elenore', 'Dane', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(367, 'Pupil024@ediface.org', 'eb888e1029a0199ab5303401061e2e0e', 'Elisha', 'Deschaine', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(368, 'Pupil025@ediface.org', 'd8119d10e3988d31dc2fd391c5a76e77', 'Emilie', 'Pippen', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(369, 'Pupil026@ediface.org', '923ea005758bd49982c70dad2b4aa87b', 'Emmanuel', 'Finlay', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(370, 'Pupil027@ediface.org', 'da9bc7a1ed7d79125e499b8d35ef8b0c', 'Fallon', 'Izzo', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(371, 'Pupil028@ediface.org', 'e07681e8e32ed0094705101848dd1b17', 'Frederica', 'Zang', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(372, 'Pupil029@ediface.org', 'd01566b466db03c9304734f3a4cbaa41', 'Gidget', 'Baham', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(373, 'Pupil030@ediface.org', 'e12ae7cbbc350fd2d477b2d55d6ef686', 'Gina', 'Luca', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(374, 'Pupil031@ediface.org', '3caf0dd3d45a77bc133d6e191da92706', 'Glady', 'Harshaw', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(375, 'Pupil032@ediface.org', '39240493355e282c48acefbaf45de735', 'Glenn', 'Waring', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(376, 'Pupil033@ediface.org', '8c55ee57a720bdee63a30ce3caf20298', 'Gregoria', 'Ohm', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(377, 'Pupil034@ediface.org', '999a6ad570eacbe5a8d5efc6a92e390e', 'Guy', 'Sipple', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(378, 'Pupil035@ediface.org', 'ae4a9e971ef619bded578c55f2d8a52a', 'Hal', 'Dinges', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(379, 'Pupil036@ediface.org', 'ccb3f0c5995dce847e0c7adf2bb74c35', 'Hildred', 'Melo', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(380, 'Pupil037@ediface.org', '015720eda7abc74ed69472942e8adecc', 'Hiroko', 'Canedy', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(381, 'Pupil038@ediface.org', '169009fd795278ab8980170f4b9823e4', 'Hortense', 'Nazario', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(382, 'Pupil039@ediface.org', 'dcd420543be8df7ee03aba3e08326c86', 'Jame', 'Temme', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(383, 'Pupil040@ediface.org', '798b99fadec9539f9bc824ff20308037', 'Janell', 'Schimpf', NULL, '2014-12-09 11:58:22', '', 'student', 3, '0000-00-00 00:00:00'),
(384, 'Pupil041@ediface.org', '65e0050816c4528efc0a059750ea210a', 'Jeanene', 'Branstetter', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(385, 'Pupil042@ediface.org', 'b3a00f48b201494acd25c2dd68f1cc5d', 'Jerrod', 'Hirth', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(386, 'Pupil043@ediface.org', 'eb4097c0c52929915165fdabf7d96c9d', 'Jill', 'Crigler', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(387, 'Pupil044@ediface.org', '4ab4405b3ed308ad0b3c210777df4633', 'Johnathan', 'Cogar', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(388, 'Pupil045@ediface.org', '8f8a6107553bed0a21ef1bec67e56dba', 'Jolene', 'Kovach', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(389, 'Pupil046@ediface.org', '8a52454f779c3cb6937a1952519e5d07', 'Kami', 'Stoughton', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(390, 'Pupil047@ediface.org', '27b722814e7c046c5349111452444da9', 'Katherine', 'Czajkowski', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(391, 'Pupil048@ediface.org', 'cb35fdb3733c0961ff00ee47689a5f84', 'Keiko', 'Hagins', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(392, 'Pupil049@ediface.org', '1988c783446b9c808183ecf1d056c73d', 'Kristian', 'Ketelsen', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(393, 'Pupil050@ediface.org', 'a03a91aaede59736cdcb4f78dee2247c', 'Kylee', 'Lanphere', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(394, 'Pupil051@ediface.org', '7e3d5eb4283a66adb38c3c86b7e7c769', 'Kymberly', 'Biermann', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(395, 'Pupil052@ediface.org', '2bd0d9db406b7a8c7582be319152b761', 'Lashawn', 'Demaria', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(396, 'Pupil053@ediface.org', '945b4ffbd591ee9953b24f53a2cb6589', 'Laveta', 'Scanlan', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(397, 'Pupil054@ediface.org', '83262760802008d376d975058d9f529f', 'Leandra', 'Barra', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(398, 'Pupil055@ediface.org', 'ef6bcb65cff035cf51b3adb3ee684bdb', 'Leatha', 'Poston', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(399, 'Pupil056@ediface.org', '242dd7513c17b237885d2d14dea251b0', 'Leisha', 'Whitely', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(400, 'Pupil057@ediface.org', 'c9f35d43364bf07bd4814ce02e16c856', 'Lesley', 'Lyman', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(401, 'Pupil058@ediface.org', '360522e97fba2a2724df4da90a9aed98', 'Maggie', 'Belgrave', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(402, 'Pupil059@ediface.org', 'b3636de9c67a2f1c1e96d651059f1509', 'Marietta', 'Naber', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(403, 'Pupil060@ediface.org', 'bf837d56b0c9aa865b97283a0d4c1f4b', 'Marissa', 'Hammon', NULL, '2014-12-09 11:58:22', '', 'student', 4, '0000-00-00 00:00:00'),
(404, 'Pupil061@ediface.org', '632261947efe325e6ca24429c932a3b3', 'Maryland', 'Benfer', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(405, 'Pupil062@ediface.org', '3b925bf262089b57462013ba866383ed', 'Merry', 'Mayes', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(406, 'Pupil063@ediface.org', '24635ddeffb88d6bd521cfd5e4312c22', 'Minerva', 'Kogan', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(407, 'Pupil064@ediface.org', '67be6d2e43700aac40621ed870f0fc72', 'Mirtha', 'Darrell', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(408, 'Pupil065@ediface.org', '6aa7289aa6de61b4128726199c8892a6', 'Monty', 'Delreal', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(409, 'Pupil066@ediface.org', '8984aaae4f9b9056f3bf654d52d865c3', 'David', 'Phillips', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(410, 'Pupil067@ediface.org', 'e61d333274f587dbf542c20fcb03086a', 'Nadia', 'Blodgett', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(411, 'Pupil068@ediface.org', '662c717393665ea916afd2cda5a32395', 'Nakisha', 'Snelson', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(412, 'Pupil069@ediface.org', 'ea4f561cdb228f29f34916512cdd08aa', 'Palmer', 'Rosenow', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(413, 'Pupil070@ediface.org', 'f7ccafdb491e43c6f9e7eefb1c6127d4', 'Regan', 'Mccarville', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(414, 'Pupil071@ediface.org', '34b5ddec6c7dab31d4dfcc56384e5fdd', 'Remona', 'Mclees', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(415, 'Pupil072@ediface.org', '324e999b1bd125454bef00b35b76a05d', 'Renaldo', 'Frappier', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(416, 'Pupil073@ediface.org', 'c792b0a5c0bcbf585ea4027578c82a53', 'Rodger', 'Webster', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(417, 'Pupil074@ediface.org', '4a172d60bd77ad52ed125dc51d66d5c1', 'Rodney', 'Defrank', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(418, 'Pupil075@ediface.org', '75e0759efa549af065ad2e64835a936a', 'Rosemarie', 'Coupe', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(419, 'Pupil076@ediface.org', '2b4581d827ea37811419386fd62984da', 'Rudolph', 'Holmen', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(420, 'Pupil077@ediface.org', 'f49c0c8b00b7a372fc1a9e4abf8a2e8c', 'Shaina', 'Schrack', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(421, 'Pupil078@ediface.org', '2976e80a15e7ede497991e4c990e6238', 'Shala', 'Roberie', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(422, 'Pupil079@ediface.org', '1a26df074765373a8c0acc541693a5ba', 'Shameka', 'Albert', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(423, 'Pupil080@ediface.org', '65fe57b528742a0d6ea5d2c13747e2f5', 'Shantae', 'Withrow', NULL, '2014-12-09 11:58:22', '', 'student', 5, '0000-00-00 00:00:00'),
(424, 'Pupil081@ediface.org', '783e747e376237acd319774630596cf7', 'Sharmaine', 'Enloe', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(425, 'Pupil082@ediface.org', 'd4f18763bcc3d77e6645173fdc20479a', 'Shirly', 'Barrera', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(426, 'Pupil083@ediface.org', 'ce89c9a0d812e2b9f42faab7f6d9ff2f', 'Stanley', 'Janik', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(427, 'Pupil084@ediface.org', '454f34799cdc1754a1074b796fc30fa4', 'Stefani', 'Fenwick', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(428, 'Pupil085@ediface.org', '1074c1d4f50ba89f9b653396694156a5', 'Taisha', 'Verdejo', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(429, 'Pupil086@ediface.org', '0197ed529ecca5ee202cf51332c5e66b', 'Tandra', 'Olesen', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(430, 'Pupil087@ediface.org', '724a032628b2c1cf681ca4b3f09cacff', 'Tangela', 'Buice', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(431, 'Pupil088@ediface.org', 'b9c302f73d321ddc59219bf203ac09e9', 'Tayna', 'Lamacchia', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(432, 'Pupil089@ediface.org', '59e85828a7571a4d96f1ccdc269233d7', 'Teodora', 'Rady', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(433, 'Pupil090@ediface.org', 'b51573877f411ee4a5e5fae42fe1a8df', 'Terrence', 'Brashears', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(434, 'Pupil091@ediface.org', '0e3e12959278ea765471ae6f726963ae', 'Thu', 'Matchett', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(435, 'Pupil092@ediface.org', '7b6a0a5adb7c8cc88d22ee211ad3d530', 'Tomiko', 'Lemmond', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(436, 'Pupil093@ediface.org', '5873055df77e19173b736961bc83a98a', 'Torri', 'Zeng', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(437, 'Pupil094@ediface.org', 'addb60331839c613a52f103381d51173', 'Trena', 'Kesler', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(438, 'Pupil095@ediface.org', 'e9705f533ca3340b56ddd2f3b08cefcb', 'Trisha', 'Riggle', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(439, 'Pupil096@ediface.org', 'efccd0606173aefc7d125d723b960d77', 'Veronica', 'Oda', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(440, 'Pupil097@ediface.org', '82006a9c578f2d3df6c6962f6e8b90a8', 'Wonda', 'Bannister', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(441, 'Pupil098@ediface.org', '29ec1d0a5060cb0ad6631df9f37186d4', 'Woodrow', 'Zahl', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(442, 'Pupil099@ediface.org', '6ed64967c9aa28f86878a791ebca1d29', 'Yaeko', 'Legros', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(443, 'Pupil100@ediface.org', '522a69389c0756dac74a6b8504208845', 'Zina', 'Eisenhart', NULL, '2014-12-09 11:58:22', '', 'student', 6, '0000-00-00 00:00:00'),
(444, 'Teacher01@ediface.org', '8ee0e3c3e511fdaa001f9993721f2e1b', 'Peter', 'Phillips', NULL, '2014-12-09 11:58:22', '', 'teacher', 0, '0000-00-00 00:00:00'),
(445, 'Teacher02@ediface.org', '742fc88d404a5993e5fccd9af7cc5896', 'Anton', 'Stoyanov', NULL, '2014-12-09 11:58:22', '', 'teacher', 0, '0000-00-00 00:00:00'),
(446, 'Teacher03@ediface.org', '35690040ad4c0613d9fbd667f971e205', 'Jonathan', 'Forman', NULL, '2014-12-09 11:58:22', '', 'teacher', 0, '0000-00-00 00:00:00'),
(447, 'Teacher04@ediface.org', '97863bd964824cf37178ecf86e81aeee', 'Jon', 'Parr', NULL, '2014-12-09 11:58:22', '', 'teacher', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_onelogins`
--

CREATE TABLE IF NOT EXISTS `user_onelogins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `oneloginid` varchar(256) NOT NULL,
  `system_password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `user_onelogins`
--

INSERT INTO `user_onelogins` (`id`, `user_id`, `oneloginid`, `system_password`) VALUES
(13, 26, 'ibe@ediface.org', 'zllGmY4p'),
(14, 27, 'student@ediface.org', 'jo4ZibPN'),
(15, 28, 'teacher@ediface.org', 'JBCXhtud'),
(16, 447, 'kiril@ediface.org', 'JBCXhtud');

-- --------------------------------------------------------

--
-- Table structure for table `user_openids`
--

CREATE TABLE IF NOT EXISTS `user_openids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `openid` varchar(256) NOT NULL,
  `system_password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user_openids`
--

INSERT INTO `user_openids` (`id`, `user_id`, `openid`, `system_password`) VALUES
(11, 22, 'https://profiles.google.com/104508716487386736841', 'Me3DRS2z'),
(12, 23, 'https://profiles.google.com/107169517403846392125', 'gIFaaLWe');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
