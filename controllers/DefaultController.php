<?php
include '../helper.php';
include '../models/UserValidation.php';

$db = include '../models/db/start.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

$vd = new UserValidation(
	$username,
	$email,
	$password1, 
	$password2, 
	$db
);

if ($vd->validate()) {

	$db->create('user', [
		'username' => $username,
		'email' => $email,
		'password' => md5($password1)
	]);

	header('Location: /index.php');

} else {
	dump($vd->getErrors());
}