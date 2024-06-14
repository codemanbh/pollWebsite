<?php
$db = new PDO('mysql:host=localhost;dbname=CS333_G14;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>