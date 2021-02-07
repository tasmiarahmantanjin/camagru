<?php
include('database.php');

// This file create's all the needed table in the DATABASE
// Try to create database and establish connection
try
{
	$pdo = new PDO("mysql:host=$DB_DSN;", $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sqlQuery = "CREATE DATABASE IF NOT EXISTS camagru";
	$pdo->exec($sqlQuery);
	//echo "Database has been created";
}
catch(PDOException $e)
{
	echo 'Connection failed: ' . $e->getMessage();
}

// 'users' table creation
try
{
	$pdo = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sqlQuery = "CREATE TABLE IF NOT EXISTS `users` (
		`user_id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar (50) NOT NULL,
		`username` varchar(100) NOT NULL,
		`email` varchar(100) NOT NULL,
		`verified` tinyint(1) NOT NULL DEFAULT '0',
		`token` varchar(255) DEFAULT NULL,
		`password` varchar(255) NOT NULL,
		-- `recieveCommEmail` varchar(255) NOT NULL DEFAULT '0',
		`notificationEmail` varchar(255) NOT NULL DEFAULT '0',
		PRIMARY KEY (`user_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		$pdo->exec($sqlQuery);
//echo "Congratulation! Your account has been created.";
}
catch(PDOException $e)
{
	echo 'Create new user failed: ' . $e->getMessage();
}

// 'reset-password' table creation
try
{
	$pdo = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sqlQuery = "CREATE TABLE IF NOT EXISTS `reset_password` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`email` varchar(100) NOT NULL,
		`token` varchar(255) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$pdo->exec($sqlQuery);
//echo "Congratulation! Your account has been created.";
}
catch(PDOException $e)
{
	echo 'Create new reset_password failed: ' . $e->getMessage();
}

// 'images' table creation
try
{
	$dbh = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE TABLE IF NOT EXISTS  `images` (
			`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`username` VARCHAR(100) NOT NULL,
			`user_id` INT(11) NOT NULL,
			`image` VARCHAR(100) NOT NULL,
			`like_count` int(11) NOT NULL
		)";
	$dbh->exec($sql);
}
catch (PDOException $e)
{
	echo "ERROR CREATING IMAGES TABLE: " . $e->getMessage() . "Aborting process<br>";
}

// 'likes' table creation
try
{
	$dbh = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE TABLE IF NOT EXISTS  `likes` (
			`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`image_id` int (11) NOT NULL,
			`user_id` int(11) NOT NULL
		)";
	$dbh->exec($sql);
}
catch (PDOException $e)
{
	echo "ERROR CREATING likes TABLE: " . $e->getMessage() . "Aborting process<br>";
}

// 'Table_comment' table creation
try
{
	$dbh = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE TABLE IF NOT EXISTS  `tbl_comment` (
			`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`user_id` int (11) NOT NULL,
			`comment` varchar(100) NOT NULL,
			`image_id` INT(11) NOT NULL,
			`date` int(50) NULL
		)";
	$dbh->exec($sql);
}
catch (PDOException $e)
{
	echo "ERROR CREATING comment TABLE: " . $e->getMessage() . "Aborting process<br>";
}

$pdo = null;
?>
