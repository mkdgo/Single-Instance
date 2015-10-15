CREATE TABLE `assignments_filter` (
  `id` int(11) unsigned NOT NULL,
  `base_assignment_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
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
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments_filter`
--
ALTER TABLE `assignments_filter`
 ADD PRIMARY KEY (`id`), ADD KEY `teacher_id` (`teacher_id`), ADD KEY `base_assignment_id` (`base_assignment_id`), ADD KEY `publish` (`publish`), ADD KEY `publish_marks` (`publish_marks`);
