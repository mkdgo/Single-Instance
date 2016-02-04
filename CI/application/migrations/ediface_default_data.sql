INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@ediface.org', '7c4a8d09ca3762af61e59520943dc26494f8941b');

INSERT INTO `site_settings` (`id`, `setting_id`, `setting_value`) VALUES
(1, 'default_identity_data_provider', 'ediface'),
(2, 'fall_back_to_default_identity_data_provider', '1'),
(3, 'website_head_title', 'The Ediface School'),
(4, 'elastic_url', 'oupsh8jetr:nvvy1krdnu@ediface-5711837249.eu-west-1.bonsai.io'),
(5, 'elastic_index', 'mkdgo'),
(6, 'tvlesson_creating_resources', ''),
(7, 'tvlesson_interactive_lessons', ''),
(8, 'tvlesson_setting_homework', ''),
(9, 'tvlesson_submitting_homework', ''),
(10, 'tvlesson_marking_homework', ''),
(11, 'svlesson_creating_resources', ''),
(12, 'svlesson_interactive_lessons', ''),
(13, 'svlesson_setting_homework', ''),
(14, 'svlesson_submitting_homework', ''),
(15, 'svlesson_marking_homework', ''),
(16, 'logout_url', 'custom'),
(17, 'logout_url_custom', 'https://dragonschool.onelogin.com/trust/saml2/http-redirect/slo/348467');
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO `subjects` (`id`, `name`, `logo_pic`, `publish`) VALUES
(1, 'Maths', 'math.png', 1),
(2, 'English', 'english.png', 1),
(3, 'Music', 'music.png', 1),
(4, 'Art', 'art.png', 1),
(5, 'History', 'history.png', 1),
(6, 'French', 'french.png', 1),
(7, 'German', 'german.png', 1),
(8, 'Geography', 'geography.png', 1),
(9, 'Science', 'chemistry.png', 1),
(10, 'PE', 'PE.png', 1),
(11, 'RS', 'Theology.png', 1),
(13, 'Drama', 'drama.png', 1),
(14, 'DT', 'Woodwork.png', 1),
(15, 'Programming', 'IT.png', 1),
(16, 'Digital Literacy', 'IT.png', 1),
(17, 'Latin', 'Latin.png', 1),
(18, 'Spanish', 'spanish.png', 1),
(19, 'Greek', 'Greek_(1).png', 1),
(12, 'Spelling', 'english.png', 1);
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `birthdate`, `timestamp`, `ip`, `user_type`, `student_year`, `last_seen`, `password_recovery_token`, `is_online`) VALUES
(1, 'teacher@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Test', 'Teacher', '2013-10-24', '2013-10-24 15:13:32', '95.111.90.14', 'teacher', 0, '0000-00-00 00:00:00', NULL, 0),
(2, 'student@ediface.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Test', 'Student', '2013-10-24', '2013-10-24 15:13:32', '95.111.90.14', 'student', 5, '2015-03-18 11:30:29', NULL, 1);
SET FOREIGN_KEY_CHECKS=1;
