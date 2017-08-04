<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-04-15 00:03:43 --> Query error: Unknown column 'ea_users.last_name ea_roles.slug' in 'field list' - Invalid query: SELECT `ea_users`.`id` AS `user_id`, `ea_users`.`email` AS `user_email`, `ea_users`.`first_name`, `ea_users`.`last_name ea_roles`.`slug` AS `role_slug`, `ea_user_settings`.`username`
FROM `ea_users`
INNER JOIN `ea_roles` ON `ea_roles`.`id` = `ea_users`.`id_roles`
JOIN `ea_user_settings` ON `ea_user_settings`.`id_users` = `ea_users`.`id`
WHERE `ea_user_settings`.`username` = 'therapist1'
AND `ea_user_settings`.`password` = '63e105da8cb9e62f44220d2032a236836595ec5ce2ec7b0d6e7fb981b74ed20e'
ERROR - 2017-04-15 00:03:43 --> Query error: Unknown column 'ea_users.last_name ea_roles.slug' in 'field list' - Invalid query: SELECT `ea_users`.`id` AS `user_id`, `ea_users`.`email` AS `user_email`, `ea_users`.`first_name`, `ea_users`.`last_name ea_roles`.`slug` AS `role_slug`, `ea_user_settings`.`username`
FROM `ea_users`
INNER JOIN `ea_roles` ON `ea_roles`.`id` = `ea_users`.`id_roles`
JOIN `ea_user_settings` ON `ea_user_settings`.`id_users` = `ea_users`.`id`
WHERE `ea_user_settings`.`username` = 'therapist1'
AND `ea_user_settings`.`password` = '63e105da8cb9e62f44220d2032a236836595ec5ce2ec7b0d6e7fb981b74ed20e'
