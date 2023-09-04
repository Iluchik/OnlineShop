<?php
   require 'configDB.php';
   $log = $_SESSION["login"];

   $query = $pdo->prepare($sql);

   $query->execute();
   header("Location: good.php"); 
?>