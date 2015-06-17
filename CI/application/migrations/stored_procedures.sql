USE `defedifa_ediface`;
DROP procedure IF EXISTS `clear_tables`;

DELIMITER $$

CREATE PROCEDURE `clear_tables` ()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;

    TRUNCATE TABLE `answers`;
    TRUNCATE TABLE `assignments`;
    TRUNCATE TABLE `assignments_details`;
    TRUNCATE TABLE `assignments_grade_attributes`;
    TRUNCATE TABLE `assignments_grade_categories`;
    TRUNCATE TABLE `assignments_marks`;
    TRUNCATE TABLE `assignments_resources`;
    TRUNCATE TABLE `ci_sessions`;
    TRUNCATE TABLE `classes`;
    TRUNCATE TABLE `cont_page_resources`;
    TRUNCATE TABLE `content_page_slides`;
    TRUNCATE TABLE `interactive_assessments_slides`;
    TRUNCATE TABLE `key_words`;
    TRUNCATE TABLE `key_words_resources`;
    TRUNCATE TABLE `lessons`;
    TRUNCATE TABLE `lessons_classes`;
    TRUNCATE TABLE `lessons_resources`;
    TRUNCATE TABLE `modules`;
    TRUNCATE TABLE `modules_resources`;
    TRUNCATE TABLE `pictures`;
    TRUNCATE TABLE `questions`;
    TRUNCATE TABLE `resources`;
    TRUNCATE TABLE `student_classes`;
    TRUNCATE TABLE `subject_years`;
    TRUNCATE TABLE `teacher_classes`;
    TRUNCATE TABLE `user_onelogins`;
    TRUNCATE TABLE `user_openids`;
    TRUNCATE TABLE `users`;

    SET FOREIGN_KEY_CHECKS=1;
END
$$

DELIMITER ;



DROP procedure IF EXISTS `clear_resources`;

DELIMITER $$

CREATE PROCEDURE `clear_resources` ()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;

    TRUNCATE TABLE `assignments_resources`;
    TRUNCATE TABLE `cont_page_resources`;
    TRUNCATE TABLE `key_words_resources`;
    TRUNCATE TABLE `lessons_resources`;
    TRUNCATE TABLE `modules_resources`;
    TRUNCATE TABLE `resources`;

    SET FOREIGN_KEY_CHECKS=1;
END
$$

DELIMITER ;



DROP procedure IF EXISTS `clear_assignments`;

DELIMITER $$

CREATE PROCEDURE `clear_assignments` ()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;

    TRUNCATE TABLE `assignments`;
    TRUNCATE TABLE `assignments_details`;
    TRUNCATE TABLE `assignments_grade_attributes`;
    TRUNCATE TABLE `assignments_grade_categories`;
    TRUNCATE TABLE `assignments_marks`;
    TRUNCATE TABLE `assignments_resources`;

    SET FOREIGN_KEY_CHECKS=1;
END
$$

DELIMITER ;



DROP procedure IF EXISTS `clear_classes`;

DELIMITER $$

CREATE PROCEDURE `clear_classes` ()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;

    TRUNCATE TABLE `answers`;
    TRUNCATE TABLE `assignments`;
    TRUNCATE TABLE `assignments_details`;
    TRUNCATE TABLE `assignments_grade_attributes`;
    TRUNCATE TABLE `assignments_grade_categories`;
    TRUNCATE TABLE `assignments_marks`;
    TRUNCATE TABLE `assignments_resources`;
    TRUNCATE TABLE `classes`;
    TRUNCATE TABLE `cont_page_resources`;
    TRUNCATE TABLE `content_page_slides`;
    TRUNCATE TABLE `interactive_assessments_slides`;
    TRUNCATE TABLE `lessons`;
    TRUNCATE TABLE `lessons_classes`;
    TRUNCATE TABLE `lessons_resources`;
    TRUNCATE TABLE `modules`;
    TRUNCATE TABLE `modules_resources`;
    TRUNCATE TABLE `questions`;
    TRUNCATE TABLE `student_classes`;
    TRUNCATE TABLE `teacher_classes`;

    SET FOREIGN_KEY_CHECKS=1;
END
$$

DELIMITER ;



DROP procedure IF EXISTS `clear_users`;

DELIMITER $$

CREATE PROCEDURE `clear_users` ()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;

    TRUNCATE TABLE `assignments`;
    TRUNCATE TABLE `assignments_details`;
    TRUNCATE TABLE `assignments_grade_attributes`;
    TRUNCATE TABLE `assignments_grade_categories`;
    TRUNCATE TABLE `assignments_marks`;
    TRUNCATE TABLE `assignments_resources`;
    TRUNCATE TABLE `student_classes`;
    TRUNCATE TABLE `subject_years`;
    TRUNCATE TABLE `teacher_classes`;
    TRUNCATE TABLE `user_onelogins`;
    TRUNCATE TABLE `user_openids`;
    TRUNCATE TABLE `users`;

    SET FOREIGN_KEY_CHECKS=1;
END
$$

DELIMITER ;



