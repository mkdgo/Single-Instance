ERROR - 2015-01-29 16:14:18 --> sql: SELECT `resources`.`id` as res_id, `resources`.`name`, `resources`.`resource_name`, `resources`.`is_remote`, `resources`.`link`
FROM (`resources`)
JOIN `lessons_resources` ON `resources`.`id` = `lessons_resources`.`resource_id`
WHERE `lessons_resources`.`lesson_id` =  '262'
