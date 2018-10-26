<?php

/*
 * uploadConfig.php
 * created by Avery Wald on 6/18/18
 * 
 * to be used in conjunction with 'upload.php'
 * holds sensitive data and effectively abstracts it within 'upload.php'
*/

// phpMyAdmin datbase credentials
$host = 'mysqlcluster4.registeredsite.com';
$user = 'averywald';
$password = 'Gorilla333';
$dbname = 'sunaviation';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// phpMailer credentials
$userName = 'averywald.dev@gmail.com';        // SMTP username
$passWord = 'Gorilla33';                      // SMTP password
$smtpSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
$tcpPort = 587;                               // TCP port to connect to

// email addresses to send new order info
$emails = array('averywald.dev@gmail.com', 'alex@sunav.com', 'curt@sunav.com',  'jeffgregg@sunav.com', 'sales2@sunav.com');