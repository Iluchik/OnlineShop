<?php
if(isset($_POST["product-name"]) && isset($_POST["product-price"]) ) { 
    // Формируем массив для JSON ответа
    $result = array(
        'name' => $_POST["product-name"],
        'price' => $_POST["product-price"]
    ); 
    // Переводим массив в JSON
    echo json_encode($result); 
}
?>