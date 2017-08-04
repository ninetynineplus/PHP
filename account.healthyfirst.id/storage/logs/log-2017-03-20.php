<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-03-20 00:58:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
	' at line 2 - Invalid query: select a.id, a.pref_provider_gender, a.start_datetime, a.status
				b.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
				CONCAT(d.first_name, ' ', d.last_name) as provname
				from ea_appointments a
				left join ea_services b
				on a.id_services = b.id
				left join ea_users c
				on a.id_users_customer = c.id
				left join ea_users d
				on a.id_users_provider = d.id
				order by a.id desc
ERROR - 2017-03-20 00:58:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
	' at line 2 - Invalid query: select a.id, a.pref_provider_gender, a.start_datetime, a.status
				b.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
				CONCAT(d.first_name, ' ', d.last_name) as provname
				from ea_appointments a
				left join ea_services b
				on a.id_services = b.id
				left join ea_users c
				on a.id_users_customer = c.id
				left join ea_users d
				on a.id_users_provider = d.id
				order by a.id desc
ERROR - 2017-03-20 00:58:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
	' at line 2 - Invalid query: select a.id, a.pref_provider_gender, a.start_datetime, a.status
				b.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
				CONCAT(d.first_name, ' ', d.last_name) as provname
				from ea_appointments a
				left join ea_services b
				on a.id_services = b.id
				left join ea_users c
				on a.id_users_customer = c.id
				left join ea_users d
				on a.id_users_provider = d.id
				order by a.id desc
ERROR - 2017-03-20 00:58:43 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
	' at line 2 - Invalid query: select a.id, a.pref_provider_gender, a.start_datetime, a.status
				b.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
				CONCAT(d.first_name, ' ', d.last_name) as provname
				from ea_appointments a
				left join ea_services b
				on a.id_services = b.id
				left join ea_users c
				on a.id_users_customer = c.id
				left join ea_users d
				on a.id_users_provider = d.id
				order by a.id desc
ERROR - 2017-03-20 01:22:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE a.pref_provider_gender like '%'test'%' OR CONCAT(c.first_name, ' ', c.last' at line 12 - Invalid query: select a.id, a.pref_provider_gender, a.start_datetime, a.status,
				b.name as servicename, 
				CONCAT(c.first_name, ' ', c.last_name) as custname,
				CONCAT(d.first_name, ' ', d.last_name) as provname
				from ea_appointments a
				left join ea_services b
				on a.id_services = b.id
				left join ea_users c
				on a.id_users_customer = c.id
				left join ea_users d
				on a.id_users_provider = d.id
				order by a.id desc WHERE a.pref_provider_gender like '%'test'%' OR CONCAT(c.first_name, ' ', c.last_name) like '%'test'%' OR CONCAT(d.first_name, ' ', d.last_name) like '%'test'%'
ERROR - 2017-03-20 01:51:52 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 01:51:52 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 01:51:52 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 01:55:37 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 01:55:37 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 01:55:37 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 01:56:30 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 01:56:30 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 01:56:30 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 01:57:17 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 01:57:17 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 01:57:17 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 01:57:39 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 01:57:39 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 01:57:39 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:01:11 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:01:11 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:01:11 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:01:11 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 5
ERROR - 2017-03-20 02:01:11 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:02:40 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:02:40 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:02:40 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:02:40 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:02:40 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:03:30 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:03:30 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:03:30 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:03:30 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:03:30 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:04:20 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:04:20 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:04:20 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:04:20 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:04:20 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:10:11 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:10:11 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:10:11 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:10:11 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:10:11 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:10:42 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:10:42 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:10:42 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:10:42 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:10:42 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:10:44 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:10:44 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:10:44 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:10:44 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:10:44 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:10:46 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:10:46 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:10:46 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:10:46 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:10:46 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:10:47 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:10:47 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:10:47 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:10:47 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:10:47 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:12:36 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:12:36 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:12:36 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:12:36 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:12:36 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:12:39 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:12:39 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:12:39 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:12:39 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:12:39 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:12:48 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:12:48 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:12:48 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:12:48 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:12:48 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:12:50 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:12:50 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:12:50 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:12:50 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:12:50 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:12:57 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:12:57 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:12:57 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:12:57 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:12:57 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
ERROR - 2017-03-20 02:13:14 --> Severity: Warning --> Illegal string offset 'key' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 424
ERROR - 2017-03-20 02:13:14 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 453
ERROR - 2017-03-20 02:13:14 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/models/Appointments_model.php 461
ERROR - 2017-03-20 02:13:14 --> Severity: Warning --> Illegal string offset 'limit' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 6
ERROR - 2017-03-20 02:13:14 --> Severity: Warning --> Illegal string offset 'page' /home/healthy2/account.healthyfirst.id/application/views/appointments/list.php 9
