<?php
   header("Location: cart.php");
   // is_numeric($_POST['quantity']) ? $_POST['quantity'] : 1;
   session_start();
   if (empty($_SESSION)){
      if (is_numeric($_POST['quantity'])) {
         setcookie($_POST['id'], $_POST['quantity']);
      }

         if (isset($_POST['del'])){
            setcookie($_POST['del'],0, time()-10);
         }
      print_r($_COOKIE);
   } else{
      require 'confDBReserv.php';

      $user_id = $_SESSION["user_id"];


      $id = $_POST['id'];
      $quantity = $_POST['quantity'];
	  $name = $_POST['name'];
	  $price = $_POST['price'];
	  print_r($_POST);

	  if (isset($name) && isset($price)) {
		$sql0 = "UPDATE `goods` SET name = :name, price = :price WHERE id = :id";

		$query0 = $pdores->prepare($sql0);
		$query0->bindParam(':name', $name);
		$query0->bindParam(':price', $price);
		$query0->bindParam(':id', $id);
		$query0->execute();
	  }

	  if (isset($user_id) && isset($quantity)) {
      $sql1 = "INSERT INTO `users_goods` (user_id, good_id, quantity) 
         SELECT :user_id, id, :quantity
         FROM
            `goods`
         WHERE id = $id";

      $query1 = $pdores->prepare($sql1);
      $query1->bindParam(':user_id', $user_id);
      $query1->bindParam(':quantity', $quantity);
      $query1->execute();

      $query = $pdores->query('SELECT * FROM `users_goods`');
      while ($row = $query->fetch(PDO::FETCH_OBJ)) {
        //  echo ($row->good_id);
         if ($row->good_id == $id){
            $sql2 = "UPDATE users_goods SET quantity = :quantity WHERE good_id = :id";
            break;
         }
      }

      $query2 = $pdores->prepare($sql2);
      $query2->bindParam(':quantity', $quantity);
      $query2->bindParam(':id', $id);
      $query2->execute();
	  }
    //   print_r($query);
   }

   
?>