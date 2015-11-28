<?php
//$r = @file_get_contents('http://dev.dev.ediface.org/search_admin/rebuild');
define('BASEPATH', realpath(dirname(__FILE__)));
require_once( BASEPATH.'/CI/application/config/database.php' );
if( $_SERVER['HTTP_HOST'] == 'ediface.dev' ) {
    $dbhost = 'localhost';
    $dbname = 'defedifa_copy';
    $dbuser = 'root';
    $dbpass = 'hoyya';
} else {
    $dbhost = $db['default']['hostname'];
    $dbname = $db['default']['database'];
    $dbuser = $db['default']['username'];
    $dbpass = $db['default']['password'];
}

$conn = @mysql_pconnect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
$db = @mysql_select_db($dbname);
mysql_set_charset('utf8');
if( !$db ) {
    echo ' : Mysql error - ' . mysql_error() . "\n";
} else {
    $sql_filter = 'SELECT *
            FROM (  SELECT a1.*, subjects.name AS subject_name, subjects.id AS subject_id, classes.year AS year, CONCAT( users.first_name, " ", users.last_name ) AS teacher_name,
                        (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active != -1) AS total,
                        (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1 AND a2.publish >= 1) AS submitted,
                        (SELECT COUNT(id) FROM assignments a2 WHERE a2.base_assignment_id = a1.id AND a2.active = 1 AND a2.publish >= 1 AND a2.grade != 0 AND a2.grade != "") AS marked
                    FROM assignments a1
                    LEFT JOIN users ON users.id = a1.teacher_id
                    LEFT JOIN classes ON classes.id IN (a1.class_id)
                    LEFT JOIN subjects ON subjects.id = classes.subject_id
                    LEFT JOIN assignments_marks ON assignments_marks.assignment_id = a1.id
                    WHERE active = 1 AND a1.base_assignment_id = 0) ss';

    $task_select = mysql_query( $sql_filter );
    if( mysql_num_rows( $task_select ) > 0 ) {
        $i = 0;
        while( $row = mysql_fetch_assoc( $task_select ) ) {
            $class_names_sql = "SELECT `group_name` FROM `classes` WHERE `classes`.`id` IN(".$row['class_id'].")";
            $task_class = mysql_query( $class_names_sql );
            $imp_class_names = '';
            if( mysql_num_rows( $task_class ) > 0 ) {
                //$i = 0;
                $arr_class_names = array();
                $imp_class_names = '';
                while( $crow = mysql_fetch_assoc( $task_class ) ) {
                    $arr_class_names[] = $crow['group_name'];
                }
                $imp_class_names = implode( ',',$arr_class_names );
            }
            
            $db_fields = array(
                'id' => $row['id'],
                'base_assignment_id' => $row['base_assignment_id'],
                'teacher_id' => $row['teacher_id'],
                'publish_date' => $row['publish_date'] ? $row['publish_date'] : null,
                'subject_id' => $row['subject_id'],
                'subject_name' => $row['subject_name'],
                'year' => $row['year'],
                'class_id' => $row['class_id'],
                'title' => mysql_real_escape_string( $row['title'] ),
                'intro' => mysql_real_escape_string( $row['intro'] ),
                'grade_type' => $row['grade_type'],
                'grade' => $row['grade'],
                'deadline_date' => $row['deadline_date'],
                'submitted_date' => $row['submitted_date'],
                'feedback' => $row['feedback'],
                'active' => $row['active'],
                'publish' => $row['publish'],
                'publish_marks' => $row['publish_marks'],
                'total' => $row['total'],
                'submitted' => $row['submitted'],
                'marked' => $row['marked'],
                'teacher_name' => $row['teacher_name'],
                'class_name' => $imp_class_names,
            );

            $values = '("'.$db_fields['id'].'", 
                "'.$db_fields['base_assignment_id'].'", 
                "'.$db_fields['teacher_id'].'", 
                "'.$db_fields['publish_date'].'", 
                "'.$db_fields['subject_id'].'", 
                "'.$db_fields['subject_name'].'", 
                "'.$db_fields['year'].'", 
                "'.$db_fields['class_id'].'", 
                "'.$db_fields['title'].'", 
                "'.$db_fields['intro'].'", 
                "'.$db_fields['grade_type'].'", 
                "'.$db_fields['grade'].'", 
                "'.$db_fields['deadline_date'].'", 
                "'.$db_fields['submitted_date'].'", 
                "'.$db_fields['feedback'].'", 
                "'.$db_fields['active'].'", 
                "'.$db_fields['publish'].'", 
                "'.$db_fields['publish_marks'].'", 
                "'.$db_fields['total'].'", 
                "'.$db_fields['submitted'].'",
                "'.$db_fields['marked'].'",
                "'.$db_fields['teacher_name'].'",
                "'.$db_fields['class_name'].'") ';
            $values_update = ' 
                base_assignment_id="'.$db_fields['base_assignment_id'].'", 
                teacher_id="'.$db_fields['teacher_id'].'", 
                publish_date="'.$db_fields['publish_date'].'", 
                subject_id="'.$db_fields['subject_id'].'", 
                subject_name="'.$db_fields['subject_name'].'", 
                year="'.$db_fields['year'].'", 
                class_id="'.$db_fields['class_id'].'", 
                title="'.$db_fields['title'].'", 
                intro="'.$db_fields['intro'].'", 
                grade_type="'.$db_fields['grade_type'].'", 
                grade="'.$db_fields['grade'].'", 
                deadline_date="'.$db_fields['deadline_date'].'", 
                submitted_date="'.$db_fields['submitted_date'].'", 
                feedback="'.$db_fields['feedback'].'", 
                active="'.$db_fields['active'].'", 
                publish="'.$db_fields['publish'].'", 
                publish_marks="'.$db_fields['publish_marks'].'", 
                total="'.$db_fields['total'].'", 
                submitted="'.$db_fields['submitted'].'", 
                marked="'.$db_fields['marked'].'", 
                teacher_name="'.$db_fields['teacher_name'].'", 
                class_name="'.$db_fields['class_name'].'" '; 

            $sql_insert =  'INSERT INTO assignments_filter ( id, base_assignment_id, teacher_id, publish_date, subject_id, subject_name, year, class_id, title, intro, grade_type, grade, deadline_date, submitted_date, feedback,
             active, publish, publish_marks, total, submitted, marked, teacher_name, class_name ) VALUES '.$values.' ON DUPLICATE KEY UPDATE '.$values_update;

            if( !$task_insert = mysql_query( $sql_insert ) ) {
                echo "Something wrong!?!?!?" . ' - ';
                echo '<pre>';var_dump( $db_fields );$sql_insert . ' - ';
                echo ' : Mysql error - ' . mysql_error() . "\n\r<br />";
            } else {
                $i++;
            }
        }
        $sql_update_draft = "UPDATE assignments_filter 
                            SET status = 'draft', order_weight = 4 
                            WHERE publish = 0 ";
        if( !$task_draft = mysql_query( $sql_update_draft ) ) {
                echo "Something wrong!?!?!?" . ' - ';
                echo ' : Mysql error - ' . mysql_error() . "\n\r<br />";
        };
        $sql_update_pending = "UPDATE assignments_filter 
                                SET status = 'pending', order_weight = 2  
                                WHERE publish = 1 AND publish_marks = 0 AND publish_date > NOW()";
        if( !$task_pending = mysql_query( $sql_update_pending ) ) {
                echo "Something wrong!?!?!?" . ' - ';
                echo ' : Mysql error - ' . mysql_error() . "\n\r<br />";
        };
        $sql_update_assigned = "UPDATE assignments_filter 
                                SET status = 'assigned', order_weight = 1 
                                WHERE publish = 1 AND publish_marks = 0 AND publish_date < NOW() AND deadline_date > NOW()";
        if( !$task_assigned = mysql_query( $sql_update_assigned ) ) {
                echo "Something wrong!?!?!?" . ' - ';
                echo ' : Mysql error - ' . mysql_error() . "\n\r<br />";
        };
        $sql_update_past = "UPDATE assignments_filter 
                                SET status = 'past', order_weight = 3  
                                WHERE grade_type <> 'offline' AND publish = 1 AND publish_marks = 0 AND publish_date < NOW() AND deadline_date < NOW()";
        if( !$task_past = mysql_query( $sql_update_past ) ) {
                echo "Something wrong!?!?!?" . ' - ';
                echo ' : Mysql error - ' . mysql_error() . "\n\r<br />";
        };
        $sql_update_closed = "UPDATE assignments_filter 
                                SET status = 'closed', order_weight = 5 
                                WHERE ( grade_type <> 'offline' AND publish = 1 AND publish_marks = 1 )
                                     OR ( grade_type = 'offline' AND publish = 1 AND deadline_date < NOW() )";
        if( !$task_closed = mysql_query( $sql_update_closed ) ) {
                echo "Something wrong!?!?!?" . ' - ';
                echo ' : Mysql error - ' . mysql_error() . "\n\r<br />";
        };
                                    
        echo "\n\nOK - all records: ".$i;
    } else {
        echo "Something wrong!?!?!?";
        echo ' : Mysql error - ' . mysql_error();
    }

/*
    $task_sql = 'CALL filterAssignments();';
    $task = mysql_query( $task_sql );
    if( $task ) {
        echo "OK";
    } else {
        echo "Something wrong!?!?!?";
    }
//*/
}

?>