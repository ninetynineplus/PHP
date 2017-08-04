<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-12-10 08:05:30 --> Severity: Warning --> mysqli::real_connect(): php_network_getaddresses: getaddrinfo failed: Name or service not known /home/healthy2/account.healthyfirst.id/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2016-12-10 08:05:30 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): php_network_getaddresses: getaddrinfo failed: Name or service not known /home/healthy2/account.healthyfirst.id/system/database/drivers/mysqli/mysqli_driver.php 202
ERROR - 2016-12-10 08:05:30 --> Unable to connect to the database
ERROR - 2016-12-10 10:21:47 --> Query error: Unknown column 'user_name' in 'field list' - Invalid query: UPDATE `ea_users` SET `user_name` = 'qweqwe', `password` = 'qweqwe123', `first_name` = 'test', `last_name` = 'aja', `email` = 'testing@test.com', `phone_number` = '123123', `address` = 'Lokasari', `id` = '86'
WHERE `id` = '86'
ERROR - 2016-12-10 10:21:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php:116) /home/healthy2/account.healthyfirst.id/system/core/Common.php 573
ERROR - 2016-12-10 10:32:48 --> Query error: Unknown column 'user_name' in 'field list' - Invalid query: UPDATE `ea_users` SET `user_name` = 'testaja', `password` = 'qweasd123', `first_name` = 'test', `last_name` = 'aja', `email` = 'testing@test.com', `phone_number` = '123123', `address` = 'Lokasari', `id` = '86'
WHERE `id` = '86'
ERROR - 2016-12-10 10:33:25 --> Query error: Unknown column 'user_name' in 'field list' - Invalid query: UPDATE `ea_users` SET `user_name` = 'testaja', `password` = 'qweasd123', `first_name` = 'test', `last_name` = 'aja', `email` = 'testing@test.com', `phone_number` = '123123', `address` = 'Lokasari', `id` = '86'
WHERE `id` = '86'
ERROR - 2016-12-10 10:34:13 --> Query error: Unknown column 'user_name' in 'field list' - Invalid query: UPDATE `ea_users` SET `user_name` = 'testaja', `password` = 'qweasd123', `first_name` = 'test', `last_name` = 'aja', `email` = 'testing@test.com', `phone_number` = '123123', `address` = 'Lokasari', `id` = '86'
WHERE `id` = '86'
ERROR - 2016-12-10 10:43:32 --> Severity: Error --> Call to undefined function generate_salt() /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 136
ERROR - 2016-12-10 10:44:46 --> Severity: Error --> Call to undefined function generate_salt() /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 136
ERROR - 2016-12-10 10:45:43 --> Severity: Error --> Call to undefined function generate_salt() /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 136
ERROR - 2016-12-10 10:46:23 --> Severity: Error --> Call to undefined function generate_salt() /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 136
ERROR - 2016-12-10 11:17:36 --> Severity: Error --> Call to undefined method CI_DB_mysqli_driver::result_array() /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 340
ERROR - 2016-12-10 11:19:26 --> Query error: Table 'healthy2_acc.ea_users_settings' doesn't exist - Invalid query: SELECT `ea_users`.*, `ea_users_settings`.*
FROM `ea_users`
INNER JOIN `ea_users_settings` ON `ea_users`.`id` = `ea_users_settings`.`id_users`
WHERE `id_roles` = '3'
ERROR - 2016-12-10 12:09:47 --> Query error: Unknown column 'testing@test.com' in 'where clause' - Invalid query: SELECT `ea_users`.*, `ea_user_settings`.*
FROM `ea_users`
INNER JOIN `ea_user_settings` ON `ea_users`.`id` = `ea_user_settings`.`id_users`
WHERE `ea_users`.`email` = `testing@test`.`com`
AND `id_roles` = '3'
ERROR - 2016-12-10 12:09:51 --> Query error: Unknown column 'testing@test.com' in 'where clause' - Invalid query: SELECT `ea_users`.*, `ea_user_settings`.*
FROM `ea_users`
INNER JOIN `ea_user_settings` ON `ea_users`.`id` = `ea_user_settings`.`id_users`
WHERE `ea_users`.`email` = `testing@test`.`com`
AND `id_roles` = '3'
ERROR - 2016-12-10 12:24:17 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 133
ERROR - 2016-12-10 12:24:56 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 133
ERROR - 2016-12-10 12:29:47 --> Query error: Unknown column 'ea_users_settings.username' in 'where clause' - Invalid query: SELECT `ea_users`.*, `ea_user_settings`.*
FROM `ea_users`
INNER JOIN `ea_user_settings` ON `ea_users`.`id` = `ea_user_settings`.`id_users`
WHERE `ea_users_settings`.`username` = 'admin'
AND `id_roles` = '3'
ERROR - 2016-12-10 12:30:37 --> Query error: Duplicate entry '86' for key 'PRIMARY' - Invalid query: INSERT INTO `ea_user_settings` (`username`, `password`, `id_users`) VALUES ('admin', 'bf4067d043a7f534b9f4bec5b56e6c79c8185085c63d23e43a43a61eb4f46e67', 86)
ERROR - 2016-12-10 12:31:53 --> Query error: Duplicate entry '86' for key 'PRIMARY' - Invalid query: INSERT INTO `ea_user_settings` (`username`, `password`, `id_users`) VALUES ('test', 'bf4067d043a7f534b9f4bec5b56e6c79c8185085c63d23e43a43a61eb4f46e67', 86)
ERROR - 2016-12-10 12:35:55 --> Query error: Unknown column 'ea_user_setting.username' in 'where clause' - Invalid query: SELECT `ea_users`.*, `ea_user_settings`.*
FROM `ea_users`
INNER JOIN `ea_user_settings` ON `ea_users`.`id` = `ea_user_settings`.`id_users`
WHERE `ea_user_setting`.`username` = 'admin'
AND `id_roles` = '3'
ERROR - 2016-12-10 12:37:15 --> Query error: Unknown column 'ea_user_setting.username' in 'where clause' - Invalid query: SELECT `ea_users`.*, `ea_user_settings`.*
FROM `ea_users`
INNER JOIN `ea_user_settings` ON `ea_users`.`id` = `ea_user_settings`.`id_users`
WHERE `ea_user_setting`.`username` = 'admin'
ERROR - 2016-12-10 12:38:13 --> Severity: Parsing Error --> syntax error, unexpected '->' (T_OBJECT_OPERATOR) /home/healthy2/account.healthyfirst.id/application/models/Customers_model.php 304
ERROR - 2016-12-10 12:40:11 --> Query error: Unknown column 'ea_user_setting.username' in 'where clause' - Invalid query: SELECT `ea_users`.*, `ea_user_settings`.*
FROM `ea_users`
INNER JOIN `ea_user_settings` ON `ea_users`.`id` = `ea_user_settings`.`id_users`
WHERE `ea_user_setting`.`username` = 'admin'
AND `id_roles` = '3'
