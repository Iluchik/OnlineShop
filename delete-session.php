<?php
   
   require "create-session.php";
   session_unset();
   // print_r($_SESSION); 
   header("Location: good.php"); 
?>