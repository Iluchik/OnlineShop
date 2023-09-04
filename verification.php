<?php
   session_start();
   require 'confDBReserv.php';
   $query = $pdores->query('SELECT * FROM `users`');
   while ($row = $query->fetch(PDO::FETCH_OBJ)){
      if($_POST['login'] === $row->login && md5($_POST['pass']) === $row->password) {
         
         $_SESSION["user_id"] = $row->user_id;
         $_SESSION["login"] = $row->login;
         header("Location: good.php");
         
      }
   };
   if (count($_COOKIE) > 1) {
   $array_keys = array_keys ($_COOKIE);
   $count = count($array_keys);
      for ($i = 1; $i<$count; $i++) {
         $user_id = $_SESSION["user_id"];
         $id = $array_keys[$i];
         $quantity = $_COOKIE[$array_keys[$i]];

         $sql1 = "INSERT INTO `users_goods` (user_id, good_id, quantity) 
         SELECT :user_id, id, :quantity
         FROM
            `goods`
         WHERE id = $id";

         $query = $pdores->query('SELECT * FROM `users_goods`');
         while ($row = $query->fetch(PDO::FETCH_OBJ)) {
            if ($row->good_id == $id){
               $sql2 = "UPDATE users_goods SET quantity = :quantity WHERE good_id = :id";
               break;
            }
         }

         $query1 = $pdores->prepare($sql1);
         $query1->bindParam(':user_id', $user_id);
         $query1->bindParam(':quantity', $quantity);
         $query1->execute();
         $query2 = $pdores->prepare($sql2);
         $query2->bindParam(':quantity', $quantity);
         $query2->bindParam(':id', $id);
         $query2->execute();
         setcookie($array_keys[$i],0, time()-10);
      };
   }


   // echo ($_SESSION["user_id"]);
   echo "<div class='user-status'>Требуется авторизация</div>
         <a href='autorization.php'>Назад</a>";
?>