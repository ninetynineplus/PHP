<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-03-31 17:24:15 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 427
ERROR - 2017-03-31 17:24:15 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 456
ERROR - 2017-03-31 17:24:15 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 464
ERROR - 2017-03-31 17:24:15 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 4
ERROR - 2017-03-31 17:24:15 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 7
ERROR - 2017-03-31 17:41:35 --> Severity: error --> Exception: /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php exists, but doesn't declare class Appointments_model /home/healthy2/account.healthyfirst.id/system/core/Loader.php 336
ERROR - 2017-03-31 17:47:17 --> Severity: Error --> Call to undefined method CI_DB_mysqli_driver::num_rows() /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 634
ERROR - 2017-03-31 18:00:40 --> Query error: Column 'status' cannot be null - Invalid query: INSERT INTO `ea_appointments` (`book_datetime`, `start_datetime`, `hash`, `id_users_provider`, `pref_provider_gender`, `id_users_customer`, `id_services`, `duration`, `address`, `payment`, `fee`, `status`) VALUES ('2017-03-31 18:00:40', '2017-31-03 20:20:00', 'f3b81dae01b9b2accd8efc383acd97ee', 0, 'Male', '86', 3, 60, 'jakarta', 'Cash', '160000.00', NULL)
ERROR - 2017-03-31 18:02:05 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`healthy2_acc`.`ea_appointments`, CONSTRAINT `ea_appointments_ibfk_4` FOREIGN KEY (`id_users_provider`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE) - Invalid query: INSERT INTO `ea_appointments` (`book_datetime`, `start_datetime`, `hash`, `id_users_provider`, `pref_provider_gender`, `id_users_customer`, `id_services`, `duration`, `address`, `payment`, `fee`, `status`) VALUES ('2017-03-31 18:02:05', '2017-31-03 20:20:00', 'a2fe52c0452e0696be5f488fa8ab2ffc', 0, 'Male', '86', 3, 60, 'jakarta', 'Cash', '160000.00', 0)
