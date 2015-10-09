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
    TRUNCATE TABLE `work`;
    TRUNCATE TABLE `work_assignments`;
    TRUNCATE TABLE `work_items`;
    TRUNCATE TABLE `work_items_temp`;
    TRUNCATE TABLE `work_taggees`;

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



DROP procedure IF EXISTS `clear_works`;

DELIMITER $$

CREATE PROCEDURE `clear_assignments` ()
BEGIN
    SET FOREIGN_KEY_CHECKS=0;

    TRUNCATE TABLE `work`;
    TRUNCATE TABLE `work_assignments`;
    TRUNCATE TABLE `work_items`;
    TRUNCATE TABLE `work_items_temp`;
    TRUNCATE TABLE `work_taggees`;

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



DELIMITER $$
CREATE PROCEDURE filterAssignments()
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
         WHERE active = 1 AND a1.base_assignment_id = 0 ) ss;
    SET FOREIGN_KEY_CHECKS=1;
END
$$
DELIMITER ;
