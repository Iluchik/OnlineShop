<? session_start(); ?>

<!DOCTYPE html>
<html lang="ru">

<head>
   <title><?= "Online shop"; ?></title>
   <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/assets/styles.css">
   <link rel="icon" href="../img/kimono-dress.ico" type="image/x-icon" />
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<header>

</header>
<body>
   <div class="wrapper">
      <div class="container">
         <header class="header-cart">
            <a href="good.php">Online Shop</a>
         </header>
         <main class="main">
            <h1>Корзина</h1>
            <div class='selected-products'>
               <?php
			   echo "<div style='display:none'>";
               require 'configDB.php';
			   echo "</div>";


               $sum = 0;
               if (empty($_SESSION)) {
                  $array_keys = array_keys ($_COOKIE);
                  $count = count($array_keys);
                  for ($i = 1; $i<$count; $i++){
                     $query = $pdo->prepare("SELECT * FROM `goods` WHERE id = :id");
                     $query->bindParam(':id', $array_keys[$i]);
                     $query->execute();
                     if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                           echo "<div class='cart-product'>
                              <img class='cart-image' src=".$row->image.">
                              <span class='cart-name'>".$row->name."</span>
                              <span class='cart-price'>".$_COOKIE[$array_keys[$i]]." * ".$row->price." ₽ = ".$_COOKIE[$array_keys[$i]]*$row->price." ₽ </span>
                              <form id=".$i." method='post' action='add.php' class='cart-delete'>
                                 <input type='hidden' value='".$array_keys[$i]."' name='del'>
                                 <input type='submit' value='Удалить' class='button'>
                              </form>
                           </div>";
                     };
                           $sum = $sum + $_COOKIE[$array_keys[$i]]*$row->price;
                  }
               }
               else {
                  $user_id = $_SESSION['user_id'];
                  $query = $pdo->prepare("SELECT id, name, price, image, quantity FROM goods, users_goods WHERE id IN (SELECT good_id FROM users_goods WHERE user_id = :user_id) AND user_id = :user_id AND good_id = id");
                  $query->bindParam(':user_id', $user_id);
                  $query->execute();
                  while ($row = $query->fetch(PDO::FETCH_OBJ)){
                     echo "<div class='cart-product'>
                        <img class='cart-image' src=".$row->image.">
                        <span class='cart-name'>".$row->name."</span>
                        <span class='cart-price'>".$row->quantity." * ".$row->price." ₽ = ".$row->quantity*$row->price." ₽ </span>
                        <form id=".$row->id." method='post' action='delete.php' class='cart-delete'>
                           <input type='hidden' value='".$row->id."' name='del'>
                           <input type='submit' value='Удалить' class='button'>
                        </form>
                     </div>";
                     $sum = $sum + $row->quantity*$row->price;   
                  }
               }
               
               ?>
            </div>
            <div class='final-price'>
               <span>Итого: <? echo $sum;?> ₽</span>
            </div>
         </main>
		 <script>
			// $("form.cart-delete").on("submit", function() {
				$.ajax({
					url: 'configDB.php',
					method: 'post',
					dataType: 'json',
					success: function(response) {
						if (response.user_log_on) {
							$("form.cart-delete").on("submit", function() {
								$.ajax({
									url: 'delete.php',
									method: 'post',
									dataType: 'html',
									data: $(this).serialize(),
								})
								event.preventDefault();
								const id = $(this)[0].getAttribute("id");
								$("div.cart-product:has(form#" + id + ")").detach();
								let key = -1;
								let summ = 0;
								while (true) {
									key = $("span.cart-price").text().split(" ").indexOf("=", key + 1) + 1;
									if (key <= 0) break;
									summ += Number($("span.cart-price").text().split(" ")[key]);
								}
								$("div.final-price span").text("Итого: " + summ + " ₽");
							});
						} else {
							$("form.cart-delete").on("submit", function() {
								$.ajax({
									url: 'add.php',
									method: 'post',
									dataType: 'html',
									data: $(this).serialize(),
								})
								event.preventDefault();
								const id = $(this)[0].getAttribute("id");
								$("div.cart-product:has(form#" + id + ")").detach();
								let key = -1;
								let summ = 0;
								while (true) {
									key = $("span.cart-price").text().split(" ").indexOf("=", key + 1) + 1;
									if (key <= 0) break;
									summ += Number($("span.cart-price").text().split(" ")[key]);
								}
								$("div.final-price span").text("Итого: " + summ + " ₽");
							});
						}
					}
				})
				// event.preventDefault();
			// })
		 </script>
         <footer class="footer">

         </footer>
      </div>
   </div>
</body>

</html>
