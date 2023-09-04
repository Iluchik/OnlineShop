<?php
 $dsn = 'mysql:host=localhost;dbname=shop';
 $user = 'root';
 $pass = 'qwerty';
 // $opt = array(
 //    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
 //    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
 try
 {
 $pdores = new PDO($dsn, $user);
 }
 catch (PDOException $e)
 {
 die('Подключение не удалось: ' . $e->getMessage());
 }
?>