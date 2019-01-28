<?php
try {
$coon = new PDO('mysql:host=localhost;dbname=ajaxregister;charset=utf8', 'liuliwei', '974628');
$coon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$coon->exec("set names utf8");
} catch (PDOException $e) {
	echo "do not connect mysql";
}