<?php
	session_start();
	if (empty($_SESSION)) {
		$count = count($_COOKIE) - 1;
	} else {
		require "confDBReserv.php";
		$count = 0;
		$user_id = $_SESSION['user_id'];
		$query = $pdores->prepare("SELECT * FROM `users_goods` WHERE user_id = :user_id");
		$query->bindParam(':user_id', $user_id);
		$query->execute();
		while ($row = $query->fetch(PDO::FETCH_OBJ)) {
			$count++;
		}
	}
	$data = array("counter" => $count);
	echo json_encode($data);
?>