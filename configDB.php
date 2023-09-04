<?php
   session_start();
   $dsn = 'mysql:host=localhost;dbname=shop';
   $user = 'root';
   $pass = 'qwerty';
   // $opt = array(
   //    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   //    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
   try
   {
   $pdo = new PDO($dsn, $user);
   }
   catch (PDOException $e)
   {
   die('Подключение не удалось: ' . $e->getMessage());
   }


$sql = "SELECT * FROM `goods`";

try {
    $stmt = $pdo->query($sql);
    $goodData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Ошибка выполнения запроса: ' . $e->getMessage();
    exit;
}

$sql = "SELECT * FROM `users_goods`";

try {
    $stmt = $pdo->query($sql);
    $users_goodsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Ошибка выполнения запроса: ' . $e->getMessage();
    exit;
}

$sql = "SELECT * FROM `users`";

try {
    $stmt = $pdo->query($sql);
    $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Ошибка выполнения запроса: ' . $e->getMessage();
    exit;
}

$data_array = array('goodData' => $goodData, 'usersData' => $usersData, 'users_goodsData' => $users_goodsData, 'user_log_on' => !empty($_SESSION));
//$pdo = null;
// print_r($data_array);
echo json_encode($data_array);
?>