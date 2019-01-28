<?php
require_once('coon.php');

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
	exit();
}

try {
$action = $_POST['action'];
if ($action == 'insert') {
session_start();
$code = trim($_POST['code']);
if ($code != $_SESSION['code']) {
	echo "invalid verification code";
	exit();
}
$username = trim($_POST['username']);
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);
$email = trim($_POST['email']);

if (strlen($username) < 6) {
	throw new Exception("invalid username");
}
if (strlen($password1) < 6 || strlen($password1) >16 || ($password1 != $password2)) {
	throw new Exception("invalid password");
}
$password = sha1($password1);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	throw new Exception("invalid email");
}

$query = "select * from userlist where username = :username or email = :email"; 
$stmt = $coon->prepare($query);
$stmt->execute(array(':username' => $username,
					 ':email' => $email));
if (!$stmt->fetch(PDO::FETCH_ASSOC)) {

$query = "insert into userlist values (:username, :password, :email)";
$stmt = $coon->prepare($query);
$stmt->execute(array(':username' => $username,
					 ':password' => $password,
					 ':email' => $email));
if ($stmt->rowCount()) {
	echo "insert successfully";
} else {
	echo "insert false";
}
} else {
	echo "The account already exists";
}
}

if ($action == 'checkname') {
	$username = trim($_POST['username']);

	$query = "select * from userlist where username = :username"; 
	$stmt = $coon->prepare($query);
	$stmt->execute(array(':username' => $username));
	if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "The user name is available";
	} else {
		echo "User name already exists";
	}
}

if ($action == 'checkemail') {
	$email = trim($_POST['email']);

	$query = "select * from userlist where email = :email"; 
	$stmt = $coon->prepare($query);
	$stmt->execute(array(':email' => $email));
	if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "The email is available";
	} else {
		echo "email already exists";
	}
}
} catch (Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e) {
	echo $e->getMessage();
	echo $e->getCode();	
	echo $e->getLine();
	echo $e->getFile();
}


